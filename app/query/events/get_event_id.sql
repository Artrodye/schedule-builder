SELECT eventId FROM events
WHERE name = :name AND
      begin_time = :beginTime AND
      teacher = :teacher AND
      room = :room AND
      isManyGroups = :isManyGroups AND
      comment = :comment