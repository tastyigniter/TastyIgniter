# Phase 1.7 local MySQL and browser verification

> This runbook records required manual acceptance; it is not evidence that the run was performed. Use a disposable MySQL 8 database and configured admin URI. Never use production tender references.

## Setup and evidence

1. Check out the release, run `composer install`, `php artisan igniter:up`, `php artisan migrate`, `php artisan restaurant-ops:sync-roles`, `php artisan restaurant-ops:verify-payments`, and `php artisan route:cache`. Log in as cashier at Branch A and manager in a separate private window. Record browser, commit, timezone and DB version.
2. Open a cashier shift with 1,000.0000. Expect one open `..._cashier_shifts` row and no payment/tender rows.
3. In POS create a collection order, add configured items, confirm it and lock payment. Expect official `orders`, lines/totals plus one `..._pos_orders` row in `payment_pending`; no tender, processed flag, receipt or cash movement yet.

## Tender scenarios

4. Prepare payment and settle fully with cash received greater than total. Expect server-derived applied total, change difference, one paid payment, one cash tender (received/applied/change distinct), processed official order with one successful safe payment log/status history, paid POS order and one immutable receipt. Expected drawer rises by **applied cash**, not received plus change.
5. Preview the 80mm receipt. Verify configured restaurant/branch/contact, operational receipt and official order/invoice identity, local timestamp, cashier/service/customer, immutable items/totals/tax, tender/reference, received/change and footer. POST print, use browser print preview at 80mm, then POST reprint. Expect print count 2, reprint marker/event and still exactly one payment/receipt.
6. Repeat with a card-only order and unique reference. Card applied must equal total, change zero, card shift total increases, cash does not.
7. Repeat with mobile; select configured bKash/Nagad/Rocket/Other and enter a reference. Expect provider/reference snapshot, mobile shift total and no cash effect.
8. Repeat splits: cash+card, cash+mobile and card+mobile. Expect applied sums exactly equal official total. Test final cash over-tender; only it produces change. Remove an uncommitted UI row and confirm it creates no DB row.
9. Attempt underpayment, card/mobile overpayment, zero/negative amount, unknown method, absent policy-required reference and client `payable_total`. Expect field/domain errors and no official or tender write.

## Recovery, security and concurrency

10. Double-click Confirm and send two concurrent requests with the same key. Expect one paid row and an exact replay. Reuse the key with changed tenders: 409 idempotency conflict. Use different keys concurrently: one succeeds, the other sees version/already-paid conflict.
11. Refresh before confirm, during processing, and after response loss. GET payment/order status and resume; never show success before server `paid`. No tender details may be in local storage.
12. Submit an old version: 409 stale conflict. Try cancelled order and already-processed official order: blocked. Try Cashier B, Branch B, global/head-office context, and a mismatched shift: 403. Request close/submit/approve/close the shift then attempt settlement: blocked with no writes.
13. Simulate official adapter failure inside the disposable environment. Same-connection POS payment/tenders/order/receipt must roll back and official order must remain unprocessed. Simulate an ambiguous external timeout only with a test adapter; it must remain recoverable and must not auto-charge/retry.
14. Cashier requests reversal with a reason. Cashier self-approval is denied. Manager at the same location attempts approval: installed generic official API is unsupported, so execution returns the documented conflict; request and original payment/tenders/receipt/prints remain. No refund or compensating tender is falsely recorded. Verify closed-shift reversal is blocked.

## Shift close and official regression

15. Request close and inspect summary: opening cash; applied cash/card/mobile sales; cash in/out; zero or actual reversal/refund totals; expected cash = opening + applied cash sales + cash in + adjustments - cash out - safe drops - petty expenses - cash refunds; tender/payment/reversed counts. Count denominations, submit, enter variance reason when required, and manager approve. Compare submission JSON/hash to tender SQL aggregates.
16. Query `orders`, `order_totals`, `order_menus`, `payment_logs`, official status history, `..._pos_payments`, tenders, events, receipts, shifts and submissions. Expect no changed official totals/items and no orphan or duplicate successful record. Run `php artisan restaurant-ops:verify-payments` again.
17. In storefront, complete customer login plus collection and delivery checkout with COD and an installed online gateway sandbox. Verify cart/session, scheduling, delivery rules, tax/discount/menu totals, customer payment history, admin order/invoice, dashboards and gateway callbacks are unchanged.
18. Run existing Phase 1.3--1.6 suites and route cache/clear. Disable then re-enable RestaurantOps without uninstall/drop. Storefront remains available while disabled and every extension payment/receipt/shift row remains after re-enable.

## MySQL queries to retain

Capture `SHOW CREATE TABLE` for all six Phase 1.7 tables; `SHOW INDEX` for payment idempotency, payment/order status, receipt payment/number and receipt sequence; orphan-tender LEFT JOIN count (zero); paid payment count grouped by POS order (maximum one); tender sums by shift/method; official processed/log/history rows; receipt print count; and `EXPLAIN` for shift summary. Run two real MySQL connections for row-lock, concurrent receipt sequence, competing payment and deadlock retry tests. SQLite results are logic-only and must not be presented as concurrency proof.

## Acceptance decision

GO requires captured successful MySQL concurrency/rollback, browser/80mm print, official synchronization, shift reconciliation and storefront/gateway evidence. Any missing item is **CONDITIONALLY GO** or **NO-GO**.
