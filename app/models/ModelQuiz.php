<?php

Class ModelQuiz {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getQuizById($id) {
        $this->db->query('SELECT * FROM '.QUIZ.' WHERE id=:id');
        $this->db->bind('id', $id);
        $result =  $this->db->single();
        
        return $result;
    }

    public function getQuizByUsername($username) {
        $this->db->query('SELECT '.QUIZ.'.* FROM '.USERS.' INNER JOIN '.QUIZ.' ON '.USERS.'.id = '.QUIZ.'.id_user WHERE '.USERS.'.username = :username AND '.USERS.'.user_type = 2');
        $this->db->bind('username', $username);
        $result =  $this->db->resultSet();

        return $result;
    }

    public function getQuizCountLimitById($id) {
        $this->db->query('SELECT '.QUIZ.'.*, COUNT('.QUESTIONS.'.id_quiz) as "total_question" FROM '.QUIZ.' LEFT JOIN '.QUESTIONS.' ON '.QUIZ.'.id = '.QUESTIONS.'.id_quiz WHERE '.QUIZ.'.id_user = :id GROUP BY '.QUIZ.'.id ORDER BY '.QUIZ.'.id DESC');
        $this->db->bind('id', $id);
        $result =  $this->db->resultSet();

        return $result;
    }

    public function getQuizAndQuestionByQuizCode($quiz_code) {
        $this->db->query('SELECT '.QUIZ.'.*, '.QUESTIONS.'.* FROM '.QUIZ.' INNER JOIN '.QUESTIONS.' ON '.QUIZ.'.id = '.QUESTIONS.'.id_quiz WHERE '.QUIZ.'.quiz_code = :quiz_code AND '.QUIZ.'.is_published = 1');
        $this->db->bind('quiz_code', $quiz_code);
        $result =  $this->db->resultSet();
        
        return $result;
    }

    public function getRecentQuizStudent($id_user) {
        $this->db->query('SELECT '.QUIZ.'.*, '.USERS.'.name, '.USERS.'.username FROM '.QUIZ.' INNER JOIN '.HISTORY.' ON '.QUIZ.'.id = '.HISTORY.'.id_quiz INNER JOIN '.USERS.' ON '.QUIZ.'.id_user = '.USERS.'.id WHERE '.HISTORY.'.id_user = :id ORDER BY '.HISTORY.'.played_at DESC LIMIT 4');
        $this->db->bind('id', $id_user);
        $result =  $this->db->resultSet();
        
        return $result;
    }

    public function updateQuizTitle($id, $title, $id_user) {
        $this->db->query('UPDATE '.QUIZ.' SET title = :title WHERE id = :id AND id_user = :id_user');
        $this->db->bind('id', $id);
        $this->db->bind('id_user', $id_user);
        $this->db->bind('title', $title);
        $result =  $this->db->execute();

        if (is_null($result)) {
            return 'success';
        } else {
            return 'Quiz title failed to update';
        }
    }

    public function pauseQuiz($id, $id_user) {
        $this->db->query('UPDATE '.QUIZ.' SET is_published = 0, quiz_code = "" WHERE id = :id AND id_user = :id_user');
        $this->db->bind('id', $id);
        $this->db->bind('id_user', $id_user);
        $result =  $this->db->execute();

        if (is_null($result)) {
            return 'success';
        } else {
            return 'Quiz failed to pause';
        }
    }

    public function publishQuiz($id, $id_user) {
        $code = Support::generateRandomString();
        //check if quiz code is already used
        $this->db->query('SELECT * FROM '.QUIZ.' WHERE quiz_code = :quiz_code');
        $this->db->bind('quiz_code', $code);
        $result =  $this->db->single();
        if (!is_null($result)) {
            while (is_null($result)) {
                $code = Support::generateRandomString();
                $this->db->query('SELECT * FROM '.QUIZ.' WHERE quiz_code = :quiz_code');
                $this->db->bind('quiz_code', $code);
                $result =  $this->db->single();
            }
        } 

        $this->db->query('UPDATE '.QUIZ.' SET is_published = 1, quiz_code = :quiz_code WHERE id = :id AND id_user = :id_user');
        $this->db->bind('id', $id);
        $this->db->bind('id_user', $id_user);
        $this->db->bind('quiz_code', $code);
        $result =  $this->db->execute();
        if (is_null($result)) {
            return 'success';
        } else {
            return 'Quiz failed to publish';
        }

    }

    public function createQuiz($title, $id) {
        $this->db->query('INSERT INTO '.QUIZ.' VALUES(NULL, :title, 0, "", :id_user)');
        $this->db->bind('title', $title);
        $this->db->bind('id_user', $id);
        $result = $this->db->execute();

        if (is_null($result)) {
            return 'success';
        }
        else {
            return 'Failed to create quiz';
        }
    }

    public function deleteQuiz($id) {
        $this->db->query('DELETE FROM '.QUIZ.' WHERE id=:id');
        $this->db->bind('id', $id);
        $result = $this->db->execute();
        
        if (is_null($result)) {
            return 'success';
        }
        else {
            return 'Failed to delete quiz';
        }
    }

    public function createHistory($id_user, $id_quiz) {
        //check if history already exists
        $this->db->query('SELECT * FROM '.HISTORY.' WHERE id_user = :id_user AND id_quiz = :id_quiz');
        $this->db->bind('id_user', $id_user);
        $this->db->bind('id_quiz', $id_quiz);
        $result =  $this->db->single();

        //if history exists, update it
        if (!$result) {
            $this->db->query('INSERT INTO '.HISTORY.' VALUES(NULL, :id_quiz, :id_user, :played_at)');
            $this->db->bind('id_user', $id_user);
            $this->db->bind('id_quiz', $id_quiz);
            $this->db->bind('played_at', date('Y-m-d H:i:s'));
            $result = $this->db->execute();
        } 
        else {
            $this->db->query('UPDATE '.HISTORY.' SET played_at = :played_at WHERE id_user = :id_user AND id_quiz = :id_quiz');
            $this->db->bind('id_user', $id_user);
            $this->db->bind('id_quiz', $id_quiz);
            $this->db->bind('played_at', date('Y-m-d H:i:s'));
            $result = $this->db->execute();
        }
    }

    public function getResult($answer) {
        $question = $_SESSION['quiz']['questions'];

        $right = 0;
        $wrong = 0;

        foreach ($question as $key => $value) {
            if ($answer[$key] == '') {
                $wrong++;
            }

            foreach ($value['answer'] as $k => $v) {
                if ($answer[$key] == $v['choice'] && $v['is_answer'] == 1) {
                    $right++;
                }
                else if ($answer[$key] == $v['choice'] && $v['is_answer'] == 0) {
                    $wrong++;
                }
            }
        }

        return json_encode([
            'right' => $right,
            'wrong' => $wrong
        ]);
    }

}