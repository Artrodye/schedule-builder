<?php

return function (array $groups): array
{
    $groupsData = [];
    foreach ($groups as $group) {
        if (!isset($groupsData[$group['id']])) {
            $groupsData[$group['id']] = ['id' => $group['id'], 'name' => $group['name']];
        }
    }
    return array_values($groupsData);
};
