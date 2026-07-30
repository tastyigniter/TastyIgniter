<?php

namespace Ratchet\RFC6455\Test;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class AbResultsTest extends TestCase {
    private function verifyAutobahnResults(string $fileName): void {
        if (!file_exists($fileName)) {
            $this->markTestSkipped('Autobahn TestSuite results not found');
        }

        $resultsJson = file_get_contents($fileName);
        $results = json_decode($resultsJson);
        $agentName = array_keys(get_object_vars($results))[0];

        foreach ($results->$agentName as $name => $result) {
            if ($result->behavior === "INFORMATIONAL") {
                continue;
            }

            $this->assertTrue(in_array($result->behavior, ["OK", "NON-STRICT"]), "Autobahn test case " . $name . " in " . $fileName);
        }
    }

    public function testAutobahnClientResults(): void {
        $this->verifyAutobahnResults(__DIR__ . '/ab/reports/clients/index.json');
    }

    public function testAutobahnServerResults(): void {
        $this->verifyAutobahnResults(__DIR__ . '/ab/reports/servers/index.json');
    }
}
