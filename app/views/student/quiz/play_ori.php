<?php
$quiz = $data['quiz'];
$_SESSION['quiz']['code'] = $quiz[0]['quiz_code'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Quiz</title>
    <link rel="icon" type="icon/ico" href="/img/favicon.ico">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <style>
        #progress {
            width: 100%;
            background-color: #fff;
        }

        #bar {
            width: 100%;
            height: 10px;
            background-color: #007bff;
            line-height: 10px;
        }
    </style>
</head>
<body class="bg-primary">
    <div id="progress-area">
        <div id="progress">
            <div id="bar">

            </div>
        </div>
    </div>  
    <div class="container">

        <div class="login_box info_box activeInfo" id="quiz-box">
            <div class="card">
                <div class="card-header text-center bg-transparent">
                    <h4 class="my-0">Quiz Info</h4>
                </div>
                <div class="card-body text-center">
                    <h4 class="mb-1"><?= $quiz[0]['title']?></h4>
                    <!-- <p>By <b><?= $_SESSION['login']['username'] ?></b></p> -->
                    <p class="my-0 mt-4"><?= count($quiz) > 1 ? count($quiz).' Questions' : count($quiz).' Question' ?></p>
                </div>
                <div class="card-footer bg-transparent">             
                    <button class="btn btn-primary float-right w-custom" id="start">Start Quiz</button>
                    <button class="btn btn-light float-right mr-2 cancel-btn w-custom exit" data-exit="<?= BASEURL ?>">Exit</button>
                </div>
            </div>
        </div>
        
        <div class="quiz_box" id="questions-box">

                <!-- <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary loading" role="status"></div>
                </div> -->

            <div class="card">                
                <div class="card-header bg-transparent py-2 custom-header-box">
                    <div class="float-left">
                        <h5 class="mb-0" id="no"></h5>
                    </div>
                    <div class="float-right">
                        <input type="text" id="time" data-time="" class="form-control float-right time" disabled>
                    </div>
                </div>
                <div class="card-body px-5">
                    
                    <div class="form-group">
                        <h3  class="mb-4" id="question"></h3>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control choice input-choice" name="choice" id="choice-1" value="" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control choice input-choice" name="choice" id="choice-2" value="" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control choice input-choice" name="choice" id="choice-3" value="" readonly>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control choice input-choice" name="choice" id="choice-4" value="" readonly>
                    </div>
                </div>
                <div class="card-footer bg-transparent">             
                    <button class="btn btn-primary float-right w-custom" id="next" disabled>Next</button>
                </div>
            </div>

        </div>

        <div class="login_box info_box" id="result-box">
            <div class="card">
                <div class="card-header text-center bg-transparent">
                    <h4 class="my-0">Result</h4>
                </div>
                <div class="card-body text-center">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="card border-0">
                            <img class="rounded-circle shadow-sm w-25 mx-auto d-block" src="<?= Support::getAvatar($_SESSION['login']['username'], 'fff', '007bff') ?>" alt="" />
                                <div class="card-body">
                                    <h4 class="card-title mb-0"><?= $_SESSION['login']['username'] ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card text-white bg-success">
                                <div class="card-body p-3">
                                    <h5 class="mb-0"> <i class="fas fa-check-circle"></i> <span id="right"></span></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card text-white bg-danger">
                                <div class="card-body p-3">
                                    <h5 class="mb-0"> <i class="fas fa-times-circle"></i> <span id="wrong"></span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent">             
                    <button class="btn btn-primary float-right w-custom exit" data-exit="<?= BASEURL ?>">Exit</button>
                    <button class="btn btn-light float-right cancel-btn mr-2" id="replay">Play Again</button>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal Alert -->
    <div class="modal fade" id="alert" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="alert alert-dismissible fade show alert-message" role="alert">
                <span id="alert-message"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        $(function () {
            var answer = [];
            var timer;
            var question_qty;
            var temp_answer = [];
            
            $('.loading').hide();

            $('#start').click(function (e) { 
                e.preventDefault();
                
                $('#quiz-box').hide();
                $('#questions-box').show().addClass('activeQuiz');
                showQuestions();
                counter();
            });

            $('.exit').click(function () { 
                window.location.href = $(this).data('exit');
            });

            let i = 2;
            $('#next').click(function (e) { 
                e.preventDefault();
                
                clearInterval(timer);
                showQuestions(i++);
                counter();
            });

            $('.input-choice').click(function (e) { 
                e.preventDefault();

                answer.push($(this).val());
                
                clearInterval(timer);
                $(this).addClass('selected-choice');
                $('.input-choice').attr('disabled', true);

                showQuestions(i++);
                counter();
            });

            function showQuestions(no=1) {
                console.log(answer);
                
                clear();

                if (no > question_qty) {
                    clearInterval(timer);
                    $('#questions-box').hide();
                    console.log(answer);
                    // getResult(answer);
                    $('#result-box').show().addClass('activeInfo');
                }
                else {
                    $.ajax({
                        type: "POST",
                        url: "/question/get",
                        data: {no:no},
                        dataType: "JSON",
                        success: function (response) {
                            $('.input-choice').removeClass('selected-choice');
                            $('.input-choice').removeAttr('disabled');
                            question_qty = response.question_qty;
                            //$('#questions-box').html(response);
                            $('.loading').hide();
                            $('#question').html(response.question);
                            $('#no').html("No. "+no);
                            for (let j = 1; j <= response.answer.length; j++) {
                                $('#choice-'+j).val(response.answer[j-1].choice);
                            }

                            $('#time').val(response.time);
                            $('#time').data('time', response.time);
                            $('#next').attr('disabled', true);        
                        }
                    });
                }
            }

            $('#replay').click(function () { 
                window.location.href = window.location.href;
            });

            function getResult(answer) {
                $.ajax({
                    type: "POST",
                    url: "/quiz/get-result",
                    data: {answer:answer},
                    dataType: "JSON",
                    success: function (response) {
                        $('#right').html(response.right);
                        $('#wrong').html(response.wrong);
                    }
                });
            }

            function counter() {
                // timer = setInterval(function () {
                //     var count = parseInt($('#time').val());
                //     if (count !== 0) {
                //         $('#time').val(count - 1);
                //     }
                //     else {
                //         answer.push("");
                //         showQuestions(i++);
                //         $('#next').removeAttr('disabled');
                //     }
                // }, 1000);    
                timer = setInterval(function () {
                    // var time = parseInt($('#time').data('time'));
                    var count = parseInt($('#time').val());
                    console.log(count);
                    if (count === 0) {
                        // width = 100;
                        // $('#bar').width('100%');
                        answer.push("");
                        showQuestions(i++);
                        // $('#next').removeAttr('disabled');
                        // clearInterval(timer);
                    }
                    else {
                        // width -= (100/time);
                        $('#time').val(count - 1);
                        // $('#bar').width(width+'%');
                    }
                }, 1000);               
            }

            function clear() {
                $('#no').html("");
                $('#time').html("");
                $('#question').html("");
                for (let j = 1; j <= 4; j++) {
                    $('#choice-'+j).val("");
                }
            }

        });
    </script>
</body>
</html>