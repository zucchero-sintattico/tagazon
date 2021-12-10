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

    public static function find($class, ...$ids)
    {
        $tableName = $class::tableName;
        $where = join("=? AND", array_keys($class::primary_keys)) . "=?;";
        $bind = join('', array_values($class::primary_keys));
        
        $db = Database::getInstance();
        $query = "SELECT * FROM $tableName WHERE $where";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }

    public static function delete($class, ...$ids)
    {
        $tableName = $class::tableName;
        $where = join("=? AND", array_keys($class::primary_keys)) . "=?;";
        $bind = join('', array_values($class::primary_keys));

        $db = Database::getInstance();
        $query = "DELETE FROM $tableName WHERE $where";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row;
    }

    public static function create($class, $ids, ...$params)
    {
        $tableName = $class::tableName;
        $columns = join(', ', array_keys($class::fields));
        $bind = join('', array_values($class::fields));
        if (!is_null($ids)) {
            $columns = join(', ', array_keys($class::primary_keys)) . ', ' . $columns;
            $bind = join('', array_values($class::primary_keys)) . ', ' . $bind;
            $params = $ids + $params;
        }
        // Create an array of symbols to bind to the query
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

    public static function update($class, $ids, ...$params)
    {
        $tableName = $class::tableName;

        $set =  join('=?, ', array_keys($class::fields)) . '=? ';
        $where = join("=? AND", array_keys($class::primary_keys)) . "=?;";

        $bind = join('', array_values($class::fields))
                . ', ' .
                join('', array_values($class::primary_keys));

        $params = $params + $ids;

        $db = Database::getInstance();
        $query = "UPDATE tags SET $set WHERE $where";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$params);
        $stmt->execute();
        return $db->query($query);
    }
}
