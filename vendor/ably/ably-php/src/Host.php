<?php
namespace Ably;

class Host {
    private $primaryHost;
    private $fallbackHosts;
    private $hostCache;

    public function __construct($clientOptions)
    {
        $this->primaryHost = $clientOptions->getPrimaryRestHost();
        $this->fallbackHosts = $clientOptions->getFallbackHosts();
        $this->hostCache = new HostCache($clientOptions->fallbackRetryTimeout);
    }

    public function fallbackHosts($currentHost) {
        if ($currentHost != $this->primaryHost) {
            yield $this->primaryHost;
        }
        $shuffledFallbacks = $this->fallbackHosts;
        shuffle($shuffledFallbacks);
        foreach ($shuffledFallbacks as $fallbackHost) {
            if ($currentHost != $fallbackHost) {
                yield $fallbackHost;
            }
        }
    }

    // getPreferredHost - Used to retrieve host in the order 1. Cached host 2. primary host
    public function getPreferredHost() {
        $host = $this->hostCache->get();
        if (empty($host)) {
            return $this->primaryHost;
        }
        return $host;
    }

    public function setPreferredHost($host) {
        $this->hostCache->put($host);
    }
}

