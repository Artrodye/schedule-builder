<?php

try {
    $id = getRequestValue("id");
    $name = getRequestValue("name");
    if (!isset($id, $name)) {
        throw new \exception\ApplicationException('Не переданы данные группы', 400);
    }
    if (require_once APP_ROOT . '/model/group/validateGroups.php') {
        return execute(file_get_contents(APP_ROOT . '/query/groups/update_group.sql'), ['name' => $name, 'id' => $id], ['name' => PDO::PARAM_STR, 'id' => PDO::PARAM_INT]);
    }
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    throw new \exception\ApplicationException('Возникла ошибка при добавлении группы');
}
