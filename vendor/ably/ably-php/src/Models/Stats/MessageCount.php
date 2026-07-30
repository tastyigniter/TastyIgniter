<?php
namespace Ably\Models\Stats;

/**
 * MessageCount contains aggregate counts for messages and data transferred
 */
#[\AllowDynamicProperties]
class MessageCount {
    /**
	 * @var int $count Count of all messages.
	 * @var int $data Total data transferred for all messages in bytes.
     */
	public $count;
	public $data;

	public function __construct() {
		$this->count = 0;
		$this->data  = 0;
	}
}
