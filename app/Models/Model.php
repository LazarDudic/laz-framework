<?php

namespace App\Models;

use Exception;
use App\Foundation\Database\DatabaseConnection;

abstract class Model
{
    protected $dbc;
    protected $table = null;
    protected $columns = null;

    public function __construct(DatabaseConnection $db)
    {
        $this->dbc = $db->getConnection();
    }

    public function all()
    {
        $stmt = $this->dbc->prepare('SELECT * FROM ' . $this->getTableName());
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS);
    }
    public function findById(int $id)
    {
        $sql = 'SELECT * FROM ' . $this->getTableName() . ' WHERE id = ?';
        $stmt = $this->dbc->prepare($sql);
        $res = $stmt->execute([$id]);

        return $res ? $stmt->fetch() : null;
    }

    public function store(array $data)
    {
        $sql = $this->getStoreQuery($data);
        $stmt = $this->dbc->prepare($sql);

        $res = $stmt->execute(array_values($data));
        if (!$res) {
            throw new Exception($stmt->errorInfo()[2]);
        }
        return $this->findById($this->dbc->lastInsertId());
    }

    public function update(array $column, array $data)
    {
        $sql = $this->getUpdateQuery($column, $data);
        $stmt = $this->dbc->prepare($sql);
        $res = $stmt->execute(array_merge(array_values($data), array_values($column)));
        if (!$res) {
            throw new Exception($stmt->errorInfo()[2]);
        }
        return true;
    }

    public function delete(array $column)
    {
        $sql = $this->getDeleteQuery($column);
        $stmt = $this->dbc->prepare($sql);
        $res = $stmt->execute(array_values($column));
        if (!$res) {
            throw new Exception($stmt->errorInfo()[2]);
        }
        return true;
    }

    protected function getTableName()
    {
        if (is_null($this->table)) {
            throw new \Exception('Table property is required in ' . get_class($this));
        }
        return $this->table;
    }

    private function getStoreQuery(array $data)
    {
        $columns = array_keys($data);
        $query = 'INSERT INTO ' . $this->getTableName() . ' (';
        foreach ($columns as $column) {
            $this->validateColumn($column);
            $query .= '`' . $column . '`, ';
        }

        $query = substr($query, 0, -2) . ') VALUES (' . str_repeat('?,', count($columns));
        $query = substr($query, 0, -1) . ')';
        return $query;
    }

    private function getUpdateQuery(array $where, array $data)
    {
        $whereColumn = array_keys($where)[0];

        $columns = array_keys($data);
        $query = 'UPDATE ' . $this->getTableName() . ' SET ';
        foreach ($columns as $column) {
            $this->validateColumn($column);
            $query .= '`' . $column . '`=?, ';
        }

        $query = substr($query, 0, -2) . ' WHERE `' . $whereColumn . '`=?';
        return $query;
    }

    private function getDeleteQuery(array $column)
    {
        $whereColumn = array_keys($column)[0];
        $query = 'DELETE FROM ' . $this->getTableName() . ' WHERE `' . $whereColumn . '`=?';
        return $query;
    }

    private function validateColumn($column)
    {
        if (is_null($this->columns)) {
            throw new \Exception('Columns property does not exists in ' . get_class($this));
        }

        if (!in_array($column, $this->columns)) {
            throw new \Exception('Column ' . $column . ' does not exists in ' . get_class($this));
        }

        return $column;
    }
}
