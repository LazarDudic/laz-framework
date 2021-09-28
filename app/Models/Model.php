<?php
namespace App\Models;

use Exception;

abstract class Model
{
    protected $dbc;
    protected $table = null;
    protected $columns = null;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }

    public function all()
    {
        $stmt = $this->dbc->prepare('SELECT * FROM '.$this->getTableName());
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS);
    }
    public function findById($id)
    {
        $sql = 'SELECT * FROM '.$this->getTableName().' WHERE id = ?';
        $stmt = $this->dbc->prepare($sql);
        $res = $stmt->execute([$id]);

        return $res ? $stmt->fetch() : null;
    }

    public function store($data)
    {
        $sql = 'INSERT INTO '.$this->getTableName().$this->getColumnsAndValuesQuery($data);
        $stmt = $this->dbc->prepare($sql);

        $res = $stmt->execute(array_values($data));
        if(!$res) {
            throw new Exception($stmt->errorInfo()[2]);
        }
        return $this->findById($this->dbc->lastInsertId());
    }

    protected function getTableName()
    {
        if (is_null($this->table)) {
            throw new \Exception('Table property is required in '.get_class($this));
        }
        return $this->table;
    }

    private function getColumnsAndValuesQuery($data)
    {
        if (is_null($this->columns)) {
            throw new \Exception('Columns property in '.get_class($this));
        }
        $columns = array_keys($data);
        $query = ' (';
        foreach ($columns as $column) {
            if (!in_array($column, $this->columns)) {
                throw new \Exception('Column '.$column.' does not exists in '.get_class($this));
            }
            $query .= '`'.$column.'`, ';
        }

        $query = substr($query, 0, -2) . ') VALUES (' . str_repeat('?,', count($columns));
        $query = substr($query, 0, -1) . ')';
        return $query;
    }
}