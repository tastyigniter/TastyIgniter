# Enhanced cart and order snapshot contract (v1)

Enhanced behavior is selected only by the application-owned endpoints
`POST /restaurant-ops/v1/cart/quote` and
`POST /restaurant-ops/v1/cart/items`. Official legacy payloads and endpoints are
unchanged.

## Request 1.0

The JSON object contains `contract_version: "1.0"`, positive `menu_id`, concrete
active `location_id`, `service_type` (`delivery`, `collection`, `takeaway`, or
`dine_in`), `channel: "storefront"`, quantity 1–99, optional `variant_id`,
`modifier_selections` grouped by `group_id`, `combo_selections` grouped by
`group_id`, an optional 500-character `item_note`, and the last quote's
`configuration_hash` when adding. Modifier/choice quantities are 1–99.

The fields `unit_price`, `price`, `subtotal`, `total`, `modifier_price`, and
`discount` are prohibited. Every official and extension ID, attachment,
visibility, activity, availability, quantity rule, combo limit, location,
service and configuration version is resolved again on the server. `takeaway`
is returned and priced as official `collection`. Global mode is invalid.

## Responses and errors

Quote returns contract/hash, canonical menu/variant/modifier/combo selections,
normalized service/channel/location, quantity/note, SHA-256 cart identity,
availability, deterministic decimal price breakdown, authoritative unit/line
totals and warnings. Add requires `Idempotency-Key`, repeats resolution and
returns the official cart row result plus the same RestaurantOps metadata.

Errors use `{ "error": { "code": "restaurantops_*", "message": "..." } }`.
Selection errors are 422, unauthorized/cross-location errors 403, and stale
configuration, idempotency reuse or cart write conflicts 409. Unexpected errors
alone use 500. Validation details never make a submitted price authoritative.

## Cart and snapshot carriage

The official cart manager remains the sole writer. A versioned, URL-safe
metadata envelope is attached to the official cart line's comment solely to
participate in official line identity and survive official order-menu
persistence. The customer note is kept separately in the envelope. The public
post-order listener decodes enhanced lines, writes the immutable snapshot, and
restores the customer-visible order comment.

Snapshot schema version 1 stores scalar `menu_item`, optional `variant`,
`modifier_groups` with selected modifiers/quantities/unit prices/kitchen names,
`combo_components`, location, service type, channel, item note, canonical
pricing breakdown, unit/line totals and configuration hash. One unique snapshot
exists per official `order_menu_id`. Renderers use it when present and official
legacy order fields otherwise. Since the official after-save event is post-
commit, failed writes enter the extension-owned reconciliation ledger rather
than being falsely described as atomic.
