<?php
namespace Ably\Models\Stats;

/**
 * ResourceCount contains aggregate data for usage of a resource in a specific
 * scope
 */
class ResourceCount {
    /**
	 * @var int $mean Average resources of this type used for this period.
	 * @var int $min Minimum total resources of this type used for this period.
	 * @var int $opened Total resources of this type opened.
	 * @var int $peak Peak resources of this type used for this period.
	 * @var int $refused Resource requests refused within this period.
     */
	public $mean;
	public $min;
	public $opened;
	public $peak;
	public $refused;

	public function __construct() {
		$this->mean    = 0;
		$this->min     = 0;
		$this->opened  = 0;
		$this->peak    = 0;
		$this->refused = 0;
	}
}