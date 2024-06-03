<?php

try {
    $id = getRequestValue('id');
    if (is_null($id)) {
        throw new \exception\ApplicationException('Не передан идентикатор группы', 400);
    }
    beginTransaction();
    execute(file_get_contents(APP_ROOT . '/query/groups/delete_relation_group.sql'), ['id' => $id], ['id' => PDO::PARAM_INT]);
    execute(file_get_contents(APP_ROOT . '/query/groups/delete_group.sql'), ['id' => $id], ['id' => PDO::PARAM_INT]);
    commit();
    return true;
} catch (\exception\ApplicationException $applicationException) {
    throw $applicationException;
} catch (Exception $exception) {
    rollback();
    throw new \exception\ApplicationException('Возникла ошибка при удалении группы');
}