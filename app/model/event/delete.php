<?php

try {
    $eventId = getRequestValue('eventId');
    if (is_null($eventId)) {
        throw new \exception\ApplicationException('Не передан идентификатор события', 400);
    }
    beginTransaction();
    execute(
        file_get_contents(APP_ROOT . '/query/event_group/delete_relations_for_event.sql'),
        ['eventId' => $eventId],
        ['eventId' => PDO::PARAM_INT]
    );
    execute(
        file_get_contents(APP_ROOT . '/query/events/delete_event.sql'),
        ['eventId' => $eventId],
        ['eventId' => PDO::PARAM_INT]
    );
    commit();
    return true;
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    rollback();
    throw new \exception\ApplicationException('Возникла ошибка при удалении события');
}