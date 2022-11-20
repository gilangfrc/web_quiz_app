<?php

Class Quiz extends Controller {
    public function index() {
        if (isset($_SESSION['login'])) {
            $data['home'] = true;
            if ($_SESSION['login']['user_type'] == 2) {
                $data['title'] = 'My Quiz';
                $data['user'] = $this->model('ModelUser')->getUserById($_SESSION['login']['id']);
                $data['data_quiz'] = $this->model('ModelQuiz')->getQuizCountLimitById($_SESSION['login']['id']);
                $this->view('teacher/template/header', $data);
                $this->view('teacher/quiz/index', $data);
                $this->view('teacher/template/footer', $data);
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function create() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_POST['quiz-title'])) {
                    $createQuiz = $this->model('ModelQuiz')->createQuiz($_POST['quiz-title'], $_SESSION['login']['id']);

                    if ($createQuiz == 'success') {
                        Support::setFlash('Quiz created successfully', '', 'success');
                        header('Location: '.BASEURL.'/quiz');
                    }
                    else {
                        Support::setFlash($createQuiz, '', 'danger');
                        header('Location: '.BASEURL);
                    }
                }
                else {
                    Support::setFlash('Please enter a quiz title', '', 'danger');
                    header('Location: '.BASEURL);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function delete() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_POST['quiz-id'])) {
                    $deleteQuiz = $this->model('ModelQuiz')->deleteQuiz($_POST['quiz-id']);
                    if ($deleteQuiz == 'success') {
                        Support::setFlash('Quiz deleted successfully', '', 'success');
                        header('Location: '.BASEURL.'/quiz');
                    }
                    else {
                        Support::setFlash($deleteQuiz, '', 'danger');
                        header('Location: '.BASEURL.'/quiz');
                    }
                }
                else {
                    Support::setFlash('Invalid request', '', 'danger');
                    header('Location: '.BASEURL.'/quiz');
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function edit($id) {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($id)) {
                    $data['quiz'] = $this->model('ModelQuiz')->getQuizById($id);
                    if ($data['quiz']) {
                        $_SESSION['quiz-id'] = $id;
                        $data['home'] = false;
                        $data['user'] = '';
                        $data['title'] = 'Edit Quiz '.$data['quiz']['title'];
                        $data['question'] = $this->model('ModelQuestion')->getQuestionByUserAndIdQuiz($_SESSION['login']['id'], $id);
                        $data['answer'] = $this->model('ModelQuestion')->answer($_SESSION['login']['id'], $id);
                        // var_dump($data['answer']);exit;
                        $data['edit-quiz'] = true;
                        $data['script'] = ['edit-quiz.js'];
                        $this->view('teacher/template/header', $data);
                        $this->view('teacher/quiz/edit', $data);
                        $this->view('teacher/template/footer', $data);
                    }
                    else {
                        Support::setFlash('Quiz not found', '', 'danger');
                        header('Location: '.BASEURL.'/quiz');
                    }
                }
                else {
                    Support::setFlash('Id quiz not found', '', 'danger');
                    header('Location: '.BASEURL.'/quiz');
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }
    
    public function play() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 1) {
                if (isset($_POST['quiz-code'])|| isset($_SESSION['quiz']['code'])) {
                    $code = isset($_POST['quiz-code']) ? $_POST['quiz-code'] : $_SESSION['quiz']['code'];
                    $checkQuiz = $this->model('ModelQuiz')->getQuizAndQuestionByQuizCode($code);
                    
                    if ($checkQuiz) {
                        $this->model('ModelQuiz')->createHistory($_SESSION['login']['id'], $checkQuiz[0]['id_quiz']);
                        $_SESSION['quiz']['questions'] = $this->model('ModelQuestion')->getQuestionAndAnswerByCode($code);
                        $data['quiz'] = $checkQuiz;
                        $this->view('student/quiz/play', $data);
                    }
                    else {
                        Support::setFlash('Quiz not found or quiz not published', '', 'danger');
                        header('Location: '.BASEURL);
                    }
                }
                else {
                    Support::setFlash('Please enter a valid quiz code', '', 'danger');
                    header('Location: '.BASEURL);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function updateTitle() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_POST['title']) && isset($_SESSION['quiz-id'])) {
                    $updateQuiz = $this->model('ModelQuiz')->updateQuizTitle($_SESSION['quiz-id'], $_POST['title'], $_SESSION['login']['id']);
                    
                    if ($updateQuiz == 'success') {
                        Support::setFlash('Quiz title updated successfully', '', 'success');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                    }
                    else {
                        Support::setFlash($updateQuiz, '', 'danger');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                    }
                }
                else {
                    Support::setFlash('Invalid request', '', 'danger');
                    header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function pause() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_SESSION['quiz-id'])) {
                    $pauseQuiz = $this->model('ModelQuiz')->pauseQuiz($_SESSION['quiz-id'], $_SESSION['login']['id']);
                    if ($pauseQuiz == 'success') {
                        Support::setFlash('Quiz paused successfully', '', 'success');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                    }
                    else {
                        Support::setFlash($pauseQuiz, '', 'danger');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                    }
                }
                else {
                    Support::setFlash('Invalid request', '', 'danger');
                    header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function publish() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_SESSION['quiz-id'])) {
                    $publishQuiz = $this->model('ModelQuiz')->publishQuiz($_SESSION['quiz-id'], $_SESSION['login']['id']);
                    if ($publishQuiz == 'success') {
                        Support::setFlash('Quiz published successfully', '', 'success');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                    }
                    else {
                        Support::setFlash($publishQuiz, '', 'danger');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                    }
                }
                else {
                    Support::setFlash('Invalid request', '', 'danger');
                    header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function getResult() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 1) {
                if (isset($_POST['answer']) && isset($_SESSION['quiz']['questions'])) {
                    $result = $this->model('ModelQuiz')->getResult($_POST['answer']);
                    echo $result;
                }
                else {
                    Support::setFlash('Invalid request', '', 'danger');
                    header('Location: '.BASEURL);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }

    public function by($username = '') {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 1) {
                if ($username != '') {
                    $data['username'] = $username;
                    $data['home'] = true;
                    $data['user'] = $this->model('ModelUser')->getUserById($_SESSION['login']['id']);
                    $data['quiz'] = $this->model('ModelQuiz')->getQuizByUsername($username);
                    $data['title'] = 'Quiz by '.$username;
                    $this->view('student/template/header', $data);
                    $this->view('student/by/index', $data);
                    $this->view('student/template/footer', $data);
                }
                else {
                    Support::setFlash('Invalid request', '', 'danger');
                    header('Location: '.BASEURL);
                }
            }
            else {
                Support::setFlash('You are not allowed to access this page', '', 'danger');
                header('Location: '.BASEURL.'/login');
            }
        }
        else {
            Support::setFlash('You are not logged in', '', 'danger');
            header('Location: '.BASEURL.'/login');
        }
    }
}

