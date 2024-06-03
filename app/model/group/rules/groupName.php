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
    if (query(file_get_contents(APP_ROOT . '/query/rules/group_name.sql'),
            ['name' => $name],
            ['name' => PDO::PARAM_STR])[0]["counters"] === "0") {
        return true;
    }
    return 'Имя группы уже существует';
};