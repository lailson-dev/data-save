<?php

namespace AcarajeTech\DataSave;

trait QueryBuilder
{
    private string $sqlCreate;
    private string $sqlUpdate;

    protected function builderSqlCreate(array $request): void
    {
        $newFields = $this->builderFields($request);
        $newValues = $this->builderKeys($request);
        $this->sqlCreate = "{$newFields} VALUES ($newValues)";
    }

    protected function builderSqlUpdate(array $request): void
    {
        $newValues = $this->builderValues($request);
        $this->sqlUpdate = "{$newValues}";

        $this->sqlUpdate;
    }

    protected function getSqlCreate(): string
    {
        return $this->sqlCreate;
    }

    protected function getSqlUpdate(): string
    {
        return $this->sqlUpdate;
    }

    private function builderFields(array $values): string
    {
        $fields = '';

        foreach ($values as $key => $value) {
            $fields .= "$key, ";
        }

        $newFields = substr_replace(trim($fields), '', -1);
        $newFields = "($newFields)";

        return $newFields;
    }

    private function builderKeys(array $values): string
    {
        $newValues = '';

        foreach ($values as $key => $value) {
            $newValues .= ":$key, ";
        }

        return substr_replace(trim($newValues), '', -1);
    }

    private function builderValues(array $values): string
    {
        $newValues = '';

        foreach ($values as $key => $value) {
            $newValues .= "$key = :$key, ";
        }

        return substr_replace(trim($newValues), '', -1);
    }
}