<?php
namespace App\Controllers;

use Teflo\Core\Controller;

class HomeController extends Controller {
    public function index() {
        return $this->view('home', ['title' => 'Welcome to Teflo']);
    }
}

?>