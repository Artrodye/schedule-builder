<?php

return function (array $context) {
    $event_id = $context['event_id'];
    $group_id = $context['group_id'];
    if (!isset($group_id, $event_id)) {
        throw new \exception\ApplicationException('Не переданы идентификаторы группы и события', 400);
    }
    if (!in_array(query('rules' . DIRECTORY_SEPARATOR . 'get_event_time.sql', ['event_id' => $event_id], ['event_id' => PDO::PARAM_INT]),
            query('rules' . DIRECTORY_SEPARATOR . 'group_free_time_for_update.sql', ['group_id' => $group_id], ['group_id' => PDO::PARAM_INT]))) {
        return true;
    }
    throw new \exception\ApplicationException('У этой группы пары в это время', 400);
};