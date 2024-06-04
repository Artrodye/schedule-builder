<?php

/**
 * @param mixed $output
 * @return void
 */
function sendSuccess($output): void
{
    header('Content-Type: Application/json');
    http_response_code(200);
    echo json_encode(['success' => true, 'rows' => $output], JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES);
}

function sendFailure(Throwable $throwable): void
{
    header('Content-Type: Application/json');
    $httpResponseCode = 500;
    $responseMessage = 'Возникла ошибка';
    if ($throwable instanceof \exception\ApplicationException) {
        $httpResponseCode = $throwable->getCode();
        $responseMessage = $throwable->getMessage();
    }

    http_response_code($httpResponseCode);
    echo json_encode(['success' => false, 'message' => $responseMessage]);
}