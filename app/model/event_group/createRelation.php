<?php

try {
    $event_id = getRequestValue('event_id');
    $group_id = getRequestValue('group_id');
    if (!isset($group_id, $event_id)) {
        throw new \exception\ApplicationException('Не переданы идентификаторы группы и события', 400);
    }
    if (require_once APP_ROOT . '/model/event_group/validateRelations.php') {
        return execute('event_group' . DIRECTORY_SEPARATOR . 'create_relation.sql', ['event_id' => $event_id, 'group_id' => $group_id],
        ['event_id' => PDO::PARAM_INT, 'group_id' => PDO::PARAM_INT]);
    }
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при привязке группы и события');
}
