# Citrus Refer & Earn Platform — Complete Feature and Functionality Specification

**Platform owner and operator:** Citrus Labs Limited  
**Platform name:** Citrus Refer & Earn  
**Platform type:** Centralized, multi-product referral, reward, payout, fraud-control, and reporting platform  
**Integration model:** One central platform integrated independently with every eligible Citrus Labs Limited product  
**Primary users:** Third-party Referrers, Citrus Labs Super Administrators, Referral Operations users, Finance and Payout users, Risk and Fraud users, Customer Support users, Audit users, and authorized product integration services  
**Launch currency:** KES only; every monetary record still stores an explicit ISO currency code  
**Launch qualification and payout frequency:** Monthly only  
**Default attribution scope:** One effective earning attribution per merchant-product tenant; campaign and campaign version are immutable attributes of that attribution  
**Minimum merchant-retention requirement:** Four consecutive qualifying service months for every launch recurring subscription-reward campaign  
**Source-of-truth rule:** Citrus products remain authoritative for merchant, subscription, payment, and product-usage facts; Citrus Refer & Earn remains authoritative for referral attribution, reward calculation, reward liabilities, payout processing, adjustments, and Referrer-facing records.

---

# Integrated Correction Authority and Manifesto

## Authority of this rewritten specification

This document is the complete governing specification for Citrus Refer & Earn. It incorporates the original feature and functionality scope together with every approved correction from the Corrective Specification Addendum. It is not an addendum and does not require a reader to consult a second document to discover the operative rule.

Where an earlier draft, implementation note, API example, database constraint, workflow, phase plan, test, interface, or report conflicts with this rewritten specification, this rewritten specification prevails.

## Manifesto applied to every correction

Every corrective change in this document follows five mandatory controls:

1. **Prove the problem.** The contradiction or omission is identified from two or more incompatible requirements, an impossible state transition, a missing data structure, an unsafe financial control gap, or an implementation phase that cannot satisfy its own acceptance criteria.
2. **Establish the root cause.** The document identifies whether the defect arose from an incorrect uniqueness boundary, conflated states, ambiguous authority, incomplete role decomposition, mutable financial data, deferred launch controls, or inconsistent configuration scope.
3. **Fix the root cause precisely.** The governing data model, state machine, authorization rule, API behavior, financial workflow, or launch constraint is changed directly. A warning message or frontend-only workaround is not accepted as a correction.
4. **Test the correction.** Every material correction has named unit, integration, authorization, concurrency, financial reconciliation, or acceptance tests. The final document also includes document-consistency tests that verify that superseded contradictory rules are absent.
5. **Demonstrate resolution.** Each correction defines an observable invariant proving the system now behaves consistently, identifies every affected user or service, and defines the audit evidence required to establish that the rule operated correctly.

## Uniform production-launch policy

The following rules apply uniformly across every launch module:

- Launch currency is KES only.
- Reward qualification occurs monthly.
- Payout execution occurs monthly.
- Product-specific active-use qualification is mandatory for every recurring subscription-reward campaign.
- The minimum retention milestone is four consecutive qualifying service months.
- Reward duration and retention are separate measurements; neither counter may substitute for the other.
- The default reward duration is a fixed calendar service-period window whose length is at least the retention milestone.
- Month 1, Month 2, and Month 3 rewards may be paid as earned under `monthly_pay_as_earned`; failure to reach retention through ordinary churn does not retroactively invalidate legitimate prior rewards.
- One merchant-product tenant can have only one effective earning attribution at a time, regardless of campaign count.
- A Referrer legal entity and each human Referrer user are separate records.
- Verified payout destinations are append-only and are replaced through a controlled request; they are never edited in place.
- Every production payout requires maker/checker authorization, provider-status verification, reconciliation, product allocation, and a final statement.
- Consolidated cross-product KES payouts, minimum viable reconciliation, and monthly statements are Phase 1 requirements.
- Internal human access uses enterprise SSO or equivalent strong identity, mandatory MFA, explicit RBAC, scopes, default-deny authorization, and auditable separation of duties.
- Product facts remain product-authoritative; referral, reward, ledger, payout, and Referrer-facing facts remain central-platform-authoritative.
- No financial, campaign-version, audit, approval, attribution-history, or payout-destination record is silently overwritten or hard-deleted.

Future multi-currency, non-monthly payout cycles, alternative campaign types, and advanced attribution models require a separately approved capability version and may not retroactively alter existing campaign terms.

---

# 0. Document Purpose and Governing Architecture

## 0.1 Purpose

This specification defines the complete production-grade **Citrus Refer & Earn** platform.

The platform allows an independent third party to refer potential merchants to one or more Citrus Labs Limited products. When a referred potential merchant creates a new Merchant Administrator account in an eligible Citrus product, completes the required setup, pays the applicable subscription in full, actively uses the product, and satisfies all campaign qualification rules, the Referrer earns a monthly reward for the duration configured by an authorized Citrus Labs Super Administrator.

The reward may be:

```text
fixed_amount_per_qualifying_month
percentage_of_eligible_subscription_amount_per_qualifying_month
```

The platform centralizes the following capabilities across the Citrus Labs product portfolio:

- Referrer registration and identity.
- Referrer authentication.
- Contact verification.
- Secure payout-method capture.
- Product-specific referral links, codes, and QR codes.
- Product- and campaign-specific attribution.
- Merchant qualification monitoring.
- Subscription-payment qualification.
- Product-specific active-use qualification.
- Monthly reward calculation.
- Four-month merchant-retention enforcement.
- Earnings ledgers.
- Monthly payout runs.
- Consolidated payouts with product-level accounting.
- Payout reconciliation.
- Earnings statements.
- Email notifications.
- Customer-support cases.
- Fraud and abuse detection.
- Duplicate-referral resolution.
- Reward holds, adjustments, and reversals.
- Super Administrator configuration.
- Cross-product reporting.
- Append-only audit trails.

The platform shall not be implemented as a separate full Refer & Earn subsystem inside every Citrus product. Each Citrus product retains only the native entry points and product-specific logic required to integrate with the central platform.

## 0.2 Settled Architecture

The governing architecture is:

> **One shared Citrus Labs Refer & Earn platform as the system of record, with isolated product-level campaigns, integrations, rules, attribution, qualification evidence, earnings, accounting allocation, and reporting.**

This means:

1. A Referrer creates one Citrus Labs Referrer Account.
2. The Referrer can refer merchants to several Citrus products.
3. Each product has separate campaigns, codes, links, eligibility rules, and reward rules.
4. Merchant registration and merchant operations remain inside the relevant Citrus product.
5. Each product emits authenticated business events to Citrus Refer & Earn.
6. Citrus Refer & Earn evaluates attribution and monthly reward eligibility.
7. Citrus Refer & Earn calculates, records, and pays rewards centrally.
8. One payout may consolidate earnings from several products.
9. The reward ledger always preserves the product and campaign source of every amount.
10. One Referrer cannot view another Referrer’s records.

## 0.3 Why This Architecture Is Required

A separate full implementation inside every product would create:

- Duplicate Referrer accounts.
- Duplicate payment-method records.
- Inconsistent reward calculations.
- Fragmented payouts.
- Inconsistent fraud rules.
- Repeated implementation and maintenance.
- Greater security exposure.
- Difficult cross-product reporting.
- Increased payout and accounting errors.
- Repeated support workflows.
- Complex future expansion.

A rigid central implementation that treats every product identically would also be incorrect because products have different:

- Subscription plans.
- Subscription prices.
- Billing periods.
- Merchant operating models.
- Active-use definitions.
- Target markets.
- Gross margins.
- Fraud patterns.
- Commercial campaigns.

The platform therefore centralizes reusable referral infrastructure while isolating product-specific commercial and operational qualification.

## 0.4 Governing Rule for Product Isolation and Attribution Uniqueness

A referral attribution applies by default to:

```text
one_referrer_legal_entity
+ one_referred_merchant_product_tenant
+ one_citrus_product
+ one_effective_earning_attribution
```

The campaign and immutable campaign version are attributes of the effective earning attribution. They do not create an additional uniqueness boundary that permits a second earning Referrer for the same merchant-product tenant.

A referral to Courier by Citrus does not automatically create a referral to Servana by Citrus. The same legal business may be referred separately to different Citrus products because each product tenant is an independent acquisition relationship.

A referral reward calculated under a Courier campaign must never use a Servana campaign rule. A campaign migration for an existing merchant-product attribution normally preserves the existing Referrer and creates a new prospective campaign assignment or attribution version. It does not reopen competition for the merchant.

The central database must enforce one effective earning attribution for each `merchant_product_tenant_id + product_id` combination through a partial unique constraint and transaction-safe conflict handling. Historical, invalidated, superseded, and disputed claims remain append-only evidence and are never deleted.

A reassignment that changes reward entitlement requires evidence, a reasoned decision, approval under the applicable maker/checker policy, immutable linkage to the superseded attribution, recalculation through adjustments or reversals, notification, and an appeal route where applicable.

## 0.5 Governing Rule for Reward Duration and the Four-Month Retention Requirement

The phrase “the referred merchant must actively use the product and pay subscriptions for at least four months” is implemented through two independent measurements:

```text
rewarded_qualification_months
current_consecutive_qualifying_months
```

The launch retention milestone is:

```text
minimum_retention_milestone_months >= 4
retention_requires_consecutive_months = true
```

The launch reward-duration default is:

```text
reward_duration_type = fixed_calendar_duration
reward_duration_months >= minimum_retention_milestone_months
```

Each service month is assessed independently. A Month 1 reward may become payable after the Month 1 service period closes when the eligible subscription obligation is fully paid, cleared, reconciled, the product-specific activity decision is qualified, attribution remains valid, risk checks pass, and the payout method is ready. Months 2 and 3 follow the same rule.

The retention milestone is reached only after four consecutive qualified service months. A missed or reversed month resets the current consecutive count but does not erase legitimately earned earlier rewards. Under a six-calendar-month campaign, for example, qualification in Months 1 and 3–6 produces five rewarded months and reaches the four-consecutive-month milestone only at Month 6.

Legitimately earned Month 1, Month 2, and Month 3 rewards are not automatically recovered merely because the merchant later stops using the product. A previous reward may be reversed only because of a specific invalidating event, including fraud, self-referral, duplicate attribution, subscription refund, chargeback, fabricated activity, merchant identity duplication, payout fraud, or proven calculation error.

Supported retention payout policies remain:

```text
monthly_pay_as_earned
monthly_pay_with_partial_holdback
deferred_until_retention_milestone
```

The launch default is:

```text
monthly_pay_as_earned
```

Any stricter holdback model must be disclosed in the published campaign version before referral, approved, visible to the Referrer, and never introduced retroactively.

# 1. Platform Purpose

Citrus Refer & Earn exists to provide Citrus Labs Limited with a controlled, auditable, secure, and scalable merchant-acquisition channel through independent Referrers.

The platform enables a Referrer to:

- Create one Referrer Account.
- Verify their email address and phone number.
- Provide required contact and payout information.
- Access product-specific referral campaigns.
- Generate and share referral links, codes, and QR codes.
- Refer an unlimited number of potential merchants, subject to campaign and abuse controls.
- Track every referral from click or code capture through registration, activation, qualification, reward, and payout.
- View consolidated earnings across all products.
- View product-specific earnings.
- View monthly reward calculations.
- View current payment status.
- View complete payment history.
- Download statements.
- Update an approved payment method through a secured workflow.
- Receive transactional email updates.
- Contact Citrus Labs customer support by email or through an in-platform support form.
- Raise attribution, qualification, calculation, payout, or account queries.

The platform enables Citrus Labs Limited to:

- Configure product-specific referral campaigns.
- Configure fixed or percentage reward rules.
- Configure reward duration.
- Configure a retention milestone of four or more consecutive qualifying service months.
- Configure eligible products, plans, merchant types, and billing periods.
- Configure a mandatory product-specific active-use rule version for every recurring subscription-reward campaign.
- Configure the monthly payout calendar, clearing periods, hold periods, retry windows, and statement dates.
- Configure maximum reward amounts and campaign budgets.
- Review Referrers.
- Monitor attribution.
- Review qualification.
- Run consolidated monthly payouts.
- Reconcile payout attempts.
- Investigate fraud.
- Apply transparent adjustments and reversals.
- Manage support cases.
- Produce product-level and cross-product analytics.
- Preserve complete audit evidence.

---

# 2. Core Product Principles

## 2.1 One Referrer Identity Principle

A natural person or legal organization has one primary Referrer legal entity across Citrus Labs products, operated through one or more separately authenticated Referrer users.

The platform prevents uncontrolled duplicate identities by comparing verified attributes, including:

- Email address.
- Phone number.
- National identification or company registration identifier where collected.
- Payout destination.
- Tax identifier where collected.
- Legal name.
- Device and network risk indicators.
- Previously deactivated or suspended Referrer records.

Potential duplicates are not automatically merged. They enter a controlled identity-resolution workflow.

## 2.2 Product-Specific Campaign Principle

Every reward belongs to a specific campaign version.

A campaign configuration change shall never silently change the reward basis of an already attributed merchant.

Each referral attribution captures:

- Product.
- Campaign.
- Campaign version.
- Reward model.
- Reward amount or rate.
- Percentage basis.
- Reward duration.
- Minimum retention milestone.
- Active-use rule version.
- Payout policy.
- Attribution policy.
- Effective date.

## 2.3 Product Fact Ownership Principle

Each Citrus product remains authoritative for:

- Merchant registration.
- Merchant identity.
- Merchant Administrator account.
- Merchant setup completion.
- Merchant subscription plan.
- Subscription invoice.
- Subscription payment.
- Subscription refund.
- Chargeback.
- Merchant billing status.
- Merchant operational status.
- Product-specific merchant activity.
- Product-specific suspension.

Citrus Refer & Earn shall not independently infer a product fact by directly querying a product’s internal operational database.

The product must emit a trusted, signed event or respond to an authenticated verification request.

## 2.4 Referral and Payout Fact Ownership Principle

Citrus Refer & Earn remains authoritative for:

- Referrer identity.
- Referral code.
- Referral link.
- Referral attribution.
- Attribution dispute.
- Qualification-period record.
- Reward calculation.
- Reward ledger entry.
- Reward hold.
- Reward adjustment.
- Reward reversal.
- Payout run.
- Payout item.
- Payout attempt.
- Payout reconciliation.
- Referrer statement.
- Referrer support case.
- Referral audit trail.

## 2.5 Server-Side Enforcement Principle

The platform shall enforce on the server:

- Referrer ownership.
- Product isolation.
- Campaign isolation.
- Role permissions.
- Payment-method access.
- Reward calculation.
- Payout eligibility.
- Hold and reversal rules.
- Rate limits.
- Referral-code validity.
- Merchant attribution locking.
- Support-case visibility.
- Audit visibility.
- Export permission.
- Field masking.

Frontend hiding alone is never sufficient.

## 2.6 Immutable Financial History Principle

Original reward calculations, earned rewards, payout items, payout attempts, and accounting allocations shall not be silently overwritten or deleted.

Corrections use:

- Adjustment records.
- Reversal records.
- Replacement calculations.
- Reason codes.
- Actor identity.
- Approval identity.
- Before-and-after values.
- Timestamps.
- Audit records.

## 2.7 No Silent Rule Change Principle

A campaign change takes effect through a new campaign version.

Already attributed merchants continue under their snapshotted terms unless the published campaign expressly allows prospective migration and the migration is lawful, approved, communicated, and audited.

## 2.8 Data-Minimization Principle

A Referrer must not receive merchant-operational or merchant-financial data beyond what is needed to understand referral status.

The Referrer may see:

- Merchant display name, where permitted.
- Product.
- Campaign.
- Referral date.
- General registration status.
- General qualification status.
- Subscription-month qualification state.
- Reward amount.
- Payout state.
- Non-sensitive failure reason category.

The Referrer must not see:

- Merchant customers.
- Merchant staff.
- Merchant branches beyond approved display.
- Merchant transaction references.
- Merchant M-Pesa phone number.
- Full subscription invoice details.
- Internal merchant notes.
- Merchant security status.
- Private fraud evidence.
- Product activity records.
- Detailed revenue.
- Other merchant data not required for referral transparency.

## 2.9 Referrer Isolation Principle

One Referrer shall never view, search, enumerate, export, infer, or access another Referrer’s:

- Profile.
- Contact details.
- Payment method.
- Referral links.
- Referred merchants.
- Earnings.
- Payment history.
- Support cases.
- Statements.
- Tax information.
- Fraud status.
- Audit history.

## 2.10 Monthly Payout Principle

Rewards are evaluated by qualification period and included in a monthly payout run after:

- The qualification period closes.
- The eligible subscription is fully paid.
- Payment is cleared and reconciled.
- Active-use requirements are confirmed.
- Attribution remains valid.
- The clearing period expires.
- Fraud and risk checks pass.
- The Referrer has a verified payout method.
- The reward is not on hold.
- The minimum payout threshold is satisfied or the carry-forward rule applies.

---

# 3. Users, Legal Entities, Actors, Roles, and Authentication

## 3.1 Referrer legal entity

The Referrer legal entity is the party that owns the referral relationship, reward entitlement, tax profile, payout destination, statements, and contractual acceptance.

A Referrer legal entity may be:

- An individual.
- A sole proprietor.
- A registered company.
- An agency.
- A consultancy.
- A trade association.
- A technology or commercial partner.
- Another approved legal person.

The Referrer legal entity is not itself a login credential. It is represented in the platform by one or more authorized Referrer users.

The entity owns:

- The immutable Referrer reference.
- Campaign enrollments.
- Referral assets.
- Merchant attributions.
- Reward calculations.
- Reward ledger entries.
- Payout methods.
- Payouts.
- Statements.
- Tax records.
- Support cases.
- Fraud and appeal records.

## 3.2 Referrer user account

A Referrer user is a natural person authorized to act for a Referrer legal entity.

For an individual Referrer, the platform creates one legal entity and one initial Referrer user. For an organization, the initial verified representative becomes the organization owner and may invite additional users subject to role and verification controls.

Supported Referrer-user roles are:

- `organization_owner`: controls membership, legal-profile requests, payout-method requests, and account closure requests.
- `organization_admin`: manages campaigns, referral assets, referrals, support, and non-destructive profile settings.
- `finance_viewer`: views earnings, payouts, statements, and tax documents but cannot change a payout destination.
- `referral_operator`: creates and shares referral assets and views referral status but cannot view full payout or tax information.
- `support_contact`: opens and manages support cases with access limited to the cases and operational context required.
- `read_only`: views permitted dashboards and reports.

An organization must always have at least one verified `organization_owner`. Removal of the last owner is blocked until another verified owner accepts transfer.

## 3.3 Citrus Labs Super Administrator

The Super Administrator governs platform configuration but is not an unrestricted bypass account.

The role may:

- Register and configure products.
- Create campaign drafts and campaign versions.
- Configure platform policies within approved limits.
- Manage internal roles and scopes.
- View cross-product reporting.
- Suspend platform operations in an emergency.

The role must not:

- Create and approve the same high-risk financial action.
- Modify source-product facts.
- mark a payout paid without evidence.
- change an immutable campaign version.
- alter or delete ledger or audit records.
- bypass a legal hold, fraud hold, or maker/checker requirement.

Break-glass access must be separately assigned, time-limited, reason-coded, approved, monitored, and reviewed after use.

## 3.4 Referral Operations user

Referral Operations manages campaign participation, attribution review, identity exceptions, delayed-event review, and non-financial account lifecycle actions.

It may place operational holds and propose corrections but cannot execute payouts, change payout destinations, or approve its own high-risk correction.

## 3.5 Finance roles

The previous single Finance and Payout account is decomposed into permission sets so that separation of duties can be enforced.

The supported Finance permission sets are:

- `finance_preparer`: creates payout runs and finance adjustment proposals.
- `finance_reviewer`: checks totals, exclusions, payout readiness, and accounting allocation.
- `finance_approver`: approves payout runs and controlled financial corrections.
- `payout_executor`: transmits approved payouts to a provider.
- `payout_reconciler`: verifies provider outcomes, settlement, returns, and fees.
- `finance_reporter`: exports permitted finance and accounting reports.

One human may hold more than one permission only where the configured monetary threshold and risk classification permit it. No human may prepare and approve the same high-risk payout run or adjustment.

## 3.6 Risk and Fraud user

Risk and Fraud investigates identity linkage, self-referral, duplicate merchants, collusion, fabricated activity, provider abuse, chargebacks, and payout-destination misuse.

Risk may place or release a risk hold according to delegated authority. Risk cannot change product source facts, create rewards, or execute payouts.

## 3.7 Customer Support user

Customer Support handles Referrer inquiries with field masking and least-privilege access.

Support may view non-sensitive referral, qualification, reward, and payout states. Support cannot change attribution, rewards, payout methods, fraud decisions, or provider settlement states.

## 3.8 Audit user

Audit is read-only with respect to business and financial records. The narrow write permission for audit work applies only to audit-case metadata, such as creating an audit case, adding a review note, assigning a reviewer, escalating, and resolving the audit case.

Audit cannot mutate the underlying referral, campaign, payout, reward, identity, support, or product-event record.

## 3.9 Platform Engineering and Integration Owner

This is an internal technical permission set, not a financial or commercial role.

It may:

- Manage integration configuration.
- Rotate service credentials.
- view integration health.
- replay dead-lettered events through a controlled process.
- manage schemas and supported event versions.
- diagnose delivery failures using masked data.

It may not:

- create or approve rewards.
- change attribution decisions.
- view unmasked payout destinations without an approved incident need.
- mark product facts as true manually.

## 3.10 Product Owner or Product Team user

This role is product-scoped. It may inspect its own product's campaign performance, integration health, activity-rule definitions, merchant verification requests, and reconciliation exceptions.

A Courier Product Owner cannot access Servana-only operational data unless separately assigned a cross-product permission.

## 3.11 Privacy and Legal user

This role handles lawful data-access, correction, retention, erasure, legal-hold, consent, and disclosure processes.

It does not receive financial approval rights merely because it can place a legal hold. Erasure requests must not delete financial or audit records that Citrus Labs is legally required to retain; instead, the platform must apply lawful restriction, pseudonymization, or retention controls.

## 3.12 Tax and Compliance user

This role configures approved tax rules, reviews tax-profile exceptions, manages withholding evidence, and issues or validates tax certificates where required.

It cannot modify an earned reward amount except through a separately approved withholding or correction process.

## 3.13 Campaign approver

Campaign approval must be a separate permission from campaign creation.

A campaign approver confirms:

- Product scope.
- Commercial authorization.
- Reward amount or percentage.
- budget.
- eligible plans.
- retention and activity rules.
- payout terms.
- tax treatment.
- effective dates.
- published terms.

A campaign creator cannot approve the same high-risk campaign version where the configured approval policy requires separation.

## 3.14 Product Integration Service Account

A Product Integration Service Account is a non-human identity bound to one product, one environment, approved event types, approved verification endpoints, and specific signing keys.

Service accounts cannot sign in to dashboards. They cannot read Referrer payout data and cannot submit events for another product.

## 3.15 Merchant Administrator as an external actor

The Merchant Administrator is not a central Citrus Refer & Earn account type. The Merchant Administrator remains a source-product user and interacts with the referral platform only through product-native referral capture, limited attribution notices, dispute entry points, and product-generated business events.

The main specification must move the Merchant Administrator from “Users and Account Types” to “External Actors and Source-Product Users.” This correction preserves the architectural rule that merchant operations remain in the relevant Citrus product.

## 3.16 Internal authentication requirements

All internal human users must authenticate through approved enterprise SSO or an equivalent strong identity provider.

Mandatory controls are:

- MFA for every internal account.
- phishing-resistant MFA for Super Administrator, Finance approver, payout executor, Risk, and break-glass roles where supported.
- managed-device or conditional-access policies for high-risk roles.
- short idle timeout for privileged sessions.
- absolute session lifetime.
- reauthentication before payout approval, credential rotation, role assignment, unmasking, legal-hold removal, or break-glass activation.
- IP, device, geolocation, and impossible-travel monitoring.
- immediate revocation when employment or authorization ends.
- quarterly access review.
- immutable login and privilege-change audit events.

Referrer users may continue to use Magic Link or another approved passwordless method, but payout-method changes, legal-profile changes, ownership transfer, exports, and account closure require step-up verification.

### Authentication error handling

- Unknown internal user: deny access without revealing organizational membership.
- Disabled or terminated user: revoke all sessions and deny new tokens.
- MFA failure: deny the action, record the failure, and apply escalating rate limits.
- Identity-provider outage: deny privileged write operations; do not fall back to a weaker local password. Existing low-risk read-only sessions may remain valid only within their original expiry and policy.
- Role changed during an active session: invalidate authorization caches and require a new token.
- Suspicious session: revoke session, place account in review, and notify security operations.
- Break-glass use: require reason, incident reference, independent approval where practicable, and post-incident review.

## 3.17 User-impact rule for cross-cutting changes

Every configuration or workflow change must identify affected users before activation. At minimum, the change record must declare whether it affects Referrer legal entities, Referrer users, Merchant Administrators, Super Administrators, Campaign Approvers, Referral Operations, Finance roles, Payout Executors, Reconciliers, Risk and Fraud, Customer Support, Audit, Privacy and Legal, Tax and Compliance, Product Owners, Platform Engineering, or Product Integration Service Accounts.

A change is not complete until affected interfaces, permissions, notifications, support procedures, audit events, reports, and tests have been updated consistently.

---

# 4. Referrer Registration and Onboarding

## 4.1 Registration Entry Points

A potential Referrer may enter through:

- `refer.citrus.co.ke`
- A product’s “Refer & Earn” page.
- A product footer link.
- A product campaign page.
- A Super Administrator invitation.
- A partner invitation.
- An approved promotional campaign.
- A QR code.
- A support-provided registration link.

## 4.2 Registration Fields

Required fields include:

- Referrer legal-entity type: individual, sole proprietor, organization, association, agency, consultancy, or another approved legal person.
- Initial Referrer-user legal name and representative capacity.
- Organization owner designation where applicable.
- Legal first name and legal last name of the initial Referrer user.
- Referrer legal-entity name.
- Organization registration name and registration number where applicable.
- Display name.
- Email address.
- Phone number.
- Country.
- Preferred currency where supported.
- Preferred communication language.
- Acceptance of platform terms.
- Acceptance of privacy notice.
- Acceptance of anti-fraud declaration.
- Confirmation that the Referrer is not creating fake merchant accounts.
- Confirmation that merchant details will not be submitted without consent.

Conditional fields may include:

- National ID type.
- National ID number.
- Tax PIN.
- Company registration number.
- Business address.
- Beneficial owner information.
- Industry.
- Referrer category.
- Referral experience.
- Website.
- Social profile.
- Source of awareness.
- Campaign invitation code.

## 4.3 Verification

Registration requires:

1. Email verification.
2. Phone verification where enabled.
3. Duplicate identity screening.
4. Risk screening.
5. Terms acceptance.
6. Completion of minimum profile.
7. Payout-method setup before payout, though campaign browsing may be allowed before payout setup.

## 4.4 Independent Referrer State Dimensions

Replace the overloaded status with orthogonal state machines.

### 4.4.1 Account lifecycle

```text
account_status:
draft
active
restricted
suspended
deactivated
closed
rejected
```

### 4.4.2 Onboarding

```text
onboarding_status:
not_started
in_progress
minimum_profile_complete
complete
```

### 4.4.3 Email verification

```text
email_verification_status:
unverified
pending
verified
failed
```

### 4.4.4 Phone verification

```text
phone_verification_status:
not_required
unverified
pending
verified
failed
```

### 4.4.5 Identity review

```text
identity_status:
not_required
pending
verified
needs_information
rejected
expired
```

### 4.4.6 Terms

```text
terms_status:
not_accepted
accepted
reacceptance_required
```

### 4.4.7 Payout readiness

```text
payout_readiness_status:
not_configured
verification_pending
cooling_off
ready
held
unsupported
```

### 4.4.8 Risk

```text
risk_status:
clear
monitor
review_pending
soft_hold
hard_hold
closed_for_fraud
```

### 4.4.9 Campaign participation

Campaign participation belongs in separate enrollment records rather than the account status.

### 4.4.9 Capability derivation

Capabilities must be derived through policy, for example:

```text
can_browse_campaigns
can_enroll
can_generate_live_referral_assets
can_receive_attribution
can_accrue_rewards
can_be_paid
can_download_statements
can_manage_members
```

A Referrer may be able to refer and accrue rewards while `payout_readiness_status = not_configured`, but cannot be paid until ready.

### 4.4.10 Error handling and edge cases

- Email verified while phone pending: retain separate results.
- Identity expires after account activation: restrict high-risk actions and payouts without deleting referrals.
- Payout method rejected: account remains active; payout readiness changes to unsupported or not configured.
- Risk soft hold: permit sign-in and support access; block payouts according to policy.
- Terms reacceptance required: permit read-only access and support; block new referrals or campaign enrollment until acceptance.
- Organization has one member suspended: do not suspend the entity automatically unless risk decision applies to entity.
- Deactivated account has unpaid valid rewards: permit final-payout workflow according to policy.
- Rejected applicant attempts duplicate registration: route to identity-resolution or appeal rather than creating another entity.

### 4.4.11 Required data model

Store state columns in the relevant aggregate or dedicated history tables. Every transition must have an append-only history record with actor, reason, source, timestamp, and prior/new state.

### 4.4.12 Required tests

```text
ActiveWithoutPayoutMethodCapabilityTest
IdentityExpiryRestrictsPayoutOnlyTest
TermsReacceptanceCapabilityTest
IndependentVerificationStateTest
EntityAndMemberStatusIsolationTest
```

## 4.5 Registration Errors

### Duplicate Email

**Condition:** The email already belongs to an active Referrer.

**Response:**

```text
An account already exists for this email address. Use the secure sign-in link instead.
```

The platform sends a sign-in option and does not reveal additional account details.

### Duplicate Phone

The system requests sign-in or controlled identity review.

### Existing Deactivated Account

The platform does not create a new duplicate. It offers reactivation review where allowed.

### Invalid Email

The form rejects invalid syntax and disposable-email domains where policy blocks them.

### Verification Link Expired

The user can request a new link. The old link becomes invalid.

### Verification Link Reused

The system rejects reuse and records the event.

### Excessive Verification Requests

Rate limits apply by account, IP, device, email, and phone.

### Identity Review Required

The account can access a limited onboarding screen but cannot generate live referral assets until review completes.

## 4.6 Get-Started Checklist

The Referrer’s get-started page shows:

1. Verify email.
2. Verify phone.
3. Complete profile.
4. Add payout method.
5. Review available products.
6. Enroll in first campaign.
7. Generate first referral link.
8. Share link or code.
9. Review referral status definitions.
10. Review monthly payout schedule.

Progress persists across sessions.

---

# 5. Secure Contact and Payment-Method Capture

## 5.1 Contact Details

The platform captures:

- Verified email.
- Verified phone.
- Alternate phone where allowed.
- Country.
- Physical or postal address where required.
- Organization contact where applicable.
- Preferred support language.
- Preferred notification settings.

Contact changes require verification.

## 5.2 Supported Payout Methods

Initial supported methods may include:

```text
mpesa
bank_account
approved_digital_wallet
other_approved_method
```

The platform should prioritize M-Pesa for Kenya.

## 5.3 M-Pesa Payout Fields

- Account holder name.
- Mobile number.
- Country code.
- Network or payout rail where required.
- Ownership declaration.
- Verification status.
- Tokenized provider reference.
- Last four digits for display.
- Created date.
- Last verified date.
- Status.
- Failure count.
- Risk flags.

The full number is encrypted and masked in the interface.

## 5.4 Bank Payout Fields

- Account holder name.
- Bank name.
- Branch.
- Account number.
- Bank code.
- Branch code.
- SWIFT or routing code where required.
- Currency.
- Country.
- Verification document where required.
- Tokenized or encrypted record.
- Last four digits.
- Status.

## 5.5 Security Requirements

- Encryption in transit.
- Encryption at rest.
- Field-level encryption.
- Tokenization where a payment provider supports it.
- Least-privilege access.
- Masking by default.
- Step-up authentication.
- Change notifications.
- Cooling-off period after a high-risk change.
- Payout hold after a payout-destination change.
- Device and IP risk review.
- Audit logging.
- No payment detail in email.
- No payment detail in product databases.
- No payment detail in analytics logs.
- No plaintext secrets.

## 5.6 Payout-Method Statuses

```text
draft
verification_pending
verified
rejected
expired
suspended
replaced
disabled
```

## 5.7 Append-Only Payout-Method Replacement Workflow

A verified payout destination is an immutable financial instruction. It must never be edited in place.

```text
Referrer owner requests a change
→ step-up verification succeeds
→ payment_method_change_request is created
→ a new payout-method candidate is captured
→ ownership and provider verification begin
→ all unsettled payouts for the Referrer are placed on payout-method-change hold
→ risk review runs
→ candidate becomes verified
→ configured cooling-off period begins
→ Finance or automated policy confirms activation eligibility
→ candidate becomes active
→ former method becomes replaced for future payouts
→ historical payout items retain their original destination snapshot
→ notifications and audit records are created
```

The previous verified method remains an immutable historical record. It may remain technically valid at the provider but cannot be selected for new payout items while a high-risk change hold is active unless Finance approves a documented exception under maker/checker controls.

Required records include:

```text
referrer_payment_methods
payment_method_change_requests
payment_method_verifications
payment_method_activation_decisions
payment_method_change_holds
payment_method_risk_reviews
```

A payout item snapshots the approved payment-method token, masked display value, verification record, activation decision, and applicable risk-policy version. Later profile changes do not mutate that snapshot.

## 5.8 Deterministic Payout-Method Errors and Edge Cases

### Invalid M-Pesa number or bank data

Reject malformed or unsupported destination data before provider submission. Return a field-level validation error without storing raw values in logs. Repeated invalid attempts trigger rate limiting and risk review.

### Ownership mismatch

Set the candidate to `verification_pending` or `rejected`, preserve provider evidence, request approved supporting documents, and block activation. The existing method is not overwritten.

### Shared payout destination

Create a risk alert when one destination is linked to several Referrer entities. Legitimate organization structures may be approved through evidence-based review. Payout remains held after the configured reuse threshold until Risk clears the linkage.

### Change requested before payout cutoff

All unsettled payouts are held. A newly verified destination may be used only after activation and cooling-off. The platform does not silently select between the old and new destination.

### Change requested after payout cutoff but before provider submission

Invalidate the affected payout item's readiness, remove it from submission, and carry the liability forward until the new destination is activated or an approved Finance exception authorizes the old destination.

### Change requested after provider submission

Do not alter the submitted item. Continue status verification and reconciliation against the snapshotted destination. Place future unpaid rewards on hold. A provider-side cancellation may be attempted only through a controlled and audited process.

### Closed or invalid destination

A provider failure or returned payout restores the reward liability through append-only ledger entries. The Referrer must add and verify a replacement destination before retry.

### Provider outage

Keep verification or payout status pending. Do not mark a method verified or a payout paid without provider evidence. Retry idempotently and expose a non-sensitive pending state.

### Account-takeover indicators

Revoke sessions, freeze payment-method activation, hold unsettled payouts, notify the verified channels, and route the case to Risk. Support cannot override the hold.

### Lost phone or inaccessible bank account

Use identity-recovery procedures independent of the compromised destination. Do not send sensitive recovery links solely to the lost channel.

### Organization ownership transfer during a method change

Pause activation until the ownership transfer and new owner's authority are verified. Preserve the original request and require the new owner to confirm or withdraw it.

### Required tests

```text
VerifiedDestinationCannotBePatchedTest
PaymentMethodChangeCreatesNewRecordTest
AllUnsettledPayoutsHeldOnChangeTest
AfterCutoffChangeRemovesItemFromSubmissionTest
SubmittedPayoutDestinationSnapshotImmutableTest
ReturnedPayoutRestoresLiabilityTest
SharedDestinationRiskReviewTest
AccountTakeoverFreezesActivationTest
```

# 6. Products, Campaigns, and Campaign Versioning

## 6.1 Product Registry

Each integrated Citrus product has:

- Product ID.
- Product name.
- Product code.
- Description.
- Registration URL.
- Status.
- Supported currencies, with launch activation restricted to KES.
- Event endpoint configuration.
- Signing keys.
- Webhook configuration.
- Active-use verifier.
- Product owner.
- Cost centre.
- Finance owner.
- Support routing.
- Integration health.
- Last successful event.
- Last failed event.

## 6.2 Campaign Fields

Every campaign includes:

- Campaign ID.
- Campaign code.
- Product ID.
- Campaign name.
- Campaign description.
- Start date.
- End date.
- Enrollment start date.
- Enrollment end date.
- Status.
- Eligible Referrer categories.
- Eligible countries.
- Eligible merchant types.
- Eligible plans.
- Eligible billing periods.
- Reward model.
- Fixed reward amount.
- Percentage reward rate.
- Percentage basis.
- Campaign type, restricted at launch to `recurring_subscription_reward`.
- Currency, restricted at launch to `KES`.
- Reward duration months.
- Reward duration type, defaulting at launch to `fixed_calendar_duration`.
- Minimum retention milestone months, not less than four.
- Consecutive-retention requirement, mandatory at launch.
- Qualification frequency, restricted at launch to `monthly`.
- Active-use-required flag, mandatory `true` at launch.
- Active-use rule ID and immutable rule version.
- Payout frequency, restricted at launch to `monthly`.
- Clearing period.
- Holdback policy.
- Payout threshold.
- Maximum reward per merchant.
- Maximum monthly reward per Referrer.
- Campaign budget.
- Attribution window.
- Cookie window.
- Last-click or code-priority rule.
- Manual-code policy.
- Self-referral policy.
- Duplicate-merchant policy.
- Refund policy.
- Chargeback policy.
- Reversal policy.
- statement policy.
- tax policy.
- terms URL.
- campaign version.
- effective date.
- created by.
- approved by.
- audit reason.

## 6.3 Reward Models

### Fixed Amount

```text
reward = configured_fixed_amount
```

A fixed reward is payable once per qualifying month unless the campaign specifies a one-time conversion reward.

### Percentage

```text
reward = eligible_subscription_amount × configured_percentage_rate
```

The percentage basis must be explicit.

Supported bases include:

```text
gross_subscription_invoice_amount
net_subscription_amount_after_discount
cash_collected_and_reconciled
base_plan_amount_excluding_add_ons
eligible_subscription_lines_only
```

The following must be explicitly included or excluded:

- Tax.
- Discounts.
- Credits.
- One-time setup charges.
- Branch charges.
- SMS charges.
- Add-ons.
- Late fees.
- Refunds.
- Promotional waivers.
- Currency conversion.
- Payment-provider fees.

## 6.4 Reward Duration and Retention Configuration

Every launch recurring subscription-reward campaign defines:

```text
reward_duration_type = fixed_calendar_duration
reward_duration_months >= 4
minimum_retention_milestone_months >= 4
retention_requires_consecutive_months = true
```

The calendar reward window begins with the first eligible paid service period. A missed month earns no reward, resets the current consecutive-retention count, and does not extend the calendar reward window. This prevents indefinite liability and ensures that reports distinguish campaign Month 4 from the fourth rewarded month.

Examples of valid reward windows include 4, 6, 12, and 18 monthly service periods. The campaign approver may increase the retention milestone but may not reduce it below four.

The platform separately records:

```text
reward_eligibility_period_number
rewarded_qualification_months
current_consecutive_qualifying_months
maximum_consecutive_qualifying_months
retention_milestone_reached_at
reward_duration_completed_at
```

`reward_duration_completed` and `retention_milestone_reached` are distinct outcomes and must never be collapsed into one status.

A future `fixed_number_of_qualifying_months` campaign type requires separate approval, terms, a maximum observation window, reporting, tests, and liability controls. It is not enabled at launch.

## 6.5 Campaign Versioning

A campaign change creates a new immutable version.

The previous version remains attached to existing attributions.

The new version applies only according to its effective-date rule.

## 6.6 Campaign States

```text
draft
pending_approval
scheduled
active
paused
budget_exhausted
closed
archived
```

## 6.7 Campaign Validation Errors and Edge Cases

### End date before start date

Block save and identify the invalid fields.

### Non-KES campaign currency

Block activation with `CURRENCY_NOT_SUPPORTED_AT_LAUNCH`. Currency columns remain mandatory for accounting precision, but launch campaign, reward, ledger, and payout currency must be KES.

### Non-monthly qualification or payout frequency

Block activation with `FREQUENCY_NOT_SUPPORTED_AT_LAUNCH`. Administrators may configure monthly dates and business-day adjustment, not weekly, fortnightly, or quarterly execution.

### Reward duration below retention minimum

Block activation when reward duration is shorter than four service periods or shorter than the configured retention milestone.

### Retention milestone below four or nonconsecutive

Block activation. Existing nonconforming legacy campaigns may continue only under documented legal review and may not accept new attribution until remediated.

### Missing, inactive, or cross-product active-use rule

Block activation. Every launch recurring subscription campaign requires an approved product-specific rule version.

### Percentage above approved maximum or invalid fixed amount

Block save or require elevated commercial approval according to policy. Zero or negative reward amounts are invalid.

### No eligible plan or incompatible billing period

Block activation when the campaign cannot produce an eligible service period under its configured product plans.

### Tax launch mode unresolved

Block production activation until Citrus Labs selects and configures the approved tax mode. Tax-dependent campaigns cannot activate when required collection, withholding, or certificates are unsupported.

### Budget exhausted

Stop new attribution or set new claims to an explicitly published waitlist state. Existing earned liabilities and already locked campaign terms remain valid.

### Campaign paused

New attribution is blocked unless the immutable campaign version expressly permits continued capture. Existing referral qualification follows the published pause rule and cannot be changed retroactively.

### Campaign version changed after approval

Any material mutation invalidates approval and returns the version to review. An active version is immutable.

### Weekend, holiday, leap-year, and time-zone boundaries

Use the campaign service-period definition and the platform IANA time zone, default `Africa/Nairobi`. Store exact cutoffs in UTC. Business-day movement changes execution timing, not qualification period boundaries.

### Required tests

```text
LaunchCampaignNonKesRejectedTest
LaunchRejectsNonMonthlyPayoutFrequencyTest
MinimumRetentionBelowFourRejectedTest
ConsecutiveRetentionRequiredAtLaunchTest
SubscriptionCampaignRequiresActivityRuleTest
CampaignMutationInvalidatesApprovalTest
RewardDurationShorterThanRetentionRejectedTest
TaxLaunchModeRequiredTest
```

# 7. Referral Codes, Links, QR Codes, and Sharing

## 7.1 Identity Structure

Each Referrer has:

- One immutable internal Referrer ID.
- One human-readable Referrer reference.
- Product-specific referral codes.
- Campaign-specific links.
- Campaign-specific QR codes.

Example:

```text
Referrer ID: ref_01J...
Referrer reference: REF-0000142
Courier code: COURIER-X8T2K
Servana code: SERVANA-X8T2K
```

## 7.2 Referral Link Formats

Product-native:

```text
https://courier.citrus.co.ke/register?ref=COURIER-X8T2K
```

Central redirect:

```text
https://refer.citrus.co.ke/r/X8T2K?product=courier
```

Campaign-specific:

```text
https://refer.citrus.co.ke/c/courier-growth-2026/r/X8T2K
```

## 7.3 Referral Asset Screen

The Referrer sees:

- Product logo.
- Product name.
- Campaign name.
- Reward summary.
- Campaign period.
- Terms link.
- Referral code.
- Copy-code button.
- Referral link.
- Copy-link button.
- Download QR code.
- Share by WhatsApp.
- Share by email.
- Share through system share sheet.
- Campaign status.
- Number of referrals.
- Conversion count.
- Last click date.
- Attribution warning.
- Prohibited-conduct notice.

## 7.4 Link and Code Rules

- Codes are case-insensitive unless explicitly configured.
- Codes use non-ambiguous characters where possible.
- Codes are unique within the applicable product/campaign scope.
- Expired campaign links display an appropriate campaign message.
- Disabled Referrer links do not attribute new merchants.
- Existing valid attributions remain preserved.
- A link may capture first-party attribution cookies where lawful.
- Manual code entry is supported on Merchant Administrator registration.
- The code is snapshotted at registration.
- The original campaign is snapshotted at attribution.
- Product mismatch is blocked.

## 7.5 Sharing Rules

The Referrer must not:

- Make false income claims.
- Misrepresent employment by Citrus Labs.
- use unauthorized branding.
- promise guaranteed merchant results.
- create fake merchant accounts.
- submit merchant details without consent.
- use spam.
- impersonate Citrus Labs staff.
- purchase misleading advertising.
- alter campaign terms.

## 7.6 Sharing Errors

### Invalid Code

```text
This referral code is invalid for the selected product.
```

### Expired Code

```text
This referral code is no longer accepting new referrals.
```

### Product Mismatch

```text
This code belongs to a different Citrus product. Use the correct product registration link.
```

### Suspended Referrer

New attribution is blocked. The merchant may continue registration without attribution.

### Campaign Closed

The merchant can register, but no new referral reward is created.

---

# 8. Merchant Referral Attribution

## 8.1 Attribution Capture Points

Attribution may be captured through:

- Product referral link.
- Central redirect link.
- Campaign landing page.
- Manual referral code.
- QR code.
- Approved sales-assisted entry.
- Authorized migration from a legacy campaign.
- Approved support correction before attribution lock.

## 8.2 Attribution Workflow

```text
Potential merchant opens referral link or enters code
→ product validates code with central platform or cached signed data
→ product stores referral snapshot
→ merchant begins registration
→ Merchant Administrator verifies email
→ merchant tenant is created
→ product emits merchant_registered
→ central platform creates or confirms attribution
→ attribution enters pending verification
→ duplicate, self-referral, campaign, and identity checks run
→ attribution is confirmed or held
→ confirmed attribution is locked
```

## 8.3 Attribution Statuses

```text
captured
registration_started
merchant_registered
pending_verification
confirmed
locked
conflicted
held
invalid
cancelled
expired
reassigned_by_approved_resolution
```

## 8.4 Attribution Priority and Merchant Choice

The launch priority is:

1. A valid manual code explicitly confirmed by the Merchant Administrator before registration submission.
2. A valid signed product-specific referral link captured within the attribution window.
3. A valid first-party campaign cookie.
4. No attribution.

A signed-link code may be prefilled but must remain replaceable before registration submission. The interface must provide a clear “Use a different referral code” action and explain that replacement changes the referral source.

The source product submits all available evidence, including the signed-link claim, manual-code claim, cookie claim, merchant-confirmation timestamp, and registration-submission timestamp. The central platform applies precedence server-side. Frontend state is not authoritative.

An invalid replacement code does not destroy a previously valid link claim. A valid manual choice is preserved during a temporary central outage and resolved when the queued evidence reaches the central platform.

## 8.5 Attribution Lock and Controlled Correction

The launch attribution lock event is successful merchant-product tenant creation. Referral evidence captured before creation remains changeable according to the precedence rule; the winning attribution becomes immutable at creation subject to central confirmation.

After lock, attribution cannot be changed merely because another Referrer contacts the merchant or because the merchant enters a code late.

A correction requires:

- Evidence of a system failure, invalid original claim, fraud, duplicate tenant, or approved pre-lock choice that was not persisted.
- Referral Operations review.
- Risk review where fraud or identity linkage is involved.
- Maker/checker approval when reward liability changes.
- A new attribution record that references the superseded record.
- Adjustments or reversals rather than rewriting historical reward records.
- Affected-party notification and appeal rights where applicable.
- Immutable audit evidence.

The platform must not disclose a competing Referrer's personal information to the merchant or another Referrer.

## 8.6 Self-Referral Detection

Potential self-referral indicators include:

- Same verified email domain and identity.
- Same phone number.
- Same national ID.
- Same company registration number.
- Same payout method.
- Same beneficial owner.
- Same device.
- Same IP pattern.
- Same address.
- Same Merchant Administrator identity.
- Circular referral relationships.
- Abnormally repeated registrations.

A self-referral alert does not always prove fraud, especially for agencies or group companies. It creates a hold and review.

## 8.7 Duplicate Merchant Detection

The platform evaluates:

- Legal name.
- Registration number.
- tax identifier.
- phone.
- email.
- address.
- beneficial owner.
- payment phone.
- product tenant history.
- deactivated tenant history.

## 8.8 Attribution Conflict Workflow

```text
Conflict detected
→ attribution set to conflicted
→ reward qualification blocked
→ evidence preserved
→ Referral Operations reviews
→ merchant registration remains operational
→ affected Referrers receive a limited status notice
→ decision recorded
→ one attribution confirmed or all invalidated
→ appeal window applies where policy allows
```

## 8.9 Attribution Edge Cases

### Merchant Clicks Several Links

Apply campaign attribution policy. Do not pay several Referrers for one product tenant.

### Merchant Enters a Code After Account Creation

Default: reject because attribution is locked. Support may correct only where evidence proves a system failure and the correction window remains open.

### Merchant Uses Referral Link but Changes Browser

Manual code can preserve attribution. Otherwise, attribution may fail unless the product stored the referral server-side.

### Merchant Registers During Central Outage

The product stores the signed referral snapshot and queues the event.

### Same Business Registers for Two Products

Separate product-specific attribution is allowed.

### Same Business Creates Duplicate Tenants in One Product

Only the valid unique merchant tenant may qualify. Duplicates enter fraud review.

### Merchant Administrator Refers Their Own Second Branch

No new referral is created when branches belong to the same merchant tenant.

### Merchant Administrator Creates a Separate Legal Entity

It may qualify only after identity and self-referral review.

---

## 8.10 Merchant-Product Attribution Uniqueness

Only one effective earning attribution may exist for a merchant-product tenant at any point in time, regardless of campaign count.

The database must enforce a partial unique constraint equivalent to:

```text
UNIQUE (merchant_product_tenant_id, product_id)
WHERE is_earning_attribution = true
AND status IN ('pending_verification', 'confirmed', 'locked', 'held', 'conflicted')
```

Competing claims may coexist as evidence inside an attribution-conflict case, but they cannot both become payable. Concurrent confirmation attempts are controlled by the database constraint and transaction locking; the losing request enters conflict review.

A campaign migration normally retains the winning Referrer. A proven invalid or fraudulent attribution may be superseded through a controlled resolution, with all historical records preserved.

---

# 9. Product-Native Refer & Earn Experience

## 9.1 Public Product Website

Each eligible product includes:

```text
Public Website
├── Refer & Earn
├── How It Works
├── Campaign Terms
├── Become a Referrer
└── Merchant Registration
    └── Referral Code
```

## 9.2 Product Refer & Earn Page

The page shows:

- Product-specific campaign branding.
- Eligible merchant types.
- Reward overview.
- Qualification explanation.
- Four-month retention requirement.
- Monthly payout rule.
- No-guaranteed-income disclaimer.
- Referral steps.
- Become-a-Referrer CTA.
- Sign-in CTA.
- Terms.
- FAQ.
- Support email link.

## 9.3 Merchant Registration Screen

The registration screen includes:

```text
Referral code (optional)
```

Behavior:

- Prefilled when a signed referral link supplies it.
- Replaceable through an explicit merchant-confirmed action before registration submission.
- Immutable only after successful merchant-product tenant creation.
- Validated server-side.
- Shows only non-sensitive confirmation.
- Does not show reward amount unless policy allows.
- Registration continues when referral validation service is temporarily unavailable.
- Referral state becomes pending.

## 9.4 Merchant Administrator Dashboard Notice

Limited notice may include:

- Referral applied.
- Attribution date.
- Product campaign name.
- Support link for disputes.
- General status.

The dashboard does not expose Referrer financial information.

---

# 10. Product Integration Architecture

## 10.1 Integration Methods

Supported methods:

- Signed REST APIs.
- Signed webhooks.
- Event bus.
- Queue-based service integration.
- Scheduled reconciliation APIs.
- Secure batch import only for controlled migration.

## 10.2 Required Product Events and Event Authority

Core lifecycle, billing, and evidence events include:

```text
merchant_registration_started
merchant_registered
merchant_email_verified
merchant_setup_completed
merchant_subscription_selected
subscription_invoice_issued
subscription_invoice_fully_paid
subscription_payment_partially_paid
subscription_payment_reversed
subscription_refunded
subscription_chargeback_recorded
merchant_billing_suspended
merchant_reactivated
merchant_deactivated
merchant_plan_changed
merchant_branch_created
eligible_operational_activity_completed
merchant_identity_updated
merchant_duplicate_detected
```

Product-specific operational evidence events are traceability inputs. They do not independently make the final active-use decision.

The single authoritative final activity event is:

```text
merchant_activity_qualification_decided
```

It includes:

```json
{
  "decision": "qualified | not_qualified",
  "qualification_period_start": "...",
  "qualification_period_end": "...",
  "activity_rule_id": "...",
  "activity_rule_version": "...",
  "decision_version": 1,
  "supersedes_event_id": null,
  "evidence_summary": {}
}
```

For one merchant, product, rule version, and period, the highest valid `decision_version` is authoritative. A corrected decision references the superseded event and never deletes prior evidence.

## 10.3 Event Envelope and HTTP Signature Headers

The business event body contains no self-referential signature field:

```json
{
  "event_id": "evt_01...",
  "event_type": "subscription_invoice_fully_paid",
  "event_version": "1.0",
  "product_id": "courier_by_citrus",
  "merchant_id": "mer_01...",
  "merchant_account_reference": "MER-000184",
  "subscription_invoice_id": "subinv_01...",
  "occurred_at": "2026-06-25T12:00:00Z",
  "currency": "KES",
  "amount": 5000,
  "billing_period_start": "2026-06-01",
  "billing_period_end": "2026-06-30",
  "campaign_context": {
    "referral_attribution_id": "attr_01..."
  },
  "metadata": {}
}
```

Every request carries:

```text
X-Citrus-Key-Id
X-Citrus-Timestamp
X-Citrus-Signature
X-Citrus-Environment
X-Citrus-Event-Id
X-Citrus-Algorithm
```

Recommended signing input:

```text
HTTP_METHOD + "\n" + REQUEST_PATH + "\n" + TIMESTAMP + "\n" + ENVIRONMENT + "\n" + SHA256(RAW_BODY)
```

The exact encoding, algorithm, raw-byte handling, constant-time comparison, clock-skew window, and key-rotation process are versioned integration contracts.

## 10.4 Event Validation Sequence

The platform validates in this order:

1. Read the exact raw body without reserialization.
2. Require all signature headers.
3. Resolve the active key by product, environment, and key ID.
4. Validate timestamp within the permitted skew.
5. Verify the signature in constant time.
6. Parse and validate the schema.
7. Confirm the header event ID matches the body event ID.
8. Confirm product, service account, environment, and event-type authorization.
9. Validate merchant, invoice, currency, amount, billing-period, campaign-context, and activity-rule fields applicable to the event.
10. Apply idempotency and replay protection.
11. Persist the validation outcome, payload hash, key ID, algorithm, and correlation ID.

A duplicate event ID with an identical payload hash receives idempotent success. The same event ID with different content is quarantined as a critical integrity incident.

During key rotation, two explicitly designated keys may overlap for a bounded period. Revoked keys are rejected. Manual replay preserves the original event ID and occurred-at value while recording a new delivery attempt.

## 10.5 Idempotency

An event with the same `event_id` is processed once.

A duplicate valid delivery receives an idempotent success response.

A duplicate event with different content triggers a critical integrity alert.

## 10.6 Retry Policy

Product-side retry:

- Exponential backoff.
- bounded retry.
- persistent queue.
- dead-letter queue.
- alert after threshold.
- manual replay.

Central-side processing retry:

- transient dependency retry.
- idempotent handler.
- dead-letter queue.
- product-owner notification.
- reconciliation task.

## 10.7 Central Unavailability

Merchant registration and product operations must continue.

The product:

1. Validates a cached signed campaign snapshot where available.
2. Stores the referral code snapshot.
3. creates the merchant.
4. Marks attribution `pending_central_confirmation`.
5. queues events.
6. retries.
7. prevents reward payout until confirmation.
8. displays a non-blocking pending message.

## 10.8 Product Unavailability

The central platform:

- Holds qualification.
- does not guess.
- retries verification.
- shows `awaiting_product_confirmation`.
- alerts product integration owners.
- prevents payout for unresolved periods.
- preserves other products’ payouts unless consolidation policy requires splitting the payout run.

## 10.9 Reconciliation API

A scheduled reconciliation compares:

- Product merchant ID.
- Subscription invoice ID.
- Paid amount.
- payment date.
- refund amount.
- chargeback status.
- billing period.
- activity qualification.
- merchant status.

Disagreement creates a reconciliation exception.

---

# 11. Product-Specific Active-Use Qualification

## 11.1 Purpose and Mandatory Launch Rule

Subscription payment alone is never sufficient for a launch recurring subscription-reward campaign.

Every active launch campaign must have:

```text
active_use_required = true
activity_rule_id = approved product-specific rule
activity_rule_version = immutable version
```

The source product evaluates its product-specific operating facts. The central platform validates and stores the final decision and minimized evidence but does not independently infer product usage from detailed operational data.

## 11.2 Example Rules

### Courier by Citrus

```text
At least 5 completed deliveries in the qualification period
At least 1 active branch
No fraud or manual suspension
Subscription fully paid
```

### Servana by Citrus

```text
At least 10 completed service sessions
At least 3 validated merchant-client invoices
Subscription fully paid
No fraud or manual suspension
```

### Scribble by Citrus

```text
At least 3 active merchant users
At least 20 qualifying saved records
Subscription fully paid
No fraud or manual suspension
```

## 11.3 Active-Use Rule Structure

- Rule ID.
- Product ID.
- Campaign ID.
- Version.
- Qualification period.
- Minimum activity.
- qualifying event types.
- excluded events.
- branch requirement.
- user requirement.
- financial requirement.
- suspension rule.
- grace rule.
- evidence fields.
- effective date.

## 11.4 Product Responsibility and Final Decision Authority

The source product emits one final `merchant_activity_qualification_decided` event for each merchant, product, campaign activity-rule version, and qualification period.

The central platform may retain operational evidence events for traceability and may request re-evaluation. It must not convert evidence counts directly into a qualification decision unless a future, approved shared-rule-engine architecture explicitly transfers that authority.

Decision precedence is:

- Highest valid `decision_version` is current.
- A higher version references the decision it supersedes.
- Same version with different content is an integrity error.
- A lower version arriving later is historical and cannot override the current decision.
- A correction after payout triggers hold and reversal evaluation rather than deletion.

## 11.5 Activity Evidence

The central platform stores a minimal evidence snapshot:

- Product.
- Merchant.
- Qualification period.
- rule version.
- qualifying count.
- required count.
- branch count.
- status.
- event ID.
- evaluated date.
- source checksum.
- failure category.

It does not copy detailed customer or operational records.

## 11.6 Activity Errors and Edge Cases

### Conflicting same-version decisions

Quarantine both claims, keep qualification on hold, create an integrity alert, and require the product owner to issue a higher corrected decision version.

### Late activity decision

Keep the reward pending. When evidence proves the activity occurred within the original service period, qualify the original period and include the reward in the next payout run.

### Higher decision version arrives before lower version

Use the higher version. Store the later lower version as historical or idempotent evidence; it cannot override.

### Decision lacks rule version or references another product

Reject the decision or hold qualification and create a configuration mismatch exception.

### Operational evidence appears sufficient but final decision is not qualified

Trust the final product decision. Create a product-review request; the central platform must not override it.

### Backdated or corrected decision affecting paid reward

Preserve both decisions, place future rewards on hold, and open reversal evaluation. Any financial correction uses ledger entries.

### Sensitive evidence leakage

Reject or redact fields outside the approved evidence schema, alert the integration owner, and do not expose the data to Referrers or general support users.

### Product outage

Hold only affected qualification periods. Other products and unaffected payout items continue.

### Required tests

```text
FinalActivityDecisionAuthoritativeTest
SameDecisionVersionConflictTest
HigherDecisionVersionSupersedesTest
OperationalEvidenceDoesNotAutoQualifyTest
SensitiveEvidenceSchemaRejectionTest
LateActivityEvidenceOriginalPeriodTest
ProductOutageActivityHoldTest
```

# 12. Subscription Payment Qualification

## 12.1 Fully Paid Requirement

A reward period qualifies only after the eligible subscription obligation is fully paid.

“Fully paid” means:

- The amount required for the eligible period has been received.
- Payment is validated.
- Payment is cleared.
- Payment is reconciled.
- No unresolved shortfall remains.
- No active chargeback exists.
- No refund has reduced the eligible amount below the required amount.
- Currency and allocation are correct.

## 12.2 Partial Payment

A partial payment does not qualify.

The period remains:

```text
awaiting_full_subscription_payment
```

Once fully paid within the campaign’s late-payment window, the period may qualify.

## 12.3 Advance Payment

Where a merchant pays quarterly or annually, the campaign defines how monthly reward qualification works.

Supported methods:

```text
allocate_subscription_value_across_service_months
pay_reward_after_each_service_month
pay_reward_upfront_subject_to_holdback
pay_reward_after_full_billing_period
```

Default:

```text
allocate_subscription_value_across_service_months
pay_reward_after_each_service_month
```

Example:

Annual eligible subscription amount: KES 120,000  
Monthly eligible basis: KES 10,000  
Percentage reward: 10%  
Monthly reward: KES 1,000 for each qualifying service month.

## 12.4 Discounts

The campaign defines whether the reward uses:

- Gross plan price.
- Net amount after discount.
- Cash collected.
- Base plan only.

The basis is snapshotted.

## 12.5 Free Trial

A free trial does not generate a monthly subscription reward unless the campaign explicitly defines a separate trial-conversion reward.

The first reward month begins with the first eligible paid service period.

## 12.6 Refunds

A refund may:

- Reduce the eligible amount.
- Cancel the reward.
- create a proportional reversal.
- move the reward to hold.

The original reward remains in history.

## 12.7 Chargebacks

A chargeback creates an immediate risk hold and reversal evaluation.

## 12.8 Late Payment

Campaign configuration defines:

- Maximum late-payment window.
- Whether qualification is retroactive.
- Which payout run receives the reward.
- Whether active use must also have occurred during the original service period.

## 12.9 Plan Changes

The reward uses the eligible plan and amount for each service period.

A mid-cycle plan change follows the source product’s billing rules.

## 12.10 Billing Suspension

A billing-suspended merchant does not qualify for a period unless the eligible obligation is later fully settled within the allowed window and the activity requirement remains valid.

---

# 13. Monthly Qualification Engine

## 13.1 Qualification Period Record

Each referred merchant receives one qualification record per campaign period.

Fields include:

- Qualification ID.
- Referrer ID.
- Merchant ID.
- Product ID.
- Campaign ID.
- campaign version.
- period number.
- period start.
- period end.
- subscription invoice.
- eligible amount.
- payment status.
- payment cleared date.
- active-use status.
- attribution status.
- merchant status.
- risk status.
- reward eligibility period number.
- rewarded qualification month count.
- current and maximum consecutive qualifying month counts.
- retention milestone status and date.
- reward-duration completion status and date.
- qualification status.
- failure reason.
- reward calculation ID.
- evaluated at.

## 13.2 Qualification Statuses

```text
not_started
in_progress
awaiting_subscription_invoice
awaiting_full_subscription_payment
awaiting_payment_clearance
awaiting_activity_confirmation
awaiting_attribution_confirmation
awaiting_risk_review
qualified
not_qualified
held
expired
reopened
reversed
```

## 13.3 Qualification Conditions

A period becomes `qualified` only when:

```text
attribution_status = confirmed_or_locked
AND campaign_status permits existing qualifications
AND merchant_subscription_obligation = fully_paid
AND payment_status = cleared_and_reconciled
AND merchant_activity_status = qualified
AND merchant_operational_status is eligible
AND merchant_billing_status is eligible
AND risk_status = cleared
AND reward_duration has not expired
AND no disqualifying refund or chargeback exists
```

## 13.4 Independent Reward and Retention Counters

The platform tracks:

```text
reward_eligibility_period_number
rewarded_qualification_months
current_consecutive_qualifying_months
maximum_consecutive_qualifying_months
retention_milestone_months
retention_milestone_reached_at
reward_duration_type
reward_duration_months
reward_duration_completed_at
```

A qualified period increments `rewarded_qualification_months` and `current_consecutive_qualifying_months`. A nonqualified or validly reversed period resets the current consecutive count to zero without erasing the historical rewarded count or maximum sequence.

Retention is reached only when the current consecutive count equals or exceeds the campaign milestone. Reward-duration completion follows the campaign's calendar window and is evaluated independently.

A late valid decision may cause deterministic sequence recalculation. Recalculation creates a versioned derived result and any necessary ledger adjustment; it does not overwrite financial history.

## 13.5 Missed Month, Reactivation, and Duration Behavior

Under the launch `fixed_calendar_duration` model, a missed month:

- Receives no reward.
- Resets the current consecutive-retention count.
- Does not erase previously earned rewards.
- Does not extend the reward window.
- Remains visible as a nonqualified service period.

Merchant cancellation and later reactivation do not restart or extend the original campaign window unless the immutable campaign version contains an approved grace rule. A plan change does not reset retention unless the new plan is ineligible and the campaign terms expressly terminate eligibility.

A future fixed-number-of-qualifying-months campaign requires a separate campaign type and a maximum observation window. It is not enabled at launch.

## 13.6 Month 1 Payment

Month 1 reward is considered after Month 1 closes.

It is not paid immediately after registration or subscription payment.

It enters the next monthly payout run after all checks and clearing periods.

## 13.7 Retention Milestone

The milestone is recorded when the merchant completes the configured number of consecutive qualified service periods. For the launch default, this is four consecutive months.

The milestone may occur after calendar Month 4 when an earlier service period was missed. The platform must communicate the actual service period in which the sequence was completed and must not label the fourth rewarded month as “Month 4 retained” unless it is also the fourth consecutive campaign period.

When the milestone is reached:

- The referral receives `retention_milestone_reached`.
- The Referrer receives a notification.
- Campaign analytics record retained conversion.
- No automatic bonus is paid unless the campaign version defines one.
- Future monthly rewards continue until the reward-duration window ends.

Ordinary later churn does not reverse the milestone or valid earlier rewards. Proven fraud or invalidation may recalculate the sequence through an audited decision.

## 13.8 Qualification Failure Reasons

Referrer-visible categories may include:

```text
subscription_not_fully_paid
payment_still_clearing
merchant_activity_requirement_not_met
merchant_account_inactive
merchant_billing_suspended
qualification_under_review
campaign_period_expired
attribution_not_confirmed
```

Internal reasons may be more detailed but remain masked.

---

# 14. Reward Calculation

## 14.1 Calculation Snapshot

Every calculation stores:

- Referrer.
- merchant.
- product.
- campaign.
- campaign version.
- qualification period.
- reward model.
- fixed amount.
- percentage rate.
- percentage basis.
- eligible subscription amount.
- excluded amount.
- gross calculated reward.
- cap.
- deduction.
- adjustment.
- final reward.
- currency.
- exchange-rate snapshot, reserved and null at KES-only launch.
- calculation timestamp.
- status.
- reason.
- formula version.

## 14.2 Fixed Example

```text
Fixed reward: KES 1,000
Qualified period: Month 2
Final reward: KES 1,000
```

## 14.3 Percentage Example

```text
Eligible subscription amount: KES 5,000
Reward rate: 10%
Gross reward: KES 500
Final reward: KES 500
```

## 14.4 Percentage With Discount

```text
Plan price: KES 5,000
Discount: KES 1,000
Net eligible amount: KES 4,000
Reward rate: 10%
Reward: KES 400
```

This applies only where campaign basis is net amount after discount.

## 14.5 Caps

Campaigns may define:

- Per-month reward cap.
- Per-merchant lifetime cap.
- Per-Referrer monthly cap.
- campaign budget cap.
- product budget cap.

Caps must not silently reduce already earned rewards after the fact.

## 14.6 Rounding

The platform defines:

- Decimal precision.
- rounding method.
- currency minor unit.
- accumulation rules.

Default KES:

```text
round_half_up_to_2_decimal_places
```

Payout providers may require whole shillings. The ledger preserves precision; payout rounding differences are recorded.

## 14.7 Negative Reward

A calculation cannot create a negative earned reward.

Negative corrections use adjustment or reversal records.

## 14.8 Calculation Errors

### Missing Campaign Version

Block calculation and alert operations.

### Unsupported or mismatched currency

Hold the event or calculation and create `CURRENCY_NOT_SUPPORTED_AT_LAUNCH` or `EVENT_CURRENCY_MISMATCH`. The platform must not improvise foreign-exchange conversion.

### Missing Eligible Amount

Request source verification.

### Duplicate Calculation

Enforce unique constraint for attribution + period + calculation version.

### Rate Outside Campaign Range

Critical configuration error; block.

---

# 15. Reward Ledger

## 15.1 Purpose

The reward ledger is the immutable financial record of Referrer earnings.

## 15.2 Ledger Entry Types

```text
reward_accrual
reward_hold
reward_release
reward_adjustment_credit
reward_adjustment_debit
reward_reversal
payout_allocation
payout_return
withholding_deduction
rounding_adjustment
```

## 15.3 Reward Statuses

```text
calculated
pending_clearance
held
earned
payable
scheduled_for_payout
paid
failed_payment
carried_forward
partially_reversed
reversed
expired_under_lawful_policy
```

## 15.4 No Deletion

Ledger entries cannot be hard-deleted.

## 15.5 Product Accounting Allocation

Every entry includes:

- Product.
- campaign.
- cost centre.
- merchant.
- qualification period.
- accounting category.
- liability account.
- expense account.
- currency.
- amount.
- tax treatment.
- payout run.

---

# 16. Monthly Payout Processing

## 16.1 Payout Calendar

The Super Administrator configures:

- Qualification cutoff.
- clearing cutoff.
- payout-run creation date.
- approval date.
- payout execution date.
- retry window.
- statement date.

Example:

```text
Qualification period closes: Last day of month
Clearing complete: 5th day of following month
Payout run created: 7th
Approval complete: 9th
Payout execution: 10th
```

## 16.2 Payout Eligibility

A reward enters a payout run only when:

- Reward status is `payable`.
- Reward currency is KES.
- The selected payout method is verified, active, outside cooling-off, and not subject to a change hold.
- The Referrer legal entity and authorized users remain in a payout-permitted state.
- No risk, legal, tax, identity, or operational hold exists.
- The minimum payout threshold is met.
- The approved tax launch mode has produced a complete tax decision for the payout.
- The monthly payout period is open.
- Product allocation, campaign allocation, and ledger balances reconcile.
- Maker/checker requirements can be satisfied.

A suspended Referrer may receive a final payout only when the suspension policy, Risk, Legal, and Finance permit it. Suspension never silently forfeits an earned liability.

## 16.3 Minimum Threshold

Where payable earnings are below the threshold:

```text
status = carried_forward
```

The amount is added to a later payout.

No earning is forfeited merely because it is below the threshold, unless lawful dormancy or unclaimed-property rules require another treatment.

## 16.4 Mandatory Consolidated KES Payout

At launch, one payout may and normally should combine payable KES earnings from several Citrus products for the same Referrer legal entity and active payout destination.

The payout item preserves immutable component allocations:

```text
payout_item
└── payout_item_allocations
    ├── product
    ├── campaign and campaign version
    ├── merchant-product tenant
    ├── qualification period
    ├── reward-ledger entry
    ├── gross amount
    ├── withholding amount
    ├── net amount
    └── cost centre and accounting codes
```

The sum of component allocations must equal the payout item's gross, withholding, and net totals. The sum of payout items must equal the provider batch total. A mismatch blocks approval and execution.

An unresolved reward or product-specific hold does not automatically block unrelated payable allocations. The run builder excludes the affected allocation and records the reason. It must not silently reduce an already approved item.

## 16.5 Payout Run Statuses

```text
draft
calculating
ready_for_review
review_in_progress
approved
submitted
processing
partially_successful
successful
failed
cancelled
reconciled
locked
```

## 16.6 Payout Item Statuses

```text
pending
excluded
held
approved
submitted
processing
paid
failed_retryable
failed_final
returned
reversed
```

## 16.7 Mandatory Maker/Checker and Separation of Duties

Every production payout run requires at least two distinct human actors:

```text
preparer != approver
```

High-value, exception-bearing, or high-risk runs require the configured separation among preparer, reviewer, approver, executor, and reconciler. Actor identity, not possession of multiple role names, determines separation.

Approval policy may depend on amount, risk, product, campaign, number of Referrers, manual corrections, payout-method exceptions, and legal or fraud holds.

Any material run mutation after approval invalidates prior approvals and returns the run to review. Material mutation includes changing items, amounts, allocations, payout methods, withholding, provider routing, or exception decisions.

The same controls apply to high-value manual adjustments, reward reversals, payout-destination exceptions, locked-period reopening, financial attribution reassignments, and break-glass financial actions.

## 16.8 Payout Attempt

Each attempt records:

- Provider.
- provider request ID.
- idempotency key.
- payout method token.
- amount.
- currency.
- request time.
- response time.
- response code.
- provider status.
- failure reason.
- retry count.
- reconciliation result.

## 16.9 Failed Payout

A failed payout does not change the reward to paid.

The Referrer receives an email with a safe failure category.

The platform may:

- Retry automatically.
- request payment-method update.
- hold until corrected.
- move to next payout run.

## 16.10 Returned Payout

Returned funds create:

- Payout return record.
- reward liability restoration.
- accounting reversal.
- support task.
- Referrer notification.

## 16.11 Payout Reconciliation and Finality

Provider acceptance is not final payment. The Referrer-facing `paid` state is derived only from `reconciled_paid`.

Use the following outcome model:

```text
approved
submitted
provider_accepted
processing
provider_reported_success
reconciliation_pending
reconciled_paid
failed_retryable
failed_final
returned
```

The reconciliation workflow is:

```text
approved payout item
→ idempotent provider submission
→ provider request and acknowledgement persisted
→ authenticated callback and/or trusted status query
→ signature, amount, currency, destination token, and provider reference matched
→ settlement result recorded
→ ledger allocation finalized
→ final statement generated or updated
```

Every reconciliation result is append-only. A later return creates a new return record, restores the liability, creates accounting reversal entries, notifies the Referrer, and requires a valid destination before retry.

Error handling includes:

- Provider timeout: mark `submission_unknown`; query by idempotency key before retry.
- Missing callback: poll the provider.
- Invalid callback signature: reject, alert, and query through a trusted channel.
- Amount or currency mismatch: block finality and create a critical exception.
- Duplicate callback: process idempotently.
- Reused provider reference: create a critical integrity alert.
- Partial batch success: reconcile each item independently and keep the run partially successful until all items are terminal.
- Provider outage: preserve liability and retry; do not mark failed final solely because the provider is unavailable.
- Statement generated before finality: mark provisional or delay it; issue a final version only after reconciliation.

Required records include:

```text
payout_provider_requests
payout_provider_responses
payout_callbacks
payout_status_queries
payout_reconciliation_results
payout_reconciliation_exceptions
payout_returns
```

Only a reconciled result may produce the final `paid` state.

# 17. Referrer Dashboard and User Experience

## 17.1 Landing Page

The Referrer landing page contains:

### Summary Cards

- Total referred merchants.
- Registered merchants.
- Active referred merchants.
- Qualifying this month.
- Pending qualification.
- On hold.
- Four-month milestone reached.
- Pending earnings.
- Payable earnings.
- Next payout estimate.
- Paid this month.
- Lifetime earnings.

### Product Breakdown

A table or cards show:

- Product.
- referred merchants.
- active merchants.
- qualifying merchants.
- pending rewards.
- payable rewards.
- paid earnings.

### Recent Activity

- Merchant registered.
- subscription paid.
- qualification confirmed.
- reward earned.
- payout scheduled.
- payout completed.
- support reply received.

### Alerts

- Payout method missing.
- payout method verification pending.
- payment failed.
- campaign ending.
- referral under review.
- profile verification required.
- terms update.

## 17.2 Navigation

```text
Overview
Refer Merchants
Products & Campaigns
My Referrals
Qualification History
Earnings
Payments
Statements
Payment Method
Support
Notifications
Profile
Security
Legal & Policies
```

## 17.3 Refer Merchants Screen

The screen allows:

- Select product.
- select campaign.
- view reward summary.
- copy link.
- copy code.
- download QR.
- share.
- view clicks.
- view registrations.
- view prohibited conduct.
- view terms.

## 17.4 My Referrals Screen

Columns:

- Merchant display name.
- product.
- campaign.
- referral date.
- registration status.
- setup status.
- current qualification month.
- subscription status category.
- activity status category.
- retention progress.
- reward status.
- next review date.

Filters:

- Product.
- campaign.
- merchant.
- date.
- status.
- retention milestone.
- reward status.

## 17.5 Referral Detail Screen

The Referrer sees:

- Merchant display name.
- product.
- campaign.
- attribution date.
- attribution status.
- current month.
- retention timeline.
- month-by-month qualification.
- reward amount per month.
- payout allocation.
- masked status reasons.
- support link.

The screen must not expose private merchant data.

## 17.6 Earnings Screen

Summary:

- Pending calculation.
- pending clearance.
- held.
- earned.
- payable.
- scheduled.
- paid.
- reversed.
- lifetime total.

Detailed table:

- Period.
- merchant.
- product.
- campaign.
- reward model.
- eligible basis.
- gross reward.
- adjustment.
- final reward.
- status.
- payout date.

## 17.7 Payments Screen

The “current payment history” requirement is implemented as:

### Current Payment Status

- Current payout cycle.
- cutoff date.
- amount currently payable.
- amount carried forward.
- amount on hold.
- expected payout date.
- payout method ending.
- verification status.
- current payout-run status.

### Payment History

- Payout reference.
- payout date.
- amount.
- currency.
- method.
- status.
- product allocation.
- provider reference.
- statement.
- failure reason category where applicable.

## 17.8 Statements

Basic monthly earnings statements and payout statements are Phase 1 requirements.

The Referrer can download:

- Monthly earnings statement.
- Monthly payout statement.
- Product-specific allocation statement.
- Campaign-specific statement.
- Annual summary when implemented.
- Withholding statement or certificate where required by the approved tax mode.

A final payout statement is generated from reconciled data and includes the Referrer legal entity, statement version, period, gross rewards, adjustments, withholding, net paid amount, payment method mask, provider reference, reconciliation date, product and campaign allocations, returned or reversed items, and support reference.

Statements are versioned and append-only. A correction creates a replacement statement linked to the prior version; the prior document remains retained and visibly superseded.

Signed download URLs expire, authorization is rechecked at download time, and every download is audited. Suspended users retain secure access to their own statements unless a lawful restriction applies.

## 17.9 Support

Support entry points:

- “Contact Support” button.
- email link.
- support form.
- payout-specific help.
- attribution-specific help.
- qualification-specific help.
- account help.

Support categories:

```text
account_access
profile_verification
payment_method
referral_attribution
merchant_status
qualification
reward_calculation
payout_pending
payout_failed
statement
fraud_or_abuse
campaign_terms
other
```

## 17.10 Mobile Experience

The dashboard is mobile-first:

- Responsive cards.
- bottom or collapsible navigation.
- touch-friendly actions.
- easy code copying.
- native share sheet.
- accessible status chips.
- statement download.
- support creation.

---

# 18. Email and Notification System

## 18.1 Required Emails

- Welcome.
- Verify email.
- Verify phone.
- Profile incomplete.
- Payment method added.
- Payment method changed.
- Payment method verified.
- Payment method rejected.
- Campaign enrollment.
- Referral link created.
- Referred merchant registered.
- Attribution confirmed.
- Attribution under review.
- Merchant Month 1 qualified.
- Monthly reward earned.
- Four-month milestone reached.
- Reward held.
- Reward released.
- Payout scheduled.
- Payout processing.
- Payout completed.
- Payout failed.
- Payout returned.
- Statement ready.
- Support case created.
- Support reply.
- Account suspended.
- Account reactivated.
- Campaign ending.
- Terms changed.

## 18.2 Email Content Rules

Emails contain:

- Referrer display name.
- product.
- merchant display name where permitted.
- qualification period.
- reward amount where appropriate.
- payout status.
- safe support link.
- no full payment details.
- no merchant-sensitive details.
- no internal fraud evidence.

## 18.3 Delivery Tracking

Store:

- Template version.
- recipient.
- event.
- sent time.
- provider ID.
- delivery state.
- bounce.
- complaint.
- retry count.

## 18.4 Email Failures

- Retry transient failures.
- suppress invalid addresses after policy threshold.
- show dashboard alert.
- request email correction.
- never block reward earning solely because an email failed.
- high-risk account actions may require successful verified-channel confirmation.

---

# 19. Customer Support Workflow

## 19.1 Case Creation

A case includes:

- Case number.
- Referrer.
- category.
- product.
- campaign.
- merchant reference where relevant.
- reward or payout reference.
- subject.
- description.
- attachments.
- priority.
- status.
- assigned team.
- created date.
- SLA target.

## 19.2 Case Statuses

```text
new
open
awaiting_referrer
awaiting_internal_team
awaiting_product_team
under_review
resolved
closed
reopened
```

## 19.3 Support Security

Support sees masked payment data.

Any unmasking requires permission and audit.

Support cannot request full PINs, passwords, or Magic Links.

## 19.4 Email Reply Integration

Replies to a case email append to the case thread after sender verification.

Attachments are malware-scanned.

## 19.5 Escalation

- Attribution → Referral Operations.
- Product activity → Product team.
- Reward calculation → Referral Operations and Finance.
- Payout → Finance.
- Fraud → Risk.
- privacy → Privacy or Legal.
- technical integration → Platform Engineering.

---

# 20. Fraud, Abuse, and Risk Controls

## 20.1 Risk Events

- Self-referral.
- duplicate merchant.
- multiple merchants sharing identity.
- same payout destination across many Referrers.
- unusual referral velocity.
- rapid merchant churn.
- repeated trial abuse.
- fabricated activity.
- repeated refunds after rewards.
- chargeback pattern.
- device-farm behavior.
- IP concentration.
- circular referrals.
- internal-user collusion.
- altered event payload.
- duplicate product event.
- payout-destination change before payout.
- suspicious support pressure.
- false merchant consent.

## 20.2 Risk Actions

```text
monitor
soft_hold
hard_hold
request_information
manual_review
restrict_new_referrals
suspend_referrer
invalidate_attribution
reverse_reward
escalate_legal
```

## 20.3 Fraud Case

A fraud case stores:

- Indicators.
- linked accounts.
- linked merchants.
- linked payment methods.
- evidence.
- product events.
- actions.
- reviewer.
- decision.
- appeal.
- audit trail.

## 20.4 Fairness

Automated risk scores shall not silently forfeit rewards.

High-impact actions require a reasoned decision and review according to policy.

## 20.5 Self-Referral Edge Cases

Legitimate relationships may include:

- agency managing several clients.
- holding company.
- franchise group.
- consultant using a shared office.
- family business.
- accountant using one business contact number.

These require evidence-based review, not automatic permanent rejection.

---

# 21. Adjustments, Holds, Reversals, and Appeals

## 21.1 Holds

A hold pauses payout without deleting the reward.

Hold reasons include:

- Payment clearing.
- attribution review.
- product-event mismatch.
- payment-method review.
- fraud review.
- refund window.
- legal hold.
- tax information missing.
- campaign budget review.

## 21.2 Adjustment

An adjustment corrects an amount.

It requires:

- Original entry.
- amount.
- direction.
- reason.
- evidence.
- maker.
- checker where required.
- effective payout period.
- notification rule.

## 21.3 Reversal

A reversal is permitted for:

- Subscription refund.
- chargeback.
- self-referral.
- duplicate merchant.
- duplicate attribution.
- fabricated activity.
- event fraud.
- payout fraud.
- system calculation error.
- campaign ineligibility proven after initial error.

## 21.4 No Automatic Clawback for Ordinary Churn

A merchant’s ordinary later cancellation does not reverse valid earlier rewards.

## 21.5 Recovery of Overpayment

Recovery methods:

- Offset future earnings.
- request repayment.
- provider reversal where lawful and possible.
- legal recovery for fraud.
- write-off under approved policy.

The platform must not create a hidden negative balance without statement visibility.

## 21.6 Appeal

The Referrer may appeal eligible decisions.

Appeal fields:

- Decision.
- reason.
- evidence.
- submitted date.
- deadline.
- reviewer.
- outcome.
- explanation.

---

# 22. Super Administrator Experience

## 22.1 Navigation

```text
Overview
Products
Campaigns
Referrers
Merchant Referrals
Attribution Conflicts
Qualification Reviews
Reward Ledger
Payout Runs
Payout Methods
Reconciliation
Fraud & Risk
Adjustments & Reversals
Support Cases
Email Templates
Reports & Analytics
Audit Logs
Integration Health
Configuration
Internal Users & Roles
```

## 22.2 Overview Dashboard

Cards:

- Active campaigns.
- active Referrers.
- new Referrers.
- referred registrations.
- confirmed attributions.
- Month 1 conversions.
- four-month retained merchants.
- reward liability.
- payable amount.
- paid this month.
- payout failures.
- fraud holds.
- integration failures.
- campaign budget utilization.

## 22.3 Campaign Builder

Step 1: Product  
Step 2: Eligibility  
Step 3: Attribution  
Step 4: Reward model  
Step 5: Qualification  
Step 6: Retention  
Step 7: Payout  
Step 8: Budget and caps  
Step 9: Terms and notifications  
Step 10: Review and approval

## 22.4 Referrer Detail

- Profile.
- verification.
- products.
- campaigns.
- referral volume.
- conversion rate.
- retained merchants.
- earnings.
- payouts.
- payment-method status.
- risk alerts.
- support cases.
- audit history.

Sensitive payment data remains masked.

## 22.5 Merchant Referral Detail

- Source product.
- merchant.
- Referrer.
- code.
- campaign version.
- attribution evidence.
- qualification periods.
- subscription evidence.
- activity evidence.
- rewards.
- payout allocations.
- holds.
- disputes.
- audit history.

---

# 23. Finance and Accounting

## 23.1 Liability Recognition

When a reward becomes earned, the platform records a reward liability.

## 23.2 Product Cost Allocation

Every amount is allocated to the responsible product and campaign cost centre.

## 23.3 Consolidated Payment Accounting

A single payment may settle several product liabilities.

The ledger preserves:

- Product expense.
- campaign expense.
- Referrer payable.
- provider fee.
- withholding.
- settlement.
- return.
- reversal.

## 23.4 Tax and Withholding Launch Gate

Tax readiness is a production launch decision, not a deferred optional feature.

Before activating production payouts, Citrus Labs must obtain current qualified tax and legal advice and select one approved mode.

### Mode A — Minimum tax support at launch

Implement:

- Tax-profile collection and verification status.
- Jurisdiction and tax identifier where required.
- Versioned withholding rules, thresholds, and exemptions.
- Gross reward, withholding, and net payout calculations.
- Withholding ledger entries.
- Statements or certificates where required.
- Finance, Referrer, and Audit reporting.

### Mode B — Disable tax-dependent campaigns

No campaign may activate where applicable law or approved policy requires tax processing that the platform cannot perform. Active campaigns must not contain an unreachable “required tax data complete” payout condition.

Every tax decision stores:

```text
tax_rule_id
tax_rule_version
jurisdiction
tax_profile_id
gross_reward
withholding_amount
net_payout
exemption_reference
effective_date
```

Tax-rule changes are prospective. Errors use adjustments and replacement documents. Missing required tax data holds payout but does not erase reward accrual. Unsupported jurisdictions are blocked according to legal policy.

## 23.5 Period Locks

Finance can lock:

- Qualification period.
- reward period.
- payout period.
- accounting period.

Post-lock corrections require controlled reopening or next-period adjustment.

## 23.6 Finance Reports

- Reward liability.
- payable rewards.
- paid rewards.
- product allocation.
- campaign expense.
- payout failures.
- returns.
- reversals.
- withholding.
- provider fees.
- unreconciled payouts.
- aging.
- cost per acquired merchant.
- cost per retained merchant.

---

# 24. Data Model

## 24.1 Identity, Legal Entity, Membership, and Authentication Tables

```text
referrer_entities
referrer_entity_profiles
referrer_users
referrer_memberships
referrer_roles
referrer_contacts
referrer_contact_verifications
referrer_identity_checks
referrer_terms_acceptances
referrer_tax_profiles
referrer_security_events
referrer_account_state_history
referrer_onboarding_state_history
referrer_risk_state_history
internal_users
roles
permissions
user_roles
role_permissions
product_scopes
campaign_scopes
approval_assignments
service_accounts
service_account_scopes
service_account_keys
internal_security_events
```

A Referrer legal entity owns contractual, financial, campaign, referral, and tax records. A Referrer user is a natural person with a membership and role. Internal roles and scopes are explicit and default-deny.

## 24.2 Product, Campaign, and Enrollment Tables

```text
referral_products
product_integration_accounts
product_integration_keys
product_integration_key_rotations
referral_campaigns
referral_campaign_versions
campaign_eligible_plans
campaign_activity_rules
campaign_budgets
campaign_terms_versions
campaign_approval_requests
campaign_approval_decisions
referrer_campaign_enrollments
campaign_enrollment_reviews
campaign_enrollment_status_history
```

Every active campaign version is immutable and records KES currency, monthly qualification and payout frequency, fixed-calendar reward duration, a retention milestone of at least four consecutive months, a mandatory activity-rule version, tax mode, and approval evidence.

## 24.3 Merchant Reference and Attribution Tables

```text
merchant_legal_entity_references
merchant_product_tenants
merchant_identity_snapshots
referral_codes
referral_links
referral_clicks
referral_attributions
referral_attribution_evidence
referral_attribution_claims
referral_attribution_conflicts
referral_attribution_resolutions
referral_attribution_status_history
```

The central merchant reference stores only minimized referral-relevant fields. Source products remain authoritative for operational merchant facts.

`referral_attributions` includes:

```text
id
merchant_product_tenant_id
product_id
referrer_entity_id
campaign_id
campaign_version_id
status
effective_from
effective_to
is_earning_attribution
supersedes_attribution_id
resolution_case_id
locked_at
created_at
```

## 24.4 Qualification, Evidence, Calculation, and Ledger Tables

```text
referral_qualification_periods
referral_activity_evidence
referral_activity_decisions
referral_subscription_evidence
referral_reward_calculations
referral_reward_calculation_versions
referral_reward_ledger_entries
referral_reward_holds
referral_adjustments
referral_reversals
retention_sequence_results
```

Qualification records separately store rewarded-month counts, current and maximum consecutive counts, retention milestone status, and reward-duration completion.

## 24.5 Payout Method, Approval, Payout, Tax, and Statement Tables

```text
referrer_payment_methods
payment_method_change_requests
payment_method_verifications
payment_method_activation_decisions
payment_method_change_holds
payment_method_risk_reviews
approval_policies
approval_requests
approval_steps
approval_decisions
approval_invalidations
separation_of_duties_rules
referral_payout_runs
referral_payout_items
referral_payout_item_allocations
referral_payout_attempts
payout_provider_requests
payout_provider_responses
payout_callbacks
payout_status_queries
payout_reconciliation_results
payout_reconciliation_exceptions
payout_returns
withholding_decisions
referral_statements
referral_statement_versions
statement_download_audits
```

## 24.6 Support, Fraud, Appeal, Audit, Notification, and Integration Tables

```text
referral_support_cases
referral_support_messages
referral_support_attachments
referral_fraud_flags
referral_fraud_cases
referral_fraud_case_links
referral_appeals
referral_appeal_decisions
referral_notifications
referral_email_deliveries
audit_logs
audit_cases
audit_case_notes
audit_case_links
audit_case_status_history
product_integration_events
product_webhook_deliveries
product_event_validation_results
product_event_payload_hashes
product_dead_letter_events
product_reconciliation_exceptions
```

Audit cases may be updated by Audit users, but underlying audit logs and business records remain immutable.

## 24.7 Product-Side Minimum Fields

Each source product stores:

```text
referral_attribution_id
referral_code_snapshot
referrer_reference
referral_campaign_id
referral_campaign_version
attributed_at
attribution_status
central_confirmation_status
merchant_product_tenant_id
```

No full payout method, Referrer tax record, earnings balance, fraud evidence, or central authorization data is stored in a product database.

## 24.8 Mandatory Constraints

- Unique normalized active Referrer-user login email according to identity policy.
- Unique or reviewed verified phone according to legal-entity and shared-contact policy.
- One organization must always have at least one verified `organization_owner`.
- Unique product and campaign code within its declared scope.
- One effective earning attribution per `merchant_product_tenant_id + product_id`, regardless of campaign.
- Campaign version immutable after activation.
- Campaign launch currency must be KES.
- Launch qualification and payout frequencies must be monthly.
- Launch recurring campaign active-use rule is mandatory.
- Launch retention milestone is at least four consecutive qualifying service periods.
- Unique product event ID per product and environment.
- Same event ID with a different payload hash is a critical integrity error.
- Unique final activity-decision version per merchant, product, rule version, and period.
- Unique reward calculation per attribution, period, and calculation version.
- Immutable reward-ledger entry ID.
- Verified payment-method records cannot be updated in place.
- Payout-item allocations must sum exactly to payout-item totals.
- Provider amount and currency must match before `reconciled_paid`.
- A payout preparer cannot approve the same production run.
- Material mutation invalidates approvals.
- No hard deletion of referenced financial, campaign, attribution, approval, audit, or reconciliation records.
- Product scope and campaign scope are enforced on every internal query.
- Referrer-entity ownership and user-membership authorization are enforced on every external query.

## 24.9 Retention, Pseudonymization, and Deletion

Legal deletion requests cannot remove records Citrus Labs must retain for finance, tax, fraud, contractual evidence, or audit. The platform applies access restriction, field-level redaction, pseudonymization, or retention expiry according to approved legal policy. Any destructive process must preserve referential and ledger integrity and must be audited.

---

# 25. API Surface

## 25.1 Referrer Entity, User, Membership, and Authentication APIs

```text
POST   /api/referrer-entities/register
POST   /api/referrer-users/verify-email
POST   /api/referrer-users/verify-phone
POST   /api/referrer-users/magic-link
POST   /api/referrer-users/step-up
GET    /api/referrer/entity
PATCH  /api/referrer/entity/profile-change-requests
GET    /api/referrer/users
POST   /api/referrer/users/invitations
POST   /api/referrer/users/invitations/{invitation}/accept
PATCH  /api/referrer/users/{user}/role
DELETE /api/referrer/users/{user}/membership
POST   /api/referrer/ownership-transfers
POST   /api/referrer/ownership-transfers/{transfer}/accept
```

Legal-profile and ownership changes use requests and verification. They do not overwrite verified identity history.

## 25.2 Campaign, Referral, Earnings, Payment, Statement, and Support APIs

```text
GET    /api/referrer/campaigns
POST   /api/referrer/campaigns/{campaign}/enrollments
GET    /api/referrer/campaign-enrollments
GET    /api/referrer/referral-assets
POST   /api/referrer/referral-assets
GET    /api/referrer/referrals
GET    /api/referrer/referrals/{referral}
GET    /api/referrer/earnings
GET    /api/referrer/payments
GET    /api/referrer/statements
GET    /api/referrer/statements/{statement}/download
POST   /api/referrer/payment-method-change-requests
POST   /api/referrer/payment-methods
POST   /api/referrer/payment-methods/{method}/verify
POST   /api/referrer/payment-methods/{method}/activate
POST   /api/referrer/support-cases
GET    /api/referrer/support-cases
POST   /api/referrer/support-cases/{case}/messages
POST   /api/referrer/appeals
```

There is no `PATCH` endpoint that edits a verified payout destination in place.

## 25.3 Product Integration APIs

```text
POST   /api/integrations/events
POST   /api/integrations/attributions/validate
POST   /api/integrations/attributions/confirm
GET    /api/integrations/attributions/{id}
POST   /api/integrations/merchant-verification
POST   /api/integrations/reconciliation
GET    /api/integrations/campaign-snapshots/{product}
POST   /api/integrations/dead-letter/{delivery}/replay-requests
```

Integration requests require the versioned signature headers defined in Section 10. The attribution-confirm endpoint is idempotent at the merchant-product boundary.

## 25.4 Campaign and Administration APIs

```text
GET    /api/admin/products
POST   /api/admin/products
GET    /api/admin/campaigns
POST   /api/admin/campaigns
POST   /api/admin/campaigns/{campaign}/versions
POST   /api/admin/campaign-versions/{version}/submit-for-approval
POST   /api/admin/campaign-versions/{version}/approve
POST   /api/admin/campaigns/{campaign}/activate
POST   /api/admin/campaigns/{campaign}/pause
GET    /api/admin/referrers
GET    /api/admin/merchant-product-tenants
GET    /api/admin/attributions
POST   /api/admin/attributions/{id}/resolution-requests
POST   /api/admin/attribution-resolutions/{resolution}/approve
GET    /api/admin/qualifications
POST   /api/admin/rewards/{id}/hold
POST   /api/admin/rewards/{id}/release-requests
POST   /api/admin/adjustments
POST   /api/admin/reversals
GET    /api/admin/audit-cases
POST   /api/admin/audit-cases
```

## 25.5 Finance and Payout APIs

```text
GET    /api/finance/payout-runs
POST   /api/finance/payout-runs
POST   /api/finance/payout-runs/{run}/submit-for-review
POST   /api/finance/payout-runs/{run}/review
POST   /api/finance/payout-runs/{run}/approve
POST   /api/finance/payout-runs/{run}/execute
POST   /api/finance/payout-runs/{run}/status-queries
POST   /api/finance/payout-runs/{run}/reconcile
POST   /api/finance/payout-items/{item}/return
POST   /api/finance/periods/{period}/reopen-requests
GET    /api/finance/reconciliation-exceptions
POST   /api/finance/reconciliation-exceptions/{exception}/resolve
```

Every write revalidates actor permissions, scopes, separation of duties, entity state, current approvals, and idempotency.

## 25.6 Risk, Legal, Tax, and Audit APIs

```text
POST   /api/risk/holds
POST   /api/risk/holds/{hold}/release
POST   /api/legal/holds
POST   /api/legal/holds/{hold}/release-requests
POST   /api/tax/profiles/{profile}/verification
POST   /api/tax/withholding-decisions
GET    /api/audit/logs
GET    /api/audit/cases
POST   /api/audit/cases
POST   /api/audit/cases/{case}/notes
POST   /api/audit/cases/{case}/resolve
```

Audit-case APIs mutate only audit-case metadata, never underlying audit logs or business records.

## 25.7 API Error Format

```json
{
  "error": {
    "code": "REFERRAL_CODE_PRODUCT_MISMATCH",
    "message": "This referral code is not valid for the selected product.",
    "correlation_id": "corr_01...",
    "details": {}
  }
}
```

Errors must be deterministic, safe for the caller's role, and free of sensitive identities, provider secrets, internal fraud evidence, stack traces, or authorization details that enable enumeration. A retryable error must state its retry classification through a machine-readable code or metadata.

---

# 26. Deterministic Error Handling Scenarios

The original specification already recognizes broad error families but often permits several possible outcomes without selecting one. The following rules make those outcomes deterministic while preserving user safety, financial integrity, product continuity, and auditability.

## 26.1 Registration and authentication errors

### Duplicate email

- Normalize email using the approved canonicalization policy without unsafe provider-specific transformations.
- Do not create another Referrer user automatically.
- Offer secure sign-in or account recovery.
- Do not disclose the associated Referrer entity or account state.
- Record rate-limited duplicate-registration evidence.

### Duplicate phone

- Do not automatically merge users or entities.
- Require sign-in, recovery, or identity-resolution review.
- Mask the existing number in any notice.
- Escalate when the number appears across excessive entities.

### Existing deactivated or closed identity

- Prevent uncontrolled duplicate creation.
- Route to reactivation, appeal, or new-entity review according to closure reason.
- Fraud-closed identities require Risk review.

### Expired Magic Link

- Reject the link.
- Allow a new request.
- Revoke previous active links for the same purpose where policy requires single use.

### Reused Magic Link

- Reject and record security event.
- Do not reveal whether first use succeeded.
- Consider revoking related sessions when reuse indicates compromise.

### Excessive requests

- Rate-limit by account, email, phone, IP, device, and risk signals.
- Use progressive delay and abuse monitoring.
- Do not permanently lock legitimate users solely because an attacker targeted their email.

### Verification provider outage

- Keep state pending.
- Queue retry.
- Allow low-risk onboarding progress that does not require verified identity.
- Block live referral assets, payout changes, or payouts where verification is mandatory.

### Suspended account

- Apply the restricted-access model from Issue 12.
- For compromised accounts, require recovery before restricted access.

### Edge cases

- Email belongs to organization invite but no user exists: complete invitation flow rather than ordinary registration.
- Phone was recycled by telecom provider: require evidence-based recovery and do not rely on phone alone.
- User loses email access: use controlled recovery with stronger identity evidence.
- Multiple failed recoveries: risk review, not automatic permanent forfeiture of rewards.

## 26.2 Payout-method errors

### Invalid M-Pesa number or bank data

- Validate format, country, provider rail, and checksum where available.
- Do not send invalid data to provider unnecessarily.
- Return field-level safe errors.

### Ownership mismatch

- Set new method to `verification_pending`, `needs_information`, or `rejected` according to provider evidence.
- Hold unsettled payouts after accepted change request.
- Permit supporting-document review through secure upload.

### Shared payout destination

- Create a risk link.
- Do not automatically reject legitimate organization, family, agency, or group structures.
- Apply threshold-based hold and evidence review.

### Provider outage

- Keep method verification pending or payout attempt unknown.
- Retry idempotently.
- Never mark verified or paid without evidence.

### Closed destination

- Mark payment attempt failed or returned based on provider result.
- Restore liability where appropriate.
- Require replacement method.

### Edge cases

- Provider says valid but account holder differs only by formatting: normalize and review; do not auto-reject.
- Mobile number changes network: use current provider verification rather than assumptions.
- Bank merger changes routing code: require provider or bank verification and versioned update.
- Destination is sanctioned or legally prohibited: legal hold and restricted disclosure.

## 26.3 Campaign configuration errors

### Invalid dates

- End date before start date: block save.
- Enrollment dates outside campaign dates: block activation.
- Effective date before approval: block activation.

### Reward configuration invalid

- Percentage outside approved range: block or require elevated commercial approval where policy permits.
- Fixed amount negative or zero when not allowed: block.
- Missing percentage basis: block.
- Reward duration shorter than four-month observation requirement: block.

### Missing activity rule

- Block launch recurring-subscription campaign activation.

### No eligible plan

- Block activation unless campaign type explicitly supports a non-plan conversion, which is outside launch scope.

### Budget exhausted

- Stop new attribution at an exact server-side timestamp.
- Preserve existing valid liabilities.
- Do not silently convert valid referrals to unpaid referrals.
- A waitlist requires published terms and explicit status.

### Paused campaign

- Block new enrollment and attribution according to configured pause policy.
- Existing locked attributions continue under snapshotted terms unless lawful published policy states otherwise.

### Edge cases

- Campaign activated concurrently by two admins: optimistic locking and idempotent activation.
- Budget replenished: create approved budget adjustment and prospective reopening.
- Campaign version scheduled across daylight-saving zone: use IANA time zone and UTC storage.
- Terms URL unavailable: block activation because material terms must be accessible.

## 26.4 Referral-code and link errors

### Invalid code

- Registration continues without attribution only after clear notice.
- Do not convert invalid code into a valid nearest match.

### Expired or closed campaign code

- Reject new attribution.
- Preserve existing locked attributions.

### Product mismatch

- Reject attribution for current product.
- Offer a safe correct-product route only when code metadata permits it without exposing Referrer data.

### Suspended Referrer

- Block new attribution.
- Registration continues.
- Existing attribution treatment follows suspension decision and published terms.

### Validation outage

- Store signed or entered evidence server-side.
- Mark pending central confirmation.
- Continue merchant registration.
- Prevent payout until resolved.

### Edge cases

- Code differs only by case: normalize because codes are case-insensitive.
- Ambiguous characters: code generation avoids them; manual entry may provide correction prompt without guessing attribution.
- QR code points to old campaign: display campaign closed message and permit normal merchant registration.
- Link parameters tampered: signature failure; validate code independently where safely possible.

## 26.5 Attribution errors

### Multiple Referrer claims

- Create conflict case.
- Block reward qualification.
- Preserve every claim and timestamp.
- Apply deterministic priority and review.

### Code after lock

- Reject ordinary changes.
- Permit correction only through evidence-based, approved process.

### Missing product event

- Keep pending.
- Request replay or verification.
- Do not fabricate merchant registration.

### Merchant ID mismatch

- Quarantine event.
- Alert product integration owner.
- Do not attach to nearest merchant.

### Unsupported manual correction

- Reject direct mutation.
- Require correction request, evidence, approval, new version, and audit.

### Edge cases

- Product event arrives before central link-click record: accept if signed and valid; correlate later.
- Two merchant tenants claim same external registration number: duplicate review.
- Merchant disputes code before tenant creation: allow replacement under Issue 2.
- Merchant disputes after rewards paid: investigate without automatic clawback.

## 26.6 Qualification and subscription errors

### Partial payment

- Keep `awaiting_full_subscription_payment`.
- Aggregate valid allocations only where source product confirms same invoice obligation.

### Uncleared payment

- Keep `awaiting_payment_clearance`.
- Do not pay on authorization or pending mobile transaction alone.

### Delayed activity decision

- Keep pending through grace period.
- After cutoff, move reward to next run when later validated.

### Conflicting activity decision

- Apply Issue 23.
- Hold and alert.

### Suspended merchant

- Distinguish operational, billing, fraud, and administrative suspension.
- Use campaign rule to determine hold versus not qualified.
- Never expose sensitive suspension reason to Referrer.

### Missing campaign version

- Block calculation.
- Repair configuration through controlled mapping; do not choose latest version automatically.

### Qualification already calculated

- Return idempotent result when inputs and version match.
- If source facts changed, create recalculation or adjustment workflow.

### Edge cases

- Annual payment: allocate by service month and assess activity monthly.
- Refund after qualification: create reversal evaluation.
- Late payment within allowed window: qualify original period and pay in later run.
- Plan changes mid-period: follow product-authoritative proration and campaign eligibility.

## 26.7 Reward-calculation errors

### Duplicate calculation

- Unique constraint by attribution, period, and calculation version.
- Same request returns existing calculation.

### Invalid rate or cap

- Block campaign activation where detectable.
- Block calculation and alert when historical configuration is corrupt.

### Missing eligible amount

- Request source verification.
- Keep qualification pending or held.

### Currency mismatch

- Apply KES-only launch rule.

### Rounding discrepancy

- Preserve full ledger precision.
- Create explicit rounding adjustment for provider amount.
- Use one documented rounding mode.

### Refund after calculation

- Preserve original calculation.
- Create reversal or adjustment linked to source refund.

### Edge cases

- Negative eligible amount: reject source fact and investigate.
- Cap reached across concurrent calculations: serialize or atomically reserve budget/cap usage.
- Campaign budget race: use transactional budget reservation.
- Calculation code version changes: existing calculation remains tied to formula version.

## 26.8 Payout-processing errors

### Missing payout method

- Carry forward payable reward.
- Notify Referrer.
- Do not expire solely due to missing method except lawful policy.

### Unverified or cooling-off method

- Hold payout.

### Provider timeout

- Unknown outcome; reconcile before retry.

### Duplicate payout request

- Same idempotency key returns prior result.
- Different key for same approved item is blocked by internal payout uniqueness.

### Missing callback

- Query provider.

### Failure

- Classify retryable versus final by approved provider code map.
- Never mark paid.

### Return

- Restore liability and allocation.
- Notify Referrer.

### Method changed after cutoff

- Apply Issue 20; hold and regenerate/reapprove where submission has not occurred.

### Edge cases

- Provider pays twice despite idempotency: critical incident, duplicate-payment recovery record, and no silent negative balance.
- Partial provider batch result: item-level states.
- Provider fee deducted from recipient unexpectedly: reconciliation exception and contractual review.
- Referrer dies or organization dissolves: legal final-payment process.

## 26.9 Support errors

### Malware attachment

- Reject or quarantine attachment.
- Keep safe case text.
- Notify user without revealing security tooling.

### Unverified reply sender

- Do not append to case.
- Ask sender to use verified channel.

### Request for another Referrer's data

- Deny and audit.
- Do not confirm whether records exist.

### Support attempts prohibited action

- Server authorization denies.
- Offer escalation workflow rather than workaround.

### Edge cases

- Email thread forwarded by Referrer: verify sender and strip unsafe embedded content.
- Duplicate cases: link them without deleting messages.
- Case includes merchant secrets: redact and restrict.
- Legal request arrives through support: route to Privacy/Legal.

## 26.10 Integration errors

### Invalid signature

- Reject and alert.

### Unknown product or wrong environment

- Reject.

### Unsupported event version

- Return version error and supported range.
- Do not partially parse unknown schema.

### Duplicate event

- Same ID and hash: idempotent success.
- Same ID different hash: critical alert.

### Out-of-order event

- Persist event.
- Apply explicit state transition rules.
- Hold dependent processing until prerequisites arrive or verification resolves gap.

### Timestamp outside tolerance

- Delivery timestamp controls replay validation; business `occurred_at` may legitimately be older for replay.
- Separate these concepts.

### Dead-letter threshold

- Alert product and platform owners.
- Provide controlled replay after root cause correction.
- Prevent duplicate financial outcomes.

### Edge cases

- Event schema valid but semantically impossible: quarantine and request source verification.
- Product sends future billing period: store only when allowed and do not qualify before period closes.
- Source clock drift: signature timestamp may fail while occurred-at is valid; fix integration clock, do not widen tolerance excessively.
- Bulk replay: rate-limit and process idempotently.

## 26.11 Error-handling proof requirements

For every error code, automated tests must prove the triggering condition, state transition, retry classification, user-safe message, internal audit record, notification behavior, and absence of duplicate financial or attribution effects. Support procedures must identify the team authorized to resolve the error and actions that remain prohibited.

---

# 27. Edge-Case Handling

## 27.1 Unlimited Referrals

A Referrer may refer an unlimited number of merchants.

Practical controls still apply:

- Rate limits.
- anti-spam.
- campaign budgets.
- fraud thresholds.
- batch performance.
- pagination.
- product eligibility.
- legal restrictions.

The platform shall not impose an undocumented referral count limit.

## 27.2 One Referrer, Several Products

The dashboard consolidates all products while maintaining product isolation.

## 27.3 Two Referrers With Same Name

Identity uses immutable IDs, not names.

## 27.4 Merchant Changes Legal Name

Attribution remains attached to the merchant tenant. The display name updates through product event.

## 27.5 Merchant Changes Merchant Administrator

Attribution remains attached to the merchant tenant, not the original administrator, unless fraud review invalidates it.

## 27.6 Merchant Adds Branches

No new attribution is created for branches within the same tenant.

## 27.7 Merchant Cancels and Reactivates

Campaign policy defines whether the reward duration resumes, continues, or expires. Previous earned rewards remain.

## 27.8 Merchant Misses Month 2 but Pays Month 3

No Month 2 reward. Month 3 may qualify. Consecutive-retention count resets under the default rule.

## 27.9 Merchant Pays Four Months in Advance

Reward is allocated by service month and paid monthly by default.

## 27.10 Merchant Receives 100% Discount

No percentage reward where eligible cash basis is zero, unless the campaign defines a fixed conversion reward.

## 27.11 Referrer Dies or Organization Closes

The account enters legal review. Lawful representative or estate handling follows policy. Records remain preserved.

## 27.12 Referrer Deactivates Account

New referrals stop. Earned unpaid rewards follow the terms and legal obligations. Records remain.

## 27.13 Referrer Is Suspended for Fraud

New referrals stop. Pending rewards are held. Proven invalid rewards may be reversed. Unrelated legitimate rewards are handled according to the decision.

## 27.14 Campaign Ends During Reward Duration

Existing valid attributions continue for their snapshotted duration unless campaign terms explicitly and lawfully state otherwise.

## 27.15 Product Is Discontinued

Citrus Labs defines a wind-down policy for existing liabilities. The platform preserves statements and audit history.

## 27.16 Currency Changes

Existing calculations retain original currency and exchange-rate snapshot. Conversion is explicit.

## 27.17 Referrer Has Earnings in Two Currencies

The platform creates separate payout items or converts under configured rules. It does not silently combine currencies.

## 27.18 Merchant Refunds Only Add-On Charges

The reward changes only when the add-on was part of the eligible basis.

## 27.19 Merchant Partially Refunds Subscription

A proportional adjustment may apply.

## 27.20 Merchant Activity Is Later Found Fraudulent

The reward is held or reversed through a traceable decision.

## 27.21 Product Sends Event After Payout

The platform creates an exception and evaluates adjustment or reversal. It never edits the paid record silently.

## 27.22 Central Platform Outage During Payout

Payout execution uses idempotency and reconciliation. No blind retry occurs where payment status is unknown.

## 27.23 Payment Provider Sends Duplicate Callback

The callback is idempotent.

## 27.24 Referrer Changes Email

Verification, risk checks, session invalidation, and notification to the old email apply.

## 27.25 Referrer Loses Phone

Recovery uses verified alternate controls and manual review. Support cannot bypass identity checks.

## 27.26 Same Payout Phone Used by an Organization’s Staff

Risk review determines legitimacy. The platform does not automatically merge accounts.

## 27.27 Merchant Claims They Did Not Consent to Referral

Attribution enters review. Referral marketing evidence and registration code evidence are preserved.

## 27.28 Referrer Disputes Active-Use Result

Support routes to product verification. The central platform does not fabricate operational evidence.

## 27.29 Merchant Pays Late After Campaign Duration

Qualification depends on the late-payment and campaign-expiry rules.

## 27.30 Leap Year and Month Length

Qualification periods use explicit start and end timestamps, not a fixed 30-day assumption.

## 27.31 Time Zone

Each campaign defines its accounting time zone. Timestamps are stored in UTC and displayed appropriately.

## 27.32 Daylight Saving

Period boundaries use the configured campaign time zone and robust date-time libraries.

## 27.33 Referrer Requests Data Deletion

Financial, fraud, tax, and audit records are retained where legally required. Non-required profile data may be deleted or anonymized according to policy.

---

# 28. Security and Privacy

## 28.1 Referrer Authentication Security

Referrer users use Magic Link or another approved passwordless method with:

- Single-use, short-expiry, hashed tokens.
- Session rotation and revocation.
- Device and network review.
- Rate limits and enumeration-resistant responses.
- Step-up verification for payout methods, legal identity, ownership transfer, exports, and closure.
- Optional or mandatory MFA according to risk and role.

A Referrer legal entity is not a credential. Authorization is derived from the authenticated user, active membership, entity role, state dimensions, and requested resource.

## 28.2 Internal Authentication Security

All internal human users authenticate through enterprise SSO or equivalent strong identity with mandatory MFA. Privileged roles use phishing-resistant MFA where supported, managed-device or conditional-access controls, short privileged-session timeouts, absolute session limits, and reauthentication before high-risk actions.

Identity-provider outage must not cause fallback to weak local passwords. Privileged writes are denied when assurance cannot be established. Role changes, employment termination, or suspicious sessions invalidate authorization caches and active sessions immediately.

Break-glass access is separately assigned, time-limited, incident-linked, reason-coded, approved where practicable, continuously monitored, and reviewed after use.

## 28.3 RBAC, Scopes, and Default-Deny Authorization

Authorization uses:

- Explicit roles and permissions.
- Referrer-entity membership.
- Product scope.
- Campaign scope.
- Field masking.
- Action-specific permissions.
- Resource ownership.
- Maker/checker and actor separation.
- Legal, tax, risk, account, and payout-readiness states.
- Service-account scopes and environment binding.

No Super Administrator, support user, engineer, or service account is an unrestricted bypass principal. Frontend hiding never substitutes for server enforcement.

## 28.4 Separation of Duties

The platform must prevent one actor from preparing and approving the same high-risk payout, campaign version, adjustment, reversal, locked-period reopening, payout-destination exception, or financially material attribution reassignment.

Material changes invalidate prior approvals. Authorization is rechecked at execution, not only when a workflow begins.

## 28.5 Data Protection

Controls include:

- Encryption in transit and at rest.
- Field-level encryption for payout and identity data.
- Provider tokenization where available.
- Secrets vault and key rotation.
- Secure backups and restoration tests.
- Data classification and least privilege.
- Masked logs and analytics.
- Secure, expiring exports.
- Malware scanning.
- Approved retention and pseudonymization.
- No plaintext secrets or payment details in email.
- No payout data in source-product databases.

## 28.6 Audit Events

Audit events include registration, verification, login, membership change, ownership transfer, role or scope change, profile change, payout-method request, verification, activation, code generation, attribution evidence, conflict, resolution, qualification, activity decision, calculation, hold, release, adjustment, reversal, payout approval, execution, provider callback, reconciliation, return, statement generation, support action, fraud decision, appeal, campaign approval, integration key rotation, break-glass access, and unauthorized access.

## 28.7 Audit Record Fields and Integrity

Every record includes event ID, timestamp, actor, actor type, role, permission, scope, action, entity type and ID, product, campaign, Referrer entity, merchant-product tenant, severity, old and new value hashes, reason, approval reference, correlation ID, IP, device, authentication assurance, payload hash, record hash, and previous hash where chaining is used.

Audit logs are append-only. Audit users may update only audit-case metadata. Business, financial, and source evidence records cannot be altered through audit tools.

## 28.8 Privacy, Legal Holds, and Data Rights

Privacy and Legal users manage lawful access, correction, restriction, erasure, disclosure, retention, and legal holds. Erasure does not delete financial, tax, fraud, contractual, or audit records that must be retained. The system applies lawful restriction or pseudonymization while preserving ledger and referential integrity.

## 28.9 Security Error Handling and Edge Cases

- Unknown or disabled internal user: deny without revealing organizational membership.
- MFA failure: deny, audit, and rate-limit.
- Role revoked during session: invalidate token or authorization cache immediately.
- Cross-product access attempt: deny and audit.
- Service account sends another product's event: reject authorization.
- Support requests unmasking: require explicit permission, purpose, and audit; most cases remain masked.
- Compromised payout-change session: revoke, hold payouts, and route to Risk.
- Break-glass attempt without incident reference: deny.
- Export URL forwarded to another user: recheck authorization and deny.
- Data deletion request conflicts with legal retention: restrict and explain the lawful retention basis through the approved process.

## 28.10 Required Security Tests

```text
ReferrerEntityMembershipIsolationTest
InternalDefaultDenyPermissionTest
ProductScopeEnforcementTest
CampaignScopeEnforcementTest
RoleRevocationInvalidatesSessionTest
MandatoryMfaPrivilegedActionTest
BreakGlassExpiryAndAuditTest
SensitiveFieldMaskingTest
StatementDownloadReauthorizationTest
AuditImmutabilityTest
ServiceAccountEnvironmentIsolationTest
```

---

# 29. Reporting and Analytics

## 29.1 Referrer Reports

- Referrals by product.
- registrations.
- confirmed attributions.
- qualification rate.
- Month 1 conversion.
- four-month retention.
- earnings.
- payout history.
- campaign performance.

## 29.2 Product Reports

- Referred merchants.
- active referrals.
- retained referrals.
- referral revenue.
- reward expense.
- cost per registration.
- cost per paid conversion.
- cost per retained merchant.
- churn.
- refund-linked rewards.
- fraud rate.

## 29.3 Cross-Product Reports

- Unique Referrers.
- Referrers active in several products.
- total reward liability.
- total payout.
- product comparison.
- campaign ROI.
- payout failure rate.
- fraud trends.
- merchant cross-product conversion.

## 29.4 Funnel

```text
Link click
→ Registration started
→ Merchant registered
→ Setup completed
→ Subscription selected
→ Subscription paid
→ Month 1 active
→ Month 1 reward
→ Month 4 retained
→ Reward duration completed
```

---

# 30. Performance, Reliability, and Scalability

## 30.1 Requirements

- Paginated lists.
- indexed attribution queries.
- indexed ledger queries.
- asynchronous emails.
- asynchronous payout processing.
- idempotent event processing.
- queue-based retry.
- horizontal worker scaling.
- read replicas where required.
- observability.
- structured logs.
- metrics.
- tracing.
- health checks.
- backups.
- disaster recovery.

## 30.2 Service-Level Expectations

Indicative targets:

- Dashboard availability: 99.9%.
- Event acceptance: 99.95%.
- No duplicate reward from duplicate event.
- No duplicate payout from retry.
- Financial reconciliation completeness: 100%.
- Audit coverage for high-risk actions: 100%.

---

# 31. Testing Requirements

## 31.1 Unit Tests

- Fixed reward.
- percentage reward.
- discount basis.
- rounding.
- caps.
- retention count.
- late payment.
- advance payment.
- refund.
- chargeback.
- payout threshold.
- currency handling.

## 31.2 Integration Tests

- Product event signature.
- idempotency.
- out-of-order event.
- retry.
- dead-letter.
- reconciliation.
- payout provider.
- email provider.
- payment-method verification.

## 31.3 Authorization Tests

- Referrer A cannot access Referrer B.
- Product service cannot send another product’s event.
- Support cannot edit reward.
- Operations cannot execute payout.
- Finance cannot edit product facts.
- Audit cannot mutate business records.
- Super Administrator cannot bypass maker/checker where required.

## 31.4 Required Named Test Suites

```text
ReferrerOwnScopeTest
ProductCampaignIsolationTest
ReferralAttributionLockTest
DuplicateAttributionTest
SelfReferralDetectionTest
FourMonthRetentionTest
MonthOneMonthlyPayoutTest
AdvanceSubscriptionAllocationTest
RewardCalculationIdempotencyTest
ProductEventSignatureTest
ProductEventReplayProtectionTest
PayoutIdempotencyTest
PayoutMethodChangeHoldTest
RefundRewardReversalTest
OrdinaryChurnNoClawbackTest
ConsolidatedPayoutAllocationTest
CentralOutageDeferredAttributionTest
ProductOutageQualificationHoldTest
AuditImmutabilityTest
SensitiveFieldMaskingTest
```

## 31.5 Acceptance Scenarios

### Scenario A: Successful Courier Referral

1. Referrer creates account.
2. Referrer enrolls in Courier campaign.
3. Referrer shares Courier link.
4. Merchant registers.
5. attribution confirms.
6. merchant pays subscription.
7. merchant completes required deliveries.
8. Month 1 closes.
9. reward is calculated.
10. reward enters payout.
11. payout succeeds.
12. Referrer sees statement.

### Scenario B: Merchant Does Not Pay

No reward is earned.

### Scenario C: Merchant Pays but Is Inactive

No reward for that period.

### Scenario D: Merchant Qualifies for Four Months

Retention milestone is recorded and communicated.

### Scenario E: Merchant Churns in Month 5

Months 1–4 remain valid. Month 5 does not qualify.

### Scenario F: Subscription Refund After Payout

A reversal record is created. Recovery follows policy.

### Scenario G: Duplicate Product Event

No duplicate reward.

### Scenario H: Referrer Tries to View Another Referrer

Access denied and audited.

### Scenario I: Consolidated Payout

Courier, Servana, and Safiri rewards are paid in one transaction with separate ledger allocation.

### Scenario J: Central Platform Unavailable During Registration

Merchant registration succeeds; attribution confirms later.

---

## 31.6 Corrective Cross-Cutting Acceptance Tests

The corrected release must include the original named tests plus the tests added in each issue. At minimum, acceptance must prove:

1. A merchant-product tenant cannot create two earning Referrers across campaigns.
2. A merchant can replace a link-derived code before registration submission, and cannot change it after tenant creation without approved correction.
3. Non-monthly payout frequency and non-KES currency are rejected at launch.
4. Every active subscription campaign has an approved activity-rule version and at least a four-month consecutive retention milestone.
5. Missed months do not erase earned rewards and do not falsely advance consecutive retention.
6. Payouts cannot be finalized without reconciliation.
7. A payout preparer cannot approve the same run.
8. Run mutation invalidates approval.
9. Consolidated payout allocations exactly reconcile to provider amount and product accounting.
10. Final statements are generated from reconciled data and corrections preserve prior versions.
11. Account, onboarding, identity, payout, and risk states operate independently.
12. Suspended users retain secure appeal and statement access unless a lawful restriction applies.
13. Organization ownership and membership controls prevent orphaned entities and stale access.
14. Verified payout destinations cannot be edited in place.
15. Internal permissions are default-deny, product-scoped, and immediately revocable.
16. Merchant references remain minimized and product-authoritative.
17. Campaign enrollment is separately persisted and audited.
18. Audit cases never mutate audit logs.
19. Payout-method changes hold unsettled payouts deterministically.
20. Internal high-risk actions require MFA and appropriate device/session assurance.
21. Product events are signed over exact raw bytes and replay-protected.
22. Final product activity decision is authoritative and versioned.
23. Tax-required campaigns cannot pay without the approved tax launch mode.
24. Provider timeouts, missing callbacks, duplicate events, returns, refunds, late events, and out-of-order events produce deterministic non-duplicative outcomes.

## 31.7 Manifesto Verification Tests

The release process must produce evidence for each correction:

- **Problem proof:** a failing pre-correction test, contradictory requirement pair, schema impossibility, race-condition reproduction, or control-gap analysis.
- **Root cause proof:** a design note identifying the violated invariant and the exact module or data boundary responsible.
- **Fix proof:** source-control change, migration, configuration version, API contract, workflow rule, and user-interface change tied to the correction.
- **Test proof:** automated test results, integration-provider evidence, authorization tests, and finance reconciliation evidence.
- **Resolution proof:** production-readiness checklist showing the corrected invariant holds across APIs, database constraints, queues, dashboards, statements, reports, support views, and audit logs.

A correction is not accepted when only the frontend has changed or when the automated tests do not exercise the server-side invariant.

---

# 32. Deployment Model

## 32.1 Recommended Domain

```text
refer.citrus.co.ke
```

## 32.2 Initial Architecture

A modular monolith is acceptable for launch when it preserves bounded modules:

- Identity.
- campaigns.
- attribution.
- qualification.
- rewards.
- payouts.
- notifications.
- support.
- fraud.
- audit.
- integrations.
- reporting.

## 32.3 Extraction Path

```text
Phase 1:
Shared modular platform

Phase 2:
Dedicated referral API and dashboard

Phase 3:
Event-driven independently scalable services
```

## 32.4 Do Not Prematurely Split

Microservices are not required merely because several products integrate.

Service boundaries must be clear even when deployed together.

---

# 33. Implementation Phases

The original phase plan puts payout runs in Phase 1 while deferring reconciliation, maker/checker, statements, tax support, and consolidated payouts, even though the acceptance scenarios and tests require them. The phase plan must be replaced.

## 33.1 Phase 1 — Production-safe centralized launch

Phase 1 must include:

- Referrer legal entities and Referrer users.
- Organization memberships and ownership.
- Referrer passwordless authentication and step-up verification.
- Internal SSO, MFA, RBAC, scopes, and access audit.
- Product registry and service accounts.
- Campaign drafts, approval, versioning, and enrollment.
- KES-only configuration.
- Monthly qualification and monthly payout cycles.
- Referral links, codes, QR codes, and corrected pre-lock precedence.
- One earning attribution per merchant-product tenant.
- Merchant-product reference aggregate.
- Signed event ingestion, idempotency, replay protection, retries, and dead-letter handling.
- Mandatory product-specific active-use decisions.
- Four-consecutive-month retention tracking.
- Fixed-calendar reward duration default.
- Fixed and percentage rewards.
- Immutable reward ledger.
- Append-only payment-method replacement.
- Deterministic payout-method change holds.
- Consolidated KES payouts.
- Maker/checker.
- Provider submission and minimum viable reconciliation.
- Basic monthly and payout statements.
- Minimum legally required tax mode or disabling of tax-dependent campaigns.
- Basic fraud rules and manual review.
- Support cases.
- Appeals required for suspension and material financial decisions.
- Audit logs and audit cases.
- Dashboard, email, monitoring, backups, and disaster recovery.

Phase 1 is not production-ready until payout finality, reconciliation, approval separation, statements, and tax launch mode are validated.

## 33.2 Phase 2 — Operational depth

Phase 2 may add:

- Advanced automated fraud scoring.
- Advanced bank-statement and provider settlement matching.
- Expanded tax certificates and annual summaries.
- Advanced appeals workflow.
- Advanced finance exports and accounting integrations.
- Advanced reporting and campaign ROI.
- Additional payout providers.
- Automated merchant identity resolution.
- More granular audit analytics.

## 33.3 Phase 3 — Scale and controlled expansion

Phase 3 may add:

- Event bus and independently scalable services.
- Product SDKs.
- Partner APIs.
- Approved non-monthly campaign or payout models.
- Multi-currency after all prerequisites.
- Advanced attribution experiments.
- Predictive risk.
- Additional campaign types.

No later phase may be used as justification to omit a control required for safe operation of a feature already launched.

---

# 34. Explicit Non-Goals and Exclusions

The launch platform is not:

- A merchant operating system.
- A merchant subscription billing engine.
- A merchant customer-payment processor.
- A replacement for source product finance.
- A public affiliate marketplace without approval controls.
- A guarantee of Referrer income.
- A mechanism for Referrers to operate merchant accounts.
- A system for copying product customer data.
- A system that pays on registration alone.
- A system that pays on partial subscription payment.
- A system that silently changes campaign terms.
- A system that pays two Referrers for one merchant-product attribution.
- A system that stores payout details independently in every Citrus product.

---

# 35. Final Governing Rules

1. Citrus Labs Limited owns and operates one central Citrus Refer & Earn platform.
2. Every eligible Citrus product integrates independently while preserving product scope.
3. Each product retains native marketing and merchant-registration entry points.
4. Each product remains authoritative for merchant identity, subscription, payment, billing, operating status, and product-specific activity facts.
5. The central platform remains authoritative for Referrer legal entities, Referrer users, membership, campaign enrollment, attribution, qualification records, rewards, ledgers, payout methods, payouts, statements, appeals, and audit evidence.
6. A Referrer legal entity may be operated by one or more authorized Referrer users. An organization always has at least one verified owner.
7. Merchant Administrators remain external source-product actors, not central Referrer dashboard accounts.
8. Launch campaign, ledger, and payout currency is KES only.
9. Launch reward qualification and payout execution are monthly only.
10. Payment details are captured, verified, encrypted, tokenized where available, and secured centrally.
11. Verified payout destinations are append-only and replaced through controlled requests; they are never edited in place.
12. A payout-method change holds all unsettled payouts until the new method is verified, activated, and outside cooling-off or an approved exception authorizes otherwise.
13. Referrers may refer unlimited merchants subject to campaign, capacity, fraud, spam, consent, and legal controls.
14. Every merchant-product tenant has only one effective earning attribution at a time, regardless of campaign.
15. Product-specific attribution is the launch default; the same legal business may have separate attributions in different products.
16. Manual code explicitly confirmed before registration submission takes priority over a signed link, and attribution locks at successful tenant creation.
17. Every campaign and activity rule has an immutable version.
18. Every launch recurring subscription campaign requires an approved product-specific active-use rule.
19. Rewards use fixed amount or percentage models under an explicit eligible basis.
20. Launch reward duration defaults to a fixed calendar service-period window and must not be shorter than the retention milestone.
21. Every launch recurring subscription campaign requires at least four consecutive qualifying service months for retention.
22. Rewarded-month count and consecutive-retention count are separate measurements.
23. Month 1 is payable only after the service period closes and subscription, activity, attribution, risk, clearing, tax, and payout-readiness rules pass.
24. Ordinary later churn does not reverse legitimate prior earnings.
25. Fraud, refunds, chargebacks, duplicates, fabricated activity, payout fraud, or calculation errors may create traceable holds, adjustments, and reversals.
26. One consolidated KES payout may settle earnings from several products while preserving product, campaign, merchant, period, cost-centre, gross, withholding, and net allocations.
27. Every production payout requires maker/checker approval and separation of duties.
28. Provider acceptance is not final payment. Only a verified and reconciled provider outcome produces final `paid` status.
29. Basic monthly earnings and payout statements are Phase 1 requirements and are generated from reconciled data.
30. Tax readiness is a launch gate: implement the approved minimum tax mode or disable campaigns whose tax obligations cannot be processed.
31. One Referrer cannot access another Referrer entity's data, and Referrer users are limited by membership role.
32. Referrers cannot view private merchant operational or financial data.
33. Internal access uses enterprise SSO or equivalent, mandatory MFA, explicit RBAC, scopes, default-deny authorization, and auditable high-risk reauthentication.
34. Service accounts are non-human, product-bound, environment-bound, event-scoped, and key-rotated.
35. Product events are signed over exact raw request bytes with explicit headers, key ID, algorithm, timestamp, environment, and replay protection.
36. The final product activity decision is versioned and authoritative; operational evidence does not automatically qualify a merchant.
37. Every high-risk action is server-enforced, reason-coded, approved where required, and audited.
38. Original financial, attribution, campaign-version, approval, payout-destination, reconciliation, statement, and audit records are never silently overwritten or deleted.
39. Merchant registration continues during temporary central-platform unavailability, but no reward is paid before central confirmation and qualification.
40. Suspended Referrer users retain restricted access to statements, support, and appeals unless a lawful restriction applies.
41. Customer support is available through email and dashboard but cannot perform prohibited financial, attribution, fraud, or payout-method actions.
42. Every correction and production feature must be proven, root-caused, precisely fixed, tested, and demonstrated through observable evidence.
43. Every product, API, queue, database constraint, dashboard, statement, support view, report, and test must use these same definitions.
44. The platform must be secure, financially reconcilable, auditable, recoverable, and implementable without undocumented exceptions.

---

# 36. Final Platform Structure

```text
Citrus Labs Limited
└── Citrus Refer & Earn Platform
    ├── Referrer Legal Entities
    │   ├── Individual and Organization Profiles
    │   ├── Referrer Users
    │   ├── Memberships, Roles, and Ownership
    │   └── Independent Account, Verification, Payout, and Risk States
    ├── Internal Identity and Access
    │   ├── Enterprise SSO and MFA
    │   ├── RBAC, Product Scopes, and Campaign Scopes
    │   ├── Separation of Duties
    │   └── Break-Glass Governance
    ├── Central Contact and Identity Verification
    ├── Append-Only Payment Profiles and Change Requests
    ├── KES-Only Launch Currency Controls
    ├── Product Registry and Product-Bound Service Accounts
    ├── Product-Specific Campaigns and Immutable Versions
    ├── Campaign Enrollment and Approval
    ├── Referral Codes, Links, QR Codes, and Pre-Lock Merchant Choice
    ├── One Effective Attribution per Merchant-Product Tenant
    ├── Minimized Merchant Legal-Entity and Product-Tenant References
    ├── Raw-Body-Signed Product Event Integration
    ├── Versioned Product Activity Decisions
    ├── Monthly Qualification Engine
    ├── Fixed-Calendar Reward Duration Engine
    ├── Four-Consecutive-Month Retention Engine
    ├── Reward Calculation and Immutable Earnings Ledger
    ├── Consolidated KES Payout Engine
    ├── Maker/Checker Approval Workflow
    ├── Provider Submission, Status Verification, and Reconciliation
    ├── Product and Campaign Cost Allocation
    ├── Tax and Withholding Launch Controls
    ├── Versioned Monthly and Payout Statements
    ├── Fraud, Risk, Holds, Adjustments, Reversals, and Appeals
    ├── Customer Support and Escalation
    ├── Privacy, Legal Holds, and Data Rights
    ├── Email and In-Platform Notifications
    ├── Reporting and Analytics
    ├── Append-Only Audit Logs and Audit Cases
    ├── Integration Health, Dead Letters, and Controlled Replay
    ├── Courier by Citrus Campaigns
    ├── Servana by Citrus Campaigns
    ├── Safiri by Citrus Campaigns
    ├── Rideon by Citrus Campaigns
    ├── Scribble by Citrus Campaigns
    └── Future Citrus Product Campaigns
```

This centralized hybrid architecture is the governing production model. It does not create separate referral platforms inside each Citrus product. It centralizes shared referral and financial controls while preserving product-specific campaign, billing, and activity authority.

---

---

# 37. Corrective Change Assurance and User-Impact Register

This section preserves the proof, root-cause analysis, precise correction, error handling, edge cases, tests, affected-user analysis, and resolution evidence for every material contradiction corrected in this rewritten specification. It is part of the governing requirements, not historical commentary.

## 37.1 Issue 1 — Attribution uniqueness can permit two earning Referrers

**Severity:** Critical  
**Confidence:** 98%

### Affected users and services

- Referrer legal entities and users.
- Merchant Administrators.
- Referral Operations.
- Finance roles.
- Risk and Fraud.
- Product Integration Service Accounts.
- Customer Support.
- Audit.

### How the error appears

The original uniqueness rule permits one confirmed Referrer per merchant tenant, product, and campaign. Because campaign is part of the uniqueness boundary, the same merchant tenant in the same product could obtain a confirmed attribution to Referrer A under Campaign A and another confirmed attribution to Referrer B under Campaign B. That conflicts with the separate rule that one product tenant must not pay multiple Referrers. The original attribution sections also state that multiple-link conflicts must resolve to one Referrer for the product tenant.

### Governing correction

The default earning-attribution boundary is:

```text
one merchant_product_tenant
+ one Citrus product
+ one effective earning attribution
```

The campaign and campaign version are immutable attributes of the winning attribution. They are not part of the uniqueness boundary that permits a second earning Referrer.

The same legal business may still have a separate attribution in another Citrus product because each product tenant is an independent acquisition relationship.

### Required data model

`referral_attributions` must include:

```text
id
merchant_product_tenant_id
product_id
referrer_entity_id
campaign_id
campaign_version_id
status
effective_from
effective_to
is_earning_attribution
supersedes_attribution_id
resolution_case_id
locked_at
created_at
```

Create a database-level partial unique constraint equivalent to:

```text
UNIQUE (merchant_product_tenant_id, product_id)
WHERE is_earning_attribution = true
AND status IN ('pending_verification', 'confirmed', 'locked', 'held', 'conflicted')
```

The exact states included must prevent two simultaneous candidates from bypassing conflict resolution. A separate conflict container may hold multiple claims, but only one claim may become the effective earning attribution.

Historical attributions remain stored with `is_earning_attribution = false` or an ended `effective_to`. They are never deleted.

### Attribution migration and campaign changes

A merchant may move to a new campaign version only through a controlled prospective migration. The migration normally preserves the existing Referrer. A campaign change must not create a new Referrer entitlement.

A Referrer reassignment requires:

- A documented system error, invalid original attribution, fraud finding, or approved pre-lock correction.
- Preserved evidence for all competing claims.
- Maker/checker approval for any reassignment that changes existing or expected reward liability.
- A new attribution record referencing the superseded record.
- A decision notice and appeal route where applicable.
- Recalculation through adjustments or reversals, never silent replacement.

### API rules

`POST /api/integrations/attributions/confirm` must be idempotent for the merchant-product boundary.

When another candidate exists, return a conflict response such as:

```json
{
  "error": {
    "code": "ATTRIBUTION_CONFLICT_REVIEW_REQUIRED",
    "message": "A referral claim already exists for this merchant and product and must be reviewed.",
    "correlation_id": "corr_..."
  }
}
```

The response must not disclose the competing Referrer's identity to the source product or merchant.

### Error handling and edge cases

- Same merchant clicks several links before registration: retain evidence for every valid click, apply the campaign's declared priority rule, and create one winning attribution.
- Same merchant manually enters a different valid code before account creation: use the corrected priority rule in Issue 2.
- Same merchant creates duplicate tenants in one product: hold every related attribution, identify the canonical tenant, invalidate duplicates, and allow only the canonical tenant to qualify.
- Same legal business registers in two Citrus products: allow one attribution per product.
- Campaign closes after attribution: existing locked attribution continues under snapshotted terms unless the published campaign expressly states a lawful prospective closure rule.
- Campaign migration preserves Referrer: create a new attribution version or campaign-assignment record without opening a new Referrer competition.
- Original attribution is proven fraudulent after payouts: create a reversal and, where another claimant is valid, create a new prospective attribution; do not silently transfer historical rewards without approved correction logic.
- Database race condition: rely on the unique constraint in addition to application locking; the losing transaction enters conflict review.
- Central outage: the product may hold a signed local snapshot, but central confirmation must still enforce the merchant-product uniqueness boundary when events are replayed.

### Required tests

Add or update:

```text
MerchantProductSingleEarningAttributionTest
ConcurrentAttributionRaceTest
CrossCampaignDuplicateAttributionTest
CrossProductIndependentAttributionTest
AttributionMigrationPreservesReferrerTest
FraudulentAttributionReassignmentAuditTest
```

### Demonstration of resolution

Resolution is demonstrated when concurrent and cross-campaign claims cannot produce two effective earning attributions, exactly one claim can become payable, and every losing or superseded claim remains traceable.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.2 Issue 2 — Manual-code priority conflicts with a locked referral field

**Severity:** High  
**Confidence:** 99%

### Affected users and services

- Merchant Administrators.
- Referrer users.
- Product Integration Service Accounts.
- Referral Operations.
- Customer Support.
- Audit.

### How the error appears

The attribution priority gives a manually entered code the highest priority before account creation. The registration specification separately says a referral code supplied through a signed link may be prefilled and locked. A merchant cannot exercise the higher-priority manual-code option when the field is locked.

### Governing correction

For launch, the priority order remains:

```text
1. Valid manual code explicitly confirmed by the Merchant Administrator before registration submission
2. Valid signed product referral link
3. Valid first-party campaign cookie
4. No attribution
```

A link-derived code may be prefilled but must not be permanently locked before the merchant submits registration. The interface must clearly state that changing the code will replace the current referral source.

The field becomes immutable when the configured attribution lock event occurs. The launch lock event is successful merchant-tenant creation. Earlier UI steps do not create an irreversible lock.

### Required user experience

When a signed link supplies a code, show:

```text
Referral code applied: COURIER-••T2K
```

Provide a controlled “Use a different referral code” action before registration submission.

Changing the code requires:

- Explicit merchant confirmation.
- Server-side validation of the new code.
- Recording the previous link claim as attribution evidence.
- Recording the chosen manual code as the winning pre-registration source.
- An audit event containing both masked source references.

The platform must not expose either Referrer's personal information.

### Server-side precedence

The source product submits all available evidence:

```text
signed_link_claim
manual_code_claim
cookie_claim
merchant_confirmation_timestamp
registration_submission_timestamp
```

The central platform applies the precedence rule. Frontend state alone is not authoritative.

### Error handling and edge cases

- Manual code is invalid: retain the valid link-derived code and tell the merchant that the replacement code was not accepted.
- Manual code belongs to another product: reject replacement and keep the valid current product claim.
- Manual code belongs to a closed campaign: reject replacement; registration continues with the valid existing claim or without attribution.
- Merchant clears the code intentionally: require confirmation that registration will proceed without a referral unless another valid source applies.
- Referral validation service is unavailable: store both the original signed link snapshot and merchant-entered code; mark attribution pending and resolve centrally after recovery. Do not silently discard the manual choice.
- Merchant changes code after tenant creation: reject as locked and provide a dispute route.
- Browser refresh or multi-tab registration: the server stores the last explicitly confirmed valid choice before submission. Simultaneous submissions use the first successful tenant-creation transaction.
- Signed link is tampered with: reject the signature and treat the code as untrusted manual input requiring normal validation.
- Accessibility: replacement and confirmation controls must be keyboard-accessible and screen-reader-labelled.

### Required tests

```text
ManualCodeOverridesSignedLinkBeforeLockTest
InvalidManualCodePreservesValidLinkTest
PostCreationCodeChangeRejectedTest
MultiTabReferralChoiceConsistencyTest
CentralOutageReferralEvidenceReplayTest
```

### Demonstration of resolution

Resolution is demonstrated when a merchant can replace a link-derived code before tenant creation, an invalid replacement preserves the valid link claim, and every post-lock change is rejected or processed through controlled correction.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.3 Issue 3 — Payout frequency is both configurable and permanently monthly

**Severity:** High  
**Confidence:** 97%

### Affected users and services

- Super Administrators.
- Campaign Approvers.
- Finance roles.
- Referrer users.
- Customer Support.
- Audit.

### How the error appears

The specification describes payout frequency as campaign-configurable, calls monthly the default, and simultaneously defines a monthly payout principle, monthly payout runs, monthly statements, monthly qualification, and monthly acceptance tests. These clauses allow different teams to implement incompatible schedules.

### Governing correction

The production launch supports only:

```text
qualification_frequency = monthly
payout_frequency = monthly
```

Campaign administrators may configure monthly cutoff dates, clearing periods, execution dates, retry windows, and minimum thresholds. They may not configure weekly, fortnightly, or quarterly payout execution in Phase 1.

The campaign schema may retain a versioned `payout_frequency` field for forward compatibility, but the only valid launch enum value is `monthly`. Attempting another value must fail validation.

### Monthly cycle definition

A payout cycle contains:

- Qualification period close.
- Product-event grace period.
- Payment-clearing cutoff.
- Risk and exception review cutoff.
- Payout-run preparation.
- Review and approval.
- Provider submission.
- Reconciliation.
- Statement issuance.

Each cycle uses an IANA time zone configured at platform level. Launch default is `Africa/Nairobi`. Date-only cutoffs must be converted to exact timestamps and stored in UTC.

### Error handling and edge cases

- Administrator selects unsupported frequency: block save with `PAYOUT_FREQUENCY_NOT_SUPPORTED`.
- Campaign imported with weekly frequency: keep in `draft_invalid_configuration` until migrated to monthly.
- Month-end falls on weekend or public holiday: use configured business-day adjustment without changing the qualification period.
- Late event arrives after cutoff: include the qualified reward in the next monthly run and preserve the original service period.
- Provider outage on payout date: keep the run processing or retryable; do not create a second cycle or duplicate run.
- Campaign ends mid-month: existing attribution uses the campaign's published end rule; payout remains in the normal monthly cycle.
- Future non-monthly support: requires a new platform capability version, updated statements, liability rules, tests, and campaign terms. Existing monthly campaigns remain unchanged.

### Required tests

```text
LaunchRejectsNonMonthlyPayoutFrequencyTest
MonthEndBusinessDayAdjustmentTest
LateQualificationNextRunTest
TimezoneCutoffConsistencyTest
```

### Demonstration of resolution

Resolution is demonstrated when every active launch campaign reports monthly qualification and payout frequency and all non-monthly activation attempts fail deterministically.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.4 Issue 4 — Active use is both mandatory and optional

**Severity:** High  
**Confidence:** 99%

### Affected users and services

- Super Administrators.
- Campaign Approvers.
- Product Owners.
- Product Integration Service Accounts.
- Referrer users.
- Merchant Administrators.
- Referral Operations.
- Risk and Fraud.

### How the error appears

The platform purpose and monthly qualification formula require active use, while campaign validation says an activity rule is required only “when active use is mandatory.” The source-product section also says payment alone is insufficient “when the campaign requires active merchant use.” This permits one module to treat active use as universal and another to bypass it.

### Governing correction

For every launch recurring subscription-reward campaign:

```text
active_use_required = true
```

Each campaign version must reference one approved product-specific active-use rule version. A recurring subscription campaign cannot be activated without it.

The qualification engine requires:

```text
merchant_activity_status = qualified
```

The state `not_required` is reserved for a future, explicitly approved non-recurring campaign type and must not be accepted for launch subscription campaigns.

### Source-of-truth rule

The source product remains authoritative for the product-specific activity decision. It emits one final activity decision for each merchant, product, campaign-rule version, and qualification period.

The central platform validates integrity, stores minimized evidence, and may request re-evaluation. It does not reconstruct detailed operational logic from the product database.

### Required campaign fields

```text
active_use_required
activity_rule_id
activity_rule_version
activity_evidence_schema_version
activity_decision_due_at
activity_grace_period_days
```

### Error handling and edge cases

- Campaign lacks activity rule: block activation.
- Referenced activity rule is inactive or belongs to another product: block activation.
- Product sends no decision before cutoff: keep qualification `awaiting_activity_confirmation`; do not guess.
- Product sends qualified and not-qualified decisions for the same version: apply the correction rules in Issue 23 and create an integrity exception.
- Activity occurred in period but event arrived late: permit qualification in the next payout run when evidence proves the underlying activity occurred within the original period.
- Merchant meets threshold after period close: do not qualify the closed period unless the product confirms the event was delayed rather than the activity itself occurring late.
- Activity rule changes: create a new version; existing attributions retain the snapshotted version unless an approved prospective migration is allowed.
- Product is unavailable: hold only affected qualifications; unrelated products continue.
- Fraudulent or fabricated activity: place risk hold, preserve original evidence, and use reversal procedures for paid rewards.

### Required tests

```text
SubscriptionCampaignRequiresActivityRuleTest
ActivityNotRequiredRejectedAtLaunchTest
LateActivityEvidenceOriginalPeriodTest
ProductOutageActivityHoldTest
ActivityRuleVersionIsolationTest
```

### Demonstration of resolution

Resolution is demonstrated when no recurring subscription campaign can activate without an approved product-specific activity-rule version and no reward qualifies without a final qualified activity decision.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.5 Issue 5 — The four-month rule is global, default, conditional, and configurable at the same time

**Severity:** High  
**Confidence:** 96%

### Affected users and services

- Super Administrators.
- Campaign Approvers.
- Referrer users.
- Merchant Administrators.
- Referral Operations.
- Finance roles.
- Customer Support.
- Audit.

### How the error appears

The specification calls four months a platform minimum, a default minimum, a requirement for some campaigns, and a configurable value. The campaign-duration section allows language that could be interpreted as permitting fewer than four months. The governing architecture separately says Month 4 confirms retention.

### Governing correction

For all launch recurring subscription-reward campaigns:

```text
minimum_retention_milestone_months >= 4
retention_requires_consecutive_months = true
```

The platform default is four. An authorized campaign approver may increase the milestone but may not reduce it below four.

The four-month rule is a retention milestone, not a retroactive condition that invalidates properly earned Month 1–3 rewards under `monthly_pay_as_earned`.

Campaigns with a shorter conversion objective are outside the launch recurring-subscription campaign type. A future one-time conversion campaign must use a different campaign type, qualification model, terms, reporting classification, and approval policy. It must not pretend to satisfy the four-month subscription-retention rule.

### Configuration validation

Block activation when:

- Retention milestone is below four.
- Consecutive retention is disabled for a launch campaign.
- Reward duration is shorter than the minimum retention observation period.
- Published terms do not disclose the retention and payout policy.
- The campaign's activity rule or eligible service periods cannot produce the required milestone.

### Error handling and edge cases

- Legacy campaign has three-month milestone: prevent new attribution; existing legal obligations continue under the legacy terms while the campaign is marked nonconforming and reviewed.
- Administrator attempts to lower an active campaign's milestone: require a new version; do not migrate existing attributions automatically; block versions below four.
- Merchant qualifies Months 1–3 then misses Month 4: previously earned rewards remain; consecutive retention resets; no milestone is recorded.
- Merchant qualifies four months nonconsecutively: reward treatment follows Issue 6, but retention milestone remains unmet until four consecutive qualified periods occur.
- Merchant pays four months in advance: payment allocation alone does not satisfy retention; each service month must close and meet activity requirements.
- Merchant churns after Month 4: milestone remains reached; later periods simply do not qualify.
- Fraud discovered after milestone: milestone may be invalidated through a reasoned fraud decision, with reward adjustments or reversals as applicable.

### Required tests

```text
MinimumRetentionBelowFourRejectedTest
ConsecutiveRetentionRequiredAtLaunchTest
AdvancePaymentDoesNotAccelerateRetentionTest
MonthFourMissResetsRetentionTest
OrdinaryPostMilestoneChurnNoClawbackTest
```

### Demonstration of resolution

Resolution is demonstrated when every launch campaign has a consecutive retention milestone of at least four months and advance payment or nonconsecutive qualification cannot falsely satisfy it.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.6 Issue 6 — Reward duration and consecutive retention can diverge

**Severity:** Critical  
**Confidence:** 98%

### Affected users and services

- Referrer users.
- Merchant Administrators.
- Campaign Approvers.
- Referral Operations.
- Finance roles.
- Customer Support.
- Reporting users.
- Audit.

### How the error appears

The original model tracks qualifying-month count and consecutive qualifying-month count, but it also describes reward duration as a fixed number of qualifying months and says “Month 4” confirms retention. A merchant can earn four nonconsecutive rewards without achieving four consecutive qualifying months. The funnel and acceptance language can therefore mislabel reward completion as retention completion.

### Governing correction

Reward entitlement and retention are separate but related dimensions. The platform must never use one counter as a substitute for the other.

Track:

```text
reward_eligibility_period_number
rewarded_qualification_months
current_consecutive_qualifying_months
maximum_consecutive_qualifying_months
retention_milestone_months
retention_milestone_reached_at
reward_duration_months
reward_duration_type
reward_duration_completed_at
```

For launch, the recommended default is:

```text
reward_duration_type = fixed_calendar_duration
reward_duration_months >= retention_milestone_months
```

Under `fixed_calendar_duration`, the campaign defines a fixed sequence of service periods beginning with the first eligible paid service month. A missed month receives no reward and does not extend the campaign duration. This prevents indefinite reward windows and keeps “Month 4” meaningful as the fourth campaign service period.

The platform may retain `fixed_number_of_qualifying_months` for a future campaign type, but such a campaign must display that rewards can extend beyond the fourth calendar month and must not label the fourth rewarded month as the fourth consecutive retained month.

### Completion definitions

`reward_duration_completed` means the configured calendar eligibility window has ended, or all qualifying-month rewards allowed by an approved alternative duration type have been allocated.

`retention_milestone_reached` means the merchant has completed the configured number of consecutive qualified service periods.

A referral may have:

- Reward duration completed and retention milestone reached.
- Reward duration completed and retention milestone not reached.
- Retention milestone reached while additional reward periods remain.
- Neither completed.

These states must be shown accurately in reporting and not collapsed into one status.

### Example

```text
Campaign duration: 6 calendar service months
Retention milestone: 4 consecutive qualifying months
Month 1: qualified and rewarded
Month 2: not qualified
Month 3: qualified and rewarded
Month 4: qualified and rewarded
Month 5: qualified and rewarded
Month 6: qualified and rewarded
```

Result:

```text
rewarded_qualification_months = 5
current_consecutive_qualifying_months = 4
retention_milestone_reached_at = Month 6 close
reward_duration_completed_at = Month 6 close
```

The milestone is reached in calendar Month 6, not incorrectly labelled as “Month 4.”

### Error handling and edge cases

- Missed month: no reward; reset current consecutive count; preserve maximum count and previously earned rewards.
- Qualification later reversed: recompute retention sequence from immutable period outcomes; do not delete history.
- Late valid event changes a period from pending to qualified: recalculate the sequence deterministically and create any reward in the next payout run.
- Period reopened after finance lock: require controlled approval; create adjustment entries instead of overwriting paid records.
- Merchant cancellation and reactivation: duration continues under fixed calendar duration; no extension unless campaign terms explicitly provide a grace rule.
- Campaign uses fixed qualifying months in a future release: define a maximum observation window to prevent unlimited liability.
- Time-zone boundary: service-period assignment follows the source product billing period, not event receipt time.
- Plan change: does not reset retention unless campaign eligibility changes and terms specify termination.

### Required tests

```text
RewardDurationIndependentFromRetentionTest
FixedCalendarDurationMissedMonthTest
RetentionReachedAfterCalendarMonthFourTest
LateEventRetentionRecalculationTest
QualificationReversalRetentionRecalculationTest
```

### Demonstration of resolution

Resolution is demonstrated when rewarded-month totals, calendar duration, and consecutive retention produce independent, reproducible states under missed, late, and reversed periods.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.7 Issue 7 — Phase 1 permits payouts without mandatory reconciliation

**Severity:** Critical  
**Confidence:** 100%

### Affected users and services

- Finance Preparers, Reviewers, Approvers, Executors, and Reconciliers.
- Referrer users.
- Customer Support.
- Platform Engineering.
- Super Administrators.
- Audit.

### How the error appears

Phase 1 includes payout runs, while reconciliation is deferred to Phase 2. Elsewhere, the platform requires payment clearing and reconciliation, says only reconciled provider success becomes final `paid`, sets financial reconciliation completeness at 100%, and includes reconciliation in integration tests. The implementation plan therefore omits a control required by its own financial state model and service-level expectations.

### Governing correction

A production payout feature cannot launch without minimum viable reconciliation. Phase 1 must include:

- Provider request and response persistence.
- Unique idempotency keys.
- Synchronous response interpretation.
- Authenticated callback verification.
- Provider-status query or polling.
- Settlement-reference capture.
- Amount and currency matching.
- Returned-payment handling.
- Retry classification.
- Manual exception review.
- Reconciliation audit evidence.

Advanced automated bank-statement matching, multi-provider net settlement, fee analytics, and bulk finance tooling may remain later. The ability to prove whether a payout succeeded, failed, remained pending, or was returned is a launch requirement.

### Corrected payout finality model

A provider's initial acceptance does not mean the Referrer has been paid.

Use:

```text
approved
submitted
provider_accepted
processing
provider_reported_success
reconciliation_pending
reconciled_paid
failed_retryable
failed_final
returned
```

The Referrer-facing `paid` state is derived only from `reconciled_paid`.

A reward ledger entry moves to final paid allocation only after:

- Provider transaction identity is known.
- Amount and currency match.
- Destination token matches the approved payout item.
- Provider status is successful.
- No contradictory return or reversal exists.
- Reconciliation is recorded.

### Reconciliation workflow

```text
Approved payout item
→ idempotent provider submission
→ provider acknowledgement stored
→ callback and/or status query
→ response signature verified
→ amount, currency, destination token, and provider reference matched
→ reconciliation result created
→ ledger allocation finalized
→ statement updated
```

Every reconciliation result must be append-only. A later provider return creates a new return result and restores the liability through ledger entries.

### Error handling and edge cases

- Provider timeout before a response: keep `submission_unknown`; query provider using the idempotency key before retrying.
- Provider reports success but callback is missing: poll provider and reconcile from authenticated status response.
- Callback reports success but status query says processing: keep pending and create a mismatch exception.
- Callback signature invalid: reject callback, alert integration security, and query provider through the trusted channel.
- Provider returns a different amount: do not mark paid; create a critical reconciliation exception.
- Duplicate callback: process idempotently.
- Duplicate submission request: same idempotency key must not create another provider transaction.
- Provider reference reused for two payout items: critical integrity alert and financial hold.
- Settlement occurs after statement generation: issue a provisional statement or keep statement pending; generate final statement after reconciliation.
- Provider outage spans cycle close: preserve payable liability; do not mark failed final solely due to outage.
- Returned funds after previous success: create `payout_return`, restore payable liability, create accounting reversal, notify Referrer, and require a valid payout destination before retry.
- Partial batch success: reconcile each payout item independently; the run becomes `partially_successful` until all items reach terminal status.

### Required data model

Add or confirm:

```text
payout_provider_requests
payout_provider_responses
payout_callbacks
payout_status_queries
payout_reconciliation_results
payout_reconciliation_exceptions
payout_returns
```

Each record must include raw-provider-payload storage under secure retention controls, payload hash, signature result, request or callback timestamp, parsed status, amount, currency, provider reference, correlation ID, and actor or service identity.

### Required tests

```text
ProviderTimeoutUnknownOutcomeTest
MissingCallbackStatusQueryReconciliationTest
InvalidCallbackSignatureTest
ProviderAmountMismatchTest
DuplicateCallbackIdempotencyTest
ReturnedPayoutLiabilityRestorationTest
PartialBatchReconciliationTest
```

### Demonstration of resolution

Resolution is demonstrated when no payout reaches final paid state without authenticated provider evidence, matched amount and destination, reconciliation, and append-only settlement records.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.8 Issue 8 — Maker/checker is deferred despite being a core financial control

**Severity:** Critical  
**Confidence:** 99%

### Affected users and services

- Finance roles.
- Super Administrators.
- Campaign Approvers.
- Referral Operations.
- Risk and Fraud.
- Audit.
- Referrer users indirectly.

### How the error appears

The specification defines maker/checker for payout runs, forbids Super Administrator bypass, and includes authorization tests for it, but Phase 2 defers the feature. This leaves Phase 1 capable of creating and executing payouts without the required separation of duties.

### Governing correction

Phase 1 must enforce maker/checker for:

- Payout-run approval.
- High-value manual adjustments.
- Reward reversals above threshold.
- Payout-destination exception approval.
- Reopening a locked payout or accounting period.
- Manual attribution reassignment that affects reward liability.
- Break-glass financial actions.

### Approval policy

The platform must support policy conditions based on:

```text
amount
currency
risk level
campaign
product
actor role
manual versus automated origin
number of affected Referrers
presence of an exception
```

For launch, every production payout run requires at least two distinct human actors:

```text
preparer != approver
```

For high-value or exceptional runs, require:

```text
preparer != reviewer
reviewer != approver
approver != executor
```

The payout reconciler should normally be different from the executor for high-risk runs.

### Approval record

Every approval must store:

- Entity type and ID.
- Policy version.
- Requested action.
- Initiator.
- Reviewer or approver.
- decision.
- reason.
- amount and currency.
- risk flags.
- before-and-after snapshot hashes.
- timestamp.
- authentication assurance level.
- correlation ID.

Approvals expire when the underlying payout run changes. Adding or removing an item, changing an amount, changing a payout method, changing a tax deduction, or changing provider routing invalidates prior approvals and requires reapproval.

### Error handling and edge cases

- Same user attempts to approve own run: deny with `SEPARATION_OF_DUTIES_VIOLATION` and audit.
- User holds both roles: actor identity, not role name, controls separation.
- Approver loses permission after approval but before execution: revalidate approval policy before execution; require replacement approval where policy fails.
- Run changes after approval: reset to review state and invalidate approvals.
- Emergency payout: use break-glass workflow with independent approval and post-event audit; no silent bypass.
- Small adjustment below threshold: may use simplified approval only where policy explicitly permits; still audit actor and reason.
- Approver is unavailable: another authorized approver may act; do not transfer or impersonate approval.
- Automated system-generated run: the system may prepare but a human must approve before provider submission.
- Reconciliation discovers material discrepancy: lock run, prevent additional execution, and require Finance review.

### Required data model

```text
approval_policies
approval_requests
approval_steps
approval_decisions
approval_invalidations
separation_of_duties_rules
```

### Required tests

```text
PayoutMakerCannotApproveOwnRunTest
RunMutationInvalidatesApprovalTest
HighValueFourRoleSeparationTest
BreakGlassFinancialActionAuditTest
PermissionRevokedBeforeExecutionTest
```

### Demonstration of resolution

Resolution is demonstrated when the same actor cannot prepare and approve a protected action and any material mutation invalidates earlier approvals.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.9 Issue 9 — Statements are a core requirement but deferred to Phase 2

**Severity:** High  
**Confidence:** 100%

### Affected users and services

- Referrer legal entities and users.
- Finance roles.
- Customer Support.
- Tax and Compliance.
- Audit.

### How the error appears

The Referrer is promised monthly statements, payout statements, downloads, and a statement at the end of the successful-referral acceptance scenario. Phase 2 then defers statements. The platform cannot provide transparent payout evidence at launch under that plan.

### Governing correction

Phase 1 must include basic:

- Monthly earnings statement.
- Monthly payout statement.
- Per-payout statement.
- Product allocation breakdown.
- Adjustments and reversals shown separately.
- Carried-forward balance.
- Payout method mask.
- Provider reference where available.
- Reconciliation status.
- Download audit event.

Annual tax summaries, withholding certificates, advanced campaign statements, and multi-currency consolidated tax reporting may follow according to the corrected tax rollout.

### Statement finality

Statements have versions and states:

```text
draft
provisional
final
superseded
void_due_to_error
```

A payout statement becomes final only after reconciliation. A provisional statement may be shown while settlement is pending, but it must clearly state that the payout is not final.

A correction does not overwrite a prior final statement. Generate a replacement version that references the superseded statement and explains the adjustment.

### Minimum statement contents

- Citrus Labs and platform identity.
- Referrer legal entity and masked reference.
- Statement period.
- Statement version and issue date.
- Opening payable balance.
- Reward accruals by product, campaign, merchant display reference, and service period.
- Holds and releases.
- Credits and debits.
- Reversals.
- Withholding where implemented.
- Payout allocations by product.
- Amount submitted.
- Amount reconciled as paid.
- Returned amount.
- Closing payable balance.
- Currency.
- Safe support route.
- Integrity identifier or document hash.

### Security and delivery

- Downloads use short-lived signed URLs.
- Authorization is checked at download time, not only when the URL is issued.
- Documents are encrypted at rest.
- Full payout destination is never printed.
- Email contains a notification and secure link, not the statement as an unprotected attachment unless policy explicitly permits encrypted attachment delivery.
- Downloads are audited.

### Error handling and edge cases

- Statement generation fails: payout state remains correct; queue retry and show `statement_generation_pending`.
- Reward changes after provisional statement: regenerate provisional version.
- Reward changes after final statement: issue corrective statement; preserve prior version.
- Referrer changes legal name: historical statement retains the legal identity effective at issuance, with corrected reissue only through approved process.
- Payout is returned after final statement: issue a new statement version or return notice reflecting restored liability.
- No activity in month: generate a zero-activity statement only where configured; otherwise show no statement due.
- User removed from organization: deny future downloads unless current membership permits them.
- Signed URL expired: require authenticated regeneration.
- Document hash mismatch: block download and alert security.

### Required tests

```text
MonthlyStatementGenerationTest
ProvisionalStatementNotFinalPaidTest
CorrectiveStatementPreservesPriorVersionTest
ExpiredSignedUrlDeniedTest
OrganizationMembershipStatementAccessTest
ReturnedPayoutStatementCorrectionTest
```

### Demonstration of resolution

Resolution is demonstrated when every reconciled payout produces a versioned downloadable statement and later corrections preserve prior statement versions.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.10 Issue 10 — Consolidated payouts are foundational but deferred

**Severity:** High  
**Confidence:** 99%

### Affected users and services

- Referrer users.
- Finance roles.
- Product Owners and cost-centre owners.
- Customer Support.
- Tax and Compliance.
- Audit.

### How the error appears

The settled architecture promises one central platform and permits one payout to consolidate rewards from several products while preserving product-level accounting. The dashboard, ledger, finance model, acceptance scenario, and named tests all rely on consolidation. Phase 2 then defers it.

### Governing correction

Phase 1 must support consolidated KES payouts across eligible Citrus products for the same Referrer legal entity and active payout method.

Consolidation occurs only when all included items share:

- Referrer legal entity.
- Currency.
- payout provider compatibility.
- active verified payout method.
- payout cycle.
- legal and tax treatment compatible with one payment.
- no item-specific hold that requires exclusion.

The payout transaction may be consolidated, but each reward allocation remains separately traceable to product, campaign, merchant, qualification period, cost centre, liability account, expense account, and tax treatment.

### Data model

Use:

```text
payout_runs
payout_beneficiary_items
payout_allocations
payout_attempts
payout_reconciliation_results
```

A beneficiary item represents the amount paid to one Referrer in one provider transaction. Allocations represent the component liabilities from products and campaigns.

The invariant is:

```text
sum(active payout allocations)
- withholding
+ payout-level rounding adjustment
= provider payout amount
```

### Run behavior

An unresolved reward from one product must not automatically block payable rewards from other products. The system should exclude or hold the affected allocation and continue with eligible allocations unless:

- A Referrer-level legal or fraud hold applies.
- The payout method is invalid.
- Currency or provider compatibility requires a split.
- The remaining amount falls below threshold.
- The provider cannot support a partial beneficiary amount after approval without a regenerated run.

### Error handling and edge cases

- One product allocation held: exclude it and carry forward while paying other eligible allocations.
- Referrer-level risk hold: hold the entire beneficiary item.
- Different currencies: Phase 1 cannot consolidate; non-KES items must not exist under the corrected launch rules.
- Different payout methods by product: not supported; payout method belongs to the Referrer entity, not product.
- One allocation reverses before submission: remove allocation, recompute item, invalidate approval, and reapprove.
- Reversal after provider submission but before settlement: do not attempt unsafe mutation; reconcile payout, then create a recovery or offset entry.
- Provider maximum transaction limit: split into multiple attempts under one beneficiary item with separate idempotency keys and reconciliation, while preserving allocations.
- Rounding across products: allocate rounding difference through an explicit payout-level rounding entry using a deterministic method.
- One provider attempt fails and another succeeds: reconcile attempts separately and maintain remaining liability.
- Consolidated payout returned: restore each component liability proportionally or exactly by allocation, not as an unallocated lump sum.

### Required tests

```text
ConsolidatedPayoutAllocationInvariantTest
HeldProductDoesNotBlockOtherProductsTest
ReferrerLevelHoldBlocksBeneficiaryTest
ProviderLimitSplitAttemptTest
ConsolidatedReturnRestoresAllocationsTest
RunMutationReapprovalTest
```

### Demonstration of resolution

Resolution is demonstrated when one provider payment can reconcile exactly to multiple product allocations and an exception in one allocation does not corrupt unrelated payable components.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.11 Issue 11 — Registration status mixes independent state dimensions

**Severity:** High  
**Confidence:** 99%

### Affected users and services

- Referrer users.
- Referral Operations.
- Customer Support.
- Risk and Fraud.
- Finance roles.
- Product and Campaign administrators.

### How the error appears

The registration status list combines lifecycle, onboarding, verification, payout readiness, risk restriction, and termination into one field. A Referrer can be active for referrals while lacking a payout method, and an organization can be active while identity review or a specific payout method remains pending. A single enum forces impossible or lossy transitions.

### Governing correction

Replace the overloaded status with orthogonal state machines.

#### Account lifecycle

```text
account_status:
draft
active
restricted
suspended
deactivated
closed
rejected
```

#### Onboarding

```text
onboarding_status:
not_started
in_progress
minimum_profile_complete
complete
```

#### Email verification

```text
email_verification_status:
unverified
pending
verified
failed
```

#### Phone verification

```text
phone_verification_status:
not_required
unverified
pending
verified
failed
```

#### Identity review

```text
identity_status:
not_required
pending
verified
needs_information
rejected
expired
```

#### Terms

```text
terms_status:
not_accepted
accepted
reacceptance_required
```

#### Payout readiness

```text
payout_readiness_status:
not_configured
verification_pending
cooling_off
ready
held
unsupported
```

#### Risk

```text
risk_status:
clear
monitor
review_pending
soft_hold
hard_hold
closed_for_fraud
```

#### Campaign participation

Campaign participation belongs in separate enrollment records rather than the account status.

### Capability derivation

Capabilities must be derived through policy, for example:

```text
can_browse_campaigns
can_enroll
can_generate_live_referral_assets
can_receive_attribution
can_accrue_rewards
can_be_paid
can_download_statements
can_manage_members
```

A Referrer may be able to refer and accrue rewards while `payout_readiness_status = not_configured`, but cannot be paid until ready.

### Error handling and edge cases

- Email verified while phone pending: retain separate results.
- Identity expires after account activation: restrict high-risk actions and payouts without deleting referrals.
- Payout method rejected: account remains active; payout readiness changes to unsupported or not configured.
- Risk soft hold: permit sign-in and support access; block payouts according to policy.
- Terms reacceptance required: permit read-only access and support; block new referrals or campaign enrollment until acceptance.
- Organization has one member suspended: do not suspend the entity automatically unless risk decision applies to entity.
- Deactivated account has unpaid valid rewards: permit final-payout workflow according to policy.
- Rejected applicant attempts duplicate registration: route to identity-resolution or appeal rather than creating another entity.

### Required data model

Store state columns in the relevant aggregate or dedicated history tables. Every transition must have an append-only history record with actor, reason, source, timestamp, and prior/new state.

### Required tests

```text
ActiveWithoutPayoutMethodCapabilityTest
IdentityExpiryRestrictsPayoutOnlyTest
TermsReacceptanceCapabilityTest
IndependentVerificationStateTest
EntityAndMemberStatusIsolationTest
```

### Demonstration of resolution

Resolution is demonstrated when account, onboarding, verification, identity, payout, risk, terms, and campaign states change independently and capabilities are derived rather than stored as one ambiguous status.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.12 Issue 12 — Suspended users are blocked from signing in but must be able to appeal

**Severity:** High  
**Confidence:** 96%

### Affected users and services

- Suspended Referrer users.
- Customer Support.
- Risk and Fraud.
- Privacy and Legal.
- Finance roles.
- Audit.

### How the error appears

The error-handling section can be read as blocking all sign-in for a suspended account, while appeals, support, statements, notices, and decision explanations require authenticated access. A total sign-in block prevents procedural fairness and access to financial records.

### Governing correction

Suspension is a restricted capability mode, not automatic loss of all authenticated access.

For a normal suspension:

```text
account_status = suspended
dashboard_mode = restricted_read_only
new_referrals = denied
campaign_enrollment = denied
referral_asset_generation = denied
payouts = held or reviewed
support_access = allowed
appeal_access = allowed
statement_access = allowed unless legal restriction applies
security_settings_access = limited
```

A security-compromised account may have all sessions revoked. The user must recover identity through a secure recovery process before accessing the restricted dashboard. This is different from permanently denying appeal.

### Suspension notice

The platform must provide:

- General reason category.
- Effective date.
- Capabilities affected.
- Treatment of existing referrals and rewards.
- Appeal eligibility and deadline.
- Support route.
- Non-disclosure of sensitive fraud methods or third-party data.

### Error handling and edge cases

- Account takeover suspected: revoke sessions, block Magic Links to compromised channel, require identity recovery, then provide restricted access.
- Legal prohibition prevents disclosure: provide minimum lawful notice and preserve appeal route where permitted.
- Referrer suspended but organization has other verified owners: entity-level versus user-level suspension must be distinguished.
- One organization user suspended: other users continue unless entity is suspended.
- Entity suspended: all members receive capability restrictions appropriate to their roles.
- Suspension expires: do not auto-release financial holds unless review conditions are satisfied.
- Appeal succeeds: restore capabilities prospectively and release valid rewards through normal payout cycle.
- Appeal fails: preserve decision and escalation route according to policy.
- Final account closure: preserve access to legally required statements through a secure archival process or support-assisted delivery.

### Required tests

```text
SuspendedAccountRestrictedDashboardTest
SuspendedAccountAppealAccessTest
CompromisedAccountRecoveryBeforeAppealTest
OrganizationUserSuspensionIsolationTest
SuccessfulAppealCapabilityRestorationTest
```

### Demonstration of resolution

Resolution is demonstrated when a suspended user cannot create new referrals or alter payouts but can securely view permitted statements, receive reasons, contact support, and submit an appeal.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.13 Issue 13 — Organization Referrers lack a usable membership model

**Severity:** High  
**Confidence:** 98%

### Affected users and services

- Organization Referrer users.
- Organization owners and admins.
- Referral Operations.
- Customer Support.
- Finance roles.
- Risk and Fraud.
- Audit.

### How the error appears

The platform allows organizations, agencies, associations, and legal entities to be Referrers but models one Referrer identity and one login-oriented profile. It does not define authorized users, invitations, ownership, permissions, removal, succession, or per-user auditing.

### Governing correction

Separate:

```text
referrer_entities
referrer_users
referrer_memberships
referrer_roles
referrer_membership_role_assignments
referrer_invitations
referrer_ownership_transfers
```

The entity owns financial and referral records. Users authenticate and act through memberships.

### Membership rules

- Every membership has status, role, effective dates, inviter, and acceptance evidence.
- Invitations expire and may be revoked.
- Invitee email must be verified before membership activation.
- High-risk roles require step-up verification and entity-owner approval.
- A user may belong to more than one Referrer entity only after conflict and risk checks.
- Every action records both `actor_user_id` and `referrer_entity_id`.
- Removing a user terminates future access but does not erase their audit history.
- The last owner cannot leave until ownership is transferred or the entity is closed.

### Ownership transfer

Ownership transfer requires:

- Current-owner request or controlled recovery process.
- New owner's verified email and phone.
- Step-up authentication.
- identity and risk review.
- cooling-off period for high-risk financial changes.
- notification to existing owners.
- audit record.

Ownership transfer does not automatically change the payout method. A separate payout-method workflow is required.

### Error handling and edge cases

- Invite sent to an email already associated with another entity: allow only after conflict/risk evaluation; do not expose other membership details.
- Invite expires: require a new invitation.
- Removed user uses an old signed URL: authorization check denies access.
- Last owner attempts removal: block.
- Organization owner dies or leaves business: use documented succession and legal-evidence review.
- Dispute between owners: freeze ownership-sensitive actions and route to Legal/Support review.
- User changes email: verify new email and update user identity without changing entity ownership.
- Organization converted to another legal form: create controlled legal-entity update with preserved historical identifiers.
- Individual Referrer later incorporates: do not silently merge; use approved entity-conversion workflow and tax/payout review.
- Shared credentials detected: notify owners, revoke sessions, and require individual memberships.

### Required tests

```text
OrganizationMultipleMemberAccessTest
LastOwnerRemovalBlockedTest
ExpiredInvitationDeniedTest
RemovedMemberSignedUrlDeniedTest
OwnershipTransferCoolingOffTest
CrossEntityMembershipRiskReviewTest
```

### Demonstration of resolution

Resolution is demonstrated when organizations support multiple authorized users, cannot lose their last verified owner, and every membership or ownership change is verified, scoped, and audited.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.14 Issue 14 — Merchant Administrator is incorrectly presented as a central account type

**Severity:** Low  
**Confidence:** 100%

### Affected users and services

- Merchant Administrators.
- Referrer users.
- Product Owners.
- Customer Support.
- Platform Engineering.

### How the error appears

The Merchant Administrator appears in the “Users and Account Types” section even though the same section states that the person remains a user of the source Citrus product and does not use the central Referrer dashboard.

### Governing correction

Move the Merchant Administrator to:

```text
External Actors and Source-Product Users
```

The central platform may store a minimized merchant-administrator reference only where necessary for attribution evidence, duplicate detection, consent, dispute handling, and audit. It must not create a central Merchant Administrator login merely to display referral status.

### Permitted interactions

- Enter or confirm a referral code in the source product.
- See a limited referral-applied notice.
- Open a source-product support or dispute route.
- Receive product communications concerning attribution where lawful.

### Prohibited exposure

- Referrer payout details.
- Referrer tax data.
- Referrer's total earnings.
- Other referred merchants.
- private fraud evidence.
- internal support or audit notes.

### Error handling and edge cases

- Merchant Administrator changes: attribution remains attached to tenant, not the person.
- Administrator loses access: central referral state remains unchanged.
- Merchant disputes referral: source product creates a dispute request linked to central attribution; no direct central account is required.
- Same person administers several merchant tenants: evaluate duplicate and self-referral risk without automatically merging tenants.
- Merchant user attempts central Referrer sign-in: only permit it when the person separately owns or is a member of a Referrer entity.

### Required tests

```text
MerchantAdminNoCentralDashboardAccountTest
MerchantAdminLimitedReferralNoticeTest
MerchantAdminChangePreservesAttributionTest
MerchantAdminDataMinimizationTest
```

### Demonstration of resolution

Resolution is demonstrated when no central login or authorization record is created for a Merchant Administrator and only limited product-native referral context is exposed.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.15 Issue 15 — Payment-method PATCH conflicts with immutable replacement

**Severity:** Critical  
**Confidence:** 98%

### Affected users and services

- Referrer owners and organization admins.
- Finance roles.
- Risk and Fraud.
- Customer Support.
- Audit.

### How the error appears

The specification correctly describes payout-method replacement as creation, verification, cooling-off, activation, and retirement of the old method. The API separately exposes a generic PATCH on a payment method, which implies that a verified destination can be edited in place. That would break historical evidence for prior payout approvals and attempts.

### Governing correction

Verified payout-destination identity fields are immutable. A change creates a new payment-method record and a change request.

Remove or narrow:

```text
PATCH /api/referrer/payment-methods/{method}
```

A PATCH may update only non-financial display metadata that does not alter destination identity and is explicitly whitelisted. It must never alter account number, mobile number, bank routing, provider token, currency, country, or account holder identity.

Use:

```text
POST /api/referrer/payment-method-change-requests
POST /api/referrer/payment-methods
POST /api/referrer/payment-methods/{id}/submit-verification
POST /api/referrer/payment-methods/{id}/activate
POST /api/referrer/payment-methods/{id}/disable
GET  /api/referrer/payment-method-change-requests/{id}
```

### Change workflow

```text
Request created
→ step-up authentication
→ new destination captured and encrypted/tokenized
→ ownership verification
→ risk screening
→ cooling-off period
→ unsettled payouts held
→ authorized activation
→ old method marked replaced
→ notifications sent
→ audit completed
```

A payout attempt always stores the exact immutable payment-method version or token used.

### Error handling and edge cases

- Referrer submits same destination again: return existing active method or create an idempotent no-change result.
- New destination verification fails: keep old method active for account history, but apply the deterministic unsettled-payout rule in Issue 20.
- Old destination expires during cooling-off: hold payouts until new method is ready.
- Provider token rotates without destination change: create a technical token-version record linked to the same immutable destination, preserving old attempt references.
- Referrer starts two change requests: allow only one active high-risk change request or cancel the older request through explicit action.
- Account takeover suspected during change: revoke sessions, cancel pending activation, and retain evidence.
- Destination used by several Referrers: risk hold and review; do not mutate existing method.
- Payout already submitted: it continues against the immutable method version captured at approval; changes cannot rewrite it.
- Data correction to account-holder spelling: treat as identity correction with verification and audit; do not alter routing fields.
- User tries PATCH on protected field: return `IMMUTABLE_PAYMENT_METHOD_FIELD`.

### Required tests

```text
VerifiedPaymentMethodFinancialFieldsImmutableTest
PaymentMethodReplacementCreatesNewVersionTest
PayoutAttemptReferencesExactMethodVersionTest
ConcurrentChangeRequestTest
ProviderTokenRotationPreservesHistoryTest
ProtectedPatchRejectedTest
```

### Demonstration of resolution

Resolution is demonstrated when a verified destination cannot be patched, every change creates a new candidate and hold, and historical payout snapshots remain unchanged.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.16 Issue 16 — Core internal identity and RBAC tables are missing

**Severity:** Critical  
**Confidence:** 99%

### Affected users and services

- Every internal human user.
- Super Administrators.
- Finance roles.
- Risk and Fraud.
- Support.
- Audit.
- Platform Engineering.
- Product Owners.
- Referrer users indirectly.

### How the error appears

The specification defines several internal account types and authorization restrictions but the core data model does not define internal users, roles, permissions, scopes, approvals, or access reviews. The system therefore has no authoritative persistence model for the stated server-side authorization rules.

### Governing correction

Add a centralized identity and authorization module with:

```text
internal_users
internal_identities
roles
permissions
role_permissions
user_role_assignments
product_scopes
campaign_scopes
entity_scopes
approval_assignments
access_review_campaigns
access_review_items
privileged_sessions
break_glass_grants
```

### Permission model

Permissions must be action-oriented, for example:

```text
campaign.create
campaign.approve
campaign.activate
attribution.review
attribution.reassign
reward.hold
reward.adjust.propose
reward.adjust.approve
payout.run.create
payout.run.review
payout.run.approve
payout.execute
payout.reconcile
payment_method.unmask
fraud.case.review
audit.case.manage
integration.key.rotate
```

Roles are bundles of permissions, not hard-coded authorization shortcuts. Every request must evaluate:

- Authenticated user.
- active status.
- assigned role.
- required permission.
- product or campaign scope.
- record sensitivity.
- separation-of-duties rule.
- step-up authentication requirement.
- legal, risk, or period lock.

### Scope rules

A user may have:

- Platform-wide scope.
- Product-only scope.
- campaign-only scope.
- assigned-case scope.
- read-only masked scope.

Deny by default. Missing scope never implies global access.

### Role lifecycle

- Role assignment requires authorized approval.
- High-risk roles require expiry or periodic recertification.
- Permission changes take effect immediately.
- Existing sessions must not retain revoked permissions through stale claims.
- Role and permission history is immutable.
- Dormant privileged accounts are disabled.

### Error handling and edge cases

- User has permission but wrong product scope: deny and audit.
- User has two roles whose combination violates policy: block assignment or require compensating approval.
- Permission removed during active workflow: recheck at each write action.
- Role deleted while assigned: prevent hard deletion; deactivate and migrate assignments.
- Super Administrator attempts maker/checker bypass: deny through policy engine.
- Support user follows direct URL to finance record: server denies regardless of frontend navigation.
- Service account presented to human endpoint: reject token audience or actor type.
- Audit user tries to mutate business record: deny; allow only audit-case metadata endpoints.
- Emergency access expires mid-session: revoke privileged token and require normal authorization.

### Required tests

```text
DefaultDenyAuthorizationTest
ProductScopedRoleIsolationTest
PermissionRevocationImmediateEffectTest
ConflictingRoleAssignmentTest
ServiceAccountHumanEndpointDeniedTest
BreakGlassExpiryTest
```

### Demonstration of resolution

Resolution is demonstrated when every internal action is denied by default unless an explicit role, permission, scope, assurance level, and entity state authorize it.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.17 Issue 17 — No clear central merchant-reference entity

**Severity:** High  
**Confidence:** 96%

### Affected users and services

- Referral Operations.
- Customer Support.
- Risk and Fraud.
- Finance roles.
- Product Owners.
- Referrer users.
- Audit.

### How the error appears

The central platform must display referred merchants, deduplicate identities, process product events, reconcile source facts, route support, and report across products. The listed data model relies on merchant IDs inside other records but does not define a minimized canonical merchant-product reference aggregate.

### Governing correction

Add:

```text
merchant_legal_entities
merchant_product_tenants
merchant_identity_snapshots
merchant_identity_links
merchant_display_profiles
merchant_source_references
```

The central platform must not become the source of truth for operational merchant data. These records are referral-domain references and immutable or versioned snapshots of product-authoritative facts.

### Merchant legal entity versus product tenant

`merchant_legal_entities` represents a deduplication and cross-product identity hypothesis or verified legal business.

`merchant_product_tenants` represents the actual merchant tenant in a specific Citrus product and is the attribution boundary.

One legal business may have several product tenants across different products. Duplicate tenants in one product require review.

### Minimum stored fields

- Central reference ID.
- Source product ID.
- source merchant tenant ID.
- source account reference.
- display name.
- legal-name hash or encrypted value where required.
- registration or tax identifier hash where collected.
- country.
- tenant status category.
- first registered timestamp.
- last source update timestamp.
- source event ID.
- identity-confidence state.
- canonical or duplicate status.

Do not copy merchant customers, detailed revenue, transaction lists, or operational records.

### Error handling and edge cases

- Product sends unknown merchant ID in payment event: quarantine event until registration reference exists or source verification confirms it.
- Product reuses merchant ID: critical integrity alert.
- Merchant changes legal name: append snapshot and update display profile; attribution remains on tenant ID.
- Two tenants are later proven one legal business: link them; do not automatically merge cross-product attributions.
- Duplicate tenant in same product: select canonical tenant through product-authoritative decision and fraud review.
- Merchant deleted in source product: retain referral-domain reference for financial and audit retention.
- Product changes account-reference format: maintain immutable source ID and versioned display reference.
- Identity match is uncertain: mark `possible_match`; do not merge automatically.
- Privacy request: minimize or pseudonymize permitted fields while retaining required financial references.

### Required tests

```text
UnknownMerchantEventQuarantineTest
MerchantIdReuseCriticalAlertTest
MerchantNameChangePreservesAttributionTest
SameLegalBusinessCrossProductTenantTest
UncertainIdentityNoAutoMergeTest
```

### Demonstration of resolution

Resolution is demonstrated when every attribution and qualification references a minimized central merchant-product record while source-product authority and privacy boundaries remain intact.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.18 Issue 18 — Campaign enrollment records are missing

**Severity:** High  
**Confidence:** 99%

### Affected users and services

- Referrer users.
- Referral Operations.
- Campaign Approvers.
- Customer Support.
- Reporting users.
- Audit.

### How the error appears

The platform permits open enrollment, restricted applications, approval, rejection, suspension, and campaign participation, yet the data model contains no explicit enrollment aggregate. Campaign access could otherwise be inferred incorrectly from account or campaign status.

### Governing correction

Add:

```text
referrer_campaign_enrollments
campaign_enrollment_applications
campaign_enrollment_reviews
campaign_enrollment_status_history
campaign_enrollment_terms_acceptances
```

### Enrollment status model

```text
not_enrolled
application_draft
application_submitted
under_review
approved
active
restricted
suspended
rejected
withdrawn
ended
```

Enrollment is specific to one Referrer entity and one campaign version or enrollment policy lineage.

### Rules

- Open campaigns may create an active enrollment after eligibility checks and terms acceptance.
- Restricted campaigns require review and approval.
- Enrollment approval does not override account, identity, risk, country, or legal restrictions.
- Campaign-version changes requiring new terms create a reacceptance task.
- Ending enrollment blocks new referral assets and attribution but does not erase valid locked attributions or earned rewards.

### Error handling and edge cases

- Duplicate application: return existing active application idempotently.
- Campaign closes during review: reject or end application with clear reason; do not activate.
- Referrer becomes ineligible after approval: restrict enrollment prospectively and review existing referrals under published terms.
- Terms change: require reacceptance before new referrals; existing attributions retain prior terms.
- Organization member without enrollment-management permission applies: deny.
- Referrer withdraws application: preserve review history.
- Enrollment suspended for campaign-specific misconduct: other campaign enrollments remain unaffected unless entity-level risk action applies.
- Campaign reopened: prior ended enrollment does not automatically reactivate without policy.

### Required tests

```text
OpenCampaignEnrollmentTest
RestrictedCampaignApprovalTest
DuplicateApplicationIdempotencyTest
CampaignClosesDuringReviewTest
CampaignSpecificSuspensionIsolationTest
TermsReacceptanceBeforeNewReferralTest
```

### Demonstration of resolution

Resolution is demonstrated when campaign application, approval, rejection, suspension, withdrawal, and termination are persisted independently from account and campaign states.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.19 Issue 19 — Audit users manage audit cases but no audit-case model exists

**Severity:** Medium  
**Confidence:** 97%

### Affected users and services

- Audit users.
- Super Administrators.
- Privacy and Legal.
- Internal control owners.

### How the error appears

Audit users may create flags, add notes, escalate, and resolve an audit review, but the model lists only immutable audit logs. Audit logs and audit investigations are different aggregates: the former records events; the latter organizes review work.

### Governing correction

Add:

```text
audit_cases
audit_case_links
audit_case_notes
audit_case_assignments
audit_case_status_history
audit_case_exports
```

### Audit-case rules

An audit case may link to immutable audit events, Referrers, merchants, campaigns, rewards, payout runs, support cases, fraud cases, integrations, or internal actors.

Audit-case metadata may be updated through append-only status and note records. The underlying audit log is never edited.

### Status model

```text
open
assigned
under_review
awaiting_information
escalated
resolved
closed
reopened
```

### Error handling and edge cases

- Linked business record later changes: case retains link and can show newer audit events; original evidence remains.
- Audit event retention policy approaches expiry while case open: legal or audit hold preserves required evidence.
- Auditor attempts to alter audit event: deny.
- Sensitive fraud evidence linked: enforce need-to-know masking even for general audit users.
- Case exported: record scope, filters, recipient, reason, and document hash.
- Duplicate cases: link or merge case metadata through explicit action; do not merge audit logs.
- Auditor closes own high-severity case where policy requires review: require second-level approval.

### Required tests

```text
AuditCaseDoesNotMutateAuditLogTest
AuditCaseEvidenceRetentionHoldTest
SensitiveLinkedEvidenceMaskingTest
HighSeverityAuditCaseClosureApprovalTest
AuditExportAuditTrailTest
```

### Demonstration of resolution

Resolution is demonstrated when Audit users can manage case metadata but cannot mutate audit logs or linked business and financial records.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.20 Issue 20 — Previous-versus-new payout-method behavior is nondeterministic

**Severity:** High  
**Confidence:** 94%

### Affected users and services

- Referrer owners and admins.
- Finance roles.
- Risk and Fraud.
- Customer Support.
- Audit.

### How the error appears

The payout-method workflow says the previous method may remain active or the payout may be held, and the error section says a post-cutoff change may use the previous verified method or hold. This lets campaign or operational interpretation decide a security-sensitive outcome after the event.

### Governing correction

Adopt one platform-wide default:

```text
Any unsettled payout for a Referrer is held from the moment a payout-destination change request is accepted until the new method is verified, the cooling-off period ends, and the hold is explicitly released.
```

The old method remains historically active for prior settled payouts but is not used for new unsettled payouts after the accepted change request.

A narrow Finance exception may permit use of the old verified method only when:

- The Referrer explicitly requests cancellation of the change through a verified channel.
- The new method has not been activated.
- Account-takeover and risk checks are clear.
- Finance reviewer and approver authorize the exception.
- The decision is documented and audited.

Campaigns cannot override this security policy.

### Cutoff behavior

- Change request before run preparation: exclude beneficiary from run until ready.
- Change after run preparation but before approval: hold item, mutate run, and require reapproval.
- Change after approval but before provider submission: hold item, invalidate approval, and regenerate.
- Change after provider submission: do not alter submitted destination; reconcile that attempt. Place future payouts on hold and open a risk review when warranted.
- Change after reconciled payment: no effect on prior payment.

### Error handling and edge cases

- Referrer claims change was unauthorized: revoke sessions, cancel pending method, preserve evidence, and hold payouts.
- Old method is closed: hold; never retry against it.
- New method verification times out: remain held and notify Referrer without exposing provider internals.
- Multiple change requests: only latest authorized pending request may proceed; prior request is cancelled with audit.
- Change request during returned-payout recovery: restore liability and hold until valid method ready.
- Organization owner changes method while another owner disputes: freeze activation and route to ownership dispute review.
- Cooling-off expires during payout run: item may enter the next run after hold release; do not inject into an already approved run.

### Required tests

```text
PaymentMethodChangeImmediatelyHoldsUnsettledPayoutsTest
ChangeAfterApprovalInvalidatesRunTest
ChangeAfterSubmissionDoesNotRewriteAttemptTest
OldMethodExceptionRequiresDualApprovalTest
UnauthorizedChangeRecoveryTest
```

### Demonstration of resolution

Resolution is demonstrated when every unsettled payout is held after a destination change and neither the old nor new method is selected without the explicit deterministic workflow.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.21 Issue 21 — Internal-user authentication is underspecified

**Severity:** High  
**Confidence:** 97%

### Affected users and services

- Every internal human user.
- Security and Platform Engineering.
- Super Administrators.
- Finance roles.
- Risk and Fraud.
- Audit.

### How the error appears

Referrer Magic Link and step-up authentication are described in detail, while privileged internal accounts lack a complete authentication and session standard. This leaves finance, fraud, audit, and administration access open to inconsistent implementation.

### Governing correction

Apply the internal authentication requirements defined in Part I, with mandatory enterprise identity, MFA, conditional access, short privileged sessions, step-up for high-risk operations, and immediate revocation.

### Additional service controls

- Internal tokens must contain audience, issuer, actor type, authentication assurance, session ID, and expiry.
- Authorization must query current role and scope data or use short-lived claims with revocation support.
- Privileged APIs must reject Referrer and service-account tokens.
- Service-account keys must use vault-managed rotation and cannot be used interactively.
- Production access must be separated from development and test environments.

### Error handling and edge cases

- SSO group grants excessive role: platform-side approval is still required; external group alone must not assign financial permissions.
- User changes department: recertify and remove stale roles.
- MFA device lost: recovery requires controlled identity verification; no helpdesk bypass to weak authentication.
- Privileged user on unmanaged device: deny high-risk actions.
- Session token stolen: revoke session and associated refresh tokens; alert security.
- Clock skew causes token validation failure: allow narrow configured tolerance, never ignore expiry.
- Identity provider sends duplicate identity: resolve to immutable internal user ID and block ambiguous mapping.

### Required tests

```text
InternalMfaRequiredTest
UnmanagedDevicePrivilegedActionDeniedTest
ReferrerTokenPrivilegedApiDeniedTest
ServiceTokenDashboardDeniedTest
RoleRevocationSessionTest
```

### Demonstration of resolution

Resolution is demonstrated when all privileged internal actions require strong identity assurance, role revocation ends access immediately, and no weak fallback is available during identity-provider outage.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.22 Issue 22 — Event signature placement and format are insufficiently defined

**Severity:** High  
**Confidence:** 95%

### Affected users and services

- Product Integration Service Accounts.
- Platform Engineering.
- Product Owners.
- Risk and Fraud.
- Referral Operations.
- Audit.

### How the error appears

The event example places a signature in the JSON body without defining canonicalization, key identity, algorithm, timestamp binding, or replay window. JSON serialization differences can produce inconsistent signatures, and a body-contained signature cannot safely cover itself.

### Governing correction

Remove `signature` from the business event body. Sign the exact raw HTTP request body plus selected context using headers:

```text
X-Citrus-Key-Id
X-Citrus-Timestamp
X-Citrus-Signature
X-Citrus-Environment
X-Citrus-Event-Id
X-Citrus-Algorithm
```

Recommended signing input:

```text
HTTP_METHOD + "\n" + REQUEST_PATH + "\n" + TIMESTAMP + "\n" + ENVIRONMENT + "\n" + SHA256(RAW_BODY)
```

The platform must publish the exact encoding, algorithm, header normalization, and key-rotation procedure. HMAC with strong per-product secrets or asymmetric signatures may be used, but the algorithm must be explicit and versioned.

### Validation sequence

1. Read raw body without reserialization.
2. Validate required headers.
3. Resolve active key by product, environment, and key ID.
4. Validate timestamp within allowed skew.
5. Verify signature in constant time.
6. Parse schema.
7. Confirm header event ID matches body event ID.
8. Apply idempotency and replay protection.
9. Authorize event type for service account.
10. Persist validation outcome and payload hash.

### Key rotation

Support overlapping active keys during a bounded rotation window. Every accepted event records key ID and algorithm. Revoked keys are rejected immediately unless an approved incident replay process applies.

### Error handling and edge cases

- Missing signature header: reject `401 EVENT_SIGNATURE_REQUIRED`.
- Unknown key ID: reject and alert product owner.
- Expired or future timestamp: reject or quarantine according to tightly defined skew policy.
- Valid signature but wrong product identity: reject authorization.
- Header and body event IDs differ: critical integrity rejection.
- Same event ID with same body: idempotent success.
- Same event ID with different payload hash: critical alert.
- Compressed payload: define whether signature covers compressed bytes or decompressed raw body; use one documented rule.
- Proxy modifies body: signature fails; integration must preserve bytes.
- Key rotation race: accept both designated active keys during overlap.
- Manual replay: generate a new delivery attempt while preserving original event ID and payload; do not modify occurred-at.

### Required tests

```text
RawBodySignatureVerificationTest
SignatureTimestampReplayWindowTest
HeaderBodyEventIdMismatchTest
KeyRotationOverlapTest
RevokedKeyRejectedTest
SameEventDifferentBodyCriticalAlertTest
```

### Demonstration of resolution

Resolution is demonstrated when signatures are verified over exact raw bytes with key, algorithm, timestamp, environment, and event-ID binding and replay attacks fail.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.23 Issue 23 — Activity event types create conflicting authority

**Severity:** Medium  
**Confidence:** 95%

### Affected users and services

- Product Owners.
- Product Integration Service Accounts.
- Referral Operations.
- Referrer users.
- Finance roles.
- Risk and Fraud.
- Customer Support.

### How the error appears

The event catalogue contains final qualification events and an operational activity-completed event. It is unclear whether the central platform calculates active-use qualification from operational events or trusts the product's final decision. The governing architecture states that the product evaluates product-specific business logic.

### Governing correction

Separate event classes:

```text
Operational evidence events:
eligible_operational_activity_completed
merchant_branch_created
other product-specific evidence events

Final decision events:
merchant_activity_qualification_decided
```

Use one final decision event type with a decision field:

```json
{
  "decision": "qualified | not_qualified",
  "qualification_period_start": "...",
  "qualification_period_end": "...",
  "activity_rule_id": "...",
  "activity_rule_version": "...",
  "decision_version": 1,
  "supersedes_event_id": null,
  "evidence_summary": {}
}
```

The central platform may store operational evidence events for traceability or integration monitoring but must not independently derive the final product-specific decision unless the product contract explicitly assigns that calculation to a shared rule engine in a future architecture.

### Decision precedence

For one merchant, product, rule version, and period:

- Highest valid `decision_version` is current.
- A higher version must reference the superseded decision.
- Same version with different content is an integrity error.
- A reversed or corrected decision never deletes prior evidence.

### Error handling and edge cases

- Qualified and not-qualified events arrive with same decision version: quarantine and integrity alert.
- Higher version arrives first: store and use it; later lower version is historical/idempotent and cannot override.
- Decision lacks rule version: reject or hold qualification.
- Operational events meet threshold but final decision says not qualified: trust final decision and request product review; central platform does not override.
- Product corrects decision after payout: hold future payout, create reversal evaluation, and preserve both decisions.
- Evidence summary contains prohibited sensitive data: reject or redact according to schema; alert product integration owner.
- Rule version not attached to campaign attribution: hold and investigate configuration mismatch.

### Required tests

```text
FinalActivityDecisionAuthoritativeTest
SameDecisionVersionConflictTest
HigherDecisionVersionSupersedesTest
OperationalEvidenceDoesNotAutoQualifyTest
SensitiveEvidenceSchemaRejectionTest
```

### Demonstration of resolution

Resolution is demonstrated when a single versioned final activity decision controls qualification and operational evidence alone never creates a reward.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.24 Issue 24 — Multi-currency is modeled as current but deferred to Phase 3

**Severity:** High  
**Confidence:** 99%

### Affected users and services

- Super Administrators.
- Campaign Approvers.
- Finance roles.
- Referrer users.
- Tax and Compliance.
- Product Owners.
- Customer Support.

### How the error appears

The main design includes configurable currencies, exchange-rate snapshots, supported currency fields, and currency handling tests, while Phase 3 defers multi-currency. Phase 1 cannot safely pretend to support currency conversion when payout, tax, ledger, rounding, and consolidation rules are not yet implemented.

### Governing correction

Phase 1 is KES-only:

```text
platform_launch_currency = KES
campaign_currency = KES
reward_ledger_currency = KES
payout_currency = KES
```

Product events with a non-KES monetary amount cannot qualify for launch reward calculation unless the source product provides an approved KES-denominated eligible amount under a documented billing arrangement. The central platform must not improvise foreign-exchange conversion.

The schema may retain currency columns because every monetary record must always state currency, but campaign activation validates KES only.

### Error handling and edge cases

- Campaign configured in USD: block activation with `CURRENCY_NOT_SUPPORTED_AT_LAUNCH`.
- Product event sends USD for KES campaign: hold event and create currency mismatch exception.
- Referrer selects non-KES preferred currency: save as future preference only or reject selection; do not promise conversion.
- Provider settles KES payout with foreign fee: record provider fee according to finance integration; do not alter Referrer reward currency.
- Product changes billing currency mid-campaign: require new campaign version and capability review; existing attribution remains under prior supported terms.
- Cross-border Referrer: may participate only where legal, payout, tax, and KES provider rules support it.
- Rounding: retain two-decimal ledger precision and explicit payout rounding entries even where provider pays whole shillings.

### Future multi-currency prerequisites

Before enabling another currency, implement:

- Currency-specific minor units.
- rate-source governance.
- exchange-rate timestamp and type.
- conversion spread policy.
- realized and unrealized FX accounting.
- provider capability matrix.
- cross-currency thresholds.
- multi-currency statements.
- tax treatment.
- reconciliation by currency.
- no cross-currency consolidation without explicit conversion policy.

### Required tests

```text
LaunchCampaignNonKesRejectedTest
EventCurrencyMismatchHoldTest
KesOnlyConsolidationTest
WholeShillingProviderRoundingTest
```

### Demonstration of resolution

Resolution is demonstrated when non-KES campaigns and events cannot enter active reward processing and all KES balances, allocations, and provider totals reconcile.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.
## 37.25 Issue 25 — Tax requirements are used before tax support is implemented

**Severity:** High  
**Confidence:** 96%

### Affected users and services

- Tax and Compliance.
- Finance roles.
- Referrer legal entities and users.
- Super Administrators.
- Campaign Approvers.
- Privacy and Legal.
- Customer Support.
- Audit.

### How the error appears

Payout eligibility can require tax data, the ledger includes withholding, and the finance module includes tax treatment, while Phase 2 defers tax support. This can either block all Phase 1 payouts or cause payouts without legally required treatment.

### Governing correction

Tax readiness is a launch-gate decision, not an optional post-launch enhancement.

Before production payout, Citrus Labs must obtain current professional tax and legal advice for applicable jurisdictions and select one of two permitted launch modes:

#### Mode A — Minimum tax support implemented at launch

Implement:

- Tax-profile collection.
- validation status.
- jurisdiction.
- tax identifier where required.
- withholding rule version.
- threshold and exemption handling.
- withholding ledger entry.
- payout net calculation.
- tax statement or certificate where required.
- finance and audit reporting.

#### Mode B — Tax-dependent campaigns disabled

No campaign may activate where applicable law or approved policy requires tax data, withholding, or certificates that the platform cannot yet process. Payout eligibility must not contain an unreachable “required tax data complete” condition for active campaigns.

For the likely Kenya-first launch, Mode A is the safer production design, but the exact tax rate, threshold, documentation, and legal characterization must come from current qualified advice and approved configuration rather than hard-coded assumptions.

### Tax-rule versioning

Every withholding decision stores:

```text
tax_rule_id
tax_rule_version
jurisdiction
tax_profile_id
gross_reward
withholding_amount
net_payout
exemption_reference
effective_date
```

Tax-rule changes are prospective. Corrections use adjustment entries and replacement documents.

### Error handling and edge cases

- Tax identifier missing where required: hold payout, allow reward accrual, notify Referrer.
- Identifier validation service unavailable: keep verification pending; do not falsely approve.
- Referrer claims exemption: require documented review and effective dates.
- Tax status changes mid-year: apply version effective for each payout or earning according to approved policy.
- Withholding calculated incorrectly after payout: create correction, amended statement or certificate, and recovery or credit process.
- Organization changes legal form: require new tax review without deleting historical profile.
- Referrer operates in unsupported jurisdiction: block campaign participation or payout according to legal policy.
- Gross amount below threshold: apply configured rule and preserve decision evidence.
- Returned payout: reverse or adjust tax treatment according to approved accounting and legal rules; do not assume withholding automatically reverses.

### Required tests

```text
RequiredTaxProfileBlocksPayoutTest
TaxRuleVersionSnapshotTest
WithholdingLedgerAndNetPayoutTest
ExemptionEffectiveDateTest
TaxCorrectionReplacementDocumentTest
UnsupportedJurisdictionEnrollmentTest
```

### Demonstration of resolution

Resolution is demonstrated when production payout cannot occur without the selected approved tax mode and every withholding or exemption decision is versioned and reproducible.

The release evidence must include the named automated tests, relevant database or API invariant, representative audit records, and a role-appropriate user-interface or support outcome. A passing frontend demonstration without the server-side invariant does not satisfy resolution.


---

# 38. Rewriting Verification and Demonstrated Resolution

The following automated document-level consistency tests were executed against this rewritten Markdown artifact after all replacements and integrations were applied. These checks do not replace application source-code tests; they prove that the governing specification itself no longer contains the identified structural contradictions and that every correction has a traceable requirement.

## 38.1 Automated consistency test results

- **PASS — Source title retained:** The rewritten artifact remains the complete platform specification.
- **PASS — All 36 original top-level sections retained:** Sections 0 through 36 are present.
- **PASS — Correction assurance register present:** The integrated register is present.
- **PASS — All 25 correction issues present:** Issues 1 through 25 are represented.
- **PASS — Affected-user subsection present for each issue:** Each issue identifies affected users and services.
- **PASS — Resolution-demonstration subsection present for each issue:** Each issue has resolution evidence requirements.
- **PASS — KES-only launch enforced:** Currency restriction and error behavior are present.
- **PASS — Monthly-only launch enforced:** Launch frequency is explicit.
- **PASS — Attribution uniqueness corrected:** Campaign is not the earning uniqueness boundary.
- **PASS — Manual code and lock corrected:** Pre-lock choice and lock point are explicit.
- **PASS — Active use mandatory:** Every launch recurring subscription campaign requires active use.
- **PASS — Retention counters separated:** Reward and retention are independent.
- **PASS — Reconciliation required at launch:** Payout finality is tied to reconciliation.
- **PASS — Maker/checker in Phase 1:** Separation of duties is a Phase 1 requirement.
- **PASS — Statements in Phase 1:** Statements are included in production-safe launch.
- **PASS — Consolidated payouts in Phase 1:** Cross-product consolidation is included at launch.
- **PASS — Verified payment method immutable:** Append-only replacement is enforced.
- **PASS — Internal RBAC entities present:** Core RBAC data model is present.
- **PASS — Merchant reference entities present:** Central minimized merchant reference model is present.
- **PASS — Campaign enrollment entities present:** Enrollment is explicitly persisted.
- **PASS — Audit case model present:** Audit metadata is modeled separately from logs.
- **PASS — Internal strong authentication present:** Internal authentication controls are explicit.
- **PASS — Raw-body event signatures present:** Signature construction is defined.
- **PASS — Single final activity event present:** Final activity authority is unambiguous.
- **PASS — Tax launch gate present:** Tax cannot be silently deferred while payouts launch.
- **PASS — No file citation markup in artifact:** The artifact is self-contained.
- **PASS — No old Phase 2 deferral list:** Unsafe deferral block has been replaced.

## 38.2 Required implementation evidence

Before production approval, engineering and operations must attach the following evidence to the release:

- Database migration results proving the new uniqueness, immutability, foreign-key, allocation-sum, and approval constraints.
- API contract tests proving deterministic error codes, idempotency, role-safe messages, and append-only replacement workflows.
- Concurrency tests proving that competing attribution confirmations and duplicate payout submissions cannot create duplicate entitlement or payment.
- Product-integration tests proving raw-body signature verification, key rotation, replay protection, out-of-order handling, and final activity-decision authority.
- Finance tests proving maker/checker, approval invalidation, consolidation arithmetic, provider status verification, reconciliation, returns, and statement versioning.
- Authorization tests for every Referrer membership role and every internal role, permission, product scope, campaign scope, unmasking permission, and break-glass action.
- User-acceptance evidence for Referrer, Merchant Administrator, Operations, Finance, Risk, Support, Audit, Product Owner, Legal, Tax, and Engineering experiences affected by each correction.
- Production-readiness confirmation that KES-only, monthly-only, mandatory-active-use, four-consecutive-month retention, fixed-calendar duration, and tax launch-mode constraints are active in configuration and cannot be bypassed.

## 38.3 Resolution standard

A correction is fully resolved only when the governing text, database constraints, API contracts, queue consumers, user interfaces, statements, reports, support playbooks, monitoring, audit evidence, and automated tests all enforce the same invariant. Any local module that reintroduces a superseded interpretation is a release-blocking defect.
