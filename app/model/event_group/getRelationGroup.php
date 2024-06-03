<?php

try {
    $group_id = getRequestValue('group_id');
    if (is_null($group_id)) {
        throw new \exception\ApplicationException('Не передан идентификатор группы', 400);
    }
    return query('event_group' . DIRECTORY_SEPARATOR . 'get_relation_group.sql', ['group_id' => $group_id], ['group_id' => PDO::PARAM_INT]);
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при получении привязок событий и группы');
}