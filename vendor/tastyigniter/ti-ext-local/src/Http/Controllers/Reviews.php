<?php

declare(strict_types=1);

namespace Igniter\Local\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\FormController;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Local\Http\Actions\LocationAwareController;
use Igniter\Local\Http\Requests\ReviewRequest;
use Igniter\Local\Models\Review;

class Reviews extends AdminController
{
    public array $implement = [
        ListController::class,
        FormController::class,
        LocationAwareController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Review::class,
            'title' => 'lang:igniter.local::default.reviews.text_title',
            'emptyMessage' => 'lang:igniter.local::default.reviews.text_empty',
            'defaultSort' => ['review_id', 'DESC'],
            'configFile' => 'review',
        ],
    ];

    public array $formConfig = [
        'name' => 'lang:igniter.local::default.reviews.text_form_name',
        'model' => Review::class,
        'request' => ReviewRequest::class,
        'create' => [
            'title' => 'lang:admin::lang.form.create_title',
            'redirect' => 'igniter/local/reviews/edit/{review_id}',
            'redirectClose' => 'igniter/local/reviews',
            'redirectNew' => 'igniter/local/reviews/create',
        ],
        'edit' => [
            'title' => 'lang:admin::lang.form.edit_title',
            'redirect' => 'igniter/local/reviews/edit/{review_id}',
            'redirectClose' => 'igniter/local/reviews',
            'redirectNew' => 'igniter/local/reviews/create',
        ],
        'preview' => [
            'title' => 'lang:admin::lang.form.preview_title',
            'back' => 'igniter/local/reviews',
        ],
        'delete' => [
            'redirect' => 'igniter/local/reviews',
        ],
        'configFile' => 'review',
    ];

    protected null|string|array $requiredPermissions = 'Admin.Reviews';

    protected static $reviewHints;

    public function __construct()
    {
        parent::__construct();

        $this->hiddenActions[] = 'makeAverageRatingDataset';

        AdminMenu::setContext('reviews', 'marketing');
    }

    public function index(): void
    {
        $this->addJs('js/vendor.chart.js', 'vendor-chart-js');

        $this->addJs('igniter.local::js/reviewchart.js', 'reviewchart-js');

        $this->asExtension('ListController')->index();
    }

    public function makeAverageRatingDataset(string $ratingType, $records)
    {
        if (is_null(self::$reviewHints)) {
            self::$reviewHints = (new Review)->getRatingOptions();
        }

        $pieColors = ['', '#e74c3c', '#f1c40f', '#9b59b6', '#64B5F6', '#1abc9c'];

        $chartData = [
            'labels' => array_values(self::$reviewHints),
            'datasets' => [],
        ];

        $chartData['datasets'][0]['label'][] = lang('igniter.local::default.reviews.label_'.$ratingType);

        for ($rating = 1; $rating <= 5; $rating++) {
            $chartData['datasets'][0]['data'][] = $records->where($ratingType, $rating)->count();
            $chartData['datasets'][0]['backgroundColor'][] = $pieColors[$rating];
        }

        return $chartData;
    }
}
