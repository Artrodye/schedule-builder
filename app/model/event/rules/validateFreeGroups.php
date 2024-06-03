<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function (array $context) {
    $beginTime = $context['beginTime'];
    $groupsIds = $context['groupsIds'];
    if (!isset($beginTime, $groupsIds)) {
        return 'Не переданы время и группы события';
    }
    $query = file_get_contents(APP_ROOT . '/query/rules/group_free_time.sql');
    $params = [];
    $types = [];
    if (isset($context['eventId'])) {
        $query .= ' ON events.eventId != :eventId';
        $params = ['eventId' => $context['eventId']];
        $types = ['eventId' => PDO::PARAM_INT];
    }
    $result = query($query, $params, $types);
    $failureGroups = [];
    foreach ($groupsIds as $groupId) {
        if (in_array(['groupId' => $groupId, 'beginTime' => $beginTime], $result)) {
            $failureGroups[] = $groupId;
        }
    }
    if (empty($failureGroups)) {
        return true;
    }
    return 'У групп ' . implode(', ', $failureGroups) . ' пары в это время';
};