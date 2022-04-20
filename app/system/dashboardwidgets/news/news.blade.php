@php
    $newsFeed = [];
    if (isset($newsRss) && @$newsRss->load($this->newsRss)) {
        foreach ($newsRss->getElementsByTagName('item') as $content) {
            $item = [
                'title' => $content->getElementsByTagName('title')->item(0)->nodeValue,
                'description' => $content->getElementsByTagName('description')->item(0)->nodeValue,
                'link' => $content->getElementsByTagName('link')->item(0)->nodeValue,
                'date' => $content->getElementsByTagName('pubDate')->item(0)->nodeValue,
            ];

            $newsFeed[] = $item;
        }

        $newsCount = $this->property('newsCount');
        $count = (($count = count($newsFeed)) < $newsCount) ? $count : $newsCount;

        $newsFeed = array_slice($newsFeed, 0, $count);
    }
@endphp
<div class="dashboard-widget widget-news">
    <h6 class="widget-title">@lang($this->property('title'))</h6>
    <div class="row">
        <div class="list-group list-group-flush w-100">
            @forelse($newsFeed as $feed)
                <a class="list-group-item" target="_blank" href="{{ $feed['link'] }}">
                    <b class="d-block text-truncate">{{ $feed['title'] }}</b>
                    <span class="text-muted d-block text-truncate">{{ strip_tags($feed['description']) }}</span>
                </a>
            @empty
                <div class="mt-3">
                    <p class="text-danger">
                        @lang('admin::lang.dashboard.error_rss')
                        <a href="javascript:location.reload();">
                            @lang('admin::lang.text_reload')
                        </a>.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>
