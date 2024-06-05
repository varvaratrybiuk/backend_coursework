<?php

namespace core;

use controllers\ErrorController;
use PDO;
use PDOException;
use PDOStatement;

class DataBase
{
    private PDO $pdo;
    private array $result = [];
    private string $sql = "";
    private string $where = "";
    private array $queryParts = [
        'parameters' => [],
        'sqlQuery' => ""
    ];
    private string $join = "";
    private string $orderBy = "";
    private string $groupBy = "";
    public function __construct($host, $dbname, $username, $password)
    {
        $dsn = "mysql:host=" . $host . ";dbname=" . $dbname;
        try {
            $this->pdo = new PDO($dsn, $username, $password);

        } catch (\Throwable) {
            $error = new ErrorController();
            $error->errorPage(500);

        }
    }

    private function prepareQuery(array $data): PDOStatement|false
    {
        $this->sql .= $this->queryParts['sqlQuery'] . $this->join . $this->where . $this->orderBy . $this->groupBy;
        $preparedQuery = $this->pdo->prepare($this->sql);
        foreach ($data as $key => $value) {
            $preparedQuery->bindValue("$key", $value);
        }
        return  $preparedQuery;
    }

    public function select(string $table, string $fields = "*"): self
    {
        $this->sql .= "SELECT $fields FROM $table";
        return $this;
    }
    public function insert(string $tableName, array $columnsAndValues):self
    {
        $columnNames = array_keys($columnsAndValues);
        $placeholders = array_map(function($columnName) { return ":$columnName"; }, $columnNames);
        $this->queryParts['parameters'] = array_combine($placeholders, array_values($columnsAndValues));
        $this->queryParts['sqlQuery'] = "INSERT INTO $tableName (" . implode(', ', $columnNames) . ") 
        VALUES (" . implode(', ', $placeholders) . ")";

        return $this;
    }
    public function delete(string $tableName): self
    {
        $this->sql .= "DELETE FROM $tableName";

        return $this;
    }

    public function update(string $tableName, array $columnsAndValues): self
    {
        foreach ($columnsAndValues as $fieldName => $fieldValue) {
            $this->queryParts['parameters'][":$fieldName"] = $fieldValue;
            $conditions[] = "$fieldName = :$fieldName";
        }
        $this->queryParts['sqlQuery'] .= " UPDATE $tableName SET " . implode(", ", $conditions);
        return $this;
    }
    public function where(array $fieldsWithValues, array $marks = [], string $operator = "AND"): self
    {
        $conditions = [];
        $markIndex = 0;
        foreach ($fieldsWithValues as $fieldName => $fieldValue) {
            $mark = $marks[$markIndex] ?? '=';
            if ($fieldValue == null) {
                break;
            }
            $value = str_replace('.', '', $fieldName);
            $this->queryParts['parameters'][":$value"] = $fieldValue;
            $conditions[] = "$fieldName $mark :$value";
            $markIndex++;
        }
        $this->where .= ' WHERE ' . implode(" $operator ", $conditions);
        return $this;
    }

    public function join(array $tableAndField, array $tableAndFieldOn, string $joinType = 'INNER'): self
    {
        $joinStatements = [];
        foreach ($tableAndField as $table => $field) {
            $onKey = key($tableAndFieldOn);
            $joinStatements[] = "$joinType JOIN $table ON $table.$field = $onKey.$tableAndFieldOn[$onKey]";
            next($tableAndFieldOn);
        }
        $this->join .= " " . implode(" ", $joinStatements);
        return $this;
    }

    public function orderBy(string $table, string $field, string $direction = "ASC"): self
    {
        $this->orderBy .= " ORDER BY $table.$field $direction";
        return $this;
    }

    public function groupBy(string $table, string $field): self
    {
        $this->groupBy .= " GROUP BY $table.$field";
        return $this;
    }

    public function execute(): self
    {
        $stmt = $this->prepareQuery($this->queryParts['parameters']);
        $stmt->execute();
        $this->result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->reset();
        return $this;
    }
    private function reset(): void
    {
        $this->sql = "";
        $this->queryParts = [
            'parameters' => [],
            'sqlQuery' => ""
        ];
        $this->join = "";
        $this->where = "";
        $this->orderBy = "";
        $this->groupBy = "";
    }
    public function returnJson(): false|string
    {
        return json_encode($this->result);
    }
    public function returnAssocArray(): array
    {
        return $this->result;
    }
}