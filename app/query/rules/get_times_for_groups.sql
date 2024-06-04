SELECT count(DISTINCT events.begin_time)
FROM events
         INNER JOIN event_group
                    ON event_group.event_id = events.id
WHERE event_group.group_id = (SELECT groups.id
                              FROM groups
                                       INNER JOIN event_group
                                                  ON groups.id = event_group.group_id
                              where event_group.event_id = :eventId)
  AND event_group.event_id != :eventId