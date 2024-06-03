<?php

function getRoute(): string
{
    $model = getRequestValue('model');
    $action = getRequestValue('action');

    if (!isset($model, $action)) {
        throw new \exception\ApplicationException('Нельзя определить путь', 400);
    }

    $fileLocation = APP_ROOT . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $model . DIRECTORY_SEPARATOR . $action . '.php';
    if (file_exists($fileLocation)) {
        return $fileLocation;
    } else {
        throw new \exception\ApplicationException('Не найден исполняемый файл', 404);
    }
}