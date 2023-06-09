<?php

namespace System\DashboardWidgets;

use Admin\Classes\BaseDashboardWidget;
use DOMDocument;

/**
 * TastyIgniter news dashboard widget.
 */
class News extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected $defaultAlias = 'news';

    public $newsRss = 'https://tastyigniter.com/feed?ref=dashboard';

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('news/news');
    }

    public function defineProperties()
    {
        return [
            'newsCount' => [
                'label' => 'admin::lang.dashboard.text_news_count',
                'default' => 6,
                'type' => 'select',
                'options' => range(1, 10),
                'validationRule' => 'required|integer',
            ],
        ];
    }

    protected function prepareVars()
    {
        $this->vars['newsFeed'] = $this->loadFeedItems();
    }

    public function loadFeedItems()
    {
        $dom = $this->createRssDocument();
        if (!$dom || !$dom->load($this->newsRss))
            return [];

        $newsFeed = [];
        foreach ($dom->getElementsByTagName('entry') as $content) {
            $newsFeed[] = [
                'title' => $content->getElementsByTagName('title')->item(0)->nodeValue,
                'description' => $content->getElementsByTagName('summary')->item(0)->nodeValue,
                'link' => $content->getElementsByTagName('link')->item(0)->getAttribute('href'),
                'date' => $content->getElementsByTagName('updated')->item(0)->nodeValue,
            ];
        }

        $newsCount = $this->property('newsCount');
        $count = (($count = count($newsFeed)) < $newsCount) ? $count : $newsCount;

        return array_slice($newsFeed, 0, $count);
    }

    protected function createRssDocument()
    {
        return class_exists('DOMDocument', false) ? new DOMDocument() : null;
    }
}
