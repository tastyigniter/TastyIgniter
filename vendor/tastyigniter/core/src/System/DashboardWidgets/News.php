<?php

declare(strict_types=1);

namespace Igniter\System\DashboardWidgets;

use DOMDocument;
use Igniter\Admin\Classes\BaseDashboardWidget;
use Override;
use Throwable;

/**
 * TastyIgniter news dashboard widget.
 */
class News extends BaseDashboardWidget
{
    /**
     * @var string A unique alias to identify this widget.
     */
    protected string $defaultAlias = 'news';

    public string $newsRss = 'https://tastyigniter.com/feed';

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('news/news');
    }

    #[Override]
    public function defineProperties(): array
    {
        return [
            'title' => [
                'label' => 'igniter::admin.dashboard.label_widget_title',
                'default' => 'igniter::admin.dashboard.text_news',
            ],
            'newsCount' => [
                'label' => 'igniter::admin.dashboard.text_news_count',
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

    protected function loadFeedItems(): array
    {
        $newsFeed = [];
        foreach ($this->loadRssDocument()?->getElementsByTagName('entry') ?? [] as $content) {
            $newsFeed[] = [
                'title' => $content->getElementsByTagName('title')->item(0)->nodeValue,
                'description' => $content->getElementsByTagName('summary')->item(0)->nodeValue,
                'link' => $content->getElementsByTagName('link')->item(0)->getAttribute('href'),
                'date' => $content->getElementsByTagName('updated')->item(0)->nodeValue,
            ];
        }

        $newsCount = (int)$this->property('newsCount');
        $count = (($count = count($newsFeed)) < $newsCount) ? $count : $newsCount;

        return array_slice($newsFeed, 0, $count);
    }

    protected function loadRssDocument(): ?DOMDocument
    {
        try {
            $dom = class_exists('DOMDocument', false) ? resolve(DOMDocument::class) : null;

            $dom?->load($this->newsRss);

            return $dom;
        } catch (Throwable) {
            return null;
        }
    }
}
