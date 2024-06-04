<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function (array $context) {
    $groupsIds = $context['groupsIds'];
    if (!isset($groupsIds)) {
        return "Не переданы группы события";
    }
    $listOfGroups = [];
    foreach (query(file_get_contents(APP_ROOT .  '/query/groups/get_groups.sql')) as $item) {
        $listOfGroups[] = $item['id'];
    }
    foreach ($groupsIds as $groupId) {
        if (!in_array($groupId, $listOfGroups)) {
            return "Указанной группы не существует";
        }
    }
    return true;
};