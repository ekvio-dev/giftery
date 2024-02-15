<?php

declare(strict_types=1);

parse_str($_SERVER['QUERY_STRING'] ?? '', $query);
/** @var array<string,string|int|null>  $query */
$code = (int)($query['code'] ?? 200);
$phrase = $query['phrase'] ?? 'OK';
$content = $query['content'] ?? 'Content';

header(sprintf("HTTP/1.1 %s %s", $code, $phrase));
echo $content;