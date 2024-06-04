<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function (array $context) {
    $beginTime = $context['beginTime'];
    $teacher = $context['teacher'];
    if (!isset($teacher, $beginTime)) {
        return 'Не переданы время и преподаватель события';
    }
    $query = file_get_contents(APP_ROOT . '/query/rules/event_time_teacher.sql');
    $params = ['beginTime' => $beginTime, 'teacher' => $teacher];
    $types = ['beginTime' => PDO::PARAM_STR, 'teacher' => PDO::PARAM_STR];
    if (isset($context['eventId'])) {
        $query .= ' AND eventId != :eventId';
        $params['eventId'] = $context['eventId'];
        $types['eventId'] = PDO::PARAM_INT;
    }
    if (!(bool)singleQuery($query, $params, $types)) {
        return true;
    }
    return 'Преподаватель занят в это время';
};