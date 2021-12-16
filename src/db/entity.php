<?php

require_once(__DIR__ . '/database.php');

abstract class Entity
{
    private static function all()
    {
        $class = static::class;
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "SELECT * FROM $tableName";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($params)
    {
        $class = get_called_class();
        if (count(array_keys($params)) == 0) {
            return $class::all($class);
        }

        $tableName = $class::tableName;
        $db = Database::getInstance();
        
        $keys = [];
        $bind = [];
        $bind_params = [];
        foreach ($params as $key => $value) {
            array_push($keys, $key);
            array_push($bind, $key != 'id' ? $class::fields[$key] : 'i');
            array_push($bind_params, $value);
        }

        $where = join(' = ? AND ', $keys) . (count($keys) > 0 ? ' = ?' : '');
        $bind = join('', $bind);

        $query = "SELECT * FROM $tableName WHERE $where";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$bind_params);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($params)
    {
        $class = static::class;
        $tableName = $class::tableName;
        $columns = join(', ', array_keys($params));
        $bind = '';
        $bind_param = [];
        $values = [];
        foreach(array_keys($params) as $column) {
            $bind .= $class::fields[$column];
            array_push($bind_param, $params[$column]);
            array_push($values, '?');
        }
        $values = join(', ', $values);

        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$bind_param);
        $stmt->execute();
        return $db->insert_id;
    }

    public static function delete($id)
    {
        $class = static::class;
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function update($params)
    {
        $class = static::class;
        if (!isset($params['id'])) {
            return false;
        }

        $tableName = $class::tableName;
        $columns = array_filter(array_keys($params), function($key) {
            return $key != 'id';
        });
        $set = join('=?, ', $columns) . (count($columns) > 0 ? '=? ' : '');

        $bind = '';
        $bind_param = [];
        foreach($columns as $column) {
            $bind .= $class::fields[$column];
            array_push($bind_param, $params[$column]);
        }

        $bind = $bind . 'i';
        array_push($bind_param, $params['id']);

        $db = Database::getInstance();
        $query = "UPDATE $tableName SET $set WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$bind_param);
        return $stmt->execute();
    }
}
