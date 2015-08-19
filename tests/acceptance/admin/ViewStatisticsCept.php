<?php
$I = new AcceptanceTester($scenario);
$I->am('Admin');
$I->wantTo('view statistics from the administrator panel');

// Login Test location user
$I->adminLogin('tastyadmin', 'demoadmin', 'admin');

$I->amGoingTo('navigate to dashboard, check page title, header and action buttons');
$I->amOnPage('/admin/dashboard');
$I->seeInTitle('Dashboard ‹ Administrator Panel');
$I->see('Dashboard', '.page-header h1');

$I->makeScreenshot('dashboard_page');

//--------------------------------------------------------------------
// Expect list view of statistics
//--------------------------------------------------------------------
$I->expectTo('see sales and customer report in statistics panel with range control');
$I->see('Statistics', '.panel-statistics h3');
$I->click('Range', '.panel-statistics');
$I->see('Today', '.panel-statistics .dropdown-menu-range');
$I->see('Week', '.panel-statistics .dropdown-menu-range');
$I->see('Month', '.panel-statistics .dropdown-menu-range');
$I->see('Year', '.panel-statistics .dropdown-menu-range');
$I->click('Year', '.panel-statistics .dropdown-menu-range');

$I->see('Total Sales', '.panel-statistics #statistics');
$I->see('£72,739.28', '.panel-statistics #statistics .sales');
$I->see('Total Lost Sales', '.panel-statistics #statistics');
$I->see('£0.00', '.panel-statistics #statistics .lost_sales');
$I->see('Total Customers', '.panel-statistics #statistics');
$I->see('5', '.panel-statistics #statistics .customers');
$I->see('Total Orders', '.panel-statistics #statistics');
$I->see('15', '.panel-statistics #statistics .orders');
$I->see('Total Delivery Orders', '.panel-statistics #statistics');
$I->see('12', '.panel-statistics #statistics .delivery_orders');
$I->see('Total Collection Orders', '.panel-statistics #statistics');
$I->see('3', '.panel-statistics #statistics .collection_orders');
$I->see('Total Orders Completed', '.panel-statistics #statistics');
$I->see('0', '.panel-statistics #statistics .orders_completed');
$I->see('Total Table(s) Reserved', '.panel-statistics #statistics');
$I->see('6', '.panel-statistics #statistics .tables_reserved');

$I->expectTo('see list of ten recent orders');
$I->see('10 Latest Orders', '.panel-orders h3');
$I->see('ID Location Customer Name Status Type Ready Time Date Added', '.panel-orders table thead tr');
$I->seeElement('.panel-orders table tbody td');
$I->seeNumberOfElements('.panel-orders table tbody tr', [1,10]); //between 1 and 10 elements
$I->dontSee('There are no orders available.', '.panel-orders');

$I->expectTo('see list of recent activity');
$I->see('Recent Activity', '.panel-activities h3');
$I->seeNumberOfElements('.panel-activities .list-group > .list-group-item', [1,10]); //between 1 and 10 elements

$I->expectTo('see a reports chart for customers, orders, reservations and reviews');
$I->see('Reports Chart', '.panel-chart h3');
$I->click('.panel-chart .daterange');
$I->waitForElementVisible('.daterangepicker .ranges', '2');
$I->see('Total CustomersTotal OrdersTotal ReservationsTotal Reviews', '.panel-chart .chart-legend');

$I->comment('All Done!');