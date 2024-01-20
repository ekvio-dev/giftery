<?php

declare(strict_types=1);


namespace App\Request;


enum HttpMethod: string
{
    case GET = 'GET';
    case POST = 'POST';

    public function isPost(): bool
    {
        return $this === self::POST;
    }

    public function isGet(): bool
    {
        return $this === self::GET;
    }
}