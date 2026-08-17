# Citrus Platform — Complete Project Scope and Product Technical Specification

---

## 1. Document Control

| Attribute | Value |
|---|---|
| Document title | Citrus Platform — Complete Project Scope and Product Technical Specification |
| Product | Citrus Platform |
| Product owner | Citrus Labs Limited |
| Document type | Project Scope and Product Technical Specification (not a Software Development Plan) |
| Version | 1.0 |
| Date | 7 July 2026 |
| Status | Draft for product approval |
| Format authority | Product Technical Details v.2 |
| Normative language | RFC-style: **shall**, **must**, **shall not**, **must not** are mandatory; **should** and **may** are recommendations or options requiring explicit product decision |
| Currency baseline | KES (launch); monetary amounts stored in integer minor units |
| Time baseline | Stored UTC; business dates presented in Africa/Nairobi (EAT) |
| Launch jurisdiction | Kenya |

### 1.1 Change discipline

1. This document supersedes all prior Citrus Platform overview and scope statements where a conflict exists, according to the source hierarchy in Section 3.
2. Amendments shall be version-controlled. Superseded requirements shall be removed or explicitly marked superseded, never left in parallel with their replacements.
3. Unresolved commercial, legal, or threshold decisions are held in the Product Decision Register (Section 44) and shall not be silently inferred by any downstream document.

---

## 2. Document Purpose

This document defines the complete, standalone, internally consistent, production-grade project scope for the **Citrus Platform**: what Citrus is, why it exists, the problems it solves, who uses it, what every account type can and cannot do, what capabilities it must provide, how its modules, roles, workflows, integrations, business rules, and state transitions must behave, what Citrus explicitly does not do, and what is required for Citrus to be secure, compliant, operationally complete, production-deployable, and usable immediately after launch.

It is written to be sufficient, without reading any source file, for:

- Product approval.
- Architecture review.
- Security review.
- Compliance review.
- UX design.
- QA planning.
- Integration contracting with Wallet by Citrus and Citrus Refer & Earn.
- Later conversion into a separate Software Development Plan.

This document intentionally contains **no** implementation sequence, sprint plan, engineering work breakdown, repository plan, file-level instructions, code, or delivery phases. Technical requirements appear only where needed to define product behavior, interoperability, security, data ownership, availability, auditability, and acceptance conditions.

---

## 3. Authority, Source Hierarchy, and Supersessions

### 3.1 Source inventory

Every file in the governed source directory was reviewed. The inventory below records each file's role. Files marked *non-governing* are excluded from requirements with the reason stated.

| ID | File | Purpose | Governs | Classification |
|---|---|---|---|---|
| S1 | Citrus Platform — Overview.txt | Consolidated platform overview (MVP Lite) | Product definition, tenant/branch/role model | Normative for product identity; **partially superseded** (service fees, direct payment validation, OTP login, lock/delete enforcement, marketing percentages) |
| S2 | Citrus Platform — Project Scope.docx | Earlier project scope draft | Platform overview, system users, service fee model, security, domains | Normative baseline; **partially superseded** (same items as S1) |
| S3 | Citrus Account Roles & Web Pages.txt | Detailed account/role and page-level specification for all 11 account types | Role purposes, pages, capabilities, restrictions, loyalty, storefront, cashier, CX, Growth, Audit, Branch | **Primary internal product authority** for role behavior; superseded on authentication method, transaction-fee billing, and direct provider validation |
| S4 | Citrus platform - Super Administrator account.txt | Super Administrator account specification | Platform governance surface, merchant oversight, magic-link authentication, audit | Normative for Super Administrator; superseded on transaction-fee configuration and manual merchant creation |
| S5 | Merchant Administrator Account Web Pages.docx | Merchant Administrator pages | Merchant governance surface | Normative; superseded on OTP login, service-fee payment mechanics |
| S6 | Merchant - Human Resource Account Web Pages.docx | HR account pages | Staff lifecycle, attendance, leave, KPIs, payroll preparation, access controls | Normative |
| S7 | Merchant - Finance Account Web Pages.docx | Finance account pages | Financial records, reconciliation, expenses, billing visibility, reports | Normative; superseded on automated M-PESA/PesaLink matching of merchant-customer payments |
| S8 | Merchant - Cashier Account Web Pages.docx | Cashier account pages | POS, online orders, payments recording, end-shift | Normative; superseded on STK/provider verification; contains a known copy-paste defect in its introduction (describes inventory duties) which is disregarded |
| S9 | Merchant - Inventory Management Account Web Pages.docx | Inventory account pages | Products, stock movement, suppliers, categories, reports | Normative |
| S10 | Merchant - Audit Account Web Pages.docx | Audit account pages | Read-only oversight, immutability, exports, compliance | Normative |
| S11 | Customer Account Features and Functionalities.JPG | Screenshot enumerating End-User feature areas | End-User surface: Account Security, Checkout, Dashboard, Deliveries, Find Merchants, Invoices and Receipts, Landing Page, My Cart, My Profile, Notifications, Orders, Shop | Normative for End-User module list |
| S12 | Wallet_by_Citrus_Platform_Project_Scope.md | Wallet by Citrus platform scope | **Controlling authority for payment orchestration and the subscription-payment integration boundary** | Normative (integration) |
| S13 | Wallet_by_Citrus_Software_Development_Plan.md (v1.0) | Wallet engineering plan | Additive integration contract detail (headers, event types, states) | Explanatory/additive to S12 |
| S14 | Refer_and_Earn_Project_Scope.md | Citrus Refer & Earn platform scope | **Controlling authority for referral attribution, qualification, rewards, payouts** | Normative (integration) |
| S15 | Citrus_Refer_and_Earn_Production_Software_Development_Plan.md | Refer & Earn engineering plan | Additive integration contract detail (transport event names, endpoints, jobs) | Explanatory/additive to S14 |
| S16 | Servana Software Development Plan.md (v4) | Servana product plan | **Reference only** for the proven product↔Wallet and product↔Refer & Earn integration patterns | Reference; Servana business modules, thresholds, roles, table names, routes, phases, and technology decisions are **not** imported |
| S17 | Product Technical Details v.2..txt | Product technical baseline and format authority | Structure, terminology, formatting discipline, responsive/theme/accessibility/security baselines | Normative (format and technical baseline) |
| S18 | AI Vibe Coding Manifesto.txt | Agent working methodology | None | **Non-governing**: describes AI-agent debugging discipline, not Citrus product behavior |

### 3.2 Precedence order

Where two requirements conflict, the following precedence applies, highest first:

1. **Settled rules** fixed by the approving authority for this scope (Section 3.3).
2. **S12/S13** for Wallet by Citrus and payment-orchestration boundaries.
3. **S14/S15** for referral, attribution, qualification, reward, and payout boundaries.
4. **S3–S11** (detailed account files) for Citrus product behavior, with the more detailed account file prevailing over the general overview.
5. **S1/S2** (general overviews).
6. **S17** for format, technical baseline, and completeness expectations.
7. **S16** only as an integration-pattern reference.

### 3.3 Settled rules (binding; supersede any contradictory source statement)

| # | Settled rule |
|---|---|
| SR-1 | Citrus shall not process End User-to-Merchant payments. |
| SR-2 | Merchant-customer payments are completed outside Citrus and are only recorded, referenced, validated, reconciled, and audited in Citrus as off-platform payment events. |
| SR-3 | The only money movement initiated for the Citrus product itself is Merchant-to-Citrus subscription payment through Wallet by Citrus. |
| SR-4 | Citrus launch monetization is subscription-based. Transaction-percentage service fees, per-sale platform charges, and direct merchant-customer payment processing are not launch requirements. |
| SR-5 | Wallet by Citrus owns subscription payment orchestration and provider-facing money-movement truth. |
| SR-6 | Citrus owns its subscription plans, entitlements, invoices, billing lifecycle, and the business decision to grant, restrict, suspend, or restore Citrus access. |
| SR-7 | Citrus Refer & Earn owns referral attribution, campaigns, rewards, reward ledgers, payout processing, and Referrer-facing records. |
| SR-8 | Citrus owns Citrus-specific merchant registration, merchant status, subscription facts, and merchant active-use qualification decisions supplied to Citrus Refer & Earn. |
| SR-9 | Merchant Branch Account requirements are included even where existing account files omit or incompletely define that account. |
| SR-10 | Citrus must be production-launch-ready, not an MVP prototype, mock-up, proof of concept, or partially operable system. |
| SR-11 | All Merchant account users shall log in using secure, single-use magic links sent to their verified email address. Password login shall not be the default merchant authentication method. |
| SR-12 | Every human user shall have an individual named identity. Shared usernames, shared inbox credentials, or shared magic links shall not be the normal operating model. |
| SR-13 | Unsupported marketing percentages and outcome claims in source files are not binding product requirements. |

### 3.4 Supersession summary

The full Contradiction and Supersession Register is Section 45. The load-bearing supersessions are:

1. **Monetization.** S1/S2/S3/S4/S5/S7 describe an automatic 10% (or fixed) per-transaction service fee, weekly auto-generated invoices, customer-price uplift, module lock cascades on overdue fees, and account deletion after six months of non-remittance. All of this is superseded by SR-3/SR-4: launch monetization is merchant subscription billing via Wallet by Citrus, with the billing lifecycle in Section 20.
2. **Merchant-customer payments.** S1/S2/S3/S7/S8 describe M-PESA STK Push initiation, PesaLink verification, and automated matching against provider settlement feeds for merchant sales. Superseded by SR-1/SR-2: merchant-customer payments are off-platform; Citrus records declared payment evidence and Finance validates it (Section 19).
3. **Authentication.** S1/S2/S3/S5–S10 describe OTP login (and, for the Merchant Administrator in S3, a password plus OTP/MFA). Superseded by SR-11: all merchant users authenticate by magic link. S4 already specifies magic-link login for the Super Administrator and is retained. End-User authentication remains OTP-based per S3/S11 (Section 13.4).
4. **Merchant creation.** S4 includes a Super Administrator "Add New Merchant (manual, internal only)" action. Superseded: merchants are created only through merchant self-registration, subject to platform approval where required (Sections 7.1, 14).
5. **Branch account nature.** S1/S2 imply a "Branch Account" surface (`branch.citrus.ke`) without defining the holder; S3 defines it as a named governance user created by the Merchant Administrator. Resolved per SR-9/SR-12: the branch is a merchant-owned business unit; the Merchant Branch role is held by one or more named humans; the Merchant Administrator owns branch lifecycle; HR provisions branch-scoped memberships (Sections 7.3, 11).
6. **Marketing figures.** All "85–90% misuse reduction", "<1% leakage probability", "~90–93% execution success" style figures are excluded as unverified (SR-13).

---

## 4. Product Definition

**Citrus** is a governed, multi-tenant, branch-aware SaaS commerce operating platform for retail and service merchants operating across physical and digital channels, owned and operated by **Citrus Labs Limited**.

Citrus **is**:

- A multi-tenant SaaS product: every merchant is a fully isolated tenant.
- A commerce execution and governance system: sales, orders, inventory, customers, loyalty, staff activity, and financial records are executed and recorded inside one governed environment.
- Branch-aware: operations, stock, staff, sales, and reports are attributable to branches.
- Role-governed: every capability is bound to an explicit role, scope, and permission; separation of duties is structural.
- Audit-focused: material actions are immutable, timestamped, actor-attributed, and audit-linked.
- Subscription-funded: merchants pay Citrus a recurring subscription, collected exclusively through Wallet by Citrus.
- Integrated: with **Wallet by Citrus** for merchant subscription payments only, and with **Citrus Refer & Earn** as a source product for merchant referral attribution and qualification.

Citrus **is not**:

- A cross-merchant marketplace. End Users discover and interact with individual merchant storefronts; Citrus does not aggregate, rank, or intermediate cross-merchant selling.
- A bank.
- A payment processor. Citrus never moves, collects, settles, custodies, disburses, reverses, or refunds End User-to-Merchant money.
- A public Wallet by Citrus interface. No merchant or End User logs into Wallet.
- A logistics or delivery-fleet management platform. Citrus records merchant-managed fulfilment status only.
- A general-purpose ERP.
- A full statutory accounting system. Citrus financial reports are operational records, not statutory accounts.
- A payroll fund-disbursement provider. HR payroll capabilities end at payroll preparation; no salary money moves through Citrus.
- A peer-to-peer wallet or stored-value system.

### 4.1 Authority hierarchy

```text
Citrus Labs Limited
    Citrus Platform
        Merchant Tenant
            Merchant Headquarters / Tenant Governance
            Merchant Branches
                Branch-Scoped Staff Memberships
                Branch-Scoped Operations
            Merchant Customers / General End Users
```

---

## 5. Purpose of the SaaS Web Application

Citrus exists to give merchants **one governed operating environment for commerce execution and recordkeeping**. Its purpose, stated as binding product intent:

1. **Standardize commerce operations.** Citrus shall standardize how a merchant executes and records sales (POS and online), orders, inventory movements, customer relationships, loyalty, staff activity, branch operations, financial records, reporting, and subscription access — under one tenant, one identity model, and one audit trail.
2. **Reduce revenue leakage and ambiguity.** By making transactions immutable, stock movements attributable, payment evidence validated by Finance, discounts authority-bound, and every material action audit-linked, Citrus shall reduce revenue leakage, stock ambiguity, unauthorized activity, role misuse, and fragmented records.
3. **Enforce structural separation of duties.** Governance, execution, finance, growth, customer experience, people operations, and audit are structurally separated roles. No role is omnipotent; the platform enforces separation at the authorization layer, not by procedure alone.
4. **Support merchant-branded customer experiences without becoming a marketplace.** Each merchant operates its own branded storefront; End Users interact with one merchant at a time; Citrus never aggregates cross-merchant commerce.
5. **Provide operational discipline without ERP scope.** Citrus coordinates, validates, synchronizes, and audits commercial activity. It does not replace a full ERP, statutory accounting suite, bank, payment processor, or logistics platform.
6. **Serve SMEs and large merchants with one product.** An owner-operated single-branch shop and a multi-branch merchant group shall both operate on the same platform through progressive configuration, not separate products (Section 9).
7. **Be immediately usable at launch.** Every workflow required for daily merchant operation shall be complete at launch, with no undocumented manual workaround, no administrator database edits, and no fabricated payment states.

### 5.1 Core operating philosophy

Commercial activity must be executed, validated, and recorded inside a governed system. Accordingly:

- Merchant-customer payments are **recorded and validated as evidence, never processed** (SR-1/SR-2).
- Transactions are **immutable**; corrections occur through reversal, void, adjustment, or replacement events.
- Roles are **structurally separated**.
- Subscription access enforcement is **system-level**, driven by authoritative Wallet-confirmed payment events.

---

## 6. Business Problems and Intended Outcomes

### 6.1 Problems Citrus solves

| # | Problem | Present-state consequence | Citrus response |
|---|---|---|---|
| P1 | Fragmented records: sales in notebooks, stock in spreadsheets, customers in phone contacts | No single truth; disputes unresolvable; theft invisible | One tenant-wide, branch-attributed, immutable record of commerce activity |
| P2 | Revenue leakage through unrecorded sales, unauthorized discounts, voided receipts | Owners cannot reconcile takings with stock | Immutable sales, authority-bound discounts, Finance validation of payment evidence, cash-up variance capture |
| P3 | Stock ambiguity: unknown quantities, unexplained shrinkage, silent write-offs | Over/under ordering, hidden loss | Attributable stock movements with reason codes, counts, approvals, and append-only history |
| P4 | Role misuse: one login shared by everyone; cashier edits prices; anyone deletes records | Unaccountable actions; internal fraud | Named individual identities, explicit role scopes, maker-checker on high-risk actions |
| P5 | Branch opacity: owners cannot see per-branch performance or enforce per-branch rules | Weak multi-location control | Branch-aware execution, branch-scoped staff, branch reports with HQ roll-up |
| P6 | No governed digital channel: merchants improvise online selling over chat apps | Lost orders, unverifiable payment claims | Merchant-branded storefront with order lifecycle and off-platform payment evidence capture |
| P7 | Customer relationships not retained: no history, no loyalty, no consent management | No repeat-purchase engine | Merchant-scoped customer profiles, loyalty ledger, consent-governed communications |
| P8 | Staff accountability gaps: attendance, shifts, and performance untracked | Payroll disputes, absenteeism | HR staff lifecycle, attendance/shift records, payroll preparation (no disbursement) |
| P9 | Un-auditable operations | Compliance and dispute risk | Read-only Audit role, immutable event history, exportable audit evidence |
| P10 | Platform monetization by opaque per-sale fees distorts merchant pricing | Merchant mistrust; price inflation | Transparent subscription plans with published entitlements (SR-4) |

### 6.2 Intended outcomes

At launch, a merchant shall be able to: register, onboard, configure branches and staff, load a catalogue, sell in-store and online, record and validate customer payment evidence, manage stock, run loyalty and promotions, view reports, receive and pay Citrus subscription invoices through Wallet by Citrus, and pass an internal audit review — entirely inside Citrus, from day one.

No numeric business-improvement claims (for example "85–90% misuse reduction") are made in this scope; source-file percentages of that kind are recorded as unverified assumptions (SR-13).

---

## 7. Product Principles

| # | Principle | Meaning |
|---|---|---|
| PR-1 | Default deny | No capability exists for a user unless an active membership, role, scope, and permission grant it. |
| PR-2 | Server-enforced authorization | Frontend visibility is a usability aid, never a security boundary. |
| PR-3 | Tenant isolation is absolute | No merchant can access, infer, enumerate, export, alter, or delete another merchant's data — including via URLs, search, counts, exports, notifications, error messages, or timing where practical. |
| PR-4 | Named humans only | Every actor is an individual identity or a registered machine identity. No shared operating credentials. |
| PR-5 | Immutability with corrective events | Financial and operational history is append-only; corrections are new events with reason, actor, and approval. |
| PR-6 | Evidence, not money | Citrus records merchant-customer payment evidence; it never touches the money. |
| PR-7 | One product, progressive configuration | SME simplicity and enterprise controls are configurations of one platform, not two products. |
| PR-8 | Integration by contract | Wallet and Refer & Earn are separate systems reached only through signed, idempotent, versioned, environment-separated machine contracts. Citrus never implements a partner platform's capability internally. |
| PR-9 | Billing is not policing | A subscription payment resolves billing restrictions only; it never clears a fraud, security, legal, compliance, or manual-risk suspension. |
| PR-10 | Launch-complete | Every scoped workflow is fully operable at launch without undocumented manual intervention. |

---

## 8. Platform Boundaries and Non-Goals

### 8.1 What Citrus provides (platform level)

- Merchant-isolated multi-tenant architecture.
- Branch-aware execution for multi-location businesses.
- Strict role-based access control separating governance, execution, finance, growth, customer experience, people operations, and audit.
- A unified commerce record synchronizing POS sales, online orders, inventory updates, loyalty events, and customer records.
- Merchant-branded digital storefronts.
- Off-platform merchant-customer payment recording and Finance validation.
- Subscription plan management, invoicing, and entitlement enforcement, with collection through Wallet by Citrus.
- Source-product integration with Citrus Refer & Earn.
- Reporting, notifications, files/imports/exports, and audit evidence.

### 8.2 What Citrus explicitly excludes

- Direct payment processing of any End User-to-Merchant money (SR-1).
- Custody of merchant or customer funds.
- Payment-provider credentials or raw provider callbacks inside Citrus (Wallet owns these; Section 21).
- Cross-merchant marketplace aggregation, cross-merchant search ranking, or cross-merchant carts.
- Logistics, delivery-fleet, or courier management (merchant-managed fulfilment status only).
- Full double-entry statutory accounting, tax filing, or audit certification.
- Payroll fund disbursement, salary payments, or statutory payroll filings.
- Referrer reward calculation, reward ledgers, or Referrer payouts (Refer & Earn owns these; Section 22).
- Public access to Wallet by Citrus.
- Peer-to-peer value transfer, lending, credit issuance, or cryptocurrency.
- Any capability found only in Servana and not authorized for Citrus.

---

## 9. Merchant Scale and Operating Models

One Citrus product shall serve both SME merchants and large multi-branch merchant groups. There shall be no separate SME and enterprise products.

### 9.1 SME merchant suitability

Citrus shall support an SME that has one branch (or a small number), a small staff, one person performing multiple approved roles, limited product volume, simple stock operations, basic reporting needs, and limited administrative capacity.

Mandatory SME requirements:

1. A merchant shall be operable with exactly **one branch** (created during onboarding) and **one human** (the Merchant Administrator) holding multiple roles.
2. The product shall not require an SME to create unnecessary users, branches, departments, approvals, or enterprise workflows before it can begin operating. Onboarding to first sale shall be achievable with: register → verify → create first branch (guided default) → add first products → sell.
3. Default configurations shall be safe and simple: single stock location per branch, merchant-wide pricing, no multi-level approvals, storefront optional.
4. Where a required control (for example Finance validation of payment evidence) exists but the merchant has assigned no separate Finance user, the control shall be performable by a human who holds the Finance role — including the Merchant Administrator holding Finance as an explicitly assigned role — with the maker-checker constraints of Section 12.4 preserved.

### 9.2 Large-merchant suitability

Citrus shall support a large merchant that has many branches, central and branch-level teams, high product and transaction volumes, multiple stock locations, distinct governance/HR/finance/audit/growth/CX/inventory/front-office responsibilities, multi-level approvals, centralized reporting with branch drill-down, large imports/exports and scheduled reports, delegated administration, and strong separation of duties.

Mandatory large-merchant requirements:

1. Unlimited-by-design branch count, constrained only by plan entitlements (Section 20).
2. Branch-scoped staff memberships, branch-scoped stock locations, branch price overrides within policy, branch storefront availability, and branch-level reporting with headquarters roll-up.
3. Delegated administration: the Merchant Administrator may appoint additional governance-scope users (including additional Merchant Administrators under Section 7.2 lifecycle rules and additional HR users under Section 7.4).
4. Maker-checker workflows for sensitive stock adjustments, financial corrections, refund records, period reopening, loyalty manual adjustments, and promotion approvals.
5. Bulk import/export, scheduled reports, and access recertification cycles.

### 9.3 Role consolidation without role conflation

1. One named human **may** hold several approved roles in a small merchant (for example Administrator + Finance + Inventory).
2. Permissions remain **explicit per role** even when roles are assigned to the same human. Role assignment is recorded per role; audit events record the acting role context.
3. The UI **may** consolidate navigation for a multi-role user (one login, one workspace, role-context switching), but the authorization model **shall not** merge role boundaries: an action allowed to Finance and denied to Inventory remains denied when the user acts in Inventory context.
4. High-risk financial, security, deletion, and approval actions shall preserve maker-checker or step-up controls even for multi-role users. Where a maker-checker pair cannot be satisfied because the merchant has only one human, the specific action shall require step-up re-authentication plus a mandatory reason, and shall be flagged at elevated audit severity as a single-operator override (see Decision Register D-07 for actions that must never be single-operator).
5. Large merchants may assign the same roles to separate people, teams, branches, regions, or headquarters functions.

### 9.4 Configurable complexity

| Tier | Capability class | Examples |
|---|---|---|
| Required at launch (all merchants) | Core commerce and governance | Tenant, first branch, Administrator, catalogue, POS sale, off-platform payment recording, receipts, basic inventory, subscription billing, audit trail, notifications |
| Configurable | Merchant chooses to enable/adjust | Storefront, loyalty program, promotions, guest checkout, negative-stock policy, discount authority limits, supervisor approval thresholds, working-hours access windows, session-report schedules |
| Disable-able for simple merchants | Present but optional | Multi-branch features, multi-stock-location, quotations, CX messaging, Growth module, attendance/shifts, multi-level approvals |
| Progressive (auto-unlocked by structure or plan) | Appear as merchant grows | Branch drill-down reporting, cross-branch transfers, regional roll-ups, delegated administration, access recertification, scheduled exports |

Enabling a capability shall never retroactively invalidate existing records; disabling a capability shall preserve history and only prevent new activity.

---

## 10. Multi-Tenant and Branch Architecture

### 10.1 Layers and owners

| Layer | Owner | Description |
|---|---|---|
| Platform layer | Citrus Labs Limited | Platform operation, Super Administrator governance, plan catalog, platform policy, integrations registry |
| Merchant tenant layer | Merchant (root: Merchant Administrator) | Fully isolated merchant organization: users, branches, catalogue, customers, records |
| Branch layer | Merchant tenant | Tenant-owned business units; operational data scope for sales, stock, staff, storefront availability |
| Membership layer | Merchant tenant (HR-administered) | Named humans bound to tenant + role(s) + scope(s) |
| End-User layer | Citrus platform (identity); merchant (relationship) | Central End-User identity; per-merchant customer relationship records |

### 10.2 Isolation requirements

1. No merchant shall be able to access, infer, enumerate, export, alter, or delete another merchant's data. This applies to: branches (where branch isolation is required), staff memberships, customers, orders, products, inventory, reports, files, notifications, audit records, subscription records, and integration events.
2. Every tenant-owned record shall carry a tenant ownership key; every query touching tenant-owned data shall be tenant-scoped; background jobs, exports, notifications, files, and webhooks shall preserve tenant context (S17 §3).
3. External identifiers shall be non-sequential public-safe identifiers (ULID/UUID class). Sequential internal identifiers shall never be exposed.
4. Cross-tenant non-inference extends to negative channels: 404-style responses for unauthorized resources (no existence disclosure), scope-safe search, count and pagination behavior that does not leak other tenants' volumes, and error messages free of foreign-tenant identifiers.
5. **Branch isolation within a tenant**: branch-scoped roles see only assigned-branch data. Tenant-governance roles (Merchant Administrator; Audit and Finance where merchant-wide scope is assigned) may see multi-branch data per the permission model (Section 12).
6. **End-User isolation**: one central End-User identity may interact with multiple merchants, but each merchant sees only its own relationship with that person (its orders, its loyalty ledger, its consent records). A merchant shall never receive another merchant's customer relationship data merely because the same individual uses Citrus elsewhere (Section 23.1).

### 10.3 Super Administrator boundary

Super Administrator access shall be privileged, purpose-limited, auditable, and incapable of silently becoming a merchant operational user:

1. Super Administrators govern merchant lifecycle, platform plans, platform policy, integration health, and platform audit — they do not sell, adjust stock, edit prices, manage merchant staff attributes, or operate merchant modules.
2. Any Super Administrator read of merchant data shall occur through purpose-limited support/oversight surfaces, be logged with reason, and be visible in the platform audit trail.
3. There shall be no impersonation of merchant users at launch. If a future support-impersonation capability is approved, it shall require explicit merchant-visible consent and elevated audit ("break-glass") controls (Decision Register D-14).

---

## 11. Account and Identity Model

Account names denote **role-based application surfaces**, not shared credentials. Every human user has an individual identity with a verified email address (merchant staff and Super Administrators) or verified email/phone (End Users). One identity may hold memberships in multiple tenants and roles; context is selected after authentication (Section 13.3).

The account types below are the complete launch set. Each defines purpose, capabilities, prohibitions, scope, creation authority, lifecycle, and audit obligations. The role-permission matrix in Section 12 is the enforcement contract.

### 11.1 Super Administrator Account

| Attribute | Requirement |
|---|---|
| Purpose | Platform-governance authority of Citrus Labs Limited: merchant lifecycle oversight, subscription plan and entitlement governance, platform security/compliance/integration/audit authority, support and exception management |
| Ownership and creation | Predefined and owned by Citrus Labs Limited. Eligibility restricted to Citrus Labs corporate staff with `@citruslabs.co.ke` email pre-approved on the "Approval for Citrus" registry. First login imports the HR-verified profile; profile is read-only in Citrus and re-synced from the registry. Additional Super Administrators are provisioned only through the approval registry, never through merchant workflows |
| Authentication | Passwordless magic link to the approved corporate email; link single-use and short-lived; session limits per Section 13.5; step-up re-authentication for high-risk actions |
| Allowed | View platform dashboards and health; approve/reject merchant onboarding where platform approval is required; suspend/reinstate/archive merchant tenants with reason; govern subscription plan catalog, prices, entitlements, and versions; view platform billing summaries and Wallet integration health; view Refer & Earn integration health; platform-wide security actions on staff/End-User identities (lock, force logout, clear device bindings) as regulatory actions; resolve billing-allocation exceptions by **linking Wallet-confirmed payments to invoices** (never manual payment recording); manage platform notices; access platform audit; manage platform configuration (domains, legal documents, notification templates, integration registry) |
| Prohibited | Creating a merchant's first Merchant Administrator through an ordinary merchant-user workflow; manually creating merchants (merchant creation occurs only through self-registration); performing routine merchant sales, stock, HR, customer, or branch operations; editing merchant staff attributes (roles, names, permissions — these belong to Merchant Administrator/HR); recording or fabricating any payment state; deleting or editing audit records; clearing a non-billing suspension via any billing action; accessing Wallet provider credentials or Wallet global treasury data |
| High-risk controls | Merchant suspension/archival, plan price changes, exception-resolution linkage, platform notices, and security lockouts require step-up re-authentication, a mandatory reason, and two-step confirmation; destructive actions require a second Super Administrator approval where available (maker-checker) |
| Audit | Every action logged with actor, target, reason, timestamp, IP, user agent, correlation ID; append-only; failed logins raise security alerts |
| Lifecycle | Active while employment and registry approval persist; revocation in the registry disables login immediately and revokes sessions |

### 11.2 Merchant Administrator Account

| Attribute | Requirement |
|---|---|
| Purpose | Root governance authority of the merchant tenant |
| Creation | Created only through merchant self-registration (Section 14). It is the root account for the merchant tenant. It shall not be created by a branch user, ordinary staff user, or the Super Administrator |
| Allowed | Merchant profile and legal/business details (identity fields locked post-KYC; changes via governed correction workflow); tenant settings (currency, timezone, tax and receipt configuration, policies); subscription and plan management (select plan, upgrade/downgrade, view invoices, initiate Wallet subscription payment); branch lifecycle — create, approve, activate, temporarily close, suspend, reopen, archive branches; initial HR provisioning (creates the first HR user); role and scope governance (role limits, discount authority policy, approval thresholds, email-domain restrictions for staff); headquarters and all-branch reporting; merchant security and policy settings; delegated administration (additional governance users under audited authority); data export and tenant closure requests subject to policy; enterprise controls (maker-checker thresholds, recertification schedules) |
| Prohibited (routine bypass prevention) | Shall not routinely execute POS sales, stock movements, payment-evidence validation, or HR operations **unless the corresponding role is explicitly self-assigned** (permitted for SMEs, Section 9.3) and each action is recorded under that role context; shall not edit or delete audit records; shall not approve their own high-risk actions where maker-checker applies and another eligible approver exists; shall not bypass Citrus platform rules, entitlements, or billing enforcement |
| Additional administrators | May appoint additional Merchant Administrators; each appointment/removal is a high-severity audited event; the tenant shall always retain at least one active Merchant Administrator (removal of the last one is blocked; recovery via Section 39 support workflow) |
| Audit | All governance actions logged at high severity |

### 11.3 Merchant Branch Account

The Merchant Branch Account is mandatory (SR-9). It is **two things**, and the scope keeps them distinct:

1. **The Branch (business unit):** a merchant-owned operational data scope — identity, address, contact, timezone, operating hours, service area, status, stock locations, catalog availability, pricing overrides, storefront availability, staff assignments, order/sale attribution, expenses (where in scope), customer/loyalty activity attribution, reports, audit trail, and operational settings. Branch lifecycle is defined in Section 15.
2. **The Merchant Branch role (governance surface):** a branch-governance application surface assigned to **one or more named human users** with explicit branch permissions. It shall not be a permanently shared human credential (SR-12).

| Attribute | Requirement |
|---|---|
| Purpose | Highest governance authority inside one branch: staff supervision, branch activity and performance oversight, branch operational settings within merchant policy, branch report review, branch audit visibility |
| Creation and provisioning | The **Merchant Administrator** creates or approves the branch business unit and retains branch lifecycle authority. An authorized **HR** user provisions named branch-scoped user memberships and assigns the Merchant Branch role where required. HR shall not create a branch outside the Merchant Administrator's approved branch structure. Where a merchant has no HR user yet, the Merchant Administrator may directly assign the Merchant Branch role |
| Allowed | Branch dashboard; branch profile (view; edit operational details within policy — operating hours, contact, service area); staff supervision (view branch staff, activity, attendance summaries; initiate suspension requests; create branch staff **only when the merchant has no active HR user**, otherwise supervisory-only); branch activity and performance monitoring; read-only branch financial summaries supplied by Finance; read-only branch audit findings; branch status visibility; branch notifications; branch logs |
| Prohibited | Merchant-wide authority; executing POS transactions, inventory changes, payment validation, or customer-facing operations under the Branch role (a human needing those capabilities must hold the corresponding operational role); financial approvals or billing control; creating branches; accessing other branches' data |
| Scope | Exactly one branch per role assignment; a human may hold Branch role assignments for multiple branches (each assignment explicit) |
| Audit | Branch governance actions logged with branch context |

### 11.4 Merchant Human Resource Account

| Attribute | Requirement |
|---|---|
| Purpose | Merchant identity, employment-record, staff-lifecycle, role-assignment, and access-provisioning authority |
| Creation | The initial HR account is created by the Merchant Administrator only. Additional HR users may be created only by the Merchant Administrator or, where the merchant policy explicitly allows, by an existing HR user with the specific delegated permission — every additional HR creation is a high-severity audited event |
| Scope | Tenant-wide people governance by default; merchants may configure branch-scoped HR users for large structures (each HR membership carries explicit scope). This resolves the source ambiguity between "merchant-wide HR" and "branch-scoped HR pages": scope is a per-membership attribute, not a fixed property of the role |
| Allowed | Staff invitation and onboarding (named-user provisioning with verified email); branch assignment within the Administrator-approved branch structure; role assignment within allowed policy (HR may assign: Branch, Finance, Front Office/Cashier, Inventory, Personnel, Growth, CX, Audit); employment and staff profile records (non-financial); activation, suspension, hold, transfer, and offboarding; working-hours access windows, period-of-access expiry, leave-driven automatic account hold; attendance and shift scheduling; leave management; performance/KPI records; payroll **preparation** (inputs, readiness, approve-and-lock payroll records; export to Finance); access review and recertification; audit of identity and permission changes |
| Prohibited | Self-escalation (an HR user cannot raise their own role set or scope); assigning or modifying Merchant Administrator role (HR may update the Administrator's profile photo only); unauthorized cross-branch assignment (assignments only within own HR scope); creating branches; sales, inventory, finance validation, customer messaging, or audit-record changes; payroll fund disbursement, payslip tax filings, bank integrations; deleting staff history |
| Audit | Every identity, role, scope, and access change logged with before/after values |

### 11.5 Merchant Audit Account

| Attribute | Requirement |
|---|---|
| Purpose | Read-only oversight of financial, operational, compliance, and governance activity, with narrowly controlled review metadata |
| Creation | Merchant Administrator or HR only; no self-registration |
| Scope | Merchant-wide or branch-scoped per membership assignment |
| Allowed | Read-only access to authorized operational, inventory, customer (masked), financial-recording, subscription, and security audit evidence; immutable event and change history (hash-chained audit trail with chain-health indication); centralized report library across modules with masked PII; transaction ledger with anomaly/integrity flags; activity logs with severity and session correlation; compliance page (billing compliance state, policy compliance, consent status, role-integrity checks); exportable audit reports and data bundles (PDF/CSV, integrity-hashed, volume-capped) subject to masking and scope; flagged-event review (viewing system-generated flags and recording review annotations that do not alter source records); notifications (read-only) |
| Prohibited | Changing any source operational record; creating, editing, approving, reversing, configuring, or suppressing data; approving or executing transactions merely because the user can audit them; dismissing or deleting notifications; exporting beyond assigned scope; unmasking PII beyond authorized fields |
| Audit | Every audit-account access, export, and page transition is itself logged (auditor activity is auditable) |

### 11.6 Merchant Finance Account

| Attribute | Requirement |
|---|---|
| Purpose | Merchant financial-record governance and reconciliation, respecting the off-platform payment boundary (SR-1/SR-2) |
| Creation | Merchant Administrator or HR |
| Scope | Merchant-wide or branch-scoped per membership assignment (resolving the source ambiguity: scope is per membership; branch-scoped Finance users see branch data only; merchant-wide Finance sees consolidated data) |
| Allowed | Pricing governance where assigned by merchant policy; merchant-customer invoice and receipt oversight; **validation or rejection of recorded off-platform payment evidence** (Section 19); recording oversight of cash, mobile-money, bank-transfer, card-terminal, cheque, voucher, insurance/third-party, credit, and other merchant-defined payment methods — without Citrus processing money; refund and dispute recordkeeping where the actual refund is executed off-platform; cash-up and shift reconciliation review (variance investigation, exception resolution: link evidence to order/invoice, mark adjustment, mark duplicate, escalate to Administrator); expense records (create, categorize; system-generated commission expenses read-only); financial reports (revenue from validated records only, P&L-style operational summaries, branch summaries, discounts impact); period locks where required; **subscription invoice and Wallet payment status visibility** (read-only; Citrus billing records cannot be edited, overridden, or bypassed by Finance); maker-checker separation for high-risk corrections |
| Prohibited | Access to Wallet provider credentials, treasury controls, or unrelated merchant records; editing Citrus subscription rates, invoices, or enforcement states; manually unlocking billing restrictions (restoration is automatic on authoritative settlement); executing sales or inventory actions; self-validating payment evidence the same user recorded (Section 12.4); presenting recorded evidence as externally settled funds |
| Audit | All validations, rejections, adjustments, exceptions, expense entries, and exports logged; finalized financial records immutable |

### 11.7 Merchant Front Office / Cashier Account

The source files define a single execution role named **Cashier**; no separate "Front Office" role exists. The canonical launch name is **Cashier**; "Front Office" is an accepted synonym for the same role surface. All required front-office permissions are preserved in this role.

| Attribute | Requirement |
|---|---|
| Purpose | Branch execution role for authorized customer-facing commerce operations |
| Creation | Merchant Administrator or HR |
| Scope | Strictly one assigned branch per membership; shift-scoped views of own activity |
| Allowed | Customer lookup or creation (minimal fields, within consent policy); cart/order/sale initiation for POS and acceptance workflow for online orders; product and service selection with barcode/QR scan; pre-configured pricing and discounts only — manual discount entry solely within explicitly granted authority limits; **recording merchant-customer payment evidence** (declared method, amount, external reference, timestamp) — never processing money; receipt issuance after applicable validation rules (Section 19.5); returns or cancellation initiation within policy (execution subject to approval rules); customer order status updates (accepted → in-progress → ready → completed for merchant-managed fulfilment); shift/till session handling — open shift context, cash declaration, mandatory End Shift reconciliation with variance notes; own transaction history (read-only, retention-configurable 30–180 days); own notifications and profile |
| Prohibited | Price, product, or inventory administration; overriding failed or flagged payment evidence ("no force confirm"); refund execution (initiation only, where policy allows); voids beyond authority; access to finance summaries, billing, HR, audit, or subscription administration; closing a shift with unverified/unescalated payment evidence, held carts, or pending ready online orders; editing posted transactions; cross-branch access |
| Audit | All sales, evidence records, receipt issuances, status changes, and shift closures logged; shift closure record is immutable and visible to Administrator, Finance, HR, and Audit |

### 11.8 Merchant Inventory Account (Inventory Manager)

| Attribute | Requirement |
|---|---|
| Purpose | Inventory-governance role: product data, stock accuracy, supplier coordination, movement integrity |
| Creation | Merchant Administrator or HR |
| Scope | Branch/stock-location scoped per membership; multi-location assignments explicit |
| Allowed | Product and SKU stock setup subject to catalogue authority (Section 16.5); stock receipt (supplier delivery, returns, corrections) with purchase-receipt references; stock transfer between owned locations (where multi-location enabled); stock adjustment with mandatory reason codes; stock counts and cycle counts; damage, expiry, wastage, shrinkage, and write-off recording; reorder levels and low-stock thresholds; supplier records (non-financial: identity, product association, delivery history, reliability indicators — no bank details, purchase orders, or payment terms at launch); barcode and QR generation/print/scan (system-generated EAN-13 class codes; immutable once used); batch/lot/expiry tracking where required by merchant category (see Decision Register D-05 for launch depth); inventory reports |
| Prohibited | Selling price changes (pricing authority per Section 16.5); sales execution; customer data access; financial approvals; editing or deleting posted movements (corrections via new adjustment events); creating negative stock where policy prohibits |
| Approval requirements | Sensitive adjustments (large quantity, write-offs above threshold, count variances above threshold) require supervisor/maker-checker approval per merchant policy |
| Audit | Every movement immutable and attributable per Section 17.4 |

### 11.9 Merchant Personnel Account

The source account files do not define a standalone "Personnel" login. This scope defines it as a **strict own-scope operational role** so merchants can give ordinary staff a governed surface without granting any operational module.

| Attribute | Requirement |
|---|---|
| Purpose | Own-scope staff self-service and assigned-work surface |
| Creation | HR (or Merchant Administrator) |
| Allowed | Own profile (view; contact changes with verification); own schedule and shift assignments; assigned tasks/orders/service work where the merchant assigns work items; own performance indicators; authorized customer interaction limited to assigned work; limited stock issue/consumption recording where explicitly granted; own notifications; own attendance records (check-in/out) |
| Prohibited | Access to other personnel's sensitive information unless separately authorized; any module of other roles; reports beyond own metrics |
| Audit | Own-scope actions logged |

### 11.10 Merchant Growth Account

| Attribute | Requirement |
|---|---|
| Purpose | Revenue-expansion role: promotions, pricing commercials, quotations, leads, loyalty configuration, growth analytics — isolated from POS execution, payment evidence, and inventory quantities |
| Creation | Merchant Administrator or HR |
| Scope | Branch-scoped per membership; merchant-wide where assigned |
| Allowed | Promotions and campaign setup within policy (approval workflow where configured); coupon/discount proposal and approval workflow per Section 24; product commercials — set selling prices and promotional prices **where the merchant assigns pricing authority to Growth** (Section 16.5), storefront visibility and merchandising, customer-facing content; product/promotion QR and barcode campaign codes with validity windows; customer segments (non-financial attributes; masked PII); loyalty program configuration — earn rules, tiers, promotion-linked boosts, expiry rules (no manual point credits/debits); quotations/proformas — draft → sent → viewed → accepted → declined → expired; accepted quotes become order requests to Cashier/POS (Growth never executes the sale); leads (manual and system-generated from abandoned/cancelled/partial orders, masked PII, append-only notes); commissions — structure configuration and attribution visibility (Earned/Pending/Confirmed) with no payout capability; campaign and funnel analytics; referral-source analytics limited to Citrus-visible aggregates that do not expose Citrus Refer & Earn private data (no Referrer identities, reward amounts, or payout data) |
| Prohibited | Changing financial truth, user permissions, or audit evidence; POS access, payment-evidence recording or validation; inventory quantity, cost price, or supplier changes; manual loyalty point adjustments; payouts or payroll; CRM export of unmasked personal data |
| Audit | All pricing, promotion, loyalty-rule, and commission-policy changes versioned and logged |

### 11.11 Merchant Customer Experience (CX) Account

| Attribute | Requirement |
|---|---|
| Purpose | Customer communication, engagement quality, feedback, and support case handling — without sales execution, pricing, payments, or financial operations |
| Creation | HR or Merchant Administrator (a Branch role holder may provision CX users only where merchant policy delegates this; the delegation is itself audited) |
| Scope | Branch-scoped per membership; optional multi-branch view where Administrator permits |
| Allowed | Customer profiles (CX-safe: masked contact, engagement indicators, communication history, internal notes); customer inquiries and unified inbox (in-app messages and approved channels), templated replies, internal notes, SLA visibility; complaint and case management with escalation workflows; order-status assistance (read order status; no order editing); returns/refund **request initiation** routed to authorized roles; loyalty inquiries (read-only tier/points/expiry; no adjustments); customer feedback and satisfaction records (immutable aggregation; no editing/hiding); segments (system and custom non-financial); scheduled non-transactional communications (announcements, greetings, loyalty reminders) with consent enforcement, frequency safeguards, cost preview, and optional Administrator approval; predefined journey activation/deactivation (no journey authoring at launch); CX analytics (engagement, sentiment, churn-likelihood bands; no revenue or invoices) |
| Prohibited | Payment validation or financial adjustment; pricing, discounts, promo codes, or payment links in communications; manual loyalty changes; unmasked PII beyond authorized fields; deleting feedback; message sending that violates consent or exhausts communication budget controls |
| Audit | Immutable CX activity ledger; campaign traceability; communication cost audit |

Communication channel costs (for example SMS/WhatsApp airtime) are treated at launch as merchant-configured provider accounts or plan entitlements; the superseded "airtime purchase invoice to Citrus" mechanism from S3 is replaced per the Decision Register (D-08).

### 11.12 General End-User Account

| Attribute | Requirement |
|---|---|
| Purpose | Customer-facing account for individuals interacting with merchant storefronts |
| Creation | Self-registration; guest checkout supported where the merchant enables it |
| Identity | One central Citrus End-User identity (email and/or phone, verified) usable across multiple merchant storefronts; per-merchant relationship data isolated (Section 23.1) |
| Feature areas (per S11) | Landing Page; Find Merchants (search by name/category, branch listings, availability; merchants under operational suspension excluded; **no ratings, price comparison, or cross-merchant ranking**); Shop (branch-scoped storefront, catalog, stock-validated add-to-cart, loyalty preview); My Cart (single-merchant, branch-locked; switching merchants clears cart); Checkout (fulfilment selection; **merchant-supplied off-platform payment instructions**; declared payment reference capture; verification per Section 13.4; order creation); Orders (immutable history; status visibility; cancellation requests where merchant policy allows); Invoices and Receipts (view/download PDF; validation status visible); Deliveries (merchant-managed fulfilment status timeline; no live GPS or courier management); Dashboard (active orders, loyalty overview, recent activity, saved merchants); My Profile (identity and contact with verification on change; delivery addresses; communication preferences; privacy controls); Notifications (order, payment-evidence, fulfilment, loyalty, merchant announcements, platform notices; retention 90–180 days); Account Security (verification identifier management, sessions and devices, trusted devices — maximum 3, 90-day trust expiry, account recovery) |
| Prohibited | Access to merchant internal systems; visibility of other customers; administrative functions; multi-merchant carts |
| Audit | Authentication, checkout, profile-change, and consent events logged |

### 11.13 Additional essential accounts

Review of all source files yields **no additional human roles required at launch**. Catalogue Manager, Warehouse Manager, Procurement Officer, Regional Manager, Storefront Manager, Customer Support Supervisor, and Read-only Executive Viewer are covered as follows and shall not be created as separate launch roles (roles are not inflated without operational need):

- Catalogue/pricing responsibilities are split between Inventory (product data) and Growth (commercials) under merchant-assignable pricing authority (Section 16.5).
- Warehouse scope is an Inventory membership bound to a stock location.
- Regional oversight is a Branch role held across multiple branches, or merchant-wide Audit/Finance scope.
- Storefront management is Growth (merchandising) plus Administrator (storefront settings).
- Support supervision is CX with escalation authority.
- Executive read-only viewing is an Audit membership or a report-recipient configuration.

**Machine identities (non-human, mandatory):**

| Identity | Purpose | Constraints |
|---|---|---|
| Citrus→Wallet client (per environment) | Register subscription payments, initiate STK attempts, query payment status, sync merchant billing accounts | OAuth2 client-credentials issued by Wallet's application registry; least-privilege scopes; disjoint per environment; rotation per Section 30 |
| Wallet→Citrus webhook identity | Signed payment event delivery | HMAC verification, replay protection, allowlisted destination |
| Citrus→Refer & Earn event producer (per environment) | Signed source-product event emission | Product Integration Service Account bound to one product, one environment, approved event types |
| Refer & Earn→Citrus reconciliation identity | Signed bounded reconciliation queries | HMAC verification; bounded query classes only |

No merchant-scoped public API credentials are offered at launch (Decision Register D-12).

---

## 12. Complete Role and Permission Model

### 12.1 Permission dimensions

Every permission is evaluated against: allowed action; denied action; tenant scope; branch scope; own-record scope; verbs (read, create, update, approve, reverse, export, delete); required step-up authentication; required maker-checker; delegability; plan entitlement; audit severity.

Mandatory rules:

1. Authorization is server-enforced on every request, form submission, background job, export, and integration action. Frontend checks are usability aids only.
2. Default deny: absence of a grant is denial.
3. No role is implicitly omnipotent. The Merchant Administrator is a governance role, not an automatic bypass of operational separation.
4. Audit is not an execution role.
5. Finance validation authority is distinct from payment-evidence recording authority and shall not be granted solely because a user can record evidence.
6. Users shall not approve their own high-risk actions where maker-checker is required (Section 12.4).
7. Cross-tenant non-inference per Section 10.2 applies to every permission evaluation, including counts, search, exports, and error responses.
8. Permission changes are versioned; sessions carry a permission version and are re-validated on change (Section 13.2).

### 12.2 Role-permission matrix (launch)

Legend: ✔ allowed · ✔* allowed with constraint noted · A approval/maker-checker required · S step-up required · — denied. Scope column: T = tenant-wide, B = assigned branch, O = own records, P = platform.

| Capability | SuperAdmin | MerchAdmin | Branch | HR | Finance | Cashier | Inventory | Personnel | Growth | CX | Audit | End User |
|---|---|---|---|---|---|---|---|---|---|---|---|---|
| Scope | P | T | B | T/B | T/B | B | B | O | B/T | B | T/B | O |
| Approve merchant onboarding | ✔ S | — | — | — | — | — | — | — | — | — | — | — |
| Suspend/reinstate merchant (operational) | ✔ S A | — | — | — | — | — | — | — | — | — | — | — |
| Govern plan catalog and prices | ✔ S | — | — | — | — | — | — | — | — | — | — | — |
| Select/upgrade/downgrade own plan | — | ✔ S | — | — | — | — | — | — | — | — | — | — |
| Initiate subscription payment (via Wallet) | — | ✔ | — | — | ✔* view+pay where delegated | — | — | — | — | — | — | — |
| View Citrus subscription invoices | — | ✔ | — | — | ✔ read-only | — | — | — | — | — | ✔ read-only | — |
| Create/approve branch (business unit) | — | ✔ S | — | — | — | — | — | — | — | — | — | — |
| Suspend/archive branch | — | ✔ S A | — | — | — | — | — | — | — | — | — | — |
| Edit branch operational details | — | ✔ | ✔* within policy | — | — | — | — | — | — | — | — | — |
| Create first HR user | — | ✔ S | — | — | — | — | — | — | — | — | — | — |
| Provision staff memberships | — | ✔ | ✔* only if no HR exists | ✔ | — | — | — | — | — | — | — | — |
| Assign roles/branches | — | ✔ | — | ✔* within policy, not Admin role, not self | — | — | — | — | — | — | — | — |
| Suspend/offboard staff | — | ✔ | ✔* request only | ✔ | — | — | — | — | — | — | — | — |
| Attendance/shifts/leave/KPIs | — | ✔ read | ✔ read (branch) | ✔ | — | ✔* own check-in | — | ✔ own | — | — | ✔ read | — |
| Payroll preparation (no disbursement) | — | ✔ read | — | ✔ A lock | ✔ read export | — | — | ✔ own summary | — | — | ✔ read | — |
| Create/edit products (data) | — | ✔ | — | — | — | — | ✔ | — | — | — | — | — |
| Set standard/promotional selling prices | — | ✔ A per policy | — | — | ✔* where assigned | — | — | — | ✔* where assigned | — | — | — |
| Publish/unpublish to storefront | — | ✔ | — | — | — | — | ✔* availability only | — | ✔ commercial visibility | — | — | — |
| Delete/archive product | — | ✔ S | — | — | — | — | ✔* archive only | — | — | — | — | — |
| Stock receipts/transfers/adjustments | — | ✔* if role held | — | — | — | — | ✔ A on sensitive | ✔* limited issue if granted | — | — | — | — |
| Stock counts and write-offs | — | ✔* if role held | — | — | — | — | ✔ A | — | — | — | — | — |
| Create POS sale/order | — | ✔* if Cashier role held | — | — | — | ✔ | — | ✔* assigned work | — | — | — | ✔ online |
| Apply discount at sale | — | ✔* within authority | — | — | — | ✔* within granted authority | — | — | — | — | — | — |
| Record payment evidence | — | ✔* if role held | — | — | ✔ | ✔ | — | — | — | — | — | ✔* declared reference at checkout |
| Validate/reject payment evidence | — | ✔* if Finance role held, not own records | — | — | ✔* not self-recorded | — | — | — | — | — | — | — |
| Issue receipt | — | ✔* if role held | — | — | ✔ | ✔* post-validation rules | — | — | — | — | — | — |
| Initiate return/cancellation | — | ✔ | — | — | ✔ record | ✔* within policy | — | — | — | ✔* request only | — | ✔ request |
| Approve refund record (off-platform) | — | ✔ A | — | — | ✔ A | — | — | — | — | — | — | — |
| Cash-up/End Shift | — | — | ✔ review | — | ✔ review/exceptions | ✔ own shift | — | — | — | — | ✔ read | — |
| Expenses | — | ✔ | ✔ read branch | — | ✔ | — | — | — | — | — | ✔ read | — |
| Period lock / reopen | — | ✔ S A | — | — | ✔ S A | — | — | — | — | — | — | — |
| Configure promotions/coupons | — | ✔ A per policy | — | — | — | — | — | — | ✔ A per policy | — | — | — |
| Configure loyalty rules | — | ✔ A | — | — | — | — | — | — | ✔ A | — | — | — |
| Manual loyalty adjustment | — | ✔ S A | — | — | — | — | — | — | — | — | — | — |
| Customer profile (merchant-scoped) | — | ✔ | — | — | ✔ masked | ✔ minimal | — | ✔* assigned | ✔ masked | ✔ masked | ✔ masked | ✔ own |
| Send customer communications | — | ✔* policy | — | — | — | ✔* transactional only | — | — | — | ✔ consent-bound | — | — |
| View reports (scope-bound) | ✔ platform | ✔ T | ✔ B | ✔ people | ✔ finance | ✔ own shift | ✔ inventory | ✔ own | ✔ growth | ✔ CX | ✔ all read-only | ✔ own |
| Export data | ✔ S logged | ✔ S logged | ✔* branch | ✔* people | ✔* finance | — (unless merchant-enabled) | ✔* inventory | — | ✔* masked | ✔* anonymized | ✔ full-dataset, hashed | ✔ own docs |
| View audit trail | ✔ platform | ✔ tenant | ✔ branch | ✔ people events | ✔ finance events | ✔ own | ✔ inventory events | ✔ own | ✔ own module | ✔ own module | ✔ tenant | — |
| Modify audit records | — | — | — | — | — | — | — | — | — | — | — | — |
| Machine integration management | ✔ S | — | — | — | — | — | — | — | — | — | — | — |

*Rows marked "if role held" apply the multi-role rule of Section 9.3: the human must hold that operational role explicitly; acting context is recorded.*

### 12.3 Non-delegable permissions

The following shall not be delegated below their listed holder: platform plan governance (Super Administrator); merchant plan selection, branch lifecycle, tenant closure request, first-HR creation, additional-Administrator appointment (Merchant Administrator); payroll approve-and-lock (HR); period lock/reopen approval (Administrator + Finance maker-checker); audit-record integrity (no one).

### 12.4 Maker-checker matrix

| Action | Maker | Checker | Fallback for single-operator SME |
|---|---|---|---|
| Payment-evidence validation | Recorder (Cashier/Finance) | Finance user other than recorder | Step-up + reason + elevated audit flag; validation by the same human as recorder remains prohibited where any second Finance-capable human exists |
| Refund/dispute record approval | Initiator | Administrator or second Finance | Step-up + reason + elevated audit |
| Sensitive stock adjustment/write-off above threshold | Inventory | Second Inventory/Administrator | Step-up + reason + elevated audit |
| Period reopen | Finance | Administrator | Not permitted single-operator (D-07) |
| Manual loyalty adjustment | Administrator/Growth proposer | Administrator (distinct human) | Not permitted single-operator (D-07) |
| Promotion above budget/margin guard | Growth | Administrator | Step-up + reason |
| Merchant data export (full) | Administrator | Step-up always | Step-up always |
| Merchant suspension (platform) | Super Administrator | Second Super Administrator | Not applicable |

### 12.5 Plan-entitled permissions

Capabilities gated by plan entitlements (Section 20.4) are evaluated after role permission and before execution — consistently across UI, API, background operations, imports, exports, and integrations. Entitlement denial returns the deterministic error `PLAN_ENTITLEMENT_DENIED` (Section 38).

---

## 13. Authentication and Session Model

### 13.1 Merchant account login (magic link)

All Merchant account users (Merchant Administrator, Branch, HR, Finance, Cashier, Inventory, Personnel, Growth, CX, Audit) shall log in using a **secure, single-use magic link** sent to their verified email address. Password login shall not be the default merchant authentication method; no merchant passwords exist at launch.

Requirements:

1. **Generic responses.** The login form response shall not reveal whether an email exists ("If an account exists for this address, a sign-in link has been sent").
2. **Token security.** Links shall be cryptographically random, short-lived (validity ≤ 10 minutes; single value fixed at product configuration), and single-use. Tokens shall be stored **hashed at rest**; the plaintext token exists only in the delivered link.
3. **Binding.** Each link is bound to: audience (merchant-staff surface), user identity, tenant (where a tenant context was requested), role context (where applicable), and environment. A link issued for one context shall not authenticate another.
4. **Expiry and replay.** Expired links produce `AUTH_LINK_EXPIRED`; a second use of a consumed link produces `AUTH_LINK_REPLAYED`, terminates any session created by that link's first use if the replay is from a different device/IP, and raises a security event.
5. **Rate limiting.** Link issuance is rate-limited per email, per IP, and per tenant; resend cooldown applies; abuse triggers temporary lockout with a generic message.
6. **Suspicious-login detection.** New device, new geography, or velocity anomalies raise security notifications and may require step-up verification.
7. **Session revocation.** Users can view active sessions and devices and terminate them; Administrators/HR revocation actions (suspension, offboarding, role change) revoke or re-validate sessions promptly (target: within 60 seconds).
8. **Step-up authentication.** High-risk actions (Section 12.2 "S" markers) require fresh re-authentication (new magic link confirmation or, where enabled, a second-channel verification code) within a short validity window.
9. **Forwarded links.** Because a link may be forwarded, session establishment shall record device/IP fingerprint at first use; anomalous first-use context triggers additional verification; links never grant access beyond the bound identity, and the generic-issuance response prevents harvesting.

### 13.2 Active-membership verification

Before issuing or accepting merchant access, Citrus shall verify all of the following; failure of any check denies or downgrades access with the mapped deterministic error (Section 38):

1. The user identity exists.
2. The email is verified.
3. The merchant tenant is active — or is billing-restricted and the requested route is on the recovery allowlist (Section 20.6).
4. The user's merchant membership is active (not suspended, held, expired, or offboarded; working-hours and period-of-access windows respected where configured).
5. The assigned role is active.
6. The assigned branch or headquarters scope is active.
7. The user has not been suspended or offboarded since session issuance.
8. The session's permission version is current; stale versions force re-resolution.

These checks run at login and continuously (middleware-equivalent) on every request.

### 13.3 Membership authority and context selection

1. Merchant Administrator self-registration creates the initial merchant root membership.
2. The Merchant Administrator creates the initial HR authority.
3. Authorized HR users invite or provision ordinary merchant staff, only after the relevant branch and role authority exist.
4. Staff access is limited to explicitly assigned tenant, branch, role, and permission scope. A staff user cannot choose another merchant account or branch during login unless an active membership has been assigned.
5. A user with memberships in several permitted contexts (multiple tenants, branches, or roles) shall select among **only those contexts** after authentication; the selected context binds the session.
6. Removal, suspension, branch transfer, or permission revocation invalidates or re-validates active sessions promptly; a user acting in a transferred-away branch context is returned to context selection.

### 13.4 End-User authentication

End-User authentication is defined separately from merchant staff and follows the source End-User rule set (S3/S11): **passwordless OTP**, with codes delivered to the verified email and/or phone; no passwords. Requirements:

1. OTP for registration, login, checkout finalization, and sensitive profile changes.
2. OTP validity ≤ 5 minutes, single-use, rate-limited, lockout on abuse.
3. Optional trusted devices: maximum 3, trust expiry 90 days; checkout on an invalidated session is blocked.
4. Session and device visibility with self-service termination; login history retained 30–60 days rolling.
5. Guest checkout (where the merchant enables it) requires contact verification sufficient for order and receipt delivery, without account creation.

Merchant staff membership rules (Section 13.2) are not applied to End Users; End-User access is bound to their own records and the storefront surface only.

### 13.5 Session durations

Source-file session values conflicted (5-minute Super Administrator OTP timeout vs 15-minute idle/4-hour magic-link session; 10-minute merchant timeout). Resolved values:

| Surface | Idle timeout | Maximum session | Notes |
|---|---|---|---|
| Super Administrator | 15 minutes | 4 hours (silent refresh within portal) | Per S4 authoritative Get Started specification; single active session per device |
| Merchant privileged (Administrator, HR, Finance, Audit, Branch) | 10 minutes | 8 hours | Step-up required after idle re-entry to high-risk actions |
| Merchant operational (Cashier, Inventory, Personnel, Growth, CX) | 10 minutes with 60-second warning | 12 hours (shift-friendly) | POS lock-screen re-entry via quick re-verification |
| End User | 30 minutes idle | 30 days remembered on trusted device | OTP re-verification at checkout and sensitive changes |

Additional rules: remembered-device policy applies to End Users only (no remembered devices for merchant staff at launch); high-risk actions always require re-authentication regardless of session age; sensitive changes (email change, role change, membership change) invalidate other active sessions of the affected user.

---

## 14. Merchant Registration and Onboarding

### 14.1 Self-registration workflow

Merchant creation occurs **only** through merchant self-registration (no Super Administrator manual creation; supersession Section 3.4 item 4). The workflow:

1. **Start registration** on the merchant registration surface. Optional **referral code** field (prefilled from a signed referral link where present; replaceable before submission; validated server-side; registration never blocks on referral validation — Section 22.3).
2. **Business identity capture.** Kenyan merchants: National ID of the registering owner and Business Registration Number, verified against the KYC/registry provider where available; foreign merchants: passport and country. Verified identity fields are locked post-verification.
3. **Duplicate merchant detection.** Duplicate prevention on business registration number, merchant legal name, phone, and email; duplicates are rejected with the deterministic error `MERCHANT_DUPLICATE` and a support path.
4. **Contact verification.** Email and phone verification both required before account creation completes.
5. **Merchant Administrator creation.** The registrant becomes the tenant's root Merchant Administrator.
6. **Terms, privacy, and policy acceptance.** Scroll-enforced acceptance of Terms of Service, Privacy Policy, and Data Processing terms; acceptance versioned and logged.
7. **Referral snapshot.** Where a referral code was supplied, an immutable local referral snapshot is stored and asynchronous confirmation begins (Section 22.3).

### 14.2 Onboarding checklist

After registration, a guided checklist (skippable items marked):

| Step | Required for activation | Notes |
|---|---|---|
| Business category selection | Yes | Drives sensible defaults (e.g., batch/expiry emphasis for perishables) |
| Currency and timezone configuration | Yes | KES and Africa/Nairobi defaults at launch |
| First branch creation | Yes | Guided default from business address |
| Subscription plan selection (or trial start where offered) | Yes | Section 20 |
| Wallet payment registration for the first subscription invoice | Yes, before first paid period | Section 21 |
| Initial HR provisioning | No (SME may defer) | Required before non-Administrator staff can be provisioned at scale |
| Product/service and inventory setup | No | Required before selling |
| Tax and receipt configuration | No (defaults apply) | Merchant-configured labels/fields |
| Storefront setup | No | Optional channel |

### 14.3 Activation criteria and incomplete onboarding

- The tenant becomes **operationally active** when all required checklist items are complete and, where platform approval is required (Decision Register D-01 governs whether approval is required for all merchants or risk-flagged merchants only), the Super Administrator has approved onboarding.
- Incomplete onboarding: the tenant remains in `onboarding` with full access to setup surfaces; reminder notifications; configurable expiry of abandoned registrations (Decision Register D-02).
- Rejected onboarding (failed KYC, duplicate, policy): tenant enters `rejected` with a stated reason category, retained per retention policy; the registrant is notified with a support path.

### 14.4 Merchant status model

Four independent status dimensions shall be maintained (never conflated):

| Dimension | States |
|---|---|
| Onboarding status | `registration_started` → `identity_verified` → `onboarding` → `active_complete` \| `rejected` \| `abandoned` |
| Operational status | `active` · `suspended` (fraud/security/legal/compliance/manual) · `deactivated` · `archived` · `closed` |
| Billing status | `trialing` · `active` · `overdue` · `read_only_grace` · `suspended_billing` · `cancelled` |
| Compliance/risk status | `clear` · `under_review` · `restricted` |

**A subscription payment shall only resolve billing-related restrictions. It shall never reactivate a merchant suspended for fraud, security, legal, compliance, or manual-risk reasons** (PR-9). Billing recovery changes billing status only.

### 14.5 Closure, export, and retention

- Merchant-initiated closure: Administrator requests closure (step-up, confirmation); tenant enters wind-down (read-only) for a defined period, data export offered, then `closed` with retention per Section 34.
- Platform-initiated archival: Super Administrator action with reason; data retained per retention class; no hard delete of financial/audit records within statutory windows.
- Recovery access for billing-only restrictions: Section 20.6.
- The superseded "automatic deletion after 6 months of non-remittance" rule is replaced by: prolonged `suspended_billing` leads to `cancelled` subscription and eventual archival per the retention schedule — never silent hard deletion of records (Decision Register D-03 sets the dormancy-to-archival period).

---

## 15. Merchant and Branch Lifecycle

### 15.1 Branch lifecycle

| Transition | Trigger | Authorized actor | Preconditions | Side effects | Audit |
|---|---|---|---|---|---|
| Create (draft) | Administrator action | Merchant Administrator | Tenant active; branch entitlement available | Draft branch, no operations | High |
| Approve/Activate | Administrator confirmation | Merchant Administrator | Required branch profile complete (name, address, timezone, operating hours) | Branch operational; assignable to staff; storefront-eligible | High |
| Temporary closure | Administrator/Branch role per policy | Administrator (Branch may request) | No blocking constraint | New sales/orders blocked; existing orders completable; storefront shows closed | Medium |
| Suspend | Administrator | Administrator (step-up) | Reason required | All branch operations blocked except read; staff sessions in branch context invalidated | High |
| Reopen | Administrator | Administrator | Suspension/closure reason resolved | Operations restored | High |
| Archive | Administrator | Administrator (step-up, confirmation) | No open orders; no unresolved payment-evidence records; stock disposition completed (transfer/write-off per policy); not the last active branch unless tenant is closing | Branch read-only historical; removed from active lists and storefront | High |
| Permanent closure | Administrator | Administrator (step-up) | Archive preconditions | As archive, flagged closed | High |
| Transfer/reorganization | Administrator | Administrator | Where allowed: staff and stock reassigned explicitly, history preserved under original branch | Attribution history never rewritten | High |

### 15.2 Merchant-global vs branch-specific

| Merchant-global | Branch-specific |
|---|---|
| Legal identity, tenant settings, currency, plan/subscription, policies, role governance | Branch profile: address, contact, timezone, operating hours, service area, status |
| Master catalogue (products, services, categories, standard prices) | Branch availability, branch price overrides (within policy), branch stock locations and quantities |
| Customer identity and merchant-level customer relationship | Branch attribution of orders, sales, loyalty events, expenses |
| Loyalty program rules | Branch attribution of earn/redeem events |
| Promotion definitions (may be merchant-wide or branch-targeted) | Branch storefront availability and settings |
| Report definitions and HQ roll-ups | Branch dashboards, branch reports, branch audit views |
| Tax/receipt defaults | Branch-level tax/receipt configuration where law or operation requires |

### 15.3 Edge constraints

- Branch closure with open orders: blocked until orders are completed, cancelled, or explicitly transferred (each with audit).
- Branch closure with stock on hand: blocked until stock is transferred, written off, or otherwise dispositioned with approval.
- Archiving the last active branch: blocked unless the tenant itself is closing.
- Branch limit reached (plan entitlement): creation blocked with `PLAN_ENTITLEMENT_DENIED` and an upgrade path.

---

## 16. Catalogue and Pricing

### 16.1 Unified catalogue

One catalogue model supports retail products, services, bundles, variants, add-ons, and merchant-defined categories:

- **Product and service records:** name, description, type (physical product / service), images and media, category assignments, unit of measure, tax classification (merchant-configured), availability windows.
- **SKUs and variants:** each sellable unit is a SKU; variant dimensions (size, color, etc.) as merchant-defined attributes; duplicate SKU codes rejected within the tenant (`SKU_DUPLICATE`).
- **Barcodes and QR codes:** system-generated (EAN-13 class) or merchant-supplied; immutable once used in a posted transaction; scan events logged.
- **Bundles/kits:** composed of component SKUs with defined component quantities; stock behavior per merchant policy (deduct components).
- **Modifiers and add-ons:** attachable options with price deltas, primarily for service and food-service merchants.
- **States:** `draft` → `active` → `archived`; `discontinued` marks end-of-life while preserving history; archived/discontinued items remain resolvable in historical records.
- **Digital-storefront visibility:** independent flags for POS availability and storefront visibility, per branch.
- **Bulk import/export:** templated CSV import with validation, duplicate handling (reject, skip, or update-by-SKU per import option), row-level error reporting; export in CSV.

### 16.2 Pricing

- **Standard price** per SKU (tenant-level).
- **Branch price overrides** where merchant policy permits, bounded by policy (e.g., ± percentage guard).
- **Promotional prices** with mandatory start/end datetimes.
- **Cost data** (purchase cost) with restricted visibility: visible to Administrator, Finance, and Inventory where granted; never visible to Cashier, Growth (unless explicitly granted), CX, or storefront.
- **Effective-dated pricing and price history:** every price change is versioned with actor, timestamp, old/new values, and reason; historical transactions retain the price in force at execution.

### 16.3 Duplicate handling

Duplicate detection on SKU code (hard reject), barcode (hard reject), and product name (soft warning). Imports report duplicates row-by-row.

### 16.4 Catalogue integrity rules

- Renaming a SKU's display name after historical sales never rewrites history (transactions snapshot name and price at sale time).
- Archiving a product with open orders is blocked or requires explicit order resolution.
- Returns of discontinued products remain recordable against the historical record.

### 16.5 Catalogue and pricing authority

Source files split authority (Inventory: product data, pricing read-only; Growth: commercial prices; Administrator: overrides and deletion). Resolved model:

| Action | Default authority | Configurable |
|---|---|---|
| Create/edit product data (identity, attributes, media, categories, barcode) | Inventory | Administrator may also hold |
| Set/change standard price | Administrator | Assignable to Finance or Growth per merchant policy ("pricing authority" setting) |
| Set promotional price/promotions | Growth (within approval policy) | Administrator approval threshold configurable |
| Branch price override | Branch-assigned pricing authority within policy bounds | Administrator-defined bounds |
| Publish to storefront | Growth (commercial visibility) + Inventory (availability) | Administrator override |
| Archive/delete product | Administrator (delete is soft/archival only) | Non-delegable delete |
| Approve price/promotion above guard thresholds | Administrator | Maker-checker per Section 12.4 |

All catalogue and price changes are audit-logged with before/after values.

---

## 17. Inventory

### 17.1 Structure

- **Stock locations:** each branch has at least one stock location; additional locations (e.g., back store, warehouse) where multi-location is enabled.
- **Opening stock:** captured per SKU per location with reason `opening_stock`.
- **Reorder levels:** per SKU per location; low-stock and out-of-stock alerts are non-dismissible until resolved or acknowledged with logging.

### 17.2 Movement types

| Movement | Trigger | Notes |
|---|---|---|
| Stock receipt | Supplier delivery, purchase receipt reference, customer return, correction-in | Supplier deliveries create immutable delivery logs |
| Transfer | Between owned stock locations/branches | Two-sided event (out + in) with in-transit state where needed |
| Reservation | Cart/checkout hard-lock, quote acceptance where configured | Time-bound; auto-release on expiry |
| Commitment | Order confirmation | Converts reservation |
| Sale deduction | POS/online sale completion | Automatic |
| Return | Return acceptance | Restock or write-off disposition |
| Adjustment | Count variance, correction | Mandatory reason code; approval above threshold |
| Count / cycle count | Scheduled or ad hoc | Snapshot + variance postings |
| Damage / Expiry / Wastage / Shrinkage / Write-off | Recorded with reason codes | Approval per policy; feeds shrinkage reporting |

### 17.3 Batch, lot, serial, expiry

Where the merchant category requires it (perishables, pharmaceuticals), batch/lot identifiers and expiry dates shall be supported on receipt and deducted on a FEFO-preferred basis. Source files define expiry only as a stock-out reason; full batch tracking depth at launch is a product decision (Decision Register D-05). At minimum, launch includes: expiry-dated stock-out reasons, batch reference capture on receipt, and expiry alerting.

### 17.4 Movement attribution (mandatory)

Every stock movement shall record: merchant; branch/stock location; actor or system process; business reason (coded); source document or event (sale, order, delivery, count, adjustment); timestamp; and before/after quantity where safe. Posted movements are immutable; corrections are new movements.

### 17.5 Concurrency and overselling (product-level requirements)

1. Stock-affecting operations on the same SKU/location shall be serialized such that two concurrent sales cannot both consume the last unit.
2. Checkout applies an inventory hard-lock (reservation) for the cart's items; expiry releases it.
3. **Negative stock policy** is merchant-configurable: `prohibit` (default — sale blocked with `INSUFFICIENT_STOCK`) or `allow_with_flag` (sale proceeds, negative-stock exception raised for Inventory).
4. Concurrent conflicting updates return `STOCK_CONFLICT` and require retry with fresh state; the system never silently overwrites a concurrent movement.
5. A stock count in progress does not block sales; count variance resolution accounts for movements during the count window.

### 17.6 Suppliers

Supplier master records (identity, contacts, product associations, delivery history, reliability indicators, notes, soft deactivation). No purchase orders, supplier invoices, bank details, or payment terms at launch.

### 17.7 Valuation

Inventory valuation reporting is an **operational estimate** (based on recorded cost data and quantity on hand), explicitly labeled as non-statutory. No authoritative source file states otherwise.

---

## 18. Sales, POS, Orders, and Storefront

### 18.1 POS (in-store) execution

- Sale initiation by Cashier in an open shift context; product search and barcode/QR scan; cart with quantity validation against stock policy.
- Pre-configured pricing and promotions only; manual discounts solely within granted authority (amount/percentage caps per role assignment).
- Customer attachment optional (lookup or minimal creation); loyalty accrual automatic on completion where a customer is attached.
- Payment-evidence capture per Section 19; receipt issuance per Section 19.5 (print, email, or approved message channel).
- Sale states: `draft` → `awaiting_payment_evidence` → `completed`; `cancelled` from pre-completion states; posted sales immutable.
- Offline draft mode: POS may hold local drafts during connectivity loss and synchronize on reconnect; drafts are not completed sales and no receipt is issued offline unless merchant policy explicitly permits provisional receipts flagged as unvalidated.

### 18.2 Orders (online and quote-originated)

- Online order placement from the storefront (Section 18.4) or conversion from an accepted quotation.
- Order states: `pending` → `accepted` → `in_progress` → `ready` → `completed`; `cancelled` and `failed` as terminal exceptions. Payment-evidence state tracks independently (Section 19.4).
- Branch routing: orders route to the branch selected in the storefront; branch queue visible to Cashier.
- Partial fulfilment where applicable: line-level fulfilment status; remaining lines completable or cancellable with audit.
- Cancellation: End User may request; merchant policy governs approval; stock released on cancellation after deduction is reversed by a compensating movement.
- Returns and exchanges: return initiation within policy; disposition (restock/write-off) recorded; refunds are **off-platform** and recorded per Section 19.6; exchanges create linked replacement transactions.
- Void and correction controls: no silent deletion; corrections via reversal, void (pre-completion), adjustment, or replacement events with reason, actor, and approval where required.

### 18.3 Quotes

Growth-created quotations/proformas: `draft` → `sent` → `viewed` → `accepted` → `declined` | `expired`; expiry mandatory; accepted quotes become order requests to the branch POS queue; Growth never executes the sale; no inventory reservation until order confirmation (unless merchant policy enables reservation on acceptance).

### 18.4 Merchant-branded digital storefront

- Merchant-specific storefront URL or tenant-aware route (for example `citrus.ke/{merchant}`), with merchant and branch branding.
- Catalogue browsing, search and filters (merchant-scoped only), product/service detail, availability, cart, order placement.
- Branch selection precedes shopping; cart is single-merchant and branch-locked; switching merchants clears the cart.
- Guest or registered flow (Section 13.4); pickup or merchant-managed fulfilment selection; **offline payment instructions supplied by the merchant** at checkout (e.g., "Pay to our M-PESA Till 123456, enter the reference shown").
- Order status, receipt and invoice access, loyalty display, promotions display, support requests, privacy and consent surfaces.
- No cross-merchant aggregation: Find Merchants supports direct discovery (name/category/branch listing) without ranking, comparison, ratings, or cross-merchant recommendations.
- External delivery handoff: the merchant may record an external courier reference on an order for customer visibility; Citrus does not manage the courier.

### 18.5 Immutability

All financial and operational history (sales, orders, payment-evidence records, receipts, shift closures) is immutable. Corrections occur only through reversal, void, adjustment, or replacement events. Deletion of posted commerce records is prohibited for all roles.

---

## 19. Merchant-Customer Payment Recording Boundary

This section is normative and unambiguous.

### 19.1 Off-platform payment rule

Citrus shall not move, collect, settle, custody, disburse, reverse, or refund End User-to-Merchant money.

Merchant-customer payments occur outside Citrus through methods selected and operated by the merchant, including: cash; merchant M-PESA Till or PayBill; merchant bank transfer; merchant card terminal; cheque; voucher; insurance or third-party settlement; merchant-approved credit; any other merchant-controlled method.

Citrus records and validates **evidence** of those payments for operational and audit purposes only.

### 19.2 Permitted Citrus capabilities

Citrus may:

1. Record declared payment method.
2. Record amount and currency.
3. Record a masked external reference (e.g., M-PESA transaction code, masked at rest and in exports per Section 34).
4. Record date and time of the declared payment.
5. Record the staff member who captured the evidence.
6. Require Finance validation before evidence is treated as validated (thresholds and always-validate rules merchant-configurable).
7. Allocate validated recorded payments to merchant invoices (merchant-customer invoices).
8. Generate merchant receipts after applicable validation rules (Section 19.5).
9. Reconcile merchant-declared records against merchant-supplied statements or cash-up records (statement import is a merchant-supplied file, not a provider integration).
10. Record off-platform refund, reversal, chargeback, or dispute outcomes.
11. Preserve immutable adjustment history.
12. Detect duplicates: an external reference already recorded within the tenant raises `PAYMENT_REFERENCE_DUPLICATE` and blocks a second evidence record without Finance exception handling.

### 19.3 Prohibited Citrus capabilities

Citrus shall not:

1. Hold a merchant's provider credentials for customer collections.
2. Register provider callbacks for merchant-customer transactions.
3. Initiate customer STK prompts for merchant sales.
4. Receive raw merchant payment-provider callbacks as authoritative payment truth.
5. Custody customer funds.
6. Pay out merchant funds.
7. Present an internal record as proof of bank settlement when it has not been externally validated.
8. Automatically claim payment success based only on user input — recorded evidence is always visibly distinct from validated evidence, and validated evidence is always visibly distinct from any externally settled funds claim (which Citrus never makes).

### 19.4 Payment-evidence states

Per order/sale/invoice payment position:

`unpaid` → `partially_recorded` → `fully_recorded`

Per evidence record:

`pending_validation` → `validated` | `rejected`; with subsequent `disputed`, `refunded_off_platform`, `reversed_off_platform`, `written_off` (written off only where authorized, maker-checker per Section 12.4).

A **recorded** payment is a merchant declaration. A **validated** payment is a Finance-confirmed declaration. Neither is a processed or settled payment, and the UI, receipts, reports, and exports shall preserve this distinction in wording.

### 19.5 Receipts

- Receipt issuance rules are merchant-configurable: on recording (marked "payment declared — pending validation") or only after validation. Default: cash receipts on recording with the declaration marking; non-cash receipts after validation.
- Receipts are immutable documents; reissued copies are marked as copies.
- If Finance rejects evidence after a receipt draft was produced, the receipt is voided by a linked corrective document and the order returns to the appropriate payment state; the customer is notified where contactable.

### 19.6 Refunds and disputes (off-platform)

Refunds/reversals happen outside Citrus. Citrus records: refund record (linked to original sale/evidence, amount, off-platform method, reason, approver), disputed status, chargeback outcome where reported by the merchant. Loyalty and inventory effects are compensated by linked events (Section 23.2). Records after a period lock require period-reopen maker-checker (Section 26).

---

## 20. Subscription Plans, Billing, and Entitlements

Launch monetization is **subscription-based** (SR-4). This section supersedes every general-overview statement requiring a percentage or fixed fee on merchant-customer transactions at launch.

### 20.1 Plan catalog (platform-owned)

Super Administrator governs:

- **Plans** with versions (immutable once merchants subscribe; changes create new versions), prices (KES, minor units), billing interval (monthly at launch; annual optional per D-04), and trial rules where applicable.
- **Entitlements** per plan: branch limit, staff-user limit, catalogue-size limit, storage limit, stock-location limit, storefront enablement, report/export tiers, scheduled-report availability, feature flags (Growth module, CX messaging, attendance, quotations, etc.), and usage limits where applicable.
- **Promotions/free periods**: platform-defined discounts on subscription pricing with start/end dates; overlap validation.
- Tax treatment of subscription invoices where applicable (D-06).

Plan prices, trial length, and entitlement values are commercial decisions recorded in the Decision Register (D-04); this scope defines the mechanism, not the numbers.

### 20.2 Subscription lifecycle

`trialing` (where offered) → `active` → `overdue` → `read_only_grace` → `suspended_billing` → `active` (recovery) | `cancelled` → `reactivated` (new subscription) ; `expired` where a fixed-term subscription lapses.

- **Upgrade:** effective immediately with proration or at next renewal (product decision D-04); entitlements expand immediately on effective date.
- **Downgrade / scheduled plan change:** effective at next renewal; over-limit resources become read-only (never deleted) until within limits.
- **Renewal:** invoice issued ahead of period start (lead time configurable).
- **Grace period:** configured days in `overdue` before `read_only_grace`.
- **Billing restriction (`read_only_grace`):** mutations blocked; reads allowed; new exports/reports blocked; recovery allowlist active.
- **Billing suspension (`suspended_billing`):** access limited to the recovery allowlist (view invoices, pay, export own data, contact support).
- **Cancellation:** merchant-initiated; access until period end; then per closure rules.
- **Credit balance:** overpayment creates account credit applied to the next invoice (no cash refund through Citrus; refunds, where approved, execute through Wallet operations).

### 20.3 Subscription invoices

Invoice states: `draft` → `issued` → `pending_payment` → `partially_paid` → `paid`; `issued`/`partially_paid` → `overdue`; `cancelled` (before payment); `reconciliation_required` when confirmed funds cannot be safely applied.

Rules:

1. Invoices carry line items (plan period, proration, promotions, credits, tax where applicable), amount due in minor units, and due date.
2. `pending_payment` → `partially_paid`/`paid` transitions are driven **exclusively** by verified Wallet events or Super Administrator exception-resolution linkage of a Wallet-confirmed payment (Section 21). No manual payment recording exists for subscription invoices — for any role.
3. Failed or delayed payment: escalation per grace configuration; notifications at each stage.

### 20.4 Entitlement enforcement

Plan entitlements are enforced consistently across UI, API, background operations, imports, exports, and integrations. Enforcement runs after permission checks. Denial returns `PLAN_ENTITLEMENT_DENIED` with an upgrade path. Downgrades never destroy data.

### 20.5 Billing vs operational separation

Billing status and operational status are independent state machines (Section 14.4). A validated subscription payment moves `suspended_billing → active` **only when the suspension reason is billing-only**. It never alters operational or compliance/risk status (PR-9).

### 20.6 Recovery allowlist

While billing-restricted or billing-suspended, merchant users can reach: billing pages, invoice viewing, Wallet payment initiation, data export of own tenant (Administrator, step-up), support contact, and read-only operational history. All other mutation routes are blocked with `BILLING_RESTRICTED`.

---

## 21. Wallet by Citrus Integration

Citrus is an integrated product of Wallet by Citrus for **merchant subscription payments only**. The controlling authority for this boundary is the Wallet by Citrus Platform Project Scope (S12).

### 21.1 Ownership boundary

**Citrus owns:** subscription plans and prices; subscription entitlements; merchant billing state; subscription invoices and line items; the amount due to Citrus; eligibility to initiate a subscription payment; applying confirmed Wallet funds to the correct Citrus subscription invoice; billing-only access restoration; Citrus-side billing records and reconciliation projection.

**Wallet by Citrus owns:** payment-provider credentials; provider accounts and routes; STK Push submission where used; PayBill, Till, bank, or other provider integration; structured payment references; raw provider callbacks; provider request identifiers; provider transaction status; collection state; settlement state; provider and bank reconciliation; the financial ledger and money-movement truth; signed product webhooks; duplicate callback protection; refund or reversal execution where separately authorized by Wallet scope.

Controlling rule (S12): *"Wallet owns money-movement truth; each product owns business truth; Wallet never decides whether a product customer is entitled to anything, and products never talk to Safaricom."*

### 21.2 Required integration behavior

1. **Machine identity:** separate Citrus machine identity per environment (sandbox/staging/production), issued through Wallet's application registry; OAuth2 client-credentials; least-privilege scopes (`payments:write`, `payments:read`, `merchant_accounts:write` class); token TTL ≤ 60 minutes; no machine refresh tokens; optional IP allowlisting; secret rotation with overlapping validity; production and sandbox credentials disjoint.
2. **Payment registration:** each payable subscription invoice is registered as a Wallet payment resource (`external_reference` = Citrus invoice identifier; expected amount = current balance in minor units; currency) before any payment instructions or STK attempt are shown. Registration is idempotent (`Idempotency-Key` per invoice); duplicate registration returns the existing resource; the invoice is never re-registered on partial payment.
3. **Structured references:** Wallet issues the immutable structured public payment reference (product-prefixed `{PREFIX}-PAY-<ULID>`; the Citrus prefix is assigned by Wallet's product registry — registration of Citrus as a Wallet product is a launch prerequisite, Decision D-09). Citrus stores and displays this reference in PayBill/Till/bank instructions.
4. **Webhooks:** Citrus consumes signed, replay-protected Wallet webhooks (HMAC-SHA256 canonical-string signature; timestamp tolerance ±300 seconds; nonce; stable event ID across retries; dual-key rotation support). Verification order: transport and content checks, key resolution, timestamp window, replay check, constant-time signature verification — before any payload field is trusted.
5. **Durable processing:** fast acknowledgment after durable inbox persistence; asynchronous application; first-seen event-ID deduplication; duplicate deliveries acknowledged with zero domain effect; out-of-order events never regress terminal states.
6. **Safe application:** funds are applied to the invoice under record-level serialization, keyed on the first-seen confirming event; amount < balance → `partially_paid`; = balance → `paid`; > balance → `paid` plus account credit. The same Wallet payment applied to a second invoice raises a critical `WALLET_PAYMENT_REUSED` exception and never double-credits.
7. **Status-query recovery:** ambiguous outcomes (timeout, missing callback) are resolved by querying Wallet payment status on schedule; a timeout is treated as `UNKNOWN`, never as failure; **no blind retry** of money movement while a prior attempt is unresolved.
8. **Reconciliation:** scheduled reconciliation compares Citrus invoice allocations against Wallet payment status over a rolling window; drift raises allocation exceptions for Super Administrator resolution by linkage (never manual recording).
9. **Audit linkage:** complete linkage between Citrus invoice ↔ Wallet payment ↔ Wallet attempt ↔ webhook event, with correlation identifiers.
10. **Errors:** user-facing errors are generic and safe; internal diagnostics carry Wallet error codes and correlation IDs.

### 21.3 Subscription payment experience (merchant-facing)

1. **View invoice:** amount due, due date, line items, payment state, structured reference once registered.
2. **Register payment resource:** automatic at issuance (with retry); instructions display "pending" until registration succeeds.
3. **Initiate eligible method:** STK Push (enter M-PESA phone; prompt arrives on the phone; cooldown between attempts; duplicate-prompt prevention) or displayed PayBill/Till/bank instructions with the structured reference.
4. **States shown:** pending, successful, failed, expired, reversed, and unknown ("confirming — this can take a few minutes") — mapped 1:1 from Wallet states; Citrus never invents a success state.
5. **Retry rules:** retry available only when the prior attempt is in a terminal failed/expired/cancelled state or Wallet reports it safe; unknown states block new attempts until resolved.
6. **Application outcomes:** partial payment reduces balance and keeps the invoice payable; overpayment creates credit; underpayment keeps `partially_paid`; duplicate payment (same funds confirmed twice) is blocked by event dedup; late payment after invoice cancellation or expiry is recorded by Wallet and routed to the exception queue for allocation or credit — funds are never discarded.
7. **Access restoration:** billing access restores automatically only after authoritative Wallet confirmation reaches `paid` allocation and the suspension reason is billing-only.

### 21.4 Strict exclusions

Citrus shall not: integrate directly with Safaricom, banks, card processors, or other payment providers for subscription collection where Wallet owns that route; store raw provider credentials; treat browser redirects as payment confirmation; mark an invoice paid solely from a user claim or unverified reference; expose Wallet's global treasury or cross-product data to merchant users. The Citrus codebase shall contain no provider SDKs, provider callback routes, or provider credential configuration.

---

## 22. Citrus Refer & Earn Integration

Citrus is a **source product** integrated with the centralized Citrus Refer & Earn platform. The controlling authority is the Refer & Earn Project Scope (S14); the production plan (S15) supplies transport detail.

### 22.1 Ownership boundary

**Citrus owns:** merchant self-registration; referral-code capture during Citrus registration; Citrus merchant tenant identity; merchant onboarding facts; merchant subscription facts; merchant operational status; Citrus-specific active-use evidence; the Citrus-specific monthly active-use qualification decision; signed emission of required source-product events; a bounded reconciliation response containing minimal Citrus facts.

**Citrus Refer & Earn owns:** Referrer identity; referral codes and links; campaigns and campaign versions; attribution uniqueness (one effective earning attribution per merchant-product tenant per product); referral disputes; reward qualification composition; reward calculation; the reward ledger; holds, adjustments, and reversals; Referrer payouts; Referrer statements; Referrer-facing support and reporting.

Hard prohibitions: Citrus must not compute or pay referral rewards; must not store Referrer payout methods, tax records, earnings balances, or fraud evidence; Refer & Earn never queries Citrus's database directly — it receives signed events and authenticated reconciliation responses only.

### 22.2 Required Citrus capabilities

1. **Optional referral code capture at registration** (prefilled from signed link; replaceable before submission; immutable after tenant creation, which is the attribution lock event).
2. **Non-blocking behavior:** registration must continue when the referral service is temporarily unavailable — validate against cached signed campaign snapshot where available, store the snapshot, create the merchant, mark attribution `pending_central_confirmation`, queue events, retry, and show a non-blocking pending notice.
3. **Format validation without exposing Referrer private data:** product-mismatch codes rejected with the standard message; invalid codes allow registration to continue without attribution; no fuzzy matching.
4. **Local immutable referral snapshot** storing: attribution ID, code snapshot, referrer reference, campaign ID and version, attributed-at, attribution status, central confirmation status, tenant ID. Nothing more.
5. **Asynchronous validation/confirmation** through the central validation and confirmation APIs (idempotent at the merchant-product boundary).
6. **Signed, idempotent, versioned source-product events** with the `X-Citrus-*` header contract (key ID, timestamp, nonce, event ID, event type, event version, content hash, signature) and canonical-string signing; events carry stable event IDs across retries.
7. **Transactional-outbox-equivalent reliable delivery** (product-behavior requirement): an event and its originating domain change commit or fail together; append-only payloads; per-tenant sequencing.
8. **Retry with backoff; dead-letter and replay controls:** bounded exponential backoff; dead-letter after the retry window; alert on threshold; controlled replay preserving original event ID and occurred-at; `409 EVENT_ID_PAYLOAD_MISMATCH` stops retries and raises a critical incident — payloads are never mutated and resent.
9. **Data minimization:** payloads never include merchant customers, staff lists, transaction references, M-PESA numbers, detailed revenue, or free-text internal notes.
10. **Reconciliation query surface:** authenticated, HMAC-signed bounded query classes (event by ID; events by merchant and period; qualification decision; subscription payment summary) returning minimal facts and evidence checksums; unattributed merchants return empty scoped results.
11. **Gap detection and backfill:** if attribution confirms after lifecycle events were skipped, Citrus backfills via the reconciliation/replay mechanism without fabricating timestamps.
12. **Correction events rather than deletion:** qualification corrections issue a new decision with a higher `decision_version` referencing the superseded event; prior decisions are never deleted.

### 22.3 Event categories

Citrus shall emit the Refer & Earn event catalogue using the scope-defined business event names (transport naming aligned with the central schema registry at integration time):

| Category | Events |
|---|---|
| Registration lifecycle | merchant_registration_started · merchant_registered (Merchant Administrator created) · merchant_email_verified · merchant_setup_completed (tenant activated) |
| Subscription lifecycle | merchant_subscription_selected (subscription started) · subscription_invoice_issued · subscription_payment_partially_paid · subscription_invoice_fully_paid (payment cleared) · subscription_payment_reversed · subscription_refunded · subscription_chargeback_recorded · merchant_plan_changed · merchant_billing_suspended |
| Operational evidence | eligible_operational_activity_completed · merchant_branch_created (traceability only; never qualifies alone) |
| Qualification | merchant_activity_qualification_decided (one per merchant + product + rule version + period) · correction via higher decision_version (activity qualification corrected) |
| Tenant lifecycle | merchant_reactivated · merchant_deactivated · merchant product tenant closed · merchant_identity_updated · merchant_duplicate_detected |

Tenant-merge events are **not** emitted because Citrus does not support tenant merge at launch.

Events for `subscription_*` and `activity_*` categories are emitted only for attributed merchants (data minimization); unattributed merchants emit nothing.

**Payment-cleared rule:** `subscription_invoice_fully_paid` is emitted only when the payment is applied, has no open allocation exception, and meets the clearing rule (Wallet settlement projection settled, or reconciliation matched and the clearing grace period has elapsed).

### 22.4 Citrus active-use qualification

Citrus defines its own commerce-based active-use rule proving a referred merchant genuinely uses Citrus. Servana's service-session thresholds are explicitly not copied.

| Element | Requirement |
|---|---|
| Qualification period | Calendar month (Africa/Nairobi business dates), evaluated after month close plus a clearing grace period (default 5 days; configurable) |
| Evidence sources (Citrus commerce model) | Completed sales/orders (POS + online); Finance-**validated** merchant-customer payment records; inventory movements from real trading (sale deductions, receipts); active branch usage; subscription invoice for the period fully paid and cleared; absence of disqualifying operational suspension overlapping the period |
| Thresholds | **Not invented here.** Candidate rule for approval (Decision Register D-10): ≥ N completed sales AND ≥ M validated payment records in the period, with subscription fully paid and cleared and no disqualifying suspension. N and M require product-owner approval and central campaign registration |
| Deterministic failure categories | `insufficient_sales` · `insufficient_validated_payments` · `subscription_not_fully_paid` · `payment_not_cleared` · `disqualifying_suspension` · `attribution_not_confirmed` (evaluated in fixed order; first failure reported) |
| Rule versioning | `activity_rule_id` + immutable `activity_rule_version` registered centrally; changes create new versions applying to future periods only |
| Correction rules | Late clearing, reversal/refund/chargeback, or retroactive suspension triggers a corrected decision with higher `decision_version`; original decision preserved |
| Late payment | Period remains `awaiting_full_subscription_payment` until fully paid within the campaign late-payment window; late qualification pays in the next payout run (central behavior) |
| Reversal handling | Reversal that invalidates full payment triggers a not_qualified correction for the affected period |
| Audit evidence | Append-only decision records with evidence checksums; minimized evidence summaries only are transmitted |
| Data supplied to Refer & Earn | Decision, period bounds, rule ID/version, decision version, supersedes reference, minimized evidence summary (counts, not records) |

---

## 23. Customers and Loyalty

### 23.1 Merchant customer relationship

- Merchant customer profiles: identity (name, verified contact where provided), consent and communication preferences, merchant-specific order history, notes (append-only), tags/segments.
- Guest-to-registered conversion: a guest checkout contact can later claim a registered End-User account; the merchant relationship history links on verified contact match with the customer's confirmation.
- Duplicate-customer handling: duplicate detection on verified contact within the tenant; merge is a governed merchant action (Administrator/CX per policy) with immutable merge history; cross-tenant merges do not exist.
- Contact verification: email/phone verification for registered customers; changes re-verified.
- **Cross-merchant isolation:** one End-User identity, many isolated merchant relationships (Section 10.2 rule 6). A merchant never sees another merchant's orders, loyalty, or consent for the same person. Platform-level End-User oversight (Super Administrator regulatory actions) never exposes one merchant's relationship data to another merchant.

### 23.2 Loyalty

- Loyalty account per customer per merchant; points ledger is **append-only**.
- Earn rules, redemption rules, tier rules (e.g., Bronze/Silver/Gold/Platinum class), expiry rules, and bonus campaigns are configured by Growth/Administrator (Section 11.10); points are issued and redeemed only by system events on completed transactions.
- Manual adjustments require Administrator approval (maker-checker, Section 12.4) and preserve reason, actor, approval, and source event.
- Fraud controls: velocity checks on earn/redeem, anomaly flags, hold states on suspected abuse.
- Returns and reversals: compensating ledger entries linked to the source return/refund record (never edits).
- Cross-branch use within the same merchant is supported (loyalty is merchant-scoped, branch-attributed).
- Cross-merchant loyalty leakage is prohibited; no Citrus-wide loyalty program exists unless separately approved as an explicit future scope.

---

## 24. Promotions and Growth

- Promotion scopes: merchant-wide, branch, product/category, customer-segment.
- Coupons/codes: generated with usage limits, per-customer limits, start/end dates, minimum-order rules, stacking rules (default: no stacking unless explicitly allowed), validity windows.
- Approval rules: promotions above configured budget or margin guards require Administrator approval (maker-checker).
- Budget/margin guards: optional merchant-configured caps on discount depth and aggregate promotion spend.
- Abuse prevention: per-customer redemption limits, velocity checks, code-brute-force rate limiting, anomaly flags to Audit.
- Promotion versioning: every change creates a version; transactions reference the version in force.
- Reporting: redemption counts, revenue influence, margin impact estimates (labeled operational estimates).
- Cancellation and correction: promotions can be ended early (audited); mispriced applications are corrected by financial adjustment events, not history edits.
- Discount authority is explicit and auditable: every discount records who, under what authority, on what transaction.

---

## 25. Staff Operations

Grounded in the HR and account files (S3, S6):

- **Staff profiles:** non-financial employment records; documents per Section 29 where lawful and required.
- **Branch assignments:** explicit, HR-administered within the approved branch structure; transfers preserve historical attribution.
- **Work schedules and shifts:** shift templates, assignment, per-branch/department visualization.
- **Attendance:** check-in/out (one active at a time, immutable after checkout), lateness/absence status, manual entries require a reason, unscheduled-presence flags; synced from authentication events where configured.
- **Access windows:** working-hours login windows, period-of-access expiry, manual hold; approved leave automatically holds and later reactivates the account.
- **Leave:** request/approve workflow, types (annual/sick/unpaid/special), balances, calendar, conflict indicators; leave takes precedence over working-hours windows.
- **Task/order assignment:** assignment of orders/tasks to Personnel and Cashiers with attribution.
- **Performance indicators:** role-based KPI templates, scorecards, review workflow, red flags; no automated rewards or penalties.
- **Attribution:** sales, inventory actions, and customer interactions attributable to the acting staff member always.
- **Payroll preparation only:** attendance-derived and leave-adjusted inputs, overtime and commission-readiness flags, payroll period structuring, approve-and-lock (immutable after lock; no reopening at launch), export to Finance. Gross-pay computation formulas per merchant configuration. **No payroll fund movement, payslips as statutory documents, tax filings, or bank integrations.** Commission records (Growth) are operational earnings records clearly separated from any payout processing, which does not exist in Citrus.
- **Suspension/termination and offboarding:** immediate access revocation, session termination, record retention.
- **Access recertification:** periodic review cycles (configurable) requiring HR/Administrator confirmation of each active membership; overdue recertification flags to Audit.

---

## 26. Finance Records and Reconciliation

Citrus provides merchant financial records without claiming statutory accounting or payment processing:

- **Merchant invoices** (to customers): creation from orders/sales; immutable once issued; corrective credit notes for changes.
- **Recorded off-platform payments** and **Finance validation** per Section 19.
- **Receipts** per Section 19.5.
- **Refund and dispute records** per Section 19.6.
- **Cash-up / till / shift reconciliation:** mandatory Cashier End Shift with declared vs expected cash, variance notes, immutable closure record; Finance review of variances and exceptions.
- **Branch summaries** and merchant-wide consolidation for merchant-wide-scoped Finance.
- **Expenses:** manual expense entries with categories (branch operations, commissions read-only system-generated, communication costs, recurring/one-off); immutable once finalized.
- **Period close/lock:** Finance+Administrator maker-checker; locked periods reject new postings dated within them; corrections in a locked period require period reopening (maker-checker, high-severity audit) or posting in the current period with back-reference.
- **Adjustments and write-offs:** maker-checker per Section 12.4.
- **Export to external accounting systems:** CSV export of journals-equivalent operational summaries; all exports labeled: *"Operational records produced by Citrus; not statutory accounts."*
- **Subscription billing visibility:** Citrus invoices, Wallet payment states, and billing status shown read-only to Finance; nothing editable (Section 20.3).

---

## 27. Reporting, Analytics, Search, and Exports

### 27.1 Report catalogue

| Report | Roles | Scope | Freshness | Export |
|---|---|---|---|---|
| Merchant overview dashboard | Administrator | Tenant | Near-real-time (≤60 s) | CSV/PDF |
| Branch dashboard | Branch, Administrator | Branch | Near-real-time | CSV/PDF |
| Sales reports (period, channel, staff, product) | Administrator, Finance, Branch (branch), Growth (influence view) | Scope-bound | Near-real-time; heavy ranges scheduled | CSV/PDF |
| Order reports | Administrator, Branch, Cashier (own shift) | Scope-bound | Near-real-time | CSV/PDF |
| Product performance | Administrator, Growth, Inventory | Scope-bound | Daily + on-demand | CSV/PDF |
| Inventory movement | Inventory, Administrator, Audit | Location-bound | Near-real-time | CSV/PDF |
| Stock valuation estimate | Administrator, Finance, Inventory | Tenant/branch | Daily | CSV/PDF (labeled estimate) |
| Low-stock / stock-out | Inventory, Branch | Location | Real-time alerts | CSV |
| Customer reports | Administrator, CX (masked), Growth (masked) | Tenant | Daily | CSV (masking enforced) |
| Loyalty reports | Administrator, Growth | Tenant | Daily | CSV/PDF |
| Promotion reports | Growth, Administrator | Scope | Daily | CSV/PDF |
| Staff activity reports | HR, Administrator, Audit | Scope | Daily | CSV/PDF |
| Finance validation and reconciliation | Finance, Administrator, Audit | Scope | Near-real-time | CSV/PDF |
| Expense reports | Finance, Administrator | Scope | On-demand | CSV/PDF |
| Subscription and billing reports | Administrator, Finance (read-only) | Tenant | Event-driven | PDF invoice, CSV history |
| Audit reports | Audit, Administrator | Tenant | On-demand | PDF/CSV, integrity-hashed, full-dataset for period |
| Integration health (Wallet, Refer & Earn) | Super Administrator; Administrator sees own tenant's payment/referral status only | Platform / tenant-limited | Near-real-time | CSV |
| Growth and CX analytics | Growth, CX | Scope | Daily | Governed, anonymized |
| Executive multi-branch summaries | Administrator, merchant-wide Audit | Tenant | Daily + on-demand | CSV/PDF |
| Platform reports (merchants, billing, compliance) | Super Administrator | Platform | Near-real-time | CSV/PDF |

For every report: date semantics use the tenant timezone with explicit boundary labeling (month-end boundaries computed in Africa/Nairobi); currency semantics use tenant currency with consistent minor-unit formatting; drill-down respects the viewer's scope; masking rules follow Section 34; retention of generated report artifacts per Section 29; freshness class (real-time / near-real-time / scheduled) is displayed on the report.

### 27.2 Search

Search is scope-safe: results include only records the searcher may read; queries against unauthorized scopes return empty results without revealing existence; search indexing preserves tenant/branch boundaries.

### 27.3 Exports

Exports are permission-checked at generation time and again at download; a user who loses permission mid-generation cannot download the artifact. Export artifacts embed watermarked timestamps and requester identity; Audit exports embed integrity hashes; oversized requests return `EXPORT_TOO_LARGE` with guidance to narrow or schedule. All export events are audit-logged.

---

## 28. Notifications and Communications

### 28.1 Notification events (minimum catalogue)

| Domain | Events |
|---|---|
| Security | Login link issued/used, new device, suspicious login, session terminated, step-up failures, lockouts |
| Identity | Staff invitations, role changes, branch assignment/transfer, suspension/hold/reactivation, recertification due |
| Branch | Status changes (closure, suspension, reopening, archival) |
| Inventory | Low stock, out of stock, expiry approaching, sensitive adjustment pending approval, count variance |
| Orders/Sales | Order placed, status changes, cancellation requests, End Shift variance |
| Customers | Receipts (transactional), order status to customer, loyalty events, promotion events (consent-bound) |
| Finance | Payment-evidence pending validation, validation exceptions, rejection after receipt draft, period lock/reopen |
| Subscription | Invoice issued, due reminders, payment pending/confirmed/failed/unknown, grace entered, restriction/suspension, restoration |
| Integration | Wallet integration failures (platform + affected merchant billing surface), Refer & Earn delivery failures (platform) |
| Compliance/Security alerts | Policy violations, anomaly flags, export events |
| Reports | Scheduled report ready |

### 28.2 Channels

- **In-app:** all roles; mandatory for transactional and security events.
- **Email:** merchant staff (magic links, invitations, security, billing), End Users (receipts, order status, security) — via approved provider.
- **SMS:** End-User OTP and transactional messages through an approved provider; merchant-to-customer campaign messages consume merchant communication budget/entitlement (D-08).
- **Push:** not in launch scope (may be added by future decision).

### 28.3 Behavior rules

1. User preferences control non-mandatory categories; **mandatory transactional and security messages cannot be disabled** (receipts, security alerts, billing enforcement notices, OTP/magic links).
2. Delivery retry with backoff; provider failover where configured; failures logged and alertable.
3. Deduplication: one logical event produces at most one notification per channel per recipient.
4. Templates are versioned and centrally managed; localization-ready (launch language English; structure supports additional locales).
5. Retention: in-app notifications 90 days (non-critical) with compliance-critical notifications retained per audit retention; End-User notification retention 90–180 days.
6. All notification sends are auditable (event, recipient, channel, template version, outcome).
7. Consent: merchant marketing communications require recorded customer consent; consent state is checked at send time.

---

## 29. Files, Media, Imports, and Exports

| Requirement | Rule |
|---|---|
| File classes | Product images, merchant branding assets, staff documents (where lawful and required), supplier documents, receipts/invoices (generated PDFs), import files, export artifacts |
| Ownership | Every file is owned by a tenant (or platform); tenant isolation applies to storage paths, listings, and access |
| Private vs public | Storefront media is public-cacheable; all other files are private by default |
| Access | Private files served only through signed, time-limited URLs; permission checked at issuance |
| Upload safety | File-type allowlist, size limits (images ≤ 10 MB, documents ≤ 25 MB — proposed defaults requiring approval), content-type verification, malware scanning before availability |
| Imports | Templated CSV for catalogue, customers (where lawful, with consent provenance), and opening stock; validation preview, row-level errors, idempotent re-run behavior (import batch IDs) |
| Exports | Section 27.3 rules; artifacts expire after a retention window (default 30 days) |
| Retention | Files follow the retention class of their owning record (Section 34) |
| Orphan cleanup | Unreferenced uploads are garbage-collected after a safety window |
| Deletion and legal hold | Deletion requests honor retention and legal holds; legal hold suspends deletion with audit |
| Audit | Upload, access grant, download, and deletion events logged |

---

## 30. API and Integration Requirements

Product-contract level requirements (no endpoint engineering catalogue; the Product Technical Details v.2 baseline requires versioned `/api/v1` style APIs, validation, authentication, authorization, pagination, and rate limiting for all API surfaces):

1. **Versioned APIs:** all programmatic surfaces versioned; breaking changes only in new versions; deprecation with published timelines.
2. **Machine identities:** Wallet and Refer & Earn identities per Section 11.13; per-environment, least-privilege, rotated (overlapping-validity rotation; dual-key webhook secrets), revocable, last-use tracked.
3. **Webhook security:** inbound Wallet webhooks and inbound Refer & Earn reconciliation requests verified per Sections 21.2/22.2 (HMAC, timestamp tolerance, nonce/event-ID replay protection, content hash, constant-time comparison) before any payload trust.
4. **Idempotency:** all money-adjacent and event-producing operations idempotent; idempotency keys stored with request hashes; same key + different payload → conflict error.
5. **Schema versioning:** integration event schemas versioned; unsupported versions rejected whole (no partial parse).
6. **Environment separation:** sandbox/staging/production credentials and data disjoint; production boot refuses non-production credentials.
7. **IP restrictions:** applied where practical to machine channels.
8. **Rate limits:** all public and authenticated endpoints rate-limited; abuse returns `RATE_LIMITED` with retry-after semantics.
9. **Integration health:** monitored delivery/consumption lag, failure rates, dead-letter depth; surfaced to Super Administrator dashboards with alerting.
10. **Retry and dead-letter:** bounded exponential backoff; dead-letter queues with alert thresholds and controlled, audited replay.
11. **Contract deprecation:** integration contract changes coordinated with Wallet/Refer & Earn registries; consumer-driven contract verification before environment promotion.
12. **Audit:** all machine-channel activity logged with correlation identifiers.
13. **No merchant-scoped public API credentials at launch** (D-12).

---

## 31. Domain Model and Data Ownership

Conceptual domain model (no column-level schema). SoR = system of record.

| Entity | SoR | Tenant owner | Branch scope | Immutability | Retention class | Sensitive fields | Deletion/archival | Cross-system IDs |
|---|---|---|---|---|---|---|---|---|
| Platform (plans, policy, registry) | Citrus (platform) | Citrus Labs | — | Plan versions immutable | Long | — | Versioned, never hard-deleted | — |
| Merchant (tenant) | Citrus | Self | — | Identity locked post-KYC | Long/statutory | KYC identifiers | Archival; no hard delete in statutory window | Wallet merchant-account ref; R&E tenant ref |
| Branch | Citrus | Merchant | Self | Lifecycle history append-only | Long | Address/contact | Archive only | — |
| User identity | Citrus | Platform (identity) | — | Identity events append-only | Long | Email, phone, national ID | Anonymization per rights requests where lawful | — |
| Membership (user×tenant×role×scope) | Citrus | Merchant | Per membership | Change history append-only | Long | — | Deactivate; history retained | — |
| Role / Permission | Citrus | Platform-defined; merchant-configured limits | — | Versioned | Long | — | Versioned | — |
| Customer (merchant relationship) | Citrus | Merchant | Attribution | Notes append-only | Medium/consent-bound | Contact, consent | Anonymization on valid request, subject to financial record retention | Central End-User identity link |
| Product / Service / Variant | Citrus | Merchant | Availability per branch | Price/name history versioned | Long | Cost data (restricted) | Archive only | — |
| Price | Citrus | Merchant | Override per branch | Effective-dated, append-only | Long | Cost | Versioned | — |
| Stock location | Citrus | Merchant | Branch | — | Long | — | Archive after disposition | — |
| Stock movement | Citrus | Merchant | Location | **Immutable** | Long | — | Never deleted | Source document ref |
| Supplier | Citrus | Merchant | Optional | Delivery logs immutable | Medium | Contact | Soft deactivation | — |
| Order / Sale | Citrus | Merchant | Branch | **Immutable**; corrective events | Statutory-aligned | Customer link | Never deleted | — |
| Merchant invoice (to customer) | Citrus | Merchant | Branch | Immutable; credit notes | Statutory-aligned | — | Never deleted | — |
| Recorded payment (evidence) | Citrus | Merchant | Branch | Immutable; state transitions append | Statutory-aligned | Masked external reference | Never deleted | — |
| Receipt | Citrus | Merchant | Branch | Immutable; voids linked | Statutory-aligned | — | Never deleted | — |
| Refund record (off-platform) | Citrus | Merchant | Branch | Immutable | Statutory-aligned | — | Never deleted | — |
| Loyalty account / ledger | Citrus | Merchant | Attribution | **Append-only ledger** | Long | — | Anonymize holder on request; ledger retained | — |
| Promotion | Citrus | Merchant | Scope-configurable | Versioned | Medium | — | End-date; versions retained | — |
| Staff profile / attendance / payroll-prep | Citrus | Merchant | Assignment | Attendance immutable post-checkout; payroll locked | Employment-record class | Employment data | Retention per labor-law guidance (legal review D-11) | — |
| Subscription / Subscription invoice | **Citrus** | Merchant (subject) / Citrus Labs (creditor) | — | Invoices immutable; states append | Statutory | — | Never deleted | Wallet payment ref |
| Wallet payment reference/projection | **Wallet** (money truth); Citrus holds projection | — | — | Projection append-only | Statutory | Masked provider ref | Never deleted | `{PREFIX}-PAY-<ULID>`, wallet_payment_id, wallet_event_id |
| Referral snapshot | Citrus (snapshot); **R&E** (attribution truth) | Merchant tenant fact | — | **Immutable** | Long | Referrer reference (opaque) | Never deleted | attribution_id, campaign_id/version |
| Integration event (outbox/inbox) | Citrus (its own emissions/inbox) | — | — | Append-only, payload-immutable | Long | Minimized payloads | Never deleted within audit window | event_id, correlation_id |
| Notification | Citrus | Tenant/user | — | Send log immutable | Short/medium | Recipient contact | Purge after retention | Template version |
| File | Citrus | Tenant | Optional | Content-addressed versions | Follows owning record | Per class | Section 29 rules | — |
| Audit event | Citrus | Tenant/platform | Contextual | **Append-only, hash-chained** | Longest class | Masked where needed | Never deleted; legal-hold aware | correlation_id |

---

## 32. State Machines and Business Rules

For every transition below, the general contract is: **Trigger** (user/system event) → **Authorized actor** (per Section 12) → **Preconditions** (validated server-side) → **Result** (new state) → **Side effects** (records, stock, notifications) → **Audit event** (always) → **Reversal/correction path** (compensating event where defined) → **Invalid transitions rejected** with `INVALID_STATE_TRANSITION`, no partial effects.

### 32.1 Catalogue of state machines

| Aggregate | States |
|---|---|
| Merchant onboarding | registration_started → identity_verified → onboarding → active_complete \| rejected \| abandoned |
| Merchant operational | active → suspended(reason) → active; active → deactivated → archived → closed |
| Merchant billing | trialing → active → overdue → read_only_grace → suspended_billing → active (billing-only recovery); any → cancelled |
| Branch | draft → active → temporarily_closed \| suspended → active; active → archived → closed |
| Staff membership | invited → active → held(working-hours/leave/manual) → active; active → suspended → active \| offboarded |
| Invitation | issued → accepted \| expired \| revoked |
| Product | draft → active → archived; active → discontinued |
| Inventory movement | posted (single-state, immutable); transfers: initiated → in_transit → received \| cancelled-with-compensation |
| Order | pending → accepted → in_progress → ready → completed; pending/accepted → cancelled; failure → failed |
| Sale (POS) | draft → awaiting_payment_evidence → completed; draft/awaiting → cancelled |
| Merchant invoice (customer) | draft → issued → partially_settled_by_evidence → settled_by_validated_evidence; issued → cancelled (pre-evidence); credit-note corrections |
| Recorded payment validation | pending_validation → validated \| rejected; validated → disputed → resolved(refunded_off_platform \| reversed_off_platform \| upheld); any authorized → written_off |
| Refund/dispute record | initiated → approved → recorded_off_platform; initiated → declined |
| Loyalty adjustment | proposed → approved → posted; proposed → declined |
| Subscription | Section 20.2 |
| Subscription invoice | Section 20.3 |
| Wallet payment projection | Mirror of Wallet states: CREATED, PENDING_CUSTOMER_ACTION, SUBMITTED, PROCESSING, SUCCEEDED, PARTIALLY_RECEIVED, OVERPAID, FAILED, EXPIRED, CANCELLED, UNKNOWN, REVERSED, REFUNDED (projection only; Wallet authoritative; terminal states never regress) |
| Referral snapshot | captured → validating → validated → confirmed; → rejected \| invalid_format \| pending_central_confirmation (outage) |
| R&E event delivery | queued → delivering → delivered; → retrying → dead_lettered → replayed |
| Support case (CX) | open → in_progress → escalated → resolved → closed; reopened |
| Shift session | opened → active → closing(blocked-until-clean) → closed (immutable) |

### 32.2 Illustrative transition specifications (normative pattern)

| Transition | Trigger | Actor | Preconditions | Side effects | Notification | Correction path |
|---|---|---|---|---|---|---|
| Sale: awaiting_payment_evidence → completed | Evidence recorded meeting receipt rule | Cashier | Open shift; stock reserved; evidence record created | Stock deduction; loyalty accrual; receipt per rules; evidence enters pending_validation | Customer receipt | Void/return events |
| Evidence: pending_validation → rejected | Finance rejection with reason | Finance (not recorder) | Evidence exists; not self-recorded | Receipt voided by linked corrective doc; order payment position recalculated; Cashier + customer notified | Yes | Re-record corrected evidence |
| Subscription invoice: pending_payment → paid | Verified Wallet webhook (SUCCEEDED, amount = balance) | System (Wallet event) | Signature verified; first-seen event; payment maps to registered invoice | Funds applied under lock; billing projection run; billing-only recovery if applicable; R&E fully-paid event queued (attributed merchants) | Merchant billing notice | Reversal event → corrective state + possible re-escalation |
| Billing: suspended_billing → active | Paid allocation confirmed | System | Suspension reason billing-only | Recovery allowlist lifted; sessions re-validated | Merchant notice | Reversal re-escalates per grace rules |
| Membership: active → offboarded | HR offboarding | HR | Not last Administrator | Sessions revoked ≤ 60 s; assignments closed; history retained | Staff + Administrator | None (new membership if rehired) |
| Qualification decision correction | Late clearing/reversal | System (scheduler) | Prior decision exists | New decision with decision_version+1, supersedes reference; R&E event queued | Platform ops on anomaly | Further corrections version++ |

---

## 33. Security Threat Model and Controls

### 33.1 Threats and mitigations

| Threat | Primary controls |
|---|---|
| Broken access control | Default deny; server-side policy checks on every request/job/export; role matrix tests (Section 42) |
| Cross-tenant access | Tenant-scoped queries; ownership verification in every policy; non-sequential public IDs; isolation test suite |
| Cross-branch access | Branch scope in membership; branch checks in policies; branch isolation tests |
| Insecure direct object references | Public-safe identifiers; ownership checks; 404-style non-disclosure |
| Magic-link theft or replay | Short expiry, single-use, hashed at rest, audience/context binding, replay detection with session termination and alert |
| Session fixation | Session regeneration at authentication; token rotation; secure cookie flags |
| Privilege escalation | HR self-escalation prohibition; permission versioning; non-delegable list; audit on every grant |
| Staff offboarding delay | Prompt session revocation (≤60 s target); access windows; recertification |
| Fraudulent payment recording | Finance validation; recorder≠validator; duplicate-reference detection; variance and anomaly flags; Audit visibility |
| Duplicate payment allocation | First-seen Wallet event dedup; invoice-lock application; WALLET_PAYMENT_REUSED exception |
| Inventory manipulation | Reason-coded immutable movements; approval thresholds; count variance review; shrinkage reporting |
| Loyalty abuse | Ledger append-only; system-only accrual; velocity checks; maker-checker adjustments |
| Promotion abuse | Usage/per-customer limits; stacking rules; budget guards; anomaly flags |
| Export abuse | Permission at generation and download; volume caps; masking; watermarks; full audit |
| File-upload abuse | Allowlists, size limits, content verification, malware scanning, private-by-default |
| API abuse | Authentication, scopes, rate limits, anomaly monitoring |
| Webhook forgery | HMAC verification, key-ID resolution, constant-time compare, destination allowlists |
| Replay attacks | Timestamp tolerance ±300 s, nonces, event-ID replay store |
| Secret leakage | Secrets manager, no secrets in code/logs/frontend, rotation, environment disjointness |
| Sensitive-log exposure | No tokens/OTPs/payment references in logs; structured logging with masking |
| Mass assignment | Explicit field allowlists on all writes |
| Injection / XSS / CSRF | Parameterized data access; output escaping by default; CSRF tokens on browser flows; strict CORS |
| Unsafe redirects | Allowlisted redirect targets only |
| Denial of service | Rate limits, load shedding, queue backpressure, resource caps on imports/exports/reports |
| Dependency risk | Automated vulnerability scanning; update policy |
| Administrative misuse | Purpose-limited Super Administrator surfaces; reason-required actions; append-only audit; alerting on anomalous admin activity |

### 33.2 Mandatory controls

Least privilege; default deny; strong tenant and branch isolation; TLS-encrypted transport everywhere; encryption at rest for sensitive fields (identity numbers, contact data, masked payment references); centralized secret management; step-up authentication for high-risk actions; rate limits on authentication and sensitive endpoints; session revocation; comprehensive audit logging; security alerting; secure generic error messages; data minimization; encrypted, access-controlled, and tested backups; documented incident-response procedure with severity classification and notification obligations (Section 34.4).

---

## 34. Privacy, Compliance, and Data Governance

Launch jurisdiction is Kenya; the governing statute is the **Kenya Data Protection Act** (registration and obligations require confirmatory legal review — D-11). This scope defines controls; it does not assert legal compliance.

1. **Lawful basis/consent:** contract performance for commerce records; consent for marketing communications (recorded, versioned, withdrawable at any time).
2. **Purpose limitation and minimization:** data collected only for defined product purposes; integration payload minimization per Sections 21–22; Referrer data never stored in Citrus; merchant operational detail never sent to Refer & Earn.
3. **Notices and terms:** customer privacy notice on storefront surfaces; merchant data-processing terms accepted at registration; staff privacy notice at first login.
4. **Data subject rights:** access, correction, export, and deletion/anonymization request workflows for End Users, merchant customers, and staff; identity verification before fulfilment; deletion honors statutory retention of financial records (anonymize identity, retain transaction facts).
5. **Retention schedule (classes):** financial/commerce records — statutory-aligned long retention (period set by legal review, D-11); audit events — longest class; employment records — labor-law-aligned (D-11); notifications — short; login history — 30–60 days (End User) / 12 months (staff security logs, proposed); export artifacts — 30 days.
6. **Legal holds:** suspend deletion for named records with audit.
7. **Breach notification workflow:** detection → severity classification → containment → assessment → notification of the regulator and affected subjects within statutory timelines → post-incident review; evidence preserved.
8. **Subprocessor management:** register of processors (email, SMS, hosting, scanning); contractual data-protection terms; change notice to merchants.
9. **Cross-border considerations:** hosting location and any cross-border transfer documented and assessed (D-11).
10. **Masking:** national IDs, phone numbers, and external payment references masked in list views, exports, and logs; full values restricted to authorized detail views with audit.
11. **Audit access:** Audit role sees masked personal data by default; unmasking rights are explicit and logged.
12. **Payments boundary statement:** Citrus records off-platform payment evidence only and **does not hold customer funds**; this is stated in merchant terms and customer-facing documentation. Regulatory analysis of recording obligations (e.g., e-receipt/tax rules) is flagged for legal review (D-11).

---

## 35. UI, UX, Responsive, Theme, and Accessibility Requirements

### 35.1 Design system

A single design system across all account surfaces defines: typography (single legible family, defined scale); spacing scale; semantic color tokens (light/dark aware); buttons (primary/secondary/destructive with disabled, loading, focus states); form controls (labels always present — placeholders never replace labels; required indicators; validation states); cards; data tables (sortable, filterable, paginated, responsive collapse); filters; navigation and sidebar; header with tenant/branch/role context and profile unit (photo + name as one cohesive identity unit with anchored preview card that never clips or blocks critical UI); modals and drawers; toasts; empty states (explanatory, action-forward); loading states (skeletons/spinners); error states (human-readable, mapped to Section 38); status badges (state-machine aligned); audit indicators (who/when on governed records).

### 35.2 Responsive behavior

Viewport-based CSS media queries only (no device detection, no JS layout-mode switching):

| Mode | Viewport |
|---|---|
| Desktop | ≥ 1025 px |
| Tablet | 768–1024 px |
| Mobile | ≤ 767 px |

Requirements: real-time adaptation on resize; no horizontal scroll on normal content; no overlap/clipping; touch-usable targets on tablet/mobile; specific adaptations for dashboards (stacking KPI cards), data tables (responsive collapse or scroll-contained regions), POS/sale screens (touch-first layout, large targets, one-hand mobile operation), catalogue and inventory forms, reports, branch switching and profile menu, storefront and checkout (mobile-first).

### 35.3 Theme

Light mode default; dark mode via a clear toggle; preference persisted per authenticated user. Both themes maintain accessible contrast and preserve focus states, borders, validation errors, status badges, and chart readability.

### 35.4 Accessibility (practical WCAG 2.2 AA)

Keyboard access across the application; visible focus indicators; accessible names/labels on all controls; error messages programmatically associated with inputs; semantic structure (headings, landmarks, table semantics); AA contrast; touch targets ≥ 44×44 pt; browser zoom respected (no disabled viewport scaling); reduced-motion preference respected; charts accompanied by accessible data tables or text equivalents; screen-reader-compatible dynamic updates (live regions for toasts and status changes).

### 35.5 Forms

Labels always visible; required indicators; inline validation with explanation and correction guidance; duplicate-submit prevention on all forms (idempotent submission on commerce forms); draft preservation for long forms (catalogue entry, onboarding); unsaved-change warnings; sensitive fields handled without visual overemphasis and never logged; error recovery preserves user input; long forms sectioned logically; destructive actions require explicit confirmation (and step-up where Section 12 requires).

---

## 36. Performance, Reliability, Scalability, and Recovery

Source files define no numeric targets beyond marketing claims; the following are **proposed targets requiring product approval** (Decision Register D-13), separated into launch and scale bands.

### 36.1 Proposed capacity targets

| Dimension | Launch target | Scale target (24 months) |
|---|---|---|
| Active merchant tenants | 500 | 5,000 |
| Branches (total) | 2,000 | 25,000 |
| Concurrent authenticated users | 2,000 | 20,000 |
| Catalogue size per merchant | 10,000 SKUs | 100,000 SKUs |
| Customers per merchant | 50,000 | 500,000 |
| Sales/orders per day (platform) | 100,000 | 1,500,000 |
| Inventory movements per day | 300,000 | 5,000,000 |
| Notifications per day | 250,000 | 3,000,000 |
| Report rows per export | 250,000 (larger scheduled) | 1,000,000 |
| Import size | 50,000 rows | 250,000 rows |
| Integration events per day | 50,000 | 500,000 |

### 36.2 Proposed service objectives

| Objective | Proposed value |
|---|---|
| Availability (core commerce) | 99.9% monthly |
| Interactive page/API latency | p95 < 500 ms for common operations |
| POS sale completion (server time) | p95 < 1 s |
| RPO (data loss bound) | ≤ 5 minutes |
| RTO (restore of core service) | ≤ 4 hours |
| Data durability | Multi-copy durable storage with tested restores |
| Webhook acknowledgment | p95 < 250 ms |
| Search freshness | ≤ 60 s from write |
| Near-real-time dashboards | ≤ 60 s staleness |

### 36.3 Reliability behavior

- **Background-work reliability:** queued jobs (emails, reports, imports, exports, integration deliveries) are durable, retried with backoff, and dead-lettered with alerting; queue backlog thresholds trigger scaling and load-shedding of deferrable work.
- **Degraded-mode behavior:** read paths preferred under stress; POS keeps local drafts during connectivity loss (Section 18.1); deferrable notifications delayed before core commerce is impacted.
- **Caching:** expensive reads cached with tenant-scoped keys; cache never bypasses authorization.
- **Rate limiting and load shedding:** per-user, per-tenant, and per-IP limits; graceful 429 responses.
- **Wallet outage:** subscription-payment initiation returns a retryable "temporarily unavailable" state; invoices remain visible and payable later; registration retries automatically; status-query reconciliation catches up on recovery; historical billing data and all non-payment operations remain available. **Citrus core merchant operations shall not fail because Wallet is unavailable.**
- **Refer & Earn outage:** registration and all commerce continue (Section 22.2); events queue durably; reconciliation backfills. **Citrus core merchant operations shall not fail solely because Refer & Earn is unavailable.**

---

## 37. Observability, Auditability, Support, and Incident Management

### 37.1 Logging and audit catalogue

Structured operational logs; security logs; authentication logs (issuance, use, replay, failure); authorization denials; merchant and branch lifecycle logs; catalogue and price changes; inventory events; sale and order events; recorded-payment events; finance validation events; subscription events; Wallet integration events (registration, attempts, webhooks, reconciliation); Refer & Earn integration events (emission, delivery, dead-letter, reconciliation); export events; file access; administrative actions; data-deletion actions.

Audit records identify, where appropriate: actor; actor role (acting context); merchant; branch; action; target; timestamp; source channel; IP address; user agent; correlation identifier; before/after values where safe; reason; approval reference. Audit storage is append-only and hash-chained for the tamper-evident trail exposed to the Audit role.

### 37.2 Alerting and incident classification

| Severity | Examples | Response expectation |
|---|---|---|
| Critical | Cross-tenant exposure, payment-allocation integrity exception, audit-chain failure, EVENT_ID_PAYLOAD_MISMATCH, platform outage | Immediate page; incident opened |
| High | Wallet/R&E delivery failures beyond threshold, webhook signature failures, queue dead-letter growth, elevated auth failures | Same business day |
| Medium | Report generation failures, import failures, notification provider degradation | Tracked and triaged |
| Low | Individual job retries, transient provider blips | Logged |

### 37.3 Support workflows

- Merchant support intake (in-product + support email) with case states per Section 32.
- Support/ops investigation evidence for a user-reported issue: correlation-ID trace across request logs, audit events, integration events, and notification outcomes; scoped read access with logged reason.
- Operational dashboards: platform health, queue depth, integration health, billing enforcement summary, security events.

### 37.4 Incident response

Documented procedure: detect → classify → contain → communicate (status page/notices where user-impacting) → resolve → post-incident review with corrective actions; breach-notification path per Section 34.7.

---

## 38. Deterministic Error Catalogue

Every material error has: a user-visible title/message (generic, safe), a stable machine-readable code, transport semantics, retryability, required user action, required staff action, audit severity, alerting requirement, and data-preservation behavior. No stack traces, provider secrets, cross-tenant identifiers, or internal details are ever exposed to users. Form errors preserve user input.

| Code | HTTP | User-visible message (summary) | Retryable | User action | Staff/system action | Audit | Alert |
|---|---|---|---|---|---|---|---|
| AUTH_LINK_EXPIRED | 401 | "This sign-in link has expired. Request a new one." | Yes (new link) | Request new link | — | Low | No |
| AUTH_LINK_REPLAYED | 401 | "This sign-in link has already been used." | Yes (new link) | Request new link | Security review if anomalous | High | On pattern |
| MEMBERSHIP_INACTIVE | 403 | "Your access to this business is not active. Contact your administrator." | No | Contact merchant admin | HR review | Medium | No |
| MERCHANT_SUSPENDED | 403 | "This business account is currently unavailable." | No | Contact support | Platform review | High | No |
| BRANCH_SUSPENDED | 403 | "This branch is currently unavailable." | No | Contact administrator | Admin review | Medium | No |
| BRANCH_ACCESS_DENIED | 404-style | "Not found." (non-disclosure) | No | — | Access-review log | High | On pattern |
| PERMISSION_DENIED | 403 | "You don't have permission for this action." | No | Request access | Denial logged | Medium | On pattern |
| PLAN_ENTITLEMENT_DENIED | 403 | "This feature isn't included in your current plan." | No | Upgrade path | — | Low | No |
| BILLING_RESTRICTED | 403 | "This action is unavailable until billing is settled." | After payment | Pay invoice | — | Medium | No |
| MERCHANT_DUPLICATE | 409 | "A business with these details is already registered." | No | Contact support | Duplicate review | Medium | No |
| CUSTOMER_DUPLICATE | 409 | "A customer with this contact already exists." | No | Use existing/merge | Merge workflow | Low | No |
| SKU_DUPLICATE | 409 | "This SKU code already exists." | No | Change SKU | — | Low | No |
| INVALID_STOCK_QUANTITY | 422 | "The quantity entered is not valid." | Yes (corrected) | Correct input | — | Low | No |
| INSUFFICIENT_STOCK | 409 | "Not enough stock to complete this action." | Yes (after restock) | Adjust quantity | Inventory alert | Low | No |
| STOCK_CONFLICT | 409 | "Stock changed while you were working. Refresh and retry." | Yes | Retry with fresh state | — | Low | No |
| INVALID_STATE_TRANSITION | 409 | "This action isn't possible in the current status." | No | Refresh | — | Medium | On pattern |
| SALE_DUPLICATE_SUBMISSION | 409 (idempotent replay) | Original result returned | N/A | None (dedup) | — | Low | No |
| PAYMENT_AMOUNT_MISMATCH | 422 | "The amount doesn't match the outstanding balance." | Yes (corrected) | Correct amount | Finance review if repeated | Medium | No |
| PAYMENT_REFERENCE_DUPLICATE | 409 | "This payment reference has already been recorded." | No | Verify reference | Finance exception queue | High | On pattern |
| PAYMENT_VALIDATION_CONFLICT | 409 | "This payment record was updated by another user." | Yes | Refresh | Finance resolves | Medium | No |
| WALLET_UNAVAILABLE | 503 | "Payment service is temporarily unavailable. Your invoice remains payable." | Yes | Retry later | Auto-retry; ops alert on duration | High | Yes |
| WALLET_TIMEOUT / WALLET_UNKNOWN_STATE | 202-style pending | "We're confirming your payment. This can take a few minutes." | No (blocked until resolved) | Wait | Status-query recovery | High | On aging |
| WALLET_SIGNATURE_INVALID | 401 (to sender) | — (machine) | No | — | Reject event; security alert | Critical | Yes |
| WALLET_EVENT_DUPLICATE | 200 ack | — (machine, no effect) | N/A | — | Dedup log | Low | No |
| WALLET_AMOUNT_MISMATCH | exception | — | No | — | Allocation exception queue | Critical | Yes |
| WALLET_PAYMENT_REUSED | exception | — | No | — | Critical integrity exception; block posting | Critical | Yes |
| RE_UNAVAILABLE | 503 (internal) | "Referral confirmation pending." (non-blocking) | Auto | None | Queue and retry | Medium | On duration |
| REFERRAL_CODE_INVALID | 422 | "This referral code isn't valid. You can continue without it." | Yes | Correct or skip | — | Low | No |
| REFERRAL_CODE_PRODUCT_MISMATCH | 422 | "This code belongs to a different Citrus product." | Yes | Use correct code | — | Low | No |
| ATTRIBUTION_CONFLICT | central | "Referral under review." | No | None | Central resolution; registration unaffected | Medium | No |
| EVENT_DELIVERY_FAILURE | internal | — | Auto backoff | — | Retry → dead-letter → replay | High | On threshold |
| EVENT_ID_PAYLOAD_MISMATCH | 409 (machine) | — | **No** | — | Stop retries; dead-letter; critical incident | Critical | Yes |
| EXPORT_TOO_LARGE | 422 | "This export is too large. Narrow the range or schedule it." | Yes | Adjust range | — | Low | No |
| FILE_REJECTED | 422 | "This file type or size isn't allowed." | Yes | Fix file | Malware detections alerted | Medium (High if malware) | On malware |
| RATE_LIMITED | 429 | "Too many requests. Try again shortly." | Yes (after retry-after) | Wait | Abuse review on pattern | Medium | On pattern |
| JOB_FAILURE | internal | "We couldn't finish this task. We're retrying." | Auto | Wait/notify | Dead-letter review | Medium | On threshold |
| REPORT_GENERATION_FAILURE | 500-class | "Report generation failed. Try again or contact support." | Yes | Retry | Ops review | Medium | On pattern |

---

## 39. Comprehensive Edge-Case Catalogue

For each case: **Expected behavior / Source of truth / User impact / Recovery / Audit / Acceptance condition** are stated compactly.

### 39.1 Identity and membership

| Case | Expected behavior |
|---|---|
| Same email holds memberships in several merchants | After authentication, context selector lists only permitted contexts; session binds to one context. SoR: membership records. Acceptance: no cross-context data access without re-selection |
| User removed while logged in | Session invalidated ≤ 60 s; in-flight requests denied with MEMBERSHIP_INACTIVE; unsaved drafts preserved locally where safe. Audit: revocation event |
| Branch transferred while session active | Old branch context invalidated; user returned to context selection; historical attribution unchanged |
| HR removes their own final administrative access | Blocked: an HR user cannot remove/suspend their own membership if doing so leaves the tenant without any HR **and** the action is self-targeted; Administrator can always restore HR |
| Merchant has no active HR user | Administrator regains direct staff-provisioning capability (fallback per Section 11.3); flagged on governance dashboard |
| Magic link forwarded | Link binds identity, not mailbox; first use from anomalous context triggers step-up; replay after use fails (AUTH_LINK_REPLAYED) |
| Magic link opened twice | Second open fails; if from different device/IP, first session terminated and security alert raised |
| Email changes during pending invitation | Invitation bound to original email is revoked and reissued to the corrected address; acceptance of the stale link fails |

### 39.2 Merchant and branch lifecycle

| Case | Expected behavior |
|---|---|
| Onboarding complete but subscription unpaid | Tenant operationally active only per plan/trial rules; unpaid first invoice follows grace path; recovery allowlist applies at restriction. SoR: billing status |
| Billing-suspended and simultaneously under investigation | Both dimensions tracked independently; payment restores billing only; operational restriction remains (PR-9). Acceptance: W-21-class test |
| Branch closes with open orders | Closure blocked until orders resolved (complete/cancel/transfer) with audit |
| Branch closes with stock on hand | Closure blocked until stock dispositioned (transfer/write-off with approval) |
| Last branch archived | Blocked unless tenant closure in progress |
| Merchant exceeds branch limit | Creation blocked with PLAN_ENTITLEMENT_DENIED and upgrade path; existing branches unaffected |

### 39.3 Catalogue and inventory

| Case | Expected behavior |
|---|---|
| SKU renamed after historical sales | Historical documents retain name/price at sale time; reports resolve by SKU identity |
| Product archived with open orders | Archive blocked or requires order resolution; archived product resolvable in history |
| Concurrent sale and transfer of same stock | Serialized stock operations; loser gets STOCK_CONFLICT/INSUFFICIENT_STOCK; no negative stock under prohibit policy |
| Negative stock policy | Configurable prohibit (default) or allow-with-flag; flagged exceptions to Inventory |
| Return after product discontinued | Return recordable against historical record; disposition restock (to active location) or write-off |
| Stock count during active sales | Count snapshot + movement window reconciliation; variances posted as adjustments with approval |
| Batch expires while reserved | Reservation invalidated at fulfilment check; substitute batch or line cancellation; expiry write-off recorded |

### 39.4 Sales and offline payments

| Case | Expected behavior |
|---|---|
| Customer pays off-platform before invoice creation | Evidence recorded unallocated (Finance queue); allocated to invoice once created; never lost |
| Partial payment recorded by two staff | Both records exist; payment position sums validated records; duplicate-reference check prevents same-reference double entry |
| Duplicate external reference | Second record blocked (PAYMENT_REFERENCE_DUPLICATE); Finance exception path for legitimate re-use across orders |
| Cash payment entered twice | No external reference to dedup: End Shift variance surfaces it; Finance corrects by rejection of duplicate with reason |
| Finance rejects evidence after receipt draft | Receipt voided by linked corrective doc; order returns to correct payment state; customer notified where contactable |
| Refund outside Citrus after period lock | Refund record requires period-reopen maker-checker or current-period posting with back-reference; original period never silently edited |
| Order cancelled after stock deduction | Compensating stock movement (return-to-stock) linked to cancellation |
| Network retry duplicates sale submission | Idempotent submission: same idempotency key returns original result; no duplicate sale |

### 39.5 Subscription and Wallet

| Case | Expected behavior |
|---|---|
| Payment succeeds at provider but Citrus request times out | Attempt state UNKNOWN; no blind retry; status-query recovery resolves; webhook remains authoritative |
| Webhook arrives before create-payment response is processed | Inbox persists event durably; application waits until the payment binding resolves; no loss |
| Duplicate webhook | First-seen event applied once; duplicates acknowledged with zero effect |
| Out-of-order webhook | Terminal states never regress; stale non-terminal events recorded snapshot-only |
| Webhook timestamp outside tolerance | Rejected; Wallet retries; persistent rejects raise clock-drift alert |
| Underpayment | partially_paid; balance remains; grace unaffected until due rules trigger |
| Overpayment | paid + account credit; credit auto-applies to next invoice |
| Payment to expired/cancelled invoice | Funds recorded by Wallet; Citrus routes to allocation exception (credit or reallocation); never discarded |
| Payment after plan change | Applied to the registered invoice it references; proration/credit rules govern differences |
| Reversal after access restored | Corrective invoice state; billing re-escalates per grace rules; R&E reversal event emitted for attributed merchants |
| Wallet outage at grace deadline | Grace escalation pauses for verified platform-side payment unavailability (fairness rule); resumes on recovery |
| Merchant pays while suspended for fraud | Payment applies to billing only; operational suspension remains (PR-9) |

### 39.6 Refer & Earn

| Case | Expected behavior |
|---|---|
| Invalid referral format | Registration continues without attribution; clear notice |
| Valid code but service unavailable | Snapshot stored; pending_central_confirmation; registration continues; events queue |
| Attribution conflict | Central resolves; Citrus registration unaffected; qualification blocked until resolution |
| Confirmation arrives after lifecycle events occurred | Gap backfill via reconciliation/replay with original event IDs and timestamps |
| Duplicate event delivery | Central dedup on event_id; Citrus retry-safe |
| Same event ID, different payload | 409 EVENT_ID_PAYLOAD_MISMATCH; stop retries; dead-letter; critical incident |
| Qualification changes after late Wallet settlement | Corrected decision with higher decision_version; original preserved |
| Reversal invalidates prior qualification | not_qualified correction; central handles reward reversal |
| Merchant closes mid-period | Tenant-closed event emitted; open period evaluated per rule (typically not_qualified: disqualifying closure) |
| Rule changes during open period | Rule versions apply to future periods only; open period evaluated under the version in force at period start |

### 39.7 Reporting and exports

| Case | Expected behavior |
|---|---|
| Report crosses branch scopes | Rows limited to viewer's scope; cross-branch totals only for tenant-scope viewers |
| User loses permission during export generation | Download blocked at fetch-time re-check; artifact expired |
| Export contains deleted or masked fields | Masking applied at generation; anonymized subjects appear anonymized; no resurrection of purged data |
| Very large report | EXPORT_TOO_LARGE with scheduling path; scheduled generation with notification |
| Timezone boundary at month-end | Business dates computed in Africa/Nairobi; boundary rows labeled; UTC storage prevents drift |
| Currency formatting inconsistency | Single tenant currency at launch; minor-unit storage; centralized formatting |

---

## 40. In-Scope and Out-of-Scope Capabilities

### 40.1 In scope (launch)

1. Merchant multi-tenancy with absolute isolation.
2. Branch-aware commerce (branch lifecycle, branch-scoped operations, HQ roll-up).
3. Role-governed access: Super Administrator, Merchant Administrator, Branch, HR, Finance, Cashier, Inventory, Personnel, Growth, CX, Audit, End User; machine identities.
4. Magic-link authentication for all merchant users; OTP authentication for End Users; active-membership verification; session governance.
5. Merchant self-registration, KYC-supported onboarding, referral-code capture.
6. Catalogue: products, services, variants, bundles, modifiers, barcodes/QR, pricing with history, bulk import/export.
7. Inventory: locations, receipts, transfers, adjustments, counts, damage/expiry/wastage/shrinkage/write-offs, reorder alerts, suppliers (non-financial), movement immutability, concurrency safety.
8. In-store POS sales with shifts and mandatory End Shift reconciliation.
9. Merchant-branded digital storefront with orders, guest/registered checkout, merchant-managed fulfilment status.
10. Offline merchant-customer payment recording and Finance validation (evidence model; Section 19).
11. Customers and loyalty (merchant-scoped profiles, append-only loyalty ledger, tiers, expiry, fraud controls).
12. Promotions, coupons, discount governance.
13. Staff operations: profiles, scheduling, attendance, leave, KPIs, payroll preparation (no disbursement).
14. Finance records: invoices, receipts, refund records, expenses, cash-up, period locks, operational reports.
15. Subscription plans, entitlements, invoices, billing lifecycle; collection exclusively through Wallet by Citrus.
16. Citrus Refer & Earn source-product integration (events, snapshot, qualification decisions, reconciliation).
17. Reporting, analytics, scope-safe search, governed exports.
18. Notifications (in-app, email, SMS for approved cases).
19. Files, media, imports, exports with security controls.
20. Audit trail (append-only, hash-chained) and Audit role surfaces.
21. Production security, privacy, observability, support, and operational readiness.

### 40.2 Out of scope (initial release)

1. End User-to-Merchant payment processing by Citrus.
2. Custody of merchant or customer funds.
3. Direct payment-provider credentials in Citrus.
4. Direct Safaricom or bank callbacks for subscription payments (Wallet owns them).
5. Cross-merchant marketplace aggregation, ranking, ratings, or comparison.
6. Citrus-operated delivery fleet or courier management.
7. Full ERP replacement (procurement, manufacturing, HR-payroll disbursement, asset management).
8. Full statutory accounting, tax filing, or double-entry general ledger claims.
9. Public Wallet by Citrus access for merchants or End Users.
10. Referrer reward calculation inside Citrus.
11. Referrer payout processing inside Citrus.
12. Peer-to-peer value transfer; lending; credit issuance; cryptocurrency.
13. Transaction-percentage or per-sale platform fees (superseded; Section 3.4).
14. Merchant-scoped public API credentials (future decision D-12).
15. Tenant merge.
16. Any feature found only in Servana and not authorized for Citrus (service sessions, healthcare workflows, Servana thresholds, etc.).

---

## 41. Product-Launch Readiness Requirements

Citrus is launch-ready only when all of the following are complete and verified. No launch dependency may rest on administrators editing database records, manually fabricating payment states, or using undocumented developer tools.

| Area | Launch requirement |
|---|---|
| Account onboarding | Every account type in Section 11 can be created, authenticated, and operated end-to-end |
| Role permissions | Full Section 12 matrix enforced and test-verified |
| Branch operation | Full branch lifecycle and branch-scoped operation working |
| Core commerce | POS sale, online order, quote-to-order, returns, voids, receipts complete |
| Offline payment records | Recording, validation, rejection, duplicate handling, receipts, cash-up complete |
| Subscription billing | Plans, invoices, Wallet registration, STK and PayBill/Till instruction flows, webhook application, recovery, reconciliation complete against Wallet production contract |
| Referral integration | Snapshot capture, event emission, qualification decisions, reconciliation verified against Refer & Earn contract |
| Notifications | All mandatory transactional/security notifications delivering on all launch channels |
| Reports | Section 27 catalogue available with correct scoping and masking |
| Audit evidence | Append-only trail, hash chain, Audit role surfaces, export integrity |
| Errors and edge cases | Sections 38–39 behaviors implemented and verified |
| Data migration/import readiness | Catalogue, customer (lawful), and opening-stock import templates validated at product-requirement level |
| Support procedures | Intake, case handling, investigation evidence paths documented and staffed |
| Incident response | Procedure documented, on-call defined, breach workflow tested |
| Backup and recovery | Backups running; restore tested to RPO/RTO objectives |
| Monitoring and alerting | Section 37 dashboards and alerts live |
| Security verification | Section 42 security testing completed with no unresolved critical/high findings |
| Accessibility verification | Section 35.4 checks passed on core flows |
| Responsive verification | Section 35.2 verified on all core surfaces |
| Browser support | Latest two major versions of mainstream evergreen browsers (Chrome, Safari, Firefox, Edge) on desktop and mobile |
| Legal documents | Terms, Privacy, Data-processing terms published and versioned |
| Privacy and consent | Section 34 workflows operational |
| Operational ownership | Named owners for platform operation, billing operations, integration operations, and security |
| Help and training | Merchant help content covering onboarding, selling, payments evidence, inventory, billing, and staff management |

---

## 42. Scope-Level Verification and Acceptance Requirements

This defines verification obligations for acceptance — not a test implementation plan.

### 42.1 Required verification categories

Functional acceptance; role and permission acceptance; tenant isolation; branch isolation; magic-link security; session revocation; subscription entitlement enforcement; Wallet contract verification (including duplicate and replay handling); Refer & Earn contract verification; offline payment-record integrity; inventory concurrency; order and sale integrity; audit completeness; file security; reporting accuracy; responsive behavior; accessibility; performance; recovery; data retention; privacy; security testing (including access-control-focused testing and dependency scanning).

### 42.2 Per-domain acceptance pattern

For each major domain (identity/membership, merchant/branch lifecycle, catalogue, inventory, POS/orders/storefront, payment evidence, loyalty/promotions, staff operations, finance records, subscription/Wallet, Refer & Earn, reporting/exports, notifications, files, audit):

1. **Positive acceptance cases:** every scoped workflow completes with correct records, states, side effects, notifications, and audit events.
2. **Negative acceptance cases:** invalid inputs, missing preconditions, and boundary values rejected with catalogued errors and no partial effects.
3. **Permission denials:** every denied cell of the Section 12 matrix verified as denied server-side.
4. **Cross-tenant denials:** foreign-tenant reads/writes/enumeration/exports denied with non-disclosure semantics.
5. **Cross-branch denials:** branch-scoped roles cannot reach unassigned branches by any channel.
6. **Invalid transition cases:** every state machine rejects undefined transitions.
7. **Duplicate and replay cases:** magic-link replay, sale resubmission, evidence duplicate references, Wallet event duplicates/out-of-order/reuse, R&E event duplicates and payload mismatch.
8. **Failure-recovery cases:** Wallet outage/timeout/unknown, R&E outage, queue failures, job dead-letter and replay, restore from backup.
9. **Evidence for sign-off:** executed verification records, isolation and permission matrices results, contract-verification results against Wallet and Refer & Earn environments, performance results against approved targets, security-testing report, accessibility report, and an edge-case coverage checklist mapped to Section 39.

### 42.3 Integration acceptance specifics

- **Wallet:** signature verification (valid/invalid/skewed/rotated keys), first-seen dedup, out-of-order handling, partial/over/underpayment application, UNKNOWN handling without blind retry, allocation reconciliation drift detection, recovery allowlist behavior, billing-only recovery vs operational suspension (payment never clears non-billing suspension).
- **Refer & Earn:** central-outage registration continuity with later idempotent confirmation, manual-code priority before lock, final-decision authority, same-version conflict quarantine, higher-version supersession, operational evidence not auto-qualifying, single earning attribution per tenant/product, unknown-merchant quarantine, late-evidence original-period handling, gap-detection replay.

---

## 43. Risk Register

Likelihood bands: Low (<10%), Medium (10–35%), High (>35%), stated against the assumption of the proposed launch scale (Section 36.1) and controls in this scope being implemented.

| # | Risk | Cause | Impact | Affected | Likelihood | Severity | Detection | Preventive control | Recovery control | Residual | Owner |
|---|---|---|---|---|---|---|---|---|---|---|---|
| R1 | Cross-tenant data leakage | Missed tenant scoping in a query/job/export | Legal, trust, regulatory breach | All merchants | Low | Critical | Isolation test suite; anomaly alerts | PR-3 controls; mandatory scoping; ID design | Incident response; breach notification; fix + audit | Low | Platform engineering owner |
| R2 | Shared-account misuse | Merchants sharing one login informally | Unattributable actions | Merchants | Medium | High | Concurrent-session anomalies; audit review | Named identities; per-user magic links; session visibility | HR recertification; forced resets | Medium-Low | Product + merchant governance |
| R3 | Incorrect branch scope | Misassignment or policy bug | Data exposure across branches | Large merchants | Medium | High | Branch isolation tests; audit sampling | Explicit per-membership scope; server checks | Scope correction; audit trail review | Low | Platform engineering owner |
| R4 | Inventory inconsistency | Concurrency bugs, unposted movements | Wrong stock, oversells | Merchants, End Users | Medium | Medium | Variance reports; negative-stock flags | Serialized movements; reservations; count workflows | Adjustments with approval; reconciliation | Medium-Low | Product owner (inventory) |
| R5 | Fraudulent offline payment recording | Staff records fake evidence | Revenue leakage, disputes | Merchants | Medium | High | Duplicate-reference detection; variance; anomaly flags | Finance validation; recorder≠validator; audit | Rejection workflow; disciplinary evidence | Medium-Low | Product owner (finance) |
| R6 | Wallet integration failure | Contract drift, outage, credential issues | Billing collection stalls | Citrus Labs, merchants | Medium | High | Integration health monitoring; webhook failure alerts | Contract verification; idempotency; status-query recovery | Queued retries; reconciliation; grace-pause fairness rule | Low | Integration owner |
| R7 | Duplicate subscription allocation | Event replay or race | Financial misstatement | Citrus Labs | Low | Critical | WALLET_PAYMENT_REUSED exception; nightly reconciliation | First-seen dedup; invoice-lock application | Exception queue linkage; correction events | Low | Integration owner |
| R8 | Refer & Earn event loss | Outbox gaps, delivery failures | Referrer non-payment disputes | Referrers, Citrus Labs | Medium | Medium | Dead-letter alerts; hourly gap reconciliation | Transactional outbox; retries; replay | Backfill via reconciliation API | Low | Integration owner |
| R9 | Subscription suspension errors | Grace/state bugs; payment applied to wrong dimension | Wrongful lockout or wrongful access | Merchants | Low | High | Billing-state audit; support signals | Independent status machines; PR-9 tests | Manual review; billing-state correction with audit | Low | Product owner (billing) |
| R10 | Large-merchant performance degradation | Volume beyond targets; unbounded queries | Slow operations at peak | Large merchants | Medium | Medium | Latency monitoring; slow-query alerts | Pagination, indexing, caching, queueing (S17) | Scaling; load shedding of deferrable work | Medium-Low | Platform engineering owner |
| R11 | SME usability overload | Enterprise controls surfacing for single-operator merchants | Abandonment | SMEs | Medium | Medium | Onboarding funnel metrics | Progressive configuration; defaults; guided onboarding | UX iteration; template presets | Medium-Low | Product owner (UX) |
| R12 | Audit gaps | Unlogged action paths | Failed investigations, compliance exposure | Merchants, Citrus Labs | Low | High | Audit completeness verification | Mandatory audit on all catalogued events; hash chain | Backfill impossible — prevention-focused; incident review | Low | Security owner |
| R13 | Privacy violations | Over-collection, masking failures, consent gaps | Regulatory penalties | End Users, staff | Medium | High | Privacy review; masking tests | Minimization; consent gating; masking defaults | Rights-request workflows; breach procedure | Low | Compliance owner |
| R14 | Incomplete role definitions in operation | Real merchants need permissions not modeled | Workarounds, shadow sharing | Merchants | Medium | Medium | Support signal analysis | Explicit matrix + configurable authority settings | Controlled matrix extension with audit | Medium-Low | Product owner |
| R15 | Conflicting source documents re-emerging | Future edits citing superseded sources | Requirement regressions | All | Medium | Medium | Register-based review discipline | Section 45 register; single-authority rule | Scope amendment process | Low | Document owner |

---

## 44. Product Decision Register

Unresolved decisions that cannot be safely inferred. None of these block the internal consistency of this scope; each blocks a specific launch configuration.

| ID | Question | Why it matters | Source gap | Options | Recommended | Consequences | Owner | Gate |
|---|---|---|---|---|---|---|---|---|
| D-01 | Is Super Administrator approval required for **all** merchant onboarding or only risk-flagged registrations? | Onboarding speed vs platform control | S4 shows approval flows; S3/S5 show self-registration to active | (a) approve all; (b) auto-activate with risk-flag review | (b) auto-activate + risk review | (a) slows activation; (b) needs risk rules | Product owner | Before launch |
| D-02 | Abandoned-registration expiry period | Data hygiene, re-registration behavior | Not specified | 30/60/90 days | 60 days | Affects duplicate detection window | Product owner | Before launch |
| D-03 | Dormancy-to-archival period after prolonged billing suspension/cancellation | Replaces superseded "delete after 6 months" | Superseded rule removed | 6/12/24 months to archival (never hard delete within statutory window) | 12 months | Storage vs merchant return experience | Product + legal | Before launch |
| D-04 | Plan structure: names, prices, trial length, entitlement values, billing intervals (monthly only vs +annual), upgrade proration | Core commercial offer | No subscription plan definitions exist in any source | Define plan matrix commercially | 3-tier plan + 14-day trial as starting hypothesis | Blocks billing configuration, not mechanism | Commercial owner | Launch gate |
| D-05 | Batch/lot/expiry tracking depth at launch | Perishable/pharma merchants | S3/S9 support expiry reasons only | (a) reasons + batch reference + expiry alerts; (b) full batch ledger with FEFO | (a) at launch, (b) fast-follow | (b) increases inventory complexity for all | Product owner (inventory) | Before launch |
| D-06 | Tax treatment on Citrus subscription invoices (VAT) | Invoice correctness | Not addressed | Per Kenyan tax advice | Follow tax counsel | Legal exposure if wrong | Finance + legal | Launch gate |
| D-07 | Actions that must never be single-operator (SME fallback exclusions) | Fraud control vs SME usability | Not specified | Fixed list: period reopen, manual loyalty adjustment, write-off above threshold | As listed in Section 12.4 | Excluded actions unavailable to true single-operator merchants without support involvement | Product owner | Before launch |
| D-08 | CX communication cost model (merchant-provided provider accounts vs Citrus-resold bundles as plan entitlements) | Replaces superseded "airtime invoice" mechanism | S3 mechanism tied to superseded billing model | (a) merchant provider accounts; (b) plan-entitled message bundles | (b) plan-entitled bundles | (a) adds merchant setup burden; (b) requires bundle pricing | Commercial owner | Before CX messaging enablement |
| D-09 | Wallet product registration for Citrus (product code, payment-reference prefix, application credentials, routes) | Required before any subscription collection | Wallet registry lists Kikao/Servana/SkillFlow only | Register Citrus via Wallet's controlled onboarding | Proceed; prefix assigned by Wallet registry | Blocks billing go-live | Integration owner | Launch gate |
| D-10 | Citrus active-use qualification thresholds (N completed sales, M validated payment records) and clearing grace days | Referral qualification fairness | R&E scope has no Citrus rule; thresholds must not be invented | Candidate: N=10 sales, M=3 validated payments, grace 5 days — requires approval and central registration | Approve candidate or adjust | Blocks referral campaign activation, not Citrus launch | Product owner + R&E owner | Before campaign activation |
| D-11 | Legal review package: Kenya DPA registration/obligations, statutory retention periods (financial, employment), cross-border hosting, e-receipt/tax recording obligations | Compliance correctness | Scope defines controls, not legal positions | Engage counsel | Engage before launch | Launch risk if deferred | Compliance owner | Launch gate |
| D-12 | Merchant-scoped public API credentials | Ecosystem openness | Not in sources | (a) none at launch (current position); (b) read-only export API | (a) | (b) adds attack surface + support load | Product owner | Post-launch review |
| D-13 | Approval of proposed performance/scale targets and SLOs (Section 36) | Sizing and operations budget | No numeric targets in sources | Approve/adjust bands | Approve as proposed | Drives infrastructure cost | Product + engineering owners | Before launch |
| D-14 | Future support-impersonation ("break-glass") capability | Support efficiency vs privacy | Not in sources | (a) never; (b) consent-based break-glass with elevated audit | (b) as future scope, not launch | (a) slower support for access-loss cases | Product + security owners | Post-launch |
| D-15 | End Shift cash-variance tolerance and escalation thresholds | Operational fairness | S3/S8 require notes on variance, no thresholds | Merchant-configurable with platform default | Merchant-configurable, default zero-tolerance-with-note | Affects Finance workload | Product owner (finance) | Before launch |

---

## 45. Contradiction and Supersession Register

| # | Conflicting statements | Controlling source | Resolved rule | Propagated to |
|---|---|---|---|---|
| C1 | S1/S2/S3/S4/S5/S7: per-transaction service fee (10% or fixed), weekly invoices, customer-price uplift, module locks, deletion after 6 months ↔ SR-3/SR-4 subscription-only launch | Settled rules | Launch monetization is merchant subscription via Wallet; no transaction fees; billing enforcement per Section 20; archival replaces deletion (D-03) | §§3.4, 8.2, 14.5, 20, 40.2 |
| C2 | S1/S2/S3/S7/S8: direct M-PESA/PesaLink validation, STK initiation, provider settlement-feed matching for merchant sales ↔ SR-1/SR-2 off-platform payments | Settled rules | Merchant-customer payments are off-platform; Citrus records/validates evidence only; merchant-supplied statement imports allowed; no provider integration for merchant sales | §§19, 18, 26 |
| C3 | S2/S3/S5–S10: OTP login for merchant users; S3: Merchant Administrator password+OTP/MFA ↔ SR-11 magic-link | Settled rules | All merchant users authenticate via magic link; no merchant passwords; OTP retained for End Users only | §13 |
| C4 | S4: Super Administrator "Add New Merchant (manual, internal)" ↔ merchant self-registration rule | Settled rules | Merchants are created only by self-registration; Super Administrator approves/oversees where required | §§7.1(11.1), 14 |
| C5 | Branch Account as shared login surface (`branch.citrus.ke`, S1/S2) ↔ S3 named governance user ↔ SR-9/SR-12 | Settled rules + S3 | Branch = business unit; Merchant Branch role = named human(s); no shared credentials | §§11.3, 15 |
| C6 | S3: Merchant Administrator sole creator of all staff ↔ S3/S5–S10: HR (or HR/Admin) creates staff; CX creatable by Branch | Detailed account files + settled HR rule | Administrator creates first HR; HR provisions staff within approved structure; Branch creates staff only when no HR exists; CX provisioning delegable to Branch by audited policy | §§11.4, 13.3 |
| C7 | Super Administrator merchant control (credential resets, cross-merchant customer actions, fee-setting) ↔ merchant operational independence | Settled rules | Super Administrator authority is regulatory and purpose-limited (Section 10.3); staff attributes remain merchant-owned; fee-setting replaced by plan governance | §§10.3, 11.1 |
| C8 | HR scope "governs all branches" ↔ HR pages "branch-scoped" (S3) | Resolution in this scope | HR scope is a per-membership attribute (tenant-wide or branch-scoped) | §11.4 |
| C9 | Finance merchant-wide truth ↔ "Finance is branch-scoped; multi-branch consolidation excluded" (S3/S7) | Resolution in this scope | Finance scope is per membership; merchant-wide Finance consolidates, branch-scoped does not | §11.6 |
| C10 | Pricing authority: Inventory read-only ↔ Growth sets prices ↔ Admin overrides (S3/S5/S9) | Detailed files harmonized | Pricing authority model of Section 16.5 (Administrator default; assignable to Finance/Growth; Inventory never) | §16.5 |
| C11 | Super Administrator sessions: OTP + 5-minute timeout (S1/S2/S4 landing) ↔ magic link + 15-minute idle/4-hour session (S4 Get Started/Profile) | S4 authoritative auth spec | Magic link; 15-minute idle; 4-hour session | §13.5 |
| C12 | Merchant session timeout 10 minutes (S1/S2) ↔ various/unspecified (S5–S10) | S1/S2 value adopted | 10-minute idle merchant sessions with role-appropriate maximums | §13.5 |
| C13 | Overdue enforcement: >10 days (S5 dashboard) ↔ >30 days (S5 finance) ↔ staff lock at 3+ days (S4) | Superseded family | Entire fee-enforcement cascade replaced by subscription grace model (Section 20.2); thresholds set with plan configuration (D-04) | §20 |
| C14 | S3 Customer profile text "this is a staff account within a Branch" | Editorial defect | Disregarded; End User is not staff | §11.12 |
| C15 | S8 Cashier introduction describes inventory duties | Editorial defect | Disregarded; Cashier is the POS execution role | §11.7 |
| C16 | Marketing percentages/outcome claims (85–90%, <1%, ~90–93%, uptime claims) | SR-13 | Excluded as unverified; performance targets are proposed values in Section 36 | §§6.2, 36 |
| C17 | CX airtime purchase invoiced by Citrus (S3) ↔ subscription-only monetization | Settled rules | Replaced by D-08 communication cost model | §§11.11, 44 |
| C18 | R&E scope snake_case event names ↔ R&E plan dot-notation transport names | S14 governs semantics | Business contract uses scope names; transport naming aligned with central schema registry at integration | §22.3 |
| C19 | Refer & Earn "merchant product tenant merged" event ↔ Citrus has no tenant merge | Product fact | Merge events not emitted; merge out of scope | §§22.3, 40.2 |
| C20 | S17 baseline "at least email/password login" ↔ SR-11 magic-link | S17 defers to project scope ("Specific login method depends on the project scope") | Magic link for merchant users; OTP for End Users | §13 |

---

## 46. Traceability Matrix

Requirement identifiers reference this document's sections; acceptance conditions reference Section 42 categories. Conflict-resolution references point to Section 45.

| Req ID | Requirement summary | Governing source | Account/module | Actor | Acceptance | Conflict ref |
|---|---|---|---|---|---|---|
| REQ-001 | Multi-tenant isolation (no cross-tenant access/inference) | S17 §2–3; S1/S2 | Platform | All | Tenant-isolation suite | — |
| REQ-002 | Branch-aware execution and attribution | S1/S2/S3 | Branch/commerce | Merchant roles | Branch-isolation suite | C5 |
| REQ-003 | Merchant self-registration creates root Administrator | S3/S5 | Onboarding | Registrant | Functional acceptance §14 | C4, C6 |
| REQ-004 | Magic-link authentication for merchant users | Settled SR-11; S4 pattern | Auth | Merchant users | Magic-link security tests | C3, C11, C20 |
| REQ-005 | Active-membership verification pre- and in-session | S3 (membership model); this scope §13.2 | Auth | System | Session/permission tests | — |
| REQ-006 | End-User OTP authentication, trusted devices | S3/S11 | End User | End User | Auth tests | — |
| REQ-007 | Role-permission matrix with maker-checker and step-up | S3/S5–S10; S17 §5 | Authorization | All | Role/permission acceptance | C6–C10 |
| REQ-008 | Branch business unit + named Branch role; Administrator lifecycle authority; HR membership provisioning | SR-9/SR-12; S3 | Branch | Admin/HR | Functional + permission tests | C5, C6 |
| REQ-009 | HR staff lifecycle, access windows, leave-driven holds, recertification | S3/S6 | HR | HR | Functional acceptance | C8 |
| REQ-010 | Audit read-only, hash-chained trail, integrity exports | S3/S10 | Audit | Audit | Audit completeness | — |
| REQ-011 | Finance validation of off-platform payment evidence; recorder≠validator | Settled SR-1/2; S7/S3 | Finance/payments | Finance | Payment-record integrity | C2 |
| REQ-012 | Cashier POS execution, shift sessions, mandatory End Shift | S3/S8 | POS | Cashier | Order/sale integrity | C15 |
| REQ-013 | Inventory movements immutable, attributable, concurrency-safe | S3/S9 | Inventory | Inventory | Inventory concurrency tests | — |
| REQ-014 | Catalogue with variants, pricing history, authority model | S3/S5/S9 | Catalogue | Admin/Inventory/Growth | Functional acceptance | C10 |
| REQ-015 | Storefront: merchant-branded, branch-locked, no marketplace | S3/S11; S1/S2 boundary | Storefront | End User | Functional + boundary tests | — |
| REQ-016 | Off-platform payment boundary: record/validate only; prohibited capabilities | Settled SR-1/SR-2 | Payments | All | Payment-record integrity; route-absence checks | C2 |
| REQ-017 | Payment-evidence states and recorded≠validated≠settled distinction | This scope §19.4 | Payments | Finance/Cashier | State-machine tests | C2 |
| REQ-018 | Subscription plans, entitlements, invoices, billing lifecycle | Settled SR-4/SR-6; Servana pattern (S16, reference) | Billing | Admin/system | Entitlement enforcement tests | C1, C13 |
| REQ-019 | Wallet-only subscription collection; no provider logic in Citrus | S12 (controlling); SR-3/SR-5 | Wallet integration | Machine | Wallet contract verification | — |
| REQ-020 | Signed idempotent Wallet webhooks; first-seen dedup; UNKNOWN handling; no blind retry | S12/S13 | Wallet integration | Machine | Duplicate/replay/unknown tests | — |
| REQ-021 | Payment never clears non-billing suspension | S16 pattern; PR-9 | Billing | System | W-21-class test | — |
| REQ-022 | Exception resolution by Wallet-payment linkage only (no manual recording) | S16 pattern; S12 | Billing ops | Super Admin | Route-absence + linkage tests | — |
| REQ-023 | Referral capture non-blocking; immutable snapshot; async confirmation | S14 | R&E integration | Registration | Central-outage tests | — |
| REQ-024 | Signed idempotent versioned R&E events with outbox-equivalent delivery | S14/S15 | R&E integration | Machine | R&E contract verification | C18 |
| REQ-025 | Citrus-owned monthly active-use qualification with versioned corrections | S14; SR-8 | Qualification | System | Qualification tests | — |
| REQ-026 | Data minimization in both integrations | S12/S14 | Integrations | Machine | Payload schema verification | — |
| REQ-027 | Loyalty append-only ledger; approvals for manual adjustments | S3 | Loyalty | Growth/Admin | Functional + audit tests | — |
| REQ-028 | Promotions with limits, stacking rules, approvals, versioning | S3 | Growth | Growth/Admin | Functional acceptance | — |
| REQ-029 | Staff operations incl. payroll preparation only (no disbursement) | S3/S6 | HR | HR | Functional + boundary tests | — |
| REQ-030 | Financial records, cash-up, period locks, operational labeling | S3/S7/S8 | Finance | Finance | Reporting accuracy | — |
| REQ-031 | Role-scoped reporting catalogue; scope-safe search; governed exports | S3/S5–S10 | Reporting | All | Reporting accuracy; export permission tests | — |
| REQ-032 | Notification catalogue, mandatory transactional messages, consent | S3/S5–S11 | Notifications | System | Functional acceptance | — |
| REQ-033 | File security: signed URLs, scanning, retention, legal hold | S17 §6 | Files | All | File security tests | — |
| REQ-034 | Machine identity, rotation, environment separation, rate limits | S12/S14/S17 | API/integration | Machine | Security + contract tests | — |
| REQ-035 | Domain ownership and immutability classes | This scope §31 | Data | — | Retention/deletion tests | — |
| REQ-036 | State-machine catalogue with rejected invalid transitions | This scope §32 | All | All | Invalid-transition tests | — |
| REQ-037 | Threat-model controls (Section 33) | S17 §6; this scope | Security | — | Security testing | — |
| REQ-038 | Privacy controls, rights workflows, retention, breach procedure | S17; Kenya DPA (legal review D-11) | Privacy | Compliance | Privacy verification | — |
| REQ-039 | Design system, responsive breakpoints, dark mode, WCAG 2.2 AA, form rules | S17 §§10–16 | UI/UX | — | Responsive + accessibility verification | — |
| REQ-040 | Performance/reliability targets and outage behavior (Wallet/R&E degradation rules) | S17 §17; this scope §36 | Platform | — | Performance + recovery tests | — |
| REQ-041 | Observability, audit record content, incident management | S17 §18; S3/S4 | Operations | Ops | Audit completeness; ops runbook review | — |
| REQ-042 | Deterministic error catalogue | This scope §38 | All | All | Negative acceptance | — |
| REQ-043 | Edge-case behaviors | This scope §39 | All | All | Edge-case checklist | — |
| REQ-044 | Launch-readiness checklist | SR-10 | Launch | All owners | Section 41 evidence | — |
| REQ-045 | SME single-human multi-role operation without role conflation | SR (Section 9.3) | Authorization | SME merchants | Multi-role acceptance | — |
| REQ-046 | Progressive configuration (one product, both scales) | Settled; S1/S2 intent | Product | — | SME + enterprise scenario acceptance | — |
| REQ-047 | Super Administrator purpose-limited authority; no merchant operations | S4; settled | Platform governance | Super Admin | Permission + boundary tests | C4, C7 |
| REQ-048 | End-User cross-merchant identity with per-merchant isolation | S3/S11; this scope §23.1 | Customers | End User | Isolation tests | — |

---

## 47. Final Product Acceptance Criteria

The Citrus Platform is acceptable for production launch only when **all** of the following are true, evidenced per Section 42:

1. It operates as a multi-tenant, branch-aware, role-governed commerce platform meeting every requirement of Sections 10–32.
2. Tenant and branch isolation are verified at data, application, API, export, notification, and search levels.
3. All merchant users authenticate exclusively by magic link with the controls of Section 13; End Users authenticate by OTP; active-membership verification is enforced continuously.
4. Every account type in Section 11 is fully operable with its defined purpose, capabilities, restrictions, scope, creation authority, lifecycle, and audit obligations — including the Merchant Branch Account and named individual identities throughout.
5. Merchant-customer payments are demonstrably off-platform: no provider credentials, callbacks, or STK initiation for merchant sales exists anywhere in the product; recording/validation behaves per Section 19 in every workflow, report, and export.
6. The only product money movement is Merchant-to-Citrus subscription payment through Wallet by Citrus, verified against the Wallet contract, including duplicate, replay, out-of-order, unknown-state, partial/over/underpayment, reversal, and reconciliation cases.
7. A subscription payment never clears a non-billing suspension.
8. Refer & Earn integration passes contract verification: non-blocking registration, immutable snapshot, signed idempotent events, qualification-decision authority with versioned corrections, reconciliation, and data minimization.
9. Subscription entitlements are enforced identically across UI, API, background operations, imports, exports, and integrations.
10. Both an SME (single human, single branch) and a large merchant (many branches, separated teams, maker-checker) complete full operational scenarios without product changes.
11. The deterministic error catalogue and edge-case behaviors are implemented and verified.
12. Security, privacy, accessibility, responsiveness, performance, recovery, and observability requirements pass their verification categories with no unresolved critical or high findings.
13. All launch-readiness items in Section 41 are complete, including legal documents, support procedures, backups with tested restores, monitoring, and merchant help content.
14. The Decision Register items gated "Launch gate" (D-04, D-06, D-09, D-11) are resolved and configured.
15. No launch operation depends on database edits, fabricated payment states, or undocumented tools.

---

## 48. Final Completeness Checklist

| # | Requirement on this document | Status |
|---|---|---|
| 1 | Is a project scope, not a Software Development Plan (no phases, sprints, estimates, repo/file/code instructions) | ✅ |
| 2 | Includes the Purpose of the SaaS Web Application (Section 5) | ✅ |
| 3 | Incorporates every file in the source directory with recorded classification (Section 3.1), including non-governing files with reasons | ✅ |
| 4 | Includes Merchant Branch Account requirements (Sections 11.3, 15) | ✅ |
| 5 | Includes all essential account users found in the files (Super Administrator, Merchant Administrator, Branch, HR, Audit, Finance, Cashier/Front Office, Inventory, Personnel, Growth, CX, End User, machine identities) | ✅ |
| 6 | Every role has purpose, capabilities, restrictions, scope, creation authority, lifecycle, and audit obligations | ✅ |
| 7 | Account-creation contradictions resolved (C4–C6) | ✅ |
| 8 | Individual named identities required; shared branch credentials prohibited | ✅ |
| 9 | Magic-link login defined for Merchant account users (Section 13.1) | ✅ |
| 10 | Active-membership verification defined (Section 13.2) | ✅ |
| 11 | Supports both SMEs and large merchants via progressive configuration, one product (Section 9) | ✅ |
| 12 | States that merchant-customer payments are off-platform and Citrus processes no End User-to-Merchant payments (Section 19) | ✅ |
| 13 | Limits money movement to Merchant-to-Citrus subscription payments via Wallet (Sections 20–21) | ✅ |
| 14 | Wallet precedence for payment orchestration; Refer & Earn precedence for referral functions (Sections 3.2, 21, 22) | ✅ |
| 15 | Servana used only as integration-pattern reference; no Servana business rules imported | ✅ |
| 16 | Direct-provider logic removed from Citrus | ✅ |
| 17 | Signed, idempotent Wallet and Refer & Earn interactions defined | ✅ |
| 18 | System-of-record ownership defined (Sections 21.1, 22.1, 31) | ✅ |
| 19 | Modules, workflows, state machines, errors, and edge cases defined (Sections 16–32, 38–39) | ✅ |
| 20 | Security, privacy, compliance, audit, accessibility, performance, reliability, and production-launch requirements defined (Sections 33–37, 41) | ✅ |
| 21 | Explicit in-scope and out-of-scope lists (Section 40) | ✅ |
| 22 | Contradiction register (45), decision register (44), risk register (43), traceability matrix (46) present | ✅ |
| 23 | Internally consistent; superseded wording removed rather than duplicated | ✅ |
| 24 | No unsupported assumptions; unresolved thresholds and legal positions held in the Decision Register | ✅ |
| 25 | Detailed enough to serve as the authoritative input for a future separate Software Development Plan | ✅ |

---

*End of document.*




