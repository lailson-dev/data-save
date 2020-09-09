<?php

namespace AcarajeTech\DataSave;

abstract class DataSave
{
    use QueryBuilder;

    protected object $pdo;
    protected object $statement;
    protected \PDOException $error;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function show(?string $fields = '*'): ?\stdClass
    {
        try {
            $sql = "SELECT {$fields} FROM {$this->table}";
            $this->statement = $this->pdo->prepare($sql);
            $this->statement->execute();

            return (object)$this->statement->fetchAll();
        } catch (\PDOException $exception) {
            $this->error = $exception;
            return null;
        }
    }

    public function findById(?string $where = null, $value, ?string $fields = '*'): ?\stdClass
    {
        try {
            $sql = "SELECT {$fields} FROM {$this->table}";

            if (! is_null($where)) {
                $sql .= " WHERE {$where} = :{$where}";
                $this->statement = $this->pdo->prepare($sql);
                $this->statement->bindValue(":{$where}", $value);
                $this->statement->execute();

                return (object)$this->statement->fetch();
            }

            $this->statement = $this->pdo->prepare($sql);
            $this->statement->bindValue(":$where", $value);
            $this->statement->execute();

            return (object)$this->statement->fetch();
        } catch (\PDOException $exception) {
            $this->error = $exception;
            return null;
        }

    }

    public function destroy(string $where, $value): bool
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$where} = :{$where}";
            $this->statement = $this->pdo->prepare($sql);
            $this->statement->bindvalue(":{$where}", $value);

            $this->statement->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->error = $exception;
            return false;
        }
    }

    public function save(array $request, ?string $where = null): bool
    {
        if ($where)
            return $this->update($request, $where) ? true : false;

        return $this->create($request) ? true : false;

    }

    private function create($request): bool
    {
        try {
            $this->builderSqlCreate($request);
            $sql = "INSERT INTO {$this->table} {$this->getSqlCreate()}";
            $this->statement = $this->pdo->prepare($sql);

            foreach ($request as $key => $value) {
                $this->statement->bindValue(":$key", $value);
            }

            $this->statement->execute();
            return true;
        } catch (\PDOException $exception) {
            $this->error = $exception;
            return false;
        }
    }

    private function update(array $request, string $where): bool
    {
        try {
            $this->builderSqlUpdate($request);
            $sql = "UPDATE {$this->table} SET {$this->getSqlUpdate()} WHERE {$where} = :{$where}";
            $this->statement = $this->pdo->prepare($sql);

            foreach ($request as $key => $value) {
                $this->statement->bindValue(":$key", $value);
            }

            $this->statement->execute();
            return true;

        } catch (\PDOException $exception) {
            $this->error = $exception;
            return false;
        }
    }
}