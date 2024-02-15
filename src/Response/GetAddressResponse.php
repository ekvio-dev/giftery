<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Request\Command;

class GetAddressResponse extends ApiResponse
{
    private Addresses $addresses;
    public function __construct(array $data)
    {
        parent::__construct(Command::GET_ADDRESS->value, $data);
        $this->addresses = new Addresses($data);
    }

    public function addresses(): Addresses
    {
        return $this->addresses;
    }
}