<?php

Class Home extends Controller {
    public function index() {
        if (isset($_SESSION['login'])) {
            $data['home'] = true;
            if ($_SESSION['login']['user_type'] == 1) {
                $data['title'] = 'Quiz App';
                $data['user'] = $this->model('ModelUser')->getUserById($_SESSION['login']['id']);
                $data['recent_quiz'] = $this->model('ModelQuiz')->getRecentQuizStudent($_SESSION['login']['id']);
                $this->view('student/template/header', $data);
                $this->view('student/home/index', $data);
                $this->view('student/template/footer', $data);
            }
            else if ($_SESSION['login']['user_type'] == 2) {
                $data['title'] = 'Quiz App';
                $data['user'] = $this->model('ModelUser')->getUserById($_SESSION['login']['id']);
                $data['data_quiz'] = $this->model('ModelQuiz')->getQuizCountLimitById($_SESSION['login']['id']);
                $data['total_quiz'] = count($data['data_quiz']);
                $this->view('teacher/template/header', $data);
                $this->view('teacher/home/index', $data);
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
}

