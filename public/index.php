<?php

define('APP_ROOT', dirname(__DIR__) . '/app');

require_once APP_ROOT . '/bootstrap.php';

try {
    $result = require_once getRoute();
    sendSuccess($result);
} catch (Throwable $throwable) {
    sendFailure($throwable);
}
