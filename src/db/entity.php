<?php

class Entity
{
    public static function all($class)
    {
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "SELECT * FROM $tableName";
        $result = $db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($class, $id)
    {
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
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

    public static function update($class, $id, ...$params)
    {
        $tableName = $class::tableName;

        $set =  join('=?, ', array_keys($class::fields)) . '=? ';
        $bind = join('', array_values($class::fields)) . 'i';
        array_push($params, $id);

        $db = Database::getInstance();
        $query = "UPDATE $tableName SET $set WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$params);
        return $stmt->execute();
    }
}
