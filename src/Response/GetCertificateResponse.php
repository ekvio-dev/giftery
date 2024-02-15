<?php

declare(strict_types=1);


namespace Giftery\Response;


use Giftery\Exception\GifterySdkException;
use Giftery\Request\Command;

class GetCertificateResponse extends ApiResponse
{
    private string $content;
    public function __construct(array $data)
    {
        parent::__construct(Command::GET_CERTIFICATE->value, $data);
        $content = base64_decode(ChangeApiGuard::getValue($data['data'], 'certificate', 'getCertificate.data.certificate', $data));
        if (!$content) {
            throw new GifterySdkException('Failed base64 decode string', $data);
        }

        $this->content = $content;
    }

    public function certificate(): string
    {
        return $this->content;
    }
}