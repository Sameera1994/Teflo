<?php
namespace Teflo\Core\Database;

use PDO;

abstract class Model {
    protected static string $table = '';
    protected array $attributes = [];

    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
    }

    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    public static function find($id) {
        $db = Connection::getInstance();
        $table = static::$table;
        $stmt = $db->prepare("SELECT * FROM $table WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new static($data) : null;
    }
    public function save() {
        $db = Connection::getInstance();
        $table = static::$table;
        $keys = array_keys($this->attributes);
        $columns = implode(", ", $keys);
        $placeholders = implode(", ", array_fill(0, count($keys), "?"));

        if (isset($this->attributes['id'])) {
            // Update
            $updates = implode(", ", array_map(fn($k) => "$k = ?", $keys));
            $stmt = $db->prepare("UPDATE $table SET $updates WHERE id = ?");
            $stmt->execute([...array_values($this->attributes), $this->attributes['id']]);
        } else {
            // Insert
            $stmt = $db->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
            $stmt->execute(array_values($this->attributes));
            $this->attributes['id'] = $db->lastInsertId();
        }
    }
}

?>