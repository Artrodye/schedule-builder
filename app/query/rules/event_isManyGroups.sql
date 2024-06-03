SELECT events.isManyGroups, COUNT(event_group.group_id) as counters FROM events
    INNER JOIN event_group
        ON events.eventId = event_group.event_id AND event_group.event_id = :event_id;