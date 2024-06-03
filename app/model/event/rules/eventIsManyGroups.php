<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function ($context) {
    if (!$context['isManyGroups'] && count($context['groupsIds']) > 1) {
        return 'Превышено допустимое количество групп';
    }
    return true;
};