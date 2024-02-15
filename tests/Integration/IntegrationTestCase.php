<?php

declare(strict_types=1);


namespace Giftery\Tests\Integration;


use Giberti\PHPUnitLocalServer\LocalServerTestCase;

class IntegrationTestCase extends LocalServerTestCase
{
    public static function setUpBeforeClass(): void
    {
        static::createServerWithDocroot('./tests/Integration/Fixture');
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
    }
}