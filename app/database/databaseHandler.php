<?php

require_once dirname(APP_ROOT) . '/config/secret.php';
$databaseHandler = null;

function setupConnection(): void
{
    global $databaseHandler;
    $configurations = getConfig();
    $databaseHandler = new PDO("mysql:host=localhost;dbname=" . $configurations["dbname"] . ";", $configurations["userName"], $configurations["password"]);
    $databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $databaseHandler->exec('SET NAMES UTF8');
}

/**
 * @return array|false
 * @throws \exception\ApplicationException
 */
function query(string $query, array $params = [], array $types = [], int $fetchMode = PDO::FETCH_ASSOC): array
{
    /** @var PDO $databaseHandler */
    global $databaseHandler;

    if ($databaseHandler === null) {
        setupConnection();
    }

    $statement = $databaseHandler->prepare($query);
    foreach ($params as $key => $value) {
        $statement->bindValue($key, $value, $types[$key] ?? PDO::PARAM_STR);
    }
    $statement->execute();
    return $statement->fetchAll($fetchMode);
}



function execute(string $query, array $params = [], array $types = []): bool
{
    /** @var PDO $databaseHandler */
    global $databaseHandler;

    if ($databaseHandler === null) {
        setupConnection();
    }

    $statement = $databaseHandler->prepare($query);
    foreach ($params as $key => $value) {
        $statement->bindValue($key, $value, $types[$key] ?? PDO::PARAM_STR);
    }
    try {
        $statement->execute();
    } catch(PDOException $exception) {
        throw new \exception\ApplicationException();
    }

    return true;
}

function beginTransaction(): void
{
    /** @var PDO $databaseHandler */
    global $databaseHandler;

    if ($databaseHandler === null) {
        setupConnection();
    }

    try {
        if (!$databaseHandler->beginTransaction()) {
            throw new \exception\ApplicationException('Возникла ошибка при открытии транзакции');
        }
    } catch(PDOException $exception) {
        throw new \exception\ApplicationException("Transaction failed", 500);
    }
}

function commit(): void
{
    global $databaseHandler;
    if ($databaseHandler === null) {
        throw new LogicException('Dont setup connection with database', 500);
    }
    $databaseHandler->commit();
}

function rollback(): void
{
    global $databaseHandler;
    if ($databaseHandler === null) {
        throw new LogicException('Dont setup connection with database', 500);
    }
    $databaseHandler->rollBack();
}