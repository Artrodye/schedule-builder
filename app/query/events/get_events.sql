SELECT events.eventId,
     events.name,
     events.begin_time,
     events.room,
     events.teacher,
     events.isManyGroups,
     events.comment,
     event_group.group_id FROM events
LEFT JOIN event_group
ON event_group.event_id = events.eventId
