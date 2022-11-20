<?php

Class Login extends Controller {
    public function index() {
        if (isset($_SESSION['login'])) {
            Support::setFlash('You are already logged in', '', 'success');
            header('Location:'.BASEURL.'/home');
        }
        else if (isset($_POST['username']) && isset($_POST['password'])) {
            $verifyLogin = $this->model('ModelUser')->verifyLogin($_POST['username'], $_POST['password']);
            
            if ($verifyLogin) {
                $name = isset($_SESSION['login']['name']) ? $_SESSION['login']['name'] : '';
                Support::setFlash('Welcome '.$name, 'check', 'success');
                header('Location:'.BASEURL.'/home');
            }
            else {
                Support::setFlash('Username or password is incorrect', '', 'danger');
                $this->view('login/index');
            }
        }
        else {
            $this->view('login/index');
        }        
    }

    public function register() {
        if (isset($_SESSION['login'])) {
            Support::setFlash('You are already logged in', '', 'success');
            header('Location:'.BASEURL.'/home');
        }
        else if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && $_POST['name'] && isset($_POST['user-type'])) {
            $register = $this->model('ModelUser')->register($_POST['username'], $_POST['password'], $_POST['email'], $_POST['name'], $_POST['user-type']);

            if ($register == 'success') {
                Support::setFlash('You have successfully registered', 'check', 'success');
                header('Location:'.BASEURL.'/login');
            }
            else {
                $_SESSION['failed'] = true;
                Support::setFlash($register, '', 'danger');
                header('Location:'.BASEURL.'/login');
                // $this->view('login/index');
            }
        }
        else {
            $this->view('login/index');
        }
    }

}