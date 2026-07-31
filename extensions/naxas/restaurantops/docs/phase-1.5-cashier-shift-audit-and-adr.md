# Phase 1.5 cashier shift foundation: pre-change audit and ADR

**Audit date:** 2026-07-31  
**Decision:** **GO**, with official payment totals explicitly treated as partial/unverified until a future POS settlement link exists. Local MySQL and browser verification remain mandatory.

This document records the mandatory audit completed before Phase 1.5 production code was changed. The implementation boundary is exclusively `Naxas.RestaurantOps`; official models remain authoritative and no storefront route or payment behavior is intercepted.

## Existing-system findings

1. **Orders and status flow.** `Igniter\Cart\Models\Order` owns `orders`, uses `order_id`, location scoping, `status_id`, `processed`, status history, `created_at`/`updated_at`, and official payment/order events. `isPaymentProcessed()` means `processed && status_id`; it is not a cashier settlement record. Completed/cancelled states depend on configured status IDs.
2. **Payments.** Pay Register owns `payments` and `payment_logs`. An order stores a payment code; logs represent gateway attempts (`is_success`), may be refundable and have `refunded_at`, but contain no reliable settled amount, normalized tender class, cashier shift, terminal, or POS attribution. Request/response payloads must not be used for reconciliation.
3. **Amounts.** `orders.order_total` and order-total values are database `DECIMAL(15,4)`, although official model casts expose floats. There is no canonical paid balance or per-refund amount. Shift code must therefore use decimal strings and integer scaled arithmetic and must never use official float casts for authoritative arithmetic.
4. **Authentication/authorization.** Admin authentication uses the official staff `Igniter\User\Models\User`. Active status is `status`. `hasPermission()` evaluates serialized official `UserRole` permissions and superusers bypass permission checks. RestaurantOps still applies location and self-approval constraints to superusers.
5. **Staff locations.** Staff have the official polymorphic `locations` assignment. `LocationContext` returns assigned locations, or all locations for superusers, and rejects inactive locations unless the official `Admin.Locations` override applies. Phase 1.5 requires an active location even for that override when writing financial operations.
6. **Location context.** `LocationContextContract` exposes current/global state, access checks, and query scoping. Global mode is valid only for reporting. Existing transactional middleware rejects global writes and missing concrete context.
7. **Operational middleware.** `RequiresOperationalPermission` delegates active-user/permission checks to `OperationalAccessService`; `RequiresTransactionalLocation` requires a concrete branch. Errors are JSON-structured for JSON clients. Shift domain checks additionally protect resource ownership and location.
8. **Permissions.** All eight required `Restaurant.Shifts.*` codes already exist. Owner/manager/cashier defaults are established by `RoleProfiles`; waiter and kitchen profiles do not receive shift permissions. No new permission code is necessary. Adjustment/reversal uses `Restaurant.Shifts.Approve`; tender settlement/refund permissions remain reserved for later phases.
9. **Superusers.** Permission bypass does not imply cross-location transactional bypass, global-mode writes, self-approval, or inactive-location financial writes.
10. **Locations.** Official `location_status` is the active flag. A shift permanently stores the official location key and is never moved.
11. **Currency/time.** Display uses the official `currency_format()` helper and configured currency. Persistence uses four decimal places. Laravel application timezone is currently UTC; server timestamps and range boundaries use application time. UI may format them through existing helpers. No business-day cutoff is inferred.
12. **Audit.** RestaurantOps has an `AuditLogger` adapter to PSR logging. There is no extension-owned immutable activity table. Phase 1.5 uses structured, allow-listed log context and immutable submission rows; it never logs gateway payloads or personal/card data.
13. **Migrations/models.** Existing extension migrations are anonymous, additive, reversible, extension-prefixed, and use named compact indexes. Models are extension-owned and official relations are referenced without altering official schema.
14. **Admin/routes.** Existing pages use class-action controllers, Blade views, `Igniter::adminUri()`, configured admin middleware, named routes, and route-cache-safe closures only for group configuration. Navigation uses `admin_url()`, integer priorities, translations, and permissions.
15. **Transactions/concurrency.** Laravel `DB::transaction()` and `lockForUpdate()` are available. Existing cart integration also uses unique idempotency hashes. MySQL has no portable partial unique index, so nullable uniqueness alone is unsafe.
16. **Deletion/archive.** Official domains vary between switchable/archive and hard records. Financial shift records must prohibit model deletion; movement corrections are reversals. Extension disable retains tables.
17. **Terminal/drawer.** No authoritative terminal or cash-drawer domain exists. `terminal_code` is optional descriptive metadata only and is not a uniqueness scope.
18. **Prepared integration points.** Official order/payment events exist, but no shift ID is attached to current orders/payments. RestaurantOps has order snapshot reconciliation but it is menu-integrity data, not settlement. Provider and warning contracts are therefore the safe future seam.
19. **Tests/runtime.** Existing suites cover location context, role permissions, menu configuration, enhanced cart/snapshots, migrations, extension/navigation, and optional MySQL integration. SQLite is available for isolated smoke tests. MySQL availability is opt-in and must skip explicitly when absent.
20. **Composer baseline.** Root constraints target PHP 8.3/Laravel 12/core 4.3. Composer validation may report the known lock-file mismatch; Phase 1.5 adds no dependency and will not update the lock.

## Payment/order data-source matrix

| Source | Available facts | Reliability for a shift | Phase 1.5 treatment |
|---|---|---|---|
| `orders` | location, total, tender code, processed/status, timestamps | Derived order-level data; no shift attribution | Report only as unavailable/partial unless a provider can prove attribution |
| `order_totals` | component values/codes | Order calculation, not paid settlement | Never infer cash receipt |
| `payments` | configured gateway code/name/class/status | No normalized cash/card/mobile taxonomy | Source metadata only; unknown is never cash |
| `payment_logs` | attempt success, gateway code, refund marker/time | No settled/refunded amount and attempts may duplicate | Attempt counts only; never authoritative cash totals |
| RestaurantOps movement rows | shift/location/type/amount/reversal | Verified extension-owned cash movement | Included exactly once when not reversed |
| Future Phase 1.10 provider | shift-linked settlement/refund/tender | Intended authoritative source | Replace/decorate provider contract without changing shift API |

The default official provider returns explicit `partial`/`unavailable` verification metadata and zero eligible cash sales/refunds rather than fabricating them.

## Authorization matrix

| Action | Cashier | Branch manager | Owner/head office | Extra invariant |
|---|---|---|---|---|
| Open/view own | shift open/view-own permissions | if granted | if granted | active staff, concrete active assigned branch |
| Add cash in/out | cash-movement permission | if granted | if granted | own active shift unless branch authority; same branch |
| Adjustment/reversal | denied by default | approve permission | approve permission | reason required |
| Request/submit close | close permission, own shift | if granted | if granted | same branch, open lifecycle |
| View branch | denied by default | view-branch | view-branch | assigned/current branch; global is read-only |
| Approve/reject | denied | approve | approve | submitted, same branch, actor != cashier |
| Force close | denied | only if explicitly granted | force-close | same branch, reason required |

Direct URLs are subject to admin auth, explicit permission middleware, transactional context for writes, then resource-location and ownership rules in the domain/controller.

## Lifecycle and state machine

`open -> closing_requested -> submitted -> approved` is the normal path. `submitted -> rejected -> closing_requested -> submitted` creates a new immutable revision. `open|closing_requested|submitted -> force_closed` is terminal and reasoned. `open -> cancelled` is allowed only with no movements/submissions and a reason (domain foundation; no broad UI shortcut). `approved`, `force_closed`, and `cancelled` are terminal. Invalid transitions produce `shift_invalid_transition`.

Rejection never overwrites a submission: the decision is recorded on that revision and the shift returns to `closing_requested`. Normal movements stop at `closing_requested`; rejected correction may return to `open` only through an explicit future workflow, so this phase corrects count/note and resubmits without altering financial history.

## Schema decision

Four additive tables are used:

* `naxas_restaurant_ops_cashier_shifts`: official location/staff IDs, lifecycle timestamps/actors, decimal opening/current submitted totals, revision, reconciliation hash, optimistic `version`, and a nullable `active_staff_id` unique key.
* `naxas_restaurant_ops_cash_movements`: shift/location/type, positive decimal amount, reason/reference, creator/approver, reversal metadata, timestamps, and optional idempotency key.
* `naxas_restaurant_ops_shift_submissions`: unique `(shift_id, revision)` immutable summary/warning JSON snapshots, reconciliation hash, decision metadata, and timestamps.
* `naxas_restaurant_ops_shift_denominations`: unique denomination per submission with decimal denomination/total and unsigned quantity.

Foreign keys target only extension-owned parent records; official IDs are indexed but deliberately not constrained so extension migrations do not couple install/rollback order to official packages. Rollback drops only these four tables in dependency order.

### One-open-shift constraint

Scope is **one active operational shift per staff globally**. While a state is active (`open`, `closing_requested`, `submitted`, `rejected`), `active_staff_id = staff_id`; terminal transitions set it to null. A unique index on `active_staff_id` provides MySQL/SQLite duplicate protection, backed by a transaction, a staff-row lock where available, an active query lock, and unique-violation translation to `shift_already_open`/`shift_concurrency_conflict`. Nullable unique semantics intentionally permit unlimited terminal history. Optional terminal code does not affect uniqueness.

## Reconciliation and compatibility

All inputs are normalized to four decimal places and calculated using scaled integers:

`expected = opening + eligible cash sales + cash_in - cash refunds - cash_out - safe_drop - petty_expense + signed manager adjustments`.

Non-cash, unpaid, failed, voided, online-prepaid, unknown and duplicate records are excluded. Adjustment direction is encoded by a required reason convention and provider output, not negative client amounts. The `PaymentSummaryProvider` contract returns values plus verification status/source details. The official adapter is conservative; a deferred provider is available when official tables are absent. `ShiftClosingWarningProvider` is composable and emits only supported warnings.

A canonical SHA-256 reconciliation hash covers opening cash, provider summary, non-reversed movements, warnings/source status, and calculated expected cash. Submission stores it. Approval recalculates under a row lock and rejects mismatch as `shift_summary_changed`. This detects later provider changes/refunds even though movements themselves are blocked after close request/submission.

## Concurrency, idempotency, and immutability

* Transactions plus row locks serialize lifecycle decisions, submission revision increments, and reversals.
* The generated active key unique strategy closes the concurrent-open race at the database layer.
* Optional request idempotency keys are unique within shift/operation scope; same-payload retries return the existing result and conflicting payloads return 409.
* `version` enables stale-client detection; state checks make duplicate close/decision requests deterministic conflicts or idempotent reads.
* Models reject updates to identity/opening values after creation and reject every mutation/delete for terminal shifts. Submission snapshots and denominations reject update/delete. Movements reject update/delete except the domain reversal operation on a mutable shift.
* Approval/rejection/force-close operate on a locked shift. Self-approval, cross-location access, stale summaries, and concurrency conflicts are audit warnings.

These guarantees are strongest on MySQL/InnoDB and require the documented local suite; SQLite tests validate semantics but do not prove production lock scheduling.

## Audit strategy

Structured events cover opening, close request, submission/revision, approval, rejection, force close, cancellation, movement creation/reversal, denied/self/cross-location attempts, stale summary, concurrency conflict, and active resolution where useful. Context is limited to actor, shift, location, movement/revision, state, safe decimal values, and reason code/text. Passwords, tokens, sessions, customer data, card data, payment payloads, and mobile secrets are prohibited.

## Risk and upgrade matrix

| Risk | Control | Residual risk |
|---|---|---|
| Duplicate active shift | unique active staff key + transaction/locks | MySQL concurrency must be locally exercised |
| Cross-location access | context assignment + resource location checks | Superuser still needs a concrete branch for writes |
| Self approval | actor/cashier invariant | none in domain API |
| Expected cash mismatch | decimal service + conservative provider | official payment data remains partial until Phase 1.10 |
| Late payment/refund | submission hash recheck | only detectable when provider exposes the event |
| Edited/deleted movement | guarded models + reversal-only service | direct SQL remains an operational/database concern |
| Duplicate decisions | row lock/state/version/idempotency | client receives deterministic 409 |
| Date boundaries | server/app timezone and exact open/submission instants | business-day timezone policy deferred |
| Official package upgrade | contracts/adapters, no official schema edits | adapter compatibility suite must run on upgrades |
| Premature accounting | shift summaries only, no posting/journal | none by scope |

## Verification plan and no-regression checklist

Automated verification includes unit state/decimal/provider tests, SQLite migration/domain/route tests, existing location/roles/menu/enhanced-cart/navigation suites, route cache, Pint, Composer validation, diff checks, and an opt-in MySQL suite checking InnoDB, decimal columns, indexes, foreign keys, uniqueness, rollback, revision uniqueness, and immutability. The environment command performs non-destructive checks by default and refuses fixture changes in production.

Owner verification must run real MySQL migrations/rollback/concurrency and the documented browser workflow: cashier open, movements, close/count/submit, self-approval denial, manager reject/resubmit/approve, immutable history, cross-branch/global denial, disable/re-enable retention, and responsive screenshots.

No-regression gates: no `vendor/`, core, official extension, theme, storefront, cart, checkout, delivery, collection, reservation, customer auth, payment gateway, or online-order route changes; no broad Composer update; no POS, settlement, drawer, accounting, inventory, warehouse, payroll, or profitability implementation.

## GO rationale and limitations

**GO** because the lifecycle, extension-owned cash records, conservative reconciliation contract, location isolation, immutable revisions, and manager controls can be implemented safely without claiming official payment settlement. Approval means approval of the captured shift snapshot and its declared provider verification status—not an accounting posting or guaranteed bank/cash settlement. Production readiness is explicitly withheld pending owner MySQL and browser verification.
