<?php

Class Settings extends Controller {
    public function index() {
        if (isset($_SESSION['login'])) {
            $data['home'] = false;
            $data['title'] = 'Settings';
            if ($_SESSION['login']['user_type'] == 1) {
                $data['user'] = $this->model('ModelUser')->getUserById($_SESSION['login']['id']);
                $this->view('student/template/header', $data);
                $this->view('settings/index', $data);
                $this->view('student/template/footer', $data);
            }
            else if ($_SESSION['login']['user_type'] == 2) {
                $data['user'] = $this->model('ModelUser')->getUserById($_SESSION['login']['id']);
                $this->view('teacher/template/header', $data);
                $this->view('settings/index', $data);
                $this->view('teacher/template/footer', $data);
            }
            else {
                header('Location:'.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location:'.BASEURL.'/login');
        }
    }

    public function update() {
        if (isset($_SESSION['login'])) {
            if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['name'])) {
                $update = $this->model('ModelUser')->updateUser($_SESSION['login']['id'], $_POST['username'], $_POST['email'], $_POST['name']);

                if ($update == 'success') {
                    $_SESSION['login']['username'] = $_POST['username'];
                    $_SESSION['login']['name'] = $_POST['name'];
                    Support::setFlash('Your profile has been updated', '', 'success');
                    header('Location:'.BASEURL.'/settings');
                }
                else {
                    Support::setFlash($update, '', 'danger');
                    header('Location:'.BASEURL.'/settings');
                }
            }
            else if (isset($_POST['password']) && isset($_POST['confirm-password'])) {
                $update = $this->model('ModelUser')->updatePassword($_SESSION['login']['id'], $_POST['password'], $_POST['confirm-password']);

                if ($update == 'success') {
                    Support::setFlash('Your password has been updated', '', 'success');
                    header('Location:'.BASEURL.'/settings');
                }
                else {
                    Support::setFlash($update, '', 'danger');
                    header('Location:'.BASEURL.'/settings');
                }
            }
            else {
                Support::setFlash('Please fill in all the fields', '', 'danger');
                header('Location:'.BASEURL.'/settings');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location:'.BASEURL.'/login');
        }
    }
}