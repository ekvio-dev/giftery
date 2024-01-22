<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Exception\ChangeApiException;

class GetStatusResponse extends ApiResponse
{
    private const ERROR_ORDER_STATUS = 'error';
    private int $id;
    private string $status;
    private ?int $orderId;
    private int $productId;
    private int $face;
    private ?int $balance;
    private ?int $sum;
    private string $expireDate;
    private string $code;
    private string $comment;
    private ?string $externalId;
    private ?string $link = null;
    private bool $testMode;
    private ?int $errorCode = null;
    private ?string $errorText = null;
    public function __construct(array $data)
    {
        parent::__construct('getStatus', $data);

        if (!is_array($data['data'])) {
            throw new ChangeApiException('getStatus.data', $data);
        }

        $this->id = ChangeApiGuard::getValue($data['data'], 'id', 'getStatus.data.id', $data);
        $this->status = ChangeApiGuard::getValue($data['data'], 'status', 'getStatus.data.status', $data);
        $this->orderId = ChangeApiGuard::getValue($data['data'], 'order_id', 'getStatus.data.order_id', $data);
        $this->productId = ChangeApiGuard::getValue($data['data'], 'product_id', 'getStatus.data.product_id', $data);
        $this->face = ChangeApiGuard::getValue($data['data'], 'face', 'getStatus.data.face', $data);
        $this->balance = ChangeApiGuard::getValue($data['data'], 'balance', 'getStatus.data.balance', $data);
        $this->sum = ChangeApiGuard::getValue($data['data'], 'sum', 'getStatus.data.sum', $data);
        $this->expireDate = ChangeApiGuard::getValue($data['data'], 'expire_date', 'getStatus.data.expire_date', $data);
        $this->code = ChangeApiGuard::getValue($data['data'], 'code', 'getStatus.data.code', $data);
        $this->comment = ChangeApiGuard::getValue($data['data'], 'comment', 'getStatus.data.comment', $data);
        $this->externalId = ChangeApiGuard::getValue($data['data'], 'external_id', 'getStatus.data.external_id', $data) ?? null;
        $this->testMode = (bool)ChangeApiGuard::getValue($data['data'], 'testmode', 'getStatus.data.testmode', $data);
        $this->link = $data['data']['link'] ?? null;

        if ($this->status === self::ERROR_ORDER_STATUS) {
            $this->errorCode = $data['data']['error_code'] ?? null;
            $this->errorText = $data['data']['error_text'] ?? null;
        }
    }

    public function id(): int
    {
        return $this->id;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function orderId(): ?int
    {
        return $this->orderId;
    }

    public function productId(): int
    {
        return $this->productId;
    }

    public function face(): int
    {
        return $this->face;
    }

    public function balance(): ?int
    {
        return $this->balance;
    }

    public function sum(): ?int
    {
        return $this->sum;
    }

    public function expireDate(): string
    {
        return $this->expireDate;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function externalId(): ?string
    {
        return $this->externalId;
    }

    public function testMode(): bool
    {
        return $this->testMode;
    }

    public function link(): ?string
    {
        return $this->link;
    }

    public function errorCode(): ?int
    {
        return $this->errorCode;
    }

    public function errorText(): ?string
    {
        return $this->errorText;
    }
}