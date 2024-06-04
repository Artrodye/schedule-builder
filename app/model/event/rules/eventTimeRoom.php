<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function (array $context) {
    if (!isset($context['beginTime'], $context['room'])) {
        return 'Не переданы время и аудитория события';
    }
    $beginTime = $context['beginTime'];
    $room = $context['room'];
    $query = file_get_contents(APP_ROOT . '/query/rules/event_time_room.sql');
    $params = ['beginTime' => $beginTime, 'room' => $room];
    $types = ['beginTime' => PDO::PARAM_STR, 'room' => PDO::PARAM_STR];
    if (isset($context['eventId'])) {
        $query .= ' AND eventId != :eventId';
        $params['eventId'] = $context['eventId'];
        $types['eventId'] = PDO::PARAM_INT;
    }
    if (!(bool)singleQuery($query, $params, $types)) {
        return true;
    }
    return 'Аудитория в это время занята';
};