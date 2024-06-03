<?php

return function (array $events): array
{
    $eventsData = [];
    foreach ($events as $event) {
        if (!isset($eventsData[$event['eventId']])) {
            $eventsData[$event['eventId']] = ['eventId' => $event['eventId'], 'name' => $event['name'], 'beginTime' => $event['begin_time'], 'room' => $event['room'], 'teacher' => $event['teacher'], 'isManyGroups' => $event['isManyGroups'], 'comment' => $event['comment'], 'groupsIds' => []];
        }
        if (isset($event['group_id'])) {
            $eventsData[$event['eventId']]['groupsIds'][] = $event['group_id'];
        }
    }
    return array_values($eventsData);
};