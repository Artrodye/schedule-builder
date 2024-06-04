<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function (array $context) {
    $beginTime = $context['beginTime'];
    if (!isset($beginTime)) {
        return 'Не передано время начала пары';
    }
    if ((bool)date('w', strtotime($beginTime))) {
        return true;
    }
    return 'Попытка назначить пару в воскресенье';
};