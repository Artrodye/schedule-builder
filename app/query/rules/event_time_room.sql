SELECT COUNT(eventId) as counters FROM events
WHERE begin_time = :beginTime AND
    room = :room