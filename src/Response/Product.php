<?php

declare(strict_types=1);


namespace Giftery\Response;

use Giftery\Exception\ChangeApiException;

/**
 * @see https://docs.giftery.tech/b2b-api/methods/getProducts/
 */
class Product
{
    private int $id;


    private string $title;
    private string $url;
    private string $brief;
    private int $supplierId;
    private ?int $certsInOnePurchase;
    private string $region;
    private string $code;
    /**
     * @var array<string,string>
     */
    private array $images;
    /**
     * @var array<int,int>
     */
    private array $categories;
    /**
     * @var array<int,int>
     */
    private array $faces;
    private int $faceStep;
    private string $digitalAcceptance;
    private bool $isMerchantCert;
    private bool $isPredefinedCert;
    private int $activationDelay;
    private int $faceMin;
    private int $faceMax;
    private string $www;
    private string $disclaimer;
    private string $catalogComment;
    private float $faceMultiplier;
    private function __construct(){}

    /**
     * @param array<string,mixed> $state
     * @return self
     */
    public static function fromApi(array $state): self
    {
        $self = new self();
        $self->id = (int) $state['id'];
        $self->title = $state['title'];
        $self->url = $state['url'];
        $self->brief = $state['brief'];
        $self->supplierId = $state['supplier_id'];
        $self->certsInOnePurchase = $state['certificates_in_one_purchase'];
        $self->region = $state['region'];
        $self->code = $state['code'];
        $self->images = $state['main_image'];
        $self->categories = $state['categories'];
        $self->faces = $self->parseFaces($state['faces']);
        $self->faceStep = (int) $state['face_step'];
        $self->digitalAcceptance = $state['digital_acceptance'];
        $self->isMerchantCert = !($state['is_merchant_cert'] === '0');
        $self->isPredefinedCert = !($state['is_predefined_cert'] === '0');
        $self->activationDelay = (int) $state['activation_delay'];
        $self->faceMin = (int) $state['face_min'];
        $self->faceMax = (int) $state['face_max'];
        $self->www = $state['www'];
        $self->disclaimer = $state['disclaimer'];
        $self->catalogComment = $state['catalog_comment'];
        $self->faceMultiplier = (float) $state['face_multiplier'];

        return $self;
    }

    /**
     * @param array<int,string> $faces
     * @return array<int,int>
     */
    private function parseFaces(array $faces): array
    {
        $data = [];
        foreach ($faces as $key => $face) {
            $data[$key] = (int) $face;
        }

        return $data;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function brief(): string
    {
        return $this->brief;
    }

    public function supplierId(): int
    {
        return $this->supplierId;
    }

    public function certsInOnePurchase(): ?int
    {
        return $this->certsInOnePurchase;
    }

    public function region(): string
    {
        return $this->region;
    }

    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return array<string,string>
     */
    public function images(): array
    {
        return $this->images;
    }

    /**
     * @return array<int,int>
     */
    public function categories(): array
    {
        return $this->categories;
    }

    /**
     * @return array<int,int>
     */
    public function faces(): array
    {
        return $this->faces;
    }

    public function faceStep(): int
    {
        return $this->faceStep;
    }

    public function digitalAcceptance(): string
    {
        return $this->digitalAcceptance;
    }

    public function isMerchantCert(): bool
    {
        return $this->isMerchantCert;
    }

    public function isPredefinedCert(): bool
    {
        return $this->isPredefinedCert;
    }

    public function activationDelay(): int
    {
        return $this->activationDelay;
    }

    public function faceMin(): int
    {
        return $this->faceMin;
    }

    public function faceMax(): int
    {
        return $this->faceMax;
    }

    public function www(): string
    {
        return $this->www;
    }

    public function disclaimer(): string
    {
        return $this->disclaimer;
    }

    public function catalogComment(): string
    {
        return $this->catalogComment;
    }

    public function faceMultiplier(): float
    {
        return $this->faceMultiplier;
    }
}