<?php
namespace Ably\Models\Stats;

/**
 * MessageTypes contains a breakdown of summary stats data for different
 * (message vs presence) message types
 */
class MessageTypes {
    /**
	 * @var \Ably\Models\Stats\MessageCount $all All messages count (includes both presence & messages).
	 * @var \Ably\Models\Stats\MessageCount $messages Count of channel messages.
	 * @var \Ably\Models\Stats\MessageCount $presence Count of presence messages.
     */
	public $all;
	public $messages;
	public $presence;

	public function __construct() {
		$this->all = new MessageCount();
		$this->messages = new MessageCount();
		$this->presence = new MessageCount();
	}
}