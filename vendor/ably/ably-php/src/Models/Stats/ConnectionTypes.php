<?php
namespace Ably\Models\Stats;

/**
 * ConnectionTypes contains a breakdown of summary stats data for different
 * (TLS vs non-TLS) connection types
 */
class ConnectionTypes {
    /**
	 * @var \Ably\Models\Stats\ResourceCount $all All connection count (includes both TLS & non-TLS connections).
	 * @var \Ably\Models\Stats\ResourceCount $plain Non-TLS connection count (unencrypted).
	 * @var \Ably\Models\Stats\ResourceCount $tls TLS connection count.
     */
	public $all;
	public $plain;
	public $tls;

	public function __construct() {
		$this->all   = new ResourceCount();
		$this->plain = new ResourceCount();
		$this->tls   = new ResourceCount();
	}
}