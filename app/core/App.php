<?php

Class App {
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseURL();
        $url = str_replace('-', '', $url);

        //controller
        if (isset($url[0])) {
            if ($url[0] == 'logout') {
                unset($_SESSION['login']);
                $this->controller = 'Login';
                Support::setFlash('You have successfully logged out', 'check', 'success');
                header('Location:'.BASEURL.'/login');
            }
            else if ($url[0] == 'register') {
                $url[0] = 'Login';
                $this->method = 'register';
            }
            else if ($url[0] == 'send_link' || $url[0] == 'change_password') {
                $pathName = $url[0];
                $url[0] = 'Login';
                $this->method = $pathName;
            }
            
            if (file_exists($_SERVER['DOCUMENT_ROOT'].'/app/controllers/' . ucfirst($url[0]) . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
            else {
                header('Location:'.BASEURL.'/login');
            }
        }

        require_once $_SERVER['DOCUMENT_ROOT'].'/app/controllers/' . ucfirst($this->controller) . '.php';
        $this->controller = new $this->controller;
        
        //method
        if (isset($url[1])) {
            
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
            // else {
            //     header('Location:'.BASEURL.'/login');
            // }
        }

        //params
        if (!empty($url)) {
            $this->params = array_values($url);
        }
        //jalankan controller dan method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }

}