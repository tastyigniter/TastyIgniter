# Phase 1.5 local MySQL and browser verification

Status before this runbook is completed: **IMPLEMENTED — LOCAL MYSQL AND BROWSER VERIFICATION REQUIRED; NOT PRODUCTION-READY**.

## Environment and automated checks

1. Start a disposable MySQL 8 service and create an empty database using `utf8mb4` and InnoDB. Copy `.env.example` to `.env`, set `APP_ENV=local`, a non-empty `APP_KEY`, `APP_TIMEZONE`, and MySQL `DB_*` values. Never commit credentials.
2. Run `composer install` without updating dependencies, `php artisan extension:refresh`, and `php artisan migrate` according to the project's normal install workflow.
3. Run `php artisan restaurant-ops:sync-roles --dry-run`, review changes, then run it without `--dry-run`. Grant only the documented shift permissions.
4. Run `php artisan restaurant-ops:verify-shifts --check-environment`, the regular focused suites, and `RESTAURANT_OPS_MYSQL=1` with the MySQL shift suite.
5. Inspect all four tables: engine InnoDB; money `DECIMAL(15,4)`; named indexes; unique nullable `active_staff_id`; unique submission revision; extension-parent foreign keys. Exercise migration rollback on a disposable database, then migrate again.

## Fixture and browser workflow

1. Create an active branch, an active Cashier, and a different active Branch Manager. Assign both using official staff-location assignment. Give the Cashier Access/Open/CashMovement/Create/Close/ViewOwn and the Manager Access/ViewBranch/Approve (and optionally ForceClose).
2. Sign in as Cashier, select that concrete branch, and capture **Open Shift**. Open with BDT 5,000. Confirm global mode and an inactive branch refuse the write.
3. Capture **Active Shift** and **Cash Movements**. Add cash-in 1,000 and cash-out 500. Confirm negative/zero movement denial and adjustment denial. Have a manager reverse a disposable movement with a reason.
4. Confirm the summary prominently says the official payment provider is partial/unverified. A test-only provider may supply verified cash sales 10,000 and cash refund 500; never configure those fixture totals in production. Expected cash is then 15,000.
5. Request close, capture **Closing Summary**, enter counted cash 14,950 (or matching configurable denominations), and capture **Variance -50**. Submit revision 1. Confirm movements are now blocked.
6. While still Cashier, attempt the approval URL and record 403/self-approval denial. Switch to a Manager assigned to another branch and confirm the direct URL is denied. Switch to the correct branch.
7. Capture **Manager Review**, reject once with a required reason, sign back in as Cashier and resubmit revision 2, then approve as the correct Manager. Capture **Approved Historical View**.
8. Confirm opening cash, location, cashier, counted/expected/variance, submissions, denominations and movements cannot be edited/deleted; movement endpoints refuse terminal shifts. Confirm duplicate approve/reject safely conflicts.
9. Repeat with force close and a required reason. Simulate a test-provider/payment summary change after submission and verify approval returns `shift_summary_changed`.
10. Verify own and branch histories, filters, pagination, empty states and tablet/mobile layout. Disable then re-enable the extension and confirm all data remains. Confirm storefront menu/cart/checkout, delivery, collection, reservation, customer login, payment and online-order routes behave exactly as before.

## Cleanup and evidence

Use only disposable, explicitly marked records and a non-production environment. The verification command intentionally has no production data seeder. Retain command output and seven screenshots (open, active, movements, closing, variance, review, approved). Record MySQL version, app/core/extension versions, timezone and commit SHA in the verification report.

Rollback for Phase 1.5 is the normal extension migration rollback on a backed-up/disposable database. It drops denomination, submission, movement and shift tables in dependency order; never roll back production financial history without an approved retention/export plan.
