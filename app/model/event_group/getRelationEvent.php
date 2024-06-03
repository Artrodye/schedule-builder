<?php

try {
    $event_id = getRequestValue('event_id');
    if (is_null($event_id)) {
        throw new \exception\ApplicationException('Не передан идентификатор события', 400);
    }
    return query('event_group' . DIRECTORY_SEPARATOR . 'get_relation_event.sql', ['event_id' => $event_id], ['event_id' => PDO::PARAM_INT]);
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при получении привязок события и групп');
}