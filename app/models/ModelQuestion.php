<?php

Class ModelQuestion {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getQuestionByUserAndIdQuiz($id_user, $id_quiz) {
        $this->db->query('SELECT '.QUESTIONS.'.* FROM '.QUIZ.' INNER JOIN '.QUESTIONS.' ON '.QUIZ.'.id = '.QUESTIONS.'.id_quiz WHERE '.QUIZ.'.id = :id_quiz AND '.QUIZ.'.id_user = :id_user');
        $this->db->bind('id_user', $id_user);
        $this->db->bind('id_quiz', $id_quiz);
        $result =  $this->db->resultSet();
        
        return $result;
    }

    public function answer($userId, $quizId) {
        $this->db->query('SELECT '.ANSWER.'.* FROM '.QUIZ.' INNER JOIN '.QUESTIONS.' ON '.QUIZ.'.id = '.QUESTIONS.'.id_quiz INNER JOIN '.ANSWER.' ON '.QUESTIONS.'.id = '.ANSWER.'.id_question WHERE '.QUIZ.'.id =:quiz_id AND '.QUIZ.'.id_user =:user_id');
        $this->db->bind('quiz_id', $quizId);
        $this->db->bind('user_id', $userId);
        $result =  $this->db->resultSet();
        // var_dump($result);exit;
        return $result;
    }

    public function getAnswerIdByIdQuestion($id_question) {
        $this->db->query('SELECT id FROM '.ANSWER.' WHERE id_question = :id_question');
        $this->db->bind('id_question', $id_question);
        $result =  $this->db->resultSet();

        return $result;
    }

    public function createQuestion($quiz_id, $data) {
        if (count($data['answer']) < 4) {
            return 'Please fill all answer';
        }

        if (count($data['answer']) > 4 || count($data['answer']) < 1) {
            return 'Please fill only 4 answer';
        }

        $time = [15, 20, 30];
        if (!in_array($data['time'], $time)) {
            return 'Please select time';
        }
        
        if ($data['question'] == '') {
            return 'Please fill question';
        }

        if (isset($data['selected_answer'])) {
            if (count($data['selected_answer']) == 0) {
                return 'Please select answer';
            }
        }
        else {
            return 'Please select answer';
        }
        
        $this->db->query('INSERT INTO '.QUESTIONS.' VALUES (NULL, :question, :time, :id_quiz)');
        $this->db->bind('question', $data['question']);
        $this->db->bind('time', $data['time']);
        $this->db->bind('id_quiz', $quiz_id);
        $result =  $this->db->execute();
        
        $id_question = $this->db->lastInsertId();

        if (is_null($result)) {
            $i = 0;
            while ($answer = current($data['answer'])) {
                if (count($data['selected_answer']) > $i) {
                    if ($data['selected_answer'][$i] == key($data['answer'])) {
                        $this->db->query('INSERT INTO '.ANSWER.' VALUES (NULL, :choice, :is_answer, :id_question)');
                        $this->db->bind('choice', $answer);
                        $this->db->bind('is_answer', '1');
                        $this->db->bind('id_question', $id_question);
                        $this->db->execute();
                        $i++;
                    }
                    else {
                        $this->db->query('INSERT INTO '.ANSWER.' VALUES (NULL, :choice, :is_answer, :id_question)');
                        $this->db->bind('choice', $answer);
                        $this->db->bind('is_answer', '0');
                        $this->db->bind('id_question', $id_question);
                        $this->db->execute();
                    }
                }
                else {
                    $this->db->query('INSERT INTO '.ANSWER.' VALUES (NULL, :choice, :is_answer, :id_question)');
                    $this->db->bind('choice', $answer);
                    $this->db->bind('is_answer', '0');
                    $this->db->bind('id_question', $id_question);
                    $this->db->execute();
                }
                next($data['answer']);
            }
            return 'success';
        } 
        else {
            return 'Question failed to create';
        }
    }

    public function updateQuestion($quiz_id, $data) {
        if (count($data['answer']) < 4) {
            return 'Please fill all answer';
        }
        
        if (count($data['answer']) > 4 || count($data['answer']) < 1) {
            return 'Please fill only 4 answer';
        }
        
        $time = [15, 20, 30];
        if (!in_array($data['time'], $time)) {
            return 'Please select time';
        }
        
        if ($data['question'] == '') {
            return 'Please fill question';
        }
        
        if (isset($data['selected_answer'])) {
            if (count($data['selected_answer']) == 0) {
                return 'Please select answer';
            }
        }
        else {
            return 'Please select answer';
        }
        
        $this->db->query('UPDATE '.QUESTIONS.' SET question = :question, time = :time WHERE id = :id_question AND id_quiz = :id_quiz');
        $this->db->bind('question', $data['question']);
        $this->db->bind('time', $data['time']);
        $this->db->bind('id_question', $data['id']);
        $this->db->bind('id_quiz', $quiz_id);
        $result =  $this->db->execute();

        $answerId = $this->getAnswerIdByIdQuestion($data['id']);
        
        if (is_null($result)) {
            $i = 0;
            $a = 0;
            while($answer = current($data['answer'])) {
                if (count($data['selected_answer']) > $i) {
                    if ($data['selected_answer'][$i] == key($data['answer'])) {
                        $this->db->query('UPDATE '.ANSWER.' SET choice = :choice, is_answer = :is_answer WHERE id = :id_answer AND id_question = :id_question');
                        $this->db->bind('choice', $answer);
                        $this->db->bind('is_answer', '1');
                        $this->db->bind('id_answer', $answerId[$a]['id']);
                        $this->db->bind('id_question', $data['id']);
                        $this->db->execute();
                        $i++;
                    }
                    else {
                        $this->db->query('UPDATE '.ANSWER.' SET choice = :choice, is_answer = :is_answer WHERE id = :id_answer AND id_question = :id_question');
                        $this->db->bind('choice', $answer);
                        $this->db->bind('is_answer', '0');
                        $this->db->bind('id_answer', $answerId[$a]['id']);
                        $this->db->bind('id_question', $data['id']);
                        $this->db->execute();
                    }
                }
                else {
                    $this->db->query('UPDATE '.ANSWER.' SET choice = :choice, is_answer = :is_answer WHERE id = :id_answer AND id_question = :id_question');
                    $this->db->bind('choice', $answer);
                    $this->db->bind('is_answer', '0');
                    $this->db->bind('id_answer', $answerId[$a]['id']);
                    $this->db->bind('id_question', $data['id']);
                    $this->db->execute();
                }
                next($data['answer']);
                $a++;
            }
            return 'success';
        } 
        else {
            return 'Question failed to update';
        }
    }

    public function deleteQuestion($question_id, $quiz_id) {
        $this->db->query('DELETE FROM '.QUESTIONS.' WHERE id = :id AND id_quiz = :id_quiz');
        $this->db->bind('id', $question_id);
        $this->db->bind('id_quiz', $quiz_id);
        $result =  $this->db->execute();
        
        if (is_null($result)) {
            return 'success';
        } 
        else {
            return 'Question failed to delete';
        }
    }

    public function getQuestionAndAnswer($question_id, $quiz_id, $user_id) {
        $this->db->query('SELECT '.QUESTIONS.'.*, '.ANSWER.'.* FROM '.QUIZ.' INNER JOIN '.QUESTIONS.' ON '.QUIZ.'.id = '.QUESTIONS.'.id_quiz INNER JOIN '.ANSWER.' ON '.QUESTIONS.'.id = '.ANSWER.'.id_question WHERE '.QUIZ.'.id =:quiz_id AND '.QUIZ.'.id_user =:user_id AND '.QUESTIONS.'.id =:question_id');
        // $this->db->query('SELECT '.QUESTIONS.'.*, '.ANSWER.'.* FROM '.QUESTIONS.' INNER JOIN '.ANSWER.' ON '.QUESTIONS.'.id = '.ANSWER.'.id_question WHERE '.QUESTIONS.'.id =:question_id AND '.QUESTIONS.'.id_quiz =:quiz_id');
        $this->db->bind('quiz_id', $quiz_id);
        $this->db->bind('question_id', $question_id);
        $this->db->bind('user_id', $user_id);
        $result =  $this->db->resultSet();

        if ($result) {
            $res['id_question'] = $result[0]['id_question'];
            $res['question'] = $result[0]['question'];
            $res['time'] = $result[0]['time'];
            foreach ($result as $key => $value) {
                $res['answer'][$key] = [
                    // 'id' => $value['id'],
                    'choice' => $value['choice'],
                    'is_answer' => $value['is_answer'],
                ];           
            }
            return json_encode(['status' => 'success', 'data' => $res]);
        } 
        else {
            return json_encode(['status' => 'failed', 'data' => $result]);
        }
    }
    
    public function getQuestionAndAnswerByCode($code) {
        $this->db->query('SELECT '.QUESTIONS.'.*, '.ANSWER.'.* FROM '.QUIZ.' INNER JOIN '.QUESTIONS.' ON '.QUIZ.'.id = '.QUESTIONS.'.id_quiz INNER JOIN '.ANSWER.' ON '.QUESTIONS.'.id = '.ANSWER.'.id_question WHERE '.QUIZ.'.quiz_code =:code');
        $this->db->bind('code', $code);
        $result =  $this->db->resultSet();
        
        
        if ($result) {
            $question = '';
            $res = [];
            $i = 0;
            $j = 0;
            foreach($result as $key => $value) {
                if ($value['question'] != $question) {
                    $res[$i++] = [
                        'question' => $value['question'],
                        'question_qty' => count($result) / 4    ,
                        'time' => $value['time'],
                        'answer' => [
                            $j++ => [
                                'choice' => $value['choice'],
                                'is_answer' => $value['is_answer'],
                            ],
                        ],
                    ];
                    $question = $value['question'];
                }
                else {
                    $res[$i-1]['answer'][] = [
                        'choice' => $value['choice'],
                        'is_answer' => $value['is_answer'],
                    ];
                    $j =0;
                }
            }
            return $res;
        } 
        else {
            return 'failed';
        }
    }
}

