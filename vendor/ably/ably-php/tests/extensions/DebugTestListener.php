<?php
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;

final class DebugTestListener implements TestListener
{
    use TestListenerDefaultImplementation;

    public function startTestSuite(PHPUnit\Framework\TestSuite $suite): void
    {
        echo "Suite \"" . $suite->getName() . "\"\n";
    }

    public function endTestSuite(PHPUnit\Framework\TestSuite $suite): void
    {
        echo "\n\n";
    }
    
    public function startTest(PHPUnit\Framework\Test $test): void
    {
        echo "\n" . $test->getName().'... ';
    }

    public function endTest(PHPUnit\Framework\Test $test, $time): void
    {
        echo "(" . round($time * 1000) . " ms)";
    }
}
