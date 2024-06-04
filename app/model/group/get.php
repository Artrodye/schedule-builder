<?php

try {
    $result = query(file_get_contents(APP_ROOT . '/query/groups/get_groups.sql'));
    $fetcher = require_once 'fetch/groupFetcher.php';
    return $fetcher($result);
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при получении групп');
}
