<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Feed_parser Class
 *
 * This class is written based entirely on the work found below
 * www.techbytes.co.in/blogs/2006/01/15/consuming-rss-with-php-the-simple-way/
 * All credit should be given to the original author
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Feed_parser.php
 * @link           http://docs.tastyigniter.com
 */

class Feed_parser {

	public $feed_uri = NULL;                    // Feed URI
	public $data = FALSE;                    // Associative array containing all the feed items
	public $channel_data = array();                    // Store RSS Channel Data in an array
	public $feed_unavailable = NULL;                    // Boolean variable which indicates whether an RSS feed was unavailable
	public $cache_life = 0;                        // Cache lifetime
	public $cache_dir;    // Cache directory
	public $write_cache_flag = FALSE;                    // Flag to write to cache
	public $callback = FALSE;                    // Callback to read custom data

	function __construct($callback = FALSE) {
		if ($callback) {
			$this->callback = $callback;
		}

		$this->cache_dir = APPPATH."cache/";
	}

	// --------------------------------------------------------------------

	function parse() {
		// Are we caching?
		if ($this->cache_life != 0) {
			$filename = $this->cache_dir . 'feed_parser_' . md5($this->feed_uri);

			// Is there a cache file ?
			if (file_exists($filename)) {
				// Has it expired?
				$timedif = (time() - filemtime($filename));

				if ($timedif < ($this->cache_life * 60 * 60)) {
					$rawFeed = @file_get_contents($filename);
				} else {
					// So raise the falg
					$this->write_cache_flag = TRUE;
				}
			} else {
				// Raise the flag to write the cache
				$this->write_cache_flag = TRUE;
			}
		}

		// Reset
		$this->data = array();
		$this->channel_data = array();

		// Parse the document
		if ( ! isset($rawFeed)) {
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
				$data = array();
				$data['title'] = (string) $item->title;
				$data['description'] = (string) preg_replace('#<img(.*)/>#', '', $item->description);
				$data['pubDate'] = (string) $item->pubDate;
				$data['link'] = (string) $item->link;
				$dc = $item->children('http://purl.org/dc/elements/1.1/');
				$data['author'] = (string) $dc->creator;

				if ($this->callback) {
					$data = call_user_func($this->callback, $data, $item);
				}

				$this->data[] = $data;
			}
		} else if (isset($xml->title)) {
			// Assign the channel data
			$this->channel_data['title'] = $xml->title;
			$this->channel_data['description'] = $xml->subtitle;

			// Build the item array
			foreach ($xml->entry as $item) {
				$data = array();
				$data['id'] = (string) $item->id;
				$data['title'] = (string) $item->title;
				$data['description'] = (string) preg_replace('#<img(.*)/>#', '', $item->content);
				$data['pubDate'] = (string) $item->published;
				$data['link'] = (string) $item->link['href'];
				$dc = $item->children('http://purl.org/dc/elements/1.1/');
				$data['author'] = (string) $dc->creator;

				if ($this->callback) {
					$data = call_user_func($this->callback, $data, $item);
				}

				$this->data[] = $data;
			}
		}

		// Do we need to write the cache file?
		if ($this->write_cache_flag) {
			if ( ! $fp = @fopen($filename, FOPEN_WRITE_CREATE_DESTRUCTIVE)) {
				echo "RSSParser error";
				log_message('error', "Unable to write cache file: " . $filename);

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

	function set_cache_life($period = NULL) {
		$this->cache_life = $period;

		return $this;
	}

	// --------------------------------------------------------------------

	function set_feed_url($url = NULL) {
		$this->feed_uri = $url;

		return $this;
	}

	// --------------------------------------------------------------------

	/* Return the feeds one at a time: when there are no more feeds return false
	 * @param No of items to return from the feed
	 * @return Associative array of items
	*/
	function getFeed($num) {
		$this->parse();

		$c = 0;
		$return = array();

		foreach ($this->data AS $item) {
			$return[] = $item;
			$c ++;

			if ($c == $num) {
				break;
			}
		}

		return $return;
	}

	// --------------------------------------------------------------------

	/* Return channel data for the feed */
	function & getChannelData() {
		$flag = FALSE;

		if ( ! empty($this->channel_data)) {
			return $this->channel_data;
		} else {
			return $flag;
		}
	}

	// --------------------------------------------------------------------

	/* Were we unable to retreive the feeds ?  */
	function errorInResponse() {
		return $this->feed_unavailable;
	}

	// --------------------------------------------------------------------

	/* Initialize the feed data */
	function clear() {
		$this->feed_uri = NULL;
		$this->data = FALSE;
		$this->channel_data = array();
		$this->cache_life = 0;
		$this->callback = FALSE;

		return $this;
	}
}

// END Feed_parser Class

/* End of file Feed_parser.php */
/* Location: ./system/tastyigniter/libraries/Feed_parser.php */