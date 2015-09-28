<?php
namespace Admin\Acceptance;

use \AcceptanceTester;

/**
 * @group admin
 */
class ViewStatisticsCest {

    public function _before(AcceptanceTester $I) {
        $I->am('Admin');
        $I->adminLogin('tastyadmin', 'demoadmin', 'admin');
        $I->amOnPage('/admin/dashboard');
        $I->seeInTitle('Dashboard ‹ Administrator Panel');
    }

    public function viewStatistics(AcceptanceTester $I) {
        $I->wantTo('view statistics from the administrator dashboard');

        $I->see('Total Sales', '.panel-statistics #statistics');
        $I->see('Total Lost Sales', '.panel-statistics #statistics');
        $I->see('Total Customers', '.panel-statistics #statistics');
        $I->see('Total Orders', '.panel-statistics #statistics');
        $I->see('Total Delivery Orders', '.panel-statistics #statistics');
        $I->see('Total Collection Orders', '.panel-statistics #statistics');
        $I->see('Total Orders Completed', '.panel-statistics #statistics');
        $I->see('Total Table(s) Reserved', '.panel-statistics #statistics');
    }

    public function viewRecentOrders(AcceptanceTester $I) {
        $I->wantTo('view ten most recent orders from the administrator dashboard');

        $I->see('10 Latest Orders', '.panel-orders h3');
        $I->see('ID Location Customer Name Status Type Ready Time Date Added', '.panel-orders table thead tr');
        $I->seeElement('.panel-orders table tbody td');
        $I->seeNumberOfElements('.panel-orders table tbody tr', [1,10]); //between 1 and 10 elements
        $I->dontSee('There are no orders available.', '.panel-orders');
    }

    public function viewRecentActivity(AcceptanceTester $I) {
        $I->wantTo('view the most recent activity from the administrator dashboard');

        $I->see('Recent Activity', '.panel-activities h3');
        $I->seeNumberOfElements('.panel-activities .list-group > .list-group-item', [1,10]); //between 1 and 10 elements
    }

    public function viewTopCustomers(AcceptanceTester $I) {
        $I->wantTo('view the top customers from the administrator dashboard');

        $I->see('Top Customers', '.panel-top-customers h3');
        $I->see('Customer Name # Orders Total Sale', '.panel-top-customers table thead tr');
        $I->seeNumberOfElements('.panel-top-customers table thead tr', [1,10]); //between 1 and 10 elements
    }

    public function viewReportsChart(AcceptanceTester $I) {
        $I->wantTo('view the sales reports chart from the administrator dashboard');

        $I->expectTo('see a reports chart for customers, orders, reservations and reviews');
        $I->see('Reports Chart', '.panel-chart h3');
        $I->click('.panel-chart .daterange');
        $I->waitForElementVisible('.daterangepicker .ranges', '2');
        $I->see('Total CustomersTotal OrdersTotal ReservationsTotal Reviews', '.panel-chart .chart-legend');
    }
}