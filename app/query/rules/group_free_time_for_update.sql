SELECT DISTINCT events.begin_time FROM events
INNER JOIN event_group
ON event_group.group_id = :groupId AND
   events.eventId != :eventId
