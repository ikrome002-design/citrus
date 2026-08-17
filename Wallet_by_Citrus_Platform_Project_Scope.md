# Wallet by Citrus

## Platform Project Scope

**Product owner and operator:** Citrus Labs Limited
**Product name:** Wallet by Citrus
**Document type:** Platform Project Scope and Product Technical Specification (complete replacement, incorporating the First-Launch Critical Additions and the PesaPal / merchant-finance enhancement requirements)
**Document version:** 2.0
**Architecture classification:** Single legal entity; multiple Citrus products; multiple applications; multiple environments; multiple product merchant accounts; multiple banks; multiple provider accounts; multiple payment gateways; multiple settlement routes; multiple payout funding sources; internal multi-tenant-grade data isolation
**Primary legal entity:** Citrus Labs Limited
**Initial integrated Citrus Labs products:** Kikao, Servana, and SkillFlow
**Future integration scope:** Any additional SaaS web application created, owned, and operated by Citrus Labs Limited
**Primary first-launch dependency:** Servana collections and merchant-payment integration
**Primary first-launch payment provider addition:** PesaPal, subject to signed commercial, technical, compliance, and settlement approval
**Primary jurisdictional context:** Kenya
**Default currency:** KES
**Time zone for operational business dates:** Africa/Nairobi
**Intended deployment status:** Product-launch-ready production platform

---

# 1. Document Purpose

This document defines the complete project scope, product boundaries, operating model, functional requirements, technical architecture, security controls, financial controls, data model, integration model, merchant-finance model, user experience, error-handling requirements, edge-case handling, testing requirements, deployment requirements, launch operations, and launch acceptance criteria for **Wallet by Citrus**.

Wallet by Citrus shall be created and operated exclusively by **Citrus Labs Limited**. It shall provide a centralized financial operations layer for Citrus Labs Limited's SaaS products, beginning with Kikao, Servana, and SkillFlow, and extending to future Citrus Labs Limited products without requiring each product to independently implement, secure, reconcile, and operate its own payment-provider integrations.

This document is a self-contained, independently complete specification. It incorporates, in full, the requirements previously distributed across the baseline project scope, the baseline software development plan's scope-relevant content, the PesaPal and merchant-finance enhancement requirements, and the First-Launch Critical Additions amendment. No reader is required to consult any predecessor document.

This document is normative. The words **shall**, **must**, **shall not**, and **must not** define mandatory product requirements. The words **should** and **may** define recommended or optional requirements that require an explicit product decision before implementation.

The platform shall follow the engineering and product standards established in Product Technical Details v.2, adapted to the actual ownership model of Wallet by Citrus: one legal entity, multiple Citrus Labs products, multiple product merchant accounts, multiple human users, multiple machine applications, multiple payment gateways, multiple provider accounts, multiple provider merchant and sub-merchant identities, multiple Citrus Labs bank accounts, and multiple independent merchant settlement destinations.

---

# 2. Authority and Source-of-Truth Rules

1. This project scope is the authoritative statement of product behaviour, platform boundaries, functional requirements, business rules, financial rules, security controls, operational requirements, and acceptance criteria for Wallet by Citrus.
2. The companion document `Wallet_by_Citrus_Software_Development_Plan.md` (version 2.0) is the authoritative engineering translation of this scope. It shall not introduce product behaviour absent from or inconsistent with this scope.
3. Where this scope and the development plan appear to conflict, this scope controls product behaviour and the development plan controls implementation sequencing; a genuine conflict shall be recorded as a blocking decision and resolved before implementation of the affected requirement.
4. Requirement classifications used throughout this document:
   - **Confirmed requirement** — mandatory, buildable, and launch-required without external dependency.
   - **Contract-dependent capability** — designed and documented, but activation requires a signed provider contract and/or production onboarding evidence.
   - **Legally gated capability** — designed and documented, but activation requires recorded legal, compliance, tax, accounting, or executive approval.
   - **Technically prepared capability** — structural readiness only; no activation at first launch.
   - **Conditional first-launch capability** — may launch only where its contract-dependent and legally gated conditions are proven.
   - **Post-launch capability** — deliberately deferred beyond first launch.
   - **Disabled capability** — implemented or implementable but held behind a default-off control that requires a defined activation gate.
   - **Out-of-scope capability** — expressly excluded (Section 112).
5. No provider capability, banking capability, PesaPal API, M-PESA capability, regulatory permission, settlement guarantee, real-time payout capability, split-settlement capability, merchant-onboarding API, or legal conclusion shall be assumed. Capability shall be recorded per provider account and per provider merchant account from contract and test evidence (Sections 28–30).
6. Unresolved blocking decisions are catalogued in Section 118.4 and in the development plan's blocking-ambiguity register. No production route affected by a blocking decision shall activate until the decision is resolved and recorded.

---

# 3. Product Definition

Wallet by Citrus shall be a centralized, API-first financial orchestration and treasury operations platform for Citrus Labs Limited's SaaS products, providing payment orchestration, treasury operations, transaction control, economic-ownership modelling, merchant-finance operations, ledger, allocation, commission, settlement, reconciliation, reporting, refund, reversal, chargeback, case-management, and disbursement capability.

It shall coordinate financial instructions and financial data across:

1. Citrus Labs Limited products.
2. Product environments, including sandbox, staging, user acceptance testing, and production.
3. Merchant accounts that exist inside the integrated Citrus Labs products.
4. Provider merchant and sub-merchant identities registered with payment providers for those merchants.
5. Payment gateways and payment service providers, including Safaricom Daraja and PesaPal.
6. M-PESA collection and disbursement facilities.
7. PesaLink and bank-transfer facilities.
8. Direct bank APIs and host-to-host bank integrations.
9. Card, mobile money, bank, and other approved collection methods.
10. Citrus Labs Limited bank accounts.
11. Independent merchant settlement destinations verified for provider settlement.
12. Provider wallets, clearing balances, prefunded balances, and payout accounts.
13. Internal accounting ledgers, allocations, commissions, fees, taxes, and reserves.
14. Reconciliation statements and bank, provider, settlement, fee, refund, chargeback, and reserve records.
15. Product-facing APIs and signed webhooks.
16. Internal Citrus Labs finance, treasury, risk, compliance, support, engineering, audit, and administrative workflows.

Wallet by Citrus shall not operate as a public payment service for unrelated companies. It shall not permit public merchant self-registration. It shall not onboard an unrelated business as a Wallet by Citrus tenant. It shall not provide general stored-value transfers between unrelated users. It shall not represent internal ledger balances as bank deposits or safeguarded funds unless the legal, accounting, banking, and regulatory structure expressly supports that representation.

Wallet by Citrus shall remain an internal Citrus Labs financial control plane. It shall not be redefined as: a public consumer wallet; a public stored-value wallet; a peer-to-peer payment platform; an unrelated-company payment service; a public merchant marketplace; a public merchant-registration platform; a bank; an escrow service; a deposit-taking service; a lending platform; a cryptocurrency platform; a general cross-border remittance platform; or a general arbitrary payout platform.

Merchant accounts originating in Servana, Kikao, SkillFlow, or another Citrus product remain product-scoped identities and financial dimensions. They do not become unrelated public Wallet tenants merely because provider merchant or sub-merchant records are introduced.

---

# 4. Product Vision

Wallet by Citrus exists so that Citrus Labs Limited operates one secure, reliable, auditable, and scalable control plane for all payment and treasury activity generated by its SaaS products, in which:

1. Every shilling that moves is attributable to a product, a merchant account, an economic purpose, an economic beneficiary, a funds-flow model, a provider route, and a settlement destination.
2. Money economically owed to a merchant is never conflated with Citrus Labs revenue, and money owed to Citrus Labs is never commingled with merchant customer funds.
3. Payment success, merchant settlement, provider settlement, and reconciliation remain separate, independently evidenced states.
4. The regulated funds intermediary for customer-to-merchant payments remains an authorised payment service provider (at first launch, PesaPal, subject to contract), while Wallet remains the orchestration, ledger, routing, control, and reconciliation layer.
5. New Citrus products, providers, provider accounts, bank accounts, currencies, and routes are added through configuration and controlled approval, not structural redevelopment.

---

# 5. Product Objectives

The platform shall solve the following operational problems:

1. Prevent every Citrus Labs product from independently registering and managing the same payment-provider callbacks.
2. Prevent conflicting callback ownership for a shared M-PESA PayBill, shortcode, or PesaPal IPN registration.
3. Provide one authoritative transaction record for all collections, refunds, reversals, payouts, merchant settlements, chargebacks, and internal transfers.
4. Route transactions to the correct Citrus Labs product and merchant account using structured references and immutable identifiers.
5. Show precisely which product uses which payment gateway, provider account, provider merchant account, merchant identifier, collection settlement account, merchant settlement destination, payout funding source, depositor bank account, and bank name.
6. Permit collections to settle into different verified Citrus Labs Limited bank accounts, subject to provider configuration and commercial onboarding.
7. Permit customer-to-merchant collections to settle directly to independent verified merchant settlement destinations through the provider, without Citrus Labs receiving or controlling the merchant's funds, where that is the applicable funds-flow model.
8. Permit payouts to originate from different verified Citrus Labs Limited bank accounts, provider wallets, or disbursement facilities, subject to the technical capabilities and contractual permissions of each bank or provider.
9. Separate product economics and merchant economics even when products or merchants share the same PayBill, provider account, bank account, or payout facility.
10. Prevent duplicate credits, duplicate refunds, duplicate payouts, duplicate settlements, and blind failover after an ambiguous provider response.
11. Support single and bulk payouts with maker-checker approval controls.
12. Support full and partial refunds without exceeding the remaining refundable amount, with a defined refund-funding party for every route.
13. Support provider reversals where eligible while treating reversals as asynchronous and non-guaranteed.
14. Maintain an immutable double-entry ledger, with explicit merchant-payable and marketplace posting templates, as the internal financial source of truth.
15. Reconcile internal transaction, allocation, commission, fee, settlement, reserve, and chargeback records against payment-provider records, provider statements, settlement reports, merchant statements, bank statements, and transaction-status queries.
16. Provide signed, retryable product webhooks so Kikao, Servana, SkillFlow, and future Citrus products receive authoritative transaction updates.
17. Provide internal dashboards, alerts, reports, merchant statements, audit trails, exception queues, case management, daily close, and operational controls.
18. Enable Citrus Labs Limited to add future products, gateways, provider accounts, provider merchant accounts, bank accounts, settlement destinations, currencies, and financial routes through configuration rather than hard-coded product logic.
19. Answer, from immutable evidence, the thirty launch-standard questions in Section 121.2 for every transaction.

---

# 6. Ownership and Legal-Entity Boundary

Wallet by Citrus shall use the following ownership hierarchy:

```text
Citrus Labs Limited
    Wallet by Citrus
        Kikao
            Sandbox application
            Staging application
            Production application
            Product merchant accounts
        Servana
            Sandbox application
            Staging application
            Production application
            Product merchant accounts
                Provider merchant / sub-merchant identities (per provider)
                Merchant settlement destinations (merchant-owned, provider-verified)
        SkillFlow
            Sandbox application
            Staging application
            Production application
            Product merchant accounts
        Future Citrus Labs SaaS products
            Product-specific applications
            Product merchant accounts
```

The architecture shall retain a `legal_entity` domain object even when the initial database contains only Citrus Labs Limited. This preserves explicit ownership, supports financial reporting, and avoids destructive schema changes should Citrus Labs Limited later operate a product under a subsidiary or another approved legal structure.

The platform shall maintain logical separation at the following levels:

1. Legal entity.
2. Product.
3. Product application.
4. Environment.
5. Product merchant account.
6. Provider merchant account.
7. Merchant settlement destination.
8. Human user membership.
9. Machine credential.
10. Provider account.
11. Bank account.
12. Ledger account.
13. Payment route.
14. Financial transaction, allocation, settlement, reserve, chargeback, and case.

No integrated product shall be able to read, infer, enumerate, modify, refund, reverse, settle, or pay out another product's transaction without an explicit, audited, privileged Wallet by Citrus administrative workflow.

No product merchant account shall be able to read, infer, enumerate, modify, refund, reverse, settle, or pay out another merchant account's transaction, settlement, reserve, statement, or provider merchant identity merely because both merchant accounts belong to the same Citrus Labs product.

## 6.1 Cross-Product Ownership Boundary

**Wallet by Citrus shall own:** provider registries; provider contracts; provider-account registries; provider credentials; certificates; PesaPal credentials; M-PESA credentials; callback and IPN registrations; provider merchant and sub-merchant mappings; payment references; provider order identifiers; provider checkout identifiers; incoming provider callbacks; raw provider payloads; authoritative payment attempts; payment status; payout status; refund status; reversal status; merchant settlement status; provider settlement status; reconciliation status; route selection; funds-flow selection; economic-beneficiary validation; allocation; provider fees; commission calculations; tax and reserve calculations where approved; merchant-payable records; provider receivables; Citrus receivables; ledger posting; settlement tracking; reconciliation; exception handling; case-management evidence; merchant statements; provider statements; bank statements; product webhooks; financial audit evidence; transaction controls; route activation; kill switches; launch controls; and financial reporting.

**Servana, Kikao, SkillFlow, and future Citrus products shall own:** bookings; orders; invoices; service fulfilment; subscription entitlements; product access; customer access decisions; product cancellation policies; merchant commercial status; merchant plans; product pricing; product-specific customer relationships; merchant business data; product-side receipt presentation; product-side customer communications; and the business meaning of the payment.

The products may send approved commercial-policy references and economic-purpose declarations, but they shall not arbitrarily select: a provider account; a provider merchant account; a bank account; a settlement destination; a provider wallet; a funding source; a custody model; an unrestricted funds-flow model; a compliance status; an unapproved fee policy; or an unapproved commission policy. Wallet shall derive and enforce those financial decisions through approved configuration.

Wallet shall not decide whether a booking is valid, whether a service was delivered, whether a customer is entitled to access, or whether a merchant has fulfilled a product obligation. Servana shall not hold PesaPal credentials, independently register PesaPal IPN endpoints, directly process provider callbacks, or represent a payment as settled without Wallet's authoritative financial state. Building a partner-owned capability in the wrong system is a defect even if it works.

---

# 7. Platform Boundary

Wallet by Citrus shall operate strictly as internal Citrus Labs financial infrastructure orchestrating instructions through authorised banks and payment providers using accounts owned or controlled by Citrus Labs Limited, and — for customer-to-merchant flows — through provider facilities in which the provider settles independent merchants directly.

The platform boundary explicitly excludes redefinition as any of the entities listed in Section 3 (public wallet, bank, escrow, marketplace, and the remainder of that list). Merchant onboarding into provider facilities shall be initiated only from an approved Citrus Labs or integrated-product workflow. Public self-registration directly into Wallet remains out of scope.

The decisive architectural rule: Wallet by Citrus may select only bank accounts, provider accounts, provider merchant accounts, settlement destinations, wallets, shortcodes, and payment rails that Citrus Labs Limited (or, for merchant settlement destinations, the merchant through a verified provider process) has formally onboarded and that the relevant bank or provider has technically made available for the intended collection, settlement, refund, reversal, or payout function.

---

# 8. Integrated Products

Initial product records shall include:

1. **Kikao** — product code `KIK`.
2. **Servana** — product code `SRV`. Servana is the primary first-launch product; its collections integration (Gate W) and its merchant funds-flow integration (Gate W-M) are the first production-critical deliveries.
3. **SkillFlow** — product code `SKF`.

Future Citrus Labs SaaS products shall be added through the controlled product-onboarding workflow (Section 20) with validation, approval, audit logging, sandbox testing, and production activation. Product prefixes are 3–4 uppercase characters, unique, and registered in the product registry.

---

# 9. Users and Actors

The platform's actors are:

1. **Citrus Labs internal users** — authorized Citrus Labs Limited employees, directors, officers, contractors, accountants, auditors, support personnel, and engineers (Section 11).
2. **Product-scoped merchant users** — delegated identities managed by an integrated product's Merchant Administrator Account (Section 13). Optional per product; launch-disabled for all three initial products until a product owner enables the capability.
3. **Product customers** — end customers of the integrated products. They shall never log into Wallet by Citrus; they interact only with their product, which calls Wallet APIs and receives signed webhooks.
4. **Machine applications** — per-product, per-environment machine identities (Section 12).
5. **Payment providers** — external systems (Safaricom Daraja, PesaPal, banks) that deliver callbacks, IPNs, statements, and settlement evidence. Providers are never trusted actors; their input is corroborated (Section 44).
6. **Merchants as provider counterparties** — product merchant accounts represented at a provider as provider merchant or sub-merchant identities (Section 14). Merchants do not access Wallet directly at first launch; merchant financial data is exposed through Servana.

---

# 10. Account Hierarchy

```text
Legal entity
    Product
        Application
            Environment
                Product merchant account
                    Provider merchant accounts (per provider)
                    Merchant settlement destinations (versioned)
                    Product-scoped users (optional, launch-disabled)
```

Every product-owned or merchant-account-owned record shall include sufficient ownership keys. Depending on the entity, these keys shall include: `legal_entity_id`, `product_id`, `application_id`, `environment` or `environment_id`, `merchant_account_id`, and — for merchant-finance records — `provider_merchant_account_id`.

All queries shall be scoped by the applicable ownership context. Background jobs, exports, webhooks, reconciliation work, statements, and audit records shall preserve that context. The platform shall use UUIDs, ULIDs, or public-safe identifiers for externally visible resources. Sequential internal identifiers shall never be accepted as sufficient authorization.

---

# 11. Human Identities

Internal users shall include authorized Citrus Labs Limited employees, directors, officers, contractors, accountants, auditors, support personnel, and engineers.

Internal roles shall include:

1. Owner.
2. Super Administrator.
3. Platform Administrator.
4. Finance Maker.
5. Finance Approver.
6. Senior Finance Approver.
7. Accountant.
8. Reconciliation Officer.
9. Treasury Officer.
10. Risk and Compliance Officer.
11. Support Officer.
12. Developer.
13. Security Administrator.
14. Auditor.
15. Read-only Executive Viewer.

The system shall permit multiple roles per user and support explicit permissions independent of role names, including explicit per-membership grant and deny overrides where deny beats grant.

---

# 12. Machine Identities

Each product and environment shall receive separate machine credentials.

A machine application identity shall include:

1. Application identifier.
2. Product identifier.
3. Environment.
4. OAuth client identifier or equivalent public identifier.
5. Secret, private key, or mutual-TLS certificate reference.
6. Allowed scopes.
7. Allowed IP address ranges where practical.
8. Allowed callback destinations.
9. Credential status.
10. Creation timestamp.
11. Expiration timestamp where applicable.
12. Last-used timestamp.
13. Rotation history.
14. Revocation status.

A compromised credential for one product or environment shall not grant access to another product or environment. Sandbox credentials shall never authorize production operations. Production credentials shall never be exposed in sandbox or staging. Credential rotation shall support a controlled overlap window; compromise shall trigger immediate revocation, token invalidation, alerting, and reissuance under runbook.

---

# 13. Merchant Identities

Where a Citrus Labs SaaS product requires a merchant user to view or operate a product-scoped payment function, Wallet by Citrus shall treat that user as a delegated product identity, not as an independent Wallet tenant.

A product-scoped merchant user shall:

1. Belong to a merchant account in Kikao, Servana, SkillFlow, or another integrated Citrus product.
2. Be created and managed from that product's Merchant Administrator Account.
3. Have an active email address and active membership in the source merchant account.
4. Receive only product-scoped and merchant-account-scoped Wallet permissions.
5. Never receive access to the central Citrus Labs treasury, provider credential, bank configuration, merchant-settlement-destination administration, cross-product reporting, global ledger, or global reconciliation areas.
6. Lose Wallet access promptly when the source Merchant Administrator Account deactivates or removes the user.
7. Be revalidated at login and at defined session-validation intervals.

Product-scoped merchant access shall be optional by product and is **launch-disabled for all three initial products**. A product may instead expose all merchant payment functionality entirely inside its own application and use Wallet by Citrus only through machine APIs. The identity-federation capability shall nonetheless be built and tested, because session revalidation logic is load-bearing for the security model.

Separately from delegated users, every product merchant account shall be mirrored into Wallet's merchant-account registry (Section 22) through an authenticated synchronization API. Wallet mirrors identity and status only; the business meaning of the merchant relationship stays in the product.

---

# 14. Provider Merchant Identities

A **provider merchant account** is a first-class Wallet entity mapping a product merchant account to the merchant identity known by PesaPal or another provider:

```text
Servana merchant
    ↕
Wallet merchant account
    ↕
Provider merchant / sub-merchant identity (e.g., PesaPal)
    ↕
Verified merchant settlement destination
```

A provider merchant account shall record: public identifier; legal entity; product; application; environment; merchant account; provider; provider account; provider merchant identifier; provider sub-merchant identifier; provider profile reference; commercial model; onboarding status; KYB status; AML status; sanctions status; risk status; settlement status; provider terms version; provider fee-schedule version; commission policy; reserve policy; settlement calendar; activation, suspension, and closure timestamps; last provider synchronization; configuration version; and redacted provider metadata.

Supported commercial models shall include:

```text
DIRECT_MERCHANT
SUBMERCHANT
PLATFORM_MANAGED
SPLIT_SETTLEMENT
GROSS_SETTLEMENT
```

No transaction shall use a provider merchant account unless it is active, approved for the environment, approved for the currency, and approved for the payment method. A provider merchant account shall never cross product or environment boundaries. Merchant A shall never transact through merchant B's provider merchant account.

Provider merchant onboarding, suspension, and offboarding are specified in Sections 68–70. The existence of provider merchant records does not convert product merchants into public Wallet tenants.

---

# 15. Authentication

All human account logins shall use a magic link sent to the user's verified email address. Password-based login shall not be implemented; the identity store shall contain no password field at all.

## 15.1 Magic-Link Login Flow

1. The user enters an email address and, where required, selects or supplies the relevant product or account context.
2. Wallet by Citrus normalizes the email address without altering its semantic mailbox identity.
3. Wallet by Citrus determines whether the identity is an internal Citrus Labs user or a delegated product merchant user.
4. For an internal user, Wallet by Citrus verifies that the account is active in the internal identity directory.
5. For a product merchant user, Wallet by Citrus calls the respective integrated product's trusted identity-verification endpoint.
6. The source product verifies that the email belongs to an active merchant-account user and returns the product, merchant account, role, permission, membership-status, and identity version required by Wallet by Citrus.
7. Wallet by Citrus shall not reveal whether an email exists. The public response shall remain generic.
8. Wallet by Citrus creates a cryptographically random, single-use, short-lived token.
9. Only a secure hash of the token shall be stored.
10. The token shall be bound to the intended email, user, audience, account context, environment, requested redirect, and creation event.
11. The platform sends a magic-link email through a queued email process.
12. The user opens the link.
13. Wallet by Citrus validates token integrity, expiry, usage state, account state, audience, environment, and redirect safety.
14. Wallet by Citrus revalidates source-product membership where the identity is delegated.
15. The token is atomically marked as consumed.
16. The session is created with the current roles, permissions, product scope, merchant-account scope, and authentication assurance level.
17. The login event is written to the security log and audit log.

## 15.2 Magic-Link Requirements

1. A configurable expiry no longer than fifteen minutes for normal login.
2. A shorter configurable expiry for step-up authentication.
3. Single-use enforcement through an atomic database update.
4. Token hashing at rest.
5. Rate limits per email, IP address, device fingerprint where lawful, and account context.
6. Cooldown periods after repeated requests.
7. Generic login responses to prevent account enumeration.
8. Safe redirect allowlists.
9. CSRF protection during session establishment.
10. Session fixation prevention through session identifier rotation.
11. A visible expiry message when a link is no longer valid.
12. A safe retry process that requests a new link.
13. Revocation of outstanding links when a user is deactivated.
14. Revocation of outstanding links when an email address changes.
15. Rejection of links created for a different environment.
16. Rejection of modified, truncated, replayed, or already-consumed links.
17. A signed context that prevents a product identifier or merchant-account identifier from being substituted.
18. Protection against open redirects.
19. Email templates that never expose secrets or financial data.
20. Audit records for requested, sent, delivered where available, consumed, expired, rejected, and revoked events.

## 15.3 Step-Up Authentication

Sensitive actions shall require recent authentication. High-risk roles and actions shall also require a second factor after magic-link authentication.

Supported step-up mechanisms shall include: a time-based one-time password (TOTP) as the primary mechanism; a fresh short-lived magic link as fallback; passkey or WebAuthn security key as a post-launch enhancement; and an approved enterprise identity-provider challenge where adopted.

Actions requiring step-up include at minimum: payout approval; refund approval; bank-account activation; merchant settlement-destination creation, verification, approval, and activation; provider merchant approval, suspension, and closure; credential reveal and rotation; route activation; commission, fee, tax, and reserve policy activation; reserve release; compliance-hold release; kill-switch and provider operating-mode changes in production; launch-control changes; daily-close approval; accounting-period reopen; ledger-correction approval; role and permission changes; and break-glass invocation.

A payout approver shall not approve a high-risk payout solely because an old browser session remains active.

## 15.4 Session Controls

Sessions shall include:

1. Secure, HTTP-only, same-site cookies.
2. Configurable inactivity timeout.
3. Configurable absolute lifetime.
4. Rotation after authentication and privilege changes.
5. Explicit logout.
6. Logout from all devices.
7. Administrative session revocation.
8. Device and active-session visibility.
9. Session revalidation after the source product reports a delegated user deactivation.
10. Risk-based reauthentication after material network, device, or behavior changes.
11. Immediate privilege refresh after role or permission changes (identity-version enforcement).
12. No reliance on frontend state as proof of authorization.

---

# 16. Authorization

Authorization shall be enforced through backend policies, gates, and a structured first-party permission model. Every authorization decision shall consider:

1. Legal entity.
2. User status.
3. User type.
4. Role.
5. Explicit permission (deny beats grant).
6. Product scope.
7. Product application scope.
8. Environment scope.
9. Merchant-account scope.
10. Provider-merchant-account scope where applicable.
11. Transaction ownership.
12. Approval segregation rules (maker-checker).
13. Authentication assurance level.
14. Risk state and resource status, including compliance holds and legal holds.

Frontend checks may hide unavailable actions but shall never be the security control. The maker of a controlled transaction shall not approve the same transaction. A permission that allows creation shall never implicitly permit approval, submission, cancellation, retry, activation, release, or destination modification.

---

# 17. Roles

The seeded internal role set is the fifteen roles of Section 11. Role-to-permission assignment shall be maintained in a canonical, version-controlled permission matrix with a parity test between the matrix file, the database seed, and the documentation. System roles shall be immutable through the application. Multiple roles per user are permitted; roles are granted within a membership scope so a product-scoped user can never hold a global role.

Segregation rules shall include at minimum:

1. Maker ≠ checker on payouts, refunds, ledger corrections, and reconciliation resolutions.
2. Bank-account creator ≠ bank-account activator.
3. Settlement-destination creator ≠ settlement-destination activator.
4. Commission-policy creator ≠ commission-policy activator (per version).
5. Reserve creator ≠ reserve releaser above a configured threshold.
6. Daily-close preparer ≠ daily-close approver.
7. Compliance-hold creator ≠ compliance-hold releaser (independent approval required).
8. Provider-contract uploader ≠ sole activator of affected production capabilities.
9. Onboarding data-entry actor ≠ manual approver of the same merchant's sensitive destination data.

---

# 18. Permissions

Permissions shall be granular. The permission catalogue shall include at minimum:

```text
products.read                      products.configure
applications.read                  applications.credentials.manage
merchant_accounts.read
bank_accounts.read_masked          bank_accounts.read_sensitive
bank_accounts.create               bank_accounts.activate
provider_accounts.read             provider_accounts.configure
routes.read                        routes.create                     routes.activate
collections.read                   collections.create                collections.investigate
payouts.read                       payouts.create                    payouts.approve
payouts.cancel                     payouts.retry
refunds.read                       refunds.create                    refunds.approve
reversals.create
beneficiaries.read                 beneficiaries.manage
reconciliation.read                reconciliation.execute            reconciliation.resolve
ledger.read                        ledger.export
reports.read                       reports.export
audit_logs.read                    users.manage                      roles.manage
security_events.read               settings.manage

provider_merchants.read            provider_merchants.create         provider_merchants.submit
provider_merchants.approve         provider_merchants.suspend        provider_merchants.close
merchant_settlement_destinations.read_masked
merchant_settlement_destinations.read_sensitive
merchant_settlement_destinations.create
merchant_settlement_destinations.verify
merchant_settlement_destinations.approve
merchant_settlement_destinations.activate
merchant_settlements.read          merchant_settlements.investigate
merchant_settlements.hold          merchant_settlements.release
merchant_statements.read           merchant_statements.generate      merchant_statements.export
commission_policies.read           commission_policies.configure     commission_policies.activate
fee_policies.read                  fee_policies.configure            fee_policies.activate
tax_policies.read                  tax_policies.configure            tax_policies.activate
reserves.read                      reserves.create                   reserves.release
reserves.apply
chargebacks.read                   chargebacks.manage
chargebacks.submit_evidence        chargebacks.accept
cases.read                         cases.create                      cases.assign
cases.resolve                      cases.reopen
daily_close.read                   daily_close.execute               daily_close.approve
daily_close.reopen
provider_contracts.read            provider_contracts.manage
provider_capabilities.activate
compliance_holds.read              compliance_holds.create           compliance_holds.release
launch_controls.read               launch_controls.manage
```

Sensitive permissions (marked `requires_step_up` in the matrix) require step-up authentication at exercise time. Permission changes shall be audited with before and after values, actor, and reason.

---

# 19. Data Isolation

Although Wallet by Citrus is owned by one legal entity, it shall apply strict account isolation comparable to a multi-tenant SaaS platform across product, application, environment, merchant account, and provider merchant account boundaries.

1. Every owned record carries its ownership keys; financial transaction records carry all keys denormalized.
2. Cross-environment references shall be structurally unrepresentable (composite foreign keys binding application and environment).
3. Foreign-scope resource identifiers shall return a non-enumerating not-found response, never a forbidden response that confirms existence; probes with valid foreign identifiers shall raise security events.
4. Search, counts, error messages, exports, URLs, and timing behaviour shall not permit cross-scope inference where practical.
5. Background jobs, exports, webhooks, notifications, statements, and reconciliation work shall carry and enforce ownership context; an unscoped job touching owned data shall fail loudly without processing.
6. Merchant statements shall never expose unrelated Citrus financial information or other merchants' data.
7. Negative-balance offsets shall never cross merchant accounts. Netting across unrelated merchants, products, currencies, or customers is prohibited (Section 63.4).
8. Super-administrative access occurs only through permission-gated, step-up-protected, reason-captured, audited workflows; there is no scoping bypass mode and no impersonation feature at launch.

---

# 20. Product Registry

Wallet by Citrus shall maintain a registry of every integrated Citrus Labs product.

Each product record shall include:

1. Product name.
2. Product code.
3. Product slug.
4. Legal owner.
5. Business owner.
6. Technical owner.
7. Finance owner.
8. Support owner.
9. Status.
10. Go-live date.
11. Default currency.
12. Supported currencies.
13. Supported transaction directions.
14. Supported payment methods.
15. Default time zone.
16. Contact and escalation details.
17. Production webhook destination.
18. Sandbox webhook destination.
19. Identity-verification endpoint where delegated merchant users are supported.
20. Expected reference formats.
21. Risk profile.
22. Default approval policy.
23. Data retention policy.
24. Reconciliation policy.
25. Associated merchant accounts.
26. Associated applications.
27. Associated provider routes.
28. Associated ledger accounts.
29. Registered commercial-policy references and versions accepted from the product (Section 47.6).

New products shall be added through a controlled administrative workflow with validation, approval, audit logging, sandbox testing, and production activation. Product retirement never deletes the record; a retired product's stray references route to controlled exception handling.

---

# 21. Application and Environment Registry

Each product shall have one or more registered applications (for example, `Servana Sandbox`, `Servana Staging`, `Servana Production`, and the equivalents for Kikao and SkillFlow — nine application rows for the three initial products).

Each application shall include:

1. Public application identifier.
2. Product identifier.
3. Environment (`sandbox`, `staging`, `production`).
4. Status.
5. Allowed API scopes.
6. Allowed source network ranges where practical.
7. Authentication method.
8. Credential references.
9. Webhook secret references (dual-key rotation supported).
10. Allowed webhook destinations.
11. Rate-limit policy.
12. Idempotency policy.
13. Maximum transaction amount.
14. Daily transaction limit.
15. Monthly transaction limit.
16. Supported currencies.
17. Supported payment methods.
18. Supported transaction directions.
19. Permitted economic purposes (Section 31).
20. Last credential rotation date.
21. Last successful API request.
22. Last failed API request.
23. Last successful webhook delivery.
24. Incident state.

These per-application entitlements shall be enforced server-side on every product API call. Sandbox credentials shall never authorize production operations.

---

# 22. Merchant-Account Registry

Wallet shall mirror every product merchant account through an authenticated synchronization API:

1. Public identifier; product; environment; the product's own external merchant reference; display name; synchronization timestamps and source.
2. Merchant status, distinguishing at minimum: `ACTIVE`, `PAYMENTS_SUSPENDED`, `SETTLEMENTS_SUSPENDED`, `REFUNDS_ONLY`, `OFFBOARDING`, `CLOSED`, `COMPLIANCE_HOLD` (effects in Section 69).
3. Merchant contact and notification routing for out-of-band notifications (Section 54.3).
4. Links to the merchant's provider merchant accounts, settlement destinations, financial position, statements, reserves, negative balances, cases, and onboarding records.

Uniqueness shall be enforced per product, environment, and external merchant reference. Wallet mirrors identity and status only; the product remains the source of merchant commercial status. Servana shall not directly mark provider KYB as approved; provider approval reflects provider evidence only.

---

# 23. Bank Registry

Each bank record shall include:

1. Bank name.
2. Bank code.
3. Country.
4. SWIFT or BIC where applicable.
5. PesaLink or local clearing code where applicable.
6. Support contact.
7. API or host-to-host capability.
8. Statement formats.
9. Reconciliation methods.
10. Operational status.

---

# 24. Citrus Bank Accounts

The Citrus bank-account registry shall contain **only** bank accounts owned by Citrus Labs Limited. Independent merchant bank accounts shall never be stored in this registry; they belong exclusively to the merchant settlement-destination model (Section 25). This separation is legally and operationally critical.

Each Citrus Labs bank account record shall include:

1. Legal owner name.
2. Bank name.
3. Bank identifier.
4. Account name.
5. Encrypted account number.
6. Masked account number.
7. Branch name.
8. Branch code.
9. Currency.
10. Account type.
11. Account purpose (settlement, payout funding, wallet funding, operational; multiple purposes supported).
12. Whether it can receive collections.
13. Whether it can fund payouts.
14. Whether direct debit access is technically available.
15. Whether a direct bank API is connected.
16. Whether a provider settles into the account.
17. Whether a provider wallet is funded from the account.
18. Supported products.
19. Supported payment methods.
20. Reconciliation method.
21. Statement source.
22. Statement frequency.
23. Current status.
24. Verification status, verified date, and verification evidence reference.
25. Effective date and closure date where applicable.
26. Finance owner.
27. Approval state.

Ordinary users shall see only a masked account representation, for example: `Equity Bank — Citrus Labs Limited — ******4821 — KES`. Bank accounts that have historical transactions shall not be deleted; they shall be deactivated with an effective date. Creation and change require maker-checker approval; activation of a payout-capable account requires step-up authentication.

**Bank-account meanings.** The platform shall distinguish: (1) depository or settlement bank account; (2) payout funding bank account; (3) provider-wallet funding bank account; (4) operational bank account; (5) clearing account (an internal ledger representation of funds expected from or owed to a provider or bank). The platform shall never label a provider wallet as a bank account.

**Collection-facility policy.** Wallet shall distinguish: Citrus receivable facilities; customer-to-merchant collection facilities; merchant payout facilities; refund facilities; and treasury funding facilities. A shared PayBill or provider account shall not be used for both Citrus receivables and merchant customer funds without an approved exception recorded through a funds-flow ADR, legal sign-off, ledger posting model, reconciliation model, and refund model. Where one facility is temporarily unavoidable, Wallet must at minimum maintain: transaction-purpose reference classes; immutable merchant ownership; separate clearing accounts; separate Citrus revenue and merchant-payable ledgers; exact merchant allocation; suspense handling; daily provider and bank reconciliation; no payout before collection finality and fraud checks; and reserves for refunds and reversals. That remains a transitional architecture, never the target state.

---

# 25. Merchant Settlement Destinations

Merchant settlement destinations are merchant-owned, provider-verified destinations, held in a model entirely separate from Citrus Labs bank accounts.

Supported destination types shall include:

```text
BANK_ACCOUNT
MOBILE_WALLET
PESAPAL_MERCHANT_BALANCE
OTHER_PROVIDER_VERIFIED_DESTINATION
```

Each destination record shall include: public identifier; merchant account; provider merchant account; destination type; bank where applicable; currency; country; account name; encrypted and masked account number; encrypted and masked mobile number; provider destination reference; verification method; verification status; provider verification reference; verified timestamp and verifier; effective dates; status; version; change risk score; and cooling-off expiry.

A destination shall not be editable in place. Every change shall create a new version. A destination change shall:

1. Invalidate pending split-settlement or merchant-settlement approvals.
2. Pause automatic settlement where policy requires.
3. Start a configurable cooling-off period.
4. Trigger out-of-band notification to the merchant's verified contacts.
5. Require step-up authentication.
6. Require maker-checker approval.
7. Record the old and new masked destinations.
8. Require provider re-verification.
9. Create a high-severity audit event.
10. Prohibit settlement to the new destination until activation.

No settlement shall point to an inactive or unverified destination. Settlement instructions and merchant settlements pin the destination version in force at instruction time; later changes never redirect an approved settlement. Access to full destination values requires the sensitive read permission, step-up, a recorded reason, and an audit event.

---

# 26. Provider Registry

Wallet by Citrus shall maintain a provider registry for current and future gateways.

Provider categories include:

1. Safaricom Daraja (M-PESA C2B, STK Push, B2C, reversal, transaction status, balance).
2. **PesaPal** (online collection, mobile money, cards, IPN, status query, refunds, and contract-dependent merchant/settlement capabilities) — an explicit first-launch provider, subject to signed commercial and production onboarding approval.
3. PesaLink integrations.
4. Direct bank APIs and bank host-to-host integrations.
5. Flutterwave, IntaSend, or another approved aggregator (registry-ready; not integrated at launch without a signed commercial agreement).
6. Card gateways and mobile-money gateways.
7. Manual bank-file workflows where APIs are unavailable.

Every provider record shall include: provider name; provider code; provider category; regulatory and contractual status; technical integration status; supported countries; supported currencies; supported payment methods; supported transaction directions; supported reconciliation methods; supported webhook authentication methods; supported balance-query methods; sandbox availability; production availability; support contacts; incident contacts; service-level commitments; known amount limits; known rate limits; settlement behavior; prefunding requirements; and provider-specific operational notes.

Provider capability shall not be inferred from a provider name. Capabilities shall be registered per provider account, per provider merchant account, and per contract, because two accounts at the same provider may have different permissions, limits, settlement accounts, or payout facilities.

---

# 27. Provider Accounts

A provider account shall represent a specific commercial and technical facility owned by Citrus Labs Limited.

A provider account shall include:

1. Provider.
2. Legal entity.
3. Provider account name.
4. Environment.
5. Merchant identifier (PayBill, Till, shortcode, business number, subaccount, PesaPal merchant reference, or equivalent).
6. Supported direction.
7. Supported payment methods.
8. Supported currencies.
9. Settlement bank account (nullable — a customer-to-merchant facility may have no Citrus settlement account).
10. Payout funding source.
11. Provider wallet.
12. Prefunding requirement.
13. Minimum and maximum amounts; daily and monthly limits.
14. Callback configuration: result URL, queue timeout URL, validation URL, confirmation URL, IPN URL and IPN identifier registrations.
15. Credential references and certificate references; secret rotation date.
16. Contract reference and contract version (Section 28).
17. Capability version and settlement model.
18. Capability flags derived from versioned capability records: supports platform merchants; supports sub-merchants; supports split settlement; supports direct merchant settlement; supports general disbursement; supports chargebacks; supports reserves.
19. Status; effective dates; health status; operating mode (Section 105).
20. Last successful transaction; last failed transaction; last balance query; last reconciliation.
21. Products using the account; routes using the account; incident or maintenance state.

Full credentials shall never be displayed after creation. The dashboard shall show credential status, age, rotation date, and last use without revealing the secret.

---

# 28. Provider Contracts

Wallet shall maintain a provider contract and commercial-terms registry containing provider contracts, contract versions, provider fee schedules, provider service levels, and provider operating limits.

Each contract record shall capture: contract effective dates; countries; currencies; products; merchant models; settlement models; fees; reserves; limits; refund rules; chargeback rules; settlement SLAs; support channels; escalation contacts; data-retention obligations; compliance responsibilities; termination provisions; renewal date; and document evidence.

Rules:

1. A route shall not remain active after the supporting contract or capability expires; expiry pauses the route and raises an alert.
2. Provider contract effective dates must cover route activation; provider capability effective dates must cover transaction submission (database-enforced).
3. Contract-expiry and renewal alerts shall be raised in advance at configured intervals.
4. Provider fee schedules are versioned and reconciled against actual charged fees (fee-variance reconciliation, Section 76).

---

# 29. Provider Capabilities

Capabilities shall be recorded per provider account and per provider merchant account, from contract and test evidence, never inferred:

```text
ONLINE_COLLECTION            MOBILE_MONEY_COLLECTION      CARD_COLLECTION
BANK_COLLECTION              IPN_NOTIFICATION             TRANSACTION_STATUS_QUERY
REFUND                       ORDER_CANCELLATION           MERCHANT_ONBOARDING
SUBMERCHANT_COLLECTION       DIRECT_MERCHANT_SETTLEMENT   SPLIT_SETTLEMENT
PLATFORM_COMMISSION          SETTLEMENT_REPORT            MERCHANT_STATEMENT
BALANCE_QUERY                GENERAL_DISBURSEMENT         REAL_TIME_SETTLEMENT
RECURRING_COLLECTION         CHARGEBACK_NOTIFICATION      RESERVE_REPORTING
```

A route shall fail closed where a required capability is absent, expired, suspended, contractually unapproved, or untested. No capability shall be enabled merely because the provider is named PesaPal. The system must not assume PesaPal supports split settlement merely because it supports payment collection. "Real-time settlement" marketing claims shall not be treated as proof of third-party merchant disbursement capability; only the account holder's own documented, contracted behaviour counts.

---

# 30. Provider Merchant and Sub-Merchant Accounts

The provider merchant account entity is specified in Section 14. Additional requirements:

1. Provider merchant lifecycle events (`created`, `submitted`, `remediation_required`, `approved`, `rejected`, `suspended`, `closed`) shall be recorded as immutable events.
2. Provider merchant capabilities shall be recorded per Section 29 at the merchant level where the provider differentiates them.
3. Configuration drift between Wallet's records and the provider's records (merchant status, settlement destination, IPN registration, capabilities, contract dates) shall be detected by a scheduled comparison ("route doctor"); drift creates an exception and may pause affected routes (Section 106.4).
4. Provider rejections and remediation requests shall be preserved; historical onboarding evidence shall never be deleted.

---

# 31. Economic-Purpose Model

Every payment shall carry a mandatory, immutable `economic_purpose` stating why the money is being collected and who is economically entitled to it.

Initial values shall include:

```text
CITRUS_PLATFORM_FEE
CITRUS_SUBSCRIPTION_FEE
CITRUS_ONBOARDING_FEE
CITRUS_USAGE_FEE
CITRUS_COMMISSION_INVOICE
MERCHANT_CUSTOMER_PAYMENT
MERCHANT_BOOKING_DEPOSIT
MERCHANT_BALANCE_PAYMENT
MERCHANT_CANCELLATION_FEE
CUSTOMER_REFUND_RECOVERY
MANUAL_APPROVED_RECEIVABLE
```

The enumeration shall not be extended by unreviewed migrations. Every new purpose shall require: a business owner; a legal beneficiary; a ledger template; a refund policy; a settlement policy; a reconciliation policy; a tax policy; a route eligibility policy; an API entitlement decision; and a product contract version.

The payment purpose shall not be changed after provider submission. A correction shall cancel or expire the original unpaid payment and create a new payment.

The integrated product supplies the purpose; Wallet validates it against the application's permitted purposes and derives the permissible funds-flow model from controlled configuration. A product must never be able to select `CITRUS_COLLECTION_MERCHANT_PAYOUT` or a settlement destination.

---

# 32. Economic-Beneficiary Model

Every payment, allocation, settlement, refund, reserve, dispute, and chargeback shall identify the economic beneficiary through first-class, immutable-or-versioned fields:

```text
economic_beneficiary_type        economic_beneficiary_id
contractual_seller_type          contractual_seller_id
merchant_of_record_type          merchant_of_record_id
funds_recipient_type             funds_recipient_id
```

Initial beneficiary types:

```text
CITRUS_LABS_LIMITED
PRODUCT_MERCHANT_ACCOUNT
CUSTOMER
PROVIDER
TAX_AUTHORITY
OTHER_APPROVED_COUNTERPARTY
```

The complete economic-ownership model shall additionally identify, per transaction or per route as applicable: initial funds recipient; temporary funds controller; final settlement beneficiary; provider account holder; refund-funding party; chargeback-responsible party; provider-fee bearer; commission beneficiary; tax beneficiary; reserve owner; negative-balance debtor; and custody classification.

These fields exist because payment origin, provider account ownership, economic ownership, contractual seller, and settlement destination may all differ. They shall be immutable after provider submission, or versioned at the correct lifecycle point where the domain requires versioning.

**A customer payment must not be classified as Citrus revenue merely because a Citrus-owned provider account, PayBill, wallet, or bank account received it.** Database constraints shall enforce that a merchant-purpose payment carries a merchant beneficiary and merchant account, and a Citrus-purpose payment carries the Citrus beneficiary.

---

# 33. Funds-Flow Models

The routing engine and every transaction snapshot shall include an explicit `funds_flow_model`:

```text
CITRUS_DIRECT_COLLECTION
PROVIDER_DIRECT_MERCHANT_SETTLEMENT
PROVIDER_SPLIT_SETTLEMENT
MERCHANT_GROSS_CITRUS_SEPARATE_BILLING
CITRUS_COLLECTION_MERCHANT_PAYOUT
MANUAL_SETTLEMENT_WITH_EVIDENCE
```

Each funds-flow model shall define: who receives the customer payment first; who controls the funds; who owns the funds economically; who owes the merchant; who owes Citrus; who funds refunds; who absorbs chargebacks; which ledger accounts are used; which settlement evidence is required; which reports are produced; and which compliance approval is required.

## 33.1 Merchant-to-Citrus Direct Collection (`CITRUS_DIRECT_COLLECTION`) — confirmed

Used for amounts legally and economically owed to Citrus Labs Limited: subscription fees; onboarding fees; account activation fees; premium module and premium-feature fees; fixed platform fees; usage fees and charges; transaction commissions invoiced separately; implementation fees; support fees; administrative charges permitted by contract; and other approved Citrus receivables.

Routes: Citrus Labs' PesaPal merchant account (contract-dependent); a dedicated Citrus Labs M-PESA PayBill; or another verified Citrus collection facility approved through route activation. The economic beneficiary must be `CITRUS_LABS_LIMITED`. Every merchant-to-Citrus payment shall identify the economic purpose, the beneficiary, the Citrus invoice or receivable reference, the merchant account that owes the amount, the product generating the receivable, the provider route, the Citrus settlement account, the fee policy, the tax policy, and the reconciliation policy. Both PesaPal checkout and Citrus PayBill options shall normalize into the same Citrus receivable and ledger model.

## 33.2 Provider Direct Merchant Settlement (`PROVIDER_DIRECT_MERCHANT_SETTLEMENT`) — contract-dependent

Used for customer payments economically owed to an independent product merchant. The provider processes the payment and settles the merchant's verified destination directly; Citrus never receives or controls the funds.

```text
Customer → Servana booking/invoice → Wallet orchestration
    → PesaPal platform / merchant / sub-merchant facility
    → Provider settlement to the verified Servana merchant destination
```

Wallet records: the customer payment; the provider transaction; the merchant beneficiary; provider fees; settlement expectation; merchant settlement; ledger entries; reconciliation; and the merchant statement.

## 33.3 Merchant Gross Settlement with Separate Citrus Billing (`MERCHANT_GROSS_CITRUS_SEPARATE_BILLING`) — first-launch default

**This shall be the first-launch default where split settlement is unavailable.** The provider settles the merchant gross amount (or contractually determined amount); Citrus issues and collects a separate commission or platform-fee receivable from the merchant:

```text
Customer → PesaPal → Merchant
Merchant → PesaPal or Citrus PayBill → Citrus Labs Limited
```

Advantages: Citrus never holds merchant customer funds; simpler regulatory boundary; clear tax and accounting treatment; fewer payout failures; no Citrus liquidity requirement; merchant owns settlement directly. Trade-offs to be controlled: Citrus merchant-credit risk; potential late commission payment; collection and commission events are separate; strong merchant billing controls required (commission receivables, aging, dunning through Servana, negative-balance interaction per Section 63).

## 33.4 Provider Split Settlement (`PROVIDER_SPLIT_SETTLEMENT`) — contract-dependent, conditional

May be enabled only where the provider contractually and technically supports: platform merchants; sub-merchants; merchant onboarding; merchant settlement; commission allocation; split settlement; applicable reports; refunds; reversals; reserves; negative-balance treatment; and chargebacks.

Split-settlement activation requires proof of all of the following:

1. PesaPal has signed a platform, marketplace, managed-merchant, or equivalent commercial agreement with Citrus Labs Limited.
2. PesaPal confirms merchant or sub-merchant onboarding requirements.
3. PesaPal confirms the supported settlement destinations.
4. PesaPal confirms API, file, portal, or operational support for split settlement.
5. PesaPal confirms responsibility for merchant KYC/KYB, AML/CFT, sanctions screening, transaction monitoring, and settlement controls.
6. The split calculation and rounding method are contractually defined.
7. The provider confirms who bears provider fees, reversals, refunds, chargebacks, taxes, reserves, and negative balances.
8. Wallet contract tests prove the provider instruction and provider statement match Wallet's immutable allocation.
9. Legal and accounting sign-off is recorded.
10. A production canary proves collection, allocation, settlement, ledger posting, merchant statement, and reconciliation.

Illustrative split: customer payment KES 10,000; provider fee KES 300; Citrus commission KES 1,000; merchant net settlement KES 8,700 — recorded through the allocation model of Section 47.

## 33.5 Citrus Collection Followed by Merchant Payout (`CITRUS_COLLECTION_MERCHANT_PAYOUT`) — disabled by default, legally gated

This flow shall exist only as a disabled-by-default, separately gated funds-flow model, globally disabled until a dedicated compliance approval is recorded. It may not be enabled merely because Wallet can technically create a payout. It changes Citrus Labs into an entity that receives money owed to independent merchants, records merchant payables, controls settlement timing, handles failed merchant payouts, and manages refunds against merchant-owned funds — materially raising the probability of regulated payment-service classification.

Activation requires all of: external Kenyan payments-law advice; provider written approval; board or delegated executive approval; accounting treatment approval; tax treatment approval; safeguarding or ring-fencing determination; customer and merchant contractual amendments; liquidity policy; reserve and refund funding policy; negative-balance policy; enhanced reconciliation; dedicated settlement and payable accounts; enhanced operational staffing; fraud and dispute controls; a specific route capability flag; customer disclosure; a reconciliation model; and a specific production route-activation checklist. Where enabled, no merchant payout shall occur until the original collection is final, allocated, risk-cleared, and reconciled to the required level.

## 33.6 Manual Settlement with Evidence (`MANUAL_SETTLEMENT_WITH_EVIDENCE`) — exceptional

Manual settlement must be exceptional, permission-controlled, evidence-backed, ledgered, reconciled, and maker-checker approved. It exists for manual adjustments, compensation, corrections, and refund alternatives. It must not become the ordinary production flow, and its usage shall be reported (funds-flow model usage report, Section 89).

---

# 34. Payment Methods

The payment-method registry shall include at minimum: `mpesa_c2b_paybill`, `mpesa_c2b_till`, `mpesa_stk`, `mpesa_b2c`, `pesapal_checkout` (M-PESA, cards, mobile banking, and other PesaPal-enabled methods behind PesaPal's hosted checkout), `pesalink`, `bank_transfer`, and `card`. Each method records its direction (collection, payout, or both) and status. Method availability per route is constrained by provider-account and provider-merchant capabilities, application entitlements, and launch limits.

---

# 35. Payment Routes

A route record shall include:

```text
legal_entity_id                  product_id                      application_id
environment_id                   merchant_account_scope          transaction_direction
payment_method_id                provider_account_id             settlement_bank_account_id (nullable)
funding_bank_account_id          provider_wallet_id              currency
minimum_amount                   maximum_amount                  priority
is_default                       is_fallback                     status
effective_from                   effective_until                 approval_policy_id
risk_policy_id                   fee_policy_id                   settlement_policy_id
route_version

economic_purpose_scope           economic_beneficiary_scope      funds_flow_model
provider_merchant_account_required
merchant_settlement_destination_required
commission_policy_id             tax_policy_id                   reserve_policy_id
settlement_calendar_id           provider_contract_version_id    custody_classification
compliance_approval_id           refund_funding_party
```

`refund_funding_party` values: `PROVIDER`, `MERCHANT`, `CITRUS_LABS`, `SHARED`, `UNDETERMINED_BLOCKED`. A refund shall not proceed where the route's funding responsibility is `UNDETERMINED_BLOCKED`.

A customer-to-merchant route may have no Citrus settlement bank account; it instead requires an active provider merchant account and a verified merchant settlement destination. A merchant-to-Citrus route requires a verified Citrus settlement account and the Citrus beneficiary.

Representative route intents:

```text
Route: Servana merchant-to-Citrus fees
    Direction COLLECTION · Purpose CITRUS_SUBSCRIPTION_FEE
    Funds-flow CITRUS_DIRECT_COLLECTION · Beneficiary CITRUS_LABS_LIMITED
    Provider: PesaPal (Citrus account) or Citrus M-PESA PayBill
    Settlement: Citrus Labs verified collections bank account
```

```text
Route: Servana customer-to-merchant payments
    Direction COLLECTION · Purpose MERCHANT_CUSTOMER_PAYMENT
    Funds-flow PROVIDER_DIRECT_MERCHANT_SETTLEMENT (or MERCHANT_GROSS_CITRUS_SEPARATE_BILLING)
    Provider: PesaPal platform facility · Provider merchant: PesaPal sub-merchant XYZ
    Settlement beneficiary: Servana merchant · Destination: merchant verified destination
    Citrus settlement account: none
```

```text
Route: SkillFlow M-PESA payout
    Safaricom B2C provider account · Citrus Labs B2C funding source
    Provider balance funded from Citrus Labs disbursement bank account
```

Route versions are immutable after activation. Activation requires approval, a verified provider account, verified settlement configuration, an unexpired provider contract covering the activation date, and — for merchant funds flows — the compliance approval reference.

---

# 36. Routing Engine

The routing engine shall select the appropriate route using configurable policy, not product-specific hard-coded branching.

Routing inputs shall include:

1. Legal entity, product, application, environment, merchant account.
2. Transaction direction, payment method, currency, amount.
3. Economic purpose, economic beneficiary, funds-flow model.
4. Provider merchant account status and capability.
5. Merchant settlement-destination verification status.
6. Merchant compliance eligibility, KYB status, and compliance holds.
7. Provider contract and capability eligibility and effective dates.
8. Custody classification and legal approval state.
9. Commission, fee, tax, and reserve policy applicability and versions.
10. Beneficiary destination type; customer destination type.
11. Provider availability, provider-account status, operating mode, and provider balance.
12. Bank-account status; contractual route eligibility; transaction limits and launch limits.
13. Risk score; approval state; cost policy; settlement policy; product preference; route effective dates; kill-switch state.

## 36.1 Route Selection Rules

The engine shall:

1. Reject routes not approved for the product and environment.
2. Reject routes outside effective dates.
3. Reject routes whose currency does not match.
4. Reject routes whose amount limits are exceeded.
5. Reject inactive provider or bank accounts.
6. Reject routes with insufficient known liquidity when a reliable balance is available.
7. Reject routes whose economic-purpose scope or beneficiary scope does not cover the payment.
8. Reject routes whose funds-flow model is disabled, unapproved, or blocked by a kill switch or feature flag.
9. Reject routes requiring a provider merchant account where none is active and approved for environment, currency, and method.
10. Reject routes requiring a settlement destination where none is verified and active.
11. Reject routes whose provider contract or capability has expired or is untested.
12. Reject merchants who are suspended, on compliance hold, offboarding, or closed (per the effects matrix in Section 69).
13. Prevent production transactions from using sandbox credentials.
14. Preserve the selected route, including the funds-flow model and all policy versions, before provider submission.
15. Record all evaluated routes and rejection reasons for operational troubleshooting.
16. Use deterministic ranking when multiple routes are eligible.
17. Require explicit authorization for manual route overrides and audit every override.
18. Never silently substitute a different beneficiary, merchant, destination, or funds-flow model.
19. Never blindly fail over an outbound transaction whose prior provider status is unknown.

## 36.2 Controlled Fallback

Fallback may occur only when: the original route was rejected before provider acceptance; no provider transaction identifier exists; the original provider explicitly reports that no money moved; a status query confirms failure; reconciliation confirms non-execution; the transaction policy permits fallback; and the fallback route supports the same beneficiary, economic purpose, funds-flow model, currency, amount, and compliance requirements. A timeout shall place the transaction in `UNKNOWN`, not `FAILED`. A provider outage shall not automatically redirect a customer to a different provider after a provider order may have been accepted.

---

# 37. Collection Capabilities

The launch architecture shall support or be structurally ready for:

1. M-PESA C2B PayBill collection (confirmed).
2. M-PESA C2B Till collection where applicable (technically prepared).
3. M-PESA STK Push (confirmed).
4. PesaPal hosted checkout collection: M-PESA, cards, mobile banking, and other PesaPal-enabled methods (contract-dependent, first-launch).
5. PesaLink or bank-account collection (technically prepared).
6. Card collection through an approved provider (conditional; at first launch only via PesaPal hosted entry, Section 95.4).
7. Direct bank virtual-account or reference-based collection where available (technically prepared).
8. Manual bank-deposit import only through a controlled reconciliation process (confirmed, exceptional).

## 37.1 Collection Record

Every collection shall include:

1. Public payment identifier and structured payment reference.
2. Product, application, environment, merchant account.
3. Economic purpose; economic beneficiary fields; funds-flow model; reference class; commercial policy reference and version; refund-funding party; allocation status.
4. Customer reference; product invoice or order reference; external reference unique within the application.
5. Expected amount; received amount; currency.
6. Payment method; provider; provider account; provider merchant account where applicable.
7. Settlement bank account (Citrus flows) or merchant settlement expectation (merchant flows).
8. Provider transaction identifier; provider order-tracking identifier; checkout-session reference where applicable.
9. Customer phone or bank identifier in masked form where appropriate; customer name where lawfully supplied.
10. Collection status; settlement status; reconciliation status; allocation reference.
11. Fee amount; tax amount where applicable; net expected settlement.
12. Provider timestamps; Wallet timestamps; immutable route snapshot; raw payload reference; risk result; error code and category where applicable.

## 37.2 Collection State Machine

```text
CREATED              PENDING_CUSTOMER_ACTION   SUBMITTED
PROVIDER_ACCEPTED    PROCESSING                SUCCEEDED
PARTIALLY_RECEIVED   OVERPAID                  FAILED
REJECTED             CANCELLED                 EXPIRED
UNKNOWN              REVERSED                  PARTIALLY_REFUNDED
REFUNDED
```

Settlement status (Section 73) and reconciliation status are separate columns. The state model shall separate payment success from bank settlement, from merchant settlement, and from reconciliation completion.

---

# 38. Merchant-to-Citrus Collections

Merchant-to-Citrus collections implement `CITRUS_DIRECT_COLLECTION` (Section 33.1). Additional requirements:

1. Every such payment references the Citrus invoice or receivable it discharges; Wallet maintains Citrus commission receivables and matches collections against them.
2. Merchant-to-Citrus payments shall not be mixed with customer-to-merchant payments under an undifferentiated accounting classification, facility, or reference class.
3. Reference classes shall distinguish the flows (Section 40.1); the ledger templates of Section 72.3 apply.
4. Recurring merchant-to-Citrus payments (for example, card-on-file subscription charges via PesaPal) are a conditional first-launch capability requiring contractual confirmation of `RECURRING_COLLECTION`.

---

# 39. Customer-to-Merchant Collections

Customer-to-merchant collections implement `PROVIDER_DIRECT_MERCHANT_SETTLEMENT`, `MERCHANT_GROSS_CITRUS_SEPARATE_BILLING`, or (conditionally) `PROVIDER_SPLIT_SETTLEMENT` (Section 33). Additional requirements:

1. The merchant is identified as the economic beneficiary from the beginning of the transaction.
2. Payment creation is rejected where: the merchant is inactive, suspended for payments, on compliance hold, offboarding, or closed; the provider merchant account is not approved; the required settlement destination is missing or unverified; the commercial policy version is invalid; the allocation would be unbalanced; the funds-flow model is blocked; the provider contract has expired; the compliance approval is missing; or the amount is outside limits.
3. Wallet computes and records the payment allocation (Section 47) before or at provider submission where commission or deductions apply.
4. Wallet creates the expected merchant settlement (Section 53) from the allocation and settlement calendar.
5. Wallet provides Servana the canonical receipt data contract (Section 91.5); Servana renders the customer-facing receipt.

---

# 40. M-PESA C2B

A shared M-PESA PayBill or shortcode shall have one authoritative callback flow managed by Wallet by Citrus:

```text
Customer payment → Safaricom M-PESA C2B
    → Wallet validation endpoint → Wallet confirmation endpoint
        → Product and merchant-account routing → Kikao / Servana / SkillFlow / future product
```

Integrated products shall not independently register competing validation or confirmation URLs for the same shared shortcode.

## 40.1 Structured Bill References and Reference Classes

References shall: use product-specific prefixes (`KIK-PAY-<ULID>`, `SRV-PAY-<ULID>`, `SKF-PAY-<ULID>`); be unique; avoid raw sequential database identifiers; avoid embedding personal data; support checksum or validation rules where useful; map to a registered payment reference; remain immutable after issuance; and have an expiry or validity policy where appropriate.

The existing `SRV-PAY-<ULID>` contract remains the public payment identifier. A separate immutable **`reference_class`** supplies the economic distinction without breaking product contracts. Reference classes shall include at minimum:

```text
SRV-CIT-FEE-<ULID>    (Citrus fee receivable)
SRV-CIT-SUB-<ULID>    (Citrus subscription receivable)
SRV-MER-PAY-<ULID>    (merchant customer payment)
SRV-MER-DEP-<ULID>    (merchant booking deposit)
```

A PayBill designated for Citrus receivables shall collect only money legally payable to Citrus Labs (Section 24, collection-facility policy).

## 40.2 C2B Validation

Where external validation is enabled, Wallet shall validate: reference existence; product ownership; merchant-account ownership; invoice or order state; payment-reference status; currency; exact amount, minimum amount, or allowed amount tolerance according to product policy; duplicate payment risk; customer eligibility where required; reference expiry; provider-account correctness; product and environment status; and economic-purpose permissibility for the facility. The validation endpoint shall respond within provider time limits; complex work shall not block the response.

## 40.3 C2B Confirmation

The confirmation endpoint shall:

1. Authenticate or validate the request using all provider-supported controls.
2. Validate the callback route and schema.
3. Persist the raw payload immutably before processing.
4. Enforce uniqueness on the M-PESA transaction identifier.
5. Acknowledge the provider promptly.
6. Process the callback asynchronously.
7. Map the bill reference to the product, application, merchant account, and payment record.
8. Post ledger entries only after domain validation, using the posting template for the payment's funds-flow model.
9. Generate signed product webhook events.
10. Route unknown references to an exception queue rather than discarding them.

Duplicate confirmations shall return a successful acknowledgment after confirming that the existing transaction is consistent. They shall not post a second credit. The same provider identifier with a different amount shall block automatic posting and raise a critical integrity exception.

---

# 41. M-PESA STK Push

All integrated products shall request STK Push through Wallet by Citrus rather than directly managing shared provider credentials and callbacks.

## 41.1 STK Push Request Flow

1. The product submits an authenticated, authorized, idempotent STK request.
2. Wallet validates product, merchant account, amount, currency, phone format, invoice state, economic purpose, merchant eligibility, and route eligibility.
3. Wallet creates a payment and payment attempt.
4. Wallet selects the provider account and settlement configuration through the routing engine.
5. Wallet submits the STK request.
6. Wallet stores all provider request identifiers, including checkout and merchant request identifiers.
7. Wallet returns a pending result to the product.
8. The provider callback returns to Wallet.
9. Wallet updates the attempt and payment atomically.
10. Wallet sends a signed webhook to the product.

## 41.2 STK Push Controls

1. Normalize Kenyan phone numbers to the approved provider format.
2. Reject invalid or unsupported number ranges.
3. Prevent repeated accidental prompts through idempotency and rate limits.
4. Enforce a configurable cooldown between prompts to the same number for the same order.
5. Record customer cancellation separately from technical failure.
6. Support expiry when the customer does not act.
7. Query status when callbacks are missing and the provider supports status queries.
8. Prevent a new attempt from overwriting the historical result of an earlier attempt.
9. Permit multiple attempts under one payment while preserving each attempt.
10. Stop new attempts after payment succeeds unless an explicit additional-payment use case exists.

---

# 42. PesaPal

PesaPal shall be an explicit provider implementation in the first-launch plan, integrated into Wallet by Citrus — never directly into Servana — and subject to signed commercial and production onboarding approval. Servana shall never store PesaPal production credentials or independently expose PesaPal IPN endpoints.

## 42.1 Scope of the PesaPal Integration

The PesaPal integration shall cover:

1. PesaPal provider registration and provider-account registration per environment.
2. Authentication and API-client credential management, rotation, and expiry alerting.
3. IPN registration per environment, with the IPN identifier associated to the correct provider account; IPN endpoint ownership rests with Wallet.
4. Order creation and checkout-session issuance (Section 43).
5. Redirect handling (return and cancel URLs) without trusting redirect success.
6. Transaction-status queries as the authoritative provider confirmation where required.
7. Refund submission and refund-report reconciliation.
8. Order cancellation where the provider supports it.
9. Provider transaction identifiers and provider order-tracking identifiers, with duplicate-event handling.
10. Provider error mapping to Wallet's canonical error categories; timeout and unknown-state handling (timeout maps to `UNKNOWN`, never `FAILED`).
11. Provider-fee capture and fee-variance reconciliation.
12. Provider merchant and sub-merchant records and settlement destinations (Sections 14, 25) — contract-dependent.
13. Settlement-report, merchant-statement (where available), refund-report, chargeback-report (where applicable), and reserve-report (where applicable) ingestion.
14. Provider contract and capability registry entries (Sections 28–29).
15. Sandbox simulation or contract fixtures for all PesaPal scenarios; contract tests.
16. Provider outage handling and operating modes (Section 105); production canary; reconciliation (Section 76).

## 42.2 Explicit Truth Rules

1. **A customer browser redirect is not proof of payment.**
2. **An IPN is a provider notification, not automatically final financial truth.**
3. **A provider status query is used where required to confirm the authoritative provider status.**
4. **Settlement evidence is separate from payment success.**
5. **Reconciliation is separate from settlement.**
6. **No undocumented or contractually unconfirmed PesaPal capability may be treated as available.** PesaPal's published API surface covers customer collection, notification, status queries, refunds, recurring payments, and cancellation; split settlement, sub-merchant settlement, merchant-onboarding APIs, and general disbursement are contract-dependent capabilities that must be confirmed in writing before design reliance.

## 42.3 Written Confirmations Required from PesaPal

Before the merchant funds-flow launch, Citrus Labs shall obtain signed commercial and technical answers covering: platform/marketplace support for multiple independent Servana merchants; whether each merchant becomes a PesaPal merchant or sub-merchant; API or managed merchant onboarding; split-settlement support; fixed and percentage commission definition per transaction; API-driven M-PESA and bank disbursements; whether "real-time settlement" applies to third-party merchant beneficiaries or only the account holder's own balance; who legally holds customer funds between collection and settlement; who performs merchant KYC, AML screening, sanctions screening, and ongoing monitoring; who bears chargebacks, reversals, refunds, fraud losses, and negative balances; whether settlement accounts are merchant-specific and pre-verified; available webhooks, status-query endpoints, settlement reports, and reconciliation exports; applicable reserves, rolling holds, transaction limits, and payout limits; and whether the arrangement can be documented as PesaPal processing payments on behalf of Servana merchants rather than Citrus conducting payment services.

Until those answers exist, the architecture shall assume **collection capability but not marketplace split-settlement or general payout capability**.

---

# 43. Checkout Sessions

Where a product redirects customers to a provider-hosted checkout (PesaPal), Wallet shall create an explicit checkout session.

Required fields:

```text
checkout_session_id            payment_id                     provider_account_id
provider_merchant_account_id   return_url                     cancel_url
expires_at                     status                         provider_order_tracking_id
provider_redirect_url          single_use_state
```

Controls:

1. Return URL allowlist and signed state.
2. Session expiry and safe handling of abandoned checkout.
3. No trust in the browser redirect for payment success; a status query follows return.
4. Prevention of reusing a completed checkout; explicit cancellation state.
5. Correlation-identifier propagation; no provider secret in the browser.

Checkout-session states shall include at minimum: `CREATED`, `REDIRECTED`, `RETURNED`, `CANCELLED`, `EXPIRED`, `COMPLETED`, `SUPERSEDED`.

---

# 44. Provider Callbacks and IPNs

Incoming webhooks and IPNs shall be processed through a hardened ingestion pipeline that shall:

1. Receive the request on a provider-specific route (including per-provider-account secret path segments).
2. Enforce HTTPS; apply provider-supported source validation; verify signatures, certificates, secrets, or tokens where supported.
3. Validate content type and maximum body size.
4. Store the exact raw payload immutably; generate a payload hash; detect replay.
5. Acknowledge within provider time limits; queue asynchronous processing.
6. Parse into a canonical event; resolve the provider account; resolve the transaction.
7. Enforce idempotency; update domain state atomically; trigger ledger posting where applicable; trigger product webhook delivery.
8. Record all processing attempts; route unresolvable events to an exception queue.

Malformed or unauthenticated webhooks shall never update a financial transaction. Because Daraja does not sign callbacks and PesaPal IPNs are notifications rather than final truth, every callback is treated as untrusted input requiring corroboration: an STK callback must match a checkout request Wallet created; a C2B confirmation must reference a registered reference and shortcode; a PesaPal IPN must resolve a known order-tracking identifier and is confirmed by status query where required; amounts and currency are cross-checked; receipt and order-tracking uniqueness block replays; non-corroborated events go to the exception queue and can never post ledger entries or emit product webhooks. IPN configuration shall support environment separation, endpoint versioning, secret path rotation where supported, IP allowlists where reliable, payload size limits, replay detection, endpoint health, provider retry handling, manual reprocessing, and no duplicate financial effect. Callbacks shall continue to be accepted after a route is paused.

---

# 45. Payment Attempts

A payment may carry multiple attempts (STK prompts, checkout sessions, C2B receipts). Attempt records include: attempt type; status; provider account; route snapshot; masked and encrypted customer identifiers; provider checkout/merchant-request/transaction identifiers; amount and currency; result code and description; customer-cancellation flag; expiry; and status-query history. Attempt states:

```text
CREATED   SUBMITTING   SUBMITTED   PROVIDER_ACCEPTED   PENDING_CUSTOMER_ACTION
PROCESSING   SUCCEEDED   FAILED   CANCELLED_BY_CUSTOMER   EXPIRED   TIMED_OUT   UNKNOWN
```

Customer cancellation is distinct from technical failure. A new attempt never overwrites a prior attempt's terminal result; attempts are append-only under one payment. At most one attempt per payment may be in a non-terminal state.

---

# 46. Payment States

The authoritative state machines are: collection (Section 37.2); attempt (Section 45); payout (Section 57.4); refund (Section 60); reversal (Section 61); chargeback (Section 62); merchant settlement (Section 53); settlement (Section 73); batch (Section 58); approval request (Section 65); reconciliation exception (Section 79); incoming webhook and outgoing delivery (Sections 82–83); checkout session (Section 43); onboarding (Section 68); compliance status (Section 67); reserve (Section 51); case (Section 81); daily close and accounting period (Sections 77–78).

Global rules: every transition is validated against the state machine; illegal transitions produce a state-conflict error; `UNKNOWN` means Wallet cannot yet prove whether money moved and blocks resubmission until resolved; payment success, merchant settlement, provider settlement, and reconciliation remain separate states; state names serialize exactly as defined because products map on them.

---

# 47. Allocations

## 47.1 Allocation Record

A payment allocation shall specify:

```text
gross_amount_minor             provider_fee_minor             provider_fee_bearer
citrus_fixed_fee_minor         citrus_percentage_fee_minor    citrus_total_commission_minor
merchant_gross_minor           merchant_net_minor             tax_withheld_minor
reserve_minor                  refund_reserve_minor           chargeback_reserve_minor
rounding_adjustment_minor      currency                       calculation_version
```

An allocation must additionally account for fraud reserve and rolling reserve where policy creates them, and authorised adjustments.

## 47.2 Balancing Invariant

```text
gross payment
=
merchant net
+ Citrus commission
+ provider fees deducted from the payment
+ tax withheld
+ reserves
+ authorised adjustments
```

**The database shall reject an unbalanced allocation.** Allocation rows shall be immutable after provider submission; corrections use a replacement instruction or adjustment transaction.

## 47.3 Versioning

Payment allocations, allocation items, commission policies, fee policies, tax policies, reserve policies, provider fee schedules, merchant commercial-policy versions, settlement instructions, and settlement-instruction items are all versioned domains. Allocation and policy versions must be preserved historically. **A later policy change must not recalculate a historical payment.**

## 47.4 Settlement Instructions

Where the provider accepts split or settlement instructions, Wallet records the instruction and its items as an immutable snapshot; contract tests must prove the provider instruction and provider statement match Wallet's allocation.

## 47.5 Allocation Events

`payment.allocation_created`, `payment.allocation_validated`, `payment.allocation_submitted`, `payment.allocation_adjusted` shall be recorded; product webhook exposure is limited to events the product needs.

## 47.6 Commercial-Policy References

Wallet shall preserve the commercial policy applied at transaction creation: Servana commission plan; cancellation policy; refund policy; deposit policy; merchant payout policy; tax policy; settlement schedule; reserve policy. Servana remains the source of business policy; Wallet receives a versioned policy reference and validates that it is registered and active. Historical payments shall not be recalculated when a merchant changes plan.

---

# 48. Fees

The fee engine shall support: fixed Citrus fee; percentage Citrus fee; tiered fee; minimum fee; maximum fee; provider fee; provider fee pass-through; merchant-borne fee; Citrus-borne fee; customer-borne fee only where contractually and legally permitted; inclusive pricing; exclusive pricing; fee-waiver periods; promotional fee versions; fee effective dates; and rounding policy.

Fee calculations shall be deterministic and versioned. Every fee policy shall include:

```text
calculation_basis    rounding_mode      minimum_minor      maximum_minor
effective_from       effective_until    tax_inclusive      fee_bearer
refund_treatment     chargeback_treatment
```

Actual provider fees shall be captured from provider evidence and reconciled against the versioned provider fee schedule; variances raise reconciliation exceptions.

---

# 49. Commissions

Commission policies and versions define Citrus's fixed and percentage commission per transaction, with minimum and maximum bounds and deterministic rounding. Under `MERCHANT_GROSS_CITRUS_SEPARATE_BILLING`, commissions become Citrus commission receivables billed separately to the merchant; under `PROVIDER_SPLIT_SETTLEMENT`, commissions are allocated within the payment allocation. Commission-policy creation and activation are segregated (creator ≠ activator). Reports shall distinguish commission earned, billed, and collected.

---

# 50. Taxes

Wallet shall not act as the tax authority, but shall preserve the data needed for correct accounting and reporting: VAT classification where applicable; withholding-tax classification where applicable; provider-fee tax treatment; Citrus commission tax treatment; merchant gross and net reporting; tax-invoice reference; tax policy version; tax amount in minor units; tax jurisdiction; and tax evidence. Tax rules shall be configuration-driven and require finance or tax approval. No product may submit an arbitrary tax amount without Wallet validation. Tax and withholding treatment for the merchant flows is a recorded blocking decision until professional sign-off (Section 118.4).

---

# 51. Reserves

Reserve types:

```text
REFUND_RESERVE   CHARGEBACK_RESERVE   FRAUD_RESERVE
ROLLING_RESERVE  MANUAL_RISK_RESERVE  PROVIDER_RESERVE
```

Reserve states:

```text
PROPOSED   ACTIVE   PARTIALLY_RELEASED   RELEASED   APPLIED   EXPIRED   DISPUTED   CANCELLED
```

Wallet shall record whether a reserve is: held by PesaPal; held in a Citrus-controlled account; represented only as a contractual deduction; unavailable for settlement; merchant-specific; payment-specific; or batch-specific. Reserve movements cannot release more than the active reserve balance (database-enforced). Reserve creation and release are segregated above a configured threshold; release schedules are versioned; a reserve shall not be represented as liquid merchant funds. Reserve events (`created`, `increased`, `partially_released`, `released`, `applied`) are recorded.

---

# 52. Merchant Financial Positions

The platform must not display one ambiguous merchant "balance." It must distinguish, per merchant:

```text
pending collection            successful collection         expected settlement
provider-confirmed settlement settled funds                 held funds
reserve                       merchant payable              merchant receivable
Citrus receivable             refund liability              chargeback liability
negative balance              reconciliation exception
```

Each component identifies its freshness and evidence source. The merchant financial position feeds the position dashboard (Section 88.6), statements (Section 54), offboarding closure checks (Section 70), and negative-balance management (Section 63).

---

# 53. Merchant Settlements

A first-class merchant settlement aggregate shall track provider settlement of merchant funds.

States:

```text
NOT_APPLICABLE   EXPECTED   AWAITING_PROVIDER   PROVIDER_CONFIRMED   IN_TRANSIT
SETTLED   PARTIALLY_SETTLED   DELAYED   HELD   RETURNED   FAILED   CANCELLED
UNKNOWN   RECONCILIATION_EXCEPTION
```

Each merchant settlement shall include:

```text
merchant_account_id            provider_merchant_account_id   settlement_destination_version_id
payment_allocation_id          gross_minor                    deductions_minor
net_minor                      currency                       expected_settlement_date
provider_settlement_reference  provider_batch_reference       bank_or_wallet_reference
actual_settlement_date         settlement_sla_deadline        hold_reason
return_reason                  reconciliation_status
```

Payment success shall not imply merchant settlement. Settlement events (`created`, `expected`, `provider_confirmed`, `settled`, `partially_settled`, `delayed`, `held`, `returned`, `failed`, `unknown`, `reconciliation_exception`) are recorded immutably. Partial, delayed, duplicate, and returned settlements are each explicit, tested paths. Merchant settlement net must equal the allocation merchant net after authorised adjustments (database-enforced).

**Settlement calendars.** Expected settlement dates shall be calculated from versioned settlement calendars modelling: business days; weekends; Kenyan public holidays; provider-specific non-processing days; settlement cut-off time; settlement delay by payment method; same-day or real-time eligibility; next-day settlement; provider holding period; reserve release schedule; and timezone. Calendar changes shall not rewrite historical expected dates.

**Settlement SLA monitoring.** The dashboard shall show settlements due today; settlements overdue; value overdue; provider-specific and merchant-specific settlement aging; destination failures; returned settlements; holds; unreconciled settlements; average settlement duration; and SLA breach count. Alerts shall be raised before and after settlement SLA breach.

---

# 54. Settlement Destinations (Operational Requirements)

In addition to the registry requirements of Section 25:

1. **Destination pinning.** Every merchant settlement and settlement instruction pins the destination version applicable at instruction time.
2. **Wrong-destination containment.** A provider settlement to a destination other than the pinned version is automatically classified as a critical exception (wrong-destination reconciliation, Section 76).
3. **Out-of-band notification.** Destination changes notify the merchant's verified contacts through a channel independent of the change request.
4. **Cooling-off.** No settlement to a newly activated destination until the cooling-off period elapses, unless an authorized, audited override with reason is recorded.
5. **Fraud posture.** Settlement-destination fraud is a named threat with a tested attack scenario (Section 93) and a dedicated runbook.

---

# 55. Settlement Calendars

Settlement calendars and their rules are versioned registry entities (fields per Section 53). Calendars are seeded per provider and payment method at launch; changes require configuration approval and never rewrite historical snapshots.

---

# 56. Merchant Statements

Wallet shall generate merchant statements that do not expose unrelated Citrus financial information.

A merchant statement shall include: statement period; merchant legal and display name; merchant account reference; provider merchant identifier in masked form; opening payable or settlement position; customer payments; refunds; reversals; chargebacks; provider fees; Citrus commissions; taxes withheld; reserves created; reserves released; settlement transfers; returned settlements; adjustments; closing position; reconciliation status; statement generation timestamp; statement version; and support reference.

Statements shall be reproducible from immutable source records. Statement line totals must equal the statement summary (database-enforced). No statement shall call an internal ledger balance a bank balance or deposit. Statement delivery to merchants occurs through Servana (signed URLs or product webhooks, subject to authorization); merchant statement totals must equal ledger and provider evidence before launch acceptance.

---

# 57. Payouts

Wallet by Citrus shall support outbound payments through multiple payout gateways and multiple Citrus Labs funding sources.

## 57.1 Supported Payout Types

1. Single M-PESA B2C payout.
2. Bulk M-PESA B2C payout.
3. Single PesaLink payout.
4. Bulk PesaLink payout.
5. Direct bank API transfer.
6. Provider-aggregated bank payout.
7. Provider-wallet payout.
8. Supplier payment.
9. Marketplace settlement generated by a Citrus Labs product — only under an approved provider arrangement and funds-flow model.
10. Customer withdrawal generated by a Citrus Labs product.
11. Customer compensation.
12. Product-operational disbursement.
13. Salary or contractor payment only when separately approved by Citrus Labs policy.
14. Refund implemented as a linked outbound payout when a native refund is unavailable.

Merchant settlement payouts (payouts that discharge merchant payables under `CITRUS_COLLECTION_MERCHANT_PAYOUT`) remain available only for manual adjustments, compensation, corrections, refund alternatives, and marketplace settlement under an approved provider arrangement. They shall not automatically be created for every successful customer collection unless the commercial and regulatory structure expressly supports that flow.

## 57.2 Funding-Source Constraint

Wallet shall only select funding sources that have been formally onboarded and technically exposed by the relevant bank or provider. The platform shall not assume that an API request can debit any Citrus Labs bank account merely because Citrus Labs owns it.

Supported funding models: direct bank integration tied to a specific Citrus Labs bank account; provider account tied to a specific Citrus Labs bank account; provider wallet prefunded from a documented Citrus Labs bank account; dedicated M-PESA B2C disbursement balance; central treasury account used to fund approved payout routes; manual bank-file generation followed by controlled upload and reconciliation where no API exists.

## 57.3 Payout Record

Each payout shall include: public payout identifier; product; application; environment; merchant account; payout purpose; economic beneficiary fields; external reference; idempotency key; amount; currency; beneficiary; beneficiary destination (pinned version); payment method; provider; provider account; funding bank account; provider wallet; provider transaction identifier; approval policy and state; risk state; payout state; reconciliation state; fee; tax where applicable; narrative; immutable route snapshot; attempt history; callback history; status-query history; failure category; retry eligibility; cancellation eligibility; created by; approved by; submitted by system job; completion timestamp.

## 57.4 Payout State Machine

```text
DRAFT   VALIDATION_FAILED   AWAITING_APPROVAL   PARTIALLY_APPROVED   APPROVED
REJECTED   CANCELLED   QUEUED   RESERVED   SUBMITTING   SUBMITTED
PROVIDER_ACCEPTED   PROCESSING   SUCCEEDED   FAILED   TIMED_OUT   UNKNOWN
REVERSAL_REQUESTED   REVERSED   RECONCILIATION_EXCEPTION
```

`UNKNOWN` shall mean that Wallet cannot yet prove whether money moved. An `UNKNOWN` transaction shall not be resubmitted through another route until its prior status is resolved.

---

# 58. Bulk Payouts

## 58.1 Bulk Payout Workflow

1. A product or authorized user creates a batch.
2. The platform validates the batch metadata.
3. The platform validates every line independently.
4. Duplicate references and duplicate beneficiaries are flagged according to policy.
5. Invalid items are isolated and explained.
6. Valid items receive a dry-run result.
7. The platform calculates totals, fees, source requirements, and route availability.
8. The platform performs risk checks.
9. The batch enters the required approval workflow.
10. Approved funds are reserved internally where the balance model supports reservation.
11. Individual payout jobs are queued.
12. Provider requests are rate-limited.
13. Every item receives an independent status.
14. Missing callbacks trigger controlled status queries.
15. Reconciliation confirms settlement.
16. Signed product webhooks report item and batch changes.
17. Users can download a result file.
18. Failed eligible items may be copied into a new batch after investigation.

## 58.2 Batch File Requirements

The platform shall support a documented CSV template with fields: `external_reference`, `beneficiary_name`, `destination_type`, `destination`, `bank_code`, `amount`, `currency`, `narrative`, `product_reference`, `merchant_account_reference`.

The import process shall include: content-type validation; extension validation; malware scanning; maximum file size; maximum row count; character-encoding validation; header validation; duplicate-row detection; formula-injection protection for exports; empty-row handling; numeric precision validation; currency validation; phone and bank-account validation; safe storage outside public paths; immutable original-file retention according to policy; and a downloadable error report.

A batch status shall never hide the item-level result. A batch may be partially successful. Batch states: `DRAFT`, `VALIDATING`, `VALIDATION_FAILED`, `AWAITING_APPROVAL`, `PARTIALLY_APPROVED`, `APPROVED`, `REJECTED`, `CANCELLED`, `EXECUTING`, `PARTIALLY_COMPLETED`, `COMPLETED`, `COMPLETED_WITH_FAILURES`.

---

# 59. Beneficiaries

Beneficiaries shall be explicit, verified domain records rather than unvalidated free-text fields copied into payout requests.

A beneficiary record shall include: person or organization name; beneficiary type; product customer reference; merchant-account reference; M-PESA number; bank name; bank code; bank account number stored encrypted; masked bank account number; currency; country; verification state; verification method; verification evidence; risk state; last successful payout; last failed payout; creation source; last change source; status.

Changes to a beneficiary destination shall: create a new version; invalidate pending approvals that relied on the old version; require revalidation; require maker-checker approval where configured; be audit logged; and never rewrite the destination snapshot of historical payouts.

A refund shall not be redirected to a new phone number or bank account without enhanced verification, explicit reason, and the required approval.

---

# 60. Refunds

A refund shall be a separate financial entity linked to a successful original collection.

The system shall support: full refund; partial refund; multiple partial refunds up to the remaining refundable amount; native provider refund where available (including PesaPal refunds, returning to the original payment instrument where provider rules require); eligible provider reversal; M-PESA B2C refund; PesaLink or bank refund; and manual refund requiring evidence and later reconciliation.

Each successful collection shall expose: gross amount; provider fee; product fee; previously refunded amount; pending refund amount; available refundable amount; refund deadline where applicable; supported refund routes; original destination; and settlement status.

Refund validation shall confirm:

1. The original payment succeeded.
2. The original payment is not fully reversed.
3. The refund amount is greater than zero.
4. The refund amount does not exceed the remaining refundable amount.
5. Concurrent refund requests cannot over-refund the payment.
6. Currency matches the original currency unless an approved manual process applies.
7. The application has refund permission.
8. The user has refund permission.
9. The required approval has been obtained.
10. The destination is verified.
11. Sufficient funding is available.
12. There is no unresolved duplicate request.
13. The route is permitted for the product.
14. The original transaction is not under a blocking dispute, chargeback, compliance hold, or legal hold.
15. The refund-funding party is determined (not `UNDETERMINED_BLOCKED`).

The refund workflow shall additionally identify: original economic beneficiary; original settlement status; amount already settled to the merchant; available provider balance; merchant reserve available; merchant negative-balance impact; Citrus funding impact; provider refund eligibility; refund destination; refund fee treatment; tax adjustment; and the product cancellation reference.

Refund amounts shall be protected by row-level locking, serializable transaction logic, or another proven concurrency control so two simultaneous requests cannot exceed the refundable balance. Refund states: `REQUESTED`, `AWAITING_APPROVAL`, `APPROVED`, `REJECTED`, `SUBMITTING`, `SUBMITTED`, `PROCESSING`, `SUCCEEDED`, `FAILED`, `TIMED_OUT`, `UNKNOWN`, `CANCELLED`.

Refunds before merchant settlement and refunds after merchant settlement follow different posting templates (Section 72.3) and different funding paths (merchant reserve, merchant negative balance, provider, or Citrus, per the route's refund-funding party).

---

# 61. Reversals

A reversal shall be treated as a provider request to undo an eligible original transaction. It shall not be treated as guaranteed.

A reversal record shall include: original transaction; reversal reason; provider eligibility result; requesting user or application; approval state; provider account; provider request identifier; result identifier; status; callback history; status-query history; reconciliation result; ledger treatment; and final resolution.

Reversal states: `REQUESTED`, `AWAITING_APPROVAL`, `APPROVED`, `SUBMITTED`, `PROCESSING`, `SUCCEEDED`, `FAILED`, `REJECTED`, `TIMED_OUT`, `UNKNOWN`, `MANUAL_REVIEW`.

A failed reversal may lead to a separately approved refund payout; the system preserves both records and their relationship. Unsolicited provider reversals create a reversal record attributed to the provider and are reconciled.

---

# 62. Chargebacks

A full chargeback domain shall exist for card and other reversible payment methods, launch-capable before any card-enabled route activates.

Entities: chargebacks; chargeback events; chargeback evidence; chargeback adjustments.

States:

```text
RECEIVED   NOTIFIED   EVIDENCE_REQUIRED   EVIDENCE_SUBMITTED   UNDER_PROVIDER_REVIEW
WON   LOST   PARTIALLY_WON   ACCEPTED   EXPIRED   CLOSED
```

A chargeback shall identify: original payment; merchant; provider; reason code; disputed amount; provider fee; response deadline; evidence owner; funds debited; reserve impact; merchant payable impact; Citrus revenue impact; final result; and reconciliation status.

Controls: chargeback deadlines generate escalating alerts; a chargeback may not exceed the original eligible amount plus provider-permitted fees (database-enforced); duplicate provider chargeback events are idempotent; chargeback wins and losses follow the posting templates of Section 72.3; chargeback-responsible party per transaction derives from contract — where the PesaPal contract has not yet allocated chargeback responsibility, the route's chargeback responsibility is a recorded blocking decision and card-enabled routes shall not activate (Section 118.4).

---

# 63. Negative Balances

A merchant negative balance may arise from: refunds after prior settlement; chargebacks; returned settlements; provider fee corrections; fraud losses contractually assigned to the merchant; Citrus fee reversals; and manual approved adjustments.

Negative-balance handling shall support: collection offset where contractually allowed; future settlement offset; separate merchant invoice; merchant account hold; escalation; write-off approval; legal collection; and evidence and audit.

Rules:

1. Wallet shall not silently debit an unrelated merchant settlement; negative-balance offsets cannot cross merchant accounts (database-enforced).
2. Every offset is explicit, policy-backed, ledgered, and reported.
3. Negative balances appear in the merchant financial position, statements, dashboards, and alerts.
4. **No silent financial netting.** Wallet shall not silently net unrelated merchants; unrelated products; unrelated currencies; customer refunds against another customer's payment; Citrus fees against merchant funds without contractual authority; or provider fees against merchant settlements without policy.

---

# 64. Internal Treasury Transfers

Wallet shall support recording and controlling internal transfers between verified Citrus Labs funding sources: bank account to provider wallet; bank account to M-PESA B2C balance; collection account to treasury account; treasury account to payout account; provider wallet withdrawal to bank; and transfers between Citrus Labs bank accounts through an approved bank integration.

An internal transfer shall not be presented as a customer payout. It shall have its own entity, state machine, approval policy, ledger entries, evidence, and reconciliation process.

---

# 65. Approval Workflows

Approval policies shall be configurable rather than hard-coded. Policies may consider: product; merchant account; direction; amount; currency; new or existing beneficiary; beneficiary change recency; provider; funding source; transaction risk score; batch size; user role; business hours; product policy; and compliance hold.

The platform shall support: automatic approval for permitted low-risk transactions; single approver; maker-checker; two distinct approvers; finance approver plus senior approver; risk or compliance approval; owner approval for provider-account or bank-account changes; approval expiry; approval delegation with effective dates; rejection with mandatory reason; and reapproval after material changes.

Material changes include: amount change; currency change; beneficiary change; destination change; provider route change; funding-source change; product or merchant-account change; and narrative change where policy considers the narrative material. Approval-request states: `PENDING`, `PARTIALLY_APPROVED`, `APPROVED`, `REJECTED`, `EXPIRED`, `INVALIDATED`.

Approvals extend beyond payouts to: settlement destinations; provider merchant activation; commission, fee, tax, and reserve policy activation; reserve release; compliance holds; provider capability activation; daily close; accounting-period reopen; bank-account activation; route activation; and ledger corrections. The creator shall not approve their own controlled action (segregation matrix, Section 17).

---

# 66. Risk Controls

Wallet shall support configurable, launch-capable controls for:

1. Transaction amount thresholds and limits (payment, payer, merchant, provider merchant account, route, day, month, method, product — Section 108.3).
2. Transaction velocity by payer and by merchant.
3. Repeated failed attempts and repeated failed payout detection.
4. Repeated refund patterns and abnormal payment-to-refund ratio.
5. Mismatched payer and booking data; duplicate customer reference; duplicate amount and timing patterns; duplicate destination detection.
6. Newly changed settlement destination holds; newly onboarded merchant controls; new-beneficiary limits; recently changed beneficiary holds.
7. Unusual trading hours and high-risk time-of-day rules.
8. High-risk merchant category rules; excessive partial payments.
9. Provider risk signals; provider-health controls; low-liquidity controls.
10. Manual watchlists; known compromised payer identifier hashes; account suspension.
11. Manual review queues (pre-execution and post-execution) for high-value payments, suspicious patterns, new merchants, recently changed destinations, provider mismatches, settlement anomalies, unusual refund requests, and chargeback evidence deadlines. Review decisions are recorded and immutable.
12. Compliance holds; sanctions or watchlist integration where legally and operationally required; suspicious pattern alerts; approval escalation; temporary account suspension; manual override with reason and audit.

Risk decisions: `ALLOW`, `ALLOW_WITH_MONITORING`, `REVIEW`, `HOLD`, `DENY`. A risk hold shall preserve the original instruction and reason; risk rules shall not silently change transaction amounts, destinations, or routes.

---

# 67. Compliance Eligibility

A risk-and-compliance eligibility layer shall exist at first launch, even where PesaPal performs the primary regulated screening. Wallet shall record — not fabricate — the outcome of: KYB verification; beneficial-owner verification; sanctions screening; politically-exposed-person screening where applicable; adverse-media review where applicable; prohibited-business classification; merchant risk rating; transaction-monitoring responsibility; provider compliance status; and periodic review due date.

Compliance states:

```text
NOT_REQUIRED   PENDING   CLEAR   REVIEW_REQUIRED   RESTRICTED   FAILED   EXPIRED   PROVIDER_MANAGED
```

A provider-managed status shall identify the provider, policy version, last verification date, and evidence reference. Wallet shall support compliance holds on: new collections; settlements; refunds; destination changes; merchant payouts; and provider-account activation. Compliance holds shall not silently change transaction amounts or beneficiaries. KYB expiry shall be monitored; expiry pauses affected routes and alerts.

**Regulatory boundary.** Before production launch, Citrus Labs Limited shall obtain appropriate Kenyan legal, financial, tax, privacy, and compliance advice covering: National Payment System classification; payment-service-provider authorization risk; merchant-of-record structure; settlement-account structure; trust or safeguarding requirements where applicable; AML and CFT obligations; customer identification requirements; beneficial-owner verification; consumer complaint handling; data-controller and data-processor obligations; cross-border processing; record-retention requirements; tax treatment; refund and reversal obligations; and provider contractual restrictions. The platform shall not claim that internal architecture alone removes regulatory obligations. A route-specific provider money-flow assessment (Section 116.3) is additionally required for every merchant funds-flow route.

---

# 68. Merchant Onboarding

Wallet shall include an internal merchant provider-onboarding workflow (public Wallet self-registration remains out of scope). The workflow shall support:

1. Receipt of an approved merchant identity from Servana.
2. Verification that the Servana merchant account is active.
3. Collection or synchronization of provider-required documents.
4. Merchant legal-name verification.
5. Business registration-number verification.
6. Tax identifier capture where required.
7. Beneficial-owner and director information where required.
8. Business address and contact verification.
9. Business-category and prohibited-business classification.
10. Settlement destination submission.
11. Provider application submission.
12. Provider review status.
13. Provider rejection reason.
14. Remediation requests.
15. Approval expiry.
16. Periodic re-verification.
17. Suspension.
18. Offboarding.
19. Document retention.
20. Audit evidence.

Wallet shall not independently invent merchant KYB rules; required data is driven by provider contract, applicable law, Citrus risk policy, and product merchant policy.

Onboarding states:

```text
NOT_STARTED   DATA_REQUIRED   DOCUMENTS_PENDING   READY_FOR_SUBMISSION
SUBMITTED_TO_PROVIDER   PROVIDER_REVIEW   REMEDIATION_REQUIRED   APPROVED
REJECTED   SUSPENDED   EXPIRED   OFFBOARDING   CLOSED
```

Controls: no production collection route before `APPROVED`; no settlement-destination activation before verification; no use of expired documents where provider policy prohibits it; no manual approval by the same person who entered sensitive destination data; all provider rejections preserved; no deletion of historical onboarding evidence.

---

# 69. Merchant Suspension

Servana remains the source of merchant commercial status; Wallet receives status changes through the authenticated synchronization API or signed webhook. Status effects shall be explicit:

| Status | Effect |
|---|---|
| `ACTIVE` | Normal operation. |
| `PAYMENTS_SUSPENDED` | Block new payment creation; continue status queries, refunds, reconciliation, and existing settlement processing according to policy. |
| `SETTLEMENTS_SUSPENDED` | Allow collection only where legally and contractually permitted; otherwise block collection. |
| `REFUNDS_ONLY` | Prohibit new collection and payout; permit approved refunds. |
| `OFFBOARDING` | Prohibit new activity; resolve open items. |
| `CLOSED` | No new transactions; historical records remain available. |
| `COMPLIANCE_HOLD` | Follow the legal/compliance hold instructions; preserve evidence. |

A product-side suspension shall not erase provider-side or ledger obligations. Suspension propagation is tested (suspended merchant cannot create a new payment; historical reporting remains available to authorized internal users).

---

# 70. Merchant Offboarding

A complete merchant-offboarding workflow shall handle:

1. Pending customer payments.
2. Unsettled provider balances.
3. Pending settlements.
4. Outstanding Citrus fees.
5. Open refunds.
6. Open disputes.
7. Open chargebacks.
8. Reserves.
9. Negative balances.
10. Incomplete reconciliation.
11. Provider merchant-account closure.
12. Settlement-destination closure.
13. Data retention.
14. Final merchant statement.
15. Final tax and fee statement.
16. Final operational sign-off.

A merchant account shall not become `CLOSED` while unresolved financial obligations remain; it shall remain in `OFFBOARDING` or `CLOSURE_BLOCKED`. Merchant closure blocked by a negative balance is a tested invariant.

---

# 71. Ledger

The ledger shall be Wallet by Citrus's internal financial source of truth.

## 71.1 Ledger Principles

1. Every posted financial event shall create balanced debit and credit entries.
2. Posted entries shall be immutable.
3. Corrections shall use reversing or compensating entries.
4. Money shall be stored in integer minor units.
5. Every amount shall include a currency; every ledger transaction shall balance by currency.
6. Provider callbacks shall not directly modify balances; a validated domain event causes ledger posting.
7. Ledger posting shall be idempotent (unique posting key per financial event) and atomic.
8. Product, merchant account, provider, provider merchant account, bank, route, funds-flow, and policy-version dimensions shall be retained.
9. Historical ledger entries shall not change when configuration changes.

## 71.2 Ledger Account Categories

The chart of accounts shall support: bank assets; provider-wallet assets; clearing assets; settlement receivables; product revenue; product liabilities; customer refund liabilities; payout liabilities; provider fee expenses; platform fee revenue; tax liabilities; suspense accounts; unidentified collection accounts; reconciliation adjustment accounts; chargeback and dispute accounts; and the merchant-finance accounts:

```text
Merchant payable — per product — merchant-specific or dimensional
Merchant settlement clearing
Provider direct-settlement clearing
Split-settlement clearing
Merchant refund liability
Merchant chargeback receivable
Merchant reserve liability
Merchant negative-balance receivable
Citrus commission receivable
Citrus commission revenue
Provider fee expense
Provider fee recoverable from merchant
Tax withholding payable
Unallocated merchant funds suspense
Reconciliation adjustment
```

**Merchant funds shall never be posted to Citrus revenue merely because they passed through a Citrus-controlled provider account or bank account.** Merchant money is represented as a liability or clearing balance, never as Citrus cash revenue.

## 71.3 Product Separation

Even when products share a PayBill, provider account, or bank account, product-specific ledger dimensions or accounts (for example `Kikao collection revenue`, `Servana refund liability`, `SkillFlow provider fee expense`, per-product payout liabilities, and the shared clearing accounts `Citrus Labs M-PESA collection clearing`, `Citrus Labs M-PESA B2C clearing`, `Citrus Labs PesaLink clearing`, PesaPal clearing) shall prevent mixed reporting.

## 71.4 Suspense Handling

Unmatched provider transactions shall post to a controlled suspense account only after defined validation. Suspense resolution shall require evidence, authorization, and an audit trail. A suspense record shall never be silently assigned to a product or a merchant.

---

# 72. Accounting Posting Rules

## 72.1 Posting Invariants

Every posting must: balance by currency; use integer minor units; be atomic with its domain state change; use an idempotent posting key; preserve ownership dimensions; preserve policy versions; preserve route snapshots; be immutable after posting; and use compensating entries for corrections. Posting directives are policy-versioned.

## 72.2 Posting-Template Catalogue

Detailed posting templates shall exist for all sixteen event families: (1) merchant-to-Citrus collections; (2) provider direct merchant settlement; (3) merchant gross settlement with separate Citrus billing; (4) provider split settlement; (5) Citrus collection followed by merchant payout; (6) refund before merchant settlement; (7) refund after merchant settlement; (8) chargeback win; (9) chargeback loss; (10) reserve creation; (11) reserve release; (12) negative-balance creation; (13) negative-balance recovery; (14) settlement return; (15) manual adjustment; (16) reconciliation correction.

## 72.3 Normative Templates

**(1) Merchant-to-Citrus collection.** At payment success: Debit provider collection receivable; Credit Citrus receivable or revenue according to revenue-recognition policy; Credit tax payable where applicable. At settlement: Debit Citrus settlement bank asset; Debit provider fee expense where Citrus bears it; Credit provider collection receivable.

**(2) Provider direct merchant settlement (with separate Citrus billing).** At customer payment success: Debit provider merchant-settlement receivable; Credit merchant settlement clearing; Credit provider fee payable or fee-clearing account according to fee bearer. At provider merchant settlement: Debit merchant settlement clearing; Credit provider merchant-settlement receivable. Citrus commission via separate merchant invoice: Debit merchant commission receivable; Credit Citrus commission revenue; Credit tax payable where applicable. At merchant payment of the Citrus invoice: Debit Citrus collection bank or provider receivable; Credit merchant commission receivable.

**(3) Merchant gross settlement with separate Citrus billing** uses template (2)'s structure with the gross amount settling to the merchant and commission billed separately.

**(4) Provider split settlement.** At customer payment success: Debit provider settlement receivable — total gross; Credit merchant settlement clearing — merchant net; Credit Citrus commission receivable or revenue; Credit provider fee payable or clearing; Credit tax withholding payable; Credit merchant reserve liability. At merchant settlement: Debit merchant settlement clearing; Credit provider settlement receivable. At Citrus settlement: Debit Citrus bank or provider asset; Credit provider settlement receivable.

**(5) Citrus collection followed by merchant payout** (only behind the disabled funds-flow model). At collection: Debit Citrus bank or provider receivable; Credit merchant payable; Credit Citrus commission revenue; Credit tax payable or fee accounts. At merchant payout: Debit merchant payable; Credit Citrus payout bank or provider asset. No merchant payout until the original collection is final, allocated, risk-cleared, and reconciled.

**(6) Refund before merchant settlement.** Debit merchant settlement clearing (or the applicable receivable/revenue account per funds-flow); Credit customer refund payable. At refund execution: Debit customer refund payable; Credit provider or bank asset (or provider receivable where the provider funds the refund from unsettled funds).

**(7) Refund after merchant settlement** (merchant responsible): Debit merchant refund receivable or merchant reserve liability; Credit customer refund payable. At execution: Debit customer refund payable; Credit provider or bank asset. Where the receivable is unrecovered it becomes a merchant negative-balance receivable (template 12).

**(8) Chargeback win.** Reverse any provisional debit: Debit provider settlement receivable or bank asset; Credit merchant chargeback receivable (or reverse the provisional loss entries); release any chargeback reserve applied (template 11).

**(9) Chargeback loss.** Debit merchant chargeback receivable, merchant reserve liability, or Citrus loss according to contract; Debit provider chargeback fee expense or merchant recoverable; Credit provider settlement receivable or bank asset.

**(10) Reserve creation.** Debit merchant settlement clearing (withheld from settlement) or provider settlement receivable; Credit merchant reserve liability.

**(11) Reserve release.** Debit merchant reserve liability; Credit merchant settlement clearing (for onward settlement) or the applicable payable.

**(12) Negative-balance creation.** Debit merchant negative-balance receivable; Credit the account that absorbed the outflow (customer refund payable, provider settlement receivable, or bank asset).

**(13) Negative-balance recovery.** Debit merchant settlement clearing (offset), Citrus collection receivable (invoice), or bank asset (direct payment); Credit merchant negative-balance receivable.

**(14) Settlement return.** Debit provider merchant-settlement receivable (funds returned to provider) or bank asset; Credit merchant settlement clearing; the settlement re-enters `RETURNED` handling and a replacement instruction requires an active destination version.

**(15) Manual adjustment.** Debit/Credit the specific approved accounts named in the adjustment approval; always maker-checker approved, evidence-backed, and reason-captured.

**(16) Reconciliation correction.** Compensating entries only, posted through the exception-resolution workflow with approval; never edits to posted entries.

The exact fee entry in each template depends on who contractually bears the provider fee; the fee-bearer is read from the allocation, never assumed.

---

# 73. Settlement

Payment success and bank settlement shall be tracked separately. Settlement management (Citrus-side settlements) shall include: expected settlement date; actual settlement date; settlement bank account; provider account; gross amount; provider fee; taxes and deductions; net amount; settlement batch identifier; provider statement identifier; bank statement identifier; settlement status; reconciliation status; variance amount; variance reason; aging; and escalation status.

Settlement states: `NOT_APPLICABLE`, `EXPECTED`, `PENDING`, `PARTIALLY_SETTLED`, `SETTLED`, `DELAYED`, `UNDERPAID`, `OVERPAID`, `FAILED`, `RECONCILIATION_EXCEPTION`.

Merchant settlements are the separate aggregate of Section 53. A settlement combining transactions from multiple Citrus products is allocated by transaction-level records while preserving the shared settlement batch. A settlement reaching a different account than configured raises a critical route exception.

---

# 74. Provider Balances

Wallet shall monitor provider wallets, B2C balances, PesaPal balances where queryable, and other prefunded sources where APIs or statements permit. Balance records include: provider account; funding source; currency; available balance; ledger balance; reserved amount; pending amount; minimum operating threshold; critical threshold; last provider query timestamp; data freshness; query result status; and variance.

Alerts shall fire when: a balance falls below the operating threshold; a balance query fails repeatedly; provider balance differs materially from the internal ledger; a payout batch exceeds available or approved liquidity; a provider wallet requires prefunding; or a bank account expected to fund a route is inactive. A stale provider balance shall be visibly marked and shall not be treated as current proof of funds.

---

# 75. Liquidity

Liquidity management shall include: operating and critical thresholds per funding source; prefunding procedures; reservation of approved funds for batches where the balance model supports it; holds when an approved batch exceeds available funds at execution time (no uncontrolled negative balances); and treasury-transfer workflows (Section 64) to rebalance funding sources. Under `MERCHANT_GROSS_CITRUS_SEPARATE_BILLING` and `PROVIDER_DIRECT_MERCHANT_SETTLEMENT`, Citrus carries no merchant-settlement liquidity requirement; the disabled `CITRUS_COLLECTION_MERCHANT_PAYOUT` model would create one and its liquidity policy is part of its activation gate.

---

# 76. Reconciliation

Reconciliation shall use multiple sources of truth rather than relying only on callbacks: provider callbacks and IPNs; transaction-status queries; pull-transaction APIs where available; provider statements; settlement reports; merchant statements where available; fee, refund, chargeback, and reserve reports; bank statements; provider-wallet statements; internal ledger entries; allocations; and product-origin records.

## 76.1 Reconciliation Layers

1. **Provider transaction reconciliation** — internal records vs. provider records (Daraja and PesaPal).
2. **Payment-allocation reconciliation** — allocation components vs. provider fee and settlement evidence.
3. **Provider-fee reconciliation** — actual fees vs. versioned fee schedules (variance exceptions).
4. **Citrus-commission reconciliation** — commission earned vs. billed vs. collected.
5. **Merchant-net reconciliation** — allocation merchant net vs. provider settlement evidence.
6. **Merchant-settlement reconciliation** — expected vs. provider-confirmed vs. settled, including partial, duplicate, and returned settlements.
7. **Settlement-destination reconciliation** — pinned destination version vs. provider-reported destination.
8. **Merchant-statement reconciliation** — statement totals vs. ledger and provider evidence.
9. **Reserve reconciliation** and **negative-balance reconciliation** — balances vs. movements and provider reports.
10. **Refund reconciliation** and **chargeback reconciliation** — including unmatched refunds and chargebacks.
11. **Provider-contract fee-schedule reconciliation** — contract terms vs. observed behaviour.
12. **Bank reconciliation** — bank statements vs. ledger and settlements.
13. **Product reference reconciliation** — product records vs. Wallet records.
14. **Three-way reconciliation** (customer-to-merchant payments): Wallet payment and allocation ↔ PesaPal transaction and fee record ↔ PesaPal settlement or merchant statement. **Four-way** where funds touch a Citrus-controlled bank or mobile wallet (add the bank/wallet statement). **Five-way** where the product records settlement expectations (add the Servana booking/invoice record).
15. **Ledger reconciliation** — trial balance by currency; ledger imbalance halts affected posting and raises a critical incident.

## 76.2 Reconciliation Schedules

Near-real-time checks for unresolved high-risk payouts; scheduled checks for missing callbacks; hourly reconciliation for recent critical transactions where supported; daily provider, allocation, settlement, and bank reconciliation; daily close (Section 77); month-end accounting reconciliation (Section 78); and on-demand reconciliation for investigations.

## 76.3 Detection Catalogue

Reconciliation must detect: wrong merchant; wrong provider merchant account; wrong settlement destination; incorrect gross; incorrect provider fee; incorrect Citrus commission; incorrect merchant net; missing settlement; partial settlement; duplicate settlement; returned settlement; wrong currency; wrong settlement date; missing refund; missing chargeback; reserve variance; negative-balance variance; provider payment missing internally; internal payment missing at provider; bank settlement missing; amount mismatch; product reference mismatch; merchant-account mismatch; duplicate provider transaction; unexpected reversal; unexpected refund; unreconciled fee; delayed payout; unknown transaction; settlement to the wrong configured account; payout funded from an unexpected source; transaction recorded against the wrong product; provider status inconsistent with bank evidence; ledger imbalance; and missing raw payload or statement evidence.

Materiality and escalation shall be configurable: value materiality; count materiality; age materiality; provider-specific and merchant-specific thresholds; and automatic critical classification where the wrong merchant or wrong destination is involved.

## 76.4 Statement and Settlement-File Ingestion

File ingestion (provider statements, settlement statements, fee reports, refund reports, chargeback reports, reserve reports, merchant onboarding reports, bank statements) shall support: file-hash deduplication; content-hash deduplication; schema versioning; quarantine of unparseable files with precise errors; line-level parse errors; unknown column preservation; source-account binding; period validation; currency validation; duplicate line detection; amount balancing; and manual review. A statement line matching multiple transactions creates an ambiguity exception. Provider and bank disagreement preserves both evidence sources and requires investigation.

## 76.5 Exception Resolution

Resolution requires: exception classification; assigned owner; investigation notes; evidence attachment; proposed correction; approval where financial posting changes; compensating ledger entry where needed; product notification where needed; final resolution code; and audit history. Exception states: `OPEN`, `ASSIGNED`, `INVESTIGATING`, `PROPOSED`, `AWAITING_APPROVAL`, `RESOLVED`, `DISMISSED`.

---

# 77. Daily Close

A daily close shall run for each launch provider account and merchant-settlement model. The daily close shall produce: opening provider position; successful collections; failed and unknown collections; refunds; reversals; chargebacks; fees; commissions; reserves; settlements expected; settlements completed; settlements overdue; merchant payables; Citrus receivables; unresolved exceptions; closing provider position; ledger trial balance; and reconciliation completion status.

The close shall not lock the ledger from valid late events. Late events shall be recorded in the current posting period with original provider timestamps and an adjustment to the affected business date. Close preparation and approval are segregated; an incomplete daily close raises an alert.

---

# 78. Accounting-Period Close

Month-end shall support: preliminary close; exception threshold check; provider statement completeness; bank statement completeness; settlement completeness; ledger trial balance; unresolved material exceptions check; finance sign-off; final close; controlled reopen with reason and approval; and reissued reports. No posted ledger entries shall be edited during reopen. A period close cannot be final while material exceptions exceed the policy threshold (database-enforced).

---

# 79. Exceptions

The exception domain covers all reconciliation, integration, routing, and integrity exceptions (detection catalogue in Section 76.3; resolution workflow in Section 76.5). Exceptions carry severity, ownership keys where known, linked references, evidence, and SLA timers (first-review SLA per Section 117). Wrong-merchant and wrong-destination exceptions are automatically critical.

---

# 80. Disputes

The dispute domain preserves all linked financial events for disputed transactions, including disputes raised after refund, and connects to chargebacks (Section 62) and cases (Section 81). A transaction under blocking dispute or compliance hold cannot be refunded, re-routed, or settled except through the dispute workflow.

---

# 81. Cases

A launch-capable internal case-management domain shall exist with entities: cases; case parties; case events; case notes; case evidence; case assignments; case SLA events.

Case types:

```text
PAYMENT_NOT_RECEIVED     DUPLICATE_PAYMENT       WRONG_AMOUNT          FAILED_PAYMENT
UNKNOWN_PAYMENT          REFUND_DELAY            SETTLEMENT_DELAY      SETTLEMENT_RETURN
CHARGEBACK               MERCHANT_ACCOUNT_ISSUE  MERCHANT_DESTINATION_ISSUE
SUSPECTED_FRAUD          UNRECOGNIZED_PAYMENT    PROVIDER_INCIDENT     BANK_INCIDENT
DATA_ACCESS_CONCERN      OTHER_FINANCIAL_COMPLAINT
```

Every case shall include: unique case reference; linked transaction or settlement references; parties and complainant type; merchant account; severity; priority; assigned owner; SLA and acknowledgement timestamp; investigation timeline; evidence; customer or merchant communication log; decisions; resolution; escalation; closure reason; reopen history; and audit history. Case events: `created`, `acknowledged`, `assigned`, `escalated`, `resolved`, `closed`, `reopened`.

Servana may remain the customer-facing support channel; Wallet provides the authoritative financial evidence and internal escalation record. Wallet shall not become the public customer-support interface by default. An immutable external communication log shall link provider, merchant, and product communications concerning a financial exception to the relevant case or transaction, preserving: message timestamp; sender; recipient; channel; subject; redacted body or evidence reference; attachments; response deadline; acknowledgement; and resolution relevance.

---

# 82. Incoming Webhooks

The ingestion pipeline of Section 44 applies to all incoming provider events (Daraja callbacks, PesaPal IPNs, bank notifications, future providers). Incoming-webhook states: `RECEIVED`, `ACKNOWLEDGED`, `QUEUED`, `PROCESSED`, `IGNORED_REPLAY`, `FAILED_VALIDATION`, `EXCEPTION`. Raw payloads are stored immutably before any processing; all processing attempts are recorded; oversized payloads are rejected before parsing; replay is detected by payload hash and provider identifiers.

---

# 83. Outgoing Product Webhooks

Wallet shall notify integrated products through signed, versioned, retryable webhooks.

Webhook events shall include: event identifier; event type; event version; creation timestamp; product; application; environment; merchant account; resource identifier; current state; prior state where safe and relevant; amount and currency where relevant; provider reference where safe; correlation identifier; and idempotency information.

Event types include at minimum: `payment.created`, `payment.state_changed`, `payment.succeeded`, `payment.partially_received`, `payment.overpaid`, `payment.failed`, `payment.expired`, `payment.reversed`, `payment.refunded`, `payment.partially_refunded`, `payment.settlement_changed`, `payment.reconciliation_exception`, `payout.state_changed`, `payout.succeeded`, `payout.failed`, `payout.unknown`, `refund.state_changed`, `refund.succeeded`, `batch.state_changed`, `batch.completed`, and the merchant-finance events the product needs: `merchant_settlement.*` (per Section 53), `provider_merchant.*` (per Section 30), `payment.allocation_*` (per Section 47.5), `merchant_reserve.*`, `chargeback.*`, and `case.*` where relevant. Internal events shall not automatically be sent to products; product webhook exposure is limited to events the product needs.

Webhook security: HMAC or asymmetric signature; timestamp; replay window; per-application secret or public key; secret rotation support (dual-key windows); delivery allowlist; TLS verification; no sensitive provider credentials.

Delivery behavior: exponential backoff with jitter; maximum retry duration; dead-letter state; manual replay with audit; idempotent event identifiers; delivery history; HTTP status and response-body truncation with secret redaction; automatic pausing after repeated endpoint failure; alerting when a production product endpoint is unhealthy. Delivery states: `PENDING`, `DELIVERING`, `DELIVERED`, `RETRYING`, `DEAD_LETTERED`, `REPLAYED`, `PAUSED`.

---

# 84. APIs

All APIs shall be versioned under `/api/v1` (or a later explicit version), across three never-mixed surfaces: the product API, provider webhook routes, and the internal dashboard API.

## 84.1 Product API Areas

```text
POST /api/v1/payments                                GET /api/v1/payments · /payments/{payment}
POST /api/v1/payments/{payment}/attempts/stk         GET /api/v1/payments/{payment}/attempts
POST /api/v1/payments/{payment}/checkout-sessions    GET /api/v1/payments/{payment}/checkout-sessions/{session}
POST /api/v1/refunds                                 GET /api/v1/refunds/{refund}
POST /api/v1/payouts                                 GET /api/v1/payouts/{payout}
POST /api/v1/payout-batches                          GET /api/v1/payout-batches/{batch} · /items
POST /api/v1/beneficiaries                           GET /api/v1/beneficiaries/{beneficiary}
PUT  /api/v1/merchant-accounts/{merchant}            GET /api/v1/merchant-accounts/{merchant}
POST /api/v1/merchant-accounts/{merchant}/status-events
GET  /api/v1/merchant-accounts/{merchant}/payment-eligibility
GET  /api/v1/provider-methods                        GET /api/v1/routes/quote
```

Payment creation accepts the immutable business-purpose fields (`economic_purpose`, `customer_reference`, `commercial_policy_reference`, `commercial_policy_version`); Wallet derives and validates the funds-flow model. Products cannot request `CITRUS_COLLECTION_MERCHANT_PAYOUT`, select settlement destinations, or mark provider KYB approved.

## 84.2 Provider Webhook Routes

```text
POST /api/v1/providers/mpesa/c2b/validate            POST /api/v1/providers/mpesa/c2b/confirm
POST /api/v1/providers/mpesa/stk/callback/{account}  POST /api/v1/providers/mpesa/b2c/result/{account}
POST /api/v1/providers/mpesa/b2c/timeout/{account}   POST /api/v1/providers/pesapal/ipn/{account}/{secretPath}
POST /api/v1/providers/{provider}/webhooks/{account}
```

## 84.3 Internal Administrative API Areas

All Section 88 dashboard areas have corresponding internal endpoints, including: products; applications; merchant accounts; provider merchants (list/create/show/submit/approve/suspend/close); merchant settlement destinations (create/verify/approve/activate/deactivate); merchant settlements and statements; commission, fee, tax, and reserve policies; reserves; chargebacks (list/show/evidence/accept); cases (list/create/show/assign/notes/resolve/reopen); daily close; provider contracts and capabilities; providers and provider accounts; banks and bank accounts; routes; approvals; reconciliation; exceptions; ledger; reports and exports; audit logs; security events; and launch controls.

## 84.4 API Standards

The API shall: return consistent JSON envelopes; use proper HTTP status codes; validate every request; authorize every resource; rate-limit sensitive endpoints; paginate collections; use public-safe identifiers; support idempotency keys for all create commands that may move money; return stable machine-readable error codes and human-readable remediation; include a correlation identifier; avoid leaking internal stack traces, secrets, or full bank details; support deprecation notices; publish an OpenAPI specification; provide sandbox examples; enforce maximum payload sizes; and require canonical currency and integer-minor-unit amount formats.

Error categories include at minimum: `AUTHENTICATION_REQUIRED`, `MAGIC_LINK_EXPIRED`, `MAGIC_LINK_ALREADY_USED`, `ACCOUNT_INACTIVE`, `SOURCE_MEMBERSHIP_INACTIVE`, `PERMISSION_DENIED`, `STEP_UP_REQUIRED`, `RESOURCE_NOT_FOUND`, `VALIDATION_FAILED`, `LIMIT_EXCEEDED`, `IDEMPOTENCY_CONFLICT`, `DUPLICATE_EXTERNAL_REFERENCE`, `DUPLICATE_PROVIDER_TRANSACTION`, `ROUTE_NOT_FOUND`, `ROUTE_INACTIVE`, `ROUTE_CHANGED`, `PROVIDER_UNAVAILABLE`, `PROVIDER_TIMEOUT`, `PROVIDER_RESPONSE_INVALID`, `INSUFFICIENT_PROVIDER_BALANCE`, `BANK_ACCOUNT_INACTIVE`, `MERCHANT_INELIGIBLE`, `PROVIDER_MERCHANT_INACTIVE`, `SETTLEMENT_DESTINATION_UNVERIFIED`, `FUNDS_FLOW_BLOCKED`, `ALLOCATION_UNBALANCED`, `POLICY_VERSION_INVALID`, `CONTRACT_EXPIRED`, `COMPLIANCE_HOLD`, `APPROVAL_REQUIRED`, `APPROVAL_CONFLICT`, `TRANSACTION_STATE_CONFLICT`, `REFUND_AMOUNT_EXCEEDED`, `REFUND_FUNDING_UNDETERMINED`, `BENEFICIARY_UNVERIFIED`, `RECONCILIATION_REQUIRED`, `RATE_LIMITED`, `INTERNAL_ERROR`.

---

# 85. Idempotency

Idempotency is mandatory for collections, checkout sessions, payouts, refunds, reversals, batch creation, webhook processing, allocation submission, settlement instruction, and ledger posting.

The implementation shall: scope keys by application and operation; store a request hash; reject reuse of the same key with a materially different request; return the original result for a valid repeated request; retain keys for a policy-defined period appropriate to financial risk; use database uniqueness constraints as the final protection; use distributed locks only as an additional control; prevent concurrent refund over-allocation; prevent concurrent payout submission; prevent duplicate ledger posting; prevent duplicate callback and IPN effects; prevent duplicate settlement application; and prevent duplicate batch-item execution.

---

# 86. Concurrency

Concurrency controls shall include: row-level locking for refundable balances, allocations, reserves, and financial aggregates; partial-unique indexes limiting non-terminal attempts; atomic single-row consumption for magic links and approvals; optimistic locking for mutable configuration; serializable or equivalent transaction logic where locking is insufficient; and idempotent workers. Specified races that must be safe: duplicate IPN under parallel processing; status query racing an IPN; settlement file racing an IPN; refund racing a chargeback; destination suspension during settlement; parallel refunds; parallel approvals racing an invalidating edit; parallel payout submission; scheduler double-fire; and worker crash after provider acceptance.

---

# 87. Database Requirements

The conceptual data model comprises the following entity groups (the implementation-level structure, columns, and constraints are defined in the development plan):

1. **Identity and access:** legal entities; users; user memberships; roles; permissions; role permissions; user roles; permission overrides; magic-link requests; sessions; invitations; security events.
2. **Registries:** products; applications; application webhook secrets; merchant accounts; banks; Citrus bank accounts and versions; payment providers; provider accounts; provider credentials; provider certificates; provider wallets; provider balances; payment methods; currencies; app settings; configuration changes.
3. **Provider commercial:** provider contracts and versions; provider fee schedules; provider service levels; provider operating limits; provider capabilities; provider account capabilities; provider merchant capabilities.
4. **Merchant finance:** provider merchant accounts and events; merchant settlement destinations and versions; merchant onboarding cases and documents; merchant compliance statuses; compliance holds; merchant financial positions; merchant settlements and events; settlement calendars and rules; merchant statements and lines; reserves, reserve movements, and release schedules; negative-balance records (within financial positions).
5. **Policies and allocation:** commission policies and versions; fee policies and versions; tax policies and versions; reserve policies and versions; payment allocations and items; settlement instructions and items.
6. **Transactions:** payments; payment references; payment attempts; checkout sessions; mpesa transactions; pesapal transactions; payouts and attempts; payout batches and items; refunds and attempts; reversals; internal transfers; beneficiaries, destinations, and versions; approval policies, requests, and actions; risk rules and assessments.
7. **Ledger and settlement:** ledger accounts; ledger transactions; ledger entries; settlements; settlement batches.
8. **Reconciliation and close:** provider statements; bank statements; statement lines; reconciliation runs, items, and exceptions; daily close runs and items; accounting periods and actions.
9. **Disputes and cases:** chargebacks, events, evidence, adjustments; disputes; investigations; cases, parties, events, notes, evidence, assignments, SLA events.
10. **Integration and operations:** incoming webhooks and attempts; webhook endpoints; outgoing webhook events; webhook deliveries; idempotency keys; uploaded files; exports; notifications; audit logs; incidents; legal holds; routing decisions; payment routes and versions.

Database invariants (enforced at the database level, not only in application code):

1. Allocation debits and credits balance by currency.
2. Merchant settlement net equals allocation merchant net after authorised adjustments.
3. No settlement-destination version may be edited.
4. No settlement may point to an inactive destination.
5. No provider merchant account may cross product or environment.
6. No chargeback may exceed the original eligible amount plus provider-permitted fees.
7. Reserve movements cannot release more than the active reserve balance.
8. Negative-balance offsets cannot cross merchant accounts.
9. Provider capability effective dates must cover transaction submission.
10. Provider contract effective dates must cover route activation.
11. The Citrus merchant-funds route remains disabled without compliance approval.
12. Statement line totals equal statement summary.
13. Period close cannot be final while material exceptions exceed the policy threshold.
14. External payment reference unique per application; payout and refund idempotency keys unique per application; provider transaction and order-tracking identifiers unique per provider account; M-PESA receipt unique per provider account; ledger posting key unique; refund totals never exceed refundable balance; route versions immutable after activation; encrypted values separated from masked display values; cross-environment references unrepresentable; ownership and status columns indexed.
15. No floating-point money anywhere; integer minor units and explicit currency only.

Data-integrity practices: migrations for all schema changes; foreign keys; transactions for multi-step writes; optimistic locking for mutable configuration; pessimistic locking for critical allocation; no unbounded queries; pagination; N+1 avoidance; partitioning or archival of high-volume tables when justified by measured scale; preservation of raw financial evidence per retention policy.

---

# 88. User Interface

The internal dashboard shall include the following areas:

1. Overview Dashboard. 2. Collections. 3. Collection Attempts. 4. Checkout Sessions. 5. Payouts. 6. Bulk Payouts. 7. Refunds. 8. Reversals. 9. Internal Transfers. 10. Approvals. 11. Beneficiaries. 12. Products. 13. Product Merchant Accounts. 14. **Provider Merchants.** 15. **Merchant Onboarding and Compliance.** 16. **Merchant Settlement Destinations.** 17. **Merchant Financial Positions.** 18. **Merchant Settlements and Settlement Aging.** 19. **Merchant Statements.** 20. **Fees and Commissions (policies).** 21. **Tax Policies.** 22. **Reserves.** 23. **Negative Balances.** 24. **Chargebacks.** 25. **Cases.** 26. **Daily Close.** 27. **Provider Contracts and Capabilities.** 28. Applications and Environments. 29. Payment Routes. 30. Payment Providers. 31. Provider Accounts. 32. Provider Balances. 33. Banks. 34. Bank Accounts. 35. Settlements. 36. Reconciliation. 37. Exceptions. 38. Ledger. 39. Reports. 40. Webhooks. 41. API Credentials. 42. Users. 43. Roles and Permissions. 44. Audit Logs. 45. Security Events. 46. Notifications. 47. System Health. 48. **Launch Controls (pilot controls, feature flags, kill switches, operating modes, limits).** 49. Settings. 50. Support and Incident Center.

## 88.1 Screen Specification Standard

Every screen specification (maintained in the development plan) shall include: route; purpose; permitted roles; required permissions; data source; filters; sorting; pagination; loading state; empty state; success state; failure state; partial-success state; delayed state; unknown state; stale-data state; validation; actions; confirmation; step-up requirement; maker-checker requirement; audit events; responsive behaviour; accessibility; dark mode; and security considerations.

## 88.2 Dashboard

Shows, subject to permission: collection, payout, and refund totals by product; provider fees by product; settlement pending amount; unreconciled amount; provider-wallet balances and low-balance warnings; failed and unknown transactions; approval queue; reconciliation exceptions; provider health and operating modes; webhook delivery health; last statement imports and reconciliations; high-risk events; settlement aging and SLA breaches; daily-close status; pilot-limit utilization; and data freshness timestamps.

## 88.3 Payment Detail

In addition to identity, amounts, attempts, provider identifiers, route snapshot, and status/settlement/reconciliation badges, the payment detail shall display: economic purpose; contractual seller; economic beneficiary; merchant of record; provider merchant account; funds-flow model; allocation breakdown; fee bearer; commission; tax; reserve; masked settlement destination; merchant settlement status; refund funding party; chargeback status; related case; and the support-safe evidence bundle (timeline, product reference, merchant, masked payer, amount, provider identifiers, payment status, settlement status, reconciliation status, refund status, chargeback status, merchant statement reference, correlation ID, exception reference — sensitive values masked).

## 88.4 Route Detail

Displays: permitted economic purposes; permitted beneficiary types; custody classification; provider contract; provider capabilities; provider merchant requirement; settlement-destination requirement; commission, fee, tax, and reserve policies; compliance approval; effective dates; pilot limits; and kill-switch state — in addition to gateway, accounts, limits, default/fallback status, and version history.

## 88.5 Provider Merchant Screen

Displays: Servana merchant; provider identifiers; KYB status; compliance status; settlement destination; capabilities; contract version; fee schedule; settlement calendar; last successful payment; last settlement; last reconciliation; holds; and onboarding evidence.

## 88.6 Merchant Financial Position Screen

Displays all Section 52 components separately — never one ambiguous "balance" — with freshness and source per value: gross customer payments; settled amount; pending settlement; Citrus fees due and paid; refunds; chargebacks; reserves; negative balance; open exceptions; settlement destination; provider merchant status; last reconciliation; last statement; current risk status.

## 88.7 Daily Close Screen

Displays: close status; provider completeness; settlement completeness; ledger balance; exceptions; sign-offs; and reopen history.

## 88.8 Product, Bank-Account, and Provider-Account Detail Pages

Retained in full: the product detail page (identity, applications, merchant accounts, routes by direction, gateways, provider identifiers, settlement and funding accounts, wallets, limits, webhooks, credentials, totals, reconciliation state, ledger accounts, configuration history); the bank-account detail page (bank, masked number, branch, currency, type, purpose, eligibilities, direct-API state, users, settling providers, funded wallets, active routes, reconciliation method, statement and reconciliation dates, verification state, configuration history); and the provider-account detail page (provider, environment, merchant identifier, methods, products, settlement account, funding source, wallet, credential health, callback configuration, balance and freshness, last transactions, last reconciliation, incident state, routes) — extended with contract, capabilities, operating mode, and IPN registration status.

## 88.9 Frontend Requirements

The frontend shall include: reusable layout, form, transaction-status, money/currency-formatting, masked-account, provider-health, approval-timeline, and audit-timeline components; a centralized typed API client; predictable state management; loading, empty, success, failure, partial-success, delayed, and unknown states; accessible validation messages; safe rendering of user-generated narratives; no secret keys; no privileged business logic trusted only to the browser; and no jQuery. Transaction status shall never rely only on color: status icons, labels, descriptions, and timestamps are always present; `UNKNOWN` has a distinct visual treatment from failure.

## 88.10 UI and UX Requirements

The interface shall prioritize: clear visual hierarchy; accurate status communication; visible data freshness; confirmation before irreversible or high-risk actions; explicit account and environment context; strong sandbox/production distinction (persistent banners); clear distinction between payment success, merchant settlement, provider settlement, and reconciliation completion; clear distinction between failed and unknown; masking of sensitive data; searchable and filterable operational records; stable layouts; minimal decorative motion; visible focus states; keyboard operability; accessible errors; duplicate-submission prevention; and pre-submission confirmation restating provider, provider account, bank/funding source, amount, currency, and beneficiary/destination.

## 88.11 Forms and Input Behavior

Forms shall include: persistent labels; clear required indicators; obvious focus states; inline validation; error summaries for long forms; duplicate-submission prevention; understandable disabled states; confirmation of high-risk changes; draft preservation where safe (never for money instructions); unsaved-change warnings for configuration; currency-aware amount entry with backend integer-minor conversion; phone normalization; bank-code validation; account-number validation without post-save exposure; file-upload progress and scan state; effective-date controls; explicit environment selection; no placeholder-only labels; and no silent substitution of bank, provider, beneficiary, amount, or route during submission (a route change at submission requires re-confirmation).

## 88.12 User Profile and Account UI

The profile area shall show: user name; verified email; user type; current product/global and merchant-account context; roles; session assurance level; last login; active sessions with revocation; theme preference; notification preferences; security settings (TOTP enrollment); and logout / logout-all-devices. Delegated merchant users see that access originates from the relevant product's Merchant Administrator Account.

---

# 89. Reporting

Reports shall support filtering by: date range; product; application; environment; merchant account; provider merchant account; direction; economic purpose; funds-flow model; payment method; provider; provider account; settlement bank; funding bank; provider wallet; currency; status; settlement status; reconciliation status; approval status; and risk state.

Required reports:

1. Collection report. 2. Payout report. 3. Refund report. 4. Reversal report. 5. Settlement report. 6. Provider-fee report (by bearer). 7. Product financial summary. 8. Merchant-account transaction summary. 9. Product-to-gateway mapping report. 10. Product-to-bank mapping report. 11. Provider-account usage report. 12. Bank-account usage report. 13. Provider-balance report. 14. Reconciliation exception report. 15. Ledger trial balance. 16. Ledger transaction report. 17. Approval activity report. 18. Audit activity report. 19. Webhook delivery report. 20. Incident and outage report. 21. **Merchant gross collections.** 22. **Merchant net settlements.** 23. **Citrus commission earned / billed / collected.** 24. **Split-settlement allocation report.** 25. **Merchant settlement aging.** 26. **Settlement returns.** 27. **Merchant reserves.** 28. **Merchant negative balances.** 29. **Refund funding report.** 30. **Chargeback aging and outcomes.** 31. **Provider merchant onboarding status.** 32. **Provider capability and contract expiry.** 33. **Economic-beneficiary mapping.** 34. **Funds-flow model usage.** 35. **PayBill purpose segregation.** 36. **Daily close report.** 37. **Pilot-limit utilization.**

Every financial report reads ledger and source tables directly, never cached aggregates.

---

# 90. Exports

Large exports shall run asynchronously. Export files shall be private, encrypted where required, access controlled, time limited, download-counted, and audit logged. Export scope filters are validated against the requester's memberships at enqueue and re-validated at execution. Exports mask bank accounts and destinations unless a specific approved use requires otherwise; formula-injection defenses apply to spreadsheet exports.

---

# 91. Notifications

Wallet shall support email, in-app, and approved operational channels. Notifications shall cover:

1. Magic-link login; new payout approval request; payout approved/rejected; high-risk payout; bulk batch completion; refund approval; unknown payout state; reconciliation exception; low provider balance; provider incident; bank statement missing; webhook endpoint failure; credential expiry; route change pending approval; bank-account change pending approval; security events; session or permission changes.
2. **Merchant-finance notifications:** merchant onboarding approval or rejection; merchant KYB expiry; settlement destination change; settlement destination activation; first successful payment; payment risk hold; settlement expected; settlement delayed; settlement returned; merchant negative balance; reserve created or released; refund funded from merchant position; chargeback received; chargeback evidence deadline; provider contract expiry; provider fee variance; route capability disabled; daily close incomplete; pilot transaction cap reached.

Notifications shall be recipient-scoped (permission plus ownership scope), shall redact sensitive data, and shall never expose full bank account numbers, destinations, provider secrets, access tokens, or unnecessary personal data. Security and critical financial alerts cannot be muted.

## 91.5 Customer Payment Receipts

Wallet shall provide a canonical receipt data contract to Servana containing: Wallet payment public ID; product reference; merchant name; economic beneficiary; paid amount; currency; payment method; provider transaction reference where safe; payment date and time; payment status; refund status; merchant or Citrus receipt issuer; support reference; masked payer identifier; and no sensitive provider credentials. Servana renders the customer-facing receipt; Wallet owns the authoritative payment facts.

---

# 92. Audit

Audit logs shall include: actor; user type; product and merchant context; action; target resource; timestamp; IP address and user agent where appropriate; correlation identifier; before and after values where safe; approval reason; manual override reason; and authentication assurance level. Audit logs shall be append-only from the application perspective and protected against modification at the database level, with hash chaining and scheduled chain verification.

The audited event catalogue spans: identity and access lifecycle; registry and configuration changes; credential lifecycle; bank, destination, provider, provider-merchant, contract, and route changes; every financial lifecycle event (payments, attempts, allocations, payouts, refunds, reversals, settlements, merchant settlements, reserves, chargebacks, negative balances, transfers, ledger corrections, suspense actions); onboarding, compliance, and hold events; reconciliation and close events; case events; integration events; file and export events; launch-control, kill-switch, operating-mode, pilot, and break-glass events; and sensitive reads (bank and destination reveals, credential views, KYB document access).

---

# 93. Security

Wallet shall defend against: SQL injection; cross-site scripting; cross-site request forgery; broken access control; insecure direct-object references; mass assignment; file-upload abuse; sensitive-data exposure; session fixation; magic-link replay; brute-force and request flooding; API abuse; unsafe redirects; dependency vulnerabilities; server-side request forgery; XML external entity attacks where XML is processed; deserialization attacks; webhook spoofing; webhook replay; credential leakage; privilege escalation; duplicate financial execution; ledger tampering; route-configuration tampering; and insider misuse.

Additional financial-control threats with named mitigations and tests:

1. **Settlement-destination fraud** — destination versioning, cooling-off, maker-checker, out-of-band notification, provider re-verification, tested attack scenario.
2. **Provider merchant-account misuse** — per-merchant isolation, environment and product constraints, capability gating.
3. **Wrong-merchant routing; wrong-beneficiary routing; wrong-currency routing; cross-environment routing; cross-product routing; cross-merchant leakage** — ownership keys, composite constraints, scoped binding, isolation tests, automatic critical reconciliation exceptions.
4. **Forged provider callbacks; duplicate IPNs; duplicate settlements** — corroboration model, receipt/order-tracking uniqueness, replay detection, idempotent settlement application.
5. **Chargeback deadlines** — deadline tracking with escalating alerts.
6. **Reserve over-release; merchant negative-balance offsets** — database-enforced invariants.
7. **Contract expiry; provider-capability expiry; route drift; merchant KYB expiry** — effective-date gates, expiry monitoring, drift detection with route pause.
8. **Merchant suspension and offboarding misuse** — status effects matrix, closure blocking.
9. **Sensitive merchant documents; beneficial-owner data; full settlement account numbers; provider merchant identifiers; payer data** — encryption at rest, masking, least-privilege reveal workflows with reason capture and access logging.
10. **Legal holds** — deletion/archival suspension for held evidence.

Implementation requirements: framework request validation; strict authorization policies; guarded mass assignment; private object storage; signed download URLs; file scanning; output escaping; encryption of sensitive fields; production secrets in a secrets manager; HTTPS enforcement; strict CORS; security headers; Content Security Policy; rate limits; idempotency; maker-checker and dual approvals; immutable hash-chained audit logs; log redaction; masked sensitive data; reason capture; access logging; privileged-data reveal workflows; route kill switches; break-glass controls (named incident, declared severity, restricted users, step-up, two-person approval where practical, time-limited permission, recorded actions, post-incident review, automatic revocation — never permitting ledger edits or idempotency bypass); feature flags; circuit breakers; callback continuation after route suspension; no blind failover after ambiguous provider acceptance; dependency scanning; static and dynamic security testing; secret scanning; encrypted backups; key rotation; database least privilege; network segmentation; and administrative step-up.

**Provider credential security:** encrypted with managed keys; referenced rather than copied; accessible only to the integration runtime and narrowly authorized administrators; rotation without downtime where the provider permits overlap; owner and expiry tracked; last-used and last-rotated timestamps; expiry alerts; never in frontend source, logs, exports, or support screenshots; segregated by environment; revoked immediately after suspected compromise.

**Bank-account and destination security:** full numbers encrypted at rest; masked display by default; full-value access requires narrow permission, recent authentication, business reason, and audit; changes require maker-checker; activation requires step-up; effective dates; no deletion of historical records; private verification evidence and statements; masked exports.

No password, magic-link token, access token, provider credential, full bank account number, full settlement destination, card data, or equivalent secret shall be written to general logs.

---

# 94. Privacy

The platform shall apply data minimization: store only data required for financial operations, audit, support, risk, and legal obligations; mask phone numbers, bank accounts, destinations, and identifiers in general views; apply purpose limitation; provide retention policies by data category; support lawful deletion or anonymization where financial retention obligations permit; preserve immutable financial records where deletion is not lawful; maintain data-processing inventories; restrict production data access; log sensitive-data access; use approved subprocessors; protect exports with expiry and access controls; avoid personal data in payment references; and redact personal data in lower environments.

The data inventory shall be extended for: merchant legal information; beneficial-owner information; provider merchant IDs; settlement destinations; payer information; risk signals; sanctions-screening results; chargeback evidence; merchant statements; tax records; and complaint communications. Access follows least privilege; support staff shall not automatically access full KYB documents or settlement account numbers.

**Card-data boundary.** Where PesaPal hosts card entry, Wallet and Servana shall not receive or store: primary account number; card verification value; PIN; full magnetic-stripe data; or raw card credentials. Wallet may store only provider tokens or masked card metadata where contractually provided and permitted. A PCI responsibility matrix shall be documented even where card data is fully hosted by PesaPal.

---

# 95. Retention

Retention policies shall be defined by data category, configurable, and audited on change. Defaults: raw incoming webhook payloads and financial evidence, seven years; audit logs, seven years, append-only; magic-link request records, ninety days after consumption or expiry; idempotency keys, at least ninety days; exports, thirty-day signed-URL expiry with file deletion per export policy; onboarding evidence, statements, contracts, chargeback evidence, and tax records per legal and provider obligations, never deleted while obligations persist. High-volume raw event archives may move to cold storage per policy while preserving immediate access to required financial records.

---

# 96. Legal Holds

The platform shall support legal holds over: payments; settlements; statements; chargebacks; disputes; merchant KYB records; provider contracts; audit logs; and support communications. A legal hold shall suspend ordinary deletion or archival expiry for the held evidence, be permission-controlled, audited, and visible on affected records.

---

# 97. Accessibility

Wallet by Citrus shall meet practical WCAG 2.2 AA-aligned requirements: full keyboard navigation; visible focus indicators; accessible text contrast in both themes; programmatic labels; errors associated with inputs and announced; accessible names for buttons and links; touch targets of at least 44 by 44 CSS pixels where practical; browser zoom support; no disabled viewport scaling; reduced-motion support; screen-reader-friendly transaction statuses; logical heading hierarchy; landmark regions; accessible dialogs with focus trapping and restoration; accessible data summaries for charts; no critical information conveyed only through a chart or color; announced progress for long-running imports and exports; and accessible session-timeout warnings.

---

# 98. Responsive Design

Responsive behavior shall be implemented through CSS media queries based on viewport width: desktop 1025 pixels and above; tablet 768–1024 pixels; mobile 767 pixels and below.

Rules: no JavaScript for primary responsive layout selection; no device detection; layout adapts during browser resizing; normal content requires no horizontal scrolling; data-heavy views use responsive cards, controlled overflow regions, progressive disclosure, or downloadable exports without breaking the page; no clipping or overlap; usable touch targets; high-risk approval actions never compressed into ambiguous icon-only controls; filters remain accessible on small screens; financial values remain legible and are never silently truncated.

**Light and dark mode:** light mode default; dark mode available; preference persists per user; both modes meet accessible contrast; status, validation, focus, and warning states remain visible in both; provider health and financial exception states never depend solely on color; printed or exported records use a stable print-safe presentation. **Visual standards (Apple HIG-inspired):** clear hierarchy, minimal clutter, consistent spacing and typography, purposeful motion, strong readability, predictable interaction, privacy-conscious presentation, user control over important actions; no animation delays or obscures a financial status.

---

# 99. Performance

The system shall: paginate large datasets; index common filters; queue slow operations; cache safe expensive reads (never in the financial write path); avoid N+1 queries; use bulk inserts where safe; rate-limit provider requests; respect provider concurrency limits; separate callback ingestion from processing; use idempotent workers and dead-letter handling; lazy-load heavy frontend modules; optimize assets; use CDN delivery for public static assets; monitor slow queries; and archive high-volume raw events per policy while preserving access to required financial records.

Launch performance targets shall be defined and load-tested for: dashboard response time; transaction search; API request latency excluding provider latency; callback and IPN acknowledgment latency; queue lag; webhook delivery latency; bulk import throughput; reconciliation throughput; merchant statement generation; settlement-file ingestion; and export generation.

---

# 100. Scalability

Stateless web and worker processes shall autoscale where infrastructure permits. High-volume tables (incoming webhooks, ledger entries, statement lines) shall have pre-declared partitioning, archival, or summary strategies triggered by measured scale. The modular architecture shall permit extraction of a high-volume module without rewriting the financial domain. Search infrastructure is introduced only when measured database-search performance requires it; financial detail pages always read from the primary database.

---

# 101. Observability

Production shall include: structured logs with redaction; error tracking; performance monitoring; distributed correlation identifiers propagated across HTTP, jobs, and webhooks; queue monitoring; failed-job tracking; database, Redis, and storage health; provider and bank integration health; webhook delivery health; security-event monitoring; uptime monitoring; and alert routing with escalation.

Launch metrics shall include the provider and merchant-finance series:

```text
pesapal_order_submit_total                pesapal_order_submit_failure_total
pesapal_ipn_received_total                pesapal_ipn_duplicate_total
pesapal_status_query_total                pesapal_status_query_mismatch_total
pesapal_refund_total
merchant_settlement_expected_total        merchant_settlement_overdue_total
merchant_settlement_value_overdue_minor   merchant_allocation_imbalance_total
merchant_negative_balance_total           merchant_reserve_value_minor
chargeback_open_total                     chargeback_deadline_breach_total
provider_fee_variance_minor               daily_close_incomplete_total
```

All money metrics carry currency labels without high-cardinality transaction identifiers. `UNKNOWN`-state counts and ages are first-class financial-safety metrics.

---

# 102. Incident Response

Incident management shall include: severity classification; on-call and escalation paths; incident records linked to alerts, runbooks, and affected scope; executive incident authority; provider and bank incident contacts; communication plans; and post-incident review. Operational runbooks shall cover at minimum: provider outage; bank outage; callback failure; product webhook outage; low provider balance; duplicate transaction alert; ledger imbalance; unknown payout; reconciliation mismatch; compromised credential; compromised user account; incorrect route activation; wrong settlement bank account; bulk payout incident; database degradation; queue backlog; email delivery outage; magic-link abuse; data breach; disaster recovery; **PesaPal authentication failure; PesaPal IPN delay; PesaPal status mismatch; PesaPal settlement delay; PesaPal settlement return; merchant settlement-destination change; merchant negative balance; merchant reserve release; chargeback response; merchant offboarding; provider contract expiry; daily-close failure; wrong-merchant routing; wrong-settlement-destination; and pilot kill-switch operation.**

---

# 103. Business Continuity

Business continuity shall provide: documented recovery-point and recovery-time objectives; cross-zone or equivalent infrastructure resilience; provider callback recovery procedures; reconciliation-led recovery after downtime; manual operational fallback for critical payouts where legally and operationally approved; and an incident communication plan. Recovery prioritizes financial correctness over apparent speed; unknown transactions are reconciled before resubmission.

---

# 104. Disaster Recovery

Disaster recovery shall include: automated database backups with point-in-time recovery; object-storage versioning; secrets recovery procedures; backup restoration testing on a regular schedule with evidence (boot, row counts, ledger trial balance, audit-chain verification, sample signed downloads); and disaster-recovery exercises. A deployment rollback shall never roll back financial facts (Section 106.5).

---

# 105. Provider Outage Handling

Provider operating modes:

```text
NORMAL   DEGRADED   COLLECTIONS_PAUSED   STATUS_QUERIES_ONLY
REFUNDS_ONLY   SETTLEMENT_MONITORING_ONLY   FULLY_SUSPENDED
```

Mode changes shall be: permission-controlled; step-up protected; maker-checker approved for production; audited; time-bounded where possible; product-notified; displayed on the dashboard; and included in route eligibility. A provider outage shall not automatically redirect a customer to a different provider after a provider order may have been accepted. Callbacks continue to be accepted in every mode that permits them.

---

# 106. Feature Flags

## 106.1 Launch Feature Flags

Immutable, audited launch flags shall include:

```text
pesapal_collections_enabled
pesapal_refunds_enabled
pesapal_direct_merchant_settlement_enabled
pesapal_split_settlement_enabled
citrus_paybill_citrus_receivables_enabled
citrus_paybill_merchant_funds_enabled      (defaults to false)
merchant_statements_enabled
chargebacks_enabled
merchant_reserves_enabled
```

Flags shall not replace authorization, route eligibility, or compliance checks; a feature flag cannot override a compliance gate (tested).

## 106.2 General Feature-Flag Rules

Risky integrations sit behind flags; flag changes are permission-controlled, audited, and environment-scoped.

## 106.3 Circuit Breakers

Provider adapters carry circuit breakers: open after consecutive failures; while open, routing marks the provider account unhealthy; breakers never cause silent failover.

## 106.4 Configuration Drift Detection

A scheduled route doctor compares: Wallet provider-account configuration; provider-registered IPN URL; provider merchant status; provider settlement destination; provider capabilities; Wallet route configuration; and contract effective dates. Drift creates an exception and may pause affected routes.

## 106.5 Rollback and Financial Containment

A deployment rollback shall not roll back financial facts. Where a release defect affects payment creation or routing: pause new affected routes; continue receiving callbacks; continue status queries; preserve all raw payloads; reconcile in-flight transactions; deploy prior compatible code; use forward-repair migrations; and produce incident and accounting impact reports.

## 106.6 Provider Exit Strategy

The first launch shall document how to disable PesaPal without losing historical evidence. A future provider may be added only through a new route; existing PesaPal payments remain associated with PesaPal; no in-flight payment shall be migrated to another provider.

---

# 107. Kill Switches

Kill switches shall exist at: product; application; environment; merchant account; payment method; provider; provider account; provider merchant account; route; funds-flow model; currency; and amount band.

Kill-switch activation shall distinguish: block new transactions; allow status queries; allow callbacks; allow refunds; allow reconciliation; allow settlement processing; and allow support reads. Callbacks shall continue to be accepted after a route is paused. Kill-switch state is visible on route detail and launch-control screens; activation is permission-controlled, step-up protected, audited, and (in production) maker-checker approved.

---

# 108. Pilot Rollout

## 108.1 Rollout Stages

**Stage 0 — Production technical canary:** one internal or controlled merchant; one low-value real transaction; no automatic split settlement; manual observation; full reconciliation before expansion. The canary set comprises (a) one merchant-to-Citrus payment and (b) one customer-to-merchant payment using the approved provider settlement model; where split settlement is enabled, a third canary proves split settlement. Production prohibits synthetic customer transactions except controlled canary transactions explicitly marked and reconciled; test merchants and test provider accounts are separate from production merchants.

**Stage 1 — Limited merchant pilot:** three to five approved merchants; per-transaction and daily caps; restricted payment methods; daily reconciliation; daily operational review; no unresolved critical exceptions.

**Stage 2 — Expanded pilot:** ten to twenty-five approved merchants; risk-based limits; automated merchant statements; settlement SLA monitoring; chargeback handling proven where cards are enabled.

**Stage 3 — General Servana availability:** only after the settlement accuracy target is met; provider fee variance is controlled; no duplicate payment or settlement defect exists; support and finance staffing is adequate; and security and legal gates remain valid. **General availability must not occur merely because the code has been deployed.**

## 108.2 Pilot Controls

Pilot merchant allowlists; stage-gated expansion with recorded success thresholds; daily operational review during pilot; pilot-limit utilization reporting and cap-reached alerts.

## 108.3 Launch Transaction Limits

Limits shall be defined at: payment; payer; merchant; provider merchant account; route; day; month; payment method; and product. Each limit has: soft threshold; hard threshold; approval requirement; alert threshold; effective dates; override process; and override expiry. A limit override requires a reason, step-up authentication, and audit evidence.

---

# 109. First-Launch Scope

**Required at first launch (confirmed):** merchant-to-Citrus collection; PesaPal customer collection (contract-gated activation); provider direct merchant settlement or separate merchant facility; separate Citrus commission billing by default; economic beneficiary model; funds-flow model; provider merchant mapping; settlement-destination verification; merchant settlement lifecycle; merchant statements; provider fee capture; allocation model; marketplace ledger templates; three-way reconciliation; merchant onboarding; KYB status tracking; refunds; settlement-delay handling; case management; launch limits; kill switches; pilot rollout; daily close; production canaries; M-PESA C2B and STK collections; the Servana collections contract (Gate W); payouts, bulk payouts, reversals, treasury transfers, beneficiaries, approvals, ledger, settlement tracking, reconciliation, reporting, audit, security, and operations as specified throughout this document.

---

# 110. Conditional First-Launch Scope

The following may launch only where contractually supported and tested: PesaPal split settlement; provider-managed reserves; card payments; chargeback evidence submission integration; real-time merchant settlement; provider merchant onboarding API; and recurring merchant-to-Citrus payments.

---

# 111. Explicitly Disabled First-Launch Capabilities

The following shall remain disabled at first launch: Citrus omnibus collection of customer funds for later merchant payout (`CITRUS_COLLECTION_MERCHANT_PAYOUT` and the `citrus_paybill_merchant_funds_enabled` flag); general arbitrary PesaPal disbursements; public merchant registration into Wallet; public Wallet merchant dashboard; stored-value merchant wallets; peer-to-peer transfers; cross-border merchant settlement; automatic provider failover after an ambiguous result; unapproved settlement-destination changes; manual editing of financial history; and delegated product-merchant Wallet login (until a product owner enables it).

---

# 112. Out-of-Scope Capabilities

The following remain out of scope unless a later approved scope explicitly introduces them:

1. Public registration of unrelated merchants directly into Wallet by Citrus.
2. Use of Wallet by Citrus by companies not owned or operated by Citrus Labs Limited.
3. Public self-service acquisition of production API credentials.
4. White-label payment dashboards for unrelated businesses.
5. A general consumer wallet storing withdrawable value independent of an underlying Citrus product transaction.
6. Peer-to-peer transfer of stored value between unrelated users.
7. Lending, credit scoring, overdraft, or credit issuance.
8. Cryptocurrency custody, exchange, or settlement.
9. Cross-border remittance without separately approved providers, compliance controls, and legal review.
10. Automatic movement of money from an arbitrary external bank account that has not been onboarded and technically exposed by the relevant bank or provider.
11. Blind provider failover after an unknown or timed-out response.
12. Editing or deleting posted ledger entries.
13. Deleting bank accounts, provider accounts, provider merchant accounts, destinations, routes, or products that have historical financial records.
14. Customer access to the central Citrus Labs finance and payment-operations dashboard.
15. Storage of raw card numbers, card verification values, personal identification numbers, or mobile-money credentials.
16. Operation as a bank, escrow service, deposit-taking service, trust, or safeguarding institution.

---

# 113. Edge Cases

Wallet by Citrus shall explicitly handle the following edge cases:

1. Two products generate the same external reference. Uniqueness is scoped by application; Wallet public identifiers remain globally unique.
2. A product is renamed. Historical transactions retain the original product snapshot; current records display the updated name with an audit trail.
3. A merchant account moves between product plans. Financial ownership remains unchanged; historical payments are not recalculated.
4. A merchant user is deactivated during an active session. Session revalidation revokes scoped access.
5. A magic link is forwarded. Revalidation and risk controls apply; high-risk actions still require step-up.
6. An email address belongs to users in more than one product merchant account. Login requires an explicit safe context selection after authentication or a signed context supplied by the source product.
7. A shared PayBill receives a reference for a retired product. The payment is recorded and routed to a controlled exception process.
8. A provider changes callback format without notice. Schema validation prevents corrupt posting and alerts integration owners.
9. A callback arrives before the underlying transaction commits. The webhook processor retries resolution within a bounded policy.
10. A transaction succeeds at the provider but Wallet crashes before committing. Status query and reconciliation recover the result without duplicate execution.
11. Wallet commits a pending attempt but the request never reaches the provider. Retry is permitted only when no provider acceptance identifier exists and idempotency rules support it.
12. A route is disabled while transactions are pending. Pending transactions retain their route snapshot and follow controlled completion or cancellation rules.
13. A bank account is closed. It remains in historical records and cannot be selected for new routes.
14. A provider wallet has sufficient displayed balance but the balance is stale. Policy based on data freshness applies; manual confirmation may be required.
15. Currency minor units differ. The currency registry controls precision; no floating-point conversion is used.
16. Daylight-saving or time-zone differences affect provider timestamps. Store UTC; preserve original provider timestamps and zones; business dates use Africa/Nairobi.
17. A leap day, month-end, or year-end affects settlement dates. Settlement calendars and banking-day rules are configurable and versioned.
18. A batch contains duplicate bank accounts with different names. Flag according to risk policy.
19. A payout narrative contains unsupported characters. Normalize safely or reject before submission while retaining the original user intent separately.
20. A beneficiary changes their M-PESA number after approval. The payout requires a new beneficiary version and reapproval.
21. A provider returns success with a missing transaction identifier. Mark as an integrity exception and query before final success.
22. Provider fees differ from configured fees. Record actual fees and raise a reconciliation variance.
23. A settlement combines transactions from multiple Citrus products. Allocate by transaction-level records while preserving the shared settlement batch.
24. A settlement reaches a different Citrus bank account than configured. Record actual evidence and raise a critical route exception.
25. A payout is funded from a different provider wallet than expected. Raise a funding-source exception.
26. A partial bank settlement occurs. Track settled and outstanding amounts independently.
27. An approved batch exceeds available funds at execution time. Hold unsubmitted items and alert; no uncontrolled negative balances.
28. A user double-clicks submit. Client protection and server idempotency prevent duplication.
29. A scheduled job runs twice. Job-level idempotency prevents duplicate status queries, webhooks, or postings.
30. Redis is unavailable. Financial correctness continues through database constraints; noncritical queued work degrades safely.
31. Object storage is unavailable. Financial transactions continue where safe; statement upload and export functions report unavailability.
32. Search index is stale. Financial detail pages read from the primary database; search freshness is displayed.
33. A product webhook is down for days. Events remain durable and replayable without blocking provider processing.
34. An application credential is rotated while requests are in flight. A controlled overlap window may accept both credentials.
35. A provider credential expires. The route becomes unavailable and alerts are raised before expiry.
36. A user lacks permission but knows a valid transaction identifier. The API returns a non-enumerating denial or not-found response.
37. A raw provider payload contains secrets. Redaction applies to logs and support views; the private evidence copy remains protected.
38. A transaction is disputed after refund. The dispute module preserves all linked financial events.
39. A provider reverses a transaction without a preceding Wallet request. Record an unsolicited reversal and reconcile.
40. A merchant account is suspended. New product-origin transactions are rejected per the status matrix; historical reporting remains available to authorized internal users.
41. A product is temporarily unavailable. Wallet continues provider callback ingestion and later retries product webhooks.
42. Wallet is temporarily unavailable. Provider retry behavior and later reconciliation recover callbacks where possible.
43. Two approvers act simultaneously. Only valid distinct approvals are accepted atomically.
44. An approver's permission is revoked after approval but before submission. Policy determines whether approval remains valid; high-risk changes require revalidation.
45. A manual route override conflicts with provider limits. Validation rejects it.
46. A product sends an unsupported currency. Reject before financial creation.
47. A product sends a negative or zero amount. Reject.
48. An amount contains excessive decimal precision. Reject or normalize only under an explicit currency rule.
49. A batch is cancelled after some items were submitted. Only unsubmitted items are cancelled.
50. A status query itself times out. Preserve unknown state and retry within policy.
51. A customer returns from PesaPal checkout before the IPN arrives. The redirect is a navigation signal only; a status query resolves the state; the payment is never marked successful from the redirect.
52. An IPN arrives before the customer returns. Processing is idempotent; the redirect handler observes the already-updated state.
53. A duplicate IPN arrives. Acknowledged idempotently; no duplicate credit, allocation, or webhook.
54. A checkout session expires while the customer is mid-payment at the provider. The session is expired; a late IPN or status query resolves the actual payment outcome; money received is never discarded.
55. A completed checkout session is reused. Rejected; the session is single-use.
56. A cancelled or incomplete PesaPal order later reports success. The status query result controls; the payment transitions by state machine, never by assumption.
57. A settlement file arrives before the IPN for a transaction it contains. File processing creates or matches records idempotently; reconciliation flags any gap.
58. A merchant changes settlement destination while a settlement is in transit. The in-transit settlement completes against its pinned destination version; the new version applies only after activation and cooling-off.
59. A destination is suspended during settlement processing. The settlement holds; a hold reason is recorded; alerts fire.
60. A refund races a chargeback for the same payment. Locking serializes them; the combined effect never exceeds the eligible amount; both records preserve their relationship.
61. A merchant is offboarded with an active reserve and a negative balance. Closure is blocked until the reserve is released or applied and the negative balance resolved.
62. A provider merchant approval expires or is revoked. Routes requiring it pause; in-flight transactions complete; new payments are rejected.
63. A provider contract expires while routes are active. Routes pause; contract-expiry alerts precede the event.
64. Allocation rounding leaves a remainder. The deterministic rounding policy assigns it to the configured party via `rounding_adjustment_minor`; the allocation still balances.
65. A late event arrives after daily close. It is recorded in the current posting period with original provider timestamps and an adjustment to the affected business date.
66. The accounting period is reopened. Reason and approval are recorded; no posted entries are edited; reports are reissued.

---

# 114. Failure Modes

## 114.1 Magic-Link Failures

1. Unknown email: generic success message; no email sent.
2. Inactive internal user: generic success; blocked request logged.
3. Inactive product merchant user: generic success; no session.
4. Source product identity service unavailable: temporary-unavailable message without asserting account existence; bounded retry only.
5. Email delivery delayed: show that a link was requested; permit resend after cooldown; invalidate excessive outstanding tokens.
6. Expired link: reject and offer a new request.
7. Already-used link: reject; no second session.
8. Link opened in a different environment: reject.
9. Unsafe redirect parameter: ignore; use safe default.
10. User deactivated after link generation: revalidate and reject.

## 114.2 Collection Failures

1. Unknown bill reference: persist the provider transaction; post to exception or suspense only under controlled rules; alert reconciliation staff.
2. Duplicate M-PESA confirmation: acknowledge idempotently; no double credit.
3. Same provider identifier with different amount: block automatic posting; raise critical integrity exception.
4. Underpayment: apply product policy (partial payment, pending balance, or exception).
5. Overpayment: record the full received amount; mark overpaid; trigger product-specific handling.
6. Payment after invoice expiry: record the money received; route to exception or late-payment policy; never discard.
7. Payment after invoice already paid: record as potential duplicate or additional payment; require resolution.
8. Callback before API response: resolve through provider request identifiers; process idempotently.
9. API response before callback: keep pending; await callback or query.
10. Missing callback: query provider status and reconcile.
11. Malformed callback: persist safely; reject processing; alert after repeated occurrences.
12. Provider sends wrong shortcode: route to provider-account exception; do not assign to a product.
13. PesaPal order submission failure: typed failure before acceptance permits controlled retry; ambiguous submission maps to `UNKNOWN`.
14. PesaPal status query contradicts IPN: status query controls; mismatch metric and exception raised.

## 114.3 Payout Failures

1. Provider rejects before acceptance: mark failed with provider reason; controlled retry or fallback per policy.
2. Provider timeout: mark `UNKNOWN`; query status; prohibit blind resubmission.
3. Callback missing: status queries and reconciliation.
4. Insufficient provider balance: hold before submission where known; alert treasury.
5. Beneficiary not registered for M-PESA: mark failed or rejected per provider result; require destination correction.
6. Invalid bank account: reject before submission when validation is available; otherwise process provider rejection safely.
7. Amount exceeds route limit: select another eligible route before submission or reject.
8. Provider duplicate-reference response: resolve against prior attempt and idempotency record.
9. Partial bulk success: preserve each item state; never mark the batch failed or successful without qualification.
10. Payout succeeds after attempted cancellation: preserve success; cancellation is ineffective after provider acceptance unless the provider supports reversal.
11. Payout route changed during approval: invalidate approval; reroute only after reapproval.
12. Funding bank account deactivated after approval: block submission; require new route and approval.

## 114.4 Refund Failures

1. Concurrent refund requests: lock refundable balance; permit only the valid aggregate.
2. Refund exceeds remaining amount: reject.
3. Original payment not successful: reject.
4. Original payment reversed: reject or limit to remaining balance.
5. Native refund fails: preserve attempt; permit an approved alternate route.
6. Destination changed: enhanced verification and approval.
7. Refund provider timeout: mark `UNKNOWN`; resolve before retry.
8. Refund success but product webhook failure: preserve refund success; retry the webhook.
9. Refund funding party undetermined: block the refund until responsibility is determined.
10. Refund after merchant settlement with insufficient reserve: create a merchant negative balance per policy; never silently debit an unrelated merchant.

## 114.5 Settlement and Merchant-Finance Failures

1. Missing merchant settlement past SLA: `DELAYED` state, aging, escalating alerts, case linkage.
2. Partial merchant settlement: track settled and outstanding independently.
3. Duplicate settlement report line: dedupe by file/content hash and provider references; duplicate application is impossible.
4. Returned settlement: `RETURNED` state, return reason, posting template 14, destination review before replacement instruction.
5. Settlement to wrong destination: automatic critical exception; settlement processing for that merchant pauses per policy.
6. Provider settlement report unavailable: contract-required reports missing raise alerts; manual evidence fallback with controlled import.
7. Allocation imbalance detected post-hoc: imbalance metric; critical exception; correction via replacement instruction or adjustment transaction.
8. Chargeback deadline at risk: escalating alerts until evidence submitted or accepted.

## 114.6 Reconciliation Failures

1. Statement cannot be parsed: quarantine; preserve; report precise errors.
2. Duplicate statement upload: detect via file and content hashes.
3. Statement line matches multiple transactions: ambiguity exception.
4. Provider and bank disagree: preserve both evidence sources; investigate.
5. Bank statement delayed: mark data stale; alert; never claim completion.
6. Ledger imbalance: stop affected posting; critical incident; no silent correction.

## 114.7 Webhook Failures

1. Product endpoint returns 500: retry with backoff.
2. Product endpoint returns 410 or permanent deactivation: pause delivery; alert the product owner.
3. Signature failure on incoming event: reject processing.
4. Replay event: acknowledge or reject per provider needs without applying effects.
5. Oversized payload: reject before parsing; log safely.
6. Product endpoint certificate invalid: never bypass TLS verification.

---

# 115. Acceptance Criteria

Wallet by Citrus shall be considered ready for production launch only when all applicable criteria are satisfied with evidence.

## 115.1 Identity and Access

1. All human login uses secure magic links; no password path exists.
2. Delegated merchant-user login validates active status from the respective Merchant Administrator Account; inactive users cannot create sessions; mid-session deactivation revokes access.
3. Role and permission tests pass; deny-beats-grant proven.
4. Cross-product, cross-merchant, and cross-environment isolation tests pass.
5. Step-up authentication protects every designated high-risk action.

## 115.2 Product Integration

1. Kikao, Servana, and SkillFlow have registered applications and environments with separate credentials.
2. Product webhooks are signed, retryable, and replayable with delivery history.
3. Sandbox and production are isolated.
4. Product integration documentation, OpenAPI, and the webhook verification contract are published; the Servana contract tests pass.

## 115.3 Gateway, Bank, and Destination Mapping

1. Every active route identifies the gateway, provider account, and — as applicable — the Citrus settlement bank account and bank name, or the provider merchant account and verified merchant settlement destination.
2. Every payout route identifies the funding source and its originating bank where applicable.
3. All bank accounts are verified and approved; all provider accounts are onboarded and tested; route versions and effective dates are active; snapshots are immutable.

## 115.4 Collections

1. C2B callbacks are centrally owned; duplicate callbacks and IPNs never duplicate credits.
2. STK requests and callbacks reconcile; unknown references enter the exception queue.
3. Collection ledger postings balance; product webhooks deliver or retry durably.
4. PesaPal: order submission works; the browser redirect cannot mark success; IPN and status query are idempotent; duplicate provider events cannot duplicate credit; merchant eligibility is enforced; checkout expiry is enforced; payment limits are enforced.

## 115.5 Payouts and Refunds

1. Payout idempotency, unknown-state handling, and no-blind-failover are proven under concurrency and chaos tests.
2. Maker-checker rules work; beneficiary changes trigger reapproval.
3. Full and partial refunds cannot exceed the refundable balance; the refund funding party is known for every route; refund-after-settlement paths work.
4. Bulk batches preserve item-level status; provider and bank limits are enforced; payout ledger postings balance.

## 115.6 Merchant Finance

1. Pilot merchants are approved; provider merchant IDs mapped; KYB and compliance eligibility current; settlement destinations verified and independently approved; merchant terms and policy versions recorded; offboarding procedure proven.
2. Every launch purpose has an economic beneficiary; every route has a funds-flow model; `citrus_paybill_merchant_funds_enabled` is false unless separately approved; split settlement is false unless contractually proven; commission and fee policies are versioned; allocation balances at database level; custody classification approved.
3. Expected settlements are created; destination versions pinned; provider settlements reconciled; partial and returned settlements handled; settlement SLA alerts work; merchant statements produced; merchant financial positions balance.
4. Refund funding, reserves, negative balances, chargeback deadlines, and chargeback financial impact are handled and balance; products receive required state updates.

## 115.7 Ledger and Reconciliation

1. Ledger transactions balance by currency; posted entries are immutable; posting is idempotent.
2. Provider, allocation, fee, commission, merchant-net, settlement, destination, statement, reserve, negative-balance, refund, chargeback, bank, and product-reference reconciliation work for every launch route, including three-way (and four-way where applicable) reconciliation.
3. Settlement variances produce exceptions; resolution is audit logged; month-end reports and daily close are producible.
4. Per launch route: transaction-level match; fee match; commission match; merchant net match; settlement destination match; settlement date match; merchant statement match; ledger match; product reference match; no unresolved duplicate.

## 115.8 Provider and Contract

1. The PesaPal contract is signed; capabilities documented; merchant/sub-merchant model confirmed; settlement model confirmed; fee, reserve, refund, chargeback, and negative-balance responsibilities confirmed.
2. Production credentials stored; IPN registered and verified in the correct environment with the IPN ID associated to the correct provider account; provider support and escalation contacts loaded.

## 115.9 Security and Compliance

1. Independent security review complete; critical and high findings resolved or formally accepted with compensating controls.
2. Legal sign-off, tax sign-off, and the provider money-flow assessment are recorded; the PCI responsibility matrix is complete.
3. Secrets are outside source control; logs verified free of secrets, KYB data, and bank/destination data; masking works; the settlement-destination change attack scenario is tested; legal hold works; backup restore is tested; incident runbooks approved.

## 115.10 Operations

1. Provider and bank support contacts documented; on-call and escalation paths exist; monitoring and alerts live; queue and webhook health visible; reconciliation owners assigned; low-balance procedures documented; disaster-recovery procedures tested.
2. Daily close completed for launch routes; support case workflow tested; provider outage mode tested; route kill switches tested; pilot merchant allowlist tested; transaction caps tested; on-call staffing assigned; runbooks approved.

## 115.11 Production Canary

1. One merchant-to-Citrus payment succeeds and reconciles.
2. One customer-to-merchant payment succeeds and reconciles; the merchant settlement reaches the verified destination; the merchant statement reflects the transaction; Citrus commission and provider fee treatment are correct; the ledger balances; Servana receives signed webhooks; no manual database correction is required.

---

# 116. Launch Gates

## 116.1 Foundation Gate

Proves: repository; architecture; authentication; authorization; isolation; registries; audit; and the security baseline.

## 116.2 Gate W — Servana Collections

Proves the complete Servana collections contract: registries; merchant-account sync; product machine auth; provider account configuration; routes; idempotency; incoming webhook foundation; outgoing signed webhooks with the published verification contract; payments and `SRV-PAY-<ULID>` reference issuance; STK attempts with cooldown; STK callbacks; C2B validation and confirmation; duplicate and receipt protection; the full collection state machine including partial and overpaid; status-query reconciliation; exception queue; ledger postings; settlement basics; delivery retries and replay; OpenAPI and event schema versions; and the sandbox simulator harness.

## 116.3 Gate W-M — Servana Merchant Funds-Flow

Proves: approved merchant; provider merchant identity; verified settlement destination; economic purpose; economic beneficiary; funds-flow model; allocation; commission treatment; provider fee treatment; ledger treatment; merchant settlement; merchant statement; reconciliation; legal approval; provider approval; and the production canary. No production merchant funds-flow route activates without the provider money-flow assessment (`docs/compliance/provider-money-flow-assessments/pesapal-servana.md`) documenting: payer; contractual seller; economic beneficiary; merchant of record; provider account holder; initial funds recipient; temporary funds controller; final settlement beneficiary; settlement destination; commission method; provider fee bearer; refund obligor; chargeback obligor; fraud-loss bearer; reserve owner; negative-balance responsibility; merchant KYB owner; AML/CFT owner; sanctions-screening owner; transaction-monitoring owner; safeguarding or ring-fencing requirement; tax invoice issuer; withholding-tax treatment; customer receipt issuer; merchant statement issuer; applicable provider terms; legal, accounting, tax, and executive sign-off; and prohibited fallback models.

## 116.4 PesaPal Gate

Proves: authentication; IPN registration; order creation; status confirmation; refund behaviour; provider fee capture; settlement evidence; merchant mapping; reconciliation; outage handling; and production onboarding. Additionally: redirect handling tested without trusting redirect success; duplicate IPNs do not duplicate credits; refunds return to the original payment instrument where provider rules require; cancelled or incomplete orders do not become successful; provider fees reconcile; provider settlement reports reconcile; unknown and delayed provider states enter controlled exception handling; and the production canary completes end to end.

## 116.5 Production-Readiness Gate

Proves: security review; legal review; tax review; provider contract; merchant pilot readiness; staffing; runbooks; observability; backup; disaster recovery; rollback; production canaries; daily close; and no material unresolved exception.

---

# 117. Operational Staffing

Before production, Citrus Labs shall assign named people to: payment operations; reconciliation; finance approval; treasury; risk and compliance; support escalation; security incident response; engineering on-call; and executive incident authority. No launch shall depend on one person having every critical role.

Measurable internal service levels shall be defined and dashboard-monitored for: payment exception first review; settlement-delay escalation; refund review; chargeback evidence submission; provider incident escalation; merchant onboarding review; settlement-destination change review; critical security event response; unresolved `UNKNOWN` age; and daily reconciliation completion. A daily operational review runs throughout the pilot.

---

# 118. Risks

## 118.1 Platform Risks

| ID | Risk | Indicative likelihood | Mitigation |
|---|---|---|---|
| R-01 | Provider production onboarding slower than development | 55–75% | Begin commercial and compliance onboarding early; per-route activation checklists; sandbox success never presented as production readiness |
| R-02 | Bank APIs unavailable for desired accounts | 35–60% per bank | Provider wallets, PesaLink intermediaries, host-to-host files, central treasury route; explicit funding-source mapping |
| R-03 | Duplicate payout via timeout/retry/failover | <2% with controls (20–40% without) | Timeout ≠ failure; no blind failover; provider-reference uniqueness; reconcile before retry |
| R-04 | Record divergence across provider/bank/ledger/product | 60–85% without automation | Multi-layer reconciliation; immutable snapshots; statement imports; exception ownership; month-end controls |
| R-05 | Shared-PayBill misrouting | 15–35% without strict references | Central callback ownership; structured unique references; validation; unknown-reference exceptions |
| R-06 | Insider misuse (beneficiary/bank/route/payout tampering) | Materially non-zero | Least privilege; maker-checker; step-up; immutable audit; alerts; effective dates; no self-approval |
| R-07 | Regulatory classification of platform activity | Not quantifiable without legal analysis | Operate through authorised providers; no public stored value; documented money flows; Kenyan legal advice before launch |
| R-08 | Single-developer delivery maturity gap | 65–80% for full production-grade delivery in four months | Reduced launch scope; security and financial-domain review; phased providers; operations as first-class deliverable |

## 118.2 Merchant-Finance and Provider Risks

| ID | Risk | Likelihood without controls | Impact | Mitigation |
|---|---|---:|---|---|
| R-16 | Wrong economic beneficiary | 20–35% | Severe legal and accounting error | Mandatory beneficiary fields, route constraints, tests |
| R-17 | Provider does not support platform merchants | 45–65% | Launch-model failure | Signed capability confirmation; separate-billing fallback |
| R-18 | Split settlement unavailable | 50–75% | Commission model change | Default separate billing; capability flag false |
| R-19 | Settlement to wrong merchant | 3–8% | Direct financial loss | Provider merchant isolation, destination pinning, critical exception |
| R-20 | Settlement destination fraud | 10–20% over operating life | Severe loss | Versioning, cooling-off, maker-checker, out-of-band notification |
| R-21 | Merchant funds misclassified as Citrus revenue | 25–45% | Financial-statement and tax error | Explicit ledger templates; accounting sign-off |
| R-22 | Provider fee variance | 30–60% | Margin leakage | Actual fee capture and reconciliation |
| R-23 | Refund after settlement creates unfunded liability | 20–40% | Liquidity loss | Refund funding policy, reserves, negative balances |
| R-24 | Chargeback process missed | 15–30% (card-enabled) | Avoidable loss | Chargeback domain and deadline alerts |
| R-25 | KYB status expires silently | 10–25% | Provider suspension / compliance exposure | Expiry monitoring and route pause |
| R-26 | Provider contract expires while route active | 5–15% | Unauthorised processing | Contract effective-date gate |
| R-27 | Shared PayBill commingles funds | 40–70% | Custody, tax, reconciliation exposure | Facility segregation and reference classes |
| R-28 | Merchant negative balances accumulate | 25–50% | Credit loss | Position dashboard, limits, reserves, suspension |
| R-29 | Settlement report unavailable | 20–40% | Incomplete reconciliation | Contract requirement, statement import, manual evidence fallback |
| R-30 | Support unable to resolve disputes | 30–50% | Trust damage | Case management and evidence bundle |
| R-31 | Pilot expands too quickly | 35–55% | Operational overload | Cohort stages, caps, success thresholds |
| R-32 | Provider outage causes duplicate attempt | 5–15% | Duplicate charge | Unknown-state discipline; no blind failover |
| R-33 | Incorrect tax or withholding | 20–40% | Tax liability | Tax policy versioning and professional sign-off |
| R-34 | Merchant offboarding leaves open obligations | 20–35% | Unclaimed or disputed funds | Closure-blocking workflow |
| R-35 | Staff concentration of authority | 25–45% in a small team | Fraud and control failure | Named roles, maker-checker, break-glass controls |

The percentages are planning estimates, not measured production rates.

## 118.3 Non-Negotiable Rules

1. Do not use jQuery. 2. Do not trust frontend authorization. 3. Do not allow cross-product, cross-merchant-account, or cross-environment leakage. 4. Do not skip backend authorization. 5. Do not hard-code secrets. 6. Do not expose secrets in logs. 7. Do not expose full bank account numbers or settlement destinations by default. 8. Do not use floating point for money. 9. Do not edit posted ledger entries. 10. Do not delete historical provider, bank, destination, route, or product records. 11. Do not treat callback or IPN receipt alone as proof of settlement. 12. Do not treat a timeout as failure. 13. Do not blindly fail over an unknown payout. 14. Do not permit a creator to approve their own controlled action. 15. Do not reuse production credentials in sandbox. 16. Do not allow each product to independently own callbacks for a shared PayBill or IPN. 17. Do not send raw provider credentials to integrated products. 18. Do not permit a product credential to access another product. 19. Do not permit a merchant user or merchant identity to access another merchant account. 20. Do not ship without idempotency. 21. Do not ship without reconciliation. 22. Do not ship without immutable route snapshots. 23. Do not ship without audit logs. 24. Do not ship without rate limiting. 25. Do not ship without automated tests for critical financial flows. 26. Do not build responsive behavior through device detection. 27. Do not disable browser zoom. 28. Do not ignore accessibility. 29. Do not let CSS or JavaScript substitute for backend financial controls. 30. Do not activate a bank, provider, provider merchant, destination, or route without verified onboarding and approval. 31. Do not classify merchant money as Citrus revenue. 32. Do not mark a payment successful from a browser redirect. 33. Do not assume an undocumented or contractually unconfirmed provider capability. 34. Do not silently net across merchants, products, currencies, or customers.

## 118.4 Unresolved Blocking Decisions

The following are recorded blocking decisions; affected capabilities remain gated until each is resolved in writing and recorded:

1. PesaPal merchant/sub-merchant model. 2. PesaPal split-settlement support and mechanics. 3. PesaPal direct merchant settlement mechanics and destination verification. 4. PesaPal disbursement capability for third-party beneficiaries. 5. Provider fee bearer per flow. 6. Refund responsibility per flow. 7. Chargeback responsibility per flow. 8. Merchant KYB ownership. 9. Settlement-destination ownership and verification responsibility. 10. Citrus commission model final parameters. 11. Tax and withholding treatment. 12. Merchant funds custody classification.

---

# 119. Assumptions

1. Currency: KES default; integer minor units; a currency registry controls precision; floating-point money is forbidden everywhere.
2. Public identifiers: immutable ULIDs; structured payment references use `{PRODUCT_PREFIX}-PAY-<ULID>`; the public reference contract is preserved and `reference_class` carries the economic distinction.
3. Human authentication: magic link only; no password path exists; step-up is TOTP or a fresh short-lived magic link; WebAuthn is post-launch.
4. Machine authentication: OAuth2 client credentials per application per environment; short-lived tokens; no machine refresh tokens.
5. Environments: sandbox, staging, production; environment is an attribute of the application; cross-environment references are structurally impossible.
6. Timezone: store UTC; business-date boundaries in Africa/Nairobi; provider timestamps preserved verbatim.
7. Provider order: Safaricom Daraja is the first adapter; PesaPal is the explicit second, first-launch adapter behind its gates; PesaLink/bank/card adapters follow behind the same contracts; aggregators are registry-ready only.
8. Delegated merchant users: capability built and tested; launch-disabled for all three products.
9. Ledger corrections: compensating entries only, with permission, maker-checker, and evidence.
10. Compliance boundary: engineering builds the controls; production launch requires documented Kenyan legal and compliance sign-off; merchant funds-flow routes additionally require the provider money-flow assessment.
11. Data retention defaults per Section 95, configurable and audited.

---

# 120. Dependencies

External dependencies that gate production (software phases never block on these; production route activation does):

1. Safaricom Daraja production onboarding, shortcode configuration, and callback registration.
2. PesaPal commercial agreement, production onboarding, IPN registration, and written capability confirmations (Section 42.3).
3. Bank verification of Citrus Labs settlement and funding accounts.
4. Provider registration of Wallet callback and IPN URLs.
5. Kenyan legal, compliance, tax, and accounting sign-off, including the provider money-flow assessment.
6. Merchant pilot cohort approval and provider merchant onboarding for pilot merchants.
7. Operational staffing assignments (Section 117).

---

# 121. Success Criteria

## 121.1 Platform Success Definition

Wallet by Citrus will have achieved its purpose when Citrus Labs Limited can answer, from one authoritative platform, without manual reconstruction: which product originated a transaction; which merchant account owned it; which application and environment submitted it; which gateway processed it; which provider account and merchant identifier were used; which Citrus Labs bank account received the collection and the receiving bank's name; which funding source funded a payout and what bank funded that source; what route and policy versions selected the path; what the provider result was; whether money actually settled; whether the transaction is reconciled; what ledger entries were posted; who created, approved, changed, or investigated it; what exception remains unresolved; whether the product received the signed outcome event; and whether the complete history can be proven through immutable records and evidence — accurate, permission-controlled, auditable, and resilient under duplicate requests, provider timeouts, delayed callbacks, partial failures, bank-settlement differences, and future product expansion.

## 121.2 First-Launch Decision Standard

Wallet by Citrus shall be considered ready for its first Servana merchant-payment launch only when the system can answer, with immutable evidence, all of the following for every transaction:

1. Which product originated the payment? 2. Which Servana merchant owns the business transaction? 3. What is the payment's economic purpose? 4. Who is the contractual seller? 5. Who is the economic beneficiary? 6. Who is the merchant of record? 7. Which provider account processed the payment? 8. Which provider merchant or sub-merchant identity was used? 9. Which funds-flow model applied? 10. Which settlement destination version applied? 11. Which commission, fee, tax, and reserve policies applied? 12. What gross amount was paid? 13. What provider fee was charged? 14. What Citrus commission was earned or invoiced? 15. What merchant net amount was due? 16. Did the provider confirm the payment? 17. Did the merchant settlement occur? 18. Did the destination receive the expected amount? 19. Did Wallet reconcile the transaction, allocation, settlement, and ledger? 20. Who is responsible for a refund? 21. Who is responsible for a chargeback? 22. Is any reserve active? 23. Does the merchant have a negative balance? 24. Was the merchant eligible and compliant at the time? 25. Were all configuration and contract versions valid? 26. Were the transaction limits respected? 27. Were any manual overrides used? 28. Were product webhooks delivered? 29. Does the merchant statement reflect the transaction? 30. Is any exception, complaint, dispute, or investigation still open?

A production route that cannot answer these questions shall not be activated.

---

# 122. Traceability Requirements

Every material requirement in this scope shall map, in the development plan's traceability matrix, to: one or more development-plan sections; a responsible module; one or more database entities; one or more services or use cases; an API or internal workflow where applicable; permissions and policies where applicable; automated tests; implementation phases; acceptance evidence; and launch gates. Every material development-plan deliverable shall map back to a requirement in this scope.

The matrix shall include rows for at minimum: economic purpose; economic beneficiary; funds-flow model; provider merchant account; merchant settlement destination; PesaPal adapter; PesaPal IPN; checkout session; allocation; commission; fees; taxes; reserves; negative balances; merchant settlement; merchant statement; chargeback; case management; daily close; provider contract; pilot rollout; and kill switches — each mapped to scope section, phase, migration, service, route, policy, screen, test, and evidence artifact.

---

*End of `Wallet_by_Citrus_Platform_Project_Scope.md` (version 2.0). This document is a complete replacement incorporating the baseline platform scope, the PesaPal and merchant-finance enhancement requirements, and the First-Launch Critical Additions amendment as one unified, internally consistent, authoritative specification.*

