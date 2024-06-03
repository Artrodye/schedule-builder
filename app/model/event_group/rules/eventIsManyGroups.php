<?php

return function (array $context) {
    $event_id = $context['event_id'];
    if (is_null($event_id)) {
        throw new \exception\ApplicationException('Не передан идентификатор события', 400);
    }
    $params = query('rules' . DIRECTORY_SEPARATOR . 'event_isManyGroups.sql', ['event_id' => $event_id], ['event_id' => PDO::PARAM_INT])[0];
    if (!($params['isManyGroups'] === "0" && $params["counters"] == "1")) {
        return true;
    }
    throw new \exception\ApplicationException('Превышено допустимое количество групп');
};