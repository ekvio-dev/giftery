<?php

declare(strict_types=1);


namespace Giftery\Request;


final class Zone
{
    private ?string $area;
    private ?string $locality;
    private function __construct(?string $area, ?string $locality)
    {
        $this->area = $area;
        $this->locality = $locality;
    }

    public static function createEmpty(): self
    {
        return new self(null, null);
    }

    public static function createFrom(?string $area, ?string $locality): self
    {
        return new self($area, $locality);
    }

    public function area(): ?string
    {
        return $this->area;
    }

    public function locality(): ?string
    {
        return $this->locality;
    }
}