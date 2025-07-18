<?php
namespace Teflo\Core;

class Controller {
    public function view(string $view, array $data = []) {
        return View::render($view, $data);
    }

    public function redirect(string $url) {
        Response::redirect($url);
    }
}

?>