# Enhanced cart and order snapshot contract (v1)

Enhanced clients retain the official `menu_options` payload and add `restaurant_ops`: `variant_id`, canonical `modifiers` (`id`, `quantity`), `combo` choices, concrete `location_id`, canonical `service_type`, `channel`, and the last server-issued `configuration_hash`. Client price fields are ignored. A hash mismatch is a conflict requiring refresh. Legacy requests without `restaurant_ops` follow the official cart path unchanged.

Snapshot schema version 1 stores scalar `menu_item`, optional `variant`, `modifier_groups` with selected modifiers/quantities/unit prices/kitchen names, `combo_components`, `location`, `service_type`, item note, canonical pricing breakdown, configuration hash and total price. Renderers use the snapshot when present and official legacy order fields otherwise.
