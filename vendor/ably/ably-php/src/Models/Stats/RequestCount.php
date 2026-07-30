<?php
namespace Ably\Models\Stats;

/**
 * RequestCount contains aggregate counts for requests made
 */
class RequestCount {
    /**
	 * @var int $failed Requests failed.
	 * @var int $refused Requests refused typically as a result of permissions or a limit being exceeded.
	 * @var int $succeeded Requests succeeded.
     */
	public $failed;
	public $refused;
	public $succeeded;

	public function __construct() {
		$this->failed    = 0;
		$this->refused   = 0;
		$this->succeeded = 0;
	}
}