<?php

Class Question extends Controller {
    public function create() {
        // var_dump($_POST);exit;
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_SESSION['quiz-id'])) {
                    $createQuestion = $this->model('ModelQuestion')->createQuestion($_SESSION['quiz-id'], $_POST);
                    if ($createQuestion == 'success') {
                        Support::setFlash('Quiz created', '', 'success');
                        echo json_encode(['url'=> BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']]);
                        exit;
                    }
                    else {
                        Support::setFlash($createQuestion, '', 'danger');
                        echo json_encode(['url'=> BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']]);
                        exit;
                    }
                }
                else {
                    Support::setFlash('Invalid data', '', 'danger');
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

    public function update() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_SESSION['quiz-id'])) {
                    $updateQuestion = $this->model('ModelQuestion')->updateQuestion($_SESSION['quiz-id'], $_POST);
                    if ($updateQuestion == 'success') {
                        Support::setFlash('Quiz updated', '', 'success');
                        echo json_encode(['url'=> BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']]);
                        exit;
                    }
                    else {
                        Support::setFlash($updateQuestion, '', 'danger');
                        echo json_encode(['url'=> BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']]);
                        exit;
                    }
                }
                else {
                    Support::setFlash('Invalid data', '', 'danger');
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

    public function delete() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_POST['id']) && isset($_SESSION['quiz-id'])) {
                    $deleteQuestion = $this->model('ModelQuestion')->deleteQuestion($_POST['id'], $_SESSION['quiz-id']);
                    if ($deleteQuestion == 'success') {
                        Support::setFlash('Question deleted', '', 'success');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                        exit;
                    }
                    else {
                        Support::setFlash($deleteQuestion, '', 'danger');
                        header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                        exit;
                    }
                }
                else {
                    Support::setFlash('Invalid data', '', 'danger');
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

    public function get() {
        if (isset($_SESSION['login'])) {
            if ($_SESSION['login']['user_type'] == 2) {
                if (isset($_POST['id']) && isset($_SESSION['quiz-id'])) {
                    $getQuestionAndAnswer = $this->model('ModelQuestion')->getQuestionAndAnswer($_POST['id'], $_SESSION['quiz-id'], $_SESSION['login']['id']);
                    echo $getQuestionAndAnswer;
                }
                else {
                    Support::setFlash('Invalid data', '', 'danger');
                    header('Location: '.BASEURL.'/quiz/edit/'.$_SESSION['quiz-id']);
                }
            }
            else if ($_SESSION['login']['user_type'] == 1) {
                if (isset($_POST['no'])) {
                    $no = $_POST['no'];
                    $question = $_SESSION['quiz']['questions'][$no-1];
                    foreach($question['answer'] as $ket => $value) {
                        unset($question['answer'][$ket]['is_answer']);
                    }
                    echo json_encode($question);
                }
                else {
                    Support::setFlash('Invalid data', '', 'danger');
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