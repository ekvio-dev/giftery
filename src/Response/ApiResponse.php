<?php

declare(strict_types=1);


namespace App\Response;


use App\Exception\ChangeApiException;
use App\Exception\GifteryApiException;

abstract class ApiResponse
{
    protected const UNKNOWN_ERROR_CODE = -1;
    protected const UNKNOWN_ERROR_TEXT = 'unknown';
    protected const STATUS_OK = 'ok';
    protected const STATUS_ERROR = 'error';
    protected const STATUS = [self::STATUS_OK, self::STATUS_ERROR];

    /**
     * @param string $command
     * @param array<string,mixed> $data
     * @throws ChangeApiException
     * @throws GifteryApiException
     */
    public function __construct(string $command, array $data)
    {
        if (!isset($data['status'])) {
            throw new ChangeApiException('status', $data);
        }

        $status = $data['status'];
        if (!in_array($status, self::STATUS, true)) {
            throw new ChangeApiException('status', $data);
        }

        if ($status === self::STATUS_ERROR) {
            throw new GifteryApiException(
                $data['error']['code'] ?? self::UNKNOWN_ERROR_CODE, $data['error']['code'] ?? self::UNKNOWN_ERROR_TEXT, $data);
        }

        if ($status === self::STATUS_OK) {
            if (!array_key_exists('data', $data) || !is_array($data['data'])) {
                throw new ChangeApiException($command, $data);
            }
        }
    }
}