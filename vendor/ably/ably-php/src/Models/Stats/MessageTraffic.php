<?php
namespace Ably\Models\Stats;

/**
 * MessageTraffic contains a breakdown of summary stats data for traffic over
 * various transport types
 */
class MessageTraffic {
    /**
	 * @var \Ably\Models\Stats\MessageTypes $all All messages count (includes realtime, rest and webhook messages).
	 * @var \Ably\Models\Stats\MessageTypes $realtime Count of messages transferred over a realtime transport such as WebSockets.
	 * @var \Ably\Models\Stats\MessageTypes $rest Count of messages transferred using REST.
	 * @var \Ably\Models\Stats\MessageTypes $webhook Count of messages delivered using WebHooks.
     */
	public $all;
	public $realtime;
	public $rest;
	public $webhook;

	public function __construct() {
		$this->all      = new MessageTypes();
		$this->realtime = new MessageTypes();
		$this->rest     = new MessageTypes();
		$this->webhook  = new MessageTypes();
	}
}