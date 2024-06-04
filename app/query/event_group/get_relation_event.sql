SELECT groups.id
FROM groups
INNER JOIN event_group
ON groups.id = event_group.group_id
where event_group.event_id = :eventId