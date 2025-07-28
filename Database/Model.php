<?php

namespace Teflo\Core;

use PDO;
use Teflo\Core\Database\Connection;

class Model {
    protected static string $table = '';
    protected array $attributes = [];
    protected static array $rules = [];

    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
    }

    public function __get($key) {
        return $this->attributes[$key] ?? null;
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    public static function all(): array {
        $db = Connection::getInstance();
        $stmt = $db->query("SELECT * FROM " . static::$table . " WHERE deleted_at IS NULL");
        return array_map(fn($row) => new static($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public static function find($id): ?self {
        $db = Connection::getInstance();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new static($data) : null;
    }

    public static function where($column, $operator, $value): array {
        $db = Connection::getInstance();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $column $operator ? AND deleted_at IS NULL");
        $stmt->execute([$value]);
        return array_map(fn($row) => new static($row), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function hasOne($related, $foreignKey, $localKey = 'id') {
        $relatedTable = $related::$table;
        $db = Connection::getInstance();
        $stmt = $db->prepare("SELECT * FROM $relatedTable WHERE $foreignKey = ?");
        $stmt->execute([$this->$localKey]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new $related($data) : null;
    }

    public function belongsTo($related, $foreignKey, $ownerKey = 'id') {
        $relatedTable = $related::$table;
        $db = Connection::getInstance();
        $stmt = $db->prepare("SELECT * FROM $relatedTable WHERE $ownerKey = ?");
        $stmt->execute([$this->$foreignKey]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new $related($data) : null;
    }

    public function save(): bool {
        $db = Connection::getInstance();
        $now = date('Y-m-d H:i:s');
        $this->attributes['updated_at'] = $now;

        if (!isset($this->attributes['id'])) {
            $this->attributes['created_at'] = $now;
            $columns = implode(', ', array_keys($this->attributes));
            $placeholders = implode(', ', array_fill(0, count($this->attributes), '?'));
            $values = array_values($this->attributes);

            $stmt = $db->prepare("INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)");
            return $stmt->execute($values);
        } else {
            $updates = [];
            foreach ($this->attributes as $key => $value) {
                if ($key !== 'id') {
                    $updates[] = "$key = ?";
                }
            }
            $values = array_values(array_filter($this->attributes, fn($k) => $k !== 'id', ARRAY_FILTER_USE_KEY));
            $values[] = $this->attributes['id'];

            $stmt = $db->prepare("UPDATE " . static::$table . " SET " . implode(', ', $updates) . " WHERE id = ?");
            return $stmt->execute($values);
        }
    }

    public function delete(): bool {
        $this->attributes['deleted_at'] = date('Y-m-d H:i:s');
        return $this->save();
    }

    public function isValid(): bool {
        $rules = static::$rules;
        foreach ($rules as $field => $rule) {
            $value = $this->$field;
            $rulesArr = explode('|', $rule);
            foreach ($rulesArr as $r) {
                if ($r === 'required' && empty($value)) return false;
                if ($r === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) return false;
            }
        }
        return true;
    }
}

?>