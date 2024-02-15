<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Request\Command;

/**
 * @see https://docs.giftery.tech/b2b-api/methods/getCategories/
 */
class GetCategoriesResponse extends ApiResponse
{
    /**
     * @var Category[] $categories
     */
    private array $categories;
    public function __construct(array $data)
    {
        parent::__construct(Command::GET_CATEGORIES->value, $data);
        $this->categories = array_map(function (array $item){
            return Category::fromApi($item);
        }, $data['data']);
    }

    /**
     * @return Category[]
     */
    public function categories(): array
    {
        return $this->categories;
    }
}