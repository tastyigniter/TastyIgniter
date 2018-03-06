<?php

/**
 * Feed_parser Class
 *
 * This class is written based entirely on the work found below
 * www.techbytes.co.in/blogs/2006/01/15/consuming-rss-with-php-the-simple-way/
 * All credit should be given to the original author
 *
 * @package System
 */
class Feed_parser
{
    public $feed_uri = null;                    // Feed URI

    public $data = FALSE;                    // Associative array containing all the feed items

    public $channel_data = [];                    // Store RSS Channel Data in an array

    public $feed_unavailable = null;                    // Boolean variable which indicates whether an RSS feed was unavailable

    public $cache_life = 0;                        // Cache lifetime

    public $cache_dir;    // Cache directory

    public $write_cache_flag = FALSE;                    // Flag to write to cache

    public $callback = FALSE;                    // Callback to read custom data

    function __construct($callback = FALSE)
    {
        if ($callback) {
            $this->callback = $callback;
        }

        $this->cache_dir = TI_APPPATH."cache/";
    }

    // --------------------------------------------------------------------

    function parse()
    {
        // Are we caching?
        if ($this->cache_life != 0) {
            $filename = $this->cache_dir.md5('feed_parser_'.$this->feed_uri);

            // Is there a cache file ?
            if (file_exists($filename)) {
                // Has it expired?
                $timedif = (time() - filemtime($filename));

                if ($timedif < ($this->cache_life * 60 * 60)) {
                    $rawFeed = @file_get_contents($filename);
                }
                else {
                    // So raise the falg
                    $this->write_cache_flag = TRUE;
                }
            }
            else {
                // Raise the flag to write the cache
                $this->write_cache_flag = TRUE;
            }
        }

        // Reset
        $this->data = [];
        $this->channel_data = [];

        // Parse the document
        if (!isset($rawFeed)) {
            $rawFeed = @file_get_contents($this->feed_uri);
        }

        if (!class_exists('SimpleXmlElement', FALSE)) return FALSE;

        try {
            $xml = new SimpleXmlElement($rawFeed);
        } catch (Exception $e) {
            log_message('error', 'Feed_parser: error --> Exception: '.$e->getMessage().' String could not be parsed as XML');

            return FALSE;
        }

        if (isset($xml->channel)) {
            // Assign the channel data
            $this->channel_data['title'] = $xml->channel->title;
            $this->channel_data['description'] = $xml->channel->description;

            // Build the item array
            foreach ($xml->channel->item as $item) {
                $data = [];
                $data['title'] = (string)$item->title;
                $data['description'] = (string)preg_replace('#<img(.*)/>#', '', $item->description);
                $data['pubDate'] = (string)$item->pubDate;
                $data['link'] = (string)$item->link;
                $dc = $item->children('http://purl.org/dc/elements/1.1/');
                $data['author'] = (string)$dc->creator;

                if ($this->callback) {
                    $data = call_user_func($this->callback, $data, $item);
                }

                $this->data[] = $data;
            }
        }
        else if (isset($xml->title)) {
            // Assign the channel data
            $this->channel_data['title'] = $xml->title;
            $this->channel_data['description'] = $xml->subtitle;

            // Build the item array
            foreach ($xml->entry as $item) {
                $data = [];
                $data['id'] = (string)$item->id;
                $data['title'] = (string)$item->title;
                $data['description'] = (string)preg_replace('#<img(.*)/>#', '', $item->content);
                $data['pubDate'] = (string)$item->published;
                $data['link'] = (string)$item->link['href'];
                $dc = $item->children('http://purl.org/dc/elements/1.1/');
                $data['author'] = (string)$dc->creator;

                if ($this->callback) {
                    $data = call_user_func($this->callback, $data, $item);
                }

                $this->data[] = $data;
            }
        }

        // Do we need to write the cache file?
        if ($this->write_cache_flag) {
            if (!$fp = @fopen($filename, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
                log_message('error', "Unable to write cache file: ".$filename);

                return;
            }

            flock($fp, LOCK_EX);
            fwrite($fp, $rawFeed);
            flock($fp, LOCK_UN);
            fclose($fp);
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    function set_cache_life($period = null)
    {
        $this->cache_life = $period;

        return $this;
    }

    // --------------------------------------------------------------------

    function set_feed_url($url = null)
    {
        $this->feed_uri = $url;

        return $this;
    }

    // --------------------------------------------------------------------

    /* Return the feeds one at a time: when there are no more feeds return false
     * @param No of items to return from the feed
     * @return Associative array of items
    */
    function getFeed($num)
    {
        $this->parse();

        $c = 0;
        $return = [];

        foreach ($this->data AS $item) {
            $return[] = $item;
            $c++;

            if ($c == $num) {
                break;
            }
        }

        return $return;
    }

    // --------------------------------------------------------------------

    /* Return channel data for the feed */
    function & getChannelData()
    {
        $flag = FALSE;

        if (!empty($this->channel_data)) {
            return $this->channel_data;
        }
        else {
            return $flag;
        }
    }

    // --------------------------------------------------------------------

    /* Were we unable to retreive the feeds ?  */
    function errorInResponse()
    {
        return $this->feed_unavailable;
    }

    // --------------------------------------------------------------------

    /* Initialize the feed data */
    function clear()
    {
        $this->feed_uri = null;
        $this->data = FALSE;
        $this->channel_data = [];
        $this->cache_life = 0;
        $this->callback = FALSE;

        return $this;
    }
}
