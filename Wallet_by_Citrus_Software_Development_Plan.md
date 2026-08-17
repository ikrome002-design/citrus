# Wallet by Citrus — Production Software Development Plan (v2.0)

> This document is the single executable plan of record for building **Wallet by Citrus**, the centralized,
> API-first financial orchestration and treasury operations platform owned and operated by **Citrus Labs Limited**.
> It is a **complete replacement** of plan v1.0, fully incorporating the First-Launch Critical Additions and the
> PesaPal / merchant-finance enhancement requirements. It is written to be executed by an IDE-based AI coding agent
> without guessing. Every phase is bounded, reviewable, testable, and traceable to the authoritative scope
> (`Wallet_by_Citrus_Platform_Project_Scope.md` v2.0, cited below as **Scope §n**). Where this plan names a
> mandatory, version-controlled specification file (a per-table data-dictionary entry, a per-screen specification,
> an ADR, a provider adapter contract), that file is a required deliverable of the owning phase and must exist and
> pass review **before** the corresponding migration, route, or screen is implemented.
>
> **Integration criticality:** the Servana platform declares two external launch dependencies on this platform:
> **Gate W — the Servana Collections Slice** (delivered by Milestone M1) and **Gate W-M — the Servana Merchant
> Funds-Flow Gate** (delivered by Milestone M2-MF). Kikao and SkillFlow integrate through the same contracts.

---

## 0. Plan Purpose and Agent Execution Rules

### 0.1 Plan Purpose

This plan translates the project scope into a dependency-aware, phase-sequenced, evidence-gated engineering programme covering repository initialization through production launch, including the merchant-finance domain, the PesaPal provider, allocation and commission, merchant settlement, chargebacks, case management, daily close, pilot rollout, and launch controls.

### 0.2 How the Implementation Agent Must Use This Plan

1. Read the entire owning phase in Section 27 before changing any code.
2. Open every authoritative scope reference the phase cites in `Wallet_by_Citrus_Platform_Project_Scope.md`.
3. Inspect the actual repository state before every task (migrations, `php artisan route:list`, policies, services, components, tests, lock files, CI). Never trust `PROGRESS.md` or `CHANGELOG.md` as proof of behavior — they are claims.
4. Prove the current state with commands and captured evidence before asserting a gap exists.
5. For any defect, perform root-cause analysis using the Bug Fix Protocol (Section 28.2) before editing.
6. Produce a file-level implementation checklist for the phase before writing code.
7. Implement only the scoped phase. Do not touch unrelated bounded contexts.
8. Write or update tests **before** declaring completion. Never weaken, skip, or delete a test to make a suite pass.
9. Run the full relevant quality suite (Section 25) and produce the proof artifacts the phase requires.
10. Update `PROGRESS.md`, `CHANGELOG.md`, the traceability matrix (`docs/traceability/matrix.csv`), and any new ADRs with real commit references.
11. Stop and record a blocking ambiguity in `docs/decisions/blocking-ambiguities.md` if an authoritative business rule is missing. Never invent financial business rules — in particular never invent provider capabilities, custody rules, fee bearers, refund/chargeback responsibility, tax treatment, or commission mechanics.
12. Never implement Servana-, Kikao-, or SkillFlow-side capabilities inside the Wallet repository. Wallet implements only its own side of each integration contract (ownership matrix, Section 2.4). Building a partner-owned capability in Wallet is a defect even if it works.

### 0.3 Source-of-Truth Hierarchy

1. `Wallet_by_Citrus_Platform_Project_Scope.md` v2.0 — product behavior, boundaries, requirements (normative shall/must).
2. **This plan** — sequenced executable engineering translation of (1).
3. `Servana Software Development Plan.md` §80.2 (Gate W), §2.2 (ownership matrix), ADR-012/014/015 — the consuming-product contract Wallet's M1 surface must satisfy verbatim (reference formats, endpoint shapes, signing contract, state-name mapping).
4. The repository — evidence of what is actually built, verified by commands, never by progress notes.

Conflicts are recorded in `docs/decisions/conflicts.md` with the controlling source named.

---

## 1. Architecture Summary and Decisions

### 1.1 What Is Being Built

Wallet by Citrus is a **single-legal-entity, multi-product, multi-account, multi-bank, multi-gateway financial orchestration and treasury operations platform** (Scope §3). It is *not* a public multi-tenant SaaS for unrelated merchants (Scope §112), but it enforces account isolation **as strictly as a public multi-tenant platform** across its internal hierarchy (Scope §10):

```text
Legal entity (Citrus Labs Limited)
    Product (Kikao, Servana, SkillFlow, future products)
        Application (per product)
            Environment (sandbox, staging, production)
                Product merchant account
                    Provider merchant accounts (per provider)
                    Merchant settlement destinations (versioned)
                    Product-scoped delegated users (launch-disabled)
```

The platform provides, at launch maturity:

1. **Identity and access** — magic-link authentication for all humans (no passwords), delegated product merchant users verified live against their source product (built, launch-disabled), OAuth2 client-credentials machine identities per product application per environment, granular role/permission authorization with maker-checker segregation and step-up authentication (Scope §11–§18).
2. **Registries** — legal entity, products, applications/environments, merchant accounts, banks, Citrus bank accounts, payment providers, provider accounts, provider credentials/certificates, provider wallets, payment methods, **provider contracts and capabilities, provider merchant accounts, merchant settlement destinations, settlement calendars, launch feature flags** (Scope §20–§30, §55, §106).
3. **Economic ownership** — first-class economic purpose, economic beneficiary, contractual seller, merchant of record, funds recipient, custody classification, and funds-flow model on every payment and route (Scope §31–§33).
4. **Routing** — a policy-driven routing engine mapping product → purpose → beneficiary → funds-flow → gateway → provider account → provider merchant account → settlement destination or Citrus settlement account, with immutable per-transaction route snapshots, deterministic ranking, controlled fallback, capability/contract/compliance gates, kill switches, and no blind failover (Scope §35–§36).
5. **Collections** — M-PESA C2B (shared PayBill with centralized validation/confirmation and structured `PRD-PAY-<ULID>` references plus `reference_class`), M-PESA STK Push, **PesaPal hosted checkout with checkout sessions, IPNs, and status queries**, and structural readiness for PesaLink/bank/card collection (Scope §37–§45).
6. **Merchant finance** — payment allocations with database-enforced balancing, commission/fee/tax/reserve policies (versioned), merchant settlements with calendars and SLA monitoring, merchant statements, merchant financial positions, reserves, negative balances, chargebacks, case management, merchant onboarding/suspension/offboarding, compliance eligibility (Scope §47–§56, §62–§63, §66–§70, §81).
7. **Payouts, refunds, reversals, treasury** — single and bulk payouts with maker-checker approvals, refund engine with concurrency-safe refundable-balance enforcement and refund-funding-party gating, reversal handling, internal treasury transfers, beneficiary versioning with reapproval (Scope §57–§61, §64–§65).
8. **Financial truth** — an immutable double-entry ledger in integer minor units with the sixteen marketplace posting templates, settlement tracking separated from payment success and from merchant settlement, provider balance/liquidity monitoring, multi-layer (including three-way and four-way) reconciliation, daily close, and accounting-period close (Scope §71–§78).
9. **Integration surface** — hardened incoming provider webhook/IPN ingestion (persist-raw-then-ack-then-process with corroboration), signed/versioned/retryable outgoing product webhooks, versioned REST product API under `/api/v1` with mandatory idempotency for money movement, and a published OpenAPI specification (Scope §44, §82–§85).
10. **Operations** — internal Vue 3 + TypeScript dashboard (50 functional areas, Scope §88), reports and async exports, notifications, append-only hash-chained audit logs, observability with merchant-finance metrics, runbooks, backups, disaster recovery, provider operating modes, kill switches, launch flags, pilot rollout, and production canaries (Scope §89–§108).

### 1.2 Architecture Style Decision

**Domain-oriented modular monolith** (ADR-0001). One Laravel application, one PostgreSQL database, with strictly bounded modules under `app/Modules/*` communicating through explicit application services, domain events, and contracts — never by reaching into another module's Eloquent models.

- **Evidence for:** small-team delivery; financial consistency requires cross-module ACID transactions (allocation + ledger posting + payment state + outbox in one commit); premature microservices would force distributed transactions across the ledger boundary — the highest-risk possible design for a money platform.
- **Failure if violated:** duplicated financial truth, two-phase-commit complexity, unreconcilable partial writes.
- **Extraction path preserved:** modules communicate via contracts, so a high-volume module (e.g., webhook ingestion) can later be extracted without rewriting the financial domain.

### 1.3 Canonical Technology Stack (binding; deviations require an ADR)

| Layer | Decision | Authority |
|---|---|---|
| Backend | Laravel 12.x (pin exact version in `composer.lock`), PHP **8.3** pinned across all images | Scope §1; matches Servana's baseline |
| API auth (products) | Laravel **Passport** OAuth2 client-credentials, per-application per-environment clients with scoped tokens | Scope §12 |
| Browser auth | Laravel **Sanctum** stateful SPA sessions + magic-link login (no passwords) | Scope §15 |
| Frontend | **Vue 3 + TypeScript + Vite**, Pinia state, Vue Router | Scope §88 |
| Styling | **Tailwind CSS** with CSS custom-property theme tokens | Section 12 |
| Database | **PostgreSQL 16** (partial indexes, JSONB, advisory locks, deferred constraint triggers, exclusion constraints) | Scope §87 |
| Cache / queues / locks / rate limits / idempotency coordination | **Redis 7** (separate logical DBs for cache vs queue; AOF everysec on queue DB) | Scope §99 |
| Queue monitoring | **Laravel Horizon** | — |
| Object storage | Private **S3-compatible** (MinIO in dev) with versioning + lifecycle rules | Scope §95 |
| Search | **PostgreSQL full-text / trigram at launch**; Meilisearch only when measured latency exceeds targets (Section 21) | Scope §100 |
| Web/proxy | Nginx + PHP-FPM | — |
| Runtime | Docker (multi-stage), docker-compose dev, container orchestration production | — |
| CI/CD | GitHub Actions (test → analyse → scan → build → deploy) | Section 26 |
| Error tracking | Sentry | — |
| Secrets | Centralized secrets manager in production; `.env` never committed | Scope §93 |
| Money | `bigint` integer minor units + `char(3)` uppercase ISO currency, everywhere, always | Scope §71.1 |
| Public identifiers | **ULID** (`char(26)`) on every externally referenced row; internal bigint PKs never exposed | Scope §10 |
| Time | `timestamptz` (UTC); provider timestamps + zones preserved verbatim; `Africa/Nairobi` business dates | Scope §113(16) |

### 1.4 Milestones

| Milestone | Content | Gate |
|---|---|---|
| **M0 — Foundation** | Phases 0–9: repo, Docker, Laravel, frontend shell, magic-link auth, registries (incl. purposes, funds-flow models, contracts, capabilities, provider merchants, destinations, calendars, launch flags), memberships, RBAC, scoped data access, audit | Foundation gate: isolation + auth suites green (Scope §116.1) |
| **M1 — Servana Collections Slice (External Gate W)** | Phases 10–17: API foundation, machine auth, routing (incl. funds-flow/capability/contract gates), PesaPal adapter foundation (12A), webhooks, C2B + STK + PesaPal collections with checkout sessions, allocation and commission (14D), ledger with marketplace accounts, settlement basics, merchant settlement (15B), collection reconciliation (incl. PesaPal + allocation + merchant settlement), merchant statements + daily close (16B), exception queue, simulator, published OpenAPI | **Gate W evidence pack** (Section 29 / Scope §116.2) |
| **M2-MF — Servana Merchant Funds-Flow (External Gate W-M)** | Phase 17 W-M packaging on top of M1 deliverables: provider merchant onboarding proven, destination verification, funds-flow canaries, legal/provider approvals | **Gate W-M evidence pack** (Scope §116.3) |
| **M2 — Payouts and Refunds** | Phases 18–21: beneficiaries, approvals (extended), single B2C payouts, refunds (incl. funding party, reserves, negative balances), reversals, chargebacks + cases (20A), provider balances | Payout + refund + chargeback acceptance criteria (Section 29) |
| **M3 — Bulk and Multi-Bank** | Phases 22–23: bulk payouts, batch upload, PesaLink/bank adapters, treasury transfers, settlement allocation | Bulk acceptance criteria |
| **M4 — Production Readiness** | Phases 24–27: reports/exports (incl. merchant-finance), observability completion (incl. launch metrics), security hardening, performance/chaos (incl. IPN storms), deployment pipeline, DR exercise, pilot rollout, launch checklist | Section 31 final verification + Scope §116.5 |

### 1.5 What This Plan Explicitly Refuses to Build (Scope §111–§112)

Public merchant self-registration; unrelated-company tenancy; public self-service production credentials; white-label dashboards; general stored-value consumer wallets; P2P transfers; lending/credit; crypto; cross-border remittance without approved providers and legal review; blind provider failover after unknown status; editing/deleting posted ledger entries; deleting financially referenced registry records; customer access to the central finance dashboard; storage of raw card data; **Citrus omnibus collection of customer funds for later merchant payout (except as the disabled, gated `CITRUS_COLLECTION_MERCHANT_PAYOUT` model); general arbitrary PesaPal disbursements; public Wallet merchant dashboards; stored-value merchant wallets; cross-border merchant settlement; unapproved settlement-destination changes; manual editing of financial history.** Any task that appears to require one of these is a **blocking ambiguity**, not an implementation choice.

---

## 2. Assumptions and Constraints

### 2.1 Resolved Assumptions (binding; each is a settled decision)

| ID | Topic | Resolved decision |
|---|---|---|
| W-A01 | Currency/money | `bigint` minor units + `char(3)` uppercase-checked ISO currency; KES default; `currencies` registry controls precision; float money forbidden in DB, PHP, TypeScript |
| W-A02 | Public identifiers | Immutable ULID `public_id char(26) unique not null` on every externally referenced row; payment references `{PRODUCT_PREFIX}-PAY-<ULID26>` (Servana ADR-014 expects `SRV-PAY-<ULID26>`); a separate immutable `reference_class` (`{PRD}-CIT-FEE-`, `{PRD}-CIT-SUB-`, `{PRD}-MER-PAY-`, `{PRD}-MER-DEP-`) carries the economic distinction without breaking the public contract (Scope §40.1) |
| W-A03 | Human auth | Magic link only; `users` has **no password column**; Sanctum stateful sessions; step-up = TOTP or fresh short-lived magic link; WebAuthn post-launch |
| W-A04 | Machine auth | Passport client-credentials; one OAuth client per `application` row; scopes from `allowed_scopes`; tokens ≤ 60 min; no machine refresh tokens |
| W-A05 | Product prefixes | `KIK`, `SRV`, `SKF`; registered in `products.code`; new prefixes 3–4 uppercase chars via product onboarding |
| W-A06 | Environments | `sandbox`, `staging`, `production` enum on `applications.environment`; every transaction carries denormalized `environment`; same-schema separation via environment keys + check constraints + composite FKs; per-environment DB split is a documented future ADR option |
| W-A07 | Outgoing webhook signing | HMAC-SHA256, canonical string `METHOD\nPATH\nTIMESTAMP\nNONCE\nCONTENT_SHA256\nEVENT_ID\nEVENT_TYPE\nEVENT_VERSION`; headers `X-Wallet-Key-Id`, `X-Wallet-Timestamp`, `X-Wallet-Nonce`, `X-Wallet-Event-Id`, `X-Wallet-Event-Type`, `X-Wallet-Event-Version`, `X-Wallet-Content-Sha256`, `X-Wallet-Signature`; ±300 s tolerance; per-application secrets, dual-key rotation; the published contract Servana ADR-015 verifies against |
| W-A08 | Event names | Dot-namespaced, versioned: `payment.*`, `payout.*`, `refund.*`, `batch.*` per plan v1.0, plus `payment.allocation_*`, `merchant_settlement.*`, `provider_merchant.*`, `merchant_reserve.*`, `chargeback.*`, `case.*` (Scope §83). Payloads always carry the full current state string exactly as defined in the state machines. Internal events are not auto-sent to products |
| W-A09 | Idempotency | `Idempotency-Key` header required on every money-moving create (`POST /payments`, `/payments/{p}/attempts/stk`, `/payments/{p}/checkout-sessions`, `/refunds`, `/payouts`, `/payout-batches`); key scoped (application, operation); body SHA-256 stored; same key + different hash → `409 IDEMPOTENCY_CONFLICT`; same key + same hash → replay; retention ≥ 90 days |
| W-A10 | Timezone | UTC storage; Africa/Nairobi business dates; banking-day/holiday calendars configurable and versioned (`settlement_calendars`) |
| W-A11 | Migrations | Expand-and-contract only; destructive `down()` never relied on in production; forward-repair migrations; migration manifest with compatibility class |
| W-A12 | Provider launch order | Daraja first adapter (C2B, STK, B2C, reversal, status, balance). **PesaPal is the explicit second adapter, built in Phase 12A and integrated in Phase 14, with activation gated on contract + onboarding evidence.** PesaLink/bank/card adapters in M3 behind the same `ProviderAdapter` contract. Aggregators registry-ready only |
| W-A13 | Delegated merchant users | Built and tested in Phase 8; launch-disabled for all three products; merchant financial data exposed through Servana |
| W-A14 | Ledger corrections | Posted entries immutable; corrections are compensating entries requiring `reconciliation.resolve` + maker-checker + evidence |
| W-A15 | Entitlement analog | Per-application entitlements: allowed scopes, methods, directions, currencies, **economic purposes**, amount limits, daily/monthly limits, rate-limit policies — enforced server-side like plan gates |
| W-A16 | Sandbox simulator | First-party simulator (Phase 16) impersonating Daraja **and PesaPal** endpoints in sandbox: success/failure/timeout/duplicate/late-callback/reversal/redirect-before-IPN/IPN-before-redirect/duplicate-IPN/status-mismatch/settlement-file scenarios |
| W-A17 | Data retention | Raw webhook payloads 7 y; audit logs 7 y append-only; magic links 90 d; idempotency keys 90 d; exports 30 d signed-URL expiry; onboarding/statements/contracts/chargeback/tax evidence per legal obligation; all configurable in `app_settings`, changes audited; legal holds suspend expiry |
| W-A18 | Compliance boundary | Engineering builds the controls; production launch requires documented Kenyan legal/compliance sign-off in `docs/compliance/legal-signoff.md`; **merchant funds-flow routes additionally require the approved provider money-flow assessment `docs/compliance/provider-money-flow-assessments/pesapal-servana.md`**; the launch checklist blocks without both |
| W-A19 | Funds-flow defaults | `MERCHANT_GROSS_CITRUS_SEPARATE_BILLING` is the first-launch default for customer-to-merchant payments; `PROVIDER_SPLIT_SETTLEMENT` capability-flag false until contractually proven; `CITRUS_COLLECTION_MERCHANT_PAYOUT` globally disabled (`citrus_paybill_merchant_funds_enabled = false`) until its full activation gate is satisfied; `MANUAL_SETTLEMENT_WITH_EVIDENCE` exceptional only |
| W-A20 | PesaPal truth model | Redirect = navigation signal; IPN = notification; status query = authoritative provider confirmation where required; settlement/statement files = settlement evidence; ledger = internal truth; reconciliation = proof of agreement. A redirect never marks a payment successful |

### 2.2 Constraints

1. **Team size:** 1–3 engineers plus this IDE agent. Mitigation is milestone ordering — M1 is the smallest production-viable slice; M2-MF is the smallest merchant-finance-viable slice.
2. **External dependencies that gate production:** Daraja production onboarding; **PesaPal commercial agreement, production onboarding, IPN registration, and written capability confirmations (Scope §42.3)**; bank verification of Citrus settlement accounts; provider registration of callback/IPN URLs; legal + funds-flow sign-off (W-A18); pilot merchant onboarding. Software phases never block on these; production route activation does.
3. **Provider constraints taken as fact:** Daraja does not sign callbacks; C2B validation has a hard response deadline; STK callbacks can precede the HTTP response; B2C results can be delayed or lost. **PesaPal IPNs are unsigned notifications resolved by status query; PesaPal's public API covers collection/notification/status/refund/recurring/cancellation only; split settlement, sub-merchant settlement, merchant-onboarding APIs, and general disbursement are unproven until contractually confirmed.** All are designed for, not assumed away.
4. **No production data exists yet** — greenfield; the agent proves the empty state at Phase 0.

### 2.3 Blocking-Ambiguity Register (seeded at Phase 0; Scope §118.4)

`docs/decisions/blocking-ambiguities.md` is seeded with: PesaPal merchant/sub-merchant model; PesaPal split settlement; PesaPal direct merchant settlement; PesaPal disbursement capability; provider fee bearer; refund responsibility; chargeback responsibility; merchant KYB ownership; settlement-destination ownership; Citrus commission model; tax and withholding treatment; merchant funds custody classification. Affected capabilities remain gated until each is resolved in writing.

### 2.4 Cross-Platform Ownership Boundary Matrix (normative)

**One-sentence rule:** *Wallet owns money-movement truth (providers, credentials, callbacks, IPNs, receipts, allocation, ledger, settlement, merchant settlement, reconciliation); each product owns its business truth (invoices, entitlements, access decisions, merchant commercial status); Wallet never decides whether a product customer is entitled to anything, and products never talk to Safaricom or PesaPal.*

| Capability | Wallet | Product (Servana/Kikao/SkillFlow) |
|---|---|---|
| Provider credentials, shortcodes, PayBill/Till, PesaPal accounts + IPN registrations | **Owns** | — |
| STK submission, checkout sessions, provider request/order-tracking IDs | **Owns** | — |
| C2B validation/confirmation, PesaPal IPN endpoints; raw callbacks | **Owns** | — |
| Receipt/order-tracking uniqueness; replay protection; status queries | **Owns** | — |
| Authoritative payment + allocation + settlement + merchant-settlement state; ledger | **Owns** | — |
| Provider/bank/allocation/merchant reconciliation; exception queue; daily close | **Owns** | — |
| Provider merchant onboarding records, destinations, statements, reserves, chargebacks, cases | **Owns** | Supplies merchant identity/status; renders merchant-facing views |
| Signed product webhooks; durable retries; replay | **Owns** | — |
| Structured reference + reference-class issuance | **Issues/owns** | Requests + displays |
| Payment registration (`external_reference`, `economic_purpose`, policy reference) | Accepts, validates, enforces uniqueness + purpose permissibility | Registers its business document + declares purpose |
| Applying confirmed funds to product invoices; product access decisions; cancellation policy | — | **Owns** |
| Merchant commercial status (plans, suspension source-of-truth) | Mirrors + enforces effects | **Owns** |
| Delegated user active-status | Verifies at login/intervals | **Owns** (source directory) |
| Bank account / settlement destination / funds-flow selection | **Owns (derives from configuration)** | Never selects |

---

## 3. Non-Negotiable Security Rules

These apply to every phase, table, route, screen, job, and test. Each has an enforcing mechanism — a rule without enforcement is treated as unimplemented.

1. **No jQuery.** CI lockfile/bundle grep.
2. **No frontend authorization.** Server-side policy on every mutation and protected read; frontend `can` maps are UX hints. Enforced by `RouteSecurityContractTest`.
3. **No cross-product / cross-merchant / cross-provider-merchant / cross-environment leakage.** Global scopes + composite ownership keys + scoped route binding + 404 posture. Enforced by the isolation suite (Section 25.4) and PHPStan tenancy rules.
4. **No skipped authorization.** Policies/gates mandatory; `PolicyCoverageTest`.
5. **No hardcoded secrets.** gitleaks CI + pre-commit; production boot refuses sandbox-pattern credentials.
6. **No sensitive data in logs.** Central redaction list (Section 22.4) incl. **KYB documents, beneficial-owner data, full settlement destinations, provider merchant identifiers in full form**; log-processor test with synthetic secrets.
7. **No device detection for responsiveness; no disabled zoom.** ESLint rule + e2e meta assertion.
8. **No floating-point money.** DB bigint; PHPStan rule; migration lint; TS integer-asserted `Money`.
9. **No editing/deleting posted ledger entries.** DB triggers block UPDATE/DELETE; runtime test.
10. **No deletion of financially referenced registry records** (banks, bank accounts, provider accounts, provider merchants, destinations, routes, products, contracts): status/effective-date deactivation only; FK RESTRICT; `NoHistoricalDeletionTest`.
11. **Timeout ≠ failure. Unknown ≠ failed. No blind failover.** Partial unique index (one non-terminal attempt per payout/refund) + transition guards + `UnknownStateFailoverTest`. Applies equally to PesaPal order submission ambiguity.
12. **Maker ≠ checker.** DB trigger + service guard + `SelfApprovalDeniedTest`; extended segregation per Scope §17 (destination creator ≠ activator; policy creator ≠ activator; reserve creator ≠ releaser; close preparer ≠ approver; hold creator ≠ releaser; contract uploader ≠ sole capability activator).
13. **Idempotency everywhere money moves** (W-A09) + `FinancialRouteIdempotencyCoverageTest`.
14. **Incoming webhooks/IPNs: persist raw → ack → process async with corroboration.** No domain mutation in the receiving HTTP request; non-corroborated events can never post ledger entries or emit product webhooks (Scope §44).
15. **Outgoing webhooks always signed** (W-A07); delivery bodies truncated + redacted.
16. **Sandbox and production credentials disjoint.** Boot guard; token env claims; composite FKs.
17. **Sensitive fields encrypted at rest** (bank/destination numbers, mobile wallet numbers, provider credentials, beneficiary destinations, TOTP secrets, KYB document references) with masked companions; full-value access = narrow permission + step-up + reason + audit.
18. **HTTPS everywhere; HSTS; strict CORS; CSP.**
19. **Rate limits on every surface** (Section 11.6, 9.6).
20. **Append-only, hash-chained audit logs** with daily chain verification.
21. **Correlation ID on every request**, flowing through jobs, webhooks, and error envelopes.
22. **Enumeration resistance:** uniform magic-link responses; 404 posture; scope-filtered search.
23. **A browser redirect never marks a payment successful** (W-A20). Enforced by the checkout-session state machine + `RedirectCannotMarkSuccessTest`.
24. **Allocation balance is database-enforced** — an unbalanced allocation cannot commit (Section 7.6); `AllocationBalanceTest`.
25. **Merchant money never posts to Citrus revenue** except through the explicit templates; posting-directive tests assert account categories per funds-flow model.
26. **Feature flags cannot override compliance gates**; kill switches block new transactions while callbacks continue. `LaunchControlTest`.
27. **No silent financial netting** across merchants, products, currencies, or customers (Scope §63.4); netting requires explicit policy + ledger + report.

---

## 4. System Architecture

### 4.1 Runtime Topology

```text
                                   ┌────────────────────────────────────────────┐
 Internet                          │  Citrus Labs private network / VPC          │
 ─────────                         │                                            │
 Safaricom Daraja ── HTTPS ──────► │  Nginx (TLS termination, body limits)      │
 PesaPal IPNs ────── HTTPS ──────► │    ├── /api/v1/providers/*  (webhook pool) │
 Bank/provider callbacks ─ HTTPS ► │    ├── /api/v1/*            (product API)  │
 Product servers (OAuth2) ──────►  │    ├── /api/internal/v1/*   (SPA API)      │
 Internal staff browsers ────────► │    └── /            (SPA static via CDN)   │
 Customer browsers (checkout       │                                            │
   redirects only; no API access)  │  PHP-FPM app containers (stateless, N≥2)   │
                                   │  Horizon worker containers:                │
                                   │    queue: webhooks-in (high concurrency)   │
                                   │    queue: financial   (low concurrency,    │
                                   │            strictly idempotent workers)    │
                                   │    queue: webhooks-out, notifications,     │
                                   │            exports, statements, default    │
                                   │  Scheduler container (single, lock-guard)  │
                                   │  PostgreSQL 16 (primary + replica; PITR)   │
                                   │  Redis 7 (cache db0 / queues db1; AOF)     │
                                   │  S3-compatible object storage (private)    │
                                   │  Secrets manager; Sentry; logs; metrics    │
                                   └────────────────────────────────────────────┘
 Wallet ── signed webhooks ──► Product callback endpoints
 Wallet ── HTTPS (Daraja: STK, B2C, status, balance) ──► Safaricom
 Wallet ── HTTPS (PesaPal: auth, orders, status, refunds, IPN registration) ──► PesaPal
```

### 4.2 The Three API Surfaces (never mixed)

| Surface | Prefix | Auth | Consumers | Route class |
|---|---|---|---|---|
| Product API | `/api/v1/*` | Passport client-credentials (scoped) | Product backend servers only | `product_api_read` / `product_financial_mutation` |
| Provider webhooks/IPNs | `/api/v1/providers/*` | Provider-specific validation (Section 24.3); **no** session/token auth | Safaricom, PesaPal, banks | `provider_webhook_mutation` |
| Internal dashboard API | `/api/internal/v1/*` | Sanctum session + CSRF | Wallet SPA only | `internal_read` / `internal_mutation` / `internal_financial_mutation` / `internal_platform_mutation` |

A provider webhook route never carries Sanctum or Passport middleware; a product API route never resolves a browser session; internal routes are unreachable with a Passport token. `RouteSecurityContractTest` enforces the matrix.

### 4.3 Module Map (modular monolith, `app/Modules/*`)

```text
app/Modules/
  Identity/            # users, magic links, sessions, step-up, security events   (Phase 5)
  Access/              # roles, permissions, memberships, policies                (Phase 8-9)
  Registry/            # legal entity, products, applications, environments,
                       #   merchant accounts, banks, bank accounts, currencies,
                       #   economic-purpose + funds-flow registries, launch flags (Phase 6-7)
  Provider/            # providers, provider accounts, credentials, wallets,
                       #   balances, adapters (Daraja Phase 12, PesaPal Phase 12A)
  ProviderContract/    # provider contracts, versions, fee schedules, SLAs,
                       #   capabilities (account + merchant level), expiry alerts (Phase 7)
  MerchantOnboarding/  # provider merchant accounts, onboarding cases, documents,
                       #   provider approval lifecycle                            (Phase 7-8)
  ComplianceEligibility/ # compliance statuses, holds, review due dates,
                       #   route eligibility input                                (Phase 8)
  MerchantFinance/     # merchant financial positions, payables/receivables,
                       #   merchant settlements, negative balances, statements    (Phase 15B, 16B)
  Routing/             # payment methods, routes, versions, routing engine,
                       #   route snapshots, decisions, kill switches              (Phase 12)
  Collection/          # payments, attempts, references, C2B, STK, PesaPal
                       #   collection flow, checkout sessions, state machine      (Phase 14)
  Allocation/          # payment allocations, items, settlement instructions,
                       #   balancing constraints, snapshots                       (Phase 14D)
  Commission/          # commission policies, versions, calculations, billing refs (Phase 14D)
  Fee/                 # fee policies, provider fees, fee bearer, variance         (Phase 14D)
  Tax/                 # tax policies, withholding, versions, reporting fields     (Phase 14D)
  Reserve/             # reserves, movements, release schedules, application       (Phase 15B, 20)
  Payout/              # payouts, attempts, batches, batch items                  (Phase 19, 22)
  Refund/              # refunds, refund attempts, reversals, funding party       (Phase 20)
  Chargeback/          # chargebacks, events, evidence, adjustments, deadlines    (Phase 20A)
  CaseManagement/      # cases, parties, events, notes, evidence, SLAs            (Phase 20A)
  Beneficiary/         # beneficiaries, destinations, versions                    (Phase 18)
  Approval/            # approval policies, requests, actions, maker-checker      (Phase 18)
  Ledger/              # accounts, transactions, entries, posting directives      (Phase 15)
  Settlement/          # Citrus settlements, batches, expected vs actual          (Phase 15)
  DailyClose/          # daily close runs/items, accounting periods, sign-offs    (Phase 16B)
  Treasury/            # internal transfers, liquidity thresholds                 (Phase 23)
  WebhookIn/           # incoming inbox, replay detection, corroboration dispatch (Phase 13)
  WebhookOut/          # outbox, endpoints, deliveries, signing, retry            (Phase 13)
  Reconciliation/      # runs, items, exceptions, statements, statement lines,
                       #   three-/four-way matchers, fee/allocation/merchant recon (Phase 16)
  Risk/                # risk rules, assessments, velocity, holds, review queues  (Phase 14, 20, 24)
  Notification/        # in-app + mail notifications, preferences                 (Phase 20)
  Reporting/           # reports, async exports, merchant statements generation   (Phase 16B, 24)
  Audit/               # append-only audit log, hash chain, verifier              (Phase 9)
  Configuration/       # app settings, configuration_changes versioning           (Phase 6)
  Observability/       # health checks, metrics, correlation                      (Phase 3, 25)
  Simulator/           # sandbox-only Daraja + PesaPal simulator                  (Phase 16)
```

Inter-module rules (enforced by Deptrac/PHPStan layer rules in CI):

1. Modules expose an `Api/` namespace of application services + DTOs; other modules import only from `Api/` and `Contracts/`.
2. Cross-module reactions use domain events dispatched inside the owning transaction; listeners queued for side effects, synchronous only for same-transaction invariants (allocation validation, ledger posting).
3. `Ledger` accepts postings only through `LedgerPoster::post(PostingDirective $d)`; `Allocation` is the only module that computes gross-to-net splits; no other module writes their tables.
4. Provider specifics never leak: only `Provider/Adapters/Daraja/*` may reference Daraja names; only `Provider/Adapters/PesaPal/*` may reference PesaPal names, URLs, or response codes. Static-analysis ban on `daraja`/`safaricom`/`pesapal` strings outside those namespaces.

### 4.4 Financial Write Path (the platform's core invariant)

Every state change that moves or acknowledges money follows this exact sequence inside one DB transaction:

```text
1. Resolve + lock the aggregate row (SELECT ... FOR UPDATE).
2. Validate the state transition against the state machine (Section 5.6).
3. Apply the domain mutation (status, amounts, snapshots).
4. Validate/record the payment allocation where the funds-flow model requires it
   (balancing enforced by deferred DB constraint).
5. Post balanced ledger entries via LedgerPoster (idempotent posting key,
   directive selected by funds-flow model + policy versions).
6. Create/update the merchant settlement expectation where applicable.
7. Insert the outgoing webhook event row (transactional outbox).
8. Insert the audit log row.
9. COMMIT. Only after commit: queue workers pick up outbox deliveries.
```

Failure anywhere rolls back everything — no ledger entry without state change, no settlement expectation without allocation, no webhook promising a state that didn't commit. Every financial phase's tests include an injected-failure case proving atomicity.

---

## 5. Backend Architecture

### 5.1 Directory Layout

```text
wallet/
  app/
    Console/Commands/            # audit:verify-chain, recon:run, close:daily, close:period,
                                 # wallet:route-doctor, capability:expiry-scan, ...
    Exceptions/                  # ApiExceptionHandler → error envelope (Section 11.7)
    Http/
      Middleware/                # ResolveCorrelationId, EnforceIdempotencyKey,
                                 # EnsureEnvironmentContext, VerifyProviderSource,
                                 # RequireStepUp, RequireRecentAuth, SetSecurityHeaders
    Modules/...                  # Section 4.3
    Support/
      Money/                     # Money value object, Currency registry, MoneyCast
      Ulid/                      # PublicId generator + HasPublicId trait
      Context/                   # OwnershipContext (Section 8.2)
  bootstrap/app.php
  config/
  database/
    migrations/                  # + database/migration-manifest.yaml
    seeders/                     # RegistrySeeder (products, currencies, permissions, roles,
                                 #   chart of accounts, purposes, funds-flow models,
                                 #   payment methods, settlement calendars, launch flags),
                                 # DevSeeder (sandbox fixtures)
  docs/
    architecture/adr/            # ADR-0001..0017; template in Phase 0
    architecture/data-dictionary/  # one .md per table group (Section 7.9)
    architecture/domain/         # merchant-finance.md, economic-beneficiary.md,
                                 # funds-flow-models.md, payment-allocation.md,
                                 # merchant-settlement.md, reserves-and-negative-balances.md,
                                 # chargebacks.md
    api/openapi.yaml             # generated + committed; parity-tested
    integrations/                # gate-w-evidence.md, gate-w-m-evidence.md,
                                 # product onboarding guide, webhook-verification-guide.md
    integrations/pesapal/        # adapter-contract.md, ipn-contract.md, status-mapping.md,
                                 # settlement-reconciliation.md, production-onboarding.md
    compliance/                  # legal-signoff.md, provider-money-flow-assessments/,
                                 # merchant-funds-custody-assessment.md,
                                 # merchant-kyb-responsibility-matrix.md,
                                 # refund-chargeback-responsibility-matrix.md,
                                 # tax-and-withholding-signoff.md,
                                 # card-data-responsibility-matrix.md
    contracts/                   # pesapal-capability-matrix.md,
                                 # pesapal-fee-and-settlement-schedule.md
    operations/                  # merchant-onboarding.md, merchant-offboarding.md,
                                 # daily-close.md, pilot-rollout.md
    runbooks/                    # Section 22 catalogue (35 runbooks)
    decisions/                   # blocking-ambiguities.md, conflicts.md
    traceability/matrix.csv
  routes/
    api_v1.php  providers.php  internal.php  web.php
  frontend/                      # Vue 3 app (Section 6)
  tests/
    Unit/ Feature/ Api/ Isolation/ Security/ Concurrency/ Contract/ Load/
  docker/  .github/workflows/  Makefile
```

### 5.2 Layered Responsibilities

| Layer | Rules |
|---|---|
| Controllers | Thin. Validated Form Request → application service → API Resource. No business logic, no direct Eloquent writes, no status assignment. |
| Form Requests | All validation (types, currency canonicalization, phone normalization, integer-minor amounts, purpose permissibility). `authorize()` delegates to policies. |
| Application services | One class per use case (`RegisterPayment`, `CreateCheckoutSession`, `InitiateStkAttempt`, `AllocatePayment`, `ApprovePayout`, `CreateMerchantSettlement`, `ResolveReconciliationException`, `RunDailyClose`). Own the transaction boundary and the Section 4.4 sequence. |
| Domain models | Guarded `$fillable`, casts (MoneyCast, encrypted casts), state accessors. **No public status setters** — transitions only through `TransitionAction` classes; a lint greps `->status =` outside `Transitions/`. |
| Transition actions | Validate `from → to` legality, required permissions, side effects. |
| Jobs | `OwnershipAwareJob` context (Section 8.5); every financial job idempotent (posting keys, natural keys). |
| Policies | One per owned resource; every method re-verifies ownership scope before permission. |

### 5.3 Money and Currency (Phase 2 primitives)

```php
// app/Support/Money/Money.php — final, immutable
final readonly class Money
{
    private function __construct(
        public int $amountMinor,      // integer minor units, never float
        public string $currency,      // char(3), uppercase, must exist in registry
    ) {}
    public static function of(int $amountMinor, string $currency): self;
    public function add(Money $other): self;        // throws CurrencyMismatch
    public function subtract(Money $other): self;   // throws CurrencyMismatch
    public function isPositive(): bool;
    public function format(): string;               // registry-driven minor units
    // NO fromFloat(). NO toFloat(). Their absence is tested by reflection.
}
```

- `currencies` table: `code char(3) pk`, `minor_units smallint`, `name`, `is_active`. Seeded KES; USD registry-ready.
- API accepts amounts only as integer `amount_minor` + `currency`; decimal floats → `VALIDATION_FAILED`.
- Excessive precision, zero, and negative amounts rejected (Scope §113(46–48)).

### 5.4 Public Identifiers

`HasPublicId` trait: ULID on `creating`, `public_id char(26) unique not null`. Route model binding binds on `public_id` **within ownership scope** (Section 8.4). Internal PKs never serialize (`NoInternalIdLeakTest` walks every Resource).

### 5.5 Provider Adapter Contracts (Phase 12 / 12A)

```php
namespace App\Modules\Provider\Contracts;

interface CollectionProviderAdapter
{
    public function initiateStk(StkRequest $r): StkInitiationResult;             // Daraja
    public function createOrder(OrderRequest $r): OrderCreationResult;           // PesaPal: order + redirect URL + order_tracking_id
    public function queryTransactionStatus(StatusQuery $q): StatusResult;        // SUCCEEDED|FAILED|PENDING|CANCELLED|NOT_FOUND|UNKNOWN
    public function requestRefund(RefundInstruction $i): RefundSubmissionResult;
    public function cancelOrder(CancelInstruction $i): CancelResult;             // where capability ORDER_CANCELLATION exists
    public function registerIpn(IpnRegistration $r): IpnRegistrationResult;      // where capability IPN_NOTIFICATION exists
}

interface PayoutProviderAdapter
{
    public function submitPayout(PayoutInstruction $i): PayoutSubmissionResult;
    public function queryPayoutStatus(StatusQuery $q): StatusResult;
    public function queryBalance(BalanceQuery $q): BalanceResult;
    public function requestReversal(ReversalInstruction $i): ReversalSubmissionResult;
}

interface SettlementReportProviderAdapter
{
    public function listAvailableReports(ReportQuery $q): ReportListResult;      // where SETTLEMENT_REPORT capability exists
    public function fetchReport(ReportReference $r): ReportFile;
}
```

Adapter rules:

1. Adapters are the only code aware of provider request/response formats, auth (Daraja OAuth token caching; PesaPal token acquisition with early refresh), and error-code mapping to Scope §84.4 categories.
2. Every adapter call is wrapped by `ProviderCallExecutor`: timeout budget, redacted structured logging, latency metrics, circuit breaker (open after N consecutive failures → provider account marked unhealthy; never silent failover).
3. **Ambiguity mapping mandatory:** transport timeout or unparseable response → `UNKNOWN`, never `FAILED`. Contract tests assert this per adapter, including PesaPal order submission.
4. Adapters exercised by contract tests against recorded fixtures + the Phase 16 simulator; production endpoints touched only via sandbox credentials until launch checklists pass.
5. An adapter method whose backing capability is absent for the account/merchant throws `CapabilityUnavailable` — it never silently degrades (Scope §29).

### 5.6 State Machine Catalogue

Defined once, in code, as enums + transition maps; state strings serialize exactly as defined (products map on the names).

- **Collection (`payments.status`)** — Scope §37.2: `CREATED, PENDING_CUSTOMER_ACTION, SUBMITTED, PROVIDER_ACCEPTED, PROCESSING, SUCCEEDED, PARTIALLY_RECEIVED, OVERPAID, FAILED, REJECTED, CANCELLED, EXPIRED, UNKNOWN, REVERSED, PARTIALLY_REFUNDED, REFUNDED`. `settlement_status`, `reconciliation_status`, and `allocation_status` are separate columns.
- **Payment attempt** — `CREATED, SUBMITTING, SUBMITTED, PROVIDER_ACCEPTED, PENDING_CUSTOMER_ACTION, PROCESSING, SUCCEEDED, FAILED, CANCELLED_BY_CUSTOMER, EXPIRED, TIMED_OUT, UNKNOWN`. Append-only; one non-terminal attempt per payment.
- **Checkout session** — Scope §43: `CREATED, REDIRECTED, RETURNED, CANCELLED, EXPIRED, COMPLETED, SUPERSEDED`. `RETURNED` triggers a status query; only the status-query/IPN corroborated result transitions the payment.
- **Payout** — Scope §57.4 (incl. `RESERVED`, `TIMED_OUT`, `UNKNOWN`, `RECONCILIATION_EXCEPTION`).
- **Refund** — `REQUESTED, AWAITING_APPROVAL, APPROVED, REJECTED, SUBMITTING, SUBMITTED, PROCESSING, SUCCEEDED, FAILED, TIMED_OUT, UNKNOWN, CANCELLED`.
- **Reversal** — Scope §61.
- **Citrus settlement** — Scope §73. **Merchant settlement** — Scope §53: `NOT_APPLICABLE, EXPECTED, AWAITING_PROVIDER, PROVIDER_CONFIRMED, IN_TRANSIT, SETTLED, PARTIALLY_SETTLED, DELAYED, HELD, RETURNED, FAILED, CANCELLED, UNKNOWN, RECONCILIATION_EXCEPTION`.
- **Batch** — `DRAFT, VALIDATING, VALIDATION_FAILED, AWAITING_APPROVAL, PARTIALLY_APPROVED, APPROVED, REJECTED, CANCELLED, EXECUTING, PARTIALLY_COMPLETED, COMPLETED, COMPLETED_WITH_FAILURES`.
- **Approval request** — `PENDING, PARTIALLY_APPROVED, APPROVED, REJECTED, EXPIRED, INVALIDATED`.
- **Provider merchant onboarding** — Scope §68: `NOT_STARTED, DATA_REQUIRED, DOCUMENTS_PENDING, READY_FOR_SUBMISSION, SUBMITTED_TO_PROVIDER, PROVIDER_REVIEW, REMEDIATION_REQUIRED, APPROVED, REJECTED, SUSPENDED, EXPIRED, OFFBOARDING, CLOSED`.
- **Compliance status** — Scope §67: `NOT_REQUIRED, PENDING, CLEAR, REVIEW_REQUIRED, RESTRICTED, FAILED, EXPIRED, PROVIDER_MANAGED`.
- **Merchant status (mirrored)** — Scope §69: `ACTIVE, PAYMENTS_SUSPENDED, SETTLEMENTS_SUSPENDED, REFUNDS_ONLY, OFFBOARDING, CLOSED, COMPLIANCE_HOLD` (+ `CLOSURE_BLOCKED` internal).
- **Reserve** — Scope §51: `PROPOSED, ACTIVE, PARTIALLY_RELEASED, RELEASED, APPLIED, EXPIRED, DISPUTED, CANCELLED`.
- **Chargeback** — Scope §62: `RECEIVED, NOTIFIED, EVIDENCE_REQUIRED, EVIDENCE_SUBMITTED, UNDER_PROVIDER_REVIEW, WON, LOST, PARTIALLY_WON, ACCEPTED, EXPIRED, CLOSED`.
- **Case** — `OPEN, ACKNOWLEDGED, ASSIGNED, INVESTIGATING, ESCALATED, RESOLVED, CLOSED, REOPENED`.
- **Reconciliation exception** — `OPEN, ASSIGNED, INVESTIGATING, PROPOSED, AWAITING_APPROVAL, RESOLVED, DISMISSED`.
- **Incoming webhook** — `RECEIVED, ACKNOWLEDGED, QUEUED, PROCESSED, IGNORED_REPLAY, FAILED_VALIDATION, EXCEPTION`. **Outgoing delivery** — `PENDING, DELIVERING, DELIVERED, RETRYING, DEAD_LETTERED, REPLAYED, PAUSED`.
- **Daily close** — `OPEN, PREPARING, PREPARED, APPROVED, INCOMPLETE, REOPENED`. **Accounting period** — `OPEN, PRELIMINARY_CLOSE, FINAL_CLOSE, REOPENED`.
- **Provider operating mode** — Scope §105: `NORMAL, DEGRADED, COLLECTIONS_PAUSED, STATUS_QUERIES_ONLY, REFUNDS_ONLY, SETTLEMENT_MONITORING_ONLY, FULLY_SUSPENDED`.

Every transition map ships an exhaustive `StateMachineTest` (legal transitions succeed; every illegal pair throws → API `409 TRANSACTION_STATE_CONFLICT`).

### 5.7 Idempotency Implementation (Phase 10)

Table `idempotency_keys`: `id`, `application_id FK`, `operation varchar(64)`, `key_hash char(64)`, `request_hash char(64)`, `response_status smallint`, `response_body jsonb`, `resource_public_id char(26) null`, `locked_at`, `completed_at`, `expires_at`, unique `(application_id, operation, key_hash)`.

Middleware algorithm for `product_financial_mutation` routes: (1) missing header → 422; (2) compute hashes; (3) `INSERT ... ON CONFLICT DO NOTHING`; (4) conflict + same hash + completed → replay with `Idempotency-Replayed: true`; (5) conflict + different hash → `409 IDEMPOTENCY_CONFLICT`; (6) conflict + in-flight → `409` retryable with `Retry-After`; (7) DB uniqueness is the final guarantee, Redis lock an optimization only. Internal financial mutations use server-generated natural keys (approval action unique per approver; posting keys; close run keys) plus UI duplicate-submit guards.

---

## 6. Frontend Architecture

### 6.1 Stack and Structure

Vue 3 (script setup) + TypeScript strict + Vite + Pinia + Vue Router + Tailwind. No jQuery. No secret keys (CI bundle grep).

```text
frontend/src/
  api/client.ts + api/generated/      # typed client from OpenAPI; correlation IDs; ApiError type
  stores/ auth.ts context.ts theme.ts notifications.ts
  router/index.ts                     # guards are UX-only
  layouts/ AuthLayout AppLayout PrintLayout
  components/
    ui/                               # Button, Input, Select, Modal, Toast, Card, Tabs, Badge,
                                      # Table, ResponsiveRecordList, Skeleton, EmptyState,
                                      # ErrorState, ConfirmDialog, StepUpDialog, CopyField,
                                      # DateRangePicker, AsyncStateWrapper
    money/MoneyText.vue  masking/MaskedAccount.vue  status/TransactionStatus.vue
    status/DataFreshness.vue  provider/ProviderHealth.vue
    approvals/ApprovalTimeline.vue  audit/AuditTimeline.vue
    allocation/AllocationBreakdown.vue          # gross → fees → commission → tax → reserve → net
    merchant/MerchantPositionCard.vue           # per-component position values, never one balance
    settlement/SettlementAgingBar.vue  chargeback/DeadlineCountdown.vue
    launch/KillSwitchPanel.vue  launch/FlagPanel.vue  close/CloseChecklist.vue
    forms/FormField FormErrorSummary AmountInput PhoneInput
  composables/ useForm usePermissions usePagination useFilters useConfirm useStepUp
  pages/                              # one directory per Scope §88 area (50 areas)
  types/                              # Money, enums generated from backend state machines
```

### 6.2 Route Structure (mirrors Scope §88)

```text
/login /login/sent /auth/consume/:token
/                          → Overview dashboard
/collections /collections/:id            /checkout-sessions/:id
/payouts /payouts/:id                    /payout-batches /payout-batches/:id
/refunds /refunds/:id                    /reversals /reversals/:id
/transfers /transfers/:id                /approvals
/beneficiaries /beneficiaries/:id
/products /products/:id                  /merchant-accounts /merchant-accounts/:id
/provider-merchants /provider-merchants/:id
/merchant-onboarding /merchant-onboarding/:id
/settlement-destinations /settlement-destinations/:id
/merchant-positions /merchant-positions/:merchant
/merchant-settlements /merchant-settlements/:id     /settlement-aging
/merchant-statements /merchant-statements/:id
/policies/commissions /policies/fees /policies/taxes /policies/reserves
/reserves /reserves/:id                  /negative-balances
/chargebacks /chargebacks/:id            /cases /cases/:id
/daily-close /daily-close/:run           /accounting-periods
/provider-contracts /provider-contracts/:id
/applications /applications/:id          /routes /routes/:id
/providers /provider-accounts/:id        /balances
/banks /bank-accounts/:id                /settlements /settlements/:id
/reconciliation /reconciliation/runs/:id /exceptions /exceptions/:id
/ledger /ledger/accounts/:id /ledger/transactions/:id
/reports /exports
/webhooks/incoming /webhooks/outgoing /webhooks/endpoints
/credentials /users /users/:id /roles /audit-logs /security-events
/launch-controls                         # flags, kill switches, operating modes, pilot limits
/notifications /system-health /settings /support
/profile /profile/sessions /profile/security
```

Route meta declares `requiredPermission`; the backend independently authorizes every API call.

### 6.3 Mandatory UI States

Every data view implements: loading (skeletons), empty, success, failure (retry + correlation ID), **partial success**, **unknown/delayed** (visually distinct from failure), and **stale-data** (freshness stamps). `AsyncStateWrapper` standardizes this; component tests assert each state renders.

### 6.4 Safe Rendering and Frontend Security Rules

Interpolation only (`v-html` banned by ESLint except one audited sanitizing component); the frontend never computes financial truth (amounts, refundable balances, allocations, positions, approval eligibility all come from API fields); loud environment context (amber SANDBOX / red PRODUCTION persistent banners); high-risk submissions restate provider, provider account, funding/destination, amount, currency, beneficiary before confirm.

---

## 7. Database Architecture

### 7.1 Conventions (apply to every table; deviations are defects)

1. `id bigint generated always as identity primary key` — internal only.
2. `public_id char(26) not null unique` — ULID on every externally referenced table.
3. Ownership keys per Section 8.1 with FK + index; composite indexes lead with ownership keys.
4. `created_at`/`updated_at timestamptz not null`; domain timestamps nullable `timestamptz`.
5. Money: `{name}_minor bigint` + `currency char(3) references currencies(code)` + `CHECK (currency = upper(currency))`.
6. Soft deletes only on non-financial registry rows; financial rows never soft- or hard-deleted — status transitions only; registry rows with financial references deactivated, never deleted (FK `ON DELETE RESTRICT`).
7. Every status column is a Postgres enum or `varchar` + `CHECK` matching the state machine exactly.
8. Migrations expand-and-contract; each registered in `database/migration-manifest.yaml` with class `additive | backfill | contract | forward-repair`.

### 7.2 Identity and Access Tables

| Table | Purpose / key columns | Constraints, security notes |
|---|---|---|
| `users` | `public_id`, `email citext unique`, `name`, `user_type enum(internal, delegated_merchant)`, `status enum(active, suspended, deactivated)`, `theme_preference`, `totp_secret text null (encrypted)`, `totp_confirmed_at`, `last_login_at`, `identity_version int` | **No password column.** Deactivation revokes sessions + links. `identity_version` bumps on privilege change → session revalidation. Never deleted |
| `user_memberships` | `user_id`, `scope_type enum(global, product, merchant_account)`, `product_id null`, `merchant_account_id null`, `source enum(internal, federated)`, `source_identity_version`, `status`, unique scope tuple | CHECK enforces scope columns match `scope_type` |
| `roles` / `permissions` / `role_permissions` / `user_roles` / `user_permission_overrides` | Seeded from `docs/auth/permission-matrix.yaml` incl. the Scope §18 merchant-finance permissions; `permissions.is_sensitive`, `requires_step_up`; roles granted within membership scope; deny beats grant | `PermissionMatrixParityTest` |
| `magic_link_requests` | `email`, `user_id null`, `token_hash char(64) unique`, `audience enum(login, step_up)`, `context jsonb` (signed intent), `expires_at`, `consumed_at`, `revoked_at`, `created_ip`, `created_user_agent`, `status` | Raw token never stored; atomic single-row consume; retention 90 d |
| `sessions` | Laravel table + `user_id`, `ip`, `user_agent`, `assurance_level enum(magic_link, step_up)`, `assurance_expires_at` | Device visibility; admin revocation |
| `invitations` | `public_id`, `email`, `invited_by`, scope, proposed `role_id`, `token_hash unique`, `expires_at (72h)`, `accepted_at`, `revoked_at`, `status` | Hashed token; rate-limited acceptance |
| `security_events` | `user_id null`, `event_type`, `severity`, `ip`, `user_agent`, `context jsonb (redacted)`, `correlation_id` | Append-only; feeds alerting |
| `oauth_clients` (Passport) | linked via `applications.oauth_client_id` | Secrets hashed; plaintext shown once |

### 7.3 Registry Tables

| Table | Purpose / key columns | Notes |
|---|---|---|
| `legal_entities` | `public_id`, `name`, `registration_number`, `country`, `status` | Seeded Citrus Labs Limited |
| `products` | `public_id`, `legal_entity_id`, `name`, `code char(3-4) unique`, `slug unique`, `status enum(draft, sandbox_only, active, suspended, retired)`, owner contacts jsonb, `default_currency`, `supported_currencies jsonb`, `default_timezone`, `risk_profile`, `default_approval_policy_id`, `reconciliation_policy jsonb`, `retention_policy jsonb`, `identity_verification_endpoint null`, `commercial_policy_registry jsonb` | Retirement never deletes |
| `applications` | `public_id`, `product_id`, `environment enum`, `name`, `status`, `oauth_client_id`, `allowed_scopes jsonb`, `allowed_ips jsonb null`, `webhook_secret_current_id`, `rate_limit_policy jsonb`, `max_transaction_minor`, `daily_limit_minor`, `monthly_limit_minor`, `supported_currencies/methods/directions jsonb`, **`permitted_economic_purposes jsonb`**, rotation/last-use timestamps, `incident_state` | Unique `(product_id, environment, name)`; entitlement source (Section 18) |
| `application_webhook_secrets` | `application_id`, `key_id unique`, `secret (encrypted)`, `status enum(active, retiring, revoked)` | Dual-key rotation |
| `merchant_accounts` | `public_id`, `product_id`, `environment`, `external_merchant_ref`, `display_name`, **`merchant_status enum(active, payments_suspended, settlements_suspended, refunds_only, offboarding, closed, compliance_hold)`**, **`closure_state enum(none, closure_blocked) default none`**, `contact_routing jsonb`, `synced_at`, `sync_source jsonb` | Unique `(product_id, environment, external_merchant_ref)`; status effects per Scope §69 |
| `banks` | Scope §23 fields | — |
| `bank_accounts` + `bank_account_purposes` + `bank_account_versions` | Scope §24 fields: encrypted + masked split, purposes, verification, effective dates, maker-checker states | Citrus Labs accounts **only**; merchant destinations live in §7.4 tables |
| `payment_providers` | Scope §26 fields | Seeded: Safaricom Daraja (full capability metadata), **PesaPal** (collection capabilities confirmed-from-docs; merchant/settlement capabilities blank until contract), PesaLink placeholder, manual-bank-file placeholder |
| `provider_accounts` | Scope §27 fields incl. `merchant_identifier`, `settlement_bank_account_id null`, callback/IPN config jsonb, **`contract_id`, `contract_version`, `capability_version`, `settlement_model`, `supports_platform_merchants`, `supports_submerchants`, `supports_split_settlement`, `supports_direct_merchant_settlement`, `supports_general_disbursement`, `supports_chargebacks`, `supports_reserves`** (generated from versioned capability records), `operating_mode`, health/status fields | Unique `(provider_id, environment, merchant_identifier)` |
| `provider_credentials` / `provider_certificates` | encrypted payloads, key references, expiry, rotation timestamps, status | Never echoed; expiry alerts |
| `provider_wallets` / `provider_balances` | Scope §74 fields incl. thresholds and freshness | Never labeled bank accounts |
| `payment_methods` | codes per Scope §34 incl. `pesapal_checkout` | Seeded |
| `currencies` / `app_settings` / `configuration_changes` | Section 5.3; every config change versioned + audited | — |
| `economic_purposes` | `code unique` (Scope §31 values), `beneficiary_type_required`, `ledger_template_ref`, `refund_policy_ref`, `settlement_policy_ref`, `reconciliation_policy_ref`, `tax_policy_ref`, `route_eligibility jsonb`, `status` | Registry-controlled; no unreviewed extension |
| `funds_flow_models` | `code unique` (Scope §33 values), `enabled boolean`, `activation_gate_ref`, definition jsonb (first recipient, controller, owner, refund funder, chargeback absorber, ledger accounts, evidence, reports, approvals) | `CITRUS_COLLECTION_MERCHANT_PAYOUT.enabled = false` seeded; DB CHECK blocks enabling without `compliance_approval_ref` |
| `launch_flags` | Scope §106.1 flags: `key unique`, `value boolean`, `default_value`, `changed_by`, `reason` | Append-only change history; `citrus_paybill_merchant_funds_enabled` default false |
| `settlement_calendars` / `settlement_calendar_rules` | Scope §55: business days, holidays, cut-offs, delays by method, holding periods, reserve release schedule, timezone, `version` | Versioned; historical snapshots preserved |

### 7.4 Provider Commercial and Merchant-Finance Registry Tables

| Table | Key columns | Constraints |
|---|---|---|
| `provider_contracts` / `provider_contract_versions` | `provider_id`, `title`, `effective_from/until`, `countries/currencies/products jsonb`, `merchant_models jsonb`, `settlement_models jsonb`, `fee_summary jsonb`, `reserve_terms jsonb`, `limit_terms jsonb`, `refund_rules jsonb`, `chargeback_rules jsonb`, `settlement_slas jsonb`, `support_contacts jsonb`, `retention_obligations jsonb`, `termination jsonb`, `renewal_date`, `evidence_file_id`, `status` | Route activation requires a covering active version (DB-checked via route FK + trigger); expiry alerts at 60/30/7 days |
| `provider_fee_schedules` | `contract_version_id`, `method`, `fee_structure jsonb`, `version`, effective dates | Reconciled against actual fees |
| `provider_service_levels` / `provider_operating_limits` | SLA and limit terms per contract version | Settlement SLA feeds monitoring |
| `provider_capabilities` | `code unique` (Scope §29 list), `description` | Seeded |
| `provider_account_capabilities` | `provider_account_id`, `capability_id`, `status enum(untested, tested, approved, suspended, expired)`, `effective_from/until`, `evidence_ref`, `contract_version_id` | Effective dates must cover transaction submission (trigger); routes fail closed on absence |
| `provider_merchant_capabilities` | same shape per `provider_merchant_account_id` | — |
| `provider_merchant_accounts` | Scope §14 fields: `public_id`, `legal_entity_id`, `product_id`, `application_id`, `environment`, `merchant_account_id`, `provider_id`, `provider_account_id`, `provider_merchant_identifier`, `provider_submerchant_identifier`, `provider_profile_reference`, `commercial_model enum(direct_merchant, submerchant, platform_managed, split_settlement, gross_settlement)`, `onboarding_status` (§5.6 machine), `kyb_status`, `aml_status`, `sanctions_status`, `risk_status`, `settlement_status`, `provider_terms_version`, `provider_fee_schedule_version`, `commission_policy_id`, `reserve_policy_id`, `settlement_calendar_id`, `activated_at`, `suspended_at`, `closed_at`, `last_provider_sync_at`, `configuration_version`, `metadata_redacted jsonb` | Unique `(provider_account_id, merchant_account_id)`; composite FK `(merchant_account_id, product_id, environment)` makes cross-product/environment use unrepresentable; no transaction may reference a non-`APPROVED` row (service + partial-index guard) |
| `provider_merchant_account_events` | `provider_merchant_account_id`, `event_type` (§6.1 events), `payload jsonb`, `actor`, `occurred_at` | Append-only |
| `merchant_settlement_destinations` | `public_id`, `merchant_account_id`, `provider_merchant_account_id`, `destination_type enum(bank_account, mobile_wallet, pesapal_merchant_balance, other_provider_verified_destination)`, `bank_id null`, `currency`, `country`, `account_name`, `account_number_encrypted/masked`, `mobile_number_encrypted/masked`, `provider_destination_reference`, `verification_method`, `verification_status`, `provider_verification_reference`, `verified_at/by`, `effective_from/until`, `status`, `current_version_id`, `change_risk_score`, `cooling_off_until` | Separate from `bank_accounts` by design |
| `merchant_settlement_destination_versions` | `destination_id`, `version int`, full snapshot jsonb (masked + encrypted refs), `created_by`, `approved_by`, `activated_at` | **Trigger blocks UPDATE/DELETE — versions immutable**; destination changes create versions + invalidate approvals + start cooling-off + notify out-of-band (service) |
| `merchant_onboarding_cases` | `public_id`, `merchant_account_id`, `provider_merchant_account_id null`, `status` (§5.6 onboarding machine), data-collection checklist jsonb, `provider_submission_ref`, `rejection_reason`, `remediation jsonb`, `expiry_at`, `assigned_to` | No production route before `APPROVED` (route-activation checklist + service guard) |
| `merchant_onboarding_documents` | `case_id`, `document_type`, `file_id`, `expires_at null`, `status` | Retention per policy; never deleted; expired documents unusable where provider policy prohibits |
| `merchant_compliance_statuses` | `merchant_account_id`, `provider_merchant_account_id null`, `dimension enum(kyb, beneficial_owner, sanctions, pep, adverse_media, prohibited_business, risk_rating)`, `status` (§5.6 compliance machine), `provider_managed_by null`, `policy_version`, `last_verified_at`, `evidence_ref`, `review_due_at` | Expiry scan pauses routes + alerts |
| `compliance_holds` | `public_id`, scope refs (merchant/provider-merchant/payment/settlement), `hold_type enum(collections, settlements, refunds, destination_changes, payouts, provider_account)`, `reason`, `created_by`, `released_by null`, `released_at null`, `legal_hold boolean` | Creator ≠ releaser (trigger); holds never mutate amounts/beneficiaries |
| `legal_holds` | `public_id`, `subject_type/subject_id`, `reason`, `created_by`, `released_at null` | Suspends deletion/archival for held evidence |

### 7.5 Policy and Allocation Tables

| Table | Key columns | Constraints |
|---|---|---|
| `commission_policies` / `commission_policy_versions` | `public_id`, `name`, `product_id`, applicability jsonb; versions: `fixed_minor`, `percentage_bp`, `minimum_minor`, `maximum_minor`, `rounding_mode`, `effective_from/until`, `created_by`, `activated_by` | Creator ≠ activator (trigger); versions immutable |
| `fee_policies` / `fee_policy_versions` | Scope §48 fields: `calculation_basis`, `rounding_mode`, `minimum/maximum_minor`, `effective_from/until`, `tax_inclusive`, `fee_bearer enum(merchant, citrus, customer, provider)`, `refund_treatment`, `chargeback_treatment`, tier structure jsonb, waiver/promo windows | Versioned; deterministic |
| `tax_policies` / `tax_policy_versions` | `classification enum(vat, withholding, none)`, `rate_bp`, `jurisdiction`, `inclusive boolean`, `invoice_ref_required`, `effective dates`, `approved_by` | Finance/tax approval required for activation |
| `reserve_policies` / `reserve_policy_versions` | `reserve_type` (Scope §51), `percentage_bp` / `fixed_minor`, `holding_days`, `release_schedule jsonb`, `held_by enum(provider, citrus, contractual_deduction)` | Versioned |
| `payment_allocations` | `public_id`, `payment_id FK unique-per-active`, ownership keys, `gross_amount_minor`, `provider_fee_minor`, `provider_fee_bearer`, `citrus_fixed_fee_minor`, `citrus_percentage_fee_minor`, `citrus_total_commission_minor`, `merchant_gross_minor`, `merchant_net_minor`, `tax_withheld_minor`, `reserve_minor`, `refund_reserve_minor`, `chargeback_reserve_minor`, `rounding_adjustment_minor`, `currency`, `calculation_version`, `commission_policy_version_id`, `fee_policy_version_id`, `tax_policy_version_id`, `reserve_policy_version_id`, `status enum(created, validated, submitted, adjusted, superseded)`, `submitted_at null` | **Deferred constraint trigger: `gross = merchant_net + citrus_total_commission + provider_fee(borne from payment) + tax_withheld + reserves + rounding_adjustment` — an unbalanced allocation cannot commit.** Trigger blocks UPDATE after `submitted_at` set; corrections create a superseding allocation |
| `payment_allocation_items` | `allocation_id`, `component enum`, `amount_minor`, `beneficiary_type/id`, `ledger_account_hint` | Sum-per-component equals parent columns (trigger) |
| `settlement_instructions` / `settlement_instruction_items` | `allocation_id`, `provider_merchant_account_id`, `destination_version_id`, instruction snapshot jsonb, `provider_instruction_ref`, `status` | Immutable snapshot after provider acceptance; contract tests compare vs provider statements |

### 7.6 Collection, Checkout, and Provider-Transaction Tables

| Table | Key columns | Constraints |
|---|---|---|
| `payments` | v1.0 fields (`public_id`, ownership keys, `external_reference`, `payment_reference unique` immutable, `customer_reference`, `description`, `expected/received/refunded/pending_refund_minor`, `currency`, `payment_method_id`, `status`, `settlement_status`, `reconciliation_status`, `expires_at`, `risk_result`, error fields, timestamps) **plus**: `economic_purpose` (FK registry, not null), `economic_beneficiary_type/id`, `contractual_seller_type/id`, `merchant_of_record_type/id`, `funds_recipient_type/id`, `funds_flow_model` (FK), `reference_class`, `commercial_policy_reference`, `commercial_policy_version`, `refund_funding_party enum(provider, merchant, citrus_labs, shared, undetermined_blocked)`, `allocation_status enum(not_required, pending, allocated, submitted, adjusted)`, `provider_merchant_account_id null`, `checkout_required boolean` | Unique `(application_id, external_reference)`. CHECK constraints: purpose mandatory; merchant purpose ⇒ `merchant_account_id` + beneficiary `PRODUCT_MERCHANT_ACCOUNT`; Citrus purpose ⇒ beneficiary `CITRUS_LABS_LIMITED`; `PROVIDER_DIRECT_MERCHANT_SETTLEMENT` ⇒ `provider_merchant_account_id not null`; allocation required before provider submission where commission/deductions apply (service + trigger); **beneficiary/purpose/funds-flow columns immutable after provider submission (trigger)** |
| `payment_references` | `payment_id`, `reference unique`, `status`, `expires_at` | Reference lifecycle |
| `payment_attempts` | v1.0 fields + `attempt_type enum(stk, c2b, pesapal_checkout, pesalink, card)`, `checkout_session_id null` | Unique `(provider_account_id, provider_checkout_request_id)`; partial unique: one non-terminal attempt per payment |
| `checkout_sessions` | Scope §43 fields: `public_id`, `payment_id`, `provider_account_id`, `provider_merchant_account_id null`, `return_url`, `cancel_url`, `expires_at`, `status`, `provider_order_tracking_id null`, `provider_redirect_url`, `single_use_state`, `signed_state char(64)`, `correlation_id` | Unique `(provider_account_id, provider_order_tracking_id)` where not null; single-use enforced by status machine; return-URL allowlist validated at creation |
| `mpesa_transactions` | v1.0 fields (`mpesa_receipt`, type, bill reference, masked/hashed msisdn, amount, provider time, payload ref, match status) | **Unique `(provider_account_id, mpesa_receipt)`** — duplicate-credit guard; same receipt + different amount → integrity exception |
| `pesapal_transactions` | `public_id`, `provider_account_id`, `provider_merchant_account_id null`, `order_tracking_id`, `merchant_reference`, `payment_method_reported`, `confirmation_code null`, `status_reported`, `amount_minor`, `currency`, `provider_fee_minor null`, `provider_time timestamptz`, `payload_ref` (FK incoming_webhooks), `status_query_count`, `last_status_query_at`, `matched_payment_id null`, `match_status` | **Unique `(provider_account_id, order_tracking_id)`** — the PesaPal duplicate-credit guard; unmatched → exception, never guessed |

### 7.7 Payout / Refund / Beneficiary / Approval / Chargeback / Case Tables

| Table | Key columns | Constraints |
|---|---|---|
| `beneficiaries` / `beneficiary_versions` | v1.0 fields; versions immutable; destination change → new version + invalidated approvals | Trigger-protected |
| `payouts` / `payout_attempts` | v1.0 fields incl. beneficiary-version pinning, route snapshot, idempotency hash | Partial unique: one non-terminal attempt — the no-blind-failover DB guarantee |
| `payout_batches` / `payout_batch_items` | v1.0 fields | Item status independent of batch |
| `refunds` / `refund_attempts` | v1.0 fields **plus**: `refund_funding_party` (resolved, not null at approval), `funding_source enum(provider_unsettled, merchant_reserve, merchant_negative_balance, citrus_funds, provider_refund)`, `reserve_id null`, `merchant_position_impact jsonb`, `tax_adjustment_minor`, `product_cancellation_reference` | Over-refund impossible: `RefundAllocator` row-lock + aggregate trigger; funding party `undetermined_blocked` → creation rejected |
| `reversals` | Scope §61 fields | Unsolicited reversals attributed to provider |
| `internal_transfers` | Scope §64 fields | Own state machine + approval + evidence |
| `approval_policies` / `approval_requests` / `approval_actions` | v1.0 fields; `material_snapshot jsonb`; maker-checker trigger; unique `(request_id, actor_user_id)` | Approval subjects extended to destinations, provider merchants, policies, reserves, holds, capabilities, daily close, period reopen |
| `risk_rules` / `risk_assessments` | Scope §66 rule types; decisions `ALLOW, ALLOW_WITH_MONITORING, REVIEW, HOLD, DENY`; launch-capable for customer-to-merchant payments | Holds preserve original instruction |
| `review_queue_items` | `public_id`, `queue enum(pre_execution, post_execution)`, `subject refs`, `trigger_rule`, `status`, `decision`, `decided_by`, `decision_reason` | Decisions immutable |
| `chargebacks` | Scope §62 fields: `public_id`, `payment_id`, `merchant_account_id`, `provider_id`, `reason_code`, `disputed_amount_minor`, `provider_fee_minor`, `response_deadline`, `evidence_owner`, `funds_debited jsonb`, `reserve_impact jsonb`, `merchant_payable_impact jsonb`, `citrus_impact jsonb`, `status`, `final_result`, `reconciliation_status` | CHECK: disputed amount ≤ original eligible + provider-permitted fees; duplicate provider events idempotent by provider reference |
| `chargeback_events` / `chargeback_evidence` / `chargeback_adjustments` | lifecycle events; evidence files with deadlines; financial adjustments linked to postings | Append-only events |
| `cases` | Scope §81 fields: `public_id`, `case_type` (17 types), linked refs, `complainant_type`, `merchant_account_id null`, `severity`, `priority`, `assigned_to`, `acknowledged_at`, SLA fields, `resolution`, `closure_reason`, `reopened_count` | Scope isolation; SLA timers |
| `case_parties` / `case_events` / `case_notes` / `case_evidence` / `case_assignments` / `case_sla_events` | supporting entities | Append-only events; evidence via `uploaded_files` |
| `external_communications` | `public_id`, `case_id null`, transaction refs, `channel`, `sender`, `recipient`, `subject`, `redacted_body_ref`, `attachments jsonb`, `response_deadline`, `acknowledged_at` | Immutable communication log (Scope §81) |

### 7.8 Ledger, Settlement, Merchant-Finance, Reconciliation, Close Tables

| Table | Key columns | Constraints |
|---|---|---|
| `ledger_accounts` | `code unique`, `name`, `category` (Scope §71.2 incl. merchant-finance categories), `currency`, dimension FKs (`product_id`, `merchant_account_id null`, `provider_account_id null`, `bank_account_id null`), `status` | Chart seeded per Scope §71.2–71.3 incl. merchant payable, settlement clearings, commission receivable/revenue, fee expense/recoverable, refund liability, chargeback receivable, reserve liability, negative-balance receivable, tax withholding payable, unallocated merchant funds suspense, adjustment accounts |
| `ledger_transactions` | `public_id`, `posting_key unique` (deterministic, e.g. `payment:{id}:succeeded`, `merchant_settlement:{id}:settled`), `event_type`, `source_type/id`, `funds_flow_model`, policy version refs, `occurred_at`, `posted_at`, `correlation_id` | Trigger blocks UPDATE/DELETE |
| `ledger_entries` | `transaction_id`, `account_id`, `direction`, `amount_minor > 0`, `currency` | **Deferred trigger: per-transaction, per-currency debits = credits at commit.** Trigger blocks UPDATE/DELETE |
| `settlements` / `settlement_batches` | Scope §73 fields; multi-product allocation by transaction records | Wrong-account settlement → critical exception |
| `merchant_settlements` | Scope §53 fields incl. `settlement_destination_version_id` (pinned), `payment_allocation_id`, gross/deductions/net, `expected_settlement_date`, provider/batch/bank references, `settlement_sla_deadline`, `hold_reason`, `return_reason`, `status`, `reconciliation_status` | **CHECK/trigger: net = allocation merchant net after authorised adjustments; destination version must be active at instruction time; settlement to inactive destination unrepresentable** |
| `merchant_settlement_events` | `merchant_settlement_id`, `event_type` (§6.3 events), payload, occurred_at | Append-only |
| `merchant_financial_positions` | `merchant_account_id unique per currency`, component columns per Scope §52 (pending collection, successful collection, expected settlement, provider-confirmed, settled, held, reserve, payable, receivable, citrus receivable, refund liability, chargeback liability, negative balance, exception count), `as_of`, `sources jsonb` | Maintained transactionally from postings; freshness stamped; **negative-balance offsets cross-merchant unrepresentable (offsets reference one merchant FK)** |
| `merchant_statements` / `merchant_statement_lines` | Scope §56 fields; `statement_version`; line totals | **Trigger: line totals = statement summary**; reproducible from immutable sources |
| `reserves` | Scope §51 fields: `public_id`, `merchant_account_id`, `reserve_type`, `held_by`, scope (merchant/payment/batch), `amount_minor`, `released_minor`, `status`, `policy_version_id` | **Trigger: movements cannot release more than active balance** |
| `reserve_movements` / `reserve_release_schedules` | movement type, amount, linked refs; schedules from policy + calendar | Append-only movements |
| `provider_statements` / `bank_statements` / `statement_lines` | v1.0 fields + `report_type enum(transaction, settlement, fee, refund, chargeback, reserve, merchant_statement, onboarding)`, `schema_version`, unknown-column preservation jsonb | Unique file-hash + content-hash; quarantine on parse failure; period/currency validation; duplicate-line detection; amount balancing |
| `reconciliation_runs` / `reconciliation_items` / `reconciliation_exceptions` | v1.0 fields + run types for allocation, fee, commission, merchant-net, merchant-settlement, destination, statement, reserve, negative-balance, refund, chargeback, three-way, four-way; exception types per Scope §76.3 | Wrong-merchant / wrong-destination auto-critical; materiality thresholds in config |
| `daily_close_runs` / `daily_close_items` | `close_date (Africa/Nairobi)`, scope (provider account / settlement model), Scope §77 output components as items, `status`, `prepared_by`, `approved_by`, `reopen_history jsonb` | Preparer ≠ approver (trigger); late events post to current period with original timestamps + business-date adjustment |
| `accounting_periods` / `accounting_period_actions` | `period (YYYY-MM)`, `status`, completeness checks jsonb, sign-offs, reopen reason/approval | **Trigger: cannot reach `FINAL_CLOSE` while material exceptions exceed policy threshold**; reopen never edits posted entries |

### 7.9 Integration, Files, Ops Tables

| Table | Key columns | Constraints |
|---|---|---|
| `incoming_webhooks` / `incoming_webhook_attempts` | v1.0 fields; raw payload immutable; payload-hash replay index; PesaPal IPNs land here with `endpoint` recording the secret-path route | Persist-before-ack; oversized rejected pre-parse |
| `webhook_endpoints` / `outgoing_webhook_events` / `webhook_deliveries` | v1.0 fields; transactional outbox; signing per W-A07; dead-letter 72 h; pause-on-failure | Cross-application event/endpoint mismatch unrepresentable |
| `idempotency_keys` | Section 5.7 | — |
| `uploaded_files` | v1.0 fields + purposes `(batch_upload, statement, evidence, export, verification, kyb_document, chargeback_evidence, contract_document)`; `scan_status` gate; `retention_until`; `legal_hold boolean` | Private bucket; signed URLs; quarantine |
| `exports` | v1.0 fields + masked-by-default policies | Scope re-validated at execution |
| `notifications` | + Scope §91 merchant-finance catalogue; recipient scope filtering; category mute rules (security/critical unmutable) | — |
| `audit_logs` | v1.0 fields (actor, scope, action, target, before/after safe values, reason, assurance, IP/UA, correlation, `prev_hash`, `row_hash`) | Append-only trigger; hash chain; daily verifier; 7 y retention |
| `incidents` / `disputes` / `investigations` | ops + dispute records preserving linked financial events | — |
| `routing_decisions` / `payment_routes` / `payment_route_versions` | v1.0 fields **plus route columns**: `economic_purpose_scope jsonb`, `economic_beneficiary_scope jsonb`, `funds_flow_model FK`, `provider_merchant_account_required boolean`, `merchant_settlement_destination_required boolean`, `commission_policy_id`, `fee_policy_id`, `tax_policy_id`, `reserve_policy_id`, `settlement_calendar_id`, `provider_contract_version_id`, `custody_classification`, `compliance_approval_id null`, `refund_funding_party`, `kill_switch_state jsonb`, `pilot_limits jsonb` | Route versions immutable after activation; **DB trigger: a route whose `funds_flow_model` requires compliance approval cannot activate with `compliance_approval_id null`**; contract version must cover activation date |
| `kill_switches` | `scope_type enum(product, application, environment, merchant_account, payment_method, provider, provider_account, provider_merchant_account, route, funds_flow_model, currency, amount_band)`, `scope_ref`, `mode jsonb` (block-new / allow-status / allow-callbacks / allow-refunds / allow-recon / allow-settlement / allow-support-reads), `activated_by`, `approved_by`, `reason`, `expires_at null` | Production activation maker-checker + step-up; callbacks always accepted |
| `provider_operating_modes` | `provider_account_id`, `mode` (§5.6), `reason`, `activated_by`, `approved_by`, `time_bound_until null` | Audited; product-notified; route eligibility input |
| `pilot_cohorts` / `pilot_merchants` | stage (0–3), merchant allowlist, caps (per-transaction/daily/monthly), method restrictions, success thresholds, review log | Stage advance requires recorded threshold evidence |
| `transaction_limits` | Scope §108.3 dimensions; soft/hard/alert thresholds; effective dates; override records (reason + step-up + expiry) | Overrides audited |

Route snapshot (Scope §35) is stored on the transaction row (`route_snapshot jsonb not null` on `payment_attempts`, `checkout_sessions`, `payouts`, `refunds`, `reversals`, `internal_transfers`, `merchant_settlements`) including all baseline fields **plus** `provider_merchant_account_id`, `economic_beneficiary_type/id`, `merchant_settlement_destination_version_id`, `funds_flow_model`, `commission_policy_version`, `fee_policy_version`, `tax_policy_version`, `reserve_policy_version`, `merchant_terms_version`, `provider_terms_version`, `custody_classification`, `legal_approval_reference`; a trigger blocks updates after insert.

### 7.10 Data Dictionary Deliverable

Each table group ships a data-dictionary file in `docs/architecture/data-dictionary/` (`identity-access.md`, `registries.md`, `provider-commercial.md`, `merchant-finance.md`, `policies-allocation.md`, `routing.md`, `collections.md`, `payouts-refunds.md`, `chargebacks-cases.md`, `ledger-settlement.md`, `reconciliation-close.md`, `integration.md`, `ops.md`) documenting per column: type, nullability, default, constraint, ownership-key role, encryption/masking, retention, index rationale, and partitioning/archival triggers (`incoming_webhooks` monthly partitioning pre-declared; `ledger_entries` BRIN + transactional summary tables; `statement_lines` archival policy). `DataDictionaryCoverageTest` fails CI if a migrated table lacks an entry.

---

## 8. Multi-Tenancy and Data Isolation Model

Wallet is single-legal-entity but enforces multi-tenant-grade isolation across **product → application → environment → merchant account → provider merchant account** (Scope §19).

### 8.1 Ownership Keys

Every owned table carries its applicable keys (`legal_entity_id`, `product_id`, `application_id`, `environment`, `merchant_account_id`, `provider_merchant_account_id` for merchant-finance rows). Financial transaction tables carry all keys denormalized so: (a) queries filter without joins; (b) composite FK `(application_id, environment)` → `applications(id, environment)` makes cross-environment references unrepresentable; (c) indexes lead with ownership keys. `TenantColumnCoverageTest` introspects `information_schema` and fails if any registered owned table lacks its keys.

### 8.2 Context Resolution

`OwnershipContext` (immutable value object) resolved once per request:

- **Product API:** from the Passport token → application → product/environment. `merchant_account_id` in payloads is validated to belong to the token's product + environment. Environment claims cross-checked.
- **Provider webhooks/IPNs:** context never trusted from the payload; derived from the route's provider-account binding (including the PesaPal secret-path segment) or resolved during async processing from registered identifiers (shortcode, checkout request ID, order-tracking ID). Unresolvable → exception queue.
- **Internal SPA:** context = the authenticated user's memberships; global users operate cross-product only through permission-checked, audited screens; the backend enforces membership scope regardless of the client's claimed viewing context.

### 8.3 Query Scoping

Global ownership scopes for scope-limited request lifecycles; `withoutOwnershipScope()` allowed solely inside module `Api/` services paired with permission checks (PHPStan rule); raw SQL against owned tables banned outside `database/` and reconciliation read models.

### 8.4 Scoped Route Binding and the 404 Posture

Owned resources bind `public_id` within the caller's scope; a valid foreign ID returns `404 RESOURCE_NOT_FOUND` and logs a `cross_scope_probe` security event.

### 8.5 Ownership Propagation

Jobs (`OwnershipAwareJob`, fails loudly unscoped), exports (frozen scope validated at enqueue + execution), outgoing webhooks (application set in-transaction; cross-application mismatch unrepresentable), notifications (membership + permission filtered), and merchant statements (single-merchant scope enforced at generation) all propagate ownership context.

### 8.6 Mandatory Denied-Case Examples (each a permanent test)

| # | Scenario | Expected behavior | Test |
|---|---|---|---|
| 1 | Servana production token GETs a Kikao payment | 404 + probe event | `Isolation/CrossProductPaymentAccessTest` |
| 2 | Servana sandbox token calls a production payment | 404 + env-mismatch event | `Isolation/CrossEnvironmentAccessTest` |
| 3 | Delegated user of merchant A reads any row of merchant B | Impossible; probe → 404 | `Isolation/CrossMerchantAccountTest` |
| 4 | User with `payouts.read` POSTs an approval | 403 + audit | `Security/PermissionDenialTest` |
| 5 | Unscoped job touches a payment | `MissingOwnershipContext`, fails loudly | `Isolation/UnscopedJobTest` |
| 6 | Export filters wider than requester scope | 422; shrunk permissions abort execution | `Isolation/ExportScopeTest` |
| 7 | Product-A webhook event to product-B endpoint | Unrepresentable + guard test | `Isolation/WebhookScopeTest` |
| 8 | C2B confirmation for a retired product's reference | Exception queue, never reassigned | `Feature/RetiredProductReferenceTest` |
| 9 | Foreign `payment_id` in refund create | 404; no refund row | `Isolation/CrossScopeRefundTest` |
| 10 | Scoped search matching another product's reference | Zero results; no hints | `Isolation/SearchScopeTest` |
| 11 | Merchant A payment referencing merchant B's provider merchant account | Unrepresentable (composite FK) + service guard | `Isolation/ProviderMerchantIsolationTest` |
| 12 | Sandbox payment referencing a production provider merchant | Unrepresentable | `Isolation/ProviderMerchantEnvironmentTest` |
| 13 | Kikao payment referencing a Servana provider merchant | Unrepresentable | `Isolation/ProviderMerchantProductTest` |
| 14 | Suspended merchant creates a payment | `MERCHANT_INELIGIBLE` per status matrix | `Feature/MerchantSuspensionEffectsTest` |
| 15 | Negative-balance offset against another merchant's settlement | Unrepresentable + guard | `Isolation/CrossMerchantOffsetTest` |
| 16 | Merchant statement containing another merchant's rows | Impossible; generation scope test | `Isolation/StatementScopeTest` |

### 8.7 Super-Admin Separation

Global administrative workflows: separate `internal_platform_mutation` route class; `is_sensitive` permissions with step-up; reason fields; full audit; no impersonation feature at launch; sensitive reads (bank/destination reveals, credential views, KYB documents) individually logged.

---

## 9. Authentication Model

### 9.1 Magic-Link Login (Scope §15.1–15.2, implemented verbatim)

1. `POST /api/internal/v1/auth/magic-link` `{ email, context? }` → always `202` generic body (enumeration resistance; Scope §114.1 scenarios 1–3 return the same body).
2. Server-side: normalize email; classify internal vs delegated; verify active status (internal directory or source-product endpoint per 9.4); source-product downtime → "cannot verify", generic response, bounded retry.
3. 64 random bytes → token; store SHA-256 hash only, bound to email, user, audience, signed context (product/merchant/environment/redirect), 15-minute expiry, creating IP/UA.
4. Queued email; consume URL only, no secrets.
5. `GET /auth/consume/{token}`: validate hash, expiry, unconsumed, audience, environment, account + membership active (delegated revalidation); **atomic consume** `UPDATE ... WHERE consumed_at IS NULL` returning row count 1.
6. Success: session regenerate (fixation prevention), assurance `magic_link`, security + audit events, redirect validated against the server-side allowlist.
7. Failure: friendly expiry/invalid page; replayed/modified tokens rejected identically with `link_replay_attempt` events.

Revocation: deactivation, email change, or membership revocation immediately revokes outstanding links (`MagicLinkRevocationTest`).

### 9.2 Step-Up Authentication (Scope §15.3)

`RequireStepUp` middleware on all designated actions (the full Scope §15.3 list, including destination activation, provider merchant approval, policy activation, reserve release, hold release, kill switches, operating modes, daily-close approval, period reopen, break-glass). Session `assurance_level = step_up` with unexpired freshness (default 15 min). Methods: TOTP (primary; enrollment mandatory for holders of `requires_step_up` permissions) or step-up magic link (5-minute expiry). API returns `403 STEP_UP_REQUIRED { retryable: true }`; SPA opens `StepUpDialog` and retries.

### 9.3 Session Controls (Scope §15.4)

Secure HTTP-only SameSite cookies; `secure` forced in production; inactivity 60 min / absolute 12 h (configurable); rotation on login and privilege change; identity-version middleware forces refresh on privilege changes; session listing + revocation endpoints; logout / logout-all; delegated users revalidate against the source product every 15 min of activity and on every sensitive action.

### 9.4 Delegated Identity Federation (built Phase 8; launch-disabled per W-A13)

Per product: `identity_verification_endpoint` + dedicated HMAC secret (W-A07 canonical construction, distinct namespace). `POST {endpoint} { email }` → `{ active, merchant_account_ref, roles, permissions_scope, identity_version }`. Timeout (2 s budget) = cannot verify → no session, generic response. Membership scope comes from the verification response, never client input.

### 9.5 Machine Authentication (Scope §12)

Passport client-credentials per application; 60-min tokens; scopes ∩ `allowed_scopes`; optional IP allowlists; rotation with overlap window (default 24 h); compromise runbook (revoke → invalidate → alert → reissue).

### 9.6 Rate Limiting and Abuse Controls (auth surfaces)

| Limiter | Key | Default |
|---|---|---|
| `magic-link-email` | normalized email | 3/15 min; 10/day; outstanding-link cap 3 |
| `magic-link-ip` / `magic-link-consume` | IP | 10/15 min |
| `step-up` | user | 5/15 min then lockout + event |
| `invitation-accept` | IP + token | 5/15 min |
| `product-api` | application | per policy (default 300/min read, 60/min financial create) |
| `provider-webhook` | provider account | high ceiling; anomaly alerting |
| `internal-api` | user | 240/min |

---

## 10. Authorization, Roles, and Permissions Model

### 10.1 Mechanism

First-party tables + a single `AccessDecision` service + policies/gates (Spatie not used — the 14-input decision of Scope §16, membership-scoped roles, segregation, and assurance exceed its model; this is the documented exception ADR-0007).

```php
final class AccessDecision
{
    /** Evaluates, in order (Scope §16): user status → user type → membership
     *  (scope containment incl. provider-merchant scope) → role/permission
     *  (deny-beats-grant) → resource ownership → segregation (maker≠checker,
     *  creator≠activator, preparer≠approver) → assurance (step-up) →
     *  risk/compliance/legal-hold status. */
    public function allows(User $u, string $permission, ?OwnedResource $r = null, ?Requirement $req = null): Decision;
}
```

### 10.2 Roles

Seeded exactly per Scope §11: `owner, super_administrator, platform_administrator, finance_maker, finance_approver, senior_finance_approver, accountant, reconciliation_officer, treasury_officer, risk_compliance_officer, support_officer, developer, security_administrator, auditor, read_only_executive_viewer`. Multiple roles per user; per-membership overrides; deny beats grant.

### 10.3 Permission Matrix (canonical file: `docs/auth/permission-matrix.yaml`)

Permissions are exactly the Scope §18 catalogue (baseline keys plus the merchant-finance keys: `provider_merchants.*`, `merchant_settlement_destinations.*`, `merchant_settlements.*`, `merchant_statements.*`, `commission_policies.*`, `fee_policies.*`, `tax_policies.*`, `reserves.*`, `chargebacks.*`, `cases.*`, `daily_close.*`, `provider_contracts.*`, `provider_capabilities.activate`, `compliance_holds.*`, `launch_controls.*`). Representative assignments (full matrix in YAML; parity-tested):

| Permission († = step-up) | Owner | SuperAdmin | PlatformAdmin | FinMaker | FinApprover | SnrFinApprover | Treasury | Recon | Risk | Support | Auditor |
|---|---|---|---|---|---|---|---|---|---|---|---|
| `payouts.create` / `payouts.approve`† | ✓/✓ | ✓/✓ | — | ✓/— | —/✓ | —/✓ | ✓/— | — | — | — | — |
| `refunds.create` / `refunds.approve`† | ✓/✓ | ✓/✓ | — | ✓/— | —/✓ | —/✓ | — | — | — | ✓/— | — |
| `bank_accounts.create` / `.activate`† | ✓ | ✓ | ✓/— | — | — | —/✓ | ✓/— | — | — | — | — |
| `provider_merchants.create/submit` | ✓ | ✓ | ✓ | — | — | — | — | — | ✓ | — | — |
| `provider_merchants.approve`† | ✓ | ✓ | — | — | — | ✓ | — | — | ✓ | — | — |
| `merchant_settlement_destinations.create` | ✓ | ✓ | ✓ | ✓ | — | — | ✓ | — | — | — | — |
| `merchant_settlement_destinations.verify/approve/activate`† | ✓ | ✓ | — | — | ✓ | ✓ | — | — | ✓ | — | — |
| `merchant_settlements.hold/release`† | ✓ | ✓ | — | — | ✓ | ✓ | ✓ | ✓ | ✓ | — | — |
| `commission_policies.configure` / `.activate`† | ✓ | ✓ | ✓/— | — | —/✓ | —/✓ | — | — | — | — | — |
| `reserves.create` / `reserves.release`† | ✓ | ✓ | — | ✓/— | —/✓ | —/✓ | ✓/— | — | ✓ | — | — |
| `chargebacks.manage/submit_evidence` | ✓ | ✓ | — | ✓ | ✓ | ✓ | — | ✓ | ✓ | ✓ | — |
| `cases.create/assign/resolve` | ✓ | ✓ | ✓ | — | — | — | — | ✓ | ✓ | ✓ | — |
| `daily_close.execute` / `.approve`† | ✓ | ✓ | — | — | —/✓ | —/✓ | — | ✓/— | — | — | — |
| `provider_contracts.manage` / `provider_capabilities.activate`† | ✓ | ✓ | ✓/— | — | — | —/✓ | ✓/— | — | — | — | — |
| `compliance_holds.create` / `.release`† | ✓ | ✓ | — | — | — | — | — | — | ✓/✓ | — | — |
| `launch_controls.manage`† | ✓ | ✓ | ✓ | — | — | — | — | — | — | — | — |
| `merchant_statements.read/generate/export` | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | partial | ✓ read |

### 10.4 Segregation Rules (hard, DB-backed)

1. Maker ≠ checker on payouts, refunds, ledger corrections, resolutions (trigger on `approval_actions`).
2. Bank-account create ≠ activate; **destination create ≠ activate; commission-policy create ≠ activate (per version); reserve create ≠ release above threshold; daily-close prepare ≠ approve; compliance-hold create ≠ release; contract upload ≠ sole capability activation; onboarding data-entry ≠ manual approval of the same merchant's destination data** (triggers + service guards + tests).
3. Approver-permission revocation between approval and submission: high-risk approvals revalidated at submission.
4. Ownership transfer: current Owner + step-up + acceptance + second super-admin confirmation.
5. Membership revocation bumps `identity_version`, revokes sessions/links, cancels pending approval assignments; user rows never deleted.
6. Permission changes audited with before/after.

### 10.5 Invitation Workflow

Step-up-protected invitation create → hashed 72 h token → rate-limited acceptance creating membership + roles exactly as invited → atomic consumption → audited lifecycle (`invitation.created/accepted/revoked/expired`).

### 10.6 Policy Pattern

Every owned resource has a policy delegating to `AccessDecision`, always re-verifying ownership scope before permission and applying `Requirement::stepUp()` / `notCreator()` where designated. Enforced on controllers, API endpoints, jobs acting for users, exports/downloads, admin screens. `PolicyCoverageTest` + `RouteSecurityContractTest` prove coverage.

---

## 11. API Design

### 11.1 Versioning, Envelopes, Conventions

All product APIs under `/api/v1`. Envelope:

```json
// success (single)
{ "data": { ... }, "meta": { "correlation_id": "01J..." } }
// success (collection — ALWAYS cursor-paginated, default 25, max 100)
{ "data": [ ... ], "links": { "next": "...", "prev": "..." },
  "meta": { "correlation_id": "01J...", "per_page": 25, "cursor": "..." } }
// error
{ "error": { "code": "ALLOCATION_UNBALANCED", "message": "...", "remediation": "...",
             "correlation_id": "01J...", "retryable": false, "retry_after": null,
             "fields": { }, "resource_state": "CREATED" } }
```

Filtering via allowlisted params (`status`, `created_from/to`, `merchant_account_id`, `economic_purpose`, `funds_flow_model`, `currency`, `method`); sorting allowlisted + indexed; max payload 64 KB (512 KB batch create); amounts only `amount_minor` + `currency`; `Deprecation`/`Sunset` headers; OpenAPI 3.1 generated, committed, parity-tested, published with version hash.

### 11.2 Product API Routes

```text
# Middleware: [auth:api-products, scope-check, EnsureEnvironmentContext,
#  throttle:product-api, EnforceIdempotencyKey (financial creates), correlation]

# Payments                                                       [Phase 14 — Gate W]
POST   /api/v1/payments                          scope payments:write   (idempotent)
GET    /api/v1/payments · /payments/{payment}    scope payments:read
POST   /api/v1/payments/{payment}/attempts/stk   scope payments:write   (idempotent)
GET    /api/v1/payments/{payment}/attempts       scope payments:read
POST   /api/v1/payments/{payment}/checkout-sessions        scope payments:write (idempotent)   [Phase 14 — PesaPal]
GET    /api/v1/payments/{payment}/checkout-sessions/{session}  scope payments:read

# Merchant-account sync                                          [Phase 14 — Gate W]
PUT    /api/v1/merchant-accounts/{external_ref}        scope merchant_accounts:write
GET    /api/v1/merchant-accounts/{external_ref}        scope merchant_accounts:read
POST   /api/v1/merchant-accounts/{external_ref}/status-events   scope merchant_accounts:write
GET    /api/v1/merchant-accounts/{external_ref}/payment-eligibility  scope merchant_accounts:read

# Discovery
GET    /api/v1/provider-methods                  scope payments:read
GET    /api/v1/routes/quote                      scope payments:read

# Refunds / Payouts / Batches / Beneficiaries                    [Phases 19–22]
POST   /api/v1/refunds        GET /api/v1/refunds/{refund}       (idempotent)
POST   /api/v1/payouts        GET /api/v1/payouts/{payout}       (idempotent)
POST   /api/v1/payout-batches GET /api/v1/payout-batches/{batch} · /items  (idempotent)
POST   /api/v1/beneficiaries  GET /api/v1/beneficiaries/{beneficiary}
```

`POST /api/v1/payments` contract (Servana ADR-014 registers against this):

```json
// request
{ "external_reference": "BOOKING-01J...", "merchant_account_ref": "MRC-01J...",
  "economic_purpose": "MERCHANT_CUSTOMER_PAYMENT",
  "expected_amount_minor": 250000, "currency": "KES",
  "customer_reference": "CUS-01J...",
  "commercial_policy_reference": "SERVANA-COMMISSION-STANDARD",
  "commercial_policy_version": 3,
  "description": "Booking payment", "expires_at": "2026-08-01T20:59:59Z", "metadata": { } }
// 201 response
{ "data": { "payment_id": "01JD...", "payment_reference": "SRV-PAY-01JD8G2K...",
    "reference_class": "SRV-MER-PAY-01JD8G2K...", "status": "CREATED",
    "economic_purpose": "MERCHANT_CUSTOMER_PAYMENT",
    "economic_beneficiary_type": "PRODUCT_MERCHANT_ACCOUNT",
    "funds_flow_model": "MERCHANT_GROSS_CITRUS_SEPARATE_BILLING",
    "expected_amount_minor": 250000, "received_amount_minor": 0, "currency": "KES",
    "external_reference": "BOOKING-01J...", "merchant_account_ref": "MRC-01J...",
    "paybill_instructions": { "paybill": "XXXXXX", "account_reference": "SRV-PAY-01JD8G2K..." },
    "checkout_required": true, "created_at": "..." } }
```

Rejections: unsupported purpose (422); inactive/suspended merchant (`MERCHANT_INELIGIBLE`); unapproved provider merchant (`PROVIDER_MERCHANT_INACTIVE`); missing settlement destination (`SETTLEMENT_DESTINATION_UNVERIFIED`); invalid policy version (`POLICY_VERSION_INVALID`); blocked funds-flow (`FUNDS_FLOW_BLOCKED`); expired contract (`CONTRACT_EXPIRED`); missing compliance approval (`COMPLIANCE_HOLD`); amount outside limits (`LIMIT_EXCEEDED`); duplicate `external_reference` (`DUPLICATE_EXTERNAL_REFERENCE` 409 with existing-resource pointer); unsupported currency, zero/negative amount (422).

`POST /payments/{payment}/checkout-sessions` (PesaPal): validates purpose/route/eligibility → creates session → adapter `createOrder` → returns `202 { session_id, provider_redirect_url, expires_at }`. Provider secrets never in the response. Session expiry, single-use, and return-URL allowlist enforced.

`POST /payments/{payment}/attempts/stk`: MSISDN normalization + unsupported-range rejection; per-(payment, msisdn) cooldown (default 90 s); terminal-payment block (`TRANSACTION_STATE_CONFLICT`); routing; attempt creation; adapter call; provider IDs persisted; `202 { attempt_id, status: "SUBMITTED" }`; provider down → `503 PROVIDER_UNAVAILABLE, retryable: true` with no stranded attempt.

### 11.3 Provider Webhook / IPN Routes

```text
POST /api/v1/providers/mpesa/c2b/validate                    [VerifyProviderSource]
POST /api/v1/providers/mpesa/c2b/confirm
POST /api/v1/providers/mpesa/stk/callback/{provider_account}
POST /api/v1/providers/mpesa/b2c/result/{provider_account}
POST /api/v1/providers/mpesa/b2c/timeout/{provider_account}
POST /api/v1/providers/pesapal/ipn/{provider_account}/{secretPath}
POST /api/v1/providers/{provider}/webhooks/{provider_account}
```

`VerifyProviderSource`: TLS-only, allowlisted source IPs where published, random 128-bit secret path segments per provider account (rotatable), content-type + 64 KB body limits. The PesaPal IPN route: persist raw → ack within provider limits → enqueue → resolve provider account from the route binding → resolve `order_tracking_id` → **status query for authoritative confirmation where required** → apply idempotently. Unsigned callbacks are always corroborated (Section 24.3).

### 11.4 Internal Dashboard API

`/api/internal/v1/...` mirrors the Section 6.2 page inventory. Purpose-named action POSTs only (no generic PATCH on financial aggregates): `POST /payouts/{payout}/approve`, `POST /exceptions/{exception}/resolve`, `POST /routes/{route}/activate`, `POST /provider-merchants/{pm}/submit|approve|suspend|close`, `POST /merchant-settlement-destinations/{d}/verify|approve|activate|deactivate`, `POST /merchant-statements` (generate), `POST /chargebacks/{c}/evidence|accept`, `POST /cases/{case}/assign|notes|resolve|reopen`, `POST /daily-close/{run}/approve|reopen`, `POST /reserves/{r}/release|apply`, `POST /compliance-holds/{h}/release`, `POST /launch-controls/flags/{flag}`, `POST /kill-switches`, `POST /provider-accounts/{a}/operating-mode`. Provider-merchant approval endpoints reflect provider evidence, never fabricate provider approval.

### 11.5 Route Classification Registry

| Class | Required middleware |
|---|---|
| `product_api_read` | auth:api-products, scopes, env-context, throttle, correlation |
| `product_financial_mutation` | above + EnforceIdempotencyKey + Form Request + policy |
| `provider_webhook_mutation` | VerifyProviderSource, throttle:provider-webhook, correlation; **forbidden:** session/token auth |
| `internal_read` | auth:sanctum, verified-session, identity-version, correlation |
| `internal_mutation` | above + CSRF + policy + Form Request |
| `internal_financial_mutation` | above + step-up where flagged + transaction + audit |
| `internal_platform_mutation` | above + `is_sensitive` permission + step-up + reason field |
| `public_auth` | throttle:magic-link-*, correlation only |

`RouteSecurityContractTest` asserts the matrix for every route.

### 11.6 API Logging Strategy

Structured JSON per request: correlation ID, application public ID, route name, status, latency, environment — never financial payload bodies (summaries only), never Authorization headers. Webhook ingestion logs raw-payload row IDs. Sampling: 100% errors, 100% financial mutations, 10% healthy reads.

### 11.7 Error Handling Strategy

Single `ApiExceptionHandler` mapping to the Scope §84.4 catalogue (including the merchant-finance codes `MERCHANT_INELIGIBLE`, `PROVIDER_MERCHANT_INACTIVE`, `SETTLEMENT_DESTINATION_UNVERIFIED`, `FUNDS_FLOW_BLOCKED`, `ALLOCATION_UNBALANCED`, `POLICY_VERSION_INVALID`, `CONTRACT_EXPIRED`, `COMPLIANCE_HOLD`, `REFUND_FUNDING_UNDETERMINED`, `LIMIT_EXCEEDED`, `ROUTE_CHANGED`). `retryable`/`retry_after` set correctly; `resource_state` where safe; stack traces/SQL/secrets never serialized (induced-500 test); unhandled exceptions → `INTERNAL_ERROR` with full Sentry capture.

---

## 12. UI/UX Design System

### 12.1 Design Tokens (CSS custom properties consumed by Tailwind)

```css
:root {
  --color-bg: #f8fafc;  --color-surface: #ffffff;  --color-surface-2: #f1f5f9;
  --color-border: #e2e8f0;  --color-text: #0f172a;  --color-text-muted: #475569;
  --color-primary: #ea7317;  --color-on-primary: #241305;
  --color-success: #15803d;  --color-warning: #b45309;  --color-danger: #b91c1c;
  --color-info: #1d4ed8;  --color-unknown: #6d28d9;  /* UNKNOWN is its own color, never gray */
  --color-focus-ring: #2563eb;
  --color-env-sandbox: #d97706;  --color-env-production: #dc2626;
  /* spacing 4px base: 1,2,3,4,6,8,12,16,24,32; radius sm4/md8/lg12; shadow ramp sm/md/lg */
}
[data-theme="dark"] {
  --color-bg: #0b1220;  --color-surface: #101a2c;  --color-surface-2: #16233a;
  --color-border: #2a3a55;  --color-text: #e2e8f0;  --color-text-muted: #94a3b8;
  --color-primary: #f08c3a;  --color-on-primary: #241305;
  --color-success: #4ade80;  --color-warning: #fbbf24;  --color-danger: #f87171;
  --color-info: #60a5fa;  --color-unknown: #a78bfa;  --color-focus-ring: #60a5fa;
}
```

Typography: Inter (system fallback); scale 12/14/16/18/20/24/30/36; body 16px/1.5; `font-variant-numeric: tabular-nums` on all monetary/table numerics.

### 12.2 Component Standards

| Component | Standard |
|---|---|
| Buttons | primary/secondary/destructive/ghost; ≥44×44 touch; loading state preserves width; destructive paired with `ConfirmDialog` |
| Form controls | Persistent visible labels; placeholder = example only; `aria-describedby` errors; required in accessible name; disabled-with-reason |
| Tables | Sort affordances (allowlisted), sticky header desktop; transform per Section 13 |
| Modals | Focus-trapped, Esc closes, focus restored; high-risk flows are pages, not modals |
| Toasts | Success auto-dismiss 6 s; errors persist + correlation ID |
| Status display | `TransactionStatus`: icon + label + description + timestamp; never color-only; `UNKNOWN` distinct icon + copy ("Wallet cannot yet prove whether money moved. Do not retry manually.") |
| Allocation display | `AllocationBreakdown`: gross → provider fee (bearer) → commission → tax → reserves → merchant net; totals always shown to balance |
| Merchant position | `MerchantPositionCard`: every Scope §52 component separately, with freshness + source; never one ambiguous balance |
| Confirmation-before-submit | Review screen restating provider, provider account, provider merchant, bank/destination masked, funding source, amount, currency, beneficiary (Scope §88.10) |
| Deadline display | `DeadlineCountdown` for chargeback/SLA deadlines with escalation colors + text |

### 12.3 UX Priorities

Visual hierarchy; accurate status; data freshness stamps; loud environment context; payment-vs-merchant-settlement-vs-provider-settlement-vs-reconciliation distinction (separate badges); failed-vs-unknown distinction; masking by default; searchable lists; stable layouts; minimal motion; keyboard operability; duplicate-submit prevention.

---

## 13. Responsive Layout Strategy

### 13.1 Breakpoints (CSS media queries only)

```js
// tailwind.config.ts
screens: { md: '768px' /* tablet ≥768 */, lg: '1025px' /* desktop ≥1025 */ }
// mobile-first: base = mobile (≤767); md: = tablet (768–1024); lg: = desktop (≥1025)
```

No JS layout-mode detection; no UA branching (ESLint ban); live adaptation on resize (e2e sweep asserts no horizontal scroll and no overlap); zoom respected.

### 13.2 Per-Region Strategies

| Region | Desktop | Tablet | Mobile |
|---|---|---|---|
| Sidebar | Fixed 260px, collapsible to 64px rail | Off-canvas drawer + focus trap | Full-width drawer |
| Header | Full: search, env badge, bell, profile | Condensed; search icon-expands | Two-row; env badge always visible |
| Dashboard | 12-col; stats 4-up | 2-up | 1-up stacked; charts get textual summary first |
| Data tables | Full table; bounded overflow for wide financial tables | Column-priority + row expander | `ResponsiveRecordList` cards; amounts/status never truncated |
| Forms | Two-col short fields; single-col financial entry | Single column | Single column; sticky submit |
| Approvals/high-risk | Full labeled buttons | Full labeled buttons | **Never icon-only**; full-width labeled |
| Filters | Inline bar | Collapsible panel | Filter sheet + active-count badge |
| Allocation/position views | Side-by-side breakdown | Stacked sections | Stacked cards, totals pinned |
| Modals | Centered max-w 560px | 90vw | Full-screen sheet |

### 13.3 Verification

Playwright viewport sweep at 375, 767, 768, 1024, 1025, 1440 asserting: `scrollWidth ≤ viewport` on normal pages; no overlap among labeled critical elements; touch targets ≥44px at ≤1024.

---

## 14. Dark Mode Strategy

1. Default light; three-way control Light/Dark/System in profile + settings.
2. All colors flow through Section 12.1 tokens (Stylelint bans raw hex in components).
3. Persistence server-side (`users.theme_preference`) mirrored to `localStorage` for pre-auth boot.
4. Flash prevention: inline head script sets `data-theme` before CSS.
5. Both themes preserve AA contrast (axe CI on key pages in both), focus rings, explicit borders, validation, status distinctions (icons + labels, never color alone).
6. Print/export: `PrintLayout` + `@media print` force the light print-safe palette.
7. Component tests run snapshot + axe in both themes for buttons, inputs (all validation states), status badges (all states incl. UNKNOWN), allocation breakdowns, tables, modals, toasts, banners.

---

## 15. Accessibility Strategy

Target WCAG 2.2 AA (Scope §97): full keyboard reachability with logical order, skip links, roving tabindex, drawer/modal focus trap + restore; visible focus in both themes; AA contrast (axe CI on 15 highest-traffic screens both themes); programmatic labels + `aria-live` error summaries; accessible names on all controls; ≥44×44 touch targets; no `user-scalable=no`, 200% zoom tolerated; `prefers-reduced-motion` global guard, no animation obscures financial status; landmarks, heading hierarchy, APG-pattern menus/modals/alerts; statuses as text ("Status: Unknown — awaiting provider confirmation, last checked 12:03"); charts ship adjacent data tables; import/export progress announced; accessible session-timeout warnings. Per-feature gate: axe scan (0 critical/serious), recorded keyboard walkthrough, screen-reader smoke, reduced-motion check.

---

## 16. Forms and Input Behavior Strategy

1. States (default/focus/hover/disabled+reason/readonly/empty/populated/error/success) via tokens; JS/backend drive state, CSS presents it.
2. Client validation mirrors server rules (generated from OpenAPI constraints where possible); server always authoritative; 422 field-maps into `useForm`.
3. Duplicate-submit prevention: `useForm` lock + client `Idempotency-Key` on financial creates; double-click cannot double-execute.
4. Long forms: sectioned, sticky nav, top error summary linking to fields.
5. Sensitive fields write-only after save; masked display; never logged.
6. `AmountInput` emits integer `amount_minor`; display re-derives from the integer.
7. `PhoneInput` normalizes to `2547XXXXXXXX`, rejects unsupported ranges with the same rule the server enforces.
8. Route/bank/destination/policy forms carry explicit effective-date and environment controls.
9. High-risk submissions restate the action ("Approve payout of KES 2,500.00"; "Activate destination ******4821 for merchant X").
10. Config forms warn on unsaved navigation; financial creates never auto-draft.
11. No silent substitution: server returns `ROUTE_CHANGED` requiring re-confirmation if routing would differ from the quoted display.

---

## 17. User Profile and Account UI Strategy

Header identity unit (initials avatar + name + role summary) opens a floating, non-clipping dropdown: name, verified email, user type (+ source-product attribution for delegated users), current context, roles, assurance level + last login, links to Profile, Sessions, Security (TOTP enrollment + recovery codes shown once), Theme, Notifications, Logout, Logout-all. Context switcher for multi-membership users re-fetches permission maps; backend still enforces per request. `/profile`, `/profile/sessions` (device list + revoke), `/profile/security`. Full keyboard support per APG menu pattern.

---

## 18. Entitlement Enforcement Strategy

Per-application entitlements enforced server-side on every product API call, in order (each failure returns its own stable code): (1) application status active; (2) token scope; (3) environment match (404 posture); (4) method/direction/currency allowed; (5) **economic purpose permitted for the application**; (6) amount ≤ max; (7) daily/monthly cumulative limits (Redis counters + nightly true-up) → `LIMIT_EXCEEDED`; (8) rate limits → `RATE_LIMITED`; (9) route availability → `ROUTE_NOT_FOUND`/`ROUTE_INACTIVE`; (10) **merchant eligibility (status matrix, compliance holds, provider merchant approval, destination verification) → `MERCHANT_INELIGIBLE` et al.**; (11) **launch limits and pilot allowlists → `LIMIT_EXCEEDED`**. Entitlement changes are `internal_platform_mutation`. Tests: per-gate denial + sandbox-can-never-pass-gate-3 matrix.

---

## 19. File Upload and Storage Strategy

Uploads: payout batch CSVs; provider/bank statements and reports (transaction, settlement, fee, refund, chargeback, reserve, merchant-statement, onboarding); evidence attachments (reconciliation, verification, chargeback, case); KYB documents; contract documents; generated exports.

| Control | Implementation |
|---|---|
| Accepted types | Batch: `text/csv`. Statements/reports: CSV, XLSX, MT940/TXT, PDF per provider registry. Evidence/KYB/contracts: PDF, PNG, JPG. Else rejected |
| Size limits | Batch 10 MB / 10,000 rows; statements 25 MB; evidence/KYB 10 MB. Nginx + middleware + validation |
| MIME + extension | Server-side `finfo` sniff must match declared extension + allowlist; mismatch → reject + security event |
| Content validation | CSV: encoding, exact headers, typed rows, duplicates, precision, currency, phone/bank formats; statement schema versioning + unknown-column preservation + period/currency validation + line balancing |
| Formula-injection | Export cells beginning `= + - @ \t` prefixed with `'` |
| Malware scanning | ClamAV sidecar; `scan_status` gate (pending → unusable; infected → quarantine + alert; scanner down → receipt allowed, processing blocked) |
| Storage | Private S3, SSE, no public ACLs, `{env}/{purpose}/{owner-scope}/{ulid}` paths; originals retained immutably |
| Downloads | Policy-checked → 15-min signed URL; export downloads counted + audited |
| Orphan cleanup | Nightly, age > 48 h, never quarantined/evidence/KYB/legal-hold files |
| Abuse tests | Wrong MIME, polyglot, oversized, zip bomb, CSV formula payloads, path-traversal names, EICAR → quarantine |

---

## 20. Queue, Jobs, Notifications, and Scheduled Task Strategy

### 20.1 Queues (Redis, Horizon-supervised)

| Queue | Purpose | Posture |
|---|---|---|
| `webhooks-in` | Persisted incoming callbacks/IPNs | High parallelism; idempotent by row + provider IDs |
| `financial` | Payout submission, allocation, ledger appliers, refund execution, status-query application, settlement application | **Low, controlled concurrency**; idempotent; per-provider-account token-bucket rate limits |
| `webhooks-out` | Signed deliveries + retries | Per-endpoint breaker |
| `statements` | Statement/report parsing, merchant statement generation, daily close computation | Low; memory-bounded chunks |
| `notifications` / `exports` / `default` | Standard | — |

Failed `financial` jobs page immediately; retry re-uses idempotency keys so double-execution is structurally prevented; scheduled jobs are lock-guarded **and** logically idempotent.

### 20.2 Scheduler (single instance, lock-protected)

| Schedule | Task |
|---|---|
| Every minute | Outgoing-webhook retries; STK/checkout-session expiry sweeps |
| Every 5 min | Status queries for `UNKNOWN`/stale non-terminal payouts, attempts, and PesaPal orders past return-without-IPN windows (bounded, oldest-first, per-provider rate-limited); provider balance polls |
| Every 15 min | Delegated-membership revalidation sweep; endpoint health; **settlement SLA scan (pre-breach + breach alerts)** |
| Hourly | Critical-transaction reconciliation; entitlement counter true-up; **chargeback deadline scan** |
| Daily 01:00 EAT | Provider + allocation + merchant-settlement reconciliation runs; bank-statement expectation check; **daily close preparation per provider account and settlement model**; audit chain verify; orphan cleanup; retention pruning; **route doctor (config-drift detection: Wallet vs provider IPN URL, merchant status, destination, capabilities, contract dates → exception + optional route pause)**; **capability/contract/KYB expiry scan (alerts 60/30/7 days; pause on expiry)** |
| Monthly 1st 03:00 EAT | Month-end reconciliation + trial balance + accounting-period preliminary close |
| Daily | Backup verification hook; credential/certificate expiry scan |

### 20.3 Failed Jobs

`failed_jobs` retained 30 days; Horizon alerts on any `financial` failure (immediate), queue depth, oldest-age thresholds; failed financial jobs are incident-tracked with root-cause before retry.

### 20.4 Notifications

Channels: in-app + email; templated; no secrets/full numbers/tokens (template lint + test). Full catalogue wired per Scope §91 including all nineteen merchant-finance notifications. Recipient resolution is permission + scope filtered; category-level mute for non-critical categories only.

---

## 21. Search Strategy

Launch: **PostgreSQL-native** (external search only when measured latency exceeds targets).

1. Exact-match lookups across `payment_reference`, `reference_class`, `external_reference`, `provider_transaction_id`, `order_tracking_id`, `mpesa_receipt`, `checkout_request_id`, checkout-session IDs, payout/batch/customer references, merchant settlement references, chargeback references, case references. A unified `GET /api/internal/v1/search?q=` classifies the query shape and probes the right indexes; results are **scope-filtered before assembly** (no cross-scope count/order/timing hints).
2. Masked-suffix search (phone/bank/destination) via dedicated hash columns, gated by `collections.investigate` or equivalent.
3. Fuzzy name search (beneficiaries, merchant accounts, provider merchants) via `pg_trgm` GIN indexes.
4. Migration trigger: p95 > 500 ms at production volume for one week → ADR for Meilisearch with scope-filtered indexes; financial detail pages continue reading PostgreSQL; index freshness displayed.

---

## 22. Observability and Audit Logging Strategy

### 22.1 Telemetry

- **Structured JSON logs** (correlation ID, route, env, actor public IDs, latency); 90 days hot, 13 months cold.
- **Sentry** with release tagging and PII scrubbing aligned to the redaction list.
- **Metrics** (Prometheus `/metrics`, internal port): HTTP latency histograms per route class; queue depth/lag/failures; webhook ack latency (C2B and IPN ack budgets are hard SLOs); outgoing delivery success ratio; provider adapter latency/error/breaker state per account; DB/Redis health; ledger posting rate; open exceptions by severity; `UNKNOWN` counts and ages; **and the launch metric series (Scope §101):** `pesapal_order_submit_total`, `pesapal_order_submit_failure_total`, `pesapal_ipn_received_total`, `pesapal_ipn_duplicate_total`, `pesapal_status_query_total`, `pesapal_status_query_mismatch_total`, `pesapal_refund_total`, `merchant_settlement_expected_total`, `merchant_settlement_overdue_total`, `merchant_settlement_value_overdue_minor`, `merchant_allocation_imbalance_total`, `merchant_negative_balance_total`, `merchant_reserve_value_minor`, `chargeback_open_total`, `chargeback_deadline_breach_total`, `provider_fee_variance_minor`, `daily_close_incomplete_total`. Money metrics carry currency labels, never high-cardinality transaction IDs.
- **Health endpoints:** `/health/live` vs `/health/ready` (DB + Redis + storage + queue heartbeat); readiness gates deploys.
- **Alert routing:** critical → page; high → immediate channel; medium → daily digest. Every alert names its runbook in `docs/runbooks/alerts.md`.

### 22.2 Audit Log Mechanics

Append-only `audit_logs` with hash chaining (`row_hash = sha256(prev_hash || canonical_json(row))`); `audit:verify-chain` daily and on demand; verification failure = critical incident. DB trigger blocks UPDATE/DELETE (runtime-tested). Sensitive-category reads are themselves logged.

### 22.3 Audited Event Catalogue (minimum)

Identity/access: link lifecycle, logins, step-up outcomes, session revocations, invitations, user status, role/permission/override changes, delegated sync events. Registry: product/application/merchant-account changes, credential lifecycle, bank/destination create-change-approve-activate-deactivate, provider account changes, **provider merchant lifecycle, onboarding case events, compliance status changes, holds created/released, contract uploads/activations, capability activations/suspensions/expiries, settlement calendar changes, launch flag changes, kill-switch and operating-mode changes, pilot cohort changes, limit overrides**, route lifecycle + manual overrides, settings changes. Financial: payment/attempt/checkout-session lifecycle, C2B confirmations applied, IPNs applied, duplicates ignored, **allocation created/validated/submitted/adjusted, merchant settlement lifecycle, reserve lifecycle, negative-balance creation/offset/recovery/write-off, chargeback lifecycle, statement generation**, payout/refund/reversal/transfer lifecycle, ledger corrections, suspense actions. Reconciliation and close: run lifecycle, exception lifecycle, **daily close prepare/approve/reopen, period close/reopen**. Cases: full lifecycle + external communications. Integration: incoming received/processed/failed/replay-ignored, outgoing created/delivered/dead-lettered/replayed, endpoint pause/resume. Files/exports: sensitive uploads, quarantines, KYB document access, export lifecycle. Break-glass: invocation, actions, revocation, review.

### 22.4 Redaction List (enforced by log processor + test)

Never logged: magic-link tokens; session IDs; OAuth secrets/tokens; provider credentials; webhook signing secrets; full bank account numbers; full settlement destinations (bank or mobile-wallet numbers); full MSISDNs; raw card data (must never exist); `Authorization`/`Cookie` headers; signed URL signatures; **KYB document contents; beneficial-owner personal data; full provider merchant identifiers where masked forms suffice**. Raw provider payloads live only in `incoming_webhooks.raw_payload` (access-controlled, excluded from log shipping); support views show redacted projections.

---

## 23. Performance and Scalability Plan

### 23.1 Launch Performance Targets (Phase 26 load-verified)

| Surface | Target |
|---|---|
| C2B validation response | p95 < 800 ms end-to-end |
| C2B/STK callback + PesaPal IPN acknowledgment | p95 < 500 ms (persist-raw + ack only) |
| Product API create (excl. provider latency) | p95 < 400 ms |
| Product API reads | p95 < 250 ms |
| Checkout-session creation (excl. provider) | p95 < 400 ms |
| Dashboard overview | p95 < 1.5 s server time |
| Transaction search | p95 < 500 ms |
| Queue lag (`financial`) | p95 < 30 s under load |
| Outgoing webhook first attempt | p95 < 60 s from state change |
| Bulk import validation | 10,000 rows < 5 min |
| Settlement-file ingestion | 50,000 lines < 15 min |
| Merchant statement generation | 100 merchants < 10 min |
| Daily close computation | per provider account < 10 min |
| Export generation | 100k rows < 10 min |

### 23.2 Mechanisms

Pagination everywhere; schema-designed indexes with `EXPLAIN` snapshots for the top 20 operational queries; `Model::preventLazyLoading()` outside production; Redis caching for dashboard aggregates (60 s TTL + tag invalidation), permission maps (identity-version invalidated), route eligibility (route-change invalidated); **no cache in the financial write path**; bulk inserts for batch items and statement lines; per-account provider rate limiting; ingestion decoupled from processing; frontend route-group lazy loading + virtualized lists; slow-query log (>200 ms) reviewed weekly.

### 23.3 Predicted Bottlenecks and Mitigations

| Bottleneck | Mitigation |
|---|---|
| `incoming_webhooks` growth (highest volume) | Monthly partitioning pre-declared; BRIN on `received_at`; cold-storage archival |
| `ledger_entries` volume + balance reads | Append-only inserts; per-account running summaries updated transactionally |
| `statement_lines` ingestion bursts | Chunked parsing on `statements` queue; bulk inserts; dedupe by hash before row writes |
| Status-query storms after provider outage | Oldest-first bounded sweeps + token buckets + breaker-aware skip |
| IPN storms (PesaPal retries) | High-ceiling throttle + replay detection + idempotent application; anomaly alerting |
| Webhook retry storms after product outage | Backoff + jitter + per-endpoint pause; durable events |
| Merchant statement generation | Immutable-source reads, per-merchant chunking, `statements` queue |
| Dashboard aggregates | Cached + freshness stamps, never live scans |

---

## 24. Security Threat Model

### 24.1 Methodology

STRIDE per surface in `docs/security/threat-model.md`, revisited at every phase exit that adds a surface. Every row names a control and a verification artifact.

### 24.2 Threat → Mitigation Table (launch baseline)

| Threat | Attack example | Mitigations | Verification |
|---|---|---|---|
| SQL injection | Crafted filter param | Eloquent bindings; raw SQL banned; allowlisted sort/filter | SAST + `FilterInjectionTest` |
| XSS | Malicious beneficiary/merchant name | Interpolation only; `v-html` banned; CSP | ESLint + CSP test + stored-XSS e2e |
| CSRF | Forged internal mutation | Sanctum CSRF; SameSite; token-based product API | `RouteSecurityContractTest` |
| Broken access control / IDOR | Foreign `public_id` probing | Scoped binding, 404 posture, policies, probe events | Isolation suite (8.6) |
| Mass assignment | Extra JSON fields | `$fillable` allowlists; explicit DTOs | `MassAssignmentTest` per model |
| File upload abuse | Polyglot/malware/zip bomb | Section 19 pipeline | Upload abuse tests |
| Sensitive data exposure | Bank/destination/KYB in API or logs | Encrypted+masked split; redaction list; resource allowlists | `NoInternalIdLeakTest`, redaction test |
| Session fixation | Pre-auth session reuse | Regeneration on login + privilege change | Auth tests |
| Magic-link replay/forward | Reused link | Atomic consume; 15-min expiry; audience/env binding; step-up regardless | `MagicLinkReplayTest` |
| Brute force / flooding | Link or consume hammering | Section 9.6 limiters; generic responses | Rate-limit tests |
| API abuse | Scope escalation, quota abuse | Scopes ∩ entitlements; per-app limits; anomaly alerts | Entitlement gate tests |
| Unsafe redirects | `?redirect=` to attacker | Server-side allowlist | `RedirectAllowlistTest` |
| Dependency vulnerabilities | Known CVE | composer/npm audit + Dependabot + Trivy; time-bound suppressions | CI gates |
| SSRF | Webhook endpoint at internal metadata | Endpoint allowlist; private-IP block; adapter URLs from config | `WebhookSsrfTest` |
| XXE/deserialization | Malicious statement file | Entity resolution disabled; no `unserialize` of external data | SAST rule |
| Webhook/IPN spoofing | Fake "payment received" | Section 24.3 corroboration | Forged-callback tests |
| Webhook/IPN replay | Re-sent real event | Receipt/order-tracking uniqueness + hash replay detection → ack-without-effect | Duplicate tests |
| Outgoing webhook forgery | Fake events to products | HMAC (W-A07); per-app secrets; rotation | Contract tests + published guide |
| Credential leakage | Secrets in repo/logs/frontend | gitleaks; secrets manager; bundle grep; redaction | CI gates |
| Privilege escalation | Self-role-grant | `roles.manage` + step-up; deny-beats-grant; identity-version | Permission tests |
| Duplicate financial execution | Retry/timeout double-pay | Idempotency; uniqueness; non-terminal-attempt index; UNKNOWN discipline | Concurrency suite (25.5) |
| Ledger tampering | Direct UPDATE | DB triggers; no mutation path; chain-verified audit | Runtime trigger test |
| Route/config tampering | Redirecting settlement | Maker-checker; step-up; config versioning; snapshots | Route approval tests |
| Insider misuse | Redirecting a refund/destination | Versioning + reapproval; enhanced verification; maker-checker; audit; alerts | `RefundDestinationChangeTest` |
| **Settlement-destination fraud** | Insider or compromised account changes a merchant's payout destination | Destination versioning; cooling-off; maker-checker; step-up; out-of-band merchant notification; provider re-verification; settlement pause; high-severity audit | `DestinationChangeAttackTest` (the Scope §115.9 attack scenario) |
| **Provider merchant misuse** | Merchant A transacting via merchant B's provider identity | Composite FKs; service guards; capability gating | `ProviderMerchantIsolationTest` |
| **Wrong-merchant / wrong-destination settlement** | Provider settles the wrong party | Destination pinning; three-way reconciliation; auto-critical exceptions; containment runbook | `WrongDestinationContainmentTest` |
| **Redirect-forged success** | Attacker calls return URL to fake payment | Checkout-session state machine; signed state; status-query corroboration | `RedirectCannotMarkSuccessTest` |
| **Reserve over-release / cross-merchant offset** | Draining reserves or netting across merchants | DB-enforced invariants; segregation | `ReserveInvariantTest`, `CrossMerchantOffsetTest` |
| **Contract/capability/KYB expiry exploitation** | Transacting on expired authority | Effective-date DB gates; expiry scans; route pause | `ExpiryGateTest` |
| **Legal-hold evasion** | Deleting held evidence | Hold flag suspends deletion/archival | `LegalHoldTest` |

### 24.3 Incoming Provider Callback and IPN Trust Model

Daraja signs nothing; PesaPal IPNs are notifications. Wallet never treats callback contents as authoritative on arrival:

1. Transport: TLS-only; per-provider-account 128-bit secret path segments (rotatable); source-IP allowlists where published; content-type + 64 KB limits.
2. Persist-then-verify: raw stored immutably; ack; async corroboration — STK callback must match a Wallet-created `checkout_request_id`; C2B confirmation must match a registered reference + shortcode; **PesaPal IPN must resolve a Wallet-created `order_tracking_id` and is confirmed by a transaction-status query where required (always for first-launch high-value threshold policy)**; amounts/currency cross-checked; `mpesa_receipt` and `(provider_account, order_tracking_id)` uniqueness block replays.
3. Non-corroborated events → exception queue with alerts; they can never post ledger entries or emit product webhooks.
4. High-value confirmations additionally verified via status query before final posting (configurable threshold).

### 24.4 Security Testing Program

SAST (PHPStan L8 + custom rules, ESLint security) every run; dependency/secret/image scanning every run; security-regression suite every run; DAST (OWASP ZAP baseline) weekly against staging; independent external security review before launch — critical/high findings closed or formally accepted with compensating controls.

---

## 25. Testing Strategy

### 25.1 Layers and Tooling

| Layer | Tooling | Scope |
|---|---|---|
| Unit | Pest | Money, ULIDs, state machines, signing, references, normalizers, fee/commission/tax calculators, rounding |
| Domain | Pest | Ledger balancing, allocation engine, refund allocator, routing engine, approval policies, reserve engine, position calculator |
| Feature/API | Pest + Laravel HTTP against **PostgreSQL** (never SQLite — Postgres constraints are load-bearing) | Every route: positive, denial, validation, cross-scope |
| Isolation | `tests/Isolation` | Section 8.6 matrix + generative coverage |
| Concurrency | Pest + parallel helpers | Section 25.5 |
| Contract | Fixtures + Phase 16 simulator | Daraja + PesaPal adapters (every scenario), webhook signing vectors |
| Frontend component | Vitest + Testing Library + axe | UI states, forms, both themes |
| E2E | Playwright | Critical workflows (25.7), responsive sweeps, dark mode, a11y |
| Load | k6 | Section 23.1 targets |
| Fault injection | Failure-forcing fakes | Section 4.4 atomicity; Redis/storage-down degradation |
| Security regression | `tests/Security` | Threat-model verifications |

CI runs everything in clean containers against PostgreSQL 16 + Redis 7; flaky tests are defects; skips require a written reason + issue link.

### 25.2 Per-Module Test Plans (`tests/{Layer}/{Module}/{Name}Test.php`)

**Identity (Phase 5):** `MagicLinkRequestTest`, `MagicLinkConsumeTest` (incl. concurrent double-consume), `StepUpTest`, `SessionControlTest`, `MagicLinkRevocationTest` — every Scope §114.1 scenario named.

**Access (Phases 8–9):** `PermissionMatrixParityTest`, `AccessDecisionTest` (all 14 inputs), `DenyBeatsGrantTest`, `SelfApprovalDeniedTest`, `SegregationMatrixTest` (all nine Scope §17 rules, each as its own denial), `InvitationLifecycleTest`, `RoleChangeAuditTest`.

**Registry (Phases 6–7):** CRUD + approval flows; `BankAccountMaskingTest`; `NoHistoricalDeletionTest`; `CredentialNeverEchoedTest`; `EncryptionAtRestTest`; `EconomicPurposeRegistryTest` (no unreviewed extension); `FundsFlowModelGateTest` (disabled model cannot enable without compliance approval — DB-level); `LaunchFlagTest` (defaults; flag cannot override compliance gate); `SettlementCalendarVersionTest` (historical dates never rewritten); `ContractRegistryTest` (expiry alerts; route-activation coverage); `CapabilityGateTest` (fail-closed on absent/expired/untested capability).

**Merchant finance registry (Phase 7–8):** `ProviderMerchantLifecycleTest` (all onboarding states + events); `ProviderMerchantIsolationTest` / `-EnvironmentTest` / `-ProductTest`; `DestinationVersioningTest` (change → new version + invalidated approvals + cooling-off + out-of-band notification + step-up + maker-checker + audit + no-settlement-until-activation); `DestinationImmutabilityTest` (version UPDATE fails at DB); `CoolingOffTest`; `ComplianceStatusTest` (states, provider-managed evidence, expiry pause); `ComplianceHoldTest` (hold effects per type; creator ≠ releaser); `MerchantStatusEffectsTest` (each Scope §69 status × operation matrix); `OffboardingClosureBlockTest` (negative balance/reserve/open items block closure); `KybDocumentTest` (expired-document prohibition; retention).

**Routing (Phase 12):** `RouteSelectionTest` — every Scope §36.1 rejection rule as a negative case, including purpose scope, beneficiary scope, funds-flow blocked, provider-merchant missing, destination unverified, contract expired, capability absent, merchant ineligible, kill switch; deterministic ranking; `ControlledFallbackTest` (all §36.2 conditions; timeout → UNKNOWN; no cross-model fallback); `RouteSnapshotImmutabilityTest` (incl. new snapshot fields); `RouteActivationGateTest` (compliance-approval trigger); `ManualOverrideAuditTest`; `KillSwitchTest` (blocks new, callbacks continue, per-mode matrix).

**Daraja adapter (Phase 12):** `DarajaAuthTest`, `BreakerTest`, `AdapterAmbiguityMappingTest`.

**PesaPal adapter (Phase 12A):** `PesaPalAuthTest` (token acquisition, refresh, failure → typed exception); `PesaPalIpnRegistrationTest`; `PesaPalOrderSubmissionTest` (success; duplicate external reference; validation failure; ambiguous submission → UNKNOWN); `PesaPalStatusQueryTest` (success, failure, pending, cancelled, not-found, mismatch vs IPN → status query controls + mismatch metric); `PesaPalRefundTest` (success, failure, original-instrument rule); `PesaPalCancellationTest` (capability-gated); `PesaPalFeeCaptureTest`; `PesaPalErrorMapTest`; `PesaPalTimeoutTest` (timeout → UNKNOWN never FAILED); `CapabilityUnavailableTest` (uncontracted method throws).

**Collections (Phase 14):** `PaymentRegistrationTest` (full contract incl. purpose validation, beneficiary constraints, policy-version validation, every 11.2 rejection); `EconomicOwnershipTest` (merchant payment cannot use Citrus beneficiary; Citrus fee cannot use merchant beneficiary; beneficiary/purpose/funds-flow immutable after submission; contractual-seller and merchant-of-record rules); `ReferenceClassTest` (correct class per purpose; public reference contract preserved); `StkAttemptTest`; `C2bValidationTest` (all 12 checks + response budget); `C2bConfirmationTest` (duplicate ack without second credit; same receipt/different amount → integrity exception; unknown reference → exception queue; under/over/late/paid policies; callback-before-response); `CheckoutSessionTest` (creation, expiry, single-use, reuse rejection, return-URL allowlist, signed state, abandoned handling, superseded); `RedirectCannotMarkSuccessTest` (redirect-before-IPN, IPN-before-redirect, forged return call); `PesaPalCollectionFlowTest` (order → redirect → IPN → status query → SUCCEEDED; cancelled/incomplete orders never become successful); `DuplicateIpnTest`; `AttemptHistoryPreservationTest`; `RiskDecisionTest` (ALLOW/REVIEW/HOLD/DENY paths; hold preserves instruction); `DataQualityTest` (every Scope-mandated validation: active merchant, permitted purpose, positive amount, supported currency, normalized customer reference, active provider merchant, verified destination, commission policy exists, allocation balances, no cross-environment references, no duplicate external reference / order-tracking ID / provider transaction ID, no impossible settlement date, no refund above balance).

**Allocation & policies (Phase 14D):** `AllocationBalanceTest` (balanced commits; unbalanced cannot commit — DB proof); `AllocationImmutabilityTest` (post-submission UPDATE fails; superseding corrections); `AllocationRoundingTest` (deterministic; remainder to configured party; property-based over random amounts); `CommissionCalcTest` (fixed, percentage, tiered, min/max caps); `FeeBearerTest` (each bearer value → correct allocation + posting); `TaxCalcTest` (VAT, withholding, inclusive/exclusive); `PolicyVersioningTest` (later policy change never recalculates history); `PolicyActivationSegregationTest`; `ConcurrentAllocationTest` (parallel submission → single allocation); `PartialRefundAllocationTest`; `SettlementInstructionSnapshotTest` (instruction matches allocation; contract-test comparison vs provider statement fixture).

**Ledger (Phase 15):** `LedgerBalanceTest` (unbalanced posting cannot commit); `LedgerImmutabilityTest`; `PostingIdempotencyTest`; `AtomicityTest` (fault injection at every step of Section 4.4 incl. allocation and settlement-expectation steps); `SuspensePostingTest`; `PostingTemplateTest` — all sixteen Scope §72.2 templates, each asserting exact account categories, balance by currency, policy-version stamping, and **that merchant money never reaches a Citrus revenue account except via the commission entries** (`MerchantMoneyNeverCitrusRevenueTest`).

**Merchant settlement (Phase 15B):** `MerchantSettlementLifecycleTest` (every state incl. partial, delayed, held, returned, unknown); `ExpectedSettlementFromAllocationTest` (calendar-derived dates; snapshot preservation); `DestinationPinningTest` (in-transit completes on pinned version); `SettlementNetInvariantTest` (net = allocation net after authorised adjustments — DB proof); `InactiveDestinationTest` (settlement to inactive destination unrepresentable); `DuplicateSettlementTest`; `ReturnedSettlementTest` (posting template 14; replacement requires active destination); `SettlementSlaTest` (pre-breach and breach alerts); `PositionCalculatorTest` (all Scope §52 components; freshness stamps).

**Statements & close (Phase 16B):** `MerchantStatementTest` (all Scope §56 contents; line totals = summary at DB; reproducibility from immutable sources; no cross-merchant rows; no Citrus internals; never calls ledger balance a deposit); `DailyCloseTest` (all §77 outputs; late-event handling; preparer ≠ approver; incomplete-close alert); `AccountingPeriodTest` (preliminary/final close; material-exception block at DB; controlled reopen; no entry edits).

**Webhooks (Phase 13):** `IncomingPersistFirstTest`; `ReplayDetectionTest`; `OversizedPayloadTest`; `OutgoingSigningTest` (canonical vectors published); `DeliveryRetryTest`; `OutboxAtomicityTest`; `EndpointAllowlistTest`; `WebhookSsrfTest`; `EventCatalogueTest` (merchant-finance events emitted; internal events not auto-sent to products).

**Payouts/Approvals (Phases 18–19):** `PayoutIdempotencyTest`; `MakerCheckerTest`; `ApprovalInvalidationTest` (field-by-field material changes); `BeneficiaryVersionTest`; `UnknownStateTest`; `ConcurrentApproverTest`; `FundingSourceDeactivatedTest`; `CancellationAfterAcceptanceTest`; `ApprovalSubjectExtensionTest` (destinations, provider merchants, policies, reserves, holds, capabilities, closes, reopens all flow through approval_requests).

**Refunds (Phase 20):** `RefundConcurrencyTest` (flagship over-refund race under parallel load); `RefundValidationTest` (all 15 Scope §60 checks as negatives); `RefundFundingPartyTest` (`UNDETERMINED_BLOCKED` rejects; each funding source posts correctly); `RefundAfterSettlementTest` (reserve application; negative-balance creation; posting templates 6–7); `RefundDestinationChangeTest`; `RefundUnknownTest`; `RefundStatementImpactTest`; `NegativeBalanceTest` (isolation per merchant; offset only where policy permits; recovery postings; closure block); `ReserveTest` (cannot over-release — DB proof; applied to refund; release schedule; segregation above threshold).

**Chargebacks & cases (Phase 20A):** `ChargebackLifecycleTest` (every state; deadline calculation; escalating alerts); `ChargebackAmountCapTest` (DB-enforced cap); `ChargebackEvidenceTest`; `ChargebackLossAllocationTest` (templates 8–9; reserve impact; statement impact); `ChargebackDuplicateEventTest`; `CaseLifecycleTest` (linkage, scope isolation, SLA timers, resolution evidence, reopen audit); `ExternalCommunicationLogTest`.

**Bulk (Phase 22):** `BatchValidationTest`; `PartialSuccessTest`; `BatchCancellationTest`; `BatchFundsExhaustionTest`; file abuse tests; 10k-row performance test.

**Reconciliation (Phase 16):** `StatementIngestTest` (quarantine; file/content dedupe; schema versioning; unknown-column preservation; period/currency validation; line balancing); `MatchingTest` (every Scope §76.3 detection type synthesized and detected, incl. wrong merchant, wrong provider merchant, wrong destination, incorrect gross/fee/commission/net, missing/partial/duplicate/returned settlement, reserve variance, negative-balance variance, unmatched refund/chargeback); `ThreeWayReconTest` (Wallet ↔ PesaPal transaction ↔ settlement/statement); `FourWayReconTest` (adds bank statement); `FeeVarianceTest`; `AllocationReconTest`; `MerchantStatementReconTest`; `AmbiguousMatchTest`; `ExceptionResolutionTest`; `LedgerImbalanceIncidentTest`; `MaterialityEscalationTest` (wrong merchant/destination auto-critical).

**Launch controls (Phase 24/27):** `LaunchControlTest` (flag cannot override compliance gate; kill switch blocks new payments while callbacks/refunds/status queries continue per mode); `PilotAllowlistTest`; `PilotCapTest` (daily/monthly caps; cap-reached alert); `LimitOverrideTest` (reason + step-up + expiry); `OperatingModeTest` (each mode's permission matrix); `ExpiryPauseTest` (capability/contract/KYB expiry pauses route); `BreakGlassTest` (cannot edit ledger or bypass idempotency); `RouteDoctorTest` (each drift type → exception; optional pause).

### 25.3 Cross-Cutting Required Cases

For every module: success; permission denial; cross-scope denial (404); validation failure map; idempotent replay; duplicate callback/IPN; expired/stale-state conflict; concurrency race; provider failure; partial failure; recovery path.

### 25.4 Isolation Suite

Section 8.6 matrix plus generative tests: for every registered owned model, create rows under two scopes, run every index/show/export/statement surface as scope-A, assert zero scope-B leakage (model registry drives it; new tables auto-covered or CI fails).

### 25.5 Concurrency Suite (financial safety core)

- Two parallel refunds totaling > refundable → aggregate never exceeds.
- Parallel identical idempotency keys → one execution, one replay.
- Parallel STK attempts on one payment → cooldown/partial-unique blocks the second.
- Parallel duplicate C2B confirmations → one credit. **Parallel duplicate IPNs → one credit.**
- **IPN racing a status query → single consistent transition, no duplicate posting.**
- **Settlement file racing an IPN → idempotent match, no duplicate settlement.**
- **Refund racing a chargeback → serialized; combined effect ≤ eligible amount.**
- **Parallel allocation submissions → single allocation.**
- **Destination suspension racing settlement processing → settlement holds safely.**
- Parallel approvals racing an invalidating edit → stale-snapshot approval rejected.
- Parallel payout submission jobs → single provider call.
- Scheduler double-fire → no duplicate postings/webhooks/close runs.
- Worker crash after provider acceptance → recovery via status query; no duplicate submission.

### 25.6 Security Regression Suite

Every Section 24.2 verification, every CI run.

### 25.7 E2E Critical Workflows (Playwright)

1. Magic-link login → dashboard (light + dark).
2. API payment (simulator) → STK success → detail shows SUCCEEDED + allocation + ledger + webhook delivered.
3. **PesaPal checkout: create payment → checkout session → simulator redirect + IPN + status query → SUCCEEDED → allocation breakdown → expected merchant settlement visible.**
4. C2B confirmation → unknown reference → exception queue → resolve with evidence.
5. Payout: create (maker) → approve (checker, step-up) → simulator success → ledger verified; self-approval visibly denied.
6. Refund exceeding balance rejected; valid partial refund succeeds; **refund after settlement draws reserve and updates position.**
7. Batch upload mixed rows → error report → approve → partial success.
8. Bank account create → maker-checker → masked display → step-up reveal.
9. **Provider merchant onboarding: create → submit → approve (evidence) → destination create → verify → approve → activate (cooling-off visible).**
10. **Merchant statement generation → view → totals match position; daily close prepare → approve.**
11. **Chargeback receive → evidence deadline countdown → submit evidence → loss allocation visible; case create → assign → resolve.**
12. **Kill switch activation → new payment blocked → callback still processed; pilot cap reached → alert.**
13. Route activation flow with production banner + confirmation restatement.
14. Responsive sweep + a11y smoke on the 12 core pages, both themes.

---

## 26. Deployment and CI/CD Strategy

### 26.1 Docker

`docker/Dockerfile.app` (multi-stage composer → PHP 8.3-fpm-alpine, opcache, non-root), `Dockerfile.frontend`, `Dockerfile.worker` (Horizon entrypoint), `Dockerfile.scheduler`; `docker-compose.yml` dev stack (app, nginx, postgres:16, redis:7, minio, mailpit, clamav, horizon, scheduler, simulator profile); images pinned by digest; Trivy gates CI.

### 26.2 Environments

`local → ci → sandbox (integrators) → staging → production`, isolated DB/Redis/buckets/secrets; config via env vars; `config:cache`/`route:cache`/`event:cache` in images; production boot guard asserts debug off, HTTPS, non-sandbox credential key IDs, Redis drivers, secure cookies.

### 26.3 CI Pipeline (every PR)

```text
1. Static: Pint, PHPStan L8 + custom rules (tenancy, money, provider-namespace,
   status-assignment), ESLint + vue-tsc, Stylelint, migration-manifest lint.
2. Security: composer audit, npm audit, gitleaks, Trivy.
3. Tests: unit → feature/API → isolation → concurrency → security against
   Postgres+Redis containers; frontend vitest; contract tests (Daraja + PesaPal).
4. Build: images; OpenAPI generation + parity check; bundle secret-grep.
5. E2E: Playwright against the composed stack (main + release branches).
6. Artifacts: coverage, OpenAPI hash, phase evidence bundle.
```

Merges to `main` require green pipeline + review; release branches auto-deploy staging; production deploys manual-approval gated.

### 26.4 Deployment Procedure

1. Pre-deploy: suite green; `migrate --pretend` reviewed; manifest compatibility check.
2. Deploy: pull images → additive migrations → rolling app restart behind readiness → `horizon:terminate` graceful worker respawn → scheduler replace.
3. Post-deploy: smoke suite (health, login, simulator payment round-trip in staging); 15-min error watch.
4. **Rollback:** redeploy previous image tag (expand-and-contract schemas); data defects → forward-repair migration + incident record; **financial containment per Scope §106.5** — pause affected routes, keep receiving callbacks and status queries, preserve raw payloads, reconcile in-flight, produce incident + accounting impact reports. A rollback never rolls back financial facts.

### 26.5 Secrets

Secrets-manager paths `wallet/{env}/db|redis|mail|objectstore`, `wallet/{env}/providers/daraja/{account}`, **`wallet/{env}/providers/pesapal/{account}`**, `wallet/{env}/webhooks/{application}`; rotation runbooks per class; rotation audits; `.env.example` documents every variable with safe placeholders. Seed scripts never contain real secrets or full bank details.

### 26.6 Backups and DR

Nightly full PostgreSQL backups + WAL archiving (PITR); RPO ≤ 5 min, RTO ≤ 4 h documented; object-storage versioning + lifecycle; **monthly restore exercise** verifying boot, row counts, trial balance, audit chain, sample signed downloads — evidence filed. Reconciliation-led recovery resolves UNKNOWNs before any resubmission.

### 26.7 Production Cutover Requirements

No production route activates until: provider onboarding complete; bank account (or merchant destination) verified + approved; callback/IPN URLs registered and test-verified; reconciliation tested for that route; approval policies tested; runbooks approved; monitoring live; **and for merchant funds-flow routes: provider merchant approved, destination verified, funds-flow assessment approved, contract version covering, capability evidence recorded**. Per-route checklist file: `docs/launch/route-activation/{route}.md`.

### 26.8 Production Data Migration and Seed Controls

Launch uses controlled seeds only: Citrus Labs legal entity; Servana product (+ Kikao/SkillFlow); production applications; Daraja + **PesaPal** providers and provider accounts; payment methods; currencies; provider capabilities (evidence-backed states only); settlement calendars; chart of accounts; role/permission matrix; launch feature flags (safe defaults); route policies. Production prohibits synthetic transactions except marked, reconciled canaries; test merchants segregated from production merchants.

---

## 27. Step-by-Step Development Roadmap

Every phase is one reviewable PR (sub-PRs where flagged), follows Section 28, and must produce: the named tests, passing suite output, the named evidence artifacts, and updated `PROGRESS.md`/`CHANGELOG.md`/traceability rows. **Common rollback rule:** migrations are expand-and-contract, so rollback = redeploy previous images; a shipped data defect gets a forward-repair migration under incident procedure. **Common acceptance rule:** a phase is complete only when its acceptance criteria are demonstrated with evidence, never on compilation or claim. **Common exit gate:** Section 28.4 ritual.

### Phase 0 — Project Initialization

- **Objective:** verified-empty starting point, repository skeleton, plan adoption.
- **Prove the need:** `ls`/`git status` confirm no prior code; record in `docs/verification/initial-state.md`.
- **Files:** `README.md`, `.gitignore`, `.editorconfig`, ADR set: `0001-modular-monolith`, `0002-postgresql`, `0003-passport-for-product-machine-auth`, `0004-magic-link-only-authentication`, `0005-money-integer-minor-units`, `0006-outgoing-webhook-signing-contract`, `0007-first-party-rbac-over-spatie`, `0008-expand-and-contract-migrations`, **`0009-economic-beneficiary-and-funds-flow-model`, `0010-provider-merchant-and-submerchant-model`, `0011-merchant-settlement-destination-separation`, `0012-pesapal-integration-boundary`, `0013-split-settlement-allocation`, `0014-merchant-payable-accounting`, `0015-paybill-purpose-segregation`, `0016-chargeback-and-reserve-model`, `0017-first-launch-pilot-and-kill-switches`**; ADR template; `docs/traceability/matrix.csv` seeded (scope-section → phase → test columns, incl. all Scope §122 rows); **`docs/decisions/blocking-ambiguities.md` seeded with the Section 2.3 register**; `docs/decisions/conflicts.md`; the domain documents `docs/architecture/domain/{merchant-finance, economic-beneficiary, funds-flow-models, payment-allocation, merchant-settlement, reserves-and-negative-balances, chargebacks}.md` (skeletons with owners/versions per Scope §118 documentation standard); `PROGRESS.md`, `CHANGELOG.md`, `Makefile`.
- **Acceptance:** all seventeen ADRs merged; traceability seeded; blocking-ambiguity register seeded; empty-state evidence recorded.
- **Risks:** skipping ADRs causes contested rework — blocked by review checklist.

### Phase 1 — Docker and Environment Setup

- **Objective:** reproducible dev/CI runtime matching production shape.
- **Files:** `docker/*`, `docker-compose.yml`, `.env.example`, `Makefile` targets, CI skeleton (lint job).
- **Security:** gitleaks hook + CI; `.env` ignored; non-default generated dev passwords.
- **Verification:** `make up` → all containers healthy; evidence: `docker compose ps` output.
- **Acceptance:** clean-clone-to-running < 15 min documented; CI lint green.
- **Risks:** ClamAV memory in dev → optional `scanning` profile locally, mandatory in CI.

### Phase 2 — Laravel Backend Foundation

- **Objective:** framework skeleton + load-bearing primitives.
- **Files:** Laravel 12 app; `Support/Money/*`, `Support/Ulid/*`, `Support/Context/OwnershipContext`, correlation + security-header middleware, `ApiExceptionHandler` with the full Scope §84.4 code catalogue as an enum (incl. merchant-finance codes); migrations `currencies`, `app_settings`, `configuration_changes`, framework tables; `database/migration-manifest.yaml`; PHPStan custom rules (money-float ban, status-assignment ban).
- **Tests:** `MoneyTest` (no float API by reflection), `MoneyCastTest`, `PublicIdTest`, `ErrorEnvelopeTest` (each code; induced 500 leaks nothing), `CorrelationIdTest`.
- **Acceptance:** suites green; PHPStan L8 clean; envelope demonstrated with curl captures.

### Phase 3 — Observability and Health Baseline

- **Objective:** logs, health checks, metrics scaffolding before business logic.
- **Files:** JSON log formatter + redaction processor (Section 22.4 list incl. KYB/destination entries), `/health/live`, `/health/ready`, `/metrics` base series, Sentry, `docs/runbooks/alerts.md` seeded.
- **Tests:** `LogRedactionTest` (synthetic secrets through every channel), `HealthEndpointTest` (dependency-kill), metrics smoke.
- **Acceptance:** redaction proven; readiness gates dependencies.

### Phase 4 — Frontend Foundation

- **Objective:** the complete UI substrate of Sections 12–17 with zero business screens.
- **Files:** `frontend/` scaffold; all `components/ui/*` plus `AllocationBreakdown`, `MerchantPositionCard`, `SettlementAgingBar`, `DeadlineCountdown`, `KillSwitchPanel`, `FlagPanel`, `CloseChecklist` shells; layouts; theme boot; `useForm`; `api/client.ts`; ESLint (`v-html` ban, UA ban), Stylelint (raw-hex ban); Playwright + Vitest + axe wiring.
- **Tests:** component tests both themes with axe; viewport sweep; theme persistence; keyboard navigation for modal/menu/drawer.
- **Acceptance:** all component tests + axe green both themes; sweep proves no scroll/overlap; flash-free theme boot evidenced.

### Phase 5 — Authentication (magic link, sessions, step-up)

- **Objective:** Section 9 in full (federation deferred to Phase 8).
- **Files:** `Modules/Identity/*`; migrations `users`, `magic_link_requests`, `security_events`, `invitations`; auth routes (`public_auth`); mail templates; `/login`, `/login/sent`, consume flow, `/profile/*`, `StepUpDialog`.
- **Backend:** Scope §15.1 flow verbatim; TOTP; session controls; rate limiters; revocation hooks.
- **Tests:** full Identity suite — every Scope §114.1 scenario a named case.
- **Acceptance:** Identity suite green; all ten scenarios demonstrated; audit rows for every link lifecycle event.

### Phase 6 — Registry Core: Legal Entity, Products, Applications, Environments, Entitlements, Purpose/Funds-Flow Registries, Launch Flags

- **Objective:** the ownership backbone (Scope §20–§21) + entitlement gates (Section 18) + **the economic-purpose registry, funds-flow-model registry, beneficiary types, settlement calendars, and launch feature flags** (Scope §31–§33, §55, §106.1).
- **Files:** `Modules/Registry/*` (partial), `Modules/Configuration/*`; migrations `legal_entities`, `products`, `applications`, `application_webhook_secrets`, **`economic_purposes`, `funds_flow_models`, `launch_flags`, `settlement_calendars`, `settlement_calendar_rules`**; seeders (Citrus Labs; KIK/SRV/SKF; 9 applications; the eleven Scope §31 purposes; the six Scope §33 models — `CITRUS_DIRECT_COLLECTION`, `PROVIDER_DIRECT_MERCHANT_SETTLEMENT`, `PROVIDER_SPLIT_SETTLEMENT`, `MERCHANT_GROSS_CITRUS_SEPARATE_BILLING`, `CITRUS_COLLECTION_MERCHANT_PAYOUT`, `MANUAL_SETTLEMENT_WITH_EVIDENCE` — with `CITRUS_COLLECTION_MERCHANT_PAYOUT.enabled = false`; the nine Scope §106.1 flags with `citrus_paybill_merchant_funds_enabled = false`; default calendars); internal API + screens for products/applications/launch controls (read-only flags at this phase); config-versioning write path.
- **DB work:** environment enum + composite-key groundwork; funds-flow enable-gate CHECK (no enable without `compliance_approval_ref`).
- **Tests:** registry CRUD + denial; `EntitlementGateTest` (all 11 gates incl. purpose); `EconomicPurposeRegistryTest`; `FundsFlowModelGateTest` (DB-level); `LaunchFlagTest`; `SettlementCalendarVersionTest`; seeder idempotency; `NoHistoricalDeletionTest` start.
- **Acceptance:** three products + nine applications + purposes + models + flags + calendars seeded and visible; entitlement and gate denials demonstrated via API captures.
- **Deferred:** flag mutation UI arrives with launch-controls screens (Phase 24).

### Phase 7 — Banks, Bank Accounts, Providers, Provider Accounts, Credentials, Provider Contracts, Capabilities, Provider Merchants, Settlement Destinations

- **Objective:** all financial-infrastructure registries (Scope §23–§30, §25) with their security posture.
- **Files:** remaining `Modules/Registry`, `Modules/Provider` (registry parts), **`Modules/ProviderContract/*`, `Modules/MerchantOnboarding/*` (registry parts)**; migrations `banks`, `bank_accounts` (+purposes, versions), `payment_providers`, `provider_accounts` (incl. contract/capability columns), `provider_credentials`, `provider_certificates`, `provider_wallets`, `payment_methods`, **`provider_contracts`, `provider_contract_versions`, `provider_fee_schedules`, `provider_service_levels`, `provider_operating_limits`, `provider_capabilities`, `provider_account_capabilities`, `provider_merchant_capabilities`, `provider_merchant_accounts`, `provider_merchant_account_events`, `merchant_settlement_destinations`, `merchant_settlement_destination_versions`**; screens per Scope §88.5, §88.8 + contract and destination screens; encrypted casts + masking.
- **Backend:** bank-account lifecycle with two-person activation (refactored onto approval_requests in Phase 18, behavior-preserving); credential write-only handling; **contract registry with expiry alerts; capability records with evidence-backed states; provider merchant CRUD + event log (onboarding workflow logic completes in Phase 8); destination CRUD with versioning, cooling-off fields, and no-activation-before-verification**; effective-date deactivation everywhere.
- **Security:** encryption at rest; reveal flows (bank + destination sensitive reads: permission + step-up + reason + audit); provider wallet ≠ bank account labeling; destination separation from `bank_accounts` (ADR-0011).
- **Tests:** `BankAccountMaskingTest`, `BankAccountActivationSegregationTest`, `CredentialNeverEchoedTest`, `EncryptionAtRestTest`, version-snapshot tests, `ContractRegistryTest`, `CapabilityGateTest`, `ProviderMerchantIsolationTest` family, `DestinationVersioningTest`, `DestinationImmutabilityTest`.
- **Acceptance:** masked screenshots; reveal audit evidence; Daraja provider row seeded with full capability metadata; **PesaPal provider row seeded with documented collection capabilities only and blank contract-dependent capabilities**; destination change flow demonstrated end to end (version + cooling-off + audit).
- **Risks:** encryption key custody → secrets runbook + `APP_KEY` rotation ADR.

### Phase 8 — Memberships, Invitations, Delegated Federation, Merchant Sync, Onboarding Workflow, Compliance Eligibility

- **Objective:** who may access what scope (Scope §13); invitation onboarding; federation client; **merchant-account mirroring with status effects (Scope §22, §69); the provider-merchant onboarding workflow (Scope §68); the compliance-eligibility layer (Scope §67)**.
- **Files:** `Modules/Identity/Federation/*`, `Modules/ComplianceEligibility/*`, onboarding workflow completion in `Modules/MerchantOnboarding`; migrations `user_memberships`, `merchant_accounts` (incl. status + closure state + contact routing), **`merchant_onboarding_cases`, `merchant_onboarding_documents`, `merchant_compliance_statuses`, `compliance_holds`, `legal_holds`**; invitation UI; users admin; federation HTTP client; membership revalidation middleware + sweep; onboarding + compliance screens.
- **Backend:** membership CRUD; invitation lifecycle; delegated login branch (feature-flagged off per W-A13, fully tested); merchant sync endpoints (built behind stub auth, activated Phase 10): `PUT /merchant-accounts/{ref}`, `POST .../status-events`, `GET .../payment-eligibility`; **status-effects matrix enforcement; onboarding state machine with document handling, provider submission/rejection/remediation records, expiry, re-verification; compliance statuses with provider-managed evidence; hold create/release with segregation; offboarding closure-blocking logic**.
- **Tests:** `InvitationLifecycleTest`, `DelegatedLoginTest`, `MembershipRevalidationTest`, `MerchantAccountSyncTest`, `MerchantStatusEffectsTest`, `ProviderMerchantLifecycleTest`, `KybDocumentTest`, `ComplianceStatusTest`, `ComplianceHoldTest`, `OffboardingClosureBlockTest`, `LegalHoldTest`.
- **Acceptance:** invitation e2e; delegated flow proven against the stub product identity server (contract fixture published); onboarding case walked `NOT_STARTED → APPROVED` and `→ REJECTED → REMEDIATION_REQUIRED` with evidence; status matrix demonstrated per status; hold effects demonstrated.

### Phase 9 — Roles, Permissions, Policies, Audit Logging

- **Objective:** full RBAC (Section 10) + append-only hash-chained audit.
- **Files:** `Modules/Access/*`, `Modules/Audit/*`; migrations `roles`, `permissions`, `role_permissions`, `user_roles`, `user_permission_overrides`, `audit_logs` (+ triggers); `docs/auth/permission-matrix.yaml` **including the full Scope §18 merchant-finance permission set**; policies for every existing resource; roles/users/audit screens.
- **Backend:** `AccessDecision`; matrix seeding; deny-beats-grant; identity-version wiring; `AuditRecorder` + chain + `audit:verify-chain`; retrofit audit events onto Phases 5–8 actions per the Section 22.3 catalogue; **segregation triggers for all nine Scope §17 rules**.
- **Tests:** `PermissionMatrixParityTest`, `AccessDecisionTest`, `DenyBeatsGrantTest`, `AuditImmutabilityTest`, `AuditChainVerifierTest`, `PolicyCoverageTest`, `RoleChangeAuditTest`, `SegregationMatrixTest`.
- **Acceptance:** matrix parity green; tamper detection demonstrated on a copy DB; denial captures.

### Phase 10 — API Foundation and Product Machine Authentication

- **Objective:** product API substrate (Section 11) + Passport (9.5) + idempotency (5.7).
- **Files:** Passport install + application linkage; `api_v1.php`; middleware `EnforceIdempotencyKey`, `EnsureEnvironmentContext`, scope middleware; migration `idempotency_keys`; pagination/filter/sort traits; OpenAPI tooling + CI parity; route-classification registry + `RouteSecurityContractTest`; TS client generation.
- **Backend:** token issuance with environment claims; scope ∩ entitlements; idempotency algorithm (all 7 branches); merchant sync + status-events + eligibility endpoints activated under real auth.
- **Tests:** `MachineAuthTest`, `IdempotencyMiddlewareTest`, `FinancialRouteIdempotencyCoverageTest`, `RouteSecurityContractTest`, pagination/filter tests, OpenAPI parity.
- **Acceptance:** sandbox Servana app token → sync endpoint round-trip captured; idempotency replay + conflict demonstrated; OpenAPI committed with hash.

### Phase 11 — Scoped Data Access Hardening

- **Objective:** enforce Section 8 everywhere, structurally.
- **Files:** global scopes, scoped binding registrars, `OwnershipAwareJob`, PHPStan tenancy rules, `tests/Isolation/*` (full 8.6 matrix incl. provider-merchant rows 11–16), model registry for generative tests, `TenantColumnCoverageTest`.
- **Tasks:** audit every route/model/job; composite FKs `(application_id, environment)`; ownership-key denormalization.
- **Acceptance:** isolation suite green; PHPStan tenancy rules in CI; deliberately-broken-branch evidence that each guard fires (then reverted).

### Phase 12 — Routing Engine, Daraja Adapter Foundation, Provider Capability and Contract Gating, Kill Switches

- **Objective:** Scope §35–§36 routing with the full funds-flow/beneficiary/capability/contract/compliance gate set + the adapter layer (5.5) with Daraja auth/transport + kill switches (Scope §107). No money flows yet.
- **Files:** `Modules/Routing/*` (routes incl. all new columns, versions, decisions, engine, snapshot builder with the extended field set), `Modules/Provider/Adapters/Daraja/*` (+ `ProviderCallExecutor`, breaker), migrations `payment_routes`, `payment_route_versions`, `routing_decisions`, `kill_switches`, `provider_operating_modes`, `transaction_limits`; route admin screens (incl. Scope §88.4 route detail: purposes, beneficiary scope, custody, contract, capabilities, requirements, policies, compliance approval, pilot limits, kill-switch state); `GET /routes/quote` + `/provider-methods`.
- **Backend:** routing inputs per Scope §36 (all nineteen rule families as explicit guards with machine-readable rejection reasons recorded in `routing_decisions`); `FallbackEligibility` service (§36.2 incl. same-funds-flow constraint); route-activation gate trigger (compliance approval; contract coverage); kill-switch evaluation in eligibility; operating-mode evaluation; manual override with permission + reason + audit.
- **Tests:** `RouteSelectionTest` (every rejection rule), `ControlledFallbackTest`, `RouteSnapshotImmutabilityTest`, `RouteVersionImmutabilityTest`, `RouteActivationGateTest`, `KillSwitchTest`, `OperatingModeTest`, `DarajaAuthTest`, `BreakerTest`, `AdapterAmbiguityMappingTest`.
- **Acceptance:** quote returns eligible route + limits for seeded sandbox config; a routing decision row shows every candidate + rejection reason including funds-flow and capability rejections; kill-switch demonstration (blocked new transaction, accepted callback).

### Phase 12A — PesaPal Adapter Foundation

- **Objective:** the complete PesaPal client behind the adapter contract (Scope §42), fixtures-first, capability-gated. No production credentials.
- **Prerequisites:** Phase 12 (adapter layer, capability gating).
- **Files:** `Modules/Provider/Adapters/PesaPal/{PesaPalClient, PesaPalAuthentication, PesaPalCollectionAdapter, PesaPalRefundAdapter, PesaPalStatusAdapter, PesaPalCancellationAdapter, PesaPalIpnRegistrar, PesaPalWebhookParser, PesaPalSettlementImporter, PesaPalErrorMapper}.php`; `docs/integrations/pesapal/{adapter-contract, ipn-contract, status-mapping, settlement-reconciliation, production-onboarding}.md`; `docs/contracts/pesapal-capability-matrix.md` (seeded from documentation; contract-dependent rows blank); fixtures for every 25.2 PesaPal scenario; metrics wiring (`pesapal_*` series).
- **Backend:** authentication with token cache + early refresh; IPN registration (per environment, IPN ID recorded on the provider account); order submission returning redirect URL + order-tracking ID; status query with canonical mapping (`docs/integrations/pesapal/status-mapping.md` is the single mapping source); refund; cancellation (capability-gated); error mapping; redaction; ambiguity → `UNKNOWN`.
- **Security:** credentials in secrets manager paths; secret-path IPN route segments; `CapabilityUnavailable` on uncontracted methods.
- **Tests:** the full Phase 12A PesaPal suite of Section 25.2.
- **Acceptance:** all contract tests green on fixtures; capability matrix committed; **no acceptance claim includes split settlement, sub-merchant settlement, merchant-onboarding API, or disbursement — these remain blocking-ambiguity-gated**.
- **Risks:** undocumented endpoint drift → fixtures versioned; sandbox verification in Phase 14; production onboarding tracked as external dependency from here.

### Phase 13 — Webhook Infrastructure (Incoming Inbox + Outgoing Signed Events)

- **Objective:** Scope §44, §82–§83 in full, provider-agnostic (Daraja callbacks + PesaPal IPNs land on the same inbox).
- **Files:** `Modules/WebhookIn/*`, `Modules/WebhookOut/*`; migrations `incoming_webhooks`, `incoming_webhook_attempts`, `webhook_endpoints`, `outgoing_webhook_events`, `webhook_deliveries`; webhook admin screens; `docs/integrations/webhook-verification-guide.md` (HMAC contract + test vectors); `scripts/verify-webhook-signature.ts` reference verifier.
- **Backend:** ingestion pipeline (persist-raw → hash → replay check → ack → queue) incl. the PesaPal IPN secret-path route; outgoing pipeline (transactional outbox → W-A07 signer → backoff+jitter → 72 h dead-letter → pause-on-failure); dual-key rotation; **event catalogue incl. merchant-finance event types (W-A08) with product-exposure filtering**.
- **Tests:** full Webhooks suite incl. `OutboxAtomicityTest`, `EventCatalogueTest`, signing vectors.
- **Acceptance:** vectors verified by the independent script; replay/dead-letter/pause demonstrated in UI evidence.

### Phase 14 — Collections: Payments, Economic Ownership, STK, C2B, PesaPal Checkout (sub-PRs: 14A payments+references+ownership, 14B STK, 14C C2B, 14E PesaPal checkout)

- **Objective:** Scope §37–§45 end to end against the Daraja and PesaPal adapters (sandbox) — the financial heart of Gate W and the collection half of Gate W-M.
- **Files:** `Modules/Collection/*`; migrations `payments` (full column set incl. economic-ownership fields + constraints), `payment_references`, `payment_attempts`, `checkout_sessions`, `mpesa_transactions`, `pesapal_transactions`; `Modules/Risk/*` launch-capable rule set + `review_queue_items`; product API routes (payments, attempts, checkout sessions); provider routes (C2B validate/confirm, STK callback, **PesaPal IPN**); collections + checkout-session dashboard screens (payment detail per Scope §88.3 incl. ownership, allocation placeholder, funds-flow, destination, related records).
- **Backend:**
  - **14A:** `POST/GET /payments` per the 11.2 contract with all rejections; purpose/beneficiary/funds-flow derivation and validation; `reference_class` issuance alongside the immutable public `{PRD}-PAY-<ULID>` reference; commercial-policy validation; per-application external-reference uniqueness; immutability triggers; risk decision hook (`ALLOW/REVIEW/HOLD/DENY`); data-quality validations (25.2 `DataQualityTest` list).
  - **14B:** STK initiation (validation → routing → attempt → adapter → provider IDs → 202), cooldown, terminal-payment block, expiry sweep, status-query integration, atomic callback applier (ledger port flagged no-op until Phase 15), customer-cancel distinction, callback-before-response resolution.
  - **14C:** C2B validation (all 12 checks within budget, indexed lookups only); confirmation via the inbox; applier (reference → amount/currency policy → receipt uniqueness → apply exact/partial/over → outbox); unknown reference → exception stub; duplicate → idempotent ack.
  - **14E:** checkout-session creation (`POST /payments/{p}/checkout-sessions`) → PesaPal order → redirect URL to product; session state machine (expiry, single-use, superseded); return handling (status query on `RETURNED`; redirect never transitions the payment); IPN applier (resolve order-tracking → corroborate → status query where required → apply idempotently); duplicate IPN handling; cancelled/incomplete orders never become successful; provider-fee capture onto `pesapal_transactions`.
- **Security:** Section 24.3 corroboration wired for both providers; msisdn encryption/masking/hashing; provider-account resolution never from payload trust; signed checkout state.
- **Tests:** the full Collections suite of Section 25.2 (every Scope §114.2 scenario 1–14 a named test; `EconomicOwnershipTest`; `ReferenceClassTest`; `CheckoutSessionTest`; `RedirectCannotMarkSuccessTest`; `PesaPalCollectionFlowTest`; `DuplicateIpnTest`; `RiskDecisionTest`; `DataQualityTest`) plus concurrency cases (duplicate confirmations, duplicate IPNs, parallel STK, IPN/status-query race).
- **Acceptance:** every collection state reachable; `SRV-PAY-` format verified against Servana ADR-014; C2B validation p95 in budget under test load; **PesaPal flow demonstrated on fixtures: order → redirect → IPN → status query → SUCCEEDED with fee captured; forged return call cannot mark success**; economic-ownership constraint denials captured at API and DB level.
- **Risks:** provider sandbox flakiness → fixtures now, simulator in Phase 16 decouples CI.

### Phase 14D — Allocation, Commission, Fee, and Tax Engines

- **Objective:** Scope §47–§50: versioned policy engines and the balanced, immutable payment allocation.
- **Prerequisites:** Phase 14A (payments with purposes), Phase 6 (registries).
- **Files:** `Modules/Allocation/*`, `Modules/Commission/*`, `Modules/Fee/*`, `Modules/Tax/*`; migrations `commission_policies(+versions)`, `fee_policies(+versions)`, `tax_policies(+versions)`, `reserve_policies(+versions)`, `payment_allocations`, `payment_allocation_items`, `settlement_instructions`, `settlement_instruction_items`; policy admin screens (Scope §88 areas 20–21) with creator≠activator flows; `AllocationBreakdown` wired on payment detail.
- **Backend:** deterministic fee engine (fixed/percentage/tiered/min/max/bearer/inclusive/exclusive/waivers/rounding); commission calculator; tax calculator (configuration-driven; finance approval to activate); allocation builder invoked in the Section 4.4 write path where the funds-flow model requires it; **deferred DB balancing trigger; immutability after submission; superseding corrections; separate-billing fallback (commission receivable creation for `MERCHANT_GROSS_CITRUS_SEPARATE_BILLING`)**; settlement-instruction snapshots.
- **Tests:** the full Allocation & policies suite of Section 25.2.
- **Acceptance:** unbalanced allocation rejected at DB (SQL capture); rounding property tests green; policy-version pinning proven (historical payment unchanged after policy change); separate-billing receivable demonstrated.
- **Deferred:** reserve application logic (Phase 15B/20); split-settlement instruction submission remains capability-gated.

### Phase 15 — Double-Entry Ledger with Marketplace Posting Templates; Settlement Basics

- **Objective:** Scope §71–§73: immutable balanced ledger wired into every existing money event, with the full sixteen-template catalogue and the merchant-finance chart of accounts.
- **Files:** `Modules/Ledger/*` (accounts, poster, directive per template, balance summaries), `Modules/Settlement/*`; migrations `ledger_accounts`, `ledger_transactions`, `ledger_entries` (+ balance + immutability triggers), `settlements`, `settlement_batches`; chart-of-accounts seeder (Scope §71.2–§71.3 incl. merchant payable, clearings, commission receivable/revenue, fee expense/recoverable, refund liability, chargeback receivable, reserve liability, negative-balance receivable, tax withholding payable, merchant funds suspense); ledger + settlement screens.
- **Backend:** `LedgerPoster` with unique posting keys and funds-flow-selected directives; templates 1–4, 6, 15, 16 live now (5 exists but is unreachable while its model is disabled; 7–14 complete in Phases 15B/20/20A); retro-wire Phase 14 appliers (removing flagged no-ops); Citrus settlement records; trial balance.
- **Tests:** full Ledger suite incl. `AtomicityTest` fault injection at every 4.4 step, `PostingTemplateTest` (each live template), `MerchantMoneyNeverCitrusRevenueTest`, trial balance zero by currency over fixture volume.
- **Acceptance:** DB-level unbalanced-posting rejection; posting idempotency; a full C2B flow and a full PesaPal flow show payment + allocation + ledger + settlement rows consistent (SQL captures).
- **Risks:** directive gaps for later events → every new financial event type must ship its directive + test (phase-template checklist item).

### Phase 15B — Merchant Settlement Lifecycle and Financial Positions

- **Objective:** Scope §52–§54: the merchant settlement aggregate, calendars in action, SLA monitoring, positions, and reserve records.
- **Prerequisites:** Phases 14D, 15.
- **Files:** `Modules/MerchantFinance/*` (settlements, events, positions), `Modules/Reserve/*` (records + movements; application logic completes in Phase 20); migrations `merchant_settlements`, `merchant_settlement_events`, `merchant_financial_positions`, `reserves`, `reserve_movements`, `reserve_release_schedules`; merchant settlement + settlement-aging + position screens (Scope §88.6, §88 areas 17–18, 22–23).
- **Backend:** expected-settlement creation from allocation + calendar (pinned destination version, SLA deadline); settlement application from provider evidence (statement/report import arrives Phase 16 — this phase applies simulator/fixture evidence); partial/delayed/held/returned/unknown handling with posting templates 10–14; position maintenance in the write path; SLA scan job; settlement events + product webhook exposure.
- **Tests:** the full Merchant settlement suite of Section 25.2 plus `ReserveTest` (record-level invariants).
- **Acceptance:** expected → provider-confirmed → settled walk with ledger + position evidence; returned settlement demonstrated (template 14 + destination review); net-invariant and inactive-destination DB proofs; SLA alert fired in test.

### Phase 16 — Reconciliation (Provider, Allocation, Merchant, Three-Way), Exception Management, Sandbox Simulator

- **Objective:** Scope §76, §79 for collections and merchant settlement + the Scope §64-style simulator covering **both Daraja and PesaPal**.
- **Files:** `Modules/Reconciliation/*` (runs, items, exceptions, matchers for every §76.1 layer relevant to collections/settlement, status-query reconciler), `Modules/Simulator/*` (sandbox-only; all 17 baseline scenarios + PesaPal: redirect-before-IPN, IPN-before-redirect, duplicate IPN, status mismatch, late IPN, cancelled order, settlement-file generation); migrations `reconciliation_runs`, `reconciliation_items`, `reconciliation_exceptions`, `provider_statements`, `bank_statements`, `statement_lines`, `uploaded_files` (core pipeline lands here); exception queue screens; statement upload screens.
- **Backend:** scheduled reconciliation per 20.2; matchers producing every §76.3 exception type incl. wrong merchant/provider-merchant/destination, incorrect gross/fee/commission/net, missing/partial/duplicate/returned settlement, reserve and negative-balance variance; **three-way matcher (Wallet ↔ provider transaction ↔ settlement evidence) and four-way extension**; fee-variance reconciliation vs versioned schedules; resolution workflow with compensating entries via approval; simulator harness API (sandbox-only, hard-off elsewhere); materiality + auto-critical classification.
- **Tests:** full Reconciliation suite (25.2); simulator-driven E2E for all scenarios; `SimulatorEnvironmentGuardTest`.
- **Acceptance:** each exception type synthesized, detected, displayed, resolvable with audit; three-way reconciliation demonstrated on a PesaPal fixture set; Gate W scenario list runnable end to end on the simulator.

### Phase 16B — Merchant Statements, Daily Close, Accounting Periods

- **Objective:** Scope §56, §77–§78.
- **Prerequisites:** Phases 15B, 16.
- **Files:** statement generation in `Modules/Reporting` + `Modules/MerchantFinance`; `Modules/DailyClose/*`; migrations `merchant_statements`, `merchant_statement_lines`, `daily_close_runs`, `daily_close_items`, `accounting_periods`, `accounting_period_actions`; statement, daily-close (Scope §88.7), and period screens.
- **Backend:** statement generator (immutable-source reads; all §56 contents; versioning; line-total trigger; single-merchant scope); daily close computation per provider account + settlement model (all §77 outputs; late-event rule); period close with completeness checks + material-exception block + controlled reopen; close approvals with segregation.
- **Tests:** `MerchantStatementTest`, `DailyCloseTest`, `AccountingPeriodTest`, `StatementScopeTest`.
- **Acceptance:** statement reproducibility proven (regenerate → identical); daily close walked prepare → approve with evidence; period close blocked by a synthetic material exception, then closed after resolution; reopen leaves posted entries untouched (SQL proof).

### Phase 17 — Gate W and Gate W-M Packaging: OpenAPI Publication, Contract Tests, Evidence Packs

- **Objective:** close **External Gate W** (Servana collections) and assemble **Gate W-M** (Servana merchant funds-flow) to the extent software can — external approvals tracked as dependencies.
- **Files:** `docs/api/openapi.yaml` (frozen v1 hash), `docs/integrations/product-onboarding-guide.md`, `docs/integrations/wallet-gate-w-evidence.md`, **`docs/integrations/wallet-gate-w-m-evidence.md`**, final webhook guide, `tests/Contract/GateW/*` and `tests/Contract/GateWM/*` mirroring every gate requirement line.
- **Gate W checklist:** registries ✓, merchant sync (incl. status events + eligibility) ✓, product auth ✓, provider accounts (sandbox) ✓, routes ✓, idempotency ✓, incoming webhooks ✓, signed outgoing webhooks + published contract ✓, payments + `SRV-PAY` issuance ✓, STK + cooldown + callbacks ✓, C2B validate/confirm ✓, duplicate/receipt protection ✓, state machine incl. partial/overpaid ✓, status-query reconciliation ✓, exception queue ✓, ledger postings ✓, settlement basics ✓, delivery retries/replay ✓, OpenAPI + event versions ✓, simulator ✓.
- **Gate W-M checklist (software-side):** approved provider merchant flow ✓, verified destination flow ✓, economic purpose + beneficiary + funds-flow enforcement ✓, allocation ✓, commission treatment (separate billing) ✓, provider fee treatment ✓, ledger templates ✓, merchant settlement ✓, merchant statement ✓, three-way reconciliation ✓, daily close ✓; **held-open external rows: PesaPal contract, capability confirmations, legal approval, funds-flow assessment, production canary** — each tracked with owner + status.
- **Acceptance:** Gate W evidence pack accepted by the Servana integration (their fixtures pass against our sandbox); Gate W-M software rows all green with the external rows explicitly open.

### Phase 18 — Beneficiaries and Approval Workflows (Extended Subjects)

- **Objective:** Scope §59, §65 as reusable modules before payout money moves, with approvals extended to every Scope-mandated subject.
- **Files:** `Modules/Beneficiary/*`, `Modules/Approval/*`; migrations `beneficiaries`, `beneficiary_versions`, `approval_policies`, `approval_requests`, `approval_actions` (+ maker-checker trigger), `risk_rules`, `risk_assessments` (promotion of the Phase 14 skeleton); beneficiary + approval-queue screens.
- **Backend:** beneficiary versioning + verification; policy engine (inputs, steps, expiry, delegation, rejection reasons, material-change invalidation field-by-field); **refactor Phase 7 two-person bank activation and Phase 7 destination activation onto approval_requests (behavior-preserving); extend approval subjects to provider merchant activation, commission/fee/tax/reserve policy activation, reserve release, compliance holds, capability activation, daily close, period reopen**.
- **Tests:** `MakerCheckerTest`, `ApprovalInvalidationTest`, `BeneficiaryVersionTest`, `ApprovalExpiryTest`, `DelegationTest`, `ConcurrentApproverTest`, `ApprovalSubjectExtensionTest`.
- **Acceptance:** approval flows demonstrated with step-up; self-approval denial at API + DB; destination and policy activations flow through approvals with segregation intact.

### Phase 19 — Single Payouts (M-PESA B2C) with Unknown-State Discipline

- **Objective:** Scope §57 for single B2C payouts: create → approve → reserve → submit → result/timeout/unknown → reconcile.
- **Files:** `Modules/Payout/*`; migrations `payouts`, `payout_attempts`; product payout routes; B2C result/timeout routes; payout screens with confirmation restatement; Daraja B2C adapter methods + status query.
- **Backend:** creation (API + internal) with idempotency + beneficiary-version pinning + routing + risk; approval integration; submission worker (reserve → non-terminal uniqueness → adapter → `SUBMITTED`/pre-acceptance-`FAILED`/`UNKNOWN`); result applier with receipt uniqueness; timeout → `UNKNOWN` + scheduled queries; every Scope §114.3 scenario explicit; ledger directives; outbox events.
- **Tests:** full Payout suite; concurrency cases; `UnknownStateFailoverTest`.
- **Acceptance:** simulator-driven success/reject/timeout→UNKNOWN→query→resolve flows with ledger + webhook evidence; duplicate-payout attack provably yields one provider call.
- **Risks:** the riskiest module — mitigated by the whole discipline, each control with named tests.

### Phase 20 — Refunds, Reversals, Reserves in Action, Negative Balances, Notification Completion

- **Objective:** Scope §60–§61, §51, §63 + the Scope §91 notification catalogue.
- **Files:** `Modules/Refund/*`; migrations `refunds` (incl. funding-party + funding-source columns), `refund_attempts`, `reversals`; refund/reversal screens with refundable-balance and funding-party display; reserve application + negative-balance flows in `Modules/Reserve` / `Modules/MerchantFinance`; `Modules/Notification/*` full catalogue + preferences UI.
- **Backend:** `RefundAllocator` (row-lock + aggregate trigger backstop); all 15 validations; refund routes (native incl. **PesaPal refund to original instrument**, reversal, B2C, bank, manual w/ evidence); **funding-party resolution per route (`UNDETERMINED_BLOCKED` rejects); refund-after-settlement path drawing merchant reserve or creating negative balance (templates 6–7, 12); negative-balance offsets (same-merchant only), invoice, hold, write-off approval, recovery postings (template 13)**; reversal engine incl. unsolicited; failed-reversal → linked refund; statement/position impacts; notification fan-out with scope filtering.
- **Tests:** full Refund suite incl. `RefundConcurrencyTest`, `RefundFundingPartyTest`, `RefundAfterSettlementTest`, `NegativeBalanceTest`, `ReserveTest` (application + over-release DB proof); reversal tests; notification scope/redaction tests.
- **Acceptance:** over-refund proven impossible under parallel load; refund-after-settlement evidence (reserve draw + position + statement); negative-balance lifecycle walked create → offset → recover; notification matrix demonstrated.

### Phase 20A — Chargebacks and Case Management

- **Objective:** Scope §62, §81: launch-capable chargeback and case domains.
- **Prerequisites:** Phase 20 (refund interactions), Phase 16B (statements).
- **Files:** `Modules/Chargeback/*`, `Modules/CaseManagement/*`; migrations `chargebacks`, `chargeback_events`, `chargeback_evidence`, `chargeback_adjustments`, `cases`, `case_parties`, `case_events`, `case_notes`, `case_evidence`, `case_assignments`, `case_sla_events`, `external_communications`; chargeback + case screens with deadline countdowns and the support evidence bundle on payment detail.
- **Backend:** chargeback ingestion (provider report/notification), deadline calculation + escalating alerts, evidence workflow, win/loss/partial/accepted postings (templates 8–9) with reserve + statement + position impacts, amount-cap DB constraint, duplicate-event idempotency; case lifecycle with SLA timers, scope isolation, communications log; case linkage from payments, settlements, exceptions, chargebacks.
- **Tests:** the full Chargebacks & cases suite of Section 25.2; refund-races-chargeback concurrency case.
- **Acceptance:** chargeback walked received → evidence → lost with balanced postings and statement impact; deadline alert escalation demonstrated; case walked create → assign → resolve → reopen with audit.

### Phase 21 — Provider Balances and Liquidity Monitoring

- **Objective:** Scope §74–§75.
- **Files:** balance polling jobs (Daraja; PesaPal where queryable), balances dashboard + thresholds, alerts.
- **Backend:** freshness tracking; operating/critical alerting; ledger-vs-provider variance; stale-balance routing policy hooks.
- **Tests:** freshness/threshold/routing tests.
- **Acceptance:** dashboard with freshness stamps; simulated low balance raises alert and blocks batch approval where policy requires.

### Phase 22 — Bulk Payouts and Secure Batch Upload

- **Objective:** Scope §58 in full.
- **Files:** `Modules/Payout/Bulk/*`; migrations `payout_batches`, `payout_batch_items`; batch UI (upload, scan state, dry run, error report, item drill-down); Section 19 batch-specific handling.
- **Backend:** workflow steps 1–18; per-line validation; totals/fees/liquidity; batch approval policies; reservation; item execution as idempotent payout jobs with provider rate limiting; result files; copy-failed-items.
- **Tests:** Bulk suite + file abuse + 10k-row performance.
- **Acceptance:** mixed-validity batch end to end; mid-execution cancel cancels only unsubmitted items; funds-exhaustion hold demonstrated.

### Phase 23 — PesaLink/Bank Adapters, Treasury Transfers, Settlement Allocation

- **Objective:** Scope §57.1(3–7), §64, §73 completion; multi-bank readiness.
- **Files:** `Modules/Provider/Adapters/{PesaLink,BankFile}/*` (manual bank-file adapter ships regardless: generate → controlled upload → reconcile), `Modules/Treasury/*`; migration `internal_transfers`; treasury screens; multi-product settlement allocation engine.
- **Tests:** adapter contract tests; transfer lifecycle; allocation-correctness property tests (allocated sum = batch net; per-product totals match transaction truth).
- **Acceptance:** simulated multi-product settlement allocates correctly; treasury transfer create → approve → record → reconcile with ledger evidence.

### Phase 24 — Reporting, Exports, Operational Search, Launch-Control Screens

- **Objective:** Scope §89–§90, §57-search, and the launch-controls area (flags, kill switches, operating modes, pilot cohorts, limits — mutation UIs).
- **Files:** `Modules/Reporting/*`; migration `exports`; report screens with the full §89 filter set; async export jobs; unified search; launch-controls screens (`pilot_cohorts`, `pilot_merchants` migrations if not landed with Phase 12 limits work).
- **Backend:** all 37 required reports as parameterized query classes with masking (financial reports read ledger/source tables directly); export pipeline (private, signed, expiring, counted, audited; formula-injection defense); search classification + scope filtering; pilot cohort + cap administration with stage-advance threshold recording.
- **Tests:** report-correctness fixtures (totals reconcile to ledger); `ExportScopeTest`; `SearchScopeTest`; `PilotAllowlistTest`; `PilotCapTest`; `LimitOverrideTest`; `LaunchControlTest` completion.
- **Acceptance:** month-end pack generated and cross-verified; all §57 key types searchable; pilot caps demonstrated; flag mutation with audit demonstrated.

### Phase 25 — Observability and Audit Completion

- **Objective:** close every Scope §101–§102 item; verify audit coverage.
- **Files:** metric completion (all Section 22.1 series incl. `pesapal_*` and merchant-finance series); alert rules + **all 35 runbooks** (`docs/runbooks/*`: the 20 baseline + pesapal-authentication-failure, pesapal-ipn-delay, pesapal-status-mismatch, pesapal-settlement-delay, pesapal-settlement-return, merchant-settlement-destination-change, merchant-negative-balance, merchant-reserve-release, chargeback-response, merchant-offboarding, provider-contract-expiry, daily-close-failure, wrong-merchant-routing, wrong-settlement-destination, pilot-kill-switch); dashboards (queue, webhook, provider health, UNKNOWN-age, exception aging, settlement aging, chargeback deadlines, close status); System Health screens.
- **Tasks:** `AuditCoverageTest` registry (every Section 22.3 event has an emitting path + test); correlation propagation verified HTTP→job→webhook; retention policies applied; SLA dashboards (Scope §117 service levels).
- **Acceptance:** chain verifier green over a fixture run containing every event type; all runbooks reviewed; on-call documented; alert-fire integration tests green.

### Phase 26 — Security Hardening and Performance Verification

- **Objective:** external-review readiness + Section 23.1 targets proven.
- **Tasks:** threat-model re-walk (incl. all merchant-finance rows); DAST + fix cycle; zero-high scan posture; CSP enforce; rate-limit tuning; k6 at 2× projected launch volume for every target incl. **PesaPal IPN storms, status-query recovery sweeps, settlement-file ingestion, merchant statement generation, allocation concurrency**; slow-query audit; **chaos day: kill Redis, kill storage, kill a worker mid-payout and mid-IPN-application, wrong-destination containment drill, pilot kill-switch drill — verify degradation rules, UNKNOWN discipline, and no duplicate money movement**; `DestinationChangeAttackTest` executed as a red-team scenario.
- **Acceptance:** load report meets every target or ADR-documented variance + remediation; external security review completed with critical/high closed; chaos-day evidence shows no duplicate movement and successful containment.

### Phase 27 — Deployment Finalization, DR Exercise, Pilot Rollout, Production Readiness

- **Objective:** Section 26 fully operational; Section 31 checklist executed; pilot rollout run; launch decision package.
- **Tasks:** production infrastructure; secrets population + rotation drills (all classes incl. PesaPal); backup + PITR restore exercise; deploy + rollback rehearsal; per-route activation checklists for launch routes (Servana collections; Servana merchant funds-flow); **production re-verification of Gate W; Gate W-M external rows closed (PesaPal contract, capability confirmations, IPN production registration, legal + funds-flow sign-off)**; legal/compliance sign-off recorded; **pilot rollout executed per Scope §108: Stage 0 canaries — (a) merchant-to-Citrus payment, (b) customer-to-merchant payment via the approved settlement model, (c) split-settlement canary only if enabled — each fully reconciled with merchant settlement at the verified destination, correct commission and fee treatment, balanced ledger, delivered webhooks, and no manual DB correction; then Stage 1 (3–5 merchants, caps, daily review) and Stage 2 (10–25 merchants) advancing only on recorded thresholds**; launch checklist execution.
- **Acceptance:** Section 31 fully green with evidence links; Stage 3 (general Servana availability) authorized only per the Scope §108.1 criteria — never merely because code is deployed.
- **Risks:** provider onboarding delay — tracked weekly from Phase 12A; software completion never reported as launch readiness while onboarding is open.

---

## 28. IDE Agent Execution Instructions

### 28.1 Per-Task Protocol (mandatory, every implementation step)

1. **Inspect first.** Read the files you intend to change and their tests. Run `php artisan route:list`, check migrations, grep for existing implementations. Never assume absence.
2. **Identify the requirement.** Name the Scope § and plan section in the PR description.
3. **Prove the gap.** Failing test, absent route, or absent schema evidence.
4. **State the stakes.** One sentence: what fails in production if omitted (e.g., "without order-tracking uniqueness, a replayed IPN double-credits a merchant payment").
5. **Smallest correct change.** No opportunistic refactors, no unrelated edits, no unneeded dependencies.
6. **Preserve behavior.** Green tests stay green; behavior changes cite the owning requirement.
7. **Tests with the change** (positive + denial + edge per Section 25.3) in the same PR.
8. **Run the suite** — module + isolation + security minimum; full suite at phase exit.
9. **Show results.** Actual command output in the phase evidence file.
10. **Demonstrate behavior.** API capture, screenshot, or SQL evidence per the phase's verification list.
11. **Document residual risk** in the risk register or phase notes with an owner phase.

### 28.2 Bug Fix Protocol (verbatim format for every defect)

```markdown
## Bug Fix Protocol
- Observed problem:
- Evidence: (failing test / log / capture)
- Affected files:
- Root cause:
- Why this is the root cause (not a symptom):
- Correct fix:
- Files changed:
- Tests added or updated:
- Test command:
- Test result: (pasted output)
- Proof of resolution: (capture/evidence)
- Remaining risk:
```

### 28.3 Hard Prohibitions for the Agent

Never: weaken/skip/delete a test to pass; catch-and-ignore exceptions; frontend-only fixes for backend authorization defects; assign a status string outside a Transition action; raw SQL against owned tables outside approved contexts; log anything on the redaction list; commit a secret or `.env`; implement a Scope §111–§112 excluded capability; invent a business rule (record a blocking ambiguity); **invent a provider capability, custody rule, fee bearer, refund/chargeback responsibility, tax treatment, or commission mechanic; enable a disabled funds-flow model or launch flag; bypass a compliance, contract, or capability gate; classify merchant money as Citrus revenue; mark a payment successful from a redirect; edit an allocation after submission; edit a destination version; cross-merchant offset**; mark a phase complete without evidence; touch provider specifics outside `Provider/Adapters/*`; treat a timeout as failure anywhere.

### 28.4 Phase Exit Ritual

1. All phase tests green in clean containers (`make fresh test`).
2. Static analysis + security scans green.
3. Evidence file `docs/evidence/phase-{n}.md` complete (commands + outputs + captures).
4. Traceability matrix rows updated (requirement → code → test → evidence).
5. `PROGRESS.md`/`CHANGELOG.md` updated with commit hashes.
6. Acceptance checklist in the phase PR ticked with links.
7. Residual risks filed.

---

## 29. Acceptance Criteria

The platform is acceptable only when every criterion below is demonstrated with evidence.

### 29.1 Identity and Access (Scope §115.1)

- [ ] Magic-link-only login; no password path (schema-verified).
- [ ] Delegated validation, inactive-user blocking, mid-session revocation.
- [ ] Matrix parity; deny-beats-grant; all nine segregation rules DB-proven.
- [ ] Isolation suites green (incl. provider-merchant rows).
- [ ] Step-up on every `requires_step_up` action; stale sessions cannot approve.

### 29.2 Product Integration (Scope §115.2)

- [ ] Three products registered with per-environment applications and disjoint credentials.
- [ ] Signed, retryable, replayable webhooks with delivery history; merchant-finance events exposed per catalogue.
- [ ] Sandbox/production isolation proven.
- [ ] OpenAPI + onboarding + webhook-verification docs published; **Gate W evidence pack accepted by Servana**.

### 29.3 Gateway, Bank, and Destination Mapping (Scope §115.3)

- [ ] Every active route identifies gateway, provider account, and (as applicable) Citrus settlement account **or** provider merchant + verified destination; funding sources identified with originating banks.
- [ ] Bank accounts verified + maker-checker approved; provider accounts onboarded + tested; route versions + snapshots immutable.

### 29.4 Collections (Scope §115.4)

- [ ] C2B centrally owned; duplicate callbacks/IPNs never double-credit (test + runtime evidence).
- [ ] STK reconciles; missing callbacks resolved by status query; unknown references → exception queue.
- [ ] Collection postings balance; product webhooks durable.
- [ ] **PesaPal: order submission works; redirect cannot mark success; IPN + status query idempotent; duplicate events cannot duplicate credit; merchant eligibility enforced; checkout expiry enforced; payment limits enforced.**

### 29.5 Payouts and Refunds (Scope §115.5)

- [ ] Idempotency, UNKNOWN discipline, no-blind-failover proven under concurrency and chaos.
- [ ] Maker-checker DB-enforced; beneficiary changes invalidate approvals.
- [ ] Refund totals can never exceed refundable balance (parallel-load proof); **refund funding party known per route; refund-after-settlement paths (reserve draw / negative balance) proven**.
- [ ] Bulk batches preserve item status; limits enforced; payout postings balance.

### 29.6 Merchant Finance (Scope §115.6)

- [ ] Pilot merchants approved; provider merchant IDs mapped; KYB + compliance current; destinations verified + independently approved; terms/policy versions recorded; offboarding proven.
- [ ] Every launch purpose has a beneficiary; every route a funds-flow model; `citrus_paybill_merchant_funds_enabled` false; split settlement false unless contractually proven; policies versioned; **allocation balances at DB level**; custody classification approved.
- [ ] Expected settlements created; destination versions pinned; provider settlements reconciled; partial/returned handled; SLA alerts work; statements produced; positions balance.
- [ ] Refund funding, reserves, negative balances, chargeback deadlines and financial impact all handled and balanced; products receive required updates.

### 29.7 Ledger and Reconciliation (Scope §115.7)

- [ ] Ledger balances by currency; entries immutable (runtime trigger proof); posting idempotent; all sixteen templates tested; **merchant money never posts to Citrus revenue incorrectly**.
- [ ] All reconciliation layers operational for every launch route, incl. three-way (and four-way where applicable); variances raise exceptions; resolutions audited; month-end pack + daily close producible.
- [ ] Per launch route: transaction, fee, commission, merchant-net, destination, settlement-date, statement, ledger, and product-reference matches; no unresolved duplicates.

### 29.8 Provider and Contract (Scope §115.8)

- [ ] PesaPal contract signed; capabilities documented; merchant model + settlement model confirmed; fee/reserve/refund/chargeback/negative-balance responsibilities confirmed.
- [ ] Production credentials stored; IPN registered + verified per environment with correct account association; support/escalation contacts loaded.

### 29.9 Security, Compliance, and Platform Quality (Scope §115.9)

- [ ] External security review complete; criticals/highs closed or formally accepted.
- [ ] Legal, tax, and funds-flow assessments recorded; PCI responsibility matrix complete.
- [ ] Secrets in manager only; logs redact secrets/KYB/bank/destination data; masking works; **destination-change attack scenario tested**; legal hold works; backups restore-tested.
- [ ] Responsive 375–1440px clean; both themes AA; axe clean on core screens; keyboard + SR walkthroughs recorded.
- [ ] APIs validated/authorized/rate-limited/paginated; stable error envelope; queues + Horizon monitored; failed financial jobs alert.
- [ ] Deploy + rollback rehearsed; DR exercised; monitoring + alerting live.

### 29.10 Operations and Canary (Scope §115.10–§115.11)

- [ ] Daily close completed for launch routes; case workflow, outage modes, kill switches, pilot allowlists, and caps all tested; on-call staffing assigned; all 35 runbooks approved.
- [ ] **Production canaries: one merchant-to-Citrus payment and one customer-to-merchant payment succeed and reconcile end to end — merchant settlement at the verified destination, statement reflects the transaction, commission and fee treatment correct, ledger balanced, webhooks delivered, no manual DB correction.**

---

## 30. Risk Register with Mitigation Steps

| ID | Risk (basis: Scope §118) | L | Impact | Mitigation steps | Owner phase | Trigger/monitor |
|---|---|---|---|---|---|---|
| R-01 | Provider production onboarding slower than development (55–75%) | H | Launch delay | Onboarding starts at Phase 12/12A; per-route checklists decouple software-done from route-live | 12→27 | Weekly onboarding status |
| R-02 | Bank APIs unavailable (35–60%/bank) | H | Payout route gaps | Manual bank-file adapter first; wallet/B2C funding models; explicit mapping | 23 | Bank engagement log |
| R-03 | Duplicate payout (<2% with controls) | M | Direct loss | Idempotency + uniqueness + UNKNOWN discipline + reconcile-before-retry; chaos proof | 19, 26 | UNKNOWN-age metric |
| R-04 | Record divergence (60–85% w/o automation) | H | Unreconcilable books | Multi-source recon from M1; snapshots; exception ownership; close controls | 15–16B | Exception aging |
| R-05 | Shared-PayBill misrouting (15–35%) | M | Wrong-product crediting | Central callbacks; structured references; unknown→exception | 14 | Unmatched-reference rate |
| R-06 | Insider misuse | M | Fraud loss | Least privilege; maker-checker; step-up; versioning; audit; alerts | 7, 9, 18 | Security-event review |
| R-07 | Regulatory classification | ? | Legal exposure | W-A18 gates; no stored value; documented flows | 27 | Legal milestone |
| R-08 | Single-developer maturity gap (65–80%) | H | Shipped-but-unsafe | Milestone ordering; external review; evidence gates; ops first-class | all | Phase-exit audits |
| R-09 | Gate W contract drift vs Servana | M | Integration rework | Contract tests from Servana's published expectations; frozen OpenAPI hash; joint smoke | 17 | Contract-test CI |
| R-10 | Unsigned callbacks spoofed (Daraja/PesaPal) | M | Fake credits | Corroboration model; secret paths; IP allowlists; status-query verification | 13–14 | Non-corroborated alerts |
| R-11 | Redis outage | L | Queue stall | DB constraints carry correctness; fault-injection tested | 26 | Redis alerts |
| R-12 | Audit chain contention | L | Insert latency | Measure first; ADR-gated per-day segments | 9, 25 | p95 audit latency |
| R-13 | `incoming_webhooks` growth | M | Query degradation | Pre-declared partitioning; BRIN; archival | 13, 26 | Table-size monitor |
| R-14 | Provider fee variance vs configured (30–60%) | M | Margin leakage | Actual fee capture; variance reconciliation + report | 14D, 16 | `provider_fee_variance_minor` |
| R-15 | Scope creep into excluded capabilities | M | Compliance damage | Section 1.5 refusal list; blocking-ambiguity procedure; review gate | all | PR review |
| R-16 | Wrong economic beneficiary (20–35%) | M | Severe legal/accounting error | Mandatory fields; route constraints; `EconomicOwnershipTest` | 14 | Constraint violations |
| R-17 | Provider lacks platform-merchant support (45–65%) | H | Launch-model failure | Signed capability confirmation; separate-billing default fallback | 12A, 17 | Capability matrix status |
| R-18 | Split settlement unavailable (50–75%) | H | Commission model change | Default separate billing; capability flag false; allocation supports both | 14D | Contract confirmations |
| R-19 | Settlement to wrong merchant (3–8%) | M | Direct loss | Provider merchant isolation; destination pinning; auto-critical exception | 15B, 16 | Wrong-destination exceptions |
| R-20 | Settlement destination fraud (10–20% lifetime) | M | Severe loss | Versioning; cooling-off; maker-checker; out-of-band notification; attack test | 7, 26 | Destination-change alerts |
| R-21 | Merchant funds misclassified as Citrus revenue (25–45%) | H | Financial-statement/tax error | Posting templates + `MerchantMoneyNeverCitrusRevenueTest` + accounting sign-off | 15 | Posting-template tests |
| R-22 | Refund after settlement unfunded (20–40%) | M | Liquidity loss | Funding-party policy; reserves; negative balances | 20 | Negative-balance metric |
| R-23 | Chargeback process missed (15–30% card launch) | M | Avoidable loss | Chargeback domain + deadline alerts; cards conditional | 20A | Deadline-breach metric |
| R-24 | KYB expiry silent (10–25%) | M | Provider suspension | Expiry scans; route pause | 8, 20.2 | Expiry alerts |
| R-25 | Contract expiry with active route (5–15%) | M | Unauthorised processing | Effective-date DB gates; expiry alerts | 7, 12 | Contract-expiry alerts |
| R-26 | Shared PayBill commingling (40–70%) | H | Custody/tax exposure | Facility segregation; reference classes; segregation report | 6, 14 | PayBill segregation report |
| R-27 | Merchant negative balances accumulate (25–50%) | M | Credit loss | Position dashboard; limits; reserves; suspension | 20 | Negative-balance metric |
| R-28 | Settlement report unavailable (20–40%) | M | Incomplete reconciliation | Contract requirement; statement import; manual evidence fallback | 16 | Missing-report alerts |
| R-29 | Support unable to resolve disputes (30–50%) | M | Trust damage | Case management + evidence bundle | 20A | Case SLA metrics |
| R-30 | Pilot expands too quickly (35–55%) | M | Operational overload | Cohort stages; caps; recorded thresholds | 24, 27 | Pilot-limit utilization |
| R-31 | Provider outage duplicate attempt (5–15%) | L | Duplicate charge | UNKNOWN discipline; no blind failover; outage modes | 12, 19 | Breaker/mode alerts |
| R-32 | Incorrect tax/withholding (20–40%) | M | Tax liability | Versioned tax policies; professional sign-off gate | 14D, 27 | Tax sign-off status |
| R-33 | Offboarding leaves open obligations (20–35%) | M | Unclaimed/disputed funds | Closure-blocking workflow | 8 | `CLOSURE_BLOCKED` count |
| R-34 | Staff authority concentration (25–45%) | M | Control failure | Named roles; segregation; break-glass | 27 | Staffing checklist |
| R-35 | IPN storm / retry storm degradation | M | Ack SLO breach | High-ceiling throttles; replay dedupe; load-tested | 26 | Ack-latency SLO |

Percentages are planning estimates, not measured production rates.

---

## 31. Final Verification Checklist (executed at Phase 27; every line requires linked evidence)

**Identity/auth:** □ no password column □ all §114.1 scenarios demonstrated □ step-up on all sensitive actions (incl. destination/policy/reserve/hold/close/launch controls) □ session controls □ delegated revalidation.
**Isolation:** □ full suite green (incl. provider-merchant, statement, offset rows) □ composite env FKs □ 404 posture □ unscoped-job guard □ export scope.
**Authorization:** □ matrix parity □ policy coverage □ maker-checker DB proof □ all nine segregation rules proven □ permission changes audited.
**API:** □ OpenAPI parity □ pagination everywhere □ idempotency coverage □ stable error codes (incl. merchant-finance codes) □ rate limits □ no internal-ID leaks.
**Collections:** □ C2B budget met □ duplicate confirmation/IPN single-credit □ receipt + order-tracking uniqueness □ unknown-reference exception path □ under/over/late policies □ STK cooldown + terminal block □ checkout sessions single-use + expiring □ redirect cannot mark success.
**Economic ownership:** □ purpose mandatory + immutable □ beneficiary constraints DB-proven □ funds-flow models gated (`CITRUS_COLLECTION_MERCHANT_PAYOUT` disabled; split-settlement flag false) □ reference classes issued □ PayBill segregation report clean.
**Allocation:** □ DB balance proof □ immutability after submission □ deterministic rounding □ policy-version pinning (history never recalculated) □ separate-billing receivable flow.
**Merchant finance:** □ onboarding states walked □ KYB/compliance current + expiry pause □ destination versioning/cooling-off/out-of-band/maker-checker □ destination pinning □ settlement lifecycle incl. partial/returned/held □ net invariant DB proof □ SLA alerts □ statements reproducible + line-total proof □ positions component-complete □ reserves cannot over-release □ negative balances isolated + recoverable □ offboarding closure block.
**Payouts/refunds:** □ UNKNOWN chaos-proof □ no-blind-failover index □ over-refund impossible under parallel load □ funding party resolved □ refund-after-settlement proven □ beneficiary reapproval □ batch partial-success integrity.
**Chargebacks/cases:** □ deadline alerts escalate □ amount cap DB-proven □ loss postings balanced □ duplicate events idempotent □ case SLAs + reopen audit □ communications log immutable.
**Ledger:** □ trial balance zero by currency □ immutability at runtime □ posting idempotency □ atomicity fault-injection □ all sixteen templates tested □ merchant-money-never-revenue proof.
**Reconciliation/close:** □ all §76.3 detection types synthesized □ three-way + four-way proven □ fee/commission/merchant-net/destination/statement matches per launch route □ statement quarantine/dedupe □ resolution approval + compensating entries □ daily close prepare/approve/segregation □ period close blocked by material exceptions □ reopen edits nothing.
**Webhooks:** □ persist-raw-first □ replay ignored □ signing vectors externally verified □ retries/dead-letter/pause/replay □ outbox atomicity □ merchant-finance events exposed per catalogue only.
**PesaPal:** □ auth + rotation □ IPN registered per environment with correct account □ order submission □ status query authoritative □ refunds to original instrument □ cancelled orders never succeed □ fee capture + variance recon □ settlement reports reconcile □ capability matrix evidence-backed □ production onboarding evidence □ outage modes tested.
**UI:** □ responsive sweep □ both themes AA □ axe clean □ keyboard + SR recorded □ env banners □ UNKNOWN distinct □ confirmation restatement □ position screen never one balance □ allocation breakdown balances visibly.
**Security:** □ threat-model rows verified (incl. destination-fraud attack test) □ DAST clean/accepted □ scans clean □ secrets in manager □ redaction green (incl. KYB/destination) □ external review closed □ break-glass constraints proven □ legal hold works.
**Ops/launch:** □ CI green □ deploy + rollback rehearsed (financial containment drill) □ restore exercise □ all 35 runbooks approved □ alerts live □ health gating □ Horizon monitored □ staffing assigned □ SLAs dashboarded □ kill switches + operating modes + flags tested □ pilot allowlist + caps tested □ route-activation checklists complete □ legal + tax + funds-flow sign-offs filed □ Gate W production re-verification □ Gate W-M closed □ **both production canaries reconciled end to end** □ daily close green on launch routes □ no material unresolved exception.

---

## 32. Traceability and Definition of Done

**Traceability.** `docs/traceability/matrix.csv` maps every material Scope requirement → plan section → module → migration(s) → service(s) → route(s) → permission(s) → screen(s) → test(s) → phase → evidence artifact → launch gate, including dedicated rows for: economic purpose; economic beneficiary; funds-flow model; provider merchant account; merchant settlement destination; PesaPal adapter; PesaPal IPN; checkout session; allocation; commission; fees; taxes; reserves; negative balances; merchant settlement; merchant statement; chargeback; case management; daily close; provider contract; pilot rollout; kill switches. `TraceabilityCoverageTest` (CI) fails when a registered requirement row lacks a test or evidence link at its owning phase's exit.

**Definition of done (any unit of work).** The requirement is named; the gap was proven; the smallest correct change is implemented with its tests (positive, denial, edge, concurrency where financial); suites are green in clean containers; static analysis and security scans pass; evidence (command output + capture) is filed; traceability, progress, and changelog rows are updated; residual risk is recorded. **Definition of done (the platform):** every line of Section 31 is green with linked evidence, both external gates are closed, the pilot stages have advanced on recorded thresholds, and the Scope §121.2 thirty-question standard is answerable with immutable evidence for every production transaction.

---

*End of `Wallet_by_Citrus_Software_Development_Plan.md` (v2.0). This plan is executable from Phase 0 with no prior code. The first production-critical target is Milestone M1 (Phases 0–17): the Servana Collections Slice opening External Gate W, immediately followed by the Servana Merchant Funds-Flow Gate (W-M) built on the same phases' merchant-finance deliverables, then payouts and refunds (M2), chargebacks and cases (20A), bulk/multi-bank (M3), and production readiness with the staged pilot rollout (M4). No phase may be reported complete without its evidence artifacts; no production route may be activated before its per-route checklist, the Section 31 verification, and — for merchant funds-flow routes — the approved provider money-flow assessment are satisfied.*

