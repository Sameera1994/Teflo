<?php

namespace Teflo\Core;

class App {
    protected Router $router;

    public function __construct() {
        $this->router = new Router();
        $this->registerRoutes();
    }

    protected function registerRoutes() {
    $router = $this->router;
    require __DIR__ . '/../routes/web.php';
}

    public function run() {
        $this->router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
    }
}

?>