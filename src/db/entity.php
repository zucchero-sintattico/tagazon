<?php

require_once(__DIR__ . '/database.php');

class Entity
{
    private static function all($class)
    {
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "SELECT * FROM $tableName";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($class, $params)
    {
        $tableName = $class::tableName;
        $db = Database::getInstance();
        
        $keys = [];
        $bind = [];
        if (isset($params['id'])){
            array_push($keys, 'id');
            array_push($bind, 'i');
        }

        foreach($class::fields as $field => $type) {
            if (isset($params[$field])) {
                array_push($keys, $field);
                array_push($bind, $type);
            }
        }

        if (count($keys) == 0) {
            return Entity::all($class);
        }
        
        $where = join(' = ? AND ', $keys) . ' = ?';
        $bind = join('', $bind);
        
        $query = "SELECT * FROM $tableName WHERE $where";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...array_values($params));
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($class, ...$params)
    {
        $tableName = $class::tableName;
        $columns = join(', ', array_keys($class::fields));
        $bind = join('', array_values($class::fields));

        // Create an array of ? to bind to the query
        $values = str_split($bind);
        $values = array_map(function ($item) {
            return '?';
        }, $values);
        $values = join(', ', $values);

        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$params);
        $stmt->execute();
        return $db->insert_id;
    }

    public static function delete($class, $id)
    {
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "DELETE FROM $tableName WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function update($class, $id, $params)
    {
        $tableName = $class::tableName;
        $filteredParams = [];
        foreach($params as $key => $value) {
            if (isset($class::fields[$key])) {
                $filteredParams[$key] = $value;
            }
        }
        $set =  join('=?, ', array_keys($filteredParams)) . '=? ';
        $bind = [];
        $bind_param = [];
        foreach($filteredParams as $paramkey => $paramvalue) {
            if (isset($class::fields[$paramkey])) {
                array_push($bind, $class::fields[$paramkey]);
                array_push($bind_param, $paramvalue);
            }
        }
        $bind = join('', $bind) . 'i';
        array_push($bind_param, $id);

        $db = Database::getInstance();
        $query = "UPDATE $tableName SET $set WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$bind_param);
        return $stmt->execute();
    }
}
