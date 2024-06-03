<?php

try {
    $event_id = getRequestValue('event_id');
    $group_id = getRequestValue('group_id');
    if (!isset($group_id, $event_id)) {
        throw new \exception\ApplicationException('Не переданы идентификаторы группы и события', 400);
    }
    return execute('event_group' . DIRECTORY_SEPARATOR . 'delete_relation.sql', ['event_id' => $event_id, 'group_id' => $group_id],
    ['event_id' => PDO::PARAM_INT, 'group_id' => PDO::PARAM_INT]);
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при выполнении');
}