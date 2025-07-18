<?php

namespace Teflo\Core;

class Request {
    public function get(string $key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, $default = null) {
        return $_POST[$key] ?? $default;
    }

    public function method(): string {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function uri(): string {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}

?>