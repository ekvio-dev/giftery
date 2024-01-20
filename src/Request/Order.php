<?php

declare(strict_types=1);


namespace App\Request;


use DomainException;
use InvalidArgumentException;
use JsonSerializable as JsonSerializableAlias;

final class Order implements JsonSerializableAlias
{
    private string $uuid;
    private int $productId;
    private int $face;
    private ?string $emailFrom = null;
    private ?string $emailTo = null;
    private ?string $fromName = null;
    private ?string $toName = null;
    private ?string $phoneNumber = null;
    private ?string $dateSend = null;
    private ?string $text = null;
    private ?string $code = null;
    private ?string $comment = null;
    private ?string $externalId = null;
    private ?DeliveryType $deliveryType = null;
    private ?int $ttl = null;
    public function __construct(string $uuid, int $productId, int $face)
    {
        if (mb_strlen(trim($uuid)) === 0) {
            throw new InvalidArgumentException('Order UUID is empty');
        }

        if (mb_strlen($uuid) > 36) {
            throw new InvalidArgumentException('Order UUID is too long. Max 36 symbols');
        }

        if ($productId <= 0 ) {
            throw new InvalidArgumentException('Order product ID must be positive integer');
        }

        if ($face < 0) {
            throw new InvalidArgumentException('Order face must be natural integer');
        }

        $this->uuid = $uuid;
        $this->productId = $productId;
        $this->face = $face;
    }

    public static function OrderWithEmail(string $uuid, int $productId, int $face, string $emailTo): self
    {
        $self = new self($uuid, $productId, $face);
        $self->addEmailTo($emailTo);
        return $self;
    }

    public function addEmailFrom(string $email): self
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Empty email from value');
        }

        if (mb_strlen($email) > 255) {
            throw new InvalidArgumentException('Too long order email from. Max 255 symbols');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid email from format');
        }

        $this->emailFrom = $email;
        return $this;
    }

    public function addEmailTo(string $email): self
    {
        if (empty($email)) {
            throw new InvalidArgumentException('Empty email to value');
        }

        if (mb_strlen($email) > 255) {
            throw new InvalidArgumentException('Too long order email to. Max 255 symbols');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid email to format');
        }

        $this->emailTo = $email;
        return $this;
    }

    public function addFromName(string $from): self
    {
        if (empty($from)) {
            throw new InvalidArgumentException('Empty email from name value');
        }

        if (mb_strlen($from) > 255) {
            throw new InvalidArgumentException('Too long email from name value. Max 255 symbols');
        }

        $this->fromName = $from;
        return $this;
    }

    public function addToName(string $to): self
    {
        if (empty($to)) {
            throw new InvalidArgumentException('Empty email to name value');
        }

        if (mb_strlen($to) > 255) {
            throw new InvalidArgumentException('Too long email to name value. Max 255 symbols');
        }

        $this->toName = $to;
        return $this;
    }

    public function addPhoneNumber(string $number): self
    {
        if (empty($number)) {
            throw new InvalidArgumentException('Empty email to name value');
        }

        if (!str_starts_with($number, '7') || mb_strlen($number) !== 11) {
            throw new InvalidArgumentException('Invalid phone number format. Ex.: 79001234567');
        }

        $this->phoneNumber = $number;
        return $this;
    }

    public function addDateSend(string $datetime): self
    {
        if (empty($datetime)) {
            throw new InvalidArgumentException('Empty date send value');
        }

        if (\DateTimeImmutable::createFromFormat(DATE_ATOM, $datetime) === false) {
            throw new InvalidArgumentException('Invalid datetime format. Ex.: 2024-01-01T22:44:26+00:00');
        }

        $this->dateSend = $datetime;
        return $this;
    }

    public function addText(string $text): self
    {
        if (empty(trim($text))) {
            throw new InvalidArgumentException('Empty text value');
        }

        if (mb_strlen($text) > 512) {
            throw new InvalidArgumentException('Too long text value');
        }

        $this->text = $text;
        return $this;
    }

    public function addCode(string $code): self
    {
        if (empty(trim($code))) {
            throw new InvalidArgumentException('Empty code value');
        }

        if (mb_strlen($code) > 100) {
            throw new InvalidArgumentException('Too long code value');
        }

        if (preg_match('/^[_A-Z0-9]+$/', $code) === false) {
            throw new InvalidArgumentException('Code contains invalid symbols. Use pattern: ^[_A-Z0-9]+$');
        }

        $this->code = $code;
        return $this;
    }

    public function addComment(string $comment): self
    {
        if (empty(trim($comment))) {
            throw new InvalidArgumentException('Empty comment value');
        }

        if (mb_strlen($comment) > 512) {
            throw new InvalidArgumentException('Too long comment value');
        }

        $this->comment = $comment;
        return $this;
    }

    public function addExternalId(string $externalId): self
    {
        if (empty(trim($externalId))) {
            throw new InvalidArgumentException('Empty external id value');
        }

        if (mb_strlen($externalId) > 255) {
            throw new InvalidArgumentException('Too long external id value');
        }

        $this->externalId = $externalId;
        return $this;
    }

    public function addDeliverType(DeliveryType $type): self
    {
        $this->deliveryType = $type;
        return $this;
    }

    public function addOrderTTL(int $ttl): self
    {
        if ($ttl < 60 || $ttl > 86400) {
            throw new InvalidArgumentException('TTL value must be between 60 and 86400');
        }

        $this->ttl = $ttl;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $json = [
            'product_id' => $this->productId,
            'face' => $this->face,
            'uuid' => $this->uuid
        ];

        if ($this->emailFrom) {
            $json['email_from'] = $this->emailFrom;
        }

        if ($this->emailTo) {
            $json['email_to'] = $this->emailTo;
        }

        if ($this->fromName) {
            $json['from'] = $this->fromName;
        }

        if ($this->toName) {
            $json['to'] = $this->toName;
        }

        if ($this->phoneNumber) {
            $json['to_phone'] = $this->phoneNumber;
        }

        if ($this->dateSend) {
            $json['date_send'] = $this->dateSend;
        }

        if ($this->text) {
            $json['text'] = $this->text;
        }

        if ($this->code) {
            $json['code'] = $this->code;
        }

        if ($this->comment) {
            $json['comment'] = $this->comment;
        }

        if ($this->externalId) {
            $json['external_id'] = $this->externalId;
        }

        if ($this->deliveryType) {
            $json['delivery_type'] = $this->deliveryType->value;
        }

        if ($this->ttl) {
            $json['ttl'] = $this->ttl;
        }

        return $json;
    }
}