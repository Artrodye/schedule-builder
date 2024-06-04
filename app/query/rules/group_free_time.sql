SELECT DISTINCT event_group.group_id as groupId, events.begin_time as beginTime FROM events
INNER JOIN event_group
