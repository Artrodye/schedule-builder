<?php

$request = null;

function createFromGlobal(): void
{
    global $context;

    $json = json_decode(file_get_contents('php://input'), true) ?: [];
    $context = array_merge($_GET, $_POST, $json);
}

function requestToArray(): array
{
    global $context;
    if (!isset($context)) {
        createFromGlobal();
    }
    return $context;
}

/**
 * @param string $key
 * @param mixed $default
 * @return mixed|null
 */
function getRequestValue(string $key, $default = null)
{
    global $context;
    if (!isset($context)) {
        createFromGlobal();
    }

    return $context[$key] ?? $default;
}