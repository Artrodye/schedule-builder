<?php


try {
    $name = getRequestValue('name');
    if (is_null($name)) {
        throw new \exception\ApplicationException('Не передано имя группы', 400);
    }
    if (require_once APP_ROOT . '/model/group/validateGroups.php') {
        return execute(
            file_get_contents(APP_ROOT . '/query/groups/create_group.sql'),
            ['name' => $name],
            ['name' => PDO::PARAM_STR]
        );
    }
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при добавлении группы тут');
}
