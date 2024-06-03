UPDATE events
SET name = :name,
    begin_time = :beginTime,
    room = :room,
    teacher = :teacher,
    isManyGroups = :isManyGroups,
    comment = :comment
WHERE eventId = :eventId