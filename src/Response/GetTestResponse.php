<?php

declare(strict_types=1);


namespace App\Response;


class GetTestResponse extends ApiResponse
{
    private string $text;
    /**
     * @var array<int,string>
     */
    private array $methods;
    public function __construct(array $data)
    {
        parent::__construct('test', $data);
        $this->text = ChangeApiGuard::getValue($data['data'], 'sample_text', 'test.data.sample_text', $data);
        $this->methods = ChangeApiGuard::getValue($data['data'], 'available_methods', 'test.data.available_methods', $data);
    }

    public function text(): string
    {
        return $this->text;
    }

    /**
     * @return array<int,string>
     */
    public function methods(): array
    {
        return $this->methods;
    }
}