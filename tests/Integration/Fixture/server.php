<?php

declare(strict_types=1);

echo sprintf('%s|%s|%s|%s',
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['QUERY_STRING'],
    $_SERVER['CONTENT_TYPE'] ?? '',
    file_get_contents('php://input')
);