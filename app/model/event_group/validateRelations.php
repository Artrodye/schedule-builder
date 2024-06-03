<?php

$collection = [];
foreach (glob(APP_ROOT . '/model/event_group/rules/*.php') as $rule) {
    $validator = require_once $rule;
    $result = $validator(requestToArray());
    if (is_string($result)) {
        $collection[] = $result;
    }
}
if (!empty($collection)) {
    throw new \exception\ApplicationException(implode('\n', $collection), 400);
}
return true;