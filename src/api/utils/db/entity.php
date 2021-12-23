<?php

require_once __DIR__ . "/../../require.php";

abstract class Entity
{
    const tableName = "";
    const fields = [];
    const orderBy = null;

	private static function filterParams($params)
	{
		$filtered = [];
		foreach ($params as $key => $value) {
			if (isset(static::fields[$key]) || $key == 'id') {
				$filtered[$key] = $value;
			}
		}
		return $filtered;
	}
    public static function all($orderBy)
    {
        $class = static::class;
        $tableName = $class::tableName;
        $db = Database::getInstance();
        $query = "SELECT * FROM $tableName ORDER BY $orderBy";
        $result = $db->query($query);
        if (!$result) {
            echo "errore = " .  htmlspecialchars($db->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function find($params)
    {
        $class = static::class;
        $orderBy = static::orderBy;
        if (isset($params['orderBy'])){
            $orderBy = $params['orderBy'];
        }
        $params = static::filterParams($params);
        if (count(array_keys($params)) == 0) {
            return $class::all($orderBy);
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

        $where = join(' = ? AND ', $keys) . (count($keys) > 0 ? ' = ? ' : '');
        $bind = join('', $bind);

        $query = "SELECT * FROM $tableName WHERE $where ORDER BY $orderBy";
        $stmt = $db->prepare($query);
        $stmt->bind_param($bind, ...$bind_params);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function create($params)
    {
        $params = static::filterParams($params);
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
        if (!$db->insert_id){
            echo "errore = " .  htmlspecialchars($db->error);
            return null;
        }
        return $class::find(["id" => $db->insert_id]);
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
        $params = static::filterParams($params);
        $class = static::class;
        if (!isset($params['id'])) {
            return false;
        }

        $tableName = $class::tableName;
        $columns = [];
        foreach(array_keys($params) as $key) {
            if ($key != 'id') {
                array_push($columns, $key);
            }
        }

        
        $set = join(' = ?, ', $columns) . (count($columns) > 0 ? ' = ? ' : '');

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
        $res = $stmt->execute();
        if (!$res) {
            echo "errore = " .  htmlspecialchars($stmt->error);
        }
        return $res;
    }
}
