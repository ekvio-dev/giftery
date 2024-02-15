<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Request\Command;

class GetCodeResponse extends ApiResponse
{
    private string $code;
    private ?string $pin;
    private ?string $expireAt;
    private ?string $format = null;
    public function __construct(array $data)
    {
        parent::__construct(Command::GET_CODE->value, $data);
        $this->code = ChangeApiGuard::getValue($data['data'], 'code', 'getCode.data.code', $data);
        $pin = ChangeApiGuard::getValue($data['data'], 'pin', 'getCode.data.pin', $data);
        $this->pin = !empty($pin) ? $pin : null;
        $this->expireAt = ChangeApiGuard::getValue($data['data'], 'expire_date', 'getCode.data.expire_date', $data);
        if (array_key_exists('format', $data['data'])) {
            $this->format = $data['data']['format'];
        }
    }

    public function code(): string
    {
        return $this->code;
    }

    public function pin(): ?string
    {
        return $this->pin;
    }

    public function expireDate(): ?string
    {
        return $this->expireAt;
    }

    public function format(): ?string
    {
        return $this->format;
    }
}