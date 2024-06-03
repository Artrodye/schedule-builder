<?php

try {
    $result = query(file_get_contents(APP_ROOT . '/query/events/get_events.sql'));
    $fetcher = require 'fetch/eventFetcher.php';
    return $fetcher($result);
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при получении событий');
}