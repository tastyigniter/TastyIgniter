# Controller and menu ownership contract

RestaurantOps admin-shell pages use explicit Laravel routes. `AdminPageController`
opts out of TastyIgniter's automatic `{slug?}` route and dispatches Laravel's named
route arguments, while retaining TastyIgniter's authenticated native admin shell.
Page actions read the current request with `request()` and explicitly resolve scalar
record IDs. The storefront cart endpoints remain ordinary Laravel controllers.

Official TastyIgniter Menu Management is the sole owner of menu items, categories,
base prices, specials, option groups and values, images, availability, mealtimes,
and location relationships. RestaurantOps never creates or updates an official
`Menu`. Menu Operations Settings selects an existing official `Menu` and writes
only supplemental operational records such as kitchen/KOT metadata, operational
variants, modifier behavior, routing, overrides, combos, and immutable snapshots.
Missing official records return 404. Existing database foreign keys define metadata
cleanup behavior; disabling a menu leaves supplemental history intact but makes it
unavailable through official catalog queries.

The visible navigation is intentionally limited to Overview, POS, Active Orders,
Held Orders, Waiter, Kitchen, Shifts, My Active Shift, Branch Shift Review, and Menu
Operations Settings. Foundation-only Head Office, Branch, and Cashier landing pages
remain routable for compatibility but are not advertised as separate workflows.
