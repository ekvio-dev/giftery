<?php

declare(strict_types=1);


namespace Giftery\Response;


final class Category
{
    private int $id;
    private ?string $code;
    private ?string $url;
    private ?string $title;
    private ?string $titleEn;
    private string $type;
    private bool $active;
    private ?string $seoH1;
    private ?string $seoText;
    private int $sort;
    private ?string $visibleSince;
    private ?string $visibleUntil;
    private bool $visibleYearly;
    private int $productsCount;
    private int $elements;
    private ?string $region;

    /**
     * @param array<string,mixed> $state
     * @return static
     */
    public static function fromApi(array $state): static
    {
        $self = new static();
        $self->id = (int) $state['id'];
        $self->code = $state['code'];
        $self->url = $state['url'];
        $self->title = getOrNull($state['title']);
        $self->titleEn = getOrNull($state['title_en']);
        $self->type = $state['type'];
        $self->active = (bool) $state['active'];
        $self->seoH1 = getOrNull($state['seo_h1']);
        $self->seoText = getOrNull($state['seo_text']);
        $self->sort = (int) $state['sort'];
        $self->visibleSince = getOrNull($state['visible_since']);
        $self->visibleUntil = getOrNull($state['visible_until']);
        $self->visibleYearly = (bool) $state['visible_yearly'];
        $self->productsCount = (int) $state['products_count'];
        $self->elements = (int) $state['elements'];
        $self->region = getOrNull($state['region']);

        return $self;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function code(): ?string
    {
        return $this->code;
    }

    public function url(): ?string
    {
        return $this->url;
    }

    public function title(): ?string
    {
        return $this->title;
    }

    public function titleEn(): ?string
    {
        return $this->titleEn;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function active(): bool
    {
        return $this->active;
    }

    public function seoH1(): ?string
    {
        return $this->seoH1;
    }

    public function seoText(): ?string
    {
        return $this->seoText;
    }

    public function sort(): int
    {
        return $this->sort;
    }

    public function visibleSince(): ?string
    {
        return $this->visibleSince;
    }

    public function visibleUntil(): ?string
    {
        return $this->visibleUntil;
    }

    public function visibleYearly(): bool
    {
        return $this->visibleYearly;
    }

    public function productsCount(): int
    {
        return $this->productsCount;
    }

    public function elements(): int
    {
        return $this->elements;
    }

    public function region(): ?string
    {
        return $this->region;
    }
}