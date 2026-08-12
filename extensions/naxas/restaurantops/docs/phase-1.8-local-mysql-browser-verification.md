# Phase 1.8 Local MySQL Browser Verification

## Browser runbook

1. Create Ground Floor with `POST /restaurant-ops/floors`.
2. Create tables 01-10 with `POST /restaurant-ops/tables`.
3. Configure capacity/shape/position/size/rotation/sort order.
4. Open Table 01 with 2 guests.
5. Add dine-in items through existing POS order item endpoints.
6. Confirm the POS order.
7. Add additional items while the table session remains active.
8. Verify `/table-sessions/{session}/bill` running bill.
9. Change guest count with expected version.
10. Request bill.
11. Transfer Table 01 to Table 02.
12. Verify Table 01 is available.
13. Verify Table 02 retains the same POS/official order IDs.
14. Merge Table 03 and Table 04 to a primary table.
15. Verify combined operational bill; official orders are preserved.
16. Split an unpaid bill by amount or item allocation.
17. Pay through existing Phase 1.7 POS payment flow.
18. Verify receipt through Phase 1.7 receipt view.
19. Close table after outstanding reaches zero.
20. Verify table becomes available.
21. Refresh browser during operations and verify no duplicate actions without fresh version/idempotency.
22. Test duplicate submission.
23. Test wrong location.
24. Test unauthorized role.
25. Test two browser sessions operating on the same table.
26. Verify no duplicate active session.
27. Verify shift totals still match Phase 1.7 payment reports.
28. Verify official order remains unchanged except legitimate status/payment updates.

## MySQL verification queries

```sql
SELECT table_id, COUNT(*) active_count FROM naxas_restaurant_ops_table_sessions WHERE active_table_id IS NOT NULL GROUP BY table_id;
SELECT active_table_id, COUNT(*) duplicate_count FROM naxas_restaurant_ops_table_sessions WHERE active_table_id IS NOT NULL GROUP BY active_table_id HAVING COUNT(*) > 1;
SELECT location_id, status, COUNT(*) FROM naxas_restaurant_ops_table_sessions GROUP BY location_id, status;
SELECT s.id, s.pos_order_id, s.official_order_id, p.order_id FROM naxas_restaurant_ops_table_sessions s JOIN naxas_restaurant_ops_pos_orders p ON p.id = s.pos_order_id;
SELECT * FROM naxas_restaurant_ops_table_transfers ORDER BY transferred_at DESC;
SELECT * FROM naxas_restaurant_ops_table_merges ORDER BY merged_at DESC;
SELECT s.id, SUM(i.amount) allocated FROM naxas_restaurant_ops_bill_splits s JOIN naxas_restaurant_ops_bill_split_items i ON i.bill_split_id = s.id GROUP BY s.id;
SELECT id, order_total, outstanding_total FROM naxas_restaurant_ops_pos_orders WHERE service_type = 'dine_in';
SELECT * FROM naxas_restaurant_ops_table_sessions WHERE status = 'closed';
SELECT s.* FROM naxas_restaurant_ops_table_sessions s LEFT JOIN naxas_restaurant_ops_tables t ON t.id = s.table_id WHERE t.id IS NULL;
SELECT s.* FROM naxas_restaurant_ops_table_sessions s LEFT JOIN naxas_restaurant_ops_pos_orders p ON p.id = s.pos_order_id WHERE p.id IS NULL;
SELECT s.* FROM naxas_restaurant_ops_table_sessions s JOIN naxas_restaurant_ops_tables t ON t.id = s.table_id JOIN naxas_restaurant_ops_pos_orders p ON p.id = s.pos_order_id WHERE s.location_id <> t.location_id OR s.location_id <> p.location_id;
EXPLAIN SELECT * FROM naxas_restaurant_ops_tables WHERE location_id = 1 AND floor_id = 1 ORDER BY sort_order;
EXPLAIN SELECT * FROM naxas_restaurant_ops_table_sessions WHERE active_table_id = 1;
```

Expected duplicate active sessions = 0, orphan table sessions = 0, orphan table orders = 0, invalid location relationships = 0.

## Evidence status

This repository change includes the runbook and queries. Full local browser/MySQL evidence must be attached by the operator running a MySQL-backed TastyIgniter installation.
