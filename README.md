# Citrus

**Powering Smart Commerce.**

Citrus is a governed, multi-tenant SaaS commerce infrastructure designed for small and medium-sized retail and service businesses operating across both physical and digital channels.

The platform gives merchants a structured environment to execute, validate, synchronize, audit, and monetize commerce activity through a role-enforced system covering POS sales, online orders, inventory movement, customer activity, loyalty, staff governance, financial oversight, audit trails, and Citrus-controlled billing.

Citrus is not a generic POS system.  
Citrus is not a marketplace.  
Citrus is not a payment processor.  
Citrus is not a logistics platform.  
Citrus is not an ERP or full accounting system.

Citrus is a commerce operating system for governed SME execution.

---

## Table of Contents

- [Project Status](#project-status)
- [Repository](#repository)
- [Core Definition](#core-definition)
- [Commercial Purpose](#commercial-purpose)
- [Operating Philosophy](#operating-philosophy)
- [What Citrus Provides](#what-citrus-provides)
- [What Citrus Explicitly Excludes](#what-citrus-explicitly-excludes)
- [Primary Users](#primary-users)
- [Core Functional Domains](#core-functional-domains)
- [Account Architecture](#account-architecture)
- [Subdomain Structure](#subdomain-structure)
- [Technical Stack](#technical-stack)
- [Frontend Direction](#frontend-direction)
- [Backend Direction](#backend-direction)
- [Database Direction](#database-direction)
- [Authentication Direction](#authentication-direction)
- [Payment Handling Boundary](#payment-handling-boundary)
- [Security Principles](#security-principles)
- [Audit Principles](#audit-principles)
- [Development Manifesto](#development-manifesto)
- [Recommended Local Development Setup](#recommended-local-development-setup)
- [Installation](#installation)
- [Environment Variables](#environment-variables)
- [Common Development Commands](#common-development-commands)
- [Suggested Project Structure](#suggested-project-structure)
- [Domain Model Direction](#domain-model-direction)
- [Authorization Model](#authorization-model)
- [Testing Strategy](#testing-strategy)
- [Coding Standards](#coding-standards)
- [Git Workflow](#git-workflow)
- [Roadmap](#roadmap)
- [Commercial Ownership](#commercial-ownership)
- [License](#license)

---

## Project Status

Citrus is currently under active MVP Lite development.

The current priority is to build a stable, secure, role-governed, commercially realistic SaaS foundation before expanding into advanced automation, analytics, integrations, and enterprise-level functionality.

The MVP Lite version focuses on:

- Clean multi-tenant architecture.
- Strict role separation.
- Branch-aware operations.
- POS and online order execution.
- Inventory synchronization.
- Payment validation.
- Customer and loyalty visibility.
- Staff governance.
- Citrus billing enforcement.
- Immutable audit trails.
- Secure authentication.
- Developer discipline through evidence-based debugging and testing.

---

## Repository

```bash
https://github.com/ikrome002-design/citrus.git
```

Recommended repository visibility during MVP development:

```text
Private
```

Reason:

Citrus contains commercial SaaS architecture, platform monetization logic, merchant governance rules, role boundaries, billing enforcement models, and proprietary business workflows. Keeping the repository private protects the platform until the product, legal structure, licensing, and deployment strategy are mature.

---

## Core Definition

Citrus is a multi-tenant SaaS commerce infrastructure that acts as the operational backbone for SMEs.

It helps merchants execute and record:

- In-store sales.
- Online orders.
- Inventory movements.
- Customer activity.
- Loyalty events.
- Staff operations.
- Branch-level activity.
- Payment validation.
- Citrus service fee billing.
- Audit-linked system activity.

Citrus is designed around structural discipline.

Every merchant, branch, user, transaction, stock movement, payment validation, loyalty action, billing event, and audit record must belong to a clear authority boundary.

No role should have uncontrolled access.

No action should happen without attribution.

No commercial activity should bypass validation, auditability, and billing logic.

---

## Commercial Purpose

Citrus exists to help small and medium-sized businesses digitize commerce without creating operational chaos.

The platform is commercially designed to:

- Generate recurring SaaS revenue.
- Monetize merchant activity through platform-controlled service fees.
- Support fixed or percentage-based Citrus service billing.
- Enforce billing compliance through system restrictions.
- Reduce merchant operational leakage.
- Increase transaction visibility.
- Standardize staff accountability.
- Improve inventory accuracy.
- Strengthen customer retention.
- Provide SMEs with enterprise-like operating discipline without ERP complexity.

Citrus is built to become a long-term commerce infrastructure layer for African SMEs.

---

## Operating Philosophy

Citrus is built on one non-negotiable principle:

> Commercial activity must be executed, validated, recorded, audited, and billed inside a governed system.

This means:

- Payments are validated, not processed.
- Transactions are immutable.
- Roles are structurally separated.
- Branches are independently attributable.
- Staff actions are role-attributed.
- Audit trails are permanent.
- Billing enforcement is system-level.
- Merchant data is tenant-isolated.
- Customer data is handled with clear access boundaries.
- No account role should quietly become omnipotent.

Citrus is intentionally strict.

That strictness is the foundation of trust, auditability, billing integrity, and long-term scalability.

---

## What Citrus Provides

Citrus provides the following platform-level capabilities:

### Multi-Tenant SaaS Foundation

Each merchant operates as an isolated tenant with its own:

- Merchant profile.
- Branches.
- Staff users.
- Customers.
- Products.
- Orders.
- Payments.
- Inventory.
- Loyalty records.
- Billing records.
- Audit logs.

Tenant data must not leak across merchants.

### Branch-Aware Execution

Merchants may operate one or multiple branches.

The following activity must be branch-attributed:

- Sales.
- Online orders.
- Stock movements.
- Staff actions.
- Customer activity.
- Loyalty events.
- Expenses.
- Billing visibility.
- Reports.
- Audit logs.

Branch attribution prevents ambiguity and supports clear accountability.

### Role-Based Access Control

Citrus uses strict role-based access control across all accounts.

The platform separates:

- Governance.
- Execution.
- Finance.
- Growth.
- Customer Experience.
- Inventory.
- Human Resource.
- Audit.
- Cashiering.
- Customer access.

No role should have unlimited authority.

### Unified Transaction Engine

Citrus synchronizes:

- POS sales.
- Online orders.
- Inventory deductions.
- Payment validation.
- Receipt generation.
- Customer order history.
- Loyalty accrual.
- Citrus service fee billing.
- Audit trail creation.

### Citrus-Controlled Billing

Citrus includes a monetization layer that supports:

- Fixed service fees.
- Percentage-based service fees.
- Weekly billing cycles.
- Branch-specific billing.
- Merchant-wide billing.
- Airtime-related billing.
- Billing enforcement.
- Account restriction logic.
- Billing audit records.

### Audit-Complete System Activity

Every critical system action should be:

- Timestamped.
- User-attributed.
- Role-attributed.
- Branch-attributed where applicable.
- Tenant-attributed.
- Immutable.
- Searchable.
- Exportable where authorized.

---

## What Citrus Explicitly Excludes

Citrus deliberately excludes the following from MVP Lite scope:

- Direct payment processing.
- Holding customer funds.
- Acting as a bank.
- Acting as a payment service provider.
- Cross-merchant marketplace aggregation.
- Delivery fleet management.
- Logistics management.
- Full ERP functionality.
- Full double-entry accounting.
- Statutory tax filing.
- Payroll disbursement.
- Bank transfers.
- Automated procurement.
- Deep enterprise BI.
- Cross-merchant benchmarking.
- jQuery-based frontend development.

These exclusions protect the MVP from scope creep.

Citrus should first become an excellent governed commerce execution system before expanding into adjacent functionality.

---

## Primary Users

Citrus supports multiple account types with intentionally separated authority boundaries.

### Platform-Level Users

- Super Administrator

### Merchant-Level Users

- Merchant Administrator
- Branch Account User
- Cashier
- Inventory Manager
- Finance Officer
- Human Resource Officer
- Growth Officer
- Customer Experience Officer
- Audit Read-Only User

### Customer-Level Users

- Registered Customer
- Guest Customer, where supported

---

## Core Functional Domains

### 1. Sales and POS Engine

The Sales and POS Engine handles commercial transaction execution.

Core responsibilities:

- In-store sales.
- Online order capture.
- Cart handling.
- Receipt generation.
- Invoice generation.
- Product availability validation.
- Payment reference capture.
- Payment validation status.
- Inventory deduction after valid transaction state.
- Loyalty event triggering.
- Citrus service fee calculation.
- Transaction audit logging.

The Sales and POS Engine must not bypass inventory, billing, payment validation, or audit rules.

---

### 2. Online Storefront

The online storefront gives each merchant a digital commerce presence.

Core responsibilities:

- Display merchant products or services.
- Show product availability.
- Support customer browsing.
- Support customer cart and checkout flows.
- Support guest or registered customer ordering.
- Generate order records.
- Link orders to merchant and branch scope.
- Support customer receipt access.
- Trigger inventory and loyalty workflows.

The storefront must not behave like a cross-merchant marketplace unless that scope is intentionally introduced later.

---

### 3. Inventory Management

Inventory Management is responsible for stock truth.

Core responsibilities:

- Product creation.
- Product lifecycle control.
- SKU management.
- Barcode or QR code association.
- Product categories.
- Supplier records.
- Stock-in recording.
- Stock-out recording.
- Stock adjustments.
- Low-stock alerts.
- Out-of-stock visibility.
- Inventory reports.
- Stock movement audit logs.

Inventory Management must not own:

- Pricing strategy.
- Discounts.
- Sales execution.
- Customer communication.
- Finance approval.
- Supplier payment.
- Procurement contracts.

---

### 4. Customer Layer

The Customer Layer supports customer identity, visibility, and experience.

Core responsibilities:

- Customer profiles.
- Customer order history.
- Customer receipts.
- Customer invoices.
- Loyalty visibility.
- Communication preferences.
- Customer activity status.
- Customer feedback where supported.

Customer records must be protected from unnecessary access by roles that do not require customer-level visibility.

---

### 5. Loyalty Engine

The Loyalty Engine supports customer retention.

Core responsibilities:

- Loyalty membership.
- Loyalty tiers.
- Points earning.
- Points redemption.
- Points expiry.
- Loyalty activity ledger.
- Loyalty-related customer notifications.
- Tier progression visibility.
- Auditability of loyalty actions.

Loyalty mechanics must not be manually manipulated by Customer Experience users.

---

### 6. Finance and Reconciliation

Finance provides financial truth and reconciliation visibility.

Core responsibilities:

- Revenue summaries.
- Payment reconciliation.
- Unmatched payment detection.
- Duplicate payment detection.
- Variance detection.
- Branch-level financial reports.
- Profit overview.
- Citrus invoice visibility.
- Billing settlement tracking.
- Financial anomaly alerts.

Finance must not create campaigns, edit promotions, manipulate customer journeys, or perform cashier activity.

---

### 7. Citrus Billing and Monetization

Citrus Billing is the platform-controlled monetization layer.

Core responsibilities:

- Service fee calculation.
- Fixed charge models.
- Percentage charge models.
- Billing cycles.
- Invoice generation.
- Due date tracking.
- Payment validation status.
- Overdue billing flags.
- Merchant or branch restriction indicators.
- Billing enforcement audit logs.

Billing rules originate from the platform layer and should not be editable by merchant staff.

---

### 8. Human Resource Governance

Human Resource is responsible for people governance.

Core responsibilities:

- Staff onboarding.
- Staff profile management.
- Role assignment.
- Branch assignment.
- Employment status.
- Attendance and shifts.
- Leave management.
- Performance and KPI visibility.
- Payroll preparation inputs.
- HR reports.
- HR audit logs.

HR must not execute sales, send customer messages, approve finance transactions, or manipulate inventory.

---

### 9. Customer Experience

Customer Experience manages customer communication and trust.

Core responsibilities:

- Customer engagement visibility.
- Customer segmentation.
- Customer messaging.
- Campaigns.
- Loyalty experience communication.
- Feedback and trust signals.
- Journeys.
- CX analytics.
- CX inbox.
- Airtime usage visibility.
- CX audit and compliance records.

CX must not execute refunds, edit orders, process payments, modify pricing, adjust loyalty points, or manipulate feedback.

---

### 10. Growth

Growth supports commercial expansion activities.

Core responsibilities:

- Leads.
- Promotions.
- Quotations.
- Campaign performance.
- Loyalty-driven growth visibility.
- Revenue expansion workflows.
- Growth-linked reporting.
- Commission-related activity visibility.

Growth must not control inventory, approve payments, override finance records, or manipulate audit logs.

---

### 11. Audit

Audit provides read-only oversight.

Core responsibilities:

- System action visibility.
- Security event logs.
- Billing event logs.
- Branch activity logs.
- Staff action logs.
- Customer-related audit records.
- Growth audit records.
- CX audit records.
- Finance audit records.
- Inventory audit records.
- Exportable audit evidence.

Audit must not edit, delete, approve, execute, reverse, or configure operational actions.

---

## Account Architecture

### Super Administrator Account

The Super Administrator Account is the highest authority within the Citrus platform.

It is owned and operated by Citrus Labs Limited.

Purpose:

- Platform-wide governance.
- Merchant oversight.
- Branch oversight.
- Staff oversight.
- Customer oversight.
- Billing rule control.
- Citrus service fee reconciliation.
- Platform security monitoring.
- Audit visibility.
- Policy enforcement.
- Account restriction and reinstatement governance.

The Super Administrator governs without executing merchant operations.

Key pages:

- Dashboard
- Merchants
- Branches
- Customers
- Staff
- Finance
- Growth
- Audit
- Notifications
- User Profile

The Super Administrator should not act as a merchant cashier, merchant inventory officer, merchant CX officer, or merchant finance officer.

---

### Merchant Administrator Account

The Merchant Administrator Account is the highest authority inside a merchant tenant.

Purpose:

- Merchant organization setup.
- Branch creation.
- Staff account governance.
- Role assignment supervision.
- Governance rule enforcement.
- Structural oversight.
- Compliance visibility.
- Merchant-wide activity supervision.

Key pages:

- Dashboard
- Accounts
- Structure
- Governance
- Supervision
- Audit
- Notifications
- My Profile

The Merchant Administrator governs the merchant environment but does not participate in daily execution such as cashiering, inventory movement, customer messaging, or finance reconciliation.

---

### Branch Account

The Branch Account governs one specific branch.

Purpose:

- Branch-level supervision.
- Branch profile visibility.
- Staff lifecycle oversight.
- Branch structure visibility.
- Branch activity monitoring.
- Branch performance visibility.
- Branch finance visibility.
- Branch audit visibility.
- Account status monitoring.
- Branch notifications.
- Branch logs.

Key pages:

- Dashboard
- Branch Profile
- Staff
- Structure
- Activity
- Performance
- Finance
- Audit
- Account Status
- Notifications
- Logs

The Branch Account oversees branch activity without executing sales, payments, stock movements, or customer engagement.

---

### Cashier Account

The Cashier Account executes sales.

Purpose:

- Process in-store sales.
- Validate cart items.
- Capture customer details where required.
- Generate receipts.
- Capture payment references.
- Trigger inventory deduction.
- Trigger loyalty events.
- Support transaction reversals only where policy allows.
- Maintain cashier-level transaction records.

Typical pages:

- Dashboard
- POS
- Orders
- Customers
- Receipts
- Payment Validation
- Shift Summary
- Notifications
- User Profile

The Cashier Account must not control pricing rules, inventory configuration, staff accounts, finance reconciliation, or audit records.

---

### Inventory Management Account

The Inventory Management Account is responsible for product and stock integrity.

Purpose:

- Product lifecycle management.
- SKU and barcode management.
- Stock-in recording.
- Stock-out recording.
- Stock adjustment.
- Supplier visibility.
- Category management.
- Stock reporting.
- Low-stock and out-of-stock notifications.

Key pages:

- Dashboard
- Products
- Stock Movement
- Suppliers
- Categories
- Reports
- Notifications
- User Profile

Inventory Management executes stock operations but does not execute sales, customer messaging, finance approvals, or promotions.

---

### Finance Account

The Finance Account owns financial visibility and reconciliation.

Purpose:

- Revenue overview.
- Payment matching.
- Reconciliation.
- Expense visibility.
- Citrus billing visibility.
- Financial reports.
- Finance notifications.
- Finance profile management.

Key pages:

- Dashboard
- Payments and Reconciliation
- Revenue and Analytics
- Expenses
- Citrus Billing
- Reports
- Notifications
- User Profile

Finance is the financial truth layer but does not execute sales, campaigns, inventory changes, or customer experience actions.

---

### Human Resource Account

The Human Resource Account governs staff lifecycle and workforce accountability.

Purpose:

- Employee management.
- Role assignment.
- Branch allocation.
- Attendance and shifts.
- Leave management.
- Performance and KPIs.
- Payroll preparation.
- HR reports and analytics.
- HR notifications.

Key pages:

- Dashboard
- Employee Management
- Attendance and Shifts
- Leave Management
- Performance and KPIs
- Payroll
- Reports and Analytics
- Notifications
- My Profile

HR prepares payroll inputs but does not disburse salaries or perform financial execution.

---

### Growth Account

The Growth Account drives merchant growth activities.

Purpose:

- Lead tracking.
- Promotions.
- Quotations.
- Campaigns.
- Loyalty-linked growth actions.
- Conversion tracking.
- Growth reports.
- Commission visibility.
- Growth notifications.

Typical pages:

- Dashboard
- Leads
- Campaigns
- Promotions
- Quotations
- Loyalty Growth
- Reports
- Notifications
- User Profile

Growth must operate with inventory awareness but without inventory authority.

---

### Customer Experience Account

The Customer Experience Account manages communication, relationship continuity, and customer trust.

Purpose:

- Customer visibility.
- Segmentation.
- Messaging.
- Campaigns.
- Loyalty experience.
- Feedback and trust monitoring.
- Journeys.
- CX analytics.
- CX inbox.
- Airtime and billing visibility.
- Audit and compliance visibility.

Key pages:

- Dashboard
- Customers
- Segmentation
- Messaging
- Campaigns
- Loyalty Experience
- Feedback and Trust
- Journeys
- Analytics
- CX Inbox
- Airtime and Billing
- Audit and Compliance
- Notifications
- User Profile

CX must not perform payment handling, refunds, order changes, pricing manipulation, or loyalty point adjustments.

---

### Audit Read-Only Account

The Audit Account provides independent read-only visibility.

Purpose:

- Review system activity.
- Inspect role actions.
- Validate compliance.
- Review transaction references.
- Review finance records.
- Review inventory activity.
- Review CX and Growth activity.
- Export audit-safe records where allowed.
- Support dispute resolution.

Typical pages:

- Dashboard
- Audit Reports
- Activity Logs
- Transactions
- Compliance
- Data Export
- Notifications
- User Profile

Audit has no execution authority.

---

### Customer Account

The Customer Account allows customers to interact with merchant storefronts.

Purpose:

- Browse merchant storefronts.
- Place orders.
- View order status.
- View receipts.
- View invoices.
- View loyalty points.
- Manage profile information.
- Manage communication preferences.

Typical pages:

- Home
- Storefronts
- Orders
- Receipts
- Invoices
- Loyalty
- Notifications
- Profile

Customer accounts must not expose merchant internal operations.

---

## Subdomain Structure

Recommended Citrus subdomain direction:

```text
citrus.ke                         Customer-facing access point
citrus.citruslabs.limited         Super Administrator portal

administrator.citrus.ke           Merchant Administrator portal
branch.citrus.ke                  Branch Account portal
cashier.citrus.ke                 Cashier portal
inventory.citrus.ke               Inventory Management portal
finance.citrus.ke                 Finance portal
hr.citrus.ke                      Human Resource portal
growth.citrus.ke                  Growth portal
cx.citrus.ke                      Customer Experience portal
audit.citrus.ke                   Audit Read-Only portal
```

Subdomain access should be enforced with:

- Tenant resolution.
- Role validation.
- Session validation.
- Device validation where implemented.
- Permission checks.
- Audit logging.

---

## Technical Stack

### Recommended Stack

| Layer | Technology |
|---|---|
| Backend | Laravel / PHP |
| Frontend Framework | Vue.js |
| Frontend Language | TypeScript |
| Styling | Tailwind CSS |
| Build Tool | Vite |
| Database | MySQL for MVP, PostgreSQL-ready architecture |
| API Authentication | Laravel Sanctum |
| API Style | REST API first |
| Payment Handling | M-Pesa / PesaLink validation |
| Authorization | Laravel Policies, Gates, Middleware, Role Permissions |
| Queue Processing | Laravel Queues |
| Caching | Laravel Cache / Redis-ready |
| Storage | Laravel Filesystem |
| Testing | PHPUnit / Pest-compatible structure |
| Frontend State | Pinia or Vue composables |
| Frontend Routing | Vue Router where SPA sections require it |

---

## Frontend Direction

JavaScript is essential for Citrus.

However, jQuery must not be used for this project.

Citrus should use modern JavaScript with TypeScript.

Frontend direction:

- Use Vue.js.
- Use TypeScript where practical.
- Use Tailwind CSS.
- Use Vite.
- Build components, not jQuery-driven DOM scripts.
- Use reusable layouts.
- Use typed API responses.
- Use clear loading, empty, error, and success states.
- Use accessible UI patterns.
- Avoid frontend business logic that should belong to Laravel services.

Why Vue.js is the recommended first choice:

- It works naturally with Laravel.
- It supports fast MVP execution.
- It is easier to maintain than jQuery-driven UI.
- It supports component-based development.
- It is suitable for role-specific dashboards and portals.

---

## Backend Direction

Laravel is the backend foundation for Citrus.

Backend responsibilities:

- Tenant resolution.
- Authentication.
- Authorization.
- Role enforcement.
- API responses.
- Business workflows.
- Transaction validation.
- Payment reference validation.
- Inventory synchronization.
- Billing calculation.
- Audit logging.
- Notifications.
- Report generation.
- Background jobs.

Laravel should remain the source of truth for business rules.

The frontend should not decide:

- Whether a role may perform an action.
- Whether a transaction is valid.
- Whether billing applies.
- Whether inventory should be deducted.
- Whether a customer earns loyalty points.
- Whether a user can access a branch.
- Whether an audit event should be created.

Those decisions belong on the backend.

---

## Database Direction

Citrus should start with MySQL for MVP unless production requirements clearly demand PostgreSQL earlier.

Recommended MVP database:

```text
MySQL
```

Recommended future-ready direction:

```text
PostgreSQL-compatible schema discipline
```

Database design should support:

- Multi-tenancy.
- Merchant isolation.
- Branch attribution.
- Role attribution.
- Immutable transaction records.
- Stock movement ledgers.
- Payment validation records.
- Citrus billing records.
- Customer loyalty ledgers.
- Audit logs.
- Soft deletes where historical continuity is required.
- Strict foreign keys where practical.
- Indexing for tenant, branch, role, status, and date filters.

---

## Authentication Direction

Citrus should use secure authentication designed for SaaS portals.

Recommended MVP authentication:

- Laravel Sanctum.
- OTP-based login where implemented.
- Email or phone verification.
- Session expiration.
- Role-based portal access.
- Device/session visibility.
- Optional device binding.
- Auto-logout per role class.

Suggested session timeout direction:

| Account Type | Suggested Timeout |
|---|---:|
| Super Administrator | 5 minutes |
| Merchant Accounts | 10 minutes |
| Customer Accounts | Longer, based on UX requirements |

Authentication must always be backed by server-side authorization checks.

---

## Payment Handling Boundary

Citrus validates payments.

Citrus does not process payments.

This means Citrus may:

- Capture M-Pesa references.
- Capture PesaLink references.
- Validate payment status through approved workflows or integrations.
- Match payments to transactions.
- Flag unmatched payments.
- Flag duplicate references.
- Mark transactions as pending, validated, failed, disputed, or reversed where applicable.
- Trigger receipts after validated payment state where required.

Citrus must not:

- Hold funds.
- Settle funds.
- Act as a bank.
- Act as a payment service provider.
- Store unnecessary sensitive payment credentials.
- Bypass external payment channel rules.

---

## Security Principles

Citrus must follow these security principles:

- No shared staff accounts.
- No unrestricted admin roles.
- No cross-tenant data access.
- No cross-branch access without explicit permission.
- No role self-escalation.
- No editable audit logs.
- No silent deletion of transaction records.
- No exposed `.env` files.
- No committed secrets.
- No customer PII exposure to unauthorized roles.
- No financial data exposure to CX roles.
- No inventory manipulation by Growth or CX roles.
- No frontend-only access control.
- No jQuery-based legacy scripting.
- No direct database changes by users.
- No production debug mode.

---

## Audit Principles

Auditability is a core Citrus requirement.

Every sensitive action should create an audit record.

Audit records should include:

- User ID.
- Role ID.
- Merchant ID.
- Branch ID where applicable.
- Action type.
- Affected resource.
- Previous value where appropriate.
- New value where appropriate.
- Timestamp.
- IP address where appropriate.
- Device/session reference where appropriate.
- System-generated reference ID.
- Severity level where appropriate.

Audit logs must be:

- Immutable.
- Searchable.
- Filterable.
- Exportable by authorized users.
- Read-only.
- Permanently retained according to policy.

---

## Development Manifesto

Citrus development must follow an evidence-first engineering discipline.

### 1. Prove the Problem

The developer or agent must never guess.

Every issue identified must be backed by clear evidence that a problem truly exists.

Acceptable evidence includes:

- Error messages.
- Stack traces.
- Failed tests.
- Broken UI state.
- Incorrect database records.
- Incorrect API responses.
- Reproducible steps.
- Logs.
- Screenshots.
- Validation failures.
- Unexpected system behavior.

No fix should be applied before the problem is proven.

---

### 2. Root Cause Analysis

Before fixing, the actual root cause must be identified.

The developer must determine whether the issue is caused by:

- Routing.
- Middleware.
- Authentication.
- Authorization.
- Validation.
- Service logic.
- Database schema.
- Data relationship.
- Frontend state.
- API response shape.
- Build configuration.
- Environment configuration.
- Queue job failure.
- Cache inconsistency.
- Incorrect test assumption.

Do not patch symptoms.

Fix the cause.

---

### 3. Fix With Precision

Every fix must directly address the proven root cause.

Avoid:

- Random code changes.
- Broad rewrites without evidence.
- Removing validation to make an error disappear.
- Weakening authorization for convenience.
- Disabling tests.
- Hiding errors.
- Commenting out important logic.
- Creating duplicate logic.
- Adding frontend workarounds for backend failures.

A good fix should be narrow, explainable, testable, and consistent with the architecture.

---

### 4. Test Thoroughly

After fixing, tests must be run to confirm the solution works.

Testing may include:

- Unit tests.
- Feature tests.
- API tests.
- Authorization tests.
- Tenant isolation tests.
- Branch scope tests.
- Role permission tests.
- Browser checks.
- Build checks.
- Manual verification for UI flows.

A fix is not complete until the corrected behavior is verified.

---

### 5. Demonstrate Resolution

After testing, the developer must show proof that the problem is resolved.

Proof may include:

- Passing test output.
- Correct API response.
- Correct UI behavior.
- Correct database state.
- Correct audit log.
- Correct transaction state.
- Correct role restriction.
- Correct build result.

The expected final answer for any bug fix should include:

```text
Problem proven:
Root cause:
Fix applied:
Tests run:
Resolution proof:
Remaining risk:
```

---

## Recommended Local Development Setup

Install the following:

- PHP 8.2 or newer.
- Composer.
- Node.js LTS.
- npm.
- MySQL 8.x.
- Git.
- Laravel CLI where needed.
- A code editor such as Visual Studio Code.
- A local mail testing tool where needed.
- Optional Redis for queues/cache later.

---

## Installation

Clone the repository:

```bash
git clone https://github.com/ikrome002-design/citrus.git
cd citrus
```

Install PHP dependencies:

```bash
composer install
```

Install JavaScript dependencies:

```bash
npm install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the Laravel app key:

```bash
php artisan key:generate
```

Configure your database in `.env`.

Run migrations:

```bash
php artisan migrate
```

Run seeders where available:

```bash
php artisan db:seed
```

Start the Laravel development server:

```bash
php artisan serve
```

Start the Vite development server:

```bash
npm run dev
```

---

## Environment Variables

The `.env` file must never be committed.

Basic MVP environment example:

```env
APP_NAME=Citrus
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citrus
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=localhost

CACHE_STORE=database
QUEUE_CONNECTION=database

SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
FRONTEND_URL=http://localhost:5173

MAIL_MAILER=log
MAIL_FROM_ADDRESS=no-reply@citrus.ke
MAIL_FROM_NAME="${APP_NAME}"
```

Future production variables should include secure values for:

- OTP provider.
- SMS provider.
- Email provider.
- M-Pesa validation.
- PesaLink validation.
- Queue driver.
- Cache driver.
- File storage.
- Logging.
- Monitoring.
- Error tracking.
- Domain/session configuration.
- Tenant resolution rules.

---

## Common Development Commands

Run Laravel server:

```bash
php artisan serve
```

Run Vite:

```bash
npm run dev
```

Build frontend assets:

```bash
npm run build
```

Run migrations:

```bash
php artisan migrate
```

Rollback migrations:

```bash
php artisan migrate:rollback
```

Fresh migration with seed:

```bash
php artisan migrate:fresh --seed
```

Run tests:

```bash
php artisan test
```

Clear framework caches:

```bash
php artisan optimize:clear
```

Queue worker:

```bash
php artisan queue:work
```

Format frontend code where configured:

```bash
npm run format
```

Lint frontend code where configured:

```bash
npm run lint
```

---

## Suggested Project Structure

Recommended Laravel domain-oriented structure:

```text
app/
├── Actions/
├── Domains/
│   ├── Audit/
│   ├── Billing/
│   ├── Branches/
│   ├── Cashier/
│   ├── Customers/
│   ├── CX/
│   ├── Finance/
│   ├── Growth/
│   ├── HR/
│   ├── Inventory/
│   ├── Loyalty/
│   ├── Merchants/
│   ├── Notifications/
│   ├── Payments/
│   ├── POS/
│   ├── Reports/
│   ├── Sales/
│   ├── Security/
│   ├── Tenancy/
│   └── Users/
├── Enums/
├── Events/
├── Exceptions/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   └── Resources/
├── Jobs/
├── Listeners/
├── Models/
├── Notifications/
├── Policies/
├── Providers/
├── Services/
└── Support/
```

Recommended frontend structure:

```text
resources/
├── css/
│   └── app.css
├── js/
│   ├── app.ts
│   ├── bootstrap.ts
│   ├── components/
│   ├── composables/
│   ├── layouts/
│   ├── pages/
│   │   ├── auth/
│   │   ├── super-admin/
│   │   ├── merchant-admin/
│   │   ├── branch/
│   │   ├── cashier/
│   │   ├── inventory/
│   │   ├── finance/
│   │   ├── hr/
│   │   ├── growth/
│   │   ├── cx/
│   │   ├── audit/
│   │   └── customer/
│   ├── router/
│   ├── stores/
│   ├── types/
│   └── utils/
└── views/
```

---

## Domain Model Direction

Recommended core models:

```text
Tenant / Merchant
Branch
User
Role
Permission
StaffProfile
Customer
Product
Category
Supplier
StockMovement
Order
OrderItem
Transaction
PaymentValidation
Receipt
Invoice
LoyaltyAccount
LoyaltyLedger
CitrusBillingRule
CitrusInvoice
CitrusInvoiceItem
AuditLog
Notification
Message
Campaign
Journey
Feedback
ReportExport
```

Recommended attribution columns for sensitive records:

```text
merchant_id
branch_id
user_id
role_id
created_by
updated_by
approved_by
voided_by
reference_code
status
source
metadata
created_at
updated_at
deleted_at
```

Recommended immutable record classes:

- Transactions.
- Payment validations.
- Stock movements.
- Loyalty ledger entries.
- Citrus invoices.
- Audit logs.
- Receipt records.
- Report exports.
- CX message logs.

---

## Authorization Model

Citrus authorization must be backend-enforced.

Recommended layers:

### 1. Authentication Middleware

Confirms the user is logged in.

### 2. Tenant Middleware

Confirms the user belongs to the resolved merchant tenant.

### 3. Branch Middleware

Confirms the user can access the requested branch.

### 4. Role Middleware

Confirms the user has the required role.

### 5. Permission Policy

Confirms the user can perform the specific action on the specific resource.

### 6. Audit Middleware or Service

Logs sensitive access or action events where required.

Example authorization rule:

```text
A CX user may view a customer experience profile within their branch,
but may not view payment history, issue refunds, edit pricing, or adjust loyalty points.
```

Example enforcement layers:

```text
auth:sanctum
resolve.tenant
ensure.branch.scope
ensure.role:cx
can:viewCxCustomerProfile,customer
audit.access
```

---

## Testing Strategy

Citrus must test governance, not only functionality.

Core test categories:

### Authentication Tests

- User can request OTP.
- User can verify OTP.
- Invalid OTP is rejected.
- Expired OTP is rejected.
- Locked users cannot log in.
- Suspended users cannot access portals.

### Tenant Isolation Tests

- Merchant A cannot access Merchant B data.
- Branch A cannot access Branch B data unless permitted.
- Customer records do not leak across merchants.
- Staff records are tenant-scoped.

### Role Authorization Tests

- Super Admin can govern platform records.
- Merchant Administrator can govern merchant structure.
- Branch Account can view branch oversight data.
- Cashier can execute sales only.
- Inventory can manage stock but not prices.
- Finance can reconcile payments but not send CX campaigns.
- HR can manage staff but not execute sales.
- CX can communicate but not process refunds.
- Growth can create campaigns/promotions but not adjust stock.
- Audit can view but not edit.

### Transaction Tests

- Order creates transaction record.
- Validated payment updates transaction state.
- Failed payment does not complete transaction.
- Receipt is generated only after correct transaction state.
- Transaction is audit logged.

### Inventory Tests

- Sale deducts stock.
- Stock-in increases stock.
- Stock adjustment requires reason code.
- Historical stock movements cannot be edited.
- Out-of-stock products cannot be sold unless policy allows backorder.

### Billing Tests

- Citrus service fee is calculated correctly.
- Fixed service fee works.
- Percentage service fee works.
- Weekly invoice can be generated.
- Overdue invoice triggers restriction state.
- Paid invoice restores allowed access where policy permits.

### Audit Tests

- Sensitive actions create audit logs.
- Audit logs are immutable.
- Audit users cannot edit records.
- Deleted entities retain historical trace where required.

### Frontend Build Tests

- TypeScript compiles.
- Vite build completes.
- Critical dashboard pages load.
- Role navigation does not expose unauthorized links.

Run backend tests:

```bash
php artisan test
```

Run frontend build:

```bash
npm run build
```

---

## Coding Standards

### Backend Standards

- Use Laravel conventions.
- Use service classes for business logic.
- Use policies for authorization.
- Use form requests for validation.
- Use API resources for responses.
- Use enums for statuses and role names.
- Use transactions for multi-step database operations.
- Use events for audit-worthy workflows.
- Use queues for slow or external tasks.
- Avoid fat controllers.
- Avoid duplicated business logic.
- Avoid direct database writes outside controlled services.

### Frontend Standards

- Use Vue components.
- Use TypeScript types.
- Use composables for shared logic.
- Use Tailwind utility classes consistently.
- Avoid jQuery.
- Avoid direct DOM manipulation where Vue state should be used.
- Handle loading states.
- Handle empty states.
- Handle validation errors.
- Handle authorization errors.
- Handle expired sessions.
- Keep portal layouts role-specific.

### Database Standards

- Use clear table names.
- Use foreign keys where practical.
- Use indexes for tenant, branch, status, and date filters.
- Use soft deletes where historical continuity matters.
- Use immutable ledgers for financial, stock, loyalty, and audit records.
- Never use ambiguous ownership fields.
- Always preserve attribution.

---

## Git Workflow

Recommended branches:

```text
main
develop
feature/<feature-name>
fix/<bug-name>
release/<version>
hotfix/<issue-name>
```

Recommended commit style:

```text
Add merchant tenant model
Create inventory stock movement ledger
Fix cashier payment validation status handling
Refactor Citrus billing calculation service
Add audit logs for inventory adjustments
```

Before pushing:

```bash
php artisan test
npm run build
git status
```

Commit:

```bash
git add .
git commit -m "Add Citrus README documentation"
git push origin main
```

---

## Roadmap

### Phase 1: Foundation

- Laravel project setup.
- Vue + TypeScript + Vite setup.
- Tailwind CSS setup.
- Authentication foundation.
- User model.
- Role model.
- Permission model.
- Merchant model.
- Branch model.
- Tenant resolution.
- Base dashboard layouts.
- Audit log foundation.

### Phase 2: Merchant Governance

- Super Administrator portal.
- Merchant onboarding.
- Merchant Administrator portal.
- Branch creation.
- Staff creation.
- Role assignment.
- Branch scope enforcement.
- Notifications foundation.

### Phase 3: POS and Sales

- Product catalog.
- POS interface.
- Cart.
- Orders.
- Transactions.
- Receipts.
- Payment reference capture.
- Payment validation status.
- Basic reports.

### Phase 4: Inventory

- Products.
- Categories.
- Suppliers.
- Stock-in.
- Stock-out.
- Adjustments.
- Stock ledger.
- Low-stock alerts.
- Inventory reports.

### Phase 5: Customer and Loyalty

- Customer accounts.
- Customer order history.
- Loyalty account.
- Loyalty ledger.
- Points earning.
- Points redemption.
- Points expiry.
- Customer notifications.

### Phase 6: Finance and Billing

- Finance dashboard.
- Payment reconciliation.
- Citrus service fee rules.
- Citrus invoice generation.
- Billing cycles.
- Billing enforcement.
- Finance reports.
- Exportable summaries.

### Phase 7: HR

- Employee management.
- Attendance.
- Shifts.
- Leave management.
- Performance and KPIs.
- Payroll preparation.
- HR reports.

### Phase 8: CX and Growth

- Customer Experience dashboard.
- Messaging.
- Segmentation.
- Campaigns.
- Feedback and trust.
- Customer journeys.
- Growth leads.
- Growth campaigns.
- Growth reports.

### Phase 9: Audit Hardening

- Audit dashboards.
- Advanced filtering.
- Export controls.
- Risk severity.
- Compliance reports.
- Immutable evidence records.

### Phase 10: Production Readiness

- Security hardening.
- Monitoring.
- Error tracking.
- Queue workers.
- Backups.
- Deployment pipeline.
- Production environment variables.
- Domain and subdomain configuration.
- Performance optimization.

---

## Commercial Ownership

Citrus is owned and developed by Citrus Labs Limited.

All source code, architecture, workflows, interface concepts, business logic, billing models, user account structures, documentation, and related materials are proprietary unless expressly stated otherwise.

Unauthorized copying, redistribution, resale, deployment, modification, or commercial use is prohibited without written permission from Citrus Labs Limited.

---

## License

This project is proprietary software.

All rights reserved by Citrus Labs Limited.

Recommended license file:

```text
Proprietary License
Copyright (c) 2026 Citrus Labs Limited.
All rights reserved.
```

---

## Final Positioning

Citrus is a governed, production-focused SaaS commerce infrastructure.

It is:

- Multi-tenant.
- Branch-aware.
- Role-enforced.
- Billing-driven.
- Audit-complete.
- Laravel-powered.
- Vue-ready.
- TypeScript-ready.
- Tailwind-ready.
- Built without jQuery.
- Designed for real SME commerce operations.

Citrus does one thing deliberately well:

> It enforces how commerce is executed, recorded, governed, and monetized at scale.
