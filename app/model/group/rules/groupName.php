<?php

/**
 * @return string|bool
 * @throws \exception\ApplicationException
 */
return function (array $context) {
    $name = $context['name'];
    if (!isset($name)) {
        return 'Не передано имя группы';
    }
    if (!(bool)singleQuery(file_get_contents(APP_ROOT . '/query/rules/group_name.sql'),
            ['name' => $name])) {
        return true;
    }
    return 'Имя группы уже существует';
};