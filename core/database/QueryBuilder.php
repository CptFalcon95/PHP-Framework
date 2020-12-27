<?php

class QueryBuilder
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function pdo() {
        return $this->pdo;
    }

    public function insert($table, $parameters) 
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(',', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $statement = $this->pdo->prepare($sql);
            if($statement->execute($parameters)) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            // FIXME Do something better
            die($e->getMessage());
        }

    }

    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function selectOne($table, $select = [], $key, $value) {
        $sql = sprintf(
            'select %s from %s where %s = %s',
            implode(',', $select),
            $table,
            $key,
            "'{$value}'"
        );
        try {
            $statement = $this->pdo->prepare($sql);
            if($statement->execute()) {
                return $statement->fetch(PDO::FETCH_OBJ);
            }
            return false;
        } catch (PDOException $e) {
            // FIXME Do something better
            die($e->getMessage());
        }
    }
    
    public function selectOneClass($class, $table, $select = [], $key, $value) {
        $sql = sprintf(
            'select %s from %s where %s = %s',
            implode(',', $select),
            $table,
            $key,
            "'{$value}'"
        );
        try {
            $statement = $this->pdo->prepare($sql);
            if($statement->execute()) {
                $statement->setFetchMode(PDO::FETCH_CLASS, $class);
                return $statement->fetch();
            }
            return false;
        } catch (PDOException $e) {
            // FIXME Do something better
            die($e->getMessage());
        }
    }
}