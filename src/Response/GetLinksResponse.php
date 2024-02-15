<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Request\Command;

class GetLinksResponse extends ApiResponse
{
    private ?string $downloadUrl;
    private ?string $exchangeUrl;
    public function __construct(array $data)
    {
        parent::__construct(Command::GET_LINKS->value, $data);
        $this->downloadUrl = ChangeApiGuard::getValue($data['data'], 'download_url', 'getLinks.data.download_url', $data);
        $this->exchangeUrl = ChangeApiGuard::getValue($data['data'], 'exchange_url', 'getLinks.data.exchange_url', $data);
    }

    public function downloadUrl(): ?string
    {
        return $this->downloadUrl;
    }

    public function exchangeUrl(): ?string
    {
        return $this->exchangeUrl;
    }
}