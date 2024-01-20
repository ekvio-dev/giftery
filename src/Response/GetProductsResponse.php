<?php

declare(strict_types=1);


namespace App\Response;

class GetProductsResponse extends ApiResponse
{
    /**
     * @var array<int,Product>
     */
    private array $products = [];
    public function __construct(array $data)
    {
        parent::__construct('getProducts', $data);

        foreach ($data['data'] as $state) {
            $this->products[] = Product::fromApi($state);
        }
    }

    /**
     * @return Product[]
     */
    public function products(): array
    {
        return $this->products;
    }
}