<?php

use exception\ApplicationException;

try {
    $beginTimes = [];
    $context = requestToArray();
    extract($context);
    $validator = require APP_ROOT . '/model/event/validateEvents.php';
    if ((int)$times !== 1 && !isset($period)) {
        throw new ApplicationException('Не переданы параметры события для периодизации', 400);
    }
    if (!isset($name, $beginTime, $teacher, $room, $isManyGroups, $comment, $groupsIds)) {
        throw new ApplicationException('Не переданы параметры события для создания', 400);
    }
    $context['beginTime'] = date_create_from_format('Y-m-d H:i:s', $beginTime)->format('Y-m-d H:i:s');
    $validator($context);
    $beginTimes[] = $context['beginTime'];
    foreach (range(1, $times) as $time) {
        $newEventDate = date_add(
            date_create_from_format('Y-m-d H:i:s', $beginTime),
            new DateInterval('P' . "$time" . $period)
        )->format('Y-m-d H:i:s');
        $beginTimes[] = $context['beginTime'] = $newEventDate;

        $validator($context);
    }
    beginTransaction();
    foreach ($beginTimes as $beginTime) {
        $query = file_get_contents(APP_ROOT . '/query/events/create_event.sql');
        $params = [
            'name' => $name,
            'beginTime' => $beginTime,
            'teacher' => $teacher,
            'room' => $room,
            'isManyGroups' => $isManyGroups,
            'comment' => $comment
        ];
        $types = ['isManyGroups' => PDO::PARAM_BOOL];

        if (execute($query, $params, $types)) {
            $eventId = singleQuery(file_get_contents(APP_ROOT . '/query/events/get_event_id.sql'), $params, $types);

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
        }
    }
    commit();
    return true;
} catch (ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    rollback();
    throw new ApplicationException('Возникла ошибка при создании события');
}