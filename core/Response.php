<?php
namespace Teflo\Core;

class Response {
    public static function json(array $data, int $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public static function redirect(string $url) {
        header("Location: $url");
        exit;
    }
}

?>