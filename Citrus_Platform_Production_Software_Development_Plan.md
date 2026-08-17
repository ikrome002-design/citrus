# Citrus Platform — Production Software Development Plan

---

## Document Control

| Attribute | Value |
|---|---|
| Document title | Citrus Platform — Production Software Development Plan |
| Product | Citrus Platform (governed, multi-tenant, branch-aware SaaS commerce operating platform) |
| Product owner | Citrus Labs Limited |
| Document type | Software Development Plan (implementation-ready, IDE-agent executable) |
| Version | 1.0 |
| Date | 7 July 2026 |
| Controlling scope authority | `Citrus_Platform_Project_Scope_and_Product_Technical_Specification.md` (v1.0) — hereafter **"the Scope"** |
| Integration authorities | `Wallet_by_Citrus_Platform_Project_Scope.md` (payment orchestration — controlling), `Refer_and_Earn_Project_Scope.md` (referral attribution/rewards — controlling) |
| Integration pattern reference | `Servana Software Development Plan.md` (pattern only; no Servana business rules imported) |
| Technical baseline | `Product Technical Details v.2..txt` |
| Working methodology | `AI Vibe Coding Manifesto.txt` (Prove the Problem → Root Cause → Fix with Precision → Test Thoroughly → Demonstrate Resolution) |
| Currency | KES; all monetary amounts stored as integers in minor units |
| Time | Stored UTC; business dates presented in Africa/Nairobi (EAT) |
| Launch jurisdiction | Kenya (Kenya Data Protection Act applies; legal review gate D-11) |

### Precedence rule for this plan

Where any statement in this plan conflicts with a source document, precedence is: (1) the Scope's Settled Rules SR-1…SR-13; (2) Wallet by Citrus scope for payment orchestration; (3) Refer & Earn scope for referral functions; (4) the Scope's detailed sections; (5) this plan's engineering decisions. Superseded source behaviors (per-transaction service fees, OTP login for merchant staff, direct M-PESA/PesaLink validation of merchant-customer payments, manual merchant creation by Super Administrator, hard deletion after 6 months of non-remittance) **must not be implemented**; the correct replacements are specified throughout this plan.

### How to read this plan

- Sections 1–26 define the target architecture, contracts, and standards. They are the reference material.
- Section 27 is the phased, step-by-step development roadmap. The IDE agent executes phases in order.
- Section 28 defines the mandatory working protocol for the IDE agent, including the Bug Fix Protocol.
- Sections 29–31 define acceptance, risk, and final verification.
- Every requirement in this plan traces to the Scope. Requirement IDs (`REQ-001`…`REQ-048`), settled rules (`SR-1`…`SR-13`), decision-register items (`D-01`…`D-15`), and error codes (e.g. `PLAN_ENTITLEMENT_DENIED`) reference the Scope directly.

---

## 1. Executive Architecture Summary

### 1.1 What is being built

Citrus is a **production-launch-ready** (SR-10), multi-tenant, branch-aware SaaS commerce platform for Kenyan retail and service merchants. One codebase serves an owner-operated single-branch SME and a multi-branch merchant group through progressive configuration (Scope §9). The platform provides:

1. **Merchant tenancy** with absolute data isolation (Scope §10) — one merchant can never access, infer, enumerate, export, alter, or delete another merchant's data.
2. **Branch-aware execution** — sales, stock, staff, expenses, and loyalty events are branch-attributed.
3. **Twelve role-governed account surfaces** — Super Administrator (platform), Merchant Administrator, Merchant Branch, HR, Finance, Cashier (Front Office), Inventory Manager, Personnel, Growth, CX, Audit (read-only), and End User — plus four machine identities for the Wallet and Refer & Earn integrations.
4. **Commerce core** — catalogue (products/services/variants/bundles/modifiers/barcodes), inventory (immutable, reason-coded, concurrency-safe movements), POS with mandatory shift/End-Shift reconciliation, merchant-branded storefronts with branch-locked carts and guest/registered checkout, quotations, returns, and voids-by-corrective-event.
5. **Off-platform payment evidence model** (SR-1/SR-2) — Citrus records and Finance validates *evidence* of merchant-customer payments; Citrus never moves, collects, settles, custodies, or refunds End User-to-Merchant money. No provider SDKs, provider callback routes, or provider credentials exist anywhere in the Citrus codebase (Scope §19.3, §21.4).
6. **Subscription monetization** (SR-3/SR-4) — merchants pay Citrus a recurring subscription collected **exclusively through Wallet by Citrus** via OAuth2 client-credentials API calls and HMAC-signed inbound webhooks. Citrus owns plans, entitlements, invoices, and billing lifecycle; Wallet owns money-movement truth.
7. **Refer & Earn source-product integration** (SR-7/SR-8) — referral-code capture at registration (non-blocking), immutable local snapshot, signed idempotent lifecycle/billing/qualification events via a transactional outbox, and Citrus-owned monthly active-use qualification decisions. Citrus never computes or pays referral rewards.
8. **Loyalty, promotions, staff operations (attendance/leave/KPIs/payroll preparation only), finance records (expenses, cash-up, period locks), CX communications (consent-bound), reporting/exports, notifications, files/imports, and a hash-chained append-only audit trail.**

### 1.2 Architecture in one paragraph

A single Laravel 11 (PHP 8.3) modular monolith with PostgreSQL 16 (single database, shared schema, `merchant_id` tenant discriminator on every tenant-owned table, enforced by a mandatory global scope plus policy-layer ownership checks), Redis 7 for cache/queues/rate-limiting, Laravel Horizon for queue supervision, Meilisearch for tenant-scope-safe search, S3-compatible object storage for private files with signed URLs, and a Vue 3 + TypeScript + Pinia + Vite + Tailwind CSS SPA per account surface (one SPA codebase, role-gated route trees), authenticated via Laravel Sanctum SPA cookie sessions established by passwordless magic links (merchant staff, Super Administrators) and OTP (End Users). Deployment is Dockerized (nginx + php-fpm + queue workers + scheduler containers), delivered through a GitHub Actions CI/CD pipeline with automated tests, migration gating, vulnerability scanning, health checks, centralized structured logging, Sentry error tracking, and Prometheus/Grafana metrics.

### 1.3 Why a modular monolith (evidence-based decision)

- **What must be built:** one deployable application containing well-bounded domain modules (`Identity`, `Tenancy`, `Catalogue`, `Inventory`, `Sales`, `Payments` (evidence), `Loyalty`, `Growth`, `CX`, `Staff`, `FinanceRecords`, `Billing`, `WalletIntegration`, `ReferralIntegration`, `Reporting`, `Notifications`, `Files`, `Audit`, `Platform`).
- **Why:** the Scope's launch capacity targets (500 tenants, 100k sales/day, 2k concurrent users — Scope §36.1) are comfortably within a scaled monolith's envelope; microservices would multiply integration failure modes on a product whose core risk is *consistency* (immutable financial records, stock serialization, billing state machines). Wallet and Refer & Earn are already the externalized services; Citrus itself must be transactionally coherent.
- **Requirement satisfied:** SR-10 (launch-complete), Scope §36 (targets), Product Technical Details §1 (Laravel).
- **Failure if omitted:** premature service decomposition breaks the transactional-outbox guarantee ("an event and its originating domain change commit or fail together", Scope §22.2.7) and multiplies cross-tenant leakage surface.
- **Verification:** module boundary lint (no cross-module model access except through module service interfaces), plus the full test pyramid in Section 25.

### 1.4 Technology stack (binding)

| Layer | Choice | Justification / constraint source |
|---|---|---|
| Backend framework | Laravel 11.x | Product Technical Details §1 |
| Language | PHP 8.3 (≥ 8.2 required) | Product Technical Details §1 |
| SPA/API auth | Laravel Sanctum (SPA cookie mode) | Required stack; Passport NOT used by Citrus itself (Citrus is not an OAuth2 server; it is an OAuth2 *client* of Wallet) |
| Frontend | Vue 3 + TypeScript (strict) + Pinia + Vue Router + Vite | Required stack; component-based; no jQuery |
| Styling | Tailwind CSS 3 with CSS custom-property design tokens | Required stack; token strategy in §12/§14 |
| Database | PostgreSQL 16 | Preferred DB; partial unique indexes, `citext`, row-level constraints used heavily |
| Cache / queues / rate limit / locks | Redis 7 (separate logical DBs) + Laravel Horizon | Required stack |
| Search | Meilisearch 1.x via Laravel Scout (per-tenant filterable indexes) | Required stack; scale fits Meilisearch envelope |
| Object storage | S3-compatible (AWS S3 production; MinIO local dev) | Required stack |
| PDF generation | Headless Chromium (Browsershot) for receipts/invoices/reports | Deterministic layout for statutory-adjacent documents |
| Email | Transactional provider (e.g. Postmark/SES) behind Laravel Mail | Magic links, invitations, receipts, billing notices |
| SMS | Approved Kenyan provider behind a `SmsChannel` contract | End-User OTP + transactional messages (Scope §28.2) |
| Error tracking | Sentry | §22 |
| Metrics | Prometheus exporters + Grafana dashboards | §22 |
| Containerization | Docker + docker compose (dev), hardened images (prod) | §26 |
| CI/CD | GitHub Actions | §26 |
| E2E testing | Playwright | §25 |
| Static analysis | PHPStan (level 8) + Larastan, Pint, ESLint + vue-tsc | §25/§28 |

### 1.5 Top-level system diagram

```text
                                   ┌─────────────────────────────┐
   Safaricom / Banks ────────────► │       Wallet by Citrus       │  (provider callbacks NEVER reach Citrus)
                                   │  money-movement truth        │
                                   └──────┬──────────────▲───────┘
                    ① OAuth2 client-creds │              │ ② HMAC-signed webhooks
                    (register payment,     │              │ (payment.succeeded, …)
                     STK attempt, status)  ▼              │
┌───────────────────────────────────────────────────────────────────────────────┐
│                              CITRUS PLATFORM                                   │
│  Laravel modular monolith · PostgreSQL (merchant_id-scoped) · Redis · S3       │
│                                                                                 │
│  Surfaces (one SPA, role-gated route trees, subdomain-mapped):                  │
│   citrus.citruslabs.limited  → Super Administrator                              │
│   administrator.citrus.ke    → Merchant Administrator                           │
│   branch/cashier/inventory/finance/hr/growth/cx/audit.citrus.ke → staff roles   │
│   citrus.ke                  → End User (storefronts, checkout, account)        │
│                                                                                 │
│  Outbox (re_outbound_events) ──③ X-Citrus HMAC events──►  ┌──────────────────┐ │
│  Inbound signed reconciliation ◄─④ bounded queries──────  │  Refer & Earn    │ │
│                                                            │ referral truth   │ │
└────────────────────────────────────────────────────────── └──────────────────┘ ┘
```

### 1.6 What Citrus explicitly does NOT contain (enforced by tests)

Route-absence and dependency-absence tests (Section 25.9) assert that the Citrus codebase contains **no**: Safaricom/Daraja SDK or credentials; bank/card/PesaLink provider integration; provider callback routes; manual subscription-payment recording endpoint; referral reward calculation; Referrer payout data; cross-merchant marketplace aggregation; tenant merge; jQuery.

---

## 2. Assumptions and Constraints

### 2.1 Assumptions (each with evidence and impact if wrong)

| # | Assumption | Evidence | Impact if wrong | Mitigation |
|---|---|---|---|---|
| A1 | Wallet by Citrus registers Citrus as a product (product code, `{PREFIX}-PAY-` reference prefix, per-environment OAuth2 credentials, webhook secrets) before billing go-live | Scope D-09 (launch gate); Wallet scope application-registry model | Subscription collection cannot go live | Phase 26 has a hard external dependency gate; sandbox credentials requested at Phase 1 |
| A2 | Refer & Earn registers Citrus as a source product (product code, service-account signing keys, campaign/activity-rule registration) | Scope D-10; R&E §11 service-account model | Referral attribution/eventing cannot activate; Citrus launch itself is NOT blocked (registration is non-blocking by design) | Phase 27 gated separately from launch |
| A3 | Plan catalog commercial values (names, prices, trial length, entitlement numbers) are provided by the commercial owner before launch | Scope D-04 | Billing configuration blocked (mechanism is not) | Build the plan mechanism fully; seed with placeholder "PENDING-COMMERCIAL" plans in non-production only |
| A4 | Kenyan legal review resolves DPA registration, retention periods, VAT on subscription invoices, e-receipt obligations | Scope D-06/D-11 | Compliance exposure | Retention values configurable, not hardcoded; VAT line-item support built in |
| A5 | KYC/registry verification provider is available for National ID / Business Registration Number checks | Scope §14.1 | Onboarding falls back to manual review queue | Provider behind a `KycVerifier` contract with `manual_review` fallback path |
| A6 | Proposed performance targets (Scope §36) are approved | Scope D-13 | Infrastructure sizing changes | Targets are config-driven alert thresholds |
| A7 | Email + SMS providers are contracted with sender IDs approved for Kenya | Scope §28.2 | OTP/magic-link delivery blocked | Providers behind contracts; dev uses Mailpit + log SMS driver |
| A8 | Single currency (KES) and single tenant timezone default (Africa/Nairobi) at launch | Scope §1, §39.7 | Multi-currency rework | Currency stored per record (ISO code + minor units); formatting centralized |

### 2.2 Hard constraints (non-negotiable, from the Scope's settled rules)

1. **SR-1/SR-2:** No End User-to-Merchant payment processing. Merchant-customer payments are recorded/validated as *evidence* only.
2. **SR-3/SR-5:** The only money movement Citrus initiates is Merchant-to-Citrus subscription payment through Wallet by Citrus.
3. **SR-4:** Launch monetization is subscription-based. No per-transaction service fees, no weekly auto-invoices tied to sales volume, no customer-price uplift, no deletion after 6 months (archival per D-03 instead).
4. **SR-6:** Citrus owns plans, entitlements, invoices, billing lifecycle, and access-restriction decisions.
5. **SR-7/SR-8:** Refer & Earn owns rewards/payouts; Citrus owns merchant facts and the active-use qualification decision.
6. **SR-9:** Merchant Branch Account is mandatory: branch = business unit; Merchant Branch role = named human(s).
7. **SR-11/SR-12:** Merchant users authenticate by single-use magic link (no merchant passwords exist at launch); every actor is a named individual or registered machine identity.
8. **SR-10:** Launch-complete: no workflow may depend on database edits, fabricated payment states, or undocumented tools.
9. **PR-9:** A subscription payment resolves billing restrictions only; it never clears fraud/security/legal/compliance/manual-risk suspensions.
10. Responsive behavior via CSS media queries on viewport width only (Desktop ≥ 1025px, Tablet 768–1024px, Mobile ≤ 767px); no JS layout-mode switching; no device detection; browser zoom never disabled.
11. Light mode default; dark mode togglable and persisted per user; WCAG 2.2 AA targeted.
12. No jQuery anywhere. Frontend checks are never security controls.

### 2.3 Engineering constraints adopted by this plan

| Constraint | Rule |
|---|---|
| Identifiers | Every externally visible record uses a ULID public ID (26-char, prefix-typed where useful, e.g. `mrc_…`, `ord_…`). Internal `bigint` PKs never leave the backend. Route model binding resolves by `public_id` only. |
| Money | `bigint` minor units + `char(3)` ISO currency on every monetary column pair. No floats. A single `Money` value object handles arithmetic/formatting. |
| Time | `timestamptz` UTC in DB. Business-date computation via a single `BusinessDate` service pinned to tenant timezone. |
| Immutability | Append-only tables get a PostgreSQL trigger (`RAISE EXCEPTION` on UPDATE/DELETE of protected columns) *in addition to* application guards. Defense in depth. |
| Mass assignment | Every model declares `$fillable` explicitly (never `$guarded = []`). Enforced by PHPStan rule + code review checklist. |
| Validation | Every mutating endpoint uses a dedicated FormRequest class. No inline `$request->validate()` for multi-field writes. |
| Transactions | Every multi-step write runs inside `DB::transaction()` with explicit lock acquisition where specified (stock, invoice application, shift closure). |
| Feature flags | Plan entitlements and merchant capability toggles evaluated through one `Entitlements` service; never scattered `if` checks. |
| Secrets | Only via environment variables/secrets manager. `.env.example` lists names, never values. CI secret-scanning gate. |

---

## 3. Non-Negotiable Security Rules

These rules bind every phase, every file, every review. The IDE agent must re-verify this list at the end of every phase (Section 28.4).

1. **Default deny.** No capability exists for a user unless an active membership, role, scope, and permission grant it (Scope PR-1). Absence of a grant is denial. Every new route ships with a policy/permission check or an explicit, reviewed `public` designation.
2. **Server-enforced authorization on every request, form submission, background job, export, download, and integration action.** Frontend visibility is UX only (PR-2). Any PR that gates behavior only in the SPA is rejected.
3. **Tenant isolation is absolute** (PR-3). Every tenant-owned query is merchant-scoped by the mandatory global scope; every policy re-verifies ownership; public IDs are non-sequential ULIDs; unauthorized resources return 404-style non-disclosure (`BRANCH_ACCESS_DENIED` semantics); counts, search, exports, notifications, and error messages never leak foreign-tenant existence.
4. **Branch isolation within a tenant.** Branch-scoped roles see only assigned-branch data; enforced in policies and query scopes, not UI.
5. **No merchant passwords.** Magic links: cryptographically random ≥ 256-bit tokens, stored hashed (SHA-256), TTL ≤ 10 minutes, single-use, audience/tenant/context-bound, replay-detected (`AUTH_LINK_REPLAYED` + session termination on cross-device replay + security event). End-User OTP: ≤ 5 minutes, single-use, rate-limited, lockout on abuse.
6. **Session security.** Sanctum SPA cookies: `Secure`, `HttpOnly`, `SameSite=Lax`; session ID regenerated at authentication; idle/max timeouts per role (Scope §13.5); permission-version stamped and re-validated per request; revocation propagates ≤ 60 seconds.
7. **Step-up re-authentication** for every action marked "S" in the Scope §12.2 matrix (plan changes, branch suspension, period reopen, exports, merchant suspension, etc.), enforced server-side with a short-lived elevated-session claim.
8. **Maker-checker** enforced server-side for the Scope §12.4 matrix (payment-evidence validation recorder≠validator, refund approval, sensitive stock adjustments, period reopen, manual loyalty adjustment, promotion guard breaches, platform merchant suspension). Single-operator SME fallback = step-up + mandatory reason + elevated audit severity, except D-07 actions which are never single-operator.
9. **No secrets in code, logs, frontend bundles, or error responses.** Never log passwords (none exist for merchants), magic-link tokens, OTPs, API keys, webhook secrets, payment references (mask them), or PII beyond need. Log scrubber middleware + Sentry `before_send` filter enforced.
10. **All input validated; all output escaped.** Eloquent parameter binding only (no raw SQL string interpolation); Vue's default escaping everywhere; `v-html` forbidden except through one `SafeHtml` component wrapping an allowlist sanitizer; CSRF tokens on all browser flows; strict CORS (SPA origins only); `X-Frame-Options: DENY`, CSP with nonced scripts, HSTS in production.
11. **Uploads:** allowlisted MIME + extension + magic-bytes verification, size caps (images ≤ 10 MB, documents ≤ 25 MB), malware scan before availability, private-by-default storage outside web root, signed time-limited URLs with permission re-check at issuance.
12. **Integration security:** OAuth2 client-credentials to Wallet (TTL ≤ 60 min, no refresh tokens, per-environment credentials, production boot guard rejects non-production key IDs); inbound Wallet webhooks and inbound R&E reconciliation calls verified in strict order — transport checks → key resolution → timestamp ±300s → nonce/event-ID replay check → content-SHA-256 → constant-time HMAC — before any payload field is trusted.
13. **Idempotency** on every money-adjacent and event-producing operation: `Idempotency-Key` stored with request hash; same key + different payload → 409 conflict; same key + same payload → replay original result.
14. **Rate limiting** on every public and authenticated endpoint (per-user, per-tenant, per-IP), with strict tiers on login-link issuance, OTP issuance, registration, invitation acceptance, coupon redemption, and export generation. `RATE_LIMITED` (429) with `Retry-After`.
15. **Audit everything material.** Append-only, hash-chained audit events with actor, acting role context, merchant, branch, action, target, timestamp, IP, user agent, correlation ID, reason, before/after where safe. Audit records are never editable or deletable by anyone, including Super Administrators.
16. **HTTPS everywhere in production**; TLS certificate verification never disabled; unsafe redirects blocked by an allowlist.
17. **Dependency hygiene:** `composer audit` + `npm audit` + Dependabot + Trivy image scanning in CI; critical vulnerabilities block deployment.
18. **Environment separation:** sandbox/staging/production credentials and data disjoint; production boot verification refuses non-production integration credentials.

---

## 4. System Architecture

### 4.1 Deployment topology

```text
┌──────────────────────── Production VPC ────────────────────────────┐
│                                                                     │
│  ┌─────────┐   ┌──────────────────────────────┐   ┌─────────────┐  │
│  │  CDN /  │──►│  Load balancer (TLS term.,   │──►│ app (nginx  │  │
│  │  WAF    │   │  HSTS, request-ID injection) │   │ + php-fpm)  │  │
│  └─────────┘   └──────────────────────────────┘   │  N replicas │  │
│                                                    └──────┬──────┘  │
│   ┌──────────────┐  ┌──────────────┐  ┌───────────┐      │         │
│   │ queue workers │  │  scheduler   │  │ Horizon   │◄─────┤         │
│   │ (Horizon, per │  │ (1 replica,  │  │ dashboard │      │         │
│   │  queue tier)  │  │  cron lock)  │  │ (ops only)│      │         │
│   └──────┬───────┘  └──────┬───────┘  └───────────┘      │         │
│          ▼                 ▼                              ▼         │
│   ┌────────────┐   ┌────────────┐   ┌────────────┐  ┌────────────┐ │
│   │ PostgreSQL │   │  Redis     │   │ Meilisearch│  │  S3 bucket │ │
│   │ 16 primary │   │ (cache/    │   │ (search)   │  │ (private + │ │
│   │ + replica  │   │ queue/lock)│   │            │  │  public)   │ │
│   └────────────┘   └────────────┘   └────────────┘  └────────────┘ │
│                                                                     │
│   Sentry ◄── errors     Prometheus ◄── metrics     Log shipper ──► │
│                                                     centralized logs│
└─────────────────────────────────────────────────────────────────────┘
External: Wallet by Citrus API + webhooks · Refer & Earn API + reconciliation
          Email provider · SMS provider · KYC provider · Malware-scan service
```

### 4.2 Domain and surface routing

The Scope maps role surfaces to subdomains (Scope §11, Overview). One SPA build serves all merchant-staff surfaces; the host determines the *surface context* (branding, default route tree, and allowed audience for magic links); authorization is always server-side and identical regardless of host.

| Host | Surface | Audience |
|---|---|---|
| `citrus.citruslabs.limited` | Super Administrator portal | `platform_staff` |
| `administrator.citrus.ke` | Merchant Administrator | `merchant_staff` |
| `branch.citrus.ke`, `cashier.citrus.ke`, `inventory.citrus.ke`, `finance.citrus.ke`, `hr.citrus.ke`, `growth.citrus.ke`, `cx.citrus.ke`, `audit.citrus.ke` | Role-focused merchant staff surfaces | `merchant_staff` |
| `citrus.ke` | End-User surface: landing, Find Merchants, `citrus.ke/{merchant-slug}` storefronts, account | `end_user` |
| `api.citrus.ke` (or same-host `/api`) | Versioned REST API `/api/v1` | all (Sanctum) + machine channels |

Implementation: a `ResolveSurface` middleware maps `Host` → `surface` attribute on the request; magic-link tokens embed the audience and are rejected on the wrong surface (`AUTH_LINK_*` errors, Scope §13.1.3). DNS/TLS covers all subdomains (wildcard cert `*.citrus.ke` + apex + `citrus.citruslabs.limited`).

**SME note:** a multi-role human uses one login and one workspace with role-context switching (Scope §9.3); the role subdomains are *presentation defaults*, not separate credential realms. All surfaces accept any authenticated merchant-staff session and render the role context the user selects; acting-role context is recorded on every audited action.

### 4.3 Module map (backend)

```text
app/
├── Domain/
│   ├── Identity/          # users, magic links, OTP, sessions, devices, step-up
│   ├── Tenancy/           # merchants, branches, memberships, roles, permissions, invitations, context
│   ├── Catalogue/         # products, services, variants, bundles, modifiers, categories, prices, barcodes
│   ├── Inventory/         # stock locations, movements, reservations, counts, suppliers, alerts
│   ├── Sales/             # POS sales, orders, quotes, carts, shifts, receipts, returns/voids
│   ├── PaymentsEvidence/  # off-platform payment evidence records, validation, refund/dispute records
│   ├── Customers/         # merchant customer relationships, consent, merges
│   ├── Loyalty/           # loyalty accounts, append-only ledger, rules, tiers, adjustments
│   ├── Growth/            # promotions, coupons, leads, quotations config, commissions, segments
│   ├── CX/                # inbox, cases, campaigns (non-transactional), journeys, feedback
│   ├── Staff/             # profiles, attendance, shifts (work), leave, KPIs, payroll preparation, recertification
│   ├── FinanceRecords/    # merchant invoices (to customers), expenses, cash-up review, period locks
│   ├── Billing/           # plans, entitlements, subscriptions, subscription invoices, billing state machine
│   ├── WalletIntegration/ # wallet client, payment registration, attempts, webhook inbox, reconciliation
│   ├── ReferralIntegration/# referral snapshots, outbox, qualification engine, reconciliation endpoint
│   ├── Reporting/         # report definitions, generation, exports, scheduled reports
│   ├── Notifications/     # catalogue, channels, templates, preferences, delivery log
│   ├── Files/             # uploads, scanning, signed URLs, imports, retention, orphan GC
│   ├── Audit/             # append-only hash-chained audit events, audit surfaces
│   └── Platform/          # super-admin governance, plan catalog admin, platform config, integration health
├── Http/
│   ├── Controllers/Api/V1/{Platform,Merchant,Storefront,Machine}/
│   ├── Middleware/
│   ├── Requests/          # FormRequest classes per endpoint
│   └── Resources/         # JsonResource classes per aggregate
├── Jobs/  ·  Events/  ·  Listeners/  ·  Policies/  ·  Rules/  ·  Support/
```

Module boundary rule: a module's Eloquent models are internal; other modules call its `*Service` or dispatch its domain events. Cross-module reads for reporting go through read-model query classes in `Reporting`. This is enforced by a `deptrac`-style layer config in CI.

### 4.4 Wallet by Citrus integration architecture (payment orchestration — Wallet scope controls)

Citrus implements exactly the Servana-proven pattern (Scope S16 reference; Wallet scope S12/S13 controlling), with Citrus-specific naming:

**Machine identities (4, per environment, disjoint secrets in the secrets manager):**

| Identity | Direction | Mechanism | Secret path |
|---|---|---|---|
| Citrus product application @ Wallet | Citrus → Wallet | Wallet-issued OAuth2 client-credentials; scopes `payments:write`, `payments:read`, `merchant_accounts:write`; bearer token TTL ≤ 60 min; no refresh tokens; optional IP allowlist | `citrus/{env}/wallet/api_credentials` |
| Wallet webhook sender | Wallet → Citrus | HMAC-SHA256, canonical string `METHOD\nPATH\nTIMESTAMP\nNONCE\nCONTENT_SHA256\nEVENT_ID\nEVENT_TYPE\nEVENT_VERSION`; headers `X-Wallet-Key-Id`, `X-Wallet-Timestamp`, `X-Wallet-Nonce`, `X-Wallet-Event-Id` (stable across retries), `X-Wallet-Event-Type`, `X-Wallet-Event-Version`, `X-Wallet-Content-Sha256`, `X-Wallet-Signature`; dual-key rotation | `citrus/{env}/wallet/webhook_secret_{key_id}` |
| Citrus service account @ Refer & Earn | Citrus → R&E | `X-Citrus-*` header contract (below) | `citrus/{env}/refer-earn/signing_key_{key_id}` |
| R&E reconciliation caller | R&E → Citrus | Same canonical HMAC construction, distinct inbound secret; nonce replay store | `citrus/{env}/refer-earn/inbound_secret_{key_id}` |

**Outbound calls Citrus makes to Wallet (collections slice only — Citrus does not call refunds/payouts/beneficiaries at launch):**

| Operation | Wallet route | Idempotency-Key | Trigger |
|---|---|---|---|
| Register subscription payment | `POST /api/v1/payments` | `ctr:pay-reg:{invoice_ulid}` | Subscription invoice issuance (with retry on failure) |
| Initiate STK attempt | `POST /api/v1/payments/{p}/attempts/stk` | `ctr:stk:{attempt_ulid}` | Merchant clicks "Pay with M-PESA" on billing page |
| Query payment status | `GET /api/v1/payments/{p}` | n/a (safe read) | Stale-attempt job; nightly reconciliation |
| List attempts | `GET /api/v1/payments/{p}/attempts` | n/a | Billing detail page; reconciliation |
| Sync merchant billing account | `PUT /api/v1/merchant-accounts/{external_ref}` | `ctr:ma:{merchant_ulid}` | Merchant activation; identity change |

Registration payload: `external_reference` = Citrus subscription-invoice ULID; `expected_amount_minor` = current invoice balance; `currency` = `KES`; response carries `payment_id`, structured reference `{PREFIX}-PAY-<ULID>` (prefix assigned by Wallet registry, D-09), and PayBill/Till instructions Citrus displays verbatim. Duplicate registration returns the existing resource (409 `DUPLICATE_EXTERNAL_REFERENCE` handled as success-with-pointer). The invoice is **never re-registered on partial payment** (Scope §21.2.2).

**Inbound webhook processing (Wallet → Citrus):**

1. `POST /api/v1/integrations/wallet/webhooks` (route class `partner_webhook_mutation`; no Sanctum; body limit 64 KB).
2. Verification in strict order: HTTPS/content-type/size → key-ID resolution (no key-inventory disclosure) → timestamp ±300 s → nonce + event-ID replay check against durable store → content-SHA-256 match → constant-time HMAC. Failure → uniform 401 (413 oversize), high-severity security audit event, encrypted forensic row `processing_status='rejected'`.
3. Durable insert into `wallet_webhook_inbox` (unique `wallet_event_id`), then **fast 200 acknowledgment** (target p95 < 250 ms; no domain work pre-ack).
4. `ProcessWalletWebhookJob` (queue `integrations`) resolves payment → invoice, applies funds **under invoice row lock** keyed on the first-seen confirming event ID: amount < balance → `partially_paid`; = balance → `paid`; > balance → `paid` + `merchant_billing_credits` row. The same Wallet payment applied to a second invoice → `WALLET_PAYMENT_REUSED` critical exception, posting blocked.
5. Duplicate `wallet_event_id` → 200 ack, marked `duplicate`, zero domain effect. Out-of-order events never regress terminal states (snapshot-only record for stale non-terminal events).
6. On `paid`: billing state machine evaluates recovery (billing-only, PR-9), sessions re-validated, R&E `subscription_invoice_fully_paid` outbox event queued when clearing rule satisfied (§4.5).

Wallet payment-projection states mirrored 1:1 (never invented): `CREATED, PENDING_CUSTOMER_ACTION, SUBMITTED, PROCESSING, SUCCEEDED, PARTIALLY_RECEIVED, OVERPAID, FAILED, EXPIRED, CANCELLED, UNKNOWN, REVERSED, REFUNDED`. Timeout/ambiguity = `UNKNOWN`, never failure; **no blind retry** while an attempt is unresolved; status-query recovery resolves it (Scope §21.2.7).

**Reconciliation jobs:** `QueryStaleWalletAttemptsJob` (every 10 min, attempts in non-terminal state > 5 min); `NightlyWalletAllocationReconciliationJob` (compares Citrus allocations vs Wallet `received_amount_minor` for invoices active in last 45 days; drift → `allocation_drift` exception for Super Administrator resolution **by linkage only** — no manual payment recording route exists for anyone).

### 4.5 Refer & Earn integration architecture (referral truth — R&E scope controls)

**Registration-time capture (non-blocking, Scope §22.2):** optional referral-code field, prefilled from signed link, replaceable until submission, immutable after tenant creation (attribution lock event). Validation via `POST /api/v1/integrations/products/{productCode}/referral-codes/validate` or, on outage, against the cached signed campaign snapshot (`GET .../campaign-snapshots/{product}`); invalid format → registration continues without attribution (`REFERRAL_CODE_INVALID`); product mismatch → `REFERRAL_CODE_PRODUCT_MISMATCH`; outage → snapshot stored, status `pending_central_confirmation`, non-blocking notice, `ConfirmAttributionJob` retries.

**Local storage — exactly the 9 minimum fields** (R&E data-minimization override): `referral_attribution_id`, `referral_code_snapshot`, `referrer_reference` (opaque), `referral_campaign_id`, `referral_campaign_version`, `attributed_at`, `attribution_status`, `central_confirmation_status`, `merchant_product_tenant_id`. Citrus never stores Referrer identities, reward amounts, payout methods, or fraud evidence.

**Event emission — transactional outbox:** `re_outbound_events` rows are inserted **in the same DB transaction** as the originating domain change (append-only payload enforced by trigger; `event_id` ULID stable across retries; per-merchant `sequence_no`; `content_sha256` over canonical JSON). `DeliverReOutboxJob` posts to `POST /api/v1/integrations/products/{productCode}/events` with headers `X-Citrus-Key-Id`, `X-Citrus-Event-Id`, `X-Citrus-Event-Type`, `X-Citrus-Event-Version`, `X-Citrus-Timestamp`, `X-Citrus-Nonce`, `X-Citrus-Content-SHA256`, `X-Citrus-Signature`, `Idempotency-Key: {event_id}`; canonical signing input `HTTP_METHOD\nNORMALIZED_PATH\nTIMESTAMP\nNONCE\nCONTENT_SHA256\nEVENT_ID\nEVENT_TYPE\nEVENT_VERSION`.

**Retry policy:** `202` → delivered; `409 EVENT_ID_PAYLOAD_MISMATCH` → **stop retries, dead-letter, critical incident** (payloads are never mutated and resent); `401/403` → pause queue + alert; `422` schema → dead-letter + contract-drift alert; `429/5xx/timeout` → exponential backoff (base 30 s, cap 1 h, max age 7 days → dead-letter with alert threshold). Controlled replay preserves original `event_id` and `occurred_at`.

**Event catalogue emitted (Scope §22.3 business names; transport naming aligned with the central schema registry at integration kickoff):** registration lifecycle (`merchant_registration_started`, `merchant_registered`, `merchant_email_verified`, `merchant_setup_completed`); subscription lifecycle (`merchant_subscription_selected`, `subscription_invoice_issued`, `subscription_payment_partially_paid`, `subscription_invoice_fully_paid`, `subscription_payment_reversed`, `subscription_refunded`, `subscription_chargeback_recorded`, `merchant_plan_changed`, `merchant_billing_suspended`); operational evidence (`eligible_operational_activity_completed`, `merchant_branch_created` — traceability only, never qualifies alone); qualification (`merchant_activity_qualification_decided` + corrections via higher `decision_version`); tenant lifecycle (`merchant_reactivated`, `merchant_deactivated`, tenant closed, `merchant_identity_updated`, `merchant_duplicate_detected`). **No tenant-merge events** (Citrus has no merge). `subscription_*`/`activity_*` events are emitted **only for attributed merchants**; payloads never include customers, staff lists, transaction references, MSISDNs, detailed revenue, or free text.

**Payment-cleared gate:** `subscription_invoice_fully_paid` is emitted only when the payment is applied, no open allocation exception exists for the `wallet_payment_id`, and the clearing rule holds (Wallet settlement projection `SETTLED`, or nightly reconciliation matched + `clearing_grace_days` [default 5, config] elapsed).

**Citrus active-use qualification (Citrus-owned, Scope §22.4):** monthly scheduler evaluates, per attributed merchant, per Africa/Nairobi calendar month after close + clearing grace: `≥ N completed sales AND ≥ M Finance-validated payment-evidence records AND subscription invoice for the period fully paid and cleared AND no disqualifying operational suspension AND attribution confirmed` (N, M from D-10 config; rule ID/version registered centrally; versions apply to future periods only). Deterministic failure categories evaluated in fixed order: `insufficient_sales → insufficient_validated_payments → subscription_not_fully_paid → payment_not_cleared → disqualifying_suspension → attribution_not_confirmed`. Decisions are append-only with evidence checksums; late clearing/reversal/retroactive suspension produces a corrected decision with `decision_version + 1` and a `supersedes_event_id` — prior decisions never deleted.

**Inbound reconciliation endpoint:** `POST /api/v1/integrations/refer-earn/reconciliation/query` accepts exactly four bounded query classes (`event_by_id`, `events_by_merchant_period`, `qualification_decision`, `subscription_payment_summary`); anything else → 422. HMAC-verified with the inbound secret; nonces stored in `re_inbound_requests` (unique; replay → 409; 90-day retention). Responses contain minimal facts + evidence checksums; unattributed merchants return empty scoped results.

**Gap detection:** `ReconcileReEventGapsJob` (hourly) uses product-scoped cursors against the R&E reconciliation API to backfill events skipped when attribution confirmed late — original event IDs and timestamps preserved, never fabricated.

### 4.6 Outage behavior (mandated degradation)

| Dependency down | Citrus behavior |
|---|---|
| Wallet | Payment initiation returns retryable `WALLET_UNAVAILABLE` (503); payment lock released; invoices remain visible/payable; registration retries with backoff; status-query reconciliation catches up; grace-period escalation **pauses** during verified platform-side payment unavailability (fairness rule, Scope §39.5); all non-payment operations unaffected. Citrus core commerce never fails because Wallet is down. |
| Refer & Earn | Registration and commerce continue; snapshot validated against cached signed campaign snapshot; events queue durably; reconciliation backfills. Citrus core commerce never fails because R&E is down. |
| Email provider | Magic-link issuance degrades to provider failover (where configured) or queued retry with user-visible "link is on its way" messaging; security alerts to ops on sustained failure. |
| SMS provider | End-User OTP falls back to email OTP where the user has a verified email; otherwise graceful failure with retry guidance. |
| Meilisearch | Search endpoints return a `SEARCH_UNAVAILABLE` degraded response; list endpoints (DB-backed) unaffected. |
| Redis | Fatal for queues/sessions → health check fails → load balancer removes node; hard dependency by design (documented). |
| KYC provider | Registration proceeds to `manual_review` onboarding path; identity fields remain unlocked until verified. |

---

## 5. Backend Architecture

### 5.1 Directory layout (concrete)

```text
citrus/
├── app/
│   ├── Console/Commands/                  # citrus:* operational commands
│   ├── Domain/<Module>/                   # per §4.3: Models/, Services/, Actions/, Events/, Enums/, DTOs/
│   ├── Exceptions/                        # DomainException tree + Handler mapping to error catalogue
│   ├── Http/
│   │   ├── Controllers/Api/V1/
│   │   │   ├── Platform/                  # Super Administrator endpoints
│   │   │   ├── Merchant/                  # merchant-staff endpoints (all roles)
│   │   │   ├── Storefront/                # End-User endpoints
│   │   │   ├── Auth/                      # magic link, OTP, session, context
│   │   │   └── Machine/                   # Wallet webhooks, R&E reconciliation (signed, no Sanctum)
│   │   ├── Middleware/                    # see §5.3
│   │   ├── Requests/<Module>/             # FormRequests
│   │   └── Resources/<Module>/            # JsonResources
│   ├── Jobs/<Module>/
│   ├── Policies/                          # one policy per aggregate
│   ├── Providers/                         # AppServiceProvider, AuthServiceProvider, ModuleServiceProvider…
│   └── Support/                           # Money, BusinessDate, Ulid, MaskedValue, CanonicalJson, HmacSigner…
├── config/                                # citrus.php, entitlements.php, integrations.php, retention.php…
├── database/
│   ├── migrations/                        # timestamped; never edited after merge to main
│   ├── seeders/                           # PermissionSeeder, PlanSeeder (non-prod), DemoMerchantSeeder (non-prod)
│   └── factories/
├── routes/
│   ├── api_v1_platform.php  · api_v1_merchant.php · api_v1_storefront.php
│   ├── api_v1_auth.php      · api_v1_machine.php  · web.php (SPA shell + signed downloads)
├── resources/js/                          # Vue SPA (see §6)
├── tests/{Unit,Feature,Integration,Browser}/
├── docker/                                # Dockerfiles, nginx conf, entrypoints
├── docs/{adr,runbooks,api}/               # ADRs, rotation runbooks, OpenAPI spec
└── .github/workflows/                     # ci.yml, deploy.yml, security.yml
```

### 5.2 Layering rules

1. **Controller** — thin: resolve FormRequest, authorize via policy, call an Action/Service, return a Resource. No business logic, no queries.
2. **Action** (single-purpose command class, e.g. `CompletePosSale`, `ValidatePaymentEvidence`, `ApplyWalletPayment`) — owns the transaction boundary, invariant checks, state-machine transition, audit emission, outbox insertion, and domain-event dispatch. One public `execute()` method.
3. **Service** — cross-action orchestration and integration clients (`WalletClient`, `ReferralClient`, `EntitlementsService`, `QualificationEngine`).
4. **Model** — persistence + relationships + casts + scopes. No workflow logic.
5. **Policy** — all authorization decisions (permission + tenant ownership + branch scope + entitlement precondition where cheap).
6. **Job** — queued wrapper that re-resolves tenant context (§8.4) and calls an Action.

### 5.3 Middleware stack (named, ordered)

| Alias | Purpose |
|---|---|
| `surface` | Resolve `Host` → surface context (§4.2) |
| `correlation` | Accept/generate `X-Correlation-Id`; bind to logs and response |
| `auth:sanctum` | Session authentication |
| `verified.membership` | The 8-point active-membership check (Scope §13.2): identity exists → email verified → tenant active-or-recovery-allowlisted → membership active (incl. working-hours/period-of-access windows) → role active → branch scope active → not suspended/offboarded since issuance → permission version current. Runs on every merchant-staff request; failures map to `MEMBERSHIP_INACTIVE`, `MERCHANT_SUSPENDED`, `BILLING_RESTRICTED`, etc. |
| `context.tenant` | Bind selected merchant context (session-stored) into the `TenantContext` container singleton |
| `context.branch` | Bind selected branch scope where the route requires it |
| `entitlement:{key}` | Plan-entitlement gate after authorization (`PLAN_ENTITLEMENT_DENIED`) |
| `step-up` | Requires a fresh elevated-auth claim (≤ 10 min old) for "S"-marked actions |
| `throttle:{tier}` | Named rate-limit tiers (§11.8) |
| `idempotency` | `Idempotency-Key` enforcement on financial/mutating commerce endpoints |
| `signed.wallet` / `signed.re` | Machine-channel HMAC verification pipelines (§4.4/§4.5) |
| `recovery.allowlist` | While billing-restricted/suspended: allow only billing pages, invoice view, Wallet payment initiation, own-tenant export (Administrator, step-up), support contact, read-only history; everything else → `BILLING_RESTRICTED` |
| `audit.context` | Stamp acting role context for audit emission |

### 5.4 Error handling architecture

- One `DomainException` hierarchy: `AuthLinkExpired`, `MembershipInactive`, `PlanEntitlementDenied`, `InsufficientStock`, `StockConflict`, `InvalidStateTransition`, `PaymentReferenceDuplicate`, `WalletUnavailable`, `ExportTooLarge`, … each carrying the Scope §38 machine code, HTTP status, retryability, and audit severity.
- The exception handler renders the structured error envelope (§11.6), logs internally with full diagnostics + correlation ID, and **never** exposes stack traces, provider errors, SQL, or foreign-tenant identifiers to users.
- Unexpected exceptions → generic 500 envelope + Sentry with correlation ID; the correlation ID is shown to the user for support ("Something went wrong. Reference: `corr_…`").
- Validation failures → 422 with per-field errors mapped to FormRequest attribute names; user input always preserved client-side.

### 5.5 State machine enforcement

Every aggregate with a Scope §32 state machine (merchant onboarding/operational/billing, branch, membership, invitation, product, order, sale, merchant invoice, evidence record, refund record, loyalty adjustment, subscription, subscription invoice, wallet payment projection, referral snapshot, R&E delivery, support case, shift session) gets:

1. A PHP backed enum for states.
2. A `transitions()` map (state → allowed next states + required permission + preconditions + side effects list).
3. A single `TransitionAggregate` trait method that validates trigger → actor → preconditions → applies atomically → records side effects → emits the audit event → dispatches domain events. Invalid transitions throw `InvalidStateTransition` (409) with **no partial effects** (transaction rollback).
4. A generated transition test asserting every undefined transition is rejected (§25.4).

### 5.6 Concurrency controls (mandatory implementations)

| Concern | Mechanism |
|---|---|
| Stock deduction/adjustment on same SKU+location | `SELECT … FOR UPDATE` on the `stock_levels` row inside the movement transaction; two concurrent sales cannot both consume the last unit; policy `prohibit` (default) → `INSUFFICIENT_STOCK`; `allow_with_flag` → proceed + negative-stock exception (Scope §17.5) |
| Cart/checkout reservation | `stock_reservations` rows with TTL; `ReleaseExpiredReservationsJob` every minute; checkout converts reservation → commitment → sale deduction |
| Concurrent conflicting stock edits | Version column check → `STOCK_CONFLICT` (409), client retries with fresh state; never silent overwrite |
| Invoice payment application | Invoice row lock + unique `confirming_wallet_event_id` |
| Duplicate sale submission | `idempotency` middleware → replay original result (`SALE_DUPLICATE_SUBMISSION` semantics) |
| Shift closure | Shift row lock; closure gates (no open orders, no unverified/unescalated evidence, no held carts, no pending-ready online orders) evaluated inside the lock |
| Evidence validation race | Evidence row lock; concurrent update → `PAYMENT_VALIDATION_CONFLICT` (409) |
| Scheduler singletons | `Schedule::…->onOneServer()->withoutOverlapping()` + Redis locks |

---

## 6. Frontend Architecture

### 6.1 Application structure (Vue 3 + TypeScript, one workspace)

```text
resources/js/
├── app.ts                       # bootstrap, theme init (pre-mount), Sentry, router
├── api/
│   ├── client.ts                # single Axios instance: baseURL /api/v1, CSRF, correlation ID,
│   │                            #   401→session-expired flow, 403/404 non-disclosure handling,
│   │                            #   429 retry-after surfacing, error-envelope normalization
│   └── modules/<module>.ts      # typed endpoint wrappers (generated from OpenAPI where possible)
├── stores/                      # Pinia: auth, context (tenant/branch/role), entitlements, theme,
│   │                            #   notifications, pos (offline drafts), forms-dirty registry
├── router/
│   ├── index.ts                 # route tree per surface; guards: requiresAuth, requiresContext,
│   │                            #   requiresPermission (UX only), requiresEntitlement (UX only)
│   └── routes/{platform,merchant,storefront}.ts
├── layouts/
│   ├── AuthLayout.vue           # magic-link / OTP screens
│   ├── AppShell.vue             # sidebar + header + content + toasts (merchant + platform)
│   ├── PosLayout.vue            # touch-first full-screen POS shell
│   └── StorefrontLayout.vue     # End-User shell (header, merchant branding, cart)
├── components/
│   ├── ui/                      # design system: CButton, CInput, CSelect, CTable, CModal, CDrawer,
│   │                            #   CToast, CCard, CBadge, CEmptyState, CSkeleton, CTabs, CPagination,
│   │                            #   CFormField, CConfirmDialog, CStepUpDialog, CFileUpload, CDatePicker
│   ├── layout/                  # SidebarNav, HeaderBar, ProfileUnit, ContextSwitcher, ThemeToggle,
│   │                            #   NotificationBell, BreadcrumbBar
│   └── domain/<module>/         # feature components (ProductForm, StockMovementList, PosCart, …)
├── pages/
│   ├── platform/                # Super Administrator pages
│   ├── merchant/<role-area>/    # dashboard, catalogue, inventory, pos, orders, payments, customers,
│   │                            #   loyalty, growth, cx, staff, finance, billing, reports, audit, settings
│   └── storefront/              # landing, find-merchants, shop, cart, checkout, orders, account
├── composables/                 # useApi, usePermissions, useEntitlements, usePagination, useForm,
│   │                            #   useConfirm, useStepUp, useTheme, useIdleTimeout, useLiveRegion
├── types/                       # generated API types + domain types
└── styles/                      # tokens.css (custom properties), tailwind.css
```

### 6.2 Authentication and context state

- `auth` store holds: user identity, verified flags, session expiry hints, elevated-auth (step-up) expiry.
- `context` store holds: available memberships (tenant × role × branch), the **selected context** (bound server-side to the session; the SPA mirror is display-only), and the context-switch flow. Switching context calls `POST /api/v1/auth/context` and reloads permission/entitlement snapshots.
- `entitlements` store caches the plan-entitlement snapshot (`GET /api/v1/merchant/entitlements`) for **UX gating only** (hide/disable + upgrade prompts). The server re-checks everything.
- Idle timeout: `useIdleTimeout` watches activity, shows the 60-second warning (operational roles), and calls logout at the role's idle limit; the server enforces its own idle expiry regardless (client timer is UX).
- Session-expiry handling: any 401 triggers a non-destructive "session expired" modal preserving unsaved form state locally (drafts registry) before redirecting to login.

### 6.3 Permission-aware rendering (UX only)

`usePermissions()` exposes `can('inventory.movement.create')` backed by the server-issued permission snapshot (permission-version stamped). Components hide or disable affordances; every guarded action still round-trips to the server and renders the structured error if denied. A lint rule bans importing the permission composable inside `api/` (no client-side "authorization" decisions on data).

### 6.4 State/status handling (mandatory for every data view)

Every list/detail page implements the four states explicitly: **loading** (skeletons, not spinner-only, for tables/cards), **empty** (explanatory copy + primary action), **error** (human-readable message from the error envelope + retry + correlation ID), **populated**. A shared `useAsyncResource` composable standardizes this; PR review checklist item.

### 6.5 POS offline drafts (Scope §18.1)

The POS page keeps the in-progress cart in IndexedDB (`pos` store persistence). On connectivity loss: banner "Offline — draft saved locally"; drafts sync on reconnect via the idempotent sale-submission endpoint; **no receipt is issued offline** unless merchant policy explicitly enables provisional receipts flagged "unvalidated". Drafts are not completed sales; stock is not deducted until server completion.

### 6.6 Safe rendering of user-generated content

All UGC (product descriptions, notes, messages) renders through Vue text interpolation. Rich text (where allowed, e.g. storefront product descriptions) is sanitized server-side on save (allowlist: `p, br, ul, ol, li, strong, em, a[href^=https]`) and rendered through the single `SafeHtml` component. CSP forbids inline scripts.

### 6.7 Frontend prohibited list (CI-enforced)

`jquery` in any dependency tree → build fails. Secret-looking strings in bundles → gitleaks scan fails. `v-html` outside `SafeHtml.vue` → ESLint error. `window.innerWidth`-based layout decisions → ESLint custom rule error (responsive is CSS-only).

---

## 7. Database Architecture

### 7.1 Conventions (apply to every table)

1. `id BIGSERIAL PRIMARY KEY` (internal, never exposed) + `public_id CHAR(26) NOT NULL UNIQUE` (ULID; route binding key).
2. Tenant-owned tables carry `merchant_id BIGINT NOT NULL REFERENCES merchants(id)`, indexed, first column of every composite index used by list queries.
3. Branch-attributed tables additionally carry `branch_id BIGINT REFERENCES branches(id)`.
4. `created_at`/`updated_at TIMESTAMPTZ`; `deleted_at` only where soft delete is justified (catalog-ish data); financial/audit tables are **append-only, never soft-deleted**.
5. Money: `{name}_minor BIGINT` + `currency CHAR(3) DEFAULT 'KES'`.
6. Enum-ish states: `VARCHAR` + CHECK constraint mirroring the PHP enum; migration and enum kept in sync by a test.
7. Append-only enforcement: tables marked **[AO]** get `CREATE TRIGGER forbid_mutation BEFORE UPDATE OR DELETE … RAISE EXCEPTION` (UPDATE allowed only on explicitly whitelisted status columns where the state machine appends transitions in-place — noted per table).
8. Sensitive columns (national IDs, phone numbers, external payment references, raw referral codes) encrypted at rest via Laravel encrypted casts **[ENC]** and masked in list views/exports/logs **[MASK]**.
9. All schema changes via migrations; every FK indexed; every migration reversible or explicitly marked irreversible with justification.

### 7.2 Identity and access tables

| Table | Purpose / key columns | Keys, indexes, constraints | Policies |
|---|---|---|---|
| `users` | Every human identity (platform staff, merchant staff, end users). `public_id`, `name`, `email CITEXT UNIQUE NULL`, `phone VARCHAR UNIQUE NULL` [ENC][MASK], `email_verified_at`, `phone_verified_at`, `user_type` (`platform_staff`,`merchant_staff`,`end_user`) , `status` (`active`,`locked`,`deactivated`), `profile_photo_file_id`, `theme_preference` (`light`,`dark`,`system`), `locale` | UNIQUE(email), UNIQUE(phone); CHECK at least one of email/phone; partial index on `user_type` | No password column exists for merchant/platform users (SR-11). Duplicate email/phone rejected at registration. Anonymizable per rights requests (identity fields nulled; FK rows retained). |
| `auth_link_tokens` [AO except `consumed_at`,`status`] | Magic-link tokens. `user_id`, `token_hash CHAR(64) UNIQUE`, `audience` (`platform_staff`,`merchant_staff`), `surface_host`, `merchant_id NULL`, `intended_context JSONB NULL`, `expires_at`, `consumed_at`, `consumed_ip INET`, `consumed_user_agent`, `first_use_fingerprint`, `status` (`issued`,`consumed`,`expired`,`revoked`,`replayed`) | INDEX(user_id, created_at); tokens hashed at rest; retention 30 days then purge | Replay from different device/IP terminates the spawned session + security event (Scope §13.1.4). |
| `otp_codes` [AO except status] | End-User OTPs. `user_id`, `channel` (`email`,`sms`), `code_hash`, `purpose` (`register`,`login`,`checkout`,`profile_change`,`step_up`), `expires_at` (≤5 min), `attempts SMALLINT`, `status` | INDEX(user_id, purpose, created_at); max 5 verify attempts then lockout | Never logged in plaintext. |
| `sessions` | Laravel session table + custom columns: `user_id`, `membership_id NULL`, `acting_role_id NULL`, `branch_id NULL`, `shift_session_id NULL`, `permission_version INT`, `device_fingerprint`, `ip`, `user_agent`, `last_activity`, `elevated_until TIMESTAMPTZ NULL` (step-up) | INDEX(user_id) | Sessions listable/terminable by owner; revocation ≤60 s via permission-version bump + session kill. |
| `trusted_devices` | End Users only, max 3. `user_id`, `device_fingerprint_hash`, `label`, `trusted_until` (90 days), `revoked_at` | UNIQUE(user_id, device_fingerprint_hash); app-enforced max 3 | Merchant staff have no remembered devices at launch. |
| `security_events` [AO] | Login link issued/used/replayed, new device, suspicious login, lockouts, step-up failures, forced logouts. `user_id NULL`, `merchant_id NULL`, `event_type`, `severity`, `ip`, `user_agent`, `context JSONB`, `correlation_id` | INDEX(user_id, created_at), INDEX(event_type, created_at) | Feeds security notifications + alerting. Staff security logs retained 12 months; End-User login history 30–60 days rolling. |

### 7.3 Tenancy, membership, RBAC tables

| Table | Purpose / key columns | Keys, indexes, constraints | Notes |
|---|---|---|---|
| `merchants` | Tenant root. `public_id`, `legal_name`, `display_name`, `slug CITEXT UNIQUE` (storefront URL), `business_registration_number` [ENC][MASK], `owner_national_id` [ENC][MASK], `country`, `kyc_status` (`pending`,`verified`,`manual_review`,`failed`), `identity_locked_at`, `email CITEXT`, `phone` [ENC], `onboarding_status` (`registration_started`,`identity_verified`,`onboarding`,`active_complete`,`rejected`,`abandoned`), `operational_status` (`active`,`suspended`,`deactivated`,`archived`,`closed`), `operational_suspension_reason` NULL, `billing_status` (`trialing`,`active`,`overdue`,`read_only_grace`,`suspended_billing`,`cancelled`), `compliance_status` (`clear`,`under_review`,`restricted`), `currency CHAR(3)`, `timezone`, `business_category`, `settings JSONB`, `wallet_merchant_account_ref NULL`, `terms_accepted_version`, `activated_at` | UNIQUE(business_registration_number) WHERE country='KE'; UNIQUE(slug); duplicate detection composite indexes on legal_name (trigram), email, phone | **Four independent status dimensions never conflated** (Scope §14.4). No hard delete within statutory windows; archival per D-03. Status transition history in `merchant_status_events` [AO]. |
| `merchant_status_events` [AO] | Every status-dimension transition: `merchant_id`, `dimension`, `from_state`, `to_state`, `reason_category`, `reason_text`, `actor_user_id NULL` (NULL = system), `correlation_id` | INDEX(merchant_id, created_at) | Proves PR-9 separation in audits. |
| `branches` | Business units. `merchant_id`, `public_id`, `name`, `address JSONB`, `contact JSONB`, `timezone`, `operating_hours JSONB`, `service_area JSONB NULL`, `status` (`draft`,`active`,`temporarily_closed`,`suspended`,`archived`,`closed`), `storefront_enabled BOOL`, `settings JSONB` | INDEX(merchant_id, status); UNIQUE(merchant_id, name) | Lifecycle per Scope §15.1; archive preconditions enforced in the Action (no open orders, stock dispositioned, not last active branch unless closing). |
| `roles` | Platform-defined role catalog: `key` (`super_admin`,`merchant_admin`,`branch`,`hr`,`finance`,`cashier`,`inventory`,`personnel`,`growth`,`cx`,`audit`,`end_user`), `name`, `scope_type` (`platform`,`tenant`,`branch`,`own`), `is_assignable_by_hr BOOL` | UNIQUE(key) | Seeded, versioned; merchants configure *limits/policies*, not the matrix itself. |
| `permissions` | Atomic permission keys, e.g. `catalogue.product.create`, `evidence.validate`, `billing.plan.change`. Columns: `key`, `module`, `description`, `requires_step_up BOOL`, `requires_maker_checker BOOL`, `audit_severity` | UNIQUE(key) | Seeded from the Scope §12.2 matrix; seeder is the single source of truth; a test snapshots the matrix. |
| `role_permission` | `role_id`, `permission_id`, `constraint_note` | UNIQUE(role_id, permission_id) | |
| `memberships` | User × merchant × role × scope. `user_id`, `merchant_id`, `role_id`, `branch_id NULL` (NULL = tenant-wide where role allows), `status` (`invited`,`active`,`held`,`suspended`,`offboarded`), `hold_reason` (`working_hours`,`leave`,`manual`) NULL, `working_hours_window JSONB NULL`, `access_expires_at NULL`, `provisioned_by_user_id`, `recertified_at`, `permission_overrides JSONB NULL` (explicit grants/denies within policy, e.g. discount authority caps, pricing authority) | UNIQUE(user_id, merchant_id, role_id, COALESCE(branch_id,0)); INDEX(merchant_id, status); INDEX(user_id, status) | One human, many memberships (multi-role SME + multi-branch Branch role). Membership change bumps the user's `permission_version` and revokes/re-validates sessions ≤60 s. Last-active-Merchant-Administrator removal blocked. HR self-escalation blocked in policy. |
| `membership_events` [AO] | Before/after values of every identity/role/scope change | INDEX(membership_id, created_at) | HR audit obligation (Scope §11.4). |
| `invitations` | Staff invitations. `merchant_id`, `email CITEXT`, `role_id`, `branch_id NULL`, `token_hash UNIQUE`, `invited_by_user_id`, `expires_at` (7 days), `status` (`issued`,`accepted`,`expired`,`revoked`) | INDEX(merchant_id, status); UNIQUE(merchant_id, email, role_id, branch_id) WHERE status='issued' | Email change during pending invitation → revoke + reissue (Scope §39.1); acceptance rate-limited. |
| `merchant_policies` | Tenant governance settings: discount authority defaults, approval thresholds (stock adjustment, write-off, promotion budget/margin guards), negative-stock policy, receipt issuance rule, evidence always-validate threshold, email-domain restrictions for staff, working-hours defaults, recertification cycle days, End-Shift variance tolerance (D-15) | UNIQUE(merchant_id, key) | Versioned via `merchant_policy_events` [AO]. |
| `platform_settings` | Platform config: domains, legal document versions, notification template versions, integration registry, decision-register runtime values (D-02 abandoned-registration expiry, D-03 archival period, D-10 N/M thresholds, clearing grace days) | UNIQUE(key) | Super Administrator governed; every change audited. |

### 7.4 Catalogue and inventory tables

| Table | Purpose / key columns | Keys, indexes, constraints |
|---|---|---|
| `categories` | `merchant_id`, `name`, `parent_id NULL` (one level), `locked BOOL` | UNIQUE(merchant_id, parent_id, name) |
| `products` | `merchant_id`, `public_id`, `type` (`physical`,`service`), `name`, `description_html` (sanitized), `unit_of_measure`, `tax_class`, `status` (`draft`,`active`,`archived`,`discontinued`), `pos_available BOOL`, `storefront_visible BOOL`, `availability_windows JSONB` | INDEX(merchant_id, status); trigram index on name (soft duplicate warning) |
| `product_category` | pivot | UNIQUE(product_id, category_id) |
| `skus` | Sellable units. `merchant_id`, `product_id`, `public_id`, `sku_code`, `variant_attributes JSONB`, `barcode VARCHAR NULL`, `barcode_locked_at NULL` (immutable once used in a posted transaction), `reorder_level INT NULL`, `status` | **UNIQUE(merchant_id, sku_code)** → `SKU_DUPLICATE`; **UNIQUE(merchant_id, barcode)** WHERE barcode IS NOT NULL |
| `bundles` / `bundle_components` | Kits: parent SKU + component SKU + quantity; stock behavior deduct-components | UNIQUE(bundle_id, component_sku_id) |
| `modifiers` / `modifier_options` | Add-ons with `price_delta_minor` | |
| `prices` [AO] | Effective-dated price history. `merchant_id`, `sku_id`, `branch_id NULL` (NULL = tenant standard), `kind` (`standard`,`promotional`,`branch_override`), `amount_minor`, `currency`, `effective_from`, `effective_to NULL` (mandatory for promotional), `set_by_user_id`, `acting_role`, `reason`, `supersedes_price_id NULL` | INDEX(sku_id, branch_id, effective_from DESC); no UPDATE — new rows supersede. Branch overrides validated against policy bounds. Historical transactions snapshot price at execution. |
| `cost_records` [ENC-restricted read] | Purchase cost per SKU; visibility Administrator/Finance/Inventory-where-granted only | INDEX(sku_id, effective_from DESC) |
| `stock_locations` | `merchant_id`, `branch_id`, `name`, `is_default BOOL`, `status` | UNIQUE(branch_id, name); every branch gets ≥1 default location on activation |
| `stock_levels` | Materialized on-hand per SKU × location: `sku_id`, `stock_location_id`, `on_hand INT`, `reserved INT`, `version INT` | UNIQUE(sku_id, stock_location_id); row-locked on every movement; CHECK(on_hand >= 0) dropped/kept per negative-stock policy — enforcement in Action with policy check, DB CHECK kept as `on_hand >= min_allowed` guard |
| `stock_movements` [AO] | Immutable ledger. `merchant_id`, `branch_id`, `stock_location_id`, `sku_id`, `movement_type` (`opening_stock`,`receipt`,`transfer_out`,`transfer_in`,`reservation`,`commitment`,`sale_deduction`,`return_in`,`adjustment`,`count_variance`,`damage`,`expiry`,`wastage`,`shrinkage`,`write_off`), `quantity_delta INT`, `before_qty INT`, `after_qty INT`, `reason_code`, `reason_text`, `source_type`/`source_id` (sale, order, delivery, count, transfer pair), `batch_reference NULL`, `expiry_date NULL`, `actor_user_id NULL`, `acting_role`, `approved_by_user_id NULL`, `correlation_id` | INDEX(merchant_id, branch_id, created_at); INDEX(sku_id, created_at); INDEX(source_type, source_id). Posted movements immutable; corrections are new movements (Scope §17.4). |
| `stock_reservations` | `sku_id`, `stock_location_id`, `quantity`, `cart_id`/`order_id`, `expires_at`, `status` (`active`,`converted`,`released`,`expired`) | INDEX(expires_at) WHERE status='active' |
| `stock_transfers` | Two-sided transfer header: `from_location_id`, `to_location_id`, `status` (`initiated`,`in_transit`,`received`,`cancelled_with_compensation`) | Movement pair rows FK here |
| `stock_counts` / `stock_count_lines` | Count snapshot + variance postings with approval | INDEX(merchant_id, status) |
| `suppliers` | Non-financial: identity, contacts, product associations, delivery history, reliability notes, `deactivated_at` | UNIQUE(merchant_id, name); no bank details/PO/payment-terms columns exist at launch |
| `supplier_deliveries` [AO] | Immutable delivery logs referenced by receipts | INDEX(supplier_id, created_at) |
| `barcode_scan_events` [AO] | Scan logging (Scope §16.1) | partitioned monthly if volume demands |

### 7.5 Sales, orders, storefront, shifts tables

| Table | Purpose / key columns | Keys, indexes, constraints |
|---|---|---|
| `shift_sessions` | Cashier shifts. `merchant_id`, `branch_id`, `cashier_user_id`, `opened_at`, `opening_cash_declared_minor`, `status` (`opened`,`active`,`closing`,`closed`), `closed_at`, `expected_cash_minor`, `declared_cash_minor`, `variance_minor`, `variance_notes`, closure record immutable | UNIQUE(cashier_user_id) WHERE status IN ('opened','active') — one open shift per cashier; INDEX(branch_id, opened_at) |
| `carts` | Storefront carts: `end_user_id NULL` (guest token otherwise), `merchant_id`, `branch_id` (branch-locked), `expires_at`, `status` | Switching merchant clears cart (app rule); INDEX(expires_at) |
| `orders` | Online + quote-originated. `merchant_id`, `branch_id`, `public_id`, `channel` (`storefront`,`quote`,`pos`), `end_user_id NULL`, `customer_id NULL`, `status` (`pending`,`accepted`,`in_progress`,`ready`,`completed`,`cancelled`,`failed`), `payment_position` (`unpaid`,`partially_recorded`,`fully_recorded`), `fulfilment_type` (`pickup`,`merchant_managed`), `external_courier_ref NULL`, `totals JSONB` (snapshot), `placed_at` | INDEX(merchant_id, branch_id, status, placed_at DESC); INDEX(end_user_id, placed_at DESC) |
| `sales` [AO status-append] | POS sales. `merchant_id`, `branch_id`, `public_id`, `shift_session_id`, `cashier_user_id`, `customer_id NULL`, `status` (`draft`,`awaiting_payment_evidence`,`completed`,`cancelled`), `subtotal_minor`, `discount_total_minor`, `total_minor`, `currency`, `completed_at`, `idempotency_key UNIQUE NULL` | INDEX(merchant_id, branch_id, completed_at DESC); INDEX(shift_session_id). Posted sales immutable; corrections via linked void/return events. |
| `sale_lines` / `order_lines` [AO] | Line snapshots: `sku_id`, `name_snapshot`, `unit_price_minor_snapshot`, `quantity`, `discount JSONB` (who/authority/amount), `modifiers JSONB`, `line_total_minor`, `fulfilment_status` (order lines, for partial fulfilment) | INDEX(sale_id)/(order_id). Name+price snapshots preserve history through renames (Scope §16.4). |
| `quotes` | Growth quotations: `status` (`draft`,`sent`,`viewed`,`accepted`,`declined`,`expired`), `expires_at NOT NULL`, `share_token_hash`, lines snapshot | Accepted quote creates an order request routed to the branch POS queue; Growth never executes the sale. |
| `merchant_invoices` [AO] | Invoices to customers: `merchant_id`, `branch_id`, `order_id/sale_id`, `status` (`draft`,`issued`,`partially_settled_by_evidence`,`settled_by_validated_evidence`,`cancelled`), `total_minor`, `issued_at`; corrections via `credit_notes` [AO] | INDEX(merchant_id, status) |
| `receipts` [AO] | Immutable documents: `merchant_id`, `branch_id`, `sale_id/order_id`, `receipt_number` (tenant-sequential display number generated under lock), `pdf_file_id`, `issued_marking` (`declared_pending_validation`,`validated`), `voided_by_document_id NULL`, `is_copy BOOL` | UNIQUE(merchant_id, receipt_number) |
| `returns` / `return_lines` | Return initiation → disposition (`restock`,`write_off`), linked compensating stock movements and refund records | INDEX(sale_id) |
| `void_events` [AO] | Pre-completion voids with reason, actor, approval | |

### 7.6 Payment evidence, finance records tables

| Table | Purpose / key columns | Keys, indexes, constraints |
|---|---|---|
| `payment_evidence_records` [AO status-append] | The heart of SR-1/SR-2. `merchant_id`, `branch_id`, `public_id`, `sale_id/order_id/merchant_invoice_id` (≥1), `declared_method` (`cash`,`mpesa_till`,`mpesa_paybill`,`bank_transfer`,`card_terminal`,`cheque`,`voucher`,`insurance_third_party`,`merchant_credit`,`other`), `amount_minor`, `currency`, `external_reference` [ENC][MASK] NULL, `external_reference_hash CHAR(64) NULL` (dedup key), `declared_paid_at`, `recorded_by_user_id`, `recording_role`, `validation_status` (`pending_validation`,`validated`,`rejected`,`disputed`,`refunded_off_platform`,`reversed_off_platform`,`written_off`), `validated_by_user_id NULL`, `validated_at`, `rejection_reason NULL`, `single_operator_override BOOL DEFAULT false` | **UNIQUE(merchant_id, external_reference_hash) WHERE external_reference_hash IS NOT NULL AND validation_status <> 'rejected'** → `PAYMENT_REFERENCE_DUPLICATE`; INDEX(merchant_id, validation_status, created_at); CHECK(validated_by_user_id IS NULL OR validated_by_user_id <> recorded_by_user_id OR single_operator_override) — recorder≠validator with audited SME fallback |
| `refund_dispute_records` [AO] | Off-platform refund/reversal/chargeback records: link to original evidence/sale, `amount_minor`, `off_platform_method`, `reason`, `initiated_by`, `approved_by` (maker-checker), `state` (`initiated`,`approved`,`recorded_off_platform`,`declined`) | INDEX(merchant_id, created_at) |
| `expenses` [AO after finalize] | Manual expenses: category (`branch_operations`,`commission_system`,`communication`,`recurring`,`one_off`), `amount_minor`, `branch_id`, `finalized_at` (immutable after) | INDEX(merchant_id, branch_id, created_at) |
| `financial_periods` | Period locks: `merchant_id`, `period_start`, `period_end`, `status` (`open`,`locked`,`reopened`), `locked_by`, `lock_approved_by` (maker-checker Administrator+Finance), reopen events [AO] | UNIQUE(merchant_id, period_start). Locked periods reject postings dated within (`INVALID_STATE_TRANSITION`-class error); corrections require reopen maker-checker or current-period posting with back-reference. |
| `cash_up_reviews` | Finance review of shift variances: `shift_session_id`, `status`, `resolution` (`linked_evidence`,`adjustment`,`duplicate`,`escalated`), notes | INDEX(merchant_id, status) |
| `statement_imports` | Merchant-supplied statement files for reconciliation (file ref, parse results, match links) — **merchant-supplied files only, never provider feeds** | INDEX(merchant_id, created_at) |

### 7.7 Customers and loyalty tables

| Table | Purpose / key columns | Keys, indexes, constraints |
|---|---|---|
| `customers` | Merchant-scoped relationship: `merchant_id`, `end_user_id NULL` (link to central identity), `name`, `email/phone` [ENC][MASK] verified flags, `consent JSONB` (versioned marketing consent), `tags`, `merged_into_customer_id NULL` | UNIQUE(merchant_id, email) / (merchant_id, phone) partial WHERE verified → `CUSTOMER_DUPLICATE`; merges append-only via `customer_merge_events` [AO]; **no cross-tenant joins ever** (Scope §23.1) |
| `customer_notes` [AO] | Append-only notes with author/role | |
| `loyalty_programs` | Per-merchant config: earn rules, tiers (Bronze/Silver/Gold/Platinum-class), expiry rules, versioned via [AO] config events | UNIQUE(merchant_id) |
| `loyalty_accounts` | Per customer per merchant: `points_balance` (derived, rebuildable), `tier` | UNIQUE(merchant_id, customer_id) |
| `loyalty_ledger_entries` [AO] | **Append-only** ledger: `entry_type` (`earn`,`redeem`,`expire`,`manual_adjustment`,`reversal_compensation`), `points_delta`, `source_type/source_id` (sale, return, adjustment approval), `branch_id`, `balance_after` | INDEX(loyalty_account_id, created_at); manual adjustments require approved `loyalty_adjustments` row (maker-checker, never single-operator per D-07) |
| `loyalty_adjustments` | Proposal→approval workflow rows | CHECK(proposed_by <> approved_by) |

### 7.8 Growth and CX tables

`promotions` (scope: merchant/branch/product/category/segment; versioned via `promotion_versions` [AO]; budget/margin guards; stacking rules default no-stack), `coupons` (usage limits, per-customer limits, validity windows, brute-force rate limiting at API), `coupon_redemptions` [AO], `leads` (manual + system-generated from abandoned/cancelled/partial orders, masked PII, append-only notes), `commission_structures` + `commission_attributions` (Earned/Pending/Confirmed; **no payout capability exists**), `segments` (non-financial criteria), `cx_cases` (open→in_progress→escalated→resolved→closed; reopened), `cx_messages` [AO] (consent-checked at send, cost preview, frequency safeguards), `cx_campaigns` (non-transactional, optional Administrator approval), `journeys` (predefined activation only at launch), `feedback_records` [AO] (immutable aggregation), `communication_budgets` (per D-08 plan-entitled bundles).

### 7.9 Staff operations tables

`staff_profiles` (non-financial employment records; documents via `files`), `work_shifts` + `shift_assignments` (templates, scheduling), `attendance_records` [AO after checkout] (one active check-in at a time — partial unique index; manual entries require reason), `leave_requests` (types annual/sick/unpaid/special; approval workflow; approved leave auto-holds membership and reactivates after), `kpi_templates` + `kpi_scores`, `payroll_periods` + `payroll_preparation_lines` (attendance-derived, leave-adjusted, overtime/commission-readiness flags; `approve_and_lock` makes rows immutable [AO]; export-to-Finance artifact; **no disbursement columns exist**), `access_recertifications` (cycle records; overdue flags to Audit).

### 7.10 Billing and subscription tables (Citrus-owned truth)

| Table | Purpose / key columns | Keys, indexes, constraints |
|---|---|---|
| `plans` / `plan_versions` [AO] | Platform plan catalog: name, `price_minor`, `billing_interval` (`monthly`; `annual` per D-04), trial rules, `status`. **Versions immutable once any merchant subscribes**; changes create new versions | UNIQUE(plan_id, version_no) |
| `plan_entitlements` | Per plan version: `entitlement_key` (`branch_limit`,`staff_limit`,`catalogue_limit`,`storage_mb`,`stock_location_limit`,`storefront_enabled`,`report_tier`,`scheduled_reports`,`growth_module`,`cx_messaging`,`attendance_module`,`quotations`,`message_bundle_monthly`, …), `int_value/bool_value` | UNIQUE(plan_version_id, entitlement_key) |
| `platform_promotions` | Subscription-price discounts with start/end + overlap validation | |
| `subscriptions` | Per merchant: `plan_version_id`, `status` (`trialing`,`active`,`overdue`,`read_only_grace`,`suspended_billing`,`cancelled`,`expired`), `current_period_start/end`, `scheduled_plan_change_id NULL` (downgrades at renewal), `cancelled_at` | UNIQUE(merchant_id) WHERE status NOT IN ('cancelled','expired') |
| `subscription_invoices` [AO status-append] | `merchant_id`, `public_id` (ULID = Wallet `external_reference`), `status` (`draft`,`issued`,`pending_payment`,`partially_paid`,`paid`,`overdue`,`cancelled`,`reconciliation_required`), `line_items JSONB` (plan period, proration, promotions, credits, tax per D-06), `amount_due_minor`, `balance_minor`, `due_at`, `wallet_payment_id NULL`, `wallet_payment_reference NULL` (`{PREFIX}-PAY-…`), `wallet_registration_status` (`pending`,`registered`,`failed`), `wallet_registered_at` | INDEX(merchant_id, status, due_at). **No manual payment recording path exists for any role** (Scope §20.3.2). |
| `merchant_billing_credits` [AO] | Overpayment credits auto-applied to next invoice | INDEX(merchant_id) |
| `billing_enforcement_events` [AO] | Grace entered, restriction, suspension, restoration; includes fairness-pause records during Wallet outage | INDEX(merchant_id, created_at) |

### 7.11 Wallet integration tables (projections — Wallet owns money truth)

| Table | Purpose | Constraints |
|---|---|---|
| `wallet_merchant_account_links` | Citrus merchant → Wallet merchant account mapping: `wallet_merchant_account_id`, `environment`, `sync_status` | UNIQUE(merchant_id, environment) |
| `subscription_payment_attempts` | STK/instruction attempt lifecycle: `subscription_invoice_id`, `wallet_payment_id`, `wallet_attempt_id`, `msisdn_masked`, `idempotency_key`, `state` (mirrors Wallet incl. `UNKNOWN`), `cooldown_until` | INDEX(subscription_invoice_id, created_at); UNKNOWN blocks new attempts until resolved |
| `subscription_payments` [AO] | Immutable confirmed-payment projection: `wallet_payment_id`, `confirming_wallet_event_id UNIQUE`, `amount_minor`, `wallet_settlement_status` projection | **UNIQUE(confirming_wallet_event_id)** — first-seen dedup; UNIQUE(wallet_payment_id, subscription_invoice_id) reuse guard feeding `WALLET_PAYMENT_REUSED` |
| `subscription_payment_reversals` [AO] | Reversal/refund/chargeback rows keyed on `wallet_event_id`; never edits original payment | UNIQUE(wallet_event_id) |
| `wallet_webhook_inbox` [AO except processing_status] | Encrypted verified payloads: `wallet_event_id UNIQUE`, `event_type`, `payload_encrypted`, `processing_status` (`received`,`processed`,`duplicate`,`failed`,`ignored`,`rejected`), `nonce`, `key_id`, `received_at` | UNIQUE(wallet_event_id); nonce replay store with 48 h retention |
| `billing_reconciliation_exceptions` | `source` (`wallet_event`,`allocation_recon`,`stale_attempt`,`inbound_gap`), `reason` (`unknown_payment`,`amount_mismatch`,`allocation_drift`,`wallet_payment_reused`,`duplicate_confirmation`,`late_payment_cancelled_invoice`), `status` (`open`,`resolved_by_linkage`,`resolved_as_credit`), `resolved_by_user_id` (Super Administrator, step-up) | INDEX(status, created_at); resolution is **linkage only** |
| `subscription_invoice_payment_locks` | Prevents concurrent STK initiation per invoice | UNIQUE(subscription_invoice_id) WHERE active |

### 7.12 Referral integration tables (snapshots — R&E owns reward truth)

| Table | Purpose | Constraints |
|---|---|---|
| `referral_snapshots` [AO status-append] | The 9 minimum fields (§4.5) + `raw_code_encrypted` [ENC], `snapshot_status` (`captured`,`validating`,`validated`,`confirmed`,`rejected`,`invalid_format`,`pending_central_confirmation`) | UNIQUE(merchant_id) — one attribution per tenant; immutable after tenant creation |
| `re_outbound_events` [AO payload] | Transactional outbox: `event_id CHAR(26) UNIQUE`, `event_type`, `event_version`, `merchant_id`, `sequence_no` (per merchant), `payload JSONB` (append-only, trigger-enforced), `content_sha256`, `occurred_at`, `status` (`queued`,`delivering`,`delivered`,`retrying`,`dead_lettered`,`replayed`), `attempts`, `next_retry_at` | UNIQUE(event_id); UNIQUE(merchant_id, sequence_no); INDEX(status, next_retry_at) |
| `re_event_deliveries` [AO] | Full delivery attempt history per event | INDEX(outbound_event_id) |
| `re_activity_rule_versions` | Version-pinned qualification rules (N sales, M validated payments, grace days) registered centrally per D-10 | UNIQUE(rule_id, version) |
| `re_qualification_periods` | One row per attributed merchant per service month: `period_start/end` (Africa/Nairobi bounds stored UTC), `status` per R&E state list incl. `awaiting_full_subscription_payment` | UNIQUE(merchant_id, period_start) |
| `re_qualification_decisions` [AO] | Append-only decisions: `decision` (`qualified`,`not_qualified`), `failure_category NULL`, `decision_version`, `supersedes_event_id NULL`, `evidence_checksum`, `evidence_summary JSONB` (counts only) | UNIQUE(merchant_id, period_start, rule_version, decision_version) |
| `re_inbound_requests` [AO] | Reconciliation nonce replay protection (unique nonce, 90-day retention) | UNIQUE(nonce) |

### 7.13 Cross-cutting tables

| Table | Purpose | Constraints / retention |
|---|---|---|
| `audit_events` [AO, hash-chained] | `merchant_id NULL` (NULL = platform), `branch_id NULL`, `actor_user_id NULL`, `acting_role`, `action` (dot-namespaced catalogue), `target_type/target_id`, `severity` (`low`,`medium`,`high`,`critical`), `reason NULL`, `approval_ref NULL`, `before JSONB NULL`/`after JSONB NULL` (masked, only where safe), `ip`, `user_agent`, `source_channel`, `correlation_id`, `prev_hash CHAR(64)`, `row_hash CHAR(64)` (SHA-256 of canonical row + prev_hash; per-tenant chain + platform chain) | INDEX(merchant_id, created_at); INDEX(action, created_at); monthly partitions; longest retention class; legal-hold aware; **no role can modify** (DB trigger + no update path) |
| `notifications` | In-app: `user_id`, `merchant_id NULL`, `category`, `severity`, `is_mandatory BOOL` (transactional/security cannot be disabled), `read_at`, `payload JSONB`, `template_version` | INDEX(user_id, created_at DESC); retention 90 days non-critical, compliance-critical per audit class |
| `notification_deliveries` [AO] | Send log per channel: `channel` (`in_app`,`email`,`sms`), `recipient_masked`, `status`, `provider_message_id`, `dedup_key UNIQUE` (one logical event → max one notification per channel per recipient) | INDEX(status, created_at) |
| `notification_preferences` | Per user per category; mandatory categories not overridable | UNIQUE(user_id, category) |
| `files` | `merchant_id NULL` (NULL = platform), `public_id`, `class` (`product_image`,`branding`,`staff_document`,`supplier_document`,`generated_pdf`,`import`,`export`), `disk`, `path` (tenant-prefixed), `original_name`, `mime`, `size_bytes`, `sha256`, `scan_status` (`pending`,`clean`,`infected`,`failed`), `visibility` (`private`,`public_cacheable`), `owner_record_type/id NULL`, `retention_class`, `legal_hold BOOL`, `expires_at NULL` | INDEX(merchant_id, class); orphan GC after safety window; infected files quarantined + alert |
| `imports` / `import_rows` | Batch imports: template type, validation preview, row-level errors, `import_batch_id` idempotent re-run behavior, duplicate handling option (`reject`,`skip`,`update_by_sku`) | INDEX(merchant_id, status) |
| `exports` | Generated artifacts: requester, scope snapshot, permission re-check at download, watermark metadata, integrity hash (Audit exports), `expires_at` (30 days) | INDEX(merchant_id, requested_by, created_at) |
| `idempotency_keys` | `key`, `scope` (user/tenant + operation), `request_hash CHAR(64)`, `response_snapshot JSONB`, `status` (`processing`,`completed`), `expires_at` (≥72 h standard, ≥30 d financial) | UNIQUE(scope, key) |
| `jobs`, `failed_jobs`, `job_batches` | Laravel queue tables (DB fallback; primary driver Redis) — `failed_jobs` monitored + alerting; retention 30 days after resolution | standard |
| `report_schedules` / `generated_reports` | Scheduled report definitions and artifacts (entitlement-gated) | INDEX(merchant_id, next_run_at) |
| `data_rights_requests` | DSR workflow: access/correct/export/delete-anonymize; identity verification; statutory-retention-aware anonymization | INDEX(status) |
| `legal_holds` | Suspend deletion for named records with audit | |

### 7.14 Retention schedule (config-driven, `config/retention.php`)

| Class | Records | Default (pending D-11 legal review) |
|---|---|---|
| Statutory-financial | sales, orders, invoices, receipts, evidence, refunds, subscription invoices, payments projections | 7 years |
| Audit | audit_events, security_events (staff) | 7 years (longest) |
| Employment | staff profiles, attendance, payroll prep | 5 years post-exit |
| Medium | customers (consent-bound), suppliers, promotions | life of relationship + 2 years |
| Short | notifications 90 d; export artifacts 30 d; End-User login history 60 d; magic-link tokens 30 d; webhook nonces 48 h; R&E inbound nonces 90 d |
| Purge jobs | `PurgeExpiredArtifactsJob` nightly; anonymization respects legal holds and statutory classes (anonymize identity, retain transaction facts) |

---

## 8. Multi-Tenancy and Data Isolation Model

### 8.1 Strategy

Single database, shared schema, **row-level tenancy** with `merchant_id` on every tenant-owned table, enforced in four independent layers (defense in depth):

1. **Global scope (query layer).** A `BelongsToMerchant` trait applies a mandatory Eloquent global scope injecting `WHERE merchant_id = ?` from the request-bound `TenantContext`. Models using the trait **cannot be queried without tenant context**: if `TenantContext` is unbound and the query is not explicitly marked `crossTenantAuthorized()` (Super Administrator/platform jobs only, itself permission-checked and audited), the scope throws `TenantContextMissingException` — a hard failure, never a silent unscoped query.
2. **Policy layer.** Every policy's first checks: (a) the resolved model's `merchant_id` equals the context tenant, (b) branch scope where applicable, (c) permission. Route-model binding resolves by `public_id` **within the scoped query**, so a foreign tenant's valid ULID yields 404 (`BRANCH_ACCESS_DENIED` non-disclosure semantics) before the policy even runs.
3. **Database layer.** Composite FKs and CHECKs where feasible (e.g. `sale_lines.sku_id` must belong to the same merchant — verified in Action + a periodic integrity sweep job); partial unique constraints are tenant-prefixed.
4. **Test layer.** The tenant-isolation test suite (Section 25.5) runs two seeded tenants (A and B) through every resource type asserting non-access, non-inference, non-enumeration.

### 8.2 Tenant resolution and storage during requests

- **Merchant staff:** tenant is bound to the session at context selection (Scope §13.3). `context.tenant` middleware loads the membership, verifies the 8-point active-membership check (§5.3), and binds `TenantContext { merchantId, membershipId, actingRoleId, branchId|null, permissionVersion }` into the container. Users select among **only their permitted contexts**; the selector never lists foreign tenants.
- **End Users:** storefront routes resolve the merchant from the URL slug (`citrus.ke/{merchant-slug}`); the End User's own records are scoped by `end_user_id`; merchant-relationship data is scoped by (merchant, customer link). One central identity, per-merchant isolated relationships (Scope §23.1).
- **Super Administrators:** operate on platform surfaces with `crossTenantAuthorized()` reads through purpose-limited endpoints; every merchant-data read requires a `reason` parameter and emits a high-severity audit event (Scope §10.3). No impersonation exists at launch (D-14).

### 8.3 Branch scope

`memberships.branch_id` defines the scope. Branch-scoped roles (Cashier, Inventory, Personnel, CX, branch-scoped HR/Finance/Audit/Branch) get an additional `branch_id` filter injected by `context.branch`. Tenant-governance roles (Merchant Administrator; merchant-wide Audit/Finance) see multi-branch data per the permission matrix. Cross-branch access attempts return 404-style non-disclosure + `BRANCH_ACCESS_DENIED` audit on pattern.

### 8.4 Tenant context in background jobs

Every job that touches tenant data extends `TenantAwareJob`, which serializes `{merchant_id, acting context (nullable system), correlation_id}` and **re-verifies at execution time** that the merchant is still in a state permitting the work (e.g. suspended merchants skip notification sends but never skip audit or billing enforcement jobs). A job constructed without tenant context that touches a `BelongsToMerchant` model fails immediately with `TenantContextMissingException` — this exact denied case is a required test (Scope §7 example 3).

### 8.5 Exports, notifications, webhooks, search preserve tenant scope

- **Exports:** generation runs inside the requester's tenant + permission scope snapshot; the artifact stores the scope; download re-checks permission at fetch time (`exports` table, §7.13); lost permission mid-generation → download blocked, artifact expired (Scope §39.7).
- **Notifications:** every notification row carries `merchant_id`; recipients resolve only through active memberships of that tenant; templates never interpolate foreign-tenant data (renderer receives a tenant-scoped payload DTO).
- **Outbound events (R&E):** payloads built by per-event DTO classes with an explicit field allowlist; a schema test asserts no forbidden fields (customer names, MSISDNs, staff lists, revenue detail).
- **Search:** Meilisearch documents carry `merchant_id` (and `branch_id`); every query is issued with a mandatory `filter: merchant_id = X [AND branch_id IN …]` applied server-side; the SPA never talks to Meilisearch directly (search proxied through the API). Unauthorized-scope queries return empty results (Scope §27.2).

### 8.6 Required denied-case examples (implemented as permanent tests)

| # | Denied case | Expected behavior | Test |
|---|---|---|---|
| 1 | User from Merchant A GETs `/api/v1/merchant/products/{ulid-of-B's-product}` | 404 non-disclosure; no existence hint; audit on pattern | `CrossTenantProductAccessTest` |
| 2 | Merchant A member with `catalogue.product.read` but not `catalogue.product.update` PATCHes a product | 403 `PERMISSION_DENIED`; denial logged | `PermissionDenialTest` |
| 3 | Background job dispatched without tenant context processing a tenant-owned resource | `TenantContextMissingException`; job fails, alert raised | `JobTenantContextTest` |
| 4 | Export endpoint invoked in a way that would produce unscoped records (forged filter params) | Scope snapshot ignores client filters beyond permitted scope; artifact contains only scoped rows | `ExportScopeTest` |
| 5 | API receives a valid public ULID belonging to another tenant on any nested route (`/orders/{A}/lines/{B-of-other-tenant}`) | 404; nested binding scoped to parent | `NestedBindingIsolationTest` |
| 6 | Cashier of Branch 1 lists orders of Branch 2 (same tenant) | Empty scoped result / 404 on direct access | `BranchIsolationTest` |
| 7 | Merchant A searches a product name that only exists in Merchant B | Zero results; no count leakage | `SearchIsolationTest` |
| 8 | End User requests another End User's order by ULID | 404 | `EndUserIsolationTest` |
| 9 | Merchant staff of A enumerates sequential-looking IDs | ULIDs are non-sequential; direct probing returns uniform 404s; rate limiter trips on pattern | `EnumerationResistanceTest` |
| 10 | Audit-role user attempts any mutation anywhere | 403; Audit is never an execution role | `AuditReadOnlyTest` |

---

## 9. Authentication Model

### 9.1 Merchant staff + Super Administrator: passwordless magic link (SR-11)

**Issuance flow (`POST /api/v1/auth/magic-link`):**
1. Input: email + surface (from Host). Response is always generic: *"If an account exists for this address, a sign-in link has been sent."* (no enumeration).
2. Server-side: resolve user by email for the surface audience; Super Administrator issuance additionally requires the `@citruslabs.co.ke` domain and an active "Approval for Citrus" registry entry (`platform_staff_registry` check).
3. Generate 256-bit random token; store SHA-256 hash in `auth_link_tokens` with audience, surface, optional tenant/role context, `expires_at = now() + 10 minutes` (single product-config value).
4. Queue `SendMagicLinkMail` (mandatory-category email). Rate limits: 3/email/10 min, 10/IP/10 min, 20/tenant/10 min; resend cooldown 60 s; abuse → temporary lockout with the same generic message.

**Consumption flow (`POST /api/v1/auth/magic-link/consume`):**
1. Hash the presented token; look up; expired → `AUTH_LINK_EXPIRED` (401); already consumed → `AUTH_LINK_REPLAYED` (401) + if replay is from a different device/IP fingerprint, terminate the session created by first use + security event + notification.
2. Verify audience/surface/tenant binding matches the request context.
3. Run the 8-point active-membership verification (Scope §13.2) for merchant users.
4. Regenerate session ID (fixation defense); create Sanctum SPA session; record device/IP fingerprint; anomalous first-use context (new device + new geography) → step-up verification before high-risk actions; issue security notification for new devices.
5. Mark token consumed. Multi-context users land on the context selector; single-context users land in their workspace.

**Step-up re-authentication:** `POST /api/v1/auth/step-up` re-issues a short-lived magic-link confirmation (or second-channel code where enabled); success stamps `sessions.elevated_until = now() + 10 minutes`. The `step-up` middleware requires an unexpired elevation for every "S"-marked action regardless of session age.

### 9.2 End Users: passwordless OTP (Scope §13.4)

- OTP (6 digits) to verified email and/or phone for registration, login, checkout finalization, and sensitive profile changes. Validity ≤ 5 minutes, single-use, 5 verify attempts, issuance rate limits (3/identifier/10 min, 10/IP/hour), lockout on abuse.
- Trusted devices: max 3, 90-day trust expiry, self-service revocation; checkout on an invalidated session is blocked pending fresh OTP.
- Guest checkout (merchant-enabled): contact verification (OTP) sufficient for order + receipt delivery without account creation; guest-to-registered claim flow links history on verified contact match with the customer's confirmation.

### 9.3 Session policy matrix (Scope §13.5 — enforced server-side)

| Surface | Idle timeout | Max session | Extras |
|---|---|---|---|
| Super Administrator | 15 min | 4 h (silent refresh within portal) | Single active session per device |
| Merchant privileged (Administrator, HR, Finance, Audit, Branch) | 10 min | 8 h | Step-up after idle re-entry to high-risk actions |
| Merchant operational (Cashier, Inventory, Personnel, Growth, CX) | 10 min (60-s client warning) | 12 h (shift-friendly) | POS lock-screen quick re-verification |
| End User | 30 min | 30 days remembered on trusted device | OTP re-verify at checkout + sensitive changes |

Implementation: per-surface session config resolved by role at login; a lightweight `EnforceSessionPolicy` middleware compares `last_activity`/`created_at` against the matrix; sensitive changes (email change, role change, membership change) invalidate the affected user's other sessions.

### 9.4 Revocation and continuous verification

`verified.membership` middleware runs the 8 checks on **every** request. Suspension, offboarding, role change, branch transfer, or leave-hold bumps the user's `permission_version` (Redis-cached) — stale sessions are forced through context re-resolution within 60 seconds (target), and in-flight requests fail with `MEMBERSHIP_INACTIVE`. Working-hours windows and period-of-access expiry are membership attributes evaluated in the same middleware.

### 9.5 CSRF, cookies, CORS

Sanctum SPA mode: `XSRF-TOKEN` cookie + `X-XSRF-TOKEN` header on every mutating call; session cookie `Secure; HttpOnly; SameSite=Lax`; `SESSION_DOMAIN=.citrus.ke` for merchant/End-User surfaces and a separate cookie domain for `citrus.citruslabs.limited`; CORS allowlist = exactly the SPA origins per environment; credentials mode locked to allowlisted origins.

---

## 10. Authorization, Roles, and Permissions Model

### 10.1 Mechanism

Laravel Policies + Gates backed by the first-party RBAC tables (§7.3). Spatie Laravel Permission is **not** used: the Scope requires per-membership scope (tenant × role × branch), permission-version stamping, plan-entitlement layering, acting-role context, and maker-checker semantics that exceed Spatie's model; a thin custom `PermissionResolver` (cached per membership + permission version) is simpler and testable. *(Documented exception per the technology-stack rule: the "mature package" option is satisfied by Policies/Gates, which are Laravel-native.)*

**Evaluation order on every request:** authentication → active-membership (8 checks) → tenant scope → branch scope → role permission (+ membership overrides like discount caps/pricing authority) → step-up requirement → maker-checker requirement → **plan entitlement** (`PLAN_ENTITLEMENT_DENIED` last, after permission — Scope §12.5) → execute.

### 10.2 Role hierarchy and the launch permission matrix

The complete Scope §12.2 matrix (12 roles × ~40 capability rows with ✔/✔*/A/S/— markers and T/B/O/P scopes) is the **binding enforcement contract**. Implementation requirements:

1. `database/seeders/PermissionMatrixSeeder.php` encodes every cell. The seeder file carries the matrix as structured data; a snapshot test (`PermissionMatrixSnapshotTest`) fails if code drifts from the Scope matrix.
2. Constraint markers become code: `✔*` constraints (e.g. "within granted authority", "not self-recorded", "only if no HR exists", "masked") are policy predicates, not seeder flags.
3. `S` markers map to `requires_step_up`; `A` markers map to `requires_maker_checker` with the §12.4 maker/checker/fallback triple.
4. Non-delegable permissions (Scope §12.3) are flagged `delegable=false`; delegation endpoints refuse them.
5. Multi-role users (SME): permissions remain explicit per role; the session carries **one acting role context** at a time; an action allowed to Finance and denied to Inventory is denied in Inventory context (Scope §9.3). Context switching is instant (no re-login) but audited.

### 10.3 Key role boundaries (enforced in policies, verbatim from the Scope)

- **Super Administrator:** platform governance only. Cannot create merchants, execute merchant operations, edit merchant staff attributes, record/fabricate payment states, modify audit records, or clear non-billing suspensions via billing actions. High-risk actions: step-up + reason + two-step confirm + second-Super-Admin maker-checker where available.
- **Merchant Administrator:** root tenant governance; operational actions only under explicitly self-assigned roles with acting-context recording; cannot approve own high-risk actions where another eligible approver exists; last-Administrator removal blocked.
- **Branch role:** branch governance surface for named humans; supervisory-only when HR exists; creates staff **only when no active HR user exists**; never executes POS/inventory/validation under the Branch role.
- **HR:** provisions staff within the Administrator-approved branch structure; cannot self-escalate, assign/modify the Administrator role (profile photo only), or touch payroll disbursement.
- **Finance:** validates/rejects evidence (never own-recorded — DB CHECK + policy); read-only on Citrus subscription billing; can never unlock billing restrictions manually.
- **Cashier:** shift-bound execution; no force-confirm of failed/flagged evidence; cannot close a shift with unverified/unescalated evidence, held carts, or pending-ready online orders (closure gates).
- **Inventory:** never sets selling prices; posted movements immutable; sensitive adjustments above threshold require maker-checker.
- **Growth:** pricing only where merchant-assigned pricing authority exists; no POS, no evidence, no manual loyalty points, no unmasked PII exports.
- **CX:** consent-bound communications; no prices/discounts/payment links in messages; request-initiation only for returns/refunds.
- **Audit:** read-only everywhere; exports integrity-hashed; auditor activity itself audited; can annotate flagged events without altering source records.
- **Personnel:** own-scope only (profile, schedule, assigned work, own attendance/KPIs, limited stock issue where explicitly granted).
- **End User:** own records + storefront surface only.

### 10.4 Ownership transfer, account removal, invitation flows

- **Additional/transfer of Merchant Administrator:** existing Administrator appoints another (step-up + high-severity audit); removal of the last active Administrator is blocked; loss-of-access recovery goes through the Scope §39 support workflow (verified support case, never a database edit).
- **Staff invitation:** HR (or Administrator; or Branch when no HR) issues an invitation → email with accept link (rate-limited) → invitee verifies email → membership `invited → active`. Expired/revoked invitations cannot be accepted; email change re-issues.
- **Offboarding:** HR action → membership `offboarded`, sessions revoked ≤ 60 s, assignments closed, history retained; rehire = new membership.
- **Permission changes:** every grant/revoke writes `membership_events` with before/after and bumps permission version; recertification cycles (configurable) flag overdue reviews to Audit.

### 10.5 Where authorization is enforced (checklist bound to CI)

Backend controllers (policy per action) · API endpoints (route→policy map test asserts no unguarded mutating route) · form submissions (FormRequest `authorize()`) · background jobs (Action re-checks inside job) · export/download endpoints (generation + fetch-time re-check) · admin screens (platform permission set) · billing/settings (Administrator + step-up) · invitation/removal (HR/Administrator per matrix) · machine channels (HMAC identity + scope) · frontend checks are UX only.

---

## 11. API Design

### 11.1 Route architecture (`/api/v1`, versioned; breaking changes only in `/api/v2`)

```php
// routes/api_v1_auth.php  — throttle:auth tiers
POST   /api/v1/auth/magic-link                 // issue (generic response)
POST   /api/v1/auth/magic-link/consume
POST   /api/v1/auth/otp                        // End-User OTP issue
POST   /api/v1/auth/otp/verify
POST   /api/v1/auth/step-up                    // elevation
GET    /api/v1/auth/contexts                   // memberships available to this identity
POST   /api/v1/auth/context                    // select tenant/role/branch context
DELETE /api/v1/auth/session                    // logout
GET    /api/v1/auth/sessions                   // list own sessions/devices
DELETE /api/v1/auth/sessions/{session}         // terminate

// routes/api_v1_merchant.php — middleware: auth:sanctum, verified.membership,
//   context.tenant, throttle:merchant, recovery.allowlist (billing-gated)
POST   /api/v1/merchant/register               // public: self-registration (throttle:registration)
GET    /api/v1/merchant/onboarding             // checklist state
GET|PUT /api/v1/merchant/profile               // settings (Administrator)
GET|POST /api/v1/merchant/branches             // + PUT /{branch}, POST /{branch}/status  (S)
GET|POST /api/v1/merchant/staff/invitations    // + POST /invitations/{invitation}/revoke
GET|POST /api/v1/merchant/staff/memberships    // + PUT /{membership}, POST /{membership}/status
GET|POST /api/v1/merchant/catalogue/products   // + /{product}, /skus, /prices, /import, /export
GET|POST /api/v1/merchant/inventory/movements  // receipts/transfers/adjustments/counts (A on sensitive)
GET    /api/v1/merchant/inventory/levels
GET|POST /api/v1/merchant/inventory/suppliers
POST   /api/v1/merchant/pos/sales              // idempotency-required
POST   /api/v1/merchant/pos/sales/{sale}/complete
GET|POST /api/v1/merchant/pos/shifts           // open; POST /{shift}/close (gated)
GET    /api/v1/merchant/orders                 // branch queue; POST /{order}/status
GET|POST /api/v1/merchant/quotes               // Growth; POST /{quote}/send|accept-handoff
POST   /api/v1/merchant/payment-evidence       // record (Cashier/Finance) — idempotency-required
POST   /api/v1/merchant/payment-evidence/{record}/validate   // Finance, recorder≠validator
POST   /api/v1/merchant/payment-evidence/{record}/reject
GET|POST /api/v1/merchant/refund-records       // maker-checker approval
GET|POST /api/v1/merchant/customers            // + merge (governed), notes (append-only)
GET|PUT /api/v1/merchant/loyalty/program       // Growth/Admin config (A)
GET    /api/v1/merchant/loyalty/accounts/{account}/ledger
POST   /api/v1/merchant/loyalty/adjustments    // proposal→approval (never single-operator)
GET|POST /api/v1/merchant/promotions           // + coupons (A above guards)
GET|POST /api/v1/merchant/cx/cases · /cx/messages · /cx/campaigns
GET|POST /api/v1/merchant/staffops/attendance · /leave · /schedules · /kpis
GET|POST /api/v1/merchant/staffops/payroll-periods  // + POST /{period}/approve-lock (HR, A)
GET|POST /api/v1/merchant/finance/expenses · /periods (lock/reopen: S+A) · /cash-up-reviews
GET    /api/v1/merchant/billing/subscription   // + POST /plan (S) — select/upgrade/downgrade
GET    /api/v1/merchant/billing/invoices       // + GET /{invoice}
POST   /api/v1/merchant/billing/invoices/{invoice}/stk-attempts   // Wallet STK (cooldown, lock)
GET    /api/v1/merchant/billing/invoices/{invoice}/payment-status
GET    /api/v1/merchant/entitlements
GET    /api/v1/merchant/reports/{report}       // + POST /exports (S where full), GET /exports/{export}/download
GET    /api/v1/merchant/audit/events           // Audit role surfaces (read-only, masked)
GET    /api/v1/merchant/notifications          // + POST /{notification}/read

// routes/api_v1_storefront.php — public + auth:sanctum(end_user), throttle:storefront
GET    /api/v1/storefront/merchants            // Find Merchants (suspended excluded; no ranking)
GET    /api/v1/storefront/{merchant}/catalog   // branch-scoped
GET|POST /api/v1/storefront/{merchant}/cart    // branch-locked
POST   /api/v1/storefront/{merchant}/checkout  // OTP-verified; reference capture; idempotent
GET    /api/v1/storefront/account/orders · /receipts · /deliveries · /profile · /security

// routes/api_v1_platform.php — Super Administrator, platform permission set
GET    /api/v1/platform/dashboard · /merchants · /merchants/{merchant}
POST   /api/v1/platform/merchants/{merchant}/onboarding-decision   // approve/reject (S)
POST   /api/v1/platform/merchants/{merchant}/status                // suspend/reinstate (S + A)
GET|POST /api/v1/platform/plans                // + versions, entitlements (S)
GET    /api/v1/platform/billing/exceptions     // + POST /{exception}/resolve-by-linkage (S)
GET    /api/v1/platform/integrations/health    // Wallet + R&E dashboards
GET    /api/v1/platform/audit/events
POST   /api/v1/platform/users/{user}/security-action  // lock/force-logout/clear-devices (S)

// routes/api_v1_machine.php — signed channels only (no Sanctum)
POST   /api/v1/integrations/wallet/webhooks              // signed.wallet pipeline
POST   /api/v1/integrations/refer-earn/reconciliation/query   // signed.re pipeline
GET    /api/v1/health · /api/v1/health/deep              // health checks (§26)
```

### 11.2 Request validation

Every mutating endpoint has a FormRequest: authorization hook (policy call), typed rules, tenant-aware uniqueness rules (`Rule::unique('skus','sku_code')->where('merchant_id', $ctx->merchantId)`), and normalized error attribute names matching frontend field names. Cross-field/state validation (e.g. "quantity ≤ available stock under prohibit policy") lives in the Action to keep it transactional.

### 11.3 Response resources

`JsonResource` per aggregate; public IDs only; masked fields masked at the resource layer (single `MaskedValue` helper — e.g. `+2547•••••42`, `RTG•••XK2`); money serialized as `{ amount_minor, currency, formatted }`; state fields as enum strings; timestamps ISO-8601 UTC with a `business_date` companion where the UI shows EAT dates.

### 11.4 Pagination, filtering, sorting

- Cursor pagination default (`?cursor=…&per_page=25`, max 100) for high-volume ledgers; page pagination for small config lists. **Every collection endpoint paginates — no unbounded lists.**
- Filtering via an explicit per-endpoint allowlist (`?filter[status]=active&filter[branch]=brn_…`); unknown filter keys → 422. Filters never widen scope beyond the caller's permissions.
- Sorting via allowlisted `?sort=-completed_at` fields backed by indexes.

### 11.5 Rate limiting tiers (Redis-backed)

| Tier | Limit (default, config-tunable) | Applies to |
|---|---|---|
| `auth` | 3/email/10 min issue; 10/IP/10 min; verify 5 attempts | magic link, OTP |
| `registration` | 3/IP/hour, 10/IP/day | merchant + End-User registration |
| `invitation` | 10 accepts/IP/hour | invitation acceptance |
| `merchant` | 240/min per user | authenticated staff APIs |
| `pos` | 600/min per user | POS burst headroom |
| `storefront` | 120/min per session/IP | public catalog + checkout |
| `coupon` | 10 attempts/customer/hour | code brute-force defense |
| `export` | 5 concurrent + 20/day per user | export generation |
| `machine-wallet` / `machine-re` | per contract | inbound signed channels |

429 responses carry `Retry-After`; repeated tripping raises an abuse-pattern security event.

### 11.6 Structured error envelope (all non-2xx)

```json
{
  "error": {
    "code": "INSUFFICIENT_STOCK",
    "message": "Not enough stock to complete this action.",
    "correlation_id": "corr_01JD8G2K7Q3W…",
    "retryable": true,
    "details": { "sku": "sku_01JD…", "available": 2 },
    "fields": { "lines.0.quantity": ["Only 2 available."] }
  }
}
```

Codes are exactly the Scope §38 catalogue (plus module-level validation codes). `details` never contains foreign-tenant identifiers, stack traces, SQL, or provider internals. A contract test walks the catalogue asserting code ↔ HTTP status ↔ retryability mapping.

### 11.7 API logging

Structured JSON request logs: method, path template (not raw path — avoids ID leakage into log indexes), status, duration, user public ID, merchant public ID, correlation ID, rate-limit tier. Bodies never logged on auth/evidence/billing endpoints; elsewhere logged only field names on validation failure. Machine-channel requests log signature verification outcomes.

### 11.8 OpenAPI

`docs/api/openapi.yaml` generated from attributes/annotations; CI validates the spec and diff-checks for breaking changes; TypeScript client types generated from it (§6.1).

---

## 12. UI/UX Design System

One design system (`resources/js/components/ui` + `styles/tokens.css`) across all account surfaces (Scope §35.1). Apple HIG-inspired discipline: clear hierarchy, minimal clutter, consistent spacing/typography, purposeful motion only.

### 12.1 Design tokens (CSS custom properties; Tailwind consumes via `theme.extend`)

```css
:root {
  /* Color primitives */
  --citrus-orange-50…900;  --neutral-0…950;  --green-*, --red-*, --amber-*, --blue-*;

  /* Semantic tokens (light theme defaults) */
  --color-bg-canvas: var(--neutral-50);      --color-bg-surface: #fff;
  --color-bg-raised: #fff;                   --color-bg-sunken: var(--neutral-100);
  --color-text-primary: var(--neutral-900);  --color-text-secondary: var(--neutral-600);
  --color-text-disabled: var(--neutral-400); --color-border: var(--neutral-200);
  --color-border-strong: var(--neutral-300); --color-accent: var(--citrus-orange-600);
  --color-accent-hover: var(--citrus-orange-700);
  --color-success / --color-warning / --color-danger / --color-info;
  --color-focus-ring: var(--blue-500);

  /* Type scale (rem; scales with browser zoom) */
  --text-xs: .75rem; --text-sm: .875rem; --text-base: 1rem;
  --text-lg: 1.125rem; --text-xl: 1.25rem; --text-2xl: 1.5rem; --text-3xl: 1.875rem;
  --font-family-ui: 'Inter var', system-ui, sans-serif;

  /* Spacing scale: 4px base — space-1(4) … space-16(64) */
  /* Radii: --radius-sm 6px, --radius-md 10px, --radius-lg 16px, --radius-full */
  /* Elevation: --shadow-sm/md/lg;  Motion: --duration-fast 120ms, --duration-base 200ms,
     --ease-standard cubic-bezier(.2,0,0,1) */
}
[data-theme="dark"] { /* semantic tokens remapped — see §14 */ }
@media (prefers-reduced-motion: reduce) { * { animation-duration:.01ms!important; transition-duration:.01ms!important; } }
```

Rule: components consume **semantic tokens only** — never raw palette values. This makes dark mode a token remap, not a component rewrite.

### 12.2 Component inventory and state contracts

| Component | States/spec |
|---|---|
| `CButton` | variants primary/secondary/destructive/ghost; states default/hover/focus-visible (2px ring, 2px offset)/active/disabled (reduced contrast + `cursor-not-allowed` + `aria-disabled`)/loading (spinner + retained width + `aria-busy`, click-suppressed). Min touch target 44×44 pt on tablet/mobile. |
| `CInput` / `CSelect` / `CTextarea` / `CDatePicker` | Label always rendered above (never placeholder-as-label); required marker `*` + `aria-required`; states empty/populated/focus/disabled/readonly/error (red border + `aria-invalid` + message linked via `aria-describedby`)/success (subtle check). |
| `CFormField` | Wrapper wiring label↔input↔hint↔error IDs; renders server validation errors mapped by field name. |
| `CTable` | Sticky header, sortable columns (allowlisted), row density options, pagination footer, loading skeleton rows, empty state slot, error state slot; responsive collapse per §13. |
| `CModal` / `CDrawer` | Focus trap, `Esc` close, initial focus, focus restore, `aria-modal`, scroll lock; destructive confirms use `CConfirmDialog` (typed confirmation for high-risk); `CStepUpDialog` embeds the elevation flow. |
| `CToast` | Success/info/warning/error; auto-dismiss except errors; `role="status"`/`role="alert"` live regions; action slot (e.g. "Retry"). |
| `CBadge` | State-machine aligned status badges (one color mapping per state enum, shared constant). |
| `CEmptyState` | Icon + explanation + primary action ("No products yet → Add your first product"). |
| `CSkeleton` | Shape-matched loading placeholders. |
| `CCard`, `CTabs`, `CPagination`, `CFileUpload` (drag-drop, progress, type/size pre-validation mirroring server rules), `CSearchInput` (debounced, scope-safe API), `CMoney` (single money formatter), `CAuditStamp` (who/when on governed records). |

### 12.3 Layout regions (preserved on every authenticated surface)

Header (tenant/branch/role context + global search + notification bell + profile unit) · Sidebar (role-filtered navigation with grouped modules; collapsible) · Content (page header with title/breadcrumb/primary action; body) · Toast region · (POS surface swaps to `PosLayout`: full-screen, cart-right/catalog-left desktop, stacked mobile). CSS never removes, renames, hides, or structurally misrepresents required content or navigation relationships — DOM structure carries the hierarchy; styling only presents it.

### 12.4 Navigation hierarchy per role (route-tree = sidebar source of truth)

Sidebar items derive from the route tree filtered by the permission snapshot; a route absent from permissions is absent from navigation (UX) *and* still policy-guarded (security). Example — Cashier sidebar: Dashboard · POS · Online Orders · Transactions (own shift) · Payments (evidence queue) · End Shift · History · Notifications · Profile. Example — Finance: Dashboard · Payments & Validation · Invoices & Receipts · Refunds & Disputes · Expenses · Cash-Up Reviews · Periods · Reports · Citrus Billing (read-only) · Notifications · Profile.

---

## 13. Responsive Layout Strategy

### 13.1 Breakpoints (exact, CSS-only)

```css
/* tailwind.config.ts screens */
screens: { md: '768px', lg: '1025px' }
/* Mobile ≤767 = base styles; Tablet 768–1024 = md; Desktop ≥1025 = lg */
```

Rules (binding): no JS viewport branching for layout (ESLint rule §6.7); no device/user-agent detection; layout adapts live during resize; no horizontal scroll on normal content (`overflow-x` audits in E2E); no overlap/clipping; touch targets ≥ 44×44 pt below `lg`; typography/spacing scale via rem tokens; `<meta name="viewport" content="width=device-width, initial-scale=1">` — never `user-scalable=no`.

### 13.2 Per-surface strategies

| Surface | Desktop ≥1025 | Tablet 768–1024 | Mobile ≤767 |
|---|---|---|---|
| Dashboard | 12-col grid; KPI cards 4-up; charts 2-up | KPI 2-up; charts full-width | KPI stacked 1-up; charts full-width, legends below |
| Sidebar | Fixed 260px, always visible | Collapsed to 64px icon rail; expand on toggle | Off-canvas drawer over content; hamburger in header; focus-trapped when open |
| Header | Full context bar + search + profile | Search collapses to icon | Context switcher moves into drawer; profile unit persists |
| Data tables | Full table | Column-priority: low-priority columns hidden behind a row expander | Card list transform (each row → labeled card) or scroll-contained region with sticky first column — per-table choice, no page-level horizontal scroll |
| Forms | 2-col field grid for short fields | 2-col only for tightly related pairs | Single column; sticky submit bar |
| POS | Catalog left / cart right split | Same split, larger targets | Tabbed Catalog ⇄ Cart; fixed bottom action bar; one-hand reachable primary actions |
| Settings pages | Side-tab layout | Top tabs | Accordion sections |
| Profile menu | Anchored dropdown card | Same | Full-width sheet from header |
| Modals | Centered, max-w-lg/xl | Centered, wider margins | Full-screen sheet |
| Billing screens | Invoice table + detail pane | Stacked detail | Card list; pay actions full-width |
| Team management | Table + side detail drawer | Drawer overlays | Card list + full-screen detail |
| Storefront/checkout | 2-col (cart summary sticky right) | Stacked; summary collapsible | Mobile-first single column; sticky checkout CTA |

### 13.3 Verification

Playwright runs the responsive suite at 1280×800, 834×1112, and 390×844 asserting: no `document.documentElement.scrollWidth > innerWidth`, sidebar behavior, table transforms, and touch-target sizes (bounding-box ≥ 44px) on core flows (login, POS sale, checkout, billing, team management).

---

## 14. Dark Mode Strategy

1. **Token strategy:** `[data-theme="dark"]` on `<html>` remaps every semantic token (e.g. `--color-bg-canvas: var(--neutral-950)`, `--color-bg-surface: var(--neutral-900)`, `--color-text-primary: var(--neutral-100)`, borders one step lighter than surface — **borders never disappear**). Focus rings, validation reds, success greens, and status badges get dark-calibrated variants that keep ≥ 4.5:1 text and ≥ 3:1 UI-component contrast.
2. **Default and toggle:** light is default. `ThemeToggle` (header + profile menu + settings) cycles light → dark → system. `system` follows `prefers-color-scheme` reactively.
3. **Persistence:** authenticated users → `users.theme_preference` via `PATCH /api/v1/auth/preferences` (per user, all devices); anonymous storefront visitors → `localStorage`.
4. **Flash prevention:** an inline `<script>` in the Blade SPA shell (before CSS paint, CSP-nonced) reads `localStorage.theme` (mirrored on login from the server value) and sets `data-theme` synchronously — no white flash into dark mode.
5. **Non-negotiables verified per component:** dark mode never reduces readability, never hides focus states, borders, validation errors, or interactive affordances.
6. **Testing:** Storybook-style component gallery page rendered in both themes; Playwright captures both-theme screenshots of core screens; axe contrast checks run against both themes; a token-lint script fails CI if any component uses a raw palette value.

---

## 15. Accessibility Strategy (WCAG 2.2 AA, practical)

| Area | Implementation |
|---|---|
| Keyboard | Every interactive element reachable/operable by keyboard; logical tab order; skip-to-content link; roving tabindex in menus; no keyboard traps (modal focus trap releases on close). |
| Focus | `:focus-visible` ring (2px, offset, both themes); focus restored to trigger after modal/drawer close; focus moved to first error on failed submit. |
| Contrast | AA: 4.5:1 text, 3:1 large text/UI components — enforced by token design + axe CI checks in both themes. |
| Forms | Real `<label for>` on every input; placeholders never replace labels; errors linked via `aria-describedby` + `aria-invalid`; required via `aria-required` + visible marker; grouped fields use `<fieldset>/<legend>`. |
| Names | Buttons/links have discernible text or `aria-label` (icon buttons); `CTable` uses proper `<th scope>`; charts ship an accessible data-table/text equivalent toggle. |
| Touch | ≥ 44×44 pt targets below `lg` (checked in E2E). |
| Zoom | rem-based layout; usable at 200% zoom and 320px-wide reflow; viewport scaling never disabled. |
| Motion | `prefers-reduced-motion` collapses all transitions/animations (§12.1). |
| Screen readers | Landmarks (`header/nav/main/aside`); heading hierarchy per page; toasts in `role="status"`/`role="alert"` live regions; async status changes announced via `useLiveRegion`; modals `aria-modal` with labelled titles; menus/comboboxes follow WAI-ARIA APG patterns. |
| Language | `<html lang="en">`; localization-ready copy structure. |

**Verification steps:** axe-core automated pass in component tests + Playwright page scans (0 serious/critical violations gate); manual keyboard-only walkthrough scripts for the 8 core flows (login, context switch, POS sale, checkout, evidence validation, billing payment, team invite, report export); NVDA + VoiceOver smoke pass on login, POS, checkout, and billing before launch; zoom/reflow manual check at 200%/400%.

---

## 16. Forms and Input Behavior Strategy

1. **State machine per form:** `idle → editing(dirty) → submitting → succeeded | failed(fieldErrors|formError)`. `useForm` composable owns it; CSS styles states; JS/backend control transitions (CSS is never behavior logic).
2. **Duplicate-submit prevention:** submit disabled + `aria-busy` during `submitting`; commerce forms additionally send an `Idempotency-Key` generated at form-open so a double-click or network retry replays the original result (`SALE_DUPLICATE_SUBMISSION` semantics).
3. **Server-side validation mapping:** 422 envelope `fields` keys match input names 1:1; `useForm` distributes messages to `CFormField`s, focuses the first errored field, and preserves all user input. Unmapped errors render in a form-level alert.
4. **Long forms:** sectioned with sticky section nav (desktop) / accordion (mobile); catalogue entry and onboarding forms auto-save drafts (drafts registry) every 10 s and on blur; unsaved-changes navigation guard (`beforeunload` + router guard) with explicit discard confirm.
5. **Sensitive fields:** national IDs, phone numbers, payment references rendered masked with explicit reveal (permission-checked, audited); never overemphasized visually; never echoed into logs or analytics.
6. **Required/optional:** required marked with `*` and legend "Fields marked * are required"; optional fields labeled `(optional)` when the form is mostly required.
7. **Destructive/high-risk:** `CConfirmDialog` with explicit consequence copy; step-up dialog where the matrix demands; reason field mandatory where the Scope demands (suspensions, adjustments, overrides).
8. **Empty/reset:** cleared forms return to pristine `idle`; error remnants cleared; success state shows toast + optimistic navigation or inline confirmation, never a dead-end.

---

## 17. User Profile and Account UI Strategy

1. **Profile unit (header):** avatar (photo or initials) + name + current context line ("Naivas Ltd · Westlands Branch · Cashier") rendered as one cohesive control (`ProfileUnit.vue`): single hover/focus surface, `cursor-pointer`, visible focus ring, `aria-haspopup="menu"`.
2. **Preview card:** opens anchored to the unit (Floating UI positioning with collision detection — never clips viewport, never covers the primary action bar); contains identity summary, current role context, theme toggle, links: My Profile · Sessions & Devices · Switch Context · Sign out. Keyboard: `Enter/Space` open, arrows navigate, `Esc` closes and restores focus.
3. **Context switcher:** lists only permitted memberships (tenant × role × branch) grouped by merchant; selecting calls `POST /api/v1/auth/context`; switch is audited; POS with an open shift blocks context switch until shift handoff/close.
4. **My Profile page:** identity + contact (verification required on change — magic-link/OTP re-verify), profile photo upload (validated per §19), notification preferences (mandatory categories locked), theme preference, active sessions with terminate buttons, login history (role-appropriate retention), trusted devices (End Users only).
5. **Separation of concerns:** CSS styles the unit; click/open behavior is component logic; no CSS-hover-only disclosure of interactive content (touch parity).

---

## 18. Billing and Plan Enforcement Strategy

### 18.1 Plan catalog and entitlements

Super Administrator governs plans, versions (immutable once subscribed), prices (KES minor units), intervals (monthly; annual per D-04), trials, platform promotions, and per-version entitlements (§7.10). Commercial numbers come from D-04; the mechanism is complete regardless.

### 18.2 Entitlement enforcement (single choke point)

`EntitlementsService::check(merchant, key, requestedDelta = 1)` is the only evaluation path, called by the `entitlement:{key}` middleware, Actions (imports/branch creation/staff provisioning/report scheduling), background jobs, and export generation — **identical semantics across UI, API, jobs, imports, exports, integrations** (Scope §20.4). Denial → `PLAN_ENTITLEMENT_DENIED` (403) with `details.upgrade_path`. Downgrades never destroy data: over-limit resources become read-only (flagged `over_entitlement`) until within limits. Entitlement snapshot is Redis-cached per merchant, invalidated on plan events.

### 18.3 Subscription lifecycle engine

State machine per Scope §20.2 driven by three inputs: scheduler (renewal invoice issuance ahead of period start; grace transitions on due-date breach), Wallet events (payments/reversals), merchant actions (plan select/upgrade/downgrade/cancel — upgrade effective per D-04 with proration line items; downgrade scheduled at renewal).

**Enforcement ladder:** `active → overdue` (due date passed; reminders) `→ read_only_grace` (configured grace days; mutations blocked; reads allowed; new exports/reports blocked) `→ suspended_billing` (recovery allowlist only). `recovery.allowlist` middleware implements Scope §20.6: billing pages, invoice viewing, Wallet payment initiation, own-tenant export (Administrator + step-up), support contact, read-only history — everything else → `BILLING_RESTRICTED`. **Fairness rule:** grace escalation pauses during verified Wallet-side payment unavailability and resumes on recovery (`billing_enforcement_events` records the pause).

**PR-9 invariant (tested):** payment application evaluates *only* the billing dimension. `MerchantBillingRecovered` listener checks `operational_status`/`compliance_status` untouched; a merchant suspended for fraud who pays remains operationally suspended (`W-21`-class test, Scope §39.5).

### 18.4 Invoice → Wallet payment flow (merchant-facing, Scope §21.3)

1. Renewal/creation issues `subscription_invoices` row (`issued → pending_payment`) with line items; `RegisterInvoiceWithWalletJob` registers the Wallet payment resource (idempotent; retry with backoff; instructions show "pending" until registered).
2. Billing page shows: amount due, due date, line items, state, structured reference `{PREFIX}-PAY-…`, PayBill/Till/bank instructions verbatim from Wallet, and the STK form (M-PESA phone; 90-s per-invoice cooldown; `subscription_invoice_payment_locks` prevents concurrent attempts; retry only from terminal failed/expired/cancelled states; `UNKNOWN` blocks new attempts and shows "confirming — this can take a few minutes").
3. States shown map 1:1 from Wallet; Citrus never invents success.
4. Application outcomes: partial → `partially_paid`, balance payable; overpayment → `paid` + credit auto-applied next invoice; duplicate funds blocked by event dedup; late payment to cancelled/expired invoice → exception queue for Super Administrator linkage or credit — funds never discarded.
5. Restoration: automatic on authoritative `paid` allocation, billing-only reasons.

### 18.5 Billing surfaces per role

Merchant Administrator: full billing management (plan change S-gated, invoices, pay). Finance: read-only invoices + payment states (+ pay where delegated); can never edit rates/invoices/enforcement. Audit: read-only. Super Administrator: platform billing summaries, exception queue (linkage-only resolution, step-up), plan governance. **No manual "mark paid" exists anywhere — verified by route-absence test.**

---

## 19. File Upload and Storage Strategy

| Concern | Implementation |
|---|---|
| Accepted types | Images: jpeg/png/webp (≤ 10 MB); documents: pdf (≤ 25 MB); imports: csv (≤ 20 MB, ≤ 50k rows launch). Per-class allowlists in `config/files.php`. |
| Validation | Triple check server-side: extension allowlist + client-declared MIME + magic-bytes sniff (finfo) must agree; mismatch → `FILE_REJECTED` (422). Image files re-encoded (strips payloads/EXIF); SVG uploads rejected at launch. |
| Malware scanning | Upload lands in `quarantine/` prefix with `scan_status=pending`; `ScanUploadedFileJob` calls the scanning service (ClamAV container or SaaS behind a `MalwareScanner` contract); `clean` → promoted to tenant path; `infected` → quarantined, high-severity audit + alert, uploader notified generically. Files are unavailable until clean. |
| Storage layout | Private bucket: `merchants/{merchant_ulid}/{class}/{ulid}.{ext}`; platform files under `platform/…`; public-cacheable storefront media in a separate public bucket behind CDN with immutable cache keys. Nothing private is ever web-root-served. |
| Authorization | Upload: policy check (class-appropriate permission + entitlement `storage_mb` + tenant context). Download: `GET /api/v1/files/{file}/download-url` re-checks permission at issuance and returns a signed URL (TTL 5 min, single content-disposition); direct bucket paths never exposed. |
| Tenant enforcement | `files.merchant_id` + path prefix + scoped queries; cross-tenant file probes → 404. |
| Sensitive-file audit | Staff documents and exports log issuance + download (who/when/IP) as audit events. |
| Cleanup | `GarbageCollectOrphanFilesJob` weekly (unreferenced > 7 days); export artifacts expire at 30 days; retention/legal-hold aware deletion (§7.14). |
| Abuse tests | Oversize, wrong-magic-bytes, double-extension (`invoice.pdf.exe`), EICAR test file, cross-tenant download probe, expired signed URL, permission-revoked re-download — all in the file-security suite. |

---

## 20. Queue, Jobs, Notifications, and Scheduled Task Strategy

### 20.1 Queues (Redis + Horizon)

| Queue | Workload | Concurrency/notes |
|---|---|---|
| `critical` | Wallet webhook processing, billing enforcement, session revocation fan-out | Highest priority; low latency |
| `integrations` | R&E outbox delivery, Wallet registration/status queries, reconciliation | Backoff-aware |
| `mail` / `sms` | Magic links, OTPs, receipts, notices | OTP/magic-link jobs get `retryUntil` ≤ token TTL (no stale link delivery) |
| `default` | Domain side effects (loyalty accrual, search indexing, audit fan-out) | |
| `heavy` | Reports, exports, imports, PDF generation | Concurrency-capped; memory-bounded |
| `low` | Cleanup, GC, recertification reminders | |

Job standards: all jobs idempotent (keyed by source record/event ID); `tries`/`backoff` explicit per class; `failed()` hooks record context + notify per severity; `failed_jobs` monitored with alert thresholds; Horizon dashboard behind platform-ops auth; dead-lettered integration events use the controlled replay path (original event IDs preserved).

### 20.2 Scheduler (single `schedule:run` container, `onOneServer`)

| Schedule | Job |
|---|---|
| Every minute | `ReleaseExpiredReservationsJob`, queue health metrics |
| Every 10 min | `QueryStaleWalletAttemptsJob` |
| Hourly | `ReconcileReEventGapsJob`, `EscalateBillingStatesJob` (grace ladder + fairness pause), abandoned-cart lead generation |
| Daily | `NightlyWalletAllocationReconciliationJob`, `IssueRenewalInvoicesJob` (lead-time window), low-stock digest, `PurgeExpiredArtifactsJob`, backup verification, `ExpireAbandonedRegistrationsJob` (D-02) |
| Monthly (after month close + clearing grace) | `EvaluateActiveUseQualificationJob` (per attributed merchant; emits decisions) |
| Configurable | Scheduled reports (entitlement-gated), access-recertification cycle openers, dormancy-to-archival sweep (D-03) |

### 20.3 Notifications

Catalogue implemented exactly per Scope §28.1 (security, identity, branch, inventory, orders/sales, customers, finance, subscription, integration, compliance, reports). Channels: in-app (all, mandatory categories locked), email (staff + End Users), SMS (End-User OTP/transactional; merchant campaign messages consume plan-entitled bundles per D-08). Behavior rules: preferences control non-mandatory categories only; delivery retry with backoff + provider failover; **dedup key = (logical event, channel, recipient)** unique constraint; versioned centrally-managed templates (English at launch, localization-ready); consent checked at send time for marketing; all sends audit-logged with template version and outcome; retention per §7.14.

---

## 21. Search Strategy

- **Engine:** Meilisearch via Laravel Scout. Indexes: `products_{env}` (name, sku codes, category, status; filterables `merchant_id, branch_availability, status`), `customers_{env}` (masked-appropriate fields; filterable `merchant_id`), `orders_{env}` (reference, customer link, status; filterable `merchant_id, branch_id`), `merchants_public_{env}` (Find Merchants: name, category, branch towns; only `active` + storefront-enabled + not operationally suspended merchants are indexed — suspended merchants are removed within 60 s via model observers).
- **Scope safety:** the SPA never queries Meilisearch directly. `GET /api/v1/merchant/search?q=…` injects mandatory tenant/branch filters server-side from `TenantContext`; End-User Find Merchants queries only the public index; results are re-filtered against read permissions before serialization (belt and braces). Unauthorized scopes → empty results, no counts.
- **Freshness:** Scout syncs on model events through the `default` queue; target ≤ 60 s from write (Scope §36.2); a nightly `AuditSearchIndexJob` samples index-vs-DB drift.
- **No cross-merchant ranking:** Find Merchants returns name/category matches with branch listings — no relevance boosting by sales volume, no ratings, no comparison (Scope §18.4).
- **Degradation:** Meilisearch outage → `SEARCH_UNAVAILABLE` on search endpoints; DB-backed list/filter endpoints unaffected.

---

## 22. Observability and Audit Logging Strategy

### 22.1 Structured logging

JSON logs (Monolog formatter) → stdout → log shipper → centralized store. Every line: timestamp, level, message, `correlation_id`, `user_public_id`, `merchant_public_id`, module, and context. **Scrubber processor** removes/masks: tokens, OTPs, magic links, secrets, external payment references, national IDs, MSISDNs. Log-injection defense: newlines stripped from user-controlled values.

### 22.2 Error tracking and metrics

Sentry (backend + SPA) with `before_send` scrubbing, release tagging, correlation-ID tag. Prometheus metrics: HTTP p50/p95/p99 per route group, DB slow-query count (`log_min_duration_statement=500ms` → alert), queue depth/latency per queue, failed-jobs rate, webhook verification failures, outbox lag and dead-letter depth, STK attempt outcomes, entitlement denials, rate-limit trips, login-failure rates, search freshness. Grafana dashboards: Platform health · Queue health · Wallet integration · R&E integration · Billing enforcement · Security events.

### 22.3 Alerting (Scope §37.2 severity model)

| Severity | Triggers | Response |
|---|---|---|
| Critical (page immediately) | Cross-tenant exposure signal, `WALLET_PAYMENT_REUSED`/`WALLET_AMOUNT_MISMATCH`, audit-chain verification failure, `EVENT_ID_PAYLOAD_MISMATCH`, platform outage, malware detection | Incident opened per §37.4 runbook |
| High (same business day) | Wallet/R&E delivery failures over threshold, webhook signature-failure bursts, dead-letter growth, elevated auth failures, aging `UNKNOWN` payment states | Ops triage |
| Medium | Report/import failures, notification provider degradation, recon exceptions backlog | Tracked |
| Low | Individual retries, transient blips | Logged |

### 22.4 Audit logging (the audit spine)

- **Emission:** one `AuditRecorder::record()` API called from Actions (never ad hoc), stamping actor, acting role context, merchant, branch, action key, target, severity, reason, approval ref, masked before/after where safe, IP, UA, source channel, correlation ID.
- **Hash chain:** `row_hash = SHA256(canonical(row) + prev_hash)` maintained per tenant chain + platform chain under an advisory lock; a `VerifyAuditChainJob` (daily) re-walks recent segments; mismatch = critical incident. Audit role UI shows chain-health indication; Audit exports embed integrity hashes.
- **Catalogued events (minimum, per Scope §37.1):** auth issuance/use/replay/failures; authorization denials (sampled by pattern); merchant/branch lifecycle; membership/role/scope changes (before/after); catalogue and price changes; stock movements; sales/orders/receipts/shift closures; evidence recording/validation/rejection; refund records; expenses/period locks; loyalty ledger + adjustments; promotion changes; subscription/billing events; Wallet integration events (registration, attempts, webhooks, exceptions, reconciliation); R&E events (emission, delivery, dead-letter, replay, reconciliation queries); exports/downloads; file access; platform admin actions (always with reason); data-rights actions.
- **Auditor auditability:** every Audit-role page view, export, and annotation is itself an audit event (Scope §11.5).

---

## 23. Performance and Scalability Plan

### 23.1 Targets (from Scope §36, pending D-13 approval — wired as alert thresholds)

p95 < 500 ms common interactive API; POS sale completion p95 < 1 s server time; webhook ack p95 < 250 ms; dashboards ≤ 60 s staleness; search ≤ 60 s freshness; 99.9% core-commerce availability; RPO ≤ 5 min; RTO ≤ 4 h.

### 23.2 Likely bottlenecks and mitigations (evidence-based)

| Bottleneck | Evidence | Mitigation |
|---|---|---|
| Stock-level row contention on hot SKUs | §5.6 serialization requirement + 300k movements/day target | Short transactions (lock → mutate → commit); per-SKU-location lock granularity (never table locks); reservation TTLs keep locks out of checkout think-time |
| Dashboard aggregate queries | Near-real-time ≤ 60 s across large tenants | Incrementally maintained `dashboard_rollups` (per merchant/branch/day) updated by domain-event listeners; dashboards read rollups, never scan ledgers |
| Report generation on big ranges | 250k row export target | All reports on `heavy` queue; streaming CSV writes; `EXPORT_TOO_LARGE` (422) over caps with schedule path; read-replica routing for report queries |
| Audit/movement table growth | Longest retention + high volume | Monthly partitioning (`audit_events`, `stock_movements`, `notification_deliveries`); BRIN indexes on timestamps; partition-aware purge |
| Outbox/webhook processing lag | 50k integration events/day | Dedicated `integrations` queue; batch dispatch; lag metric + alert; horizontal worker scaling |
| N+1 queries | Eloquent default risk | `Model::preventLazyLoading()` outside prod; eager-loading required in list endpoints; CI fails on lazy-load violations in tests |
| Frontend bundle size | SPA covering all surfaces | Route-level code splitting per surface/module; POS and storefront as separate entry chunks; vendor chunking; bundle-size budget in CI (main chunk ≤ 250 KB gz) |
| Image weight | Product images | Server re-encode to webp variants (thumb/medium/large) on upload; CDN with immutable caching; `loading="lazy"` |
| Redis single point | Sessions + queues + cache | Managed Redis with replica/failover; cache misses degrade gracefully; queue-backlog thresholds trigger scaling + deferral of `low` work |

### 23.3 Caching strategy

Tenant-scoped cache keys (`m:{ulid}:…`) always; permission snapshot (invalidate on permission-version bump), entitlement snapshot (invalidate on plan events), catalog reads for storefront (60 s TTL + event-driven bust), dashboard rollups (listener-maintained), platform plan catalog (long TTL + admin bust). **Cache never bypasses authorization** — cached payloads are per-scope, and policies still run.

---

## 24. Security Threat Model

STRIDE-organized; every mitigation traces to an implementation section and a test in §25.

| Threat | Vector | Mitigations (§ refs) | Verifying tests |
|---|---|---|---|
| Broken access control | Missing policy on new route | Default deny; route→policy coverage test; `verified.membership` (§10, §5.3) | RouteAuthorizationCoverageTest; matrix suite |
| Cross-tenant leakage | Unscoped query/job/export/search | 4-layer isolation (§8); `TenantContextMissingException`; scoped bindings | Isolation suite (§8.6) |
| IDOR | Guessable IDs / foreign ULIDs | ULIDs; scoped route binding → 404 non-disclosure | EnumerationResistanceTest |
| Magic-link theft/replay | Forwarded/intercepted links | Hashed at rest, 10-min TTL, single-use, context binding, replay → session kill + alert (§9.1) | MagicLinkSecurityTest |
| Session fixation/hijack | Cookie theft, fixation | Regeneration at auth; Secure/HttpOnly/SameSite; idle/max timeouts; device fingerprint anomaly step-up | SessionSecurityTest |
| Privilege escalation | HR self-escalation, permission drift | Policy prohibitions; permission versioning; non-delegable list; membership_events audit | HrSelfEscalationTest; matrix snapshot |
| Offboarding lag | Stale sessions post-removal | Permission-version bump; ≤60 s revocation; continuous membership middleware | RevocationLatencyTest |
| Fraudulent payment evidence | Fake references, self-validation | Finance validation; recorder≠validator CHECK+policy; reference-hash dedup (`PAYMENT_REFERENCE_DUPLICATE`); variance surfacing; Audit visibility | EvidenceIntegrityTest |
| Duplicate/replayed Wallet events | Webhook replay, out-of-order | Inbox unique event ID; nonce store; timestamp window; terminal-state no-regress; `WALLET_PAYMENT_REUSED` guard | WalletContractSuite |
| Webhook forgery | Spoofed sender | Full verification pipeline before payload trust; constant-time compare; dual-key rotation (§4.4) | WebhookForgeryTest (invalid/skewed/rotated/oversize) |
| R&E event tampering | Payload mutation on retry | Append-only outbox payloads (trigger); `EVENT_ID_PAYLOAD_MISMATCH` stop-and-alert | OutboxImmutabilityTest |
| Inventory manipulation | Silent stock edits | Immutable reason-coded movements; approval thresholds; count variance workflow; shrinkage reporting | InventoryImmutabilityTest |
| Loyalty abuse | Point farming, manual credits | System-only accrual; append-only ledger; velocity checks; maker-checker adjustments (never single-operator) | LoyaltyAbuseTest |
| Promotion/coupon abuse | Brute force, stacking | Usage/per-customer limits; `coupon` rate tier; default no-stack; anomaly flags | CouponAbuseTest |
| Export abuse | Bulk exfiltration | Permission at generate + download; volume caps; masking; watermarks; full audit; step-up on full exports | ExportSecurityTest |
| Upload abuse | Malware, polyglots | §19 pipeline (allowlist, magic bytes, re-encode, scan, quarantine) | FileAbuseSuite |
| SQLi / XSS / CSRF | Injection vectors | Bound parameters only; Vue escaping + `SafeHtml` allowlist + CSP; Sanctum CSRF; strict CORS | Static analysis + XssRenderingTest |
| Mass assignment | Over-posted fields | Explicit `$fillable`; FormRequest field allowlists | MassAssignmentAuditTest |
| Unsafe redirects | Open-redirect params | Redirect allowlist helper; no user-supplied absolute redirects | RedirectSafetyTest |
| Brute force / credential stuffing | Auth endpoints | Rate tiers; lockouts; generic responses; security events + alert on pattern | AuthRateLimitTest |
| DoS / abuse | Floods, heavy ops | Per-user/tenant/IP limits; queue backpressure; import/export/report caps; 64 KB machine-channel body cap | RateLimitSuite |
| Secret leakage | Code/logs/bundle | Secrets manager; scrubbers; gitleaks + bundle scan in CI; env-separation boot guard | CI gates |
| Dependency vulns | Supply chain | composer/npm audit + Dependabot + Trivy; critical = deploy-blocking | CI gates |
| Admin misuse | Super Admin overreach | Purpose-limited surfaces; reason-required; maker-checker on destructive; append-only audit; anomaly alerting; no impersonation (D-14) | PlatformBoundaryTest |
| Log exposure | PII/tokens in logs | Scrubber processors; Sentry filter; masked references | LogScrubberTest |

---

## 25. Testing Strategy

### 25.1 Test pyramid and tooling

| Layer | Tooling | Scope | Gate |
|---|---|---|---|
| Static | PHPStan level 8 + Larastan, Pint, ESLint, vue-tsc, deptrac module boundaries | Whole codebase | CI-blocking |
| Unit | Pest | Money, BusinessDate, HmacSigner/verifier, CanonicalJson, state-machine transition maps, PermissionResolver, QualificationEngine rules, masking helpers | CI-blocking |
| Feature/API | Pest + Laravel HTTP tests against PostgreSQL (never SQLite — partial indexes/triggers must be exercised) | Every endpoint: positive, negative, permission-denial, cross-tenant, validation, state machine | CI-blocking |
| Integration | Pest + WireMock-style fakes of Wallet/R&E contracts + real Redis/Meilisearch containers | Webhook pipelines, outbox delivery, reconciliation, search scoping | CI-blocking |
| Browser/E2E | Playwright (chromium + webkit) | 12 critical journeys; responsive; both themes; axe scans | CI-blocking on core set |
| Security regression | Dedicated Pest suite (§24 rightmost column) | Access control, isolation, abuse | CI-blocking |
| Load (pre-launch) | k6 scripts: POS burst, checkout, webhook flood, report generation | §23.1 targets | Launch gate |

Coverage requirement: 100% of policies and Actions have tests; mutating endpoints have at least one negative + one denial + one validation-failure test; global line coverage floor 80% enforced, with `Domain/` floor 90%.

### 25.2 Standing test suites (names bound to phases in §27)

1. **AuthSuite** — `tests/Feature/Auth/`: `MagicLinkIssuanceTest`, `MagicLinkConsumptionTest`, `MagicLinkSecurityTest` (expiry, replay, cross-device replay kills session, audience mismatch, rate limits, generic responses), `OtpAuthTest`, `StepUpTest`, `SessionPolicyTest` (all four duration rows), `RevocationLatencyTest`.
2. **TenancySuite** — `tests/Feature/Tenancy/`: registration (KYC paths, duplicates `MERCHANT_DUPLICATE`, referral capture incl. outage), onboarding checklist/activation, four-status-dimension independence, branch lifecycle incl. edge constraints (open orders, stock on hand, last branch, entitlement limit), membership lifecycle, invitations (expiry/revoke/email-change reissue), context selection/switching.
3. **IsolationSuite** — `tests/Feature/Isolation/`: the 10 denied cases of §8.6, run parameterized across every tenant-owned aggregate.
4. **PermissionMatrixSuite** — generated from the seeder: for each role × capability cell, asserts allow/deny/step-up/maker-checker against real endpoints. The Scope §12.2 matrix is executable.
5. **CommerceSuite** — catalogue (SKU/barcode dedup, price history snapshots, archive constraints), inventory (movement immutability trigger, concurrency: parallel sale race for last unit, `STOCK_CONFLICT`, negative-stock policies, counts during sales, batch expiry during reservation), POS (shift gates, idempotent sale submission, offline-draft sync), orders (state machine, cancellation compensation, partial fulfilment), quotes, returns/voids.
6. **EvidenceSuite** — recording, validation (recorder≠validator, SME single-operator override flag, `PAYMENT_REFERENCE_DUPLICATE`, cash double-entry via End-Shift variance, rejection-after-receipt voiding + notification, unallocated evidence, partial positions summing), refund records (maker-checker, period-lock interaction), receipts (numbering under lock, copies marked, declaration wording).
7. **BillingSuite** — plan/versioning immutability, entitlement enforcement across UI/API/jobs/imports/exports (each channel exercised), lifecycle ladder with fairness pause, recovery allowlist route-by-route, PR-9 invariant, proration/downgrade read-only behavior, credits.
8. **WalletContractSuite** — signature valid/invalid/skewed/rotated-key/oversize/replayed-nonce; first-seen dedup; out-of-order no-regress; partial/exact/over payment application; `WALLET_PAYMENT_REUSED`; `UNKNOWN` no-blind-retry; stale-attempt recovery; registration idempotency; allocation-drift exception + linkage-only resolution; outage behavior (503 path, lock release, grace pause). Runs against the contract fake; a separate consumer-driven contract-verification job runs against the Wallet sandbox before environment promotion.
9. **ReferralContractSuite** — capture (valid/invalid/mismatch/outage snapshot), immutability post-tenant-creation, outbox transactionality (event + domain change commit/fail together — asserted by forced rollback), payload minimization schema checks, delivery retry ladder incl. `EVENT_ID_PAYLOAD_MISMATCH` stop, per-merchant sequencing, qualification engine (each deterministic failure category in order; correction versions; late clearing; reversal), reconciliation endpoint (four query classes, nonce replay 409, unattributed-empty), gap backfill.
10. **StaffOpsSuite** — attendance single-active-check-in, leave→auto-hold→reactivate, working-hours window denial, payroll approve-and-lock immutability, recertification flags, offboarding revocation.
11. **LoyaltyGrowthCxSuite** — ledger append-only, system-only accrual, adjustment maker-checker (single-operator forbidden), velocity flags, coupon limits/stacking/brute-force, promotion versioning + guards, CX consent enforcement + frequency safeguards + no-price-content rule.
12. **FileSecuritySuite**, **ExportSecuritySuite**, **NotificationSuite** (dedup, mandatory categories, consent), **AuditSuite** (chain verification, auditor-activity logging, no-modify-by-anyone incl. Super Admin), **ErrorCatalogueContractTest**, **RouteAbsenceSuite** (§25.8).

### 25.3 E2E critical journeys (Playwright)

1. Merchant self-registration → verify → onboarding checklist → first branch → plan selection → first product → first POS sale (the SME golden path, Scope §9.1.2).
2. Magic-link login → context selection → role switch (multi-role SME user).
3. Cashier: open shift → POS sale with barcode + discount within authority → record M-PESA evidence → receipt → End Shift with variance note.
4. Finance: validate evidence → reject one → receipt voiding → cash-up review.
5. End User: find merchant → branch storefront → cart → OTP checkout with declared reference → order tracking → receipt download.
6. Online order fulfilment: Cashier accepts → ready → completed; cancellation with stock compensation.
7. Billing: view invoice → STK attempt (fake Wallet) → webhook confirm → restoration from `read_only_grace`.
8. Team management: HR invites Cashier → acceptance → branch assignment → suspension → revoked session.
9. Inventory: receipt → transfer → count with variance approval.
10. Growth: quote → send → accept → POS queue handoff; promotion with approval guard.
11. Audit: read-only navigation, chain-health view, hashed export.
12. Super Administrator: onboarding approval, merchant suspension (maker-checker), billing exception linkage.

Each journey runs at all three breakpoints; journeys 1–5 also run in dark mode with axe scans.

### 25.4 Generated invalid-transition tests

For every registered state machine, a generator test enumerates undefined `(state, trigger)` pairs and asserts `INVALID_STATE_TRANSITION` (409) with zero partial effects (transaction snapshot comparison).

### 25.5 Per-module test definition standard

Every suite in §25.2 is specified in a `tests/README.md` block per module using this mandatory format, and reviewers reject suites that omit any row. Worked example for the Payment Evidence module (all other modules follow identically):

| Field | Payment Evidence example |
|---|---|
| Test files | `tests/Feature/Evidence/EvidenceRecordingTest.php`, `EvidenceValidationTest.php`, `EvidenceRejectionTest.php`, `CashUpTest.php`, `tests/Unit/Evidence/ReferenceHashTest.php` |
| Purpose | Prove evidence recording, validation segregation, dedup, rejection compensation, and cash reconciliation behave per Scope evidence rules |
| Positive cases | Cashier records M-PESA evidence on own sale; Finance validates pending evidence; partial positions sum to sale total; unallocated evidence later linked |
| Negative cases | Duplicate reference → `PAYMENT_REFERENCE_DUPLICATE` (409); validating already-validated evidence → `INVALID_STATE_TRANSITION`; evidence exceeding outstanding balance → validation error |
| Cross-tenant denial | Tenant B Finance validating Tenant A evidence by ULID → 404; evidence list scoped to context branch |
| Permission denial | Cashier attempting validation → 403 `PERMISSION_DENIED`; recorder validating own evidence → 403 + audit event (SME single-operator path asserts flag, not bypass) |
| Validation failures | Missing reference, malformed amount (non-minor-units), unknown method, future-dated timestamp → 422 with field-mapped errors |
| Success criteria | All cases green on PostgreSQL; zero direct status writes detected; audit events emitted for record/validate/reject; suite joins the regression wall |

### 25.6 Test data and factories

One factory per model with states mirroring the state machines (`PaymentEvidence::factory()->pendingValidation()`, `Order::factory()->readyForPickup()`); a `TwoTenantSeeder` (tenants A/B with mirrored data) is the substrate for every isolation test; time-sensitive logic uses `travelTo()` exclusively (no sleeps); external integrations use the contract fakes from §25.2-8/9 — real network calls in tests are a CI failure.

### 25.7 Flake policy

A test that fails then passes on retry is quarantined with a ticket within 24 h; quarantine >5 items or >7 days old blocks release. Retries are never enabled globally to mask instability.

### 25.8 Route-absence and code-absence tests (boundary proofs)

Asserts non-existence of: provider callback routes (`/providers/mpesa/*` etc.), manual subscription-payment recording endpoints, referral-reward/payout endpoints, tenant-merge endpoints, merchant password columns/endpoints, jQuery in lockfiles, provider SDK packages in composer.lock. These prove Scope §19.3, §21.4, §22.1 prohibitions structurally.

---

## 26. Deployment and CI/CD Strategy

### 26.1 Docker

- **Images:** `app` (php-fpm 8.3-alpine, extensions pinned, non-root user, OPcache+JIT prod config), `web` (nginx, security headers, gzip/brotli), `worker` (same app image, Horizon entrypoint), `scheduler` (same image, `schedule:run` loop). Multi-stage builds: composer install → npm build → final slim runtime (no dev deps, no node in runtime image).
- **docker-compose.dev.yml:** app, web, postgres:16, redis:7, meilisearch, minio, mailpit, clamav. One-command bootstrap: `make up && make setup` (migrate, seed permissions/plans/demo tenants A+B).
- **Hardening:** read-only root FS where possible, no shell in prod entrypoints beyond init, Trivy scan gate, pinned base-image digests.

### 26.2 Environments and configuration

`local → ci → staging → production`. Config via env vars only; secrets from the secrets manager injected at deploy (never in images or repo). **Production boot guard** (`citrus:verify-environment`, runs in entrypoint): asserts `APP_ENV=production`, `APP_DEBUG=false`, HTTPS URLs, Wallet base URL is the production host, integration key IDs lack `sandbox|staging` prefixes, mail/SMS drivers are real providers, and telescope/debug tooling absent — boot fails otherwise (Scope §30.6).

### 26.3 CI pipeline (`.github/workflows/ci.yml`, on every PR)

1. Checkout → PHP/Node setup with caches.
2. `composer validate` → Pint check → PHPStan → deptrac.
3. ESLint → vue-tsc → bundle build with size budget.
4. Pest unit + feature + integration against postgres/redis/meilisearch services (parallelized).
5. Playwright core set (smoke on PR; full nightly).
6. Security: gitleaks, `composer audit`, `npm audit --audit-level=high`, Trivy image scan.
7. OpenAPI spec validation + breaking-change diff.
8. Coverage floors enforced. Any failure blocks merge; `main` is protected.

### 26.4 Deployment pipeline (`deploy.yml`, on tagged release)

1. Build + push images (SHA + semver tags).
2. Deploy to **staging** → run migrations → smoke tests + Wallet/R&E sandbox contract verification job → manual approval gate.
3. **Production:** `php artisan down --render=maintenance --secret=…` only when a migration is non-online (see 26.5; default is zero-downtime rolling): rolling replace app/web/worker containers → `php artisan migrate --force` (gated) → `config:cache route:cache view:cache event:cache` → Horizon graceful terminate/restart → scheduler restart → health-check verification → traffic restore.
4. Post-deploy: synthetic checks (login page, health endpoints, webhook ping), Sentry release marker, deployment audit event.

### 26.5 Safe migration policy

Expand → migrate → contract pattern: additive columns first, backfill via queued jobs (chunked), code reads both, contract in a later release. No destructive DDL in the same release as the code that stops using it. Long-running index builds use `CREATE INDEX CONCURRENTLY` (outside transactional migration). Every migration PR states lock impact and rollback path.

### 26.6 Rollback

Images immutable → rollback = redeploy previous tag. Migrations: `down()` where safe; irreversible migrations require a documented forward-fix plan reviewed before merge. Runbook `docs/runbooks/rollback.md` covers: app rollback, migration incident, queue drain, webhook backlog replay, cache bust.

### 26.7 Backups and recovery

PostgreSQL: continuous WAL archiving + nightly base backups → RPO ≤ 5 min; weekly automated restore test into an isolated environment with checksum verification (RTO ≤ 4 h rehearsed). S3: versioned buckets + lifecycle rules. Redis: RDB snapshots (cache/queues are reconstructible; queued jobs idempotent by design). Backup encryption at rest; restore runbook tested before launch (Scope §41).

### 26.8 Health checks, uptime, logs

`GET /api/v1/health` (liveness: app up) and `/api/v1/health/deep` (readiness: DB, Redis, storage, Meilisearch, queue heartbeat, scheduler heartbeat, Wallet/R&E circuit-breaker states — reported, not gating pod health). External uptime monitoring on all public surfaces + webhook endpoint reachability. HTTPS enforced (HSTS preload); centralized logs with retention policy; TLS certs auto-renewed.

---

## 27. Step-by-Step Development Roadmap

Thirty phases in strict order; each later phase depends on the acceptance criteria of earlier ones. **Every phase ends with the same closing ritual:** (a) run the phase's test list plus the full IsolationSuite and PermissionMatrixSuite (they are cumulative regression walls from Phase 6 onward), (b) attach proof artifacts (test output, API examples, screenshots at three breakpoints where UI is involved, DB query output where data is involved), (c) update `docs/DECISIONS.md` for any deviation, (d) commit with the phase tag. **Rollback strategy for all phases:** each phase is a reviewed PR series on a feature branch; revert = revert the merge commit; migrations follow §26.5 so schema rollback is always additive-safe.

### Phase 0 — Project initialization

- **Objective:** Repository, tooling, and quality gates exist before any product code.
- **Creates:** repo skeleton, `composer.json`, `package.json`, Pint/PHPStan/ESLint/vue-tsc/deptrac configs, `.editorconfig`, `Makefile`, CI workflow, `docs/DECISIONS.md`, module directory scaffold (§5.1).
- **Tasks:** Laravel 11 skeleton; Vue 3 + Vite + TS + Tailwind app in `resources/`; Pest; CI pipeline (§26.3) green on empty suites; branch protection.
- **Verification:** CI runs all gates on a trivial PR and blocks a deliberately failing one.
- **Acceptance:** clone → `make up && make setup` → welcome page in <10 min; CI green.
- **Risk:** tool-version drift → lockfiles + pinned CI versions.

### Phase 1 — Docker and environment setup

- **Objective:** Dev/prod parity containers, environment guard.
- **Creates:** `docker/` (Dockerfiles, nginx conf, entrypoints), `docker-compose.dev.yml`, `citrus:verify-environment` command.
- **Tasks:** §26.1 images; health endpoints (`/health`, `/health/deep`); boot guard with tests (fails on `APP_DEBUG=true` + `APP_ENV=production`).
- **Tests:** `EnvironmentGuardTest`, `HealthEndpointTest`.
- **Acceptance:** all containers healthy; deep health reports every dependency; guard blocks misconfigured boot.

### Phase 2 — Database foundation and conventions

- **Objective:** Cross-cutting schema layer.
- **Creates:** migrations for `users`, `merchants`, `branches`, `audit_events` (+ hash-chain trigger + block-UPDATE/DELETE trigger), `idempotency_keys`, `files`, `notifications`, `failed_jobs`, `job_batches`, `sessions`, base model `Concerns` (ULIDs, `BelongsToMerchant`), `Money` and `BusinessDate` value objects, error-envelope exception handler + `ErrorCatalogue` enum.
- **Tests:** ULID generation, money arithmetic (unit), audit trigger rejects UPDATE (integration), error envelope shape (`ErrorCatalogueContractTest` seed).
- **Acceptance:** conventions §7.1 enforceable by Larastan rules; audit chain verified by `citrus:audit:verify-chain`.

### Phase 3 — Authentication (magic links, OTP, sessions)

- **Objective:** §9 complete for all three audiences.
- **Creates:** `Modules/Identity` (login_tokens, otp_codes, trusted_devices, auth controllers/actions), mail/SMS channel abstractions (Mailpit locally), session policy middleware, device fingerprinting, step-up mechanism, auth rate-limit tiers.
- **Frontend:** login screens per audience, magic-link sent/consumed states, OTP entry, step-up modal, session-expiry interceptor.
- **Security tasks:** hashed tokens, single-use enforcement under concurrency (unique consume via atomic UPDATE), replay → session kill + security event; generic responses.
- **Tests:** AuthSuite (§25.2-1) complete.
- **Acceptance:** all MagicLinkSecurityTest and SessionPolicyTest cases green; manual replay attempt shows session-kill screenshot; no password column anywhere (RouteAbsenceSuite seed).

### Phase 4 — Tenant model, registration, onboarding

- **Objective:** Merchants exist with four independent status dimensions and onboarding gates.
- **Creates:** merchant registration flow (+KYC fields per business type), onboarding checklist engine, activation rules, Super Admin approval queue (minimal), referral-capture stub (records `referral_captures` even before R&E module: snapshot + outage paths).
- **Tests:** TenancySuite registration/onboarding subset; `MERCHANT_DUPLICATE`; status-dimension independence.
- **Acceptance:** golden-path registration E2E (journey 1 through checklist) passes; four status dimensions provably independent in DB.

### Phase 5 — Memberships, invitations, branches, context

- **Objective:** People and places: memberships, invitation lifecycle, branch CRUD with edge constraints, context selection/switching.
- **Creates:** `memberships`, `membership_events`, `invitations`, branch lifecycle actions, `X-Branch-Id` context middleware, context-picker UI, account-switcher UI (§17 profile identity unit begins here).
- **Tests:** TenancySuite remainder; invitation expiry/reissue; last-branch/open-order/stock-on-hand branch-closure denials.
- **Acceptance:** journey 8 partial (invite→accept→assign); branch closure denial screenshots with error codes.

### Phase 6 — Roles, permissions, policies (default deny goes live)

- **Objective:** Full RBAC of §10; from this phase the regression wall is armed.
- **Creates:** permission registry seeder (matrix from Scope §12.2), `PermissionResolver` (+Redis cache + version bump), all policies, `EnsurePermission` middleware, route→policy coverage test, permission-aware frontend directive `v-can`, non-delegable list, HR-self-escalation prohibitions.
- **Tests:** PermissionMatrixSuite generated and green; RouteAuthorizationCoverageTest; RevocationLatencyTest (≤60 s).
- **Acceptance:** every registered route maps to a policy or explicit `public` marker; matrix snapshot committed as executable fixture.

### Phase 7 — Tenant-scoped data access layer

- **Objective:** §8's four isolation layers operational.
- **Creates:** global scopes + `TenantContextMissingException`, scoped route bindings (404 non-disclosure), tenant-context job middleware + serialization, scoped export/search/notification helpers, demo tenants A/B seeders.
- **Tests:** IsolationSuite all 10 denied cases; EnumerationResistanceTest.
- **Acceptance:** IsolationSuite green and joins the regression wall; manual cross-tenant curl attempts return 404 (artifacts attached).

### Phase 8 — API foundation

- **Objective:** §11 conventions materialized.
- **Creates:** `/api/v1` route groups per surface, FormRequest base classes, `ApiResource` envelope, pagination/filter/sort helpers, idempotency middleware, rate-limit tiers, OpenAPI generation + CI diff, API logging with scrubbers.
- **Tests:** envelope contract, pagination bounds, idempotency replay returns first result, 429 tiers.
- **Acceptance:** OpenAPI spec published; ErrorCatalogueContractTest green across implemented endpoints.

### Phase 9 — UI foundation: layout, responsive, dark mode, accessibility, forms

- **Objective:** §§12–17 foundations before feature screens multiply.
- **Creates:** app shell (header/sidebar/content per §13 strategies), design tokens + dark theme (§14 incl. flash prevention + server-persisted preference), base components (buttons, inputs, tables, modals, toasts, cards, empty/error/loading states), form kit with server-error mapping + duplicate-submit guard, profile menu + preview card (§17), axe CI integration, reduced-motion support.
- **Tests:** component tests for form kit and table; Playwright shell test at 3 breakpoints × 2 themes; axe zero-critical.
- **Acceptance:** journey 2 E2E passes; theme persists across logins; keyboard-only walkthrough recorded.

### Phases 10–17 — Commerce core (each phase = module, same template)

| Phase | Module | Key deliverables | Definitive tests |
|---|---|---|---|
| 10 | Catalogue | products/variants/categories/price history, barcode+SKU dedup, bulk import (queued, entitlement-capped), Meilisearch indexing (tenant-filtered) | CommerceSuite-catalogue; SearchIsolationTest |
| 11 | Inventory | movements (immutable), receipts, transfers, adjustments (reason-coded, threshold approvals), counts, batch/expiry, reorder alerts | CommerceSuite-inventory incl. race tests |
| 12 | POS + shifts | shift lifecycle, sale flow (locks §5.6), discount authority, offline drafts (IndexedDB + idempotent sync), receipts + numbering, End Shift with variance | journeys 3; POS idempotency; StockConflictTest |
| 13 | Payment evidence | recording, validation queue, dedup hash, rejection→void, unallocated pool, cash-up | EvidenceSuite; journey 4 |
| 14 | Orders + storefront | public storefront (SEO-safe, no auth), cart, OTP checkout, order state machine, fulfilment console, cancellations | journeys 5–6; storefront isolation |
| 15 | Customers + loyalty | directory, consent, points ledger, tiers, maker-checker adjustments, velocity flags | LoyaltyGrowthCxSuite-loyalty |
| 16 | Growth: promotions/coupons/quotes | versioned promotions + guards, coupon limits, quote lifecycle → POS handoff | journey 10; CouponAbuseTest |
| 17 | CX: campaigns/feedback | consent-enforced sends, frequency caps, no-price rule, feedback intake | LoyaltyGrowthCxSuite-cx; NotificationSuite |

Each of these phases: backend module + policies + FormRequests + resources; frontend screens on the Phase-9 kit; migrations per §7; audit events registered; entitlement checks stubbed against a static "Launch" plan until Phase 18; state-machine generator tests auto-extend.

### Phase 18 — Billing and plan enforcement

- **Objective:** §18 fully live; entitlements stop being stubs.
- **Creates:** plans/versions/subscriptions/invoices, `EntitlementService` wired into all channels, lifecycle ladder scheduler jobs, recovery-mode route allowlist, dunning notifications, Super Admin billing exceptions (maker-checker), PR-9 invariant checks.
- **Tests:** BillingSuite; journey 7 (against Wallet fake).
- **Acceptance:** ladder walked end-to-end in time-travel test; every entitlement denial carries upgrade context.

### Phase 19 — Wallet integration

- **Objective:** §4.4 contract complete.
- **Creates:** `Modules/WalletIntegration` (client with OAuth2 CC + circuit breaker, webhook verification pipeline, inbox, projections, allocation engine, STK flows for subscription + optional customer STK, reconciliation jobs, drift exception queue).
- **Tests:** WalletContractSuite against fake; sandbox contract-verification job wired into deploy pipeline.
- **Acceptance:** replay/forgery/rotation artifacts attached; outage drill (fake returns 503) shows correct degradation and recovery; journey 7 re-run green.

### Phase 20 — Refer & Earn integration

- **Objective:** §4.5 contract complete.
- **Creates:** `Modules/ReferralIntegration` (capture finalization, transactional outbox + delivery worker with retry ladder, qualification engine + correction versions, reconciliation query endpoint, gap backfill command, gating snapshot cache).
- **Tests:** ReferralContractSuite; forced-rollback transactionality proof.
- **Acceptance:** outbox immutability trigger proven; qualification decision matrix executable; reconciliation endpoint contract verified against R&E sandbox.

### Phase 21 — Staff operations (HR, attendance, leave, payroll records)

- **Objective:** Staff module per Scope HR/Staff sections.
- **Creates:** attendance, leave (auto-hold/reactivate), working-hours enforcement middleware, payroll record approve-and-lock, recertification tracking, offboarding runbook automation.
- **Tests:** StaffOpsSuite; journey 8 complete.

### Phase 22 — Reporting and exports

- **Objective:** Role-scoped reports, queued exports, PDF pipeline.
- **Creates:** report builders (branch/merchant scoped), export jobs with volume caps + masking + watermarks + step-up, headless-Chromium PDF service, download-token flow.
- **Tests:** ExportSecuritySuite; report-number reconciliation tests (reports agree with ledgers).

### Phase 23 — Audit surfaces and Super Administrator console

- **Objective:** Auditor read-only surface; platform console completed (approvals started in Phase 4).
- **Creates:** audit browser UI, chain-health dashboard, hashed exports; Super Admin: merchant registry, suspension maker-checker, platform announcements, plan catalogue admin.
- **Tests:** AuditSuite; PlatformBoundaryTest; journeys 11–12.

### Phase 24 — Notifications and CX plumbing hardening

- **Objective:** unify §20: channels, dedup, mandatory categories, digests, quiet hours.
- **Tests:** NotificationSuite full; consent regression.

### Phase 25 — Observability

- **Objective:** §22 complete: structured logs + scrubbers, Sentry, Prometheus metrics, Grafana dashboards (golden signals + queue + webhook + outbox lag), alert rules with severities, slow-query log shipping.
- **Verification:** synthetic incident drill — kill a worker, verify alert fires and dashboard shows backlog.

### Phase 26 — Testing completion and load tests

- **Objective:** close every §25 suite gap; k6 scenarios at §23.1 targets on staging with production-like data volume (generated: 50 tenants, 1 large tenant with 100 branches/500k orders).
- **Acceptance:** coverage floors met; k6 report within targets; flaky-test quarantine empty.

### Phase 27 — Security hardening and external review

- **Objective:** full §24 sweep: header audit, CSP rollout (report-only → enforce), dependency upgrade pass, gitleaks history scan, internal red-team of the top 6 threats, third-party penetration test, findings remediated with Bug Fix Protocol artifacts.
- **Acceptance:** zero criticals open; pen-test report + remediation log archived.

### Phase 28 — Performance optimization

- **Objective:** act on Phase-26 findings: query plans reviewed for top-20 endpoints, cache hit-rate tuning, bundle-size budget re-check, image/CDN configuration, BRIN/partition verification on hot tables.
- **Acceptance:** p95 targets green for one full week on staging under synthetic load.

### Phase 29 — Deployment pipeline and DR rehearsal

- **Objective:** §26 executed for real: staging + production infrastructure, secrets manager population, backup + restore rehearsal (timed), rollback rehearsal, runbooks finalized.
- **Acceptance:** restore drill meets RTO/RPO; rollback drill < 10 min; on-call rota + escalation policy documented.

### Phase 30 — Production readiness verification and launch

- **Objective:** execute §31 checklist item-by-item with evidence links; Wallet/R&E production key exchange and webhook registration; DNS/TLS for all surfaces; go/no-go review; launch; 48-hour hypercare with defined rollback triggers.
- **Acceptance:** §31 checklist 100% checked with artifacts; hypercare exit criteria met (error rate < 0.5%, zero Sev-1, webhook lag nominal).

---

## 28. IDE Agent Execution Instructions

These instructions bind the implementing agent for every task in §27. They operationalize the AI Vibe Coding Manifesto (Prove the Problem → Root Cause Analysis → Fix with Precision → Test Thoroughly → Demonstrate Resolution).

### 28.1 Standing work loop (every task, no exceptions)

1. **Read before write.** Open and read every file you intend to change, plus its tests, its module's policies, and any state machine it touches. Never edit from memory of a filename.
2. **Cite the requirement.** State which section of this plan (and, where applicable, which Scope section) the task satisfies. If you cannot cite one, stop — the task is out of scope and must be raised, not implemented.
3. **Prove the gap.** Show the failing test, the missing route, the absent column, or the reproduction that demonstrates the work is needed. "It seems like" is not evidence; a failing test or a concrete absence is.
4. **State the failure-if-omitted.** One sentence: what breaks in production if this is skipped. If nothing breaks, question the task.
5. **Make the smallest correct change.** Touch only the files the root cause requires. No drive-by refactors, no reformatting unrelated code, no upgrading dependencies mid-task.
6. **Preserve working behavior.** If an existing green test must change, justify why the *test* was wrong, not merely inconvenient.
7. **Write or update tests first or alongside** — every mutating endpoint change updates its positive, negative, denial, cross-tenant, and validation cases (§25.1 floor).
8. **Run the tests:** the module suite + IsolationSuite + PermissionMatrixSuite minimum; paste the actual command and its actual output.
9. **Demonstrate:** API request/response example, screenshot at the relevant breakpoints, or DB query output — whichever proves the behavior (§1.5 of the mandate).
10. **Document residual risk** in the PR description; if a Scope deviation was needed, record it in `docs/DECISIONS.md` with the settled-rules precedence analysis (Wallet/R&E scopes override the main Scope on conflict; Settled Rules D-1…D-16 override everything).

### 28.2 Bug Fix Protocol (mandatory format for every defect)

```
## Bug Fix Protocol
- Observed problem: <user-visible or test-visible symptom>
- Evidence: <failing test name/output, log excerpt, reproduction steps>
- Affected files: <exact paths>
- Root cause: <the actual defect, not the symptom>
- Why this is the root cause: <trace from symptom to cause; what ruled out alternatives>
- Correct fix: <what changes and why it addresses the cause>
- Files changed: <paths>
- Tests added or updated: <test names>
- Test command: <exact command>
- Test result: <pasted output>
- Proof of resolution: <API example / screenshot / DB output>
- Remaining risk: <what is still uncertain, or "none identified">
```

Forbidden fix patterns (reject in review): styling changes for logic defects; frontend guards for backend authorization gaps; catching-and-ignoring exceptions; widening a rate limit or validation rule to make a test pass; disabling a global scope "temporarily"; copy-pasting logic instead of extracting it; marking a flaky test as skipped without a quarantine ticket.

### 28.3 Hard guardrails (violating any of these fails review automatically)

1. Never write a query on a tenant-owned table that bypasses the global scope without `withoutTenancy()` + a written justification comment + an audit event where data leaves the tenant boundary.
2. Never add a route without a policy mapping or an explicit `public` registration (the coverage test will fail anyway — do not weaken the coverage test).
3. Never store or log a secret, token, password-equivalent, raw payment reference, or full phone/email in plaintext logs; use the scrubbers and masking helpers.
4. Never introduce jQuery, provider payment SDKs, password columns for merchant users, referral-reward computation, or tenant-merge logic (RouteAbsenceSuite enforces; do not weaken it).
5. Never trust a webhook payload before the full verification pipeline passes; never trust frontend-supplied prices, totals, discounts, roles, or entitlement flags — recompute server-side.
6. Never implement money as floats. Minor units + `Money` object only.
7. Never mutate append-only tables (audit, movements, ledgers, outbox payloads) — the triggers will reject it; do not remove the triggers.
8. All state changes go through the registered state machines; direct status-column writes are forbidden.
9. Schema changes only via migrations following §26.5; never edit a shipped migration.
10. When Scope documents conflict, apply precedence (Settled Rules > Wallet/R&E scope > main Scope > role files) and record the resolution in `docs/DECISIONS.md`.

### 28.4 Definition of Done (per task)

A task is done when: requirement cited; gap proven; change minimal; module + regression-wall suites green with pasted output; demonstration artifact attached; lint/static analysis clean; OpenAPI updated if routes changed; audit events registered if sensitive actions added; docs/DECISIONS.md updated if any judgment call was made; residual risk stated.

---

## 29. Acceptance Criteria

The Citrus platform is accepted for production launch only when every criterion below is verified with linked evidence (test run, artifact, or drill report). Grouped; each criterion is individually checkable.

### 29.1 Tenancy and isolation
1. Two seeded tenants (A, B) coexist; all 10 IsolationSuite denial cases pass, including job-without-context, unscoped export, foreign-ULID 404, and search-index scoping.
2. Branch scoping enforced for branch-bound roles; branch closure edge constraints (open orders, stock on hand, last branch) denied with catalogued errors.
3. No endpoint, export, report, search result, notification, or webhook ever emits another tenant's data — proven by the parameterized isolation suite across every aggregate.

### 29.2 Authentication and authorization
4. Magic-link auth passes all MagicLinkSecurityTest cases (TTL, single-use, replay→session-kill, context binding, generic responses); End-User OTP passes OtpAuthTest; no password storage for merchant users exists (RouteAbsenceSuite).
5. Session policy matches the four-row duration table; revocation after role change/suspension/offboarding ≤ 60 seconds (RevocationLatencyTest).
6. The full role × capability matrix is executable and green (PermissionMatrixSuite); route→policy coverage is 100%; step-up and maker-checker paths verified for every action flagged in §10.
7. HR self-escalation, recorder-validates-own-evidence, and single-operator loyalty adjustment are all denied and audited.

### 29.3 Commerce correctness
8. Inventory movements immutable; parallel last-unit sale race yields exactly one success and one `STOCK_CONFLICT`; counts, transfers, batch expiry behave per CommerceSuite.
9. POS sale submission idempotent; offline drafts sync without duplication; receipts numbered gaplessly under the period-lock rules; End-Shift variance recorded.
10. Payment evidence: duplicate reference blocked (`PAYMENT_REFERENCE_DUPLICATE`), recorder≠validator enforced (with the SME single-operator flagging exception exactly as scoped), rejection-after-receipt voids and notifies.
11. Order state machine rejects every undefined transition with `INVALID_STATE_TRANSITION` and zero partial effects (generator test).

### 29.4 Billing
12. Entitlements enforced at UI, API, job, import, and export channels (each proven separately); lifecycle ladder incl. fairness pause and recovery-mode allowlist walked in a time-travel test; PR-9 invariant holds; every denial carries upgrade context.

### 29.5 Integrations
13. WalletContractSuite green including forgery, replay, key rotation, out-of-order, over/partial payment, `WALLET_PAYMENT_REUSED`, and outage degradation; sandbox contract verification passes in the deploy pipeline; no provider callback routes exist.
14. ReferralContractSuite green including outbox transactionality under forced rollback, payload immutability, `EVENT_ID_PAYLOAD_MISMATCH` stop-and-alert, the full qualification decision order with correction versions, and the reconciliation endpoint contract; referral capture never blocks registration during R&E outage.

### 29.6 Experience
15. All 12 E2E journeys green at desktop/tablet/mobile breakpoints; journeys 1–5 additionally green in dark mode; no horizontal scroll, clipping, or overlap at any breakpoint.
16. Light default + persisted dark mode without flash-of-wrong-theme; axe scans report zero critical/serious violations on every shipped screen; keyboard-only completion of journeys 1–4 recorded; reduced-motion respected.
17. Forms: labels, associated errors, duplicate-submit prevention, server-error mapping verified by the form-kit component tests.

### 29.7 Operations
18. Structured logs with scrubbers (LogScrubberTest); Sentry receiving tagged releases; Grafana dashboards live for golden signals, queues, webhook lag, outbox lag; alert drill fired and acknowledged.
19. Audit chain verifies end-to-end (`citrus:audit:verify-chain`); auditor surface read-only; Super Admin actions reason-required and maker-checkered where flagged; no modification path exists for anyone including Super Admin.
20. Backups: restore drill met RPO ≤ 5 min / RTO ≤ 4 h with checksum verification; rollback drill < 10 min; runbooks exist for the incidents listed in §26.6.
21. k6 load run meets §23.1 latency/throughput targets on production-like data; coverage floors (80% global / 90% Domain, 100% policies) met; CI blocks on every gate in §26.3.
22. Third-party penetration test completed; zero critical or high findings open; environment boot guard proven to block misconfiguration; secrets present only in the secrets manager (gitleaks history scan clean).

---

## 30. Risk Register with Mitigation Steps

Severity = Impact × Likelihood (H/M/L). Every risk names an owner-role, mitigation already embedded in this plan (§ refs), and a contingency if the mitigation fails.

| # | Risk | Sev | Mitigation (built into plan) | Contingency / trigger |
|---|---|---|---|---|
| R-1 | Cross-tenant data leak reaches production | H | 4-layer isolation (§8); parameterized IsolationSuite as permanent regression wall; scoped bindings; export/search/notification scoping helpers | Sev-1 runbook: revoke sessions, disable affected endpoint, audit-log forensics via hash chain, mandatory disclosure review |
| R-2 | Wallet outage blocks merchant subscriptions and checkout | H | Circuit breaker, projections-first reads, grace pause on lifecycle ladder, queued STK retries, `UNKNOWN`-state recovery jobs (§4.4, §18) | Extend grace window platform-wide via Super Admin billing exception; status-page comms |
| R-3 | Webhook forgery or replay accepted | H | Full verification pipeline before trust; nonce store; timestamp window; dual-key rotation; WebhookForgeryTest in CI (§4.4, §24) | Rotate keys immediately; replay inbox from last verified event; incident review |
| R-4 | Fraudulent payment evidence at scale (SME single-operator gap) | H | Reference-hash dedup; recorder≠validator with flagged SME exception; variance surfacing; Audit visibility; velocity anomaly flags (§13 evidence rules) | Tighten per-merchant validation thresholds via config; Super Admin fraud review queue |
| R-5 | Outbox/webhook backlog causes R&E qualification drift | M | Per-merchant sequencing, retry ladder, gap backfill command, reconciliation endpoint, lag dashboards + alerts (§4.5, §25.2-9) | Manual backfill run; R&E reconciliation sweep; correction-version events |
| R-6 | Migration locks a hot table during deploy | M | §26.5 expand/contract policy, `CONCURRENTLY` indexes, lock-impact statement per migration PR, staging soak | Abort deploy, rollback image, reschedule migration in low-traffic window |
| R-7 | POS unusable during connectivity loss | M | Offline drafts in IndexedDB + idempotent sync; degradation strategy tested (§6, §25.2-5) | Paper-fallback procedure documented for merchants; sync-conflict review screen |
| R-8 | Permission matrix drift as features grow | M | Matrix as executable seeder + generated suite; route coverage test; permission versioning (§10, §25.2-4) | Fail CI on drift; quarterly matrix review against Scope §12.2 |
| R-9 | Queue backlog degrades receipts/notifications/exports | M | Horizon autoscaling, per-queue SLAs + alerts, idempotent jobs, backpressure caps (§20, §23) | Scale workers; shed low-priority queues; replay from failed_jobs |
| R-10 | Search index leaks or lags | M | Tenant-filtered index keys, SearchIsolationTest, reindex command, lag metric (§21) | Disable search UI gracefully (degradation state), rebuild index |
| R-11 | Dependency vulnerability (supply chain) | M | composer/npm audit + Dependabot + Trivy, deploy-blocking criticals (§24, §26.3) | Emergency patch release path (< 24 h) documented in runbook |
| R-12 | Startup team bus-factor on integration contracts | M | Contract fakes + consumer-driven verification jobs encode the contracts executably; DECISIONS.md; runbooks | Contract suites double as onboarding documentation |
| R-13 | Load beyond §23.1 projections (viral growth) | L | Stateless app tier, queue-first design, BRIN/partitioning prepared, CDN, read-replica plan (§23) | Activate read replicas; raise plan-tier rate limits deliberately, not reactively |
| R-14 | Legal/compliance change (KE data protection, e-receipts) | L | Retention schedule centralized (§7.9); masking helpers; consent framework; DPO review pre-launch (§2 assumptions) | Config-driven retention adjustments; targeted migration |
| R-15 | Dark-mode/accessibility regressions as UI evolves | L | Token-only theming, axe in CI, two-theme E2E on core journeys (§14, §15, §25.3) | Block release on axe criticals; visual regression snapshots |
| R-16 | Super Admin misuse or compromise | M | Purpose-limited console, maker-checker on destructive ops, reason-required, append-only audit, anomaly alerts, no impersonation (D-14) | Emergency key rotation + session purge; audit-chain forensic export |

---

## 31. Final Verification Checklist

Executed in order during Phase 30. Every box requires a linked artifact (test run URL, screenshot, drill report, or query output). A single unchecked box is a launch blocker.

### 31.1 Isolation and access control
- [ ] IsolationSuite: all 10 denial cases green across every tenant-owned aggregate (parameterized run output attached).
- [ ] PermissionMatrixSuite green; matrix snapshot diff vs Scope §12.2 reviewed and empty.
- [ ] RouteAuthorizationCoverageTest: 100% of routes mapped; `public` list reviewed and justified.
- [ ] EnumerationResistanceTest green; foreign-ULID probes return 404 non-disclosure (manual curl artifact).
- [ ] RouteAbsenceSuite green: no provider callbacks, no merchant passwords, no reward computation, no tenant merge, no jQuery, no provider SDKs.

### 31.2 Authentication and sessions
- [ ] AuthSuite fully green; replay-kill and step-up flows demonstrated with screenshots.
- [ ] Session duration table verified for all four rows; RevocationLatencyTest ≤ 60 s.
- [ ] Auth rate-limit tiers return catalogued 429s with generic bodies (artifact per tier).

### 31.3 Commerce, evidence, billing
- [ ] CommerceSuite, EvidenceSuite, BillingSuite green; last-unit race and reference-dedup artifacts attached.
- [ ] State-machine generator suite green: zero undefined transitions accepted anywhere.
- [ ] Entitlement enforcement proven per channel (UI, API, job, import, export) with one artifact each.
- [ ] Lifecycle ladder time-travel test output attached, including fairness pause and recovery allowlist.

### 31.4 Integrations
- [ ] WalletContractSuite green + sandbox contract-verification job passed in the release pipeline.
- [ ] Wallet outage drill report: degradation states shown, locks released, grace pause engaged, recovery clean.
- [ ] ReferralContractSuite green + R&E sandbox reconciliation verified; forced-rollback outbox proof attached.
- [ ] Production key exchange completed for both integrations; webhook endpoints registered and pinged; dual-key rotation rehearsed.

### 31.5 Experience and accessibility
- [ ] 12 E2E journeys green at 3 breakpoints; 1–5 green in dark mode (Playwright report link).
- [ ] axe: zero critical/serious on all shipped screens (report link); keyboard-only recordings for journeys 1–4.
- [ ] Theme persistence + no-flash verified; reduced-motion verified; zoom to 200% verified without loss.

### 31.6 Operations and deployment
- [ ] `citrus:audit:verify-chain` clean on staging data; audit UPDATE/DELETE rejection demonstrated (including as Super Admin).
- [ ] Grafana dashboards live; alert drill (worker kill) fired, paged, acknowledged; Sentry receiving tagged releases.
- [ ] Backup restore drill: RPO ≤ 5 min, RTO ≤ 4 h, checksums verified (drill report).
- [ ] Rollback drill < 10 min (report); runbooks reviewed: rollback, migration incident, queue drain, webhook backlog, key rotation, Sev-1 isolation breach.
- [ ] k6 report meets §23.1 targets on production-like data; slow-query log reviewed with zero unindexed hot queries.
- [ ] CI green on final release candidate: static analysis, coverage floors (80/90/100-policies), gitleaks, audits, Trivy, OpenAPI diff.
- [ ] `citrus:verify-environment` passes on production; deliberately misconfigured boot fails (artifact).
- [ ] Penetration test report: zero open critical/high; remediation log archived with Bug Fix Protocol entries.
- [ ] DNS + TLS (HSTS) live for all public surfaces; uptime monitors active; status/comms channel ready.
- [ ] Go/no-go review signed off; 48-hour hypercare rota staffed; rollback triggers documented (error rate ≥ 2%, any Sev-1, webhook lag > 15 min sustained).

**When every box above is checked with evidence, the Citrus platform is production-launch ready.**

---

*End of Citrus Platform Production Software Development Plan.*
