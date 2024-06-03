SELECT events.name,
       events.begin_time,
       events.room,
       events.teacher,
       events.isManyGroups,
       events.comment
FROM events
INNER JOIN event_group
ON events.eventId = event_group.event_id AND
   event_group.group_id = ?