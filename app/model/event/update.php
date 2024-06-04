<?php

try {
    $context = requestToArray();
    extract($context);
    if (!isset($eventId, $name, $beginTime, $teacher, $room, $isManyGroups, $comment, $groupsIds)) {
        throw new \exception\ApplicationException('Не переданы параметры события', 400);
    }
    $validator = require_once APP_ROOT . '/model/event/validateEvents.php';
    if ($validator($context)) {
        beginTransaction();
        execute(
            file_get_contents(APP_ROOT . '/query/event_group/delete_relations_for_event.sql'),
            ['eventId' => $eventId],
            ['eventId' => PDO::PARAM_INT]
        );

        if (!empty($groupsIds)) {
            $query = file_get_contents(APP_ROOT . '/query/event_group/create_relation.sql');
            $count = count($groupsIds);
            foreach ($groupsIds as $index => $groupId) {
                $query .= sprintf(' (%s, %s)', $eventId, $groupId);
                if ($index !== $count - 1) {
                    $query .= ',';
                }
            }
            execute($query);
        }
        execute(
            file_get_contents(APP_ROOT . '/query/events/update_event.sql'),
            ['eventId' => $eventId, 'name' => $name, 'beginTime' => $beginTime, 'teacher' => $teacher, 'room' => $room, 'isManyGroups' => $isManyGroups, 'comment' => $comment],
            ['eventId' => PDO::PARAM_INT, 'isManyGroups' => PDO::PARAM_BOOL]
        );
        commit();
        return true;
    }
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    rollback();
    throw new \exception\ApplicationException('Возникла ошибка при обновлении события');
}