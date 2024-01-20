<?php

declare(strict_types=1);


namespace App\Response;

use App\Exception\ChangeApiException;

class GetBalanceResponse extends ApiResponse
{
    private int $balance;
    public function __construct(array $data)
    {
        parent::__construct('getBalance', $data);
        $this->balance = ChangeApiGuard::getValue($data['data'], 'balance', 'getBalance.data.balance', $data);
    }

    public function balance(): int
    {
        return $this->balance;
    }
}