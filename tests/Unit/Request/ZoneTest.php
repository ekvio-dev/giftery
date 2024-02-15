<?php

declare(strict_types=1);


namespace Giftery\Tests\Unit\Request;


use Giftery\Request\Zone;
use PHPUnit\Framework\TestCase;

class ZoneTest extends TestCase
{
    public function testCreateEmptyZone(): void
    {
        $zone = Zone::createEmpty();

        $this->assertNull($zone->area());
        $this->assertNull($zone->locality());
    }

    public function testCreateNonEmptyZone(): void
    {
        $zone = Zone::createFrom('area', 'locality');

        $this->assertEquals('area', $zone->area());
        $this->assertEquals('locality', $zone->locality());
    }
}