<?php

declare(strict_types=1);


namespace App\Response;


class MakeOrderResponse extends ApiResponse
{
    private int $id;

    public function __construct(array $data)
    {
        parent::__construct('makeOrder', $data);
        $this->id = ChangeApiGuard::getValue($data['data'], 'id', 'makeOrder.data.id', $data);
    }

    public function id(): int
    {
        return $this->id;
    }
}