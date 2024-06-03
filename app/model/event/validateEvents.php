<?php

return function (array $context): bool {
    $collection = [];
    foreach (glob(APP_ROOT . '/model/event/rules/*.php') as $rule) {
        $validator = require $rule;
        $result = $validator($context);
        if (is_string($result)) {
            $collection[] = $result;
        }
    }
    if (!empty($collection)) {
        throw new \exception\ApplicationException(implode("\n", $collection), 400);
    }
    return true;
};