<?php

namespace Teflo\Core;

class View {
    public static function render(string $view, array $data = []) {
        $viewPath = __DIR__ . "/../app/Views/$view.php";

        if (!file_exists($viewPath)) {
            throw new \Exception("View $view not found");
        }

        extract($data);
        ob_start();
        include $viewPath;
        return ob_get_clean();
    }
}

?>