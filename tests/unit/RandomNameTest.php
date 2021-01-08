<?php

/**
 * Class RandomNameTest
 */
class RandomNameTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /**
     * @return string
     */
    public function randomName(): string
    {
        return 'test';
    }

    // tests
    public function testSomeFeature()
    {
        $name = $this->randomName();
        self::assertNotNull($name);
    }
}