<?php 
$quiz = $data['quiz'];
$question = $data['question'];
$answer = $data['answer'];

?>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-sm-auto">
                <h3><a href="#change-title" data-toggle="modal" data-target="#modal-change-quiz-title" id="quiz-title"><?= $quiz['title'] ?><i class="fas fa-pen ml-2" style="font-size:15px" aria-hidden="true"></i></a></h3>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <!-- <div class="col-md-5"> -->
            <div class="col-lg-5 col-md-8">
                <div class="card shadow-sm w-100">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-question-circle mr-1" aria-hidden="true"></i>
                        New Question
                    </div>
                    <div class="card-body">
                        <button class="btn btn-primary mt-2 float-right w-100" data-toggle="modal" data-target="#modal-add-question" id="add-question-btn">
                            <i class="fas fa-plus mr-1" aria-hidden="true"></i> Create New Question
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-5 col-md-8" id="questions-area">
                <?php $no = 1 ?>
                <?php foreach($question as $q) : ?>
                <div class="card shadow-sm w-100 mt-3">
                    <div class="card-header card-header-custom">
                        <div class="float-left mt-1">
                            <span>No. <?= $no ?></span>
                        </div>
                        <div class="float-right mt-1">
                            <span id="no-question"><?= $q['time'] ?>s</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><?= $q['question'] ?></label>
                        </div>
                        <?php foreach($answer as $a) : ?>
                        <?php if ($a['id_question'] == $q['id']) : ?>
                            <?php if ($a['is_answer'] == 1) : ?>
                            <div class="form-group">
                                <input type="text" class="form-control input-right-answer" value="<?= $a['choice'] ?>" disabled>
                            </div>
                            <?php else : ?>
                            <div class="form-group">
                                <input type="text" class="form-control choice" value="<?= $a['choice'] ?>" disabled>
                            </div>
                            <?php endif ?>   
                        <?php endif ?>     
                        <?php endforeach ?>                       
                                           
                        <button type="button" class="btn btn-primary mt-2 float-right edit-question-btn" data-toggle="modal" data-target="#modal-add-question" data-question-id="<?= $q['id'] ?>" data-question-no="<?= $no ?>"><i class="fas fa-pen mr-2" aria-hidden="true"></i>Edit Question</button>
                        <button type="button" class="btn btn-danger mt-2 mr-2 float-right delete-question-btn" data-question-no="<?= $no ?>" data-question-id="<?= $q['id'] ?>"><i class="fas fa-trash" aria-hidden="true"></i></button>
                    </div>
                </div>
                <?php $no++ ?>
                <?php endforeach ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-5 mt-5"></div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-add-question" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="card-header card-header-custom">
                        <div class="float-left mt-1">
                            <span id="modal-no">No. <?= count($question)+1 ?></span>
                        </div>
                        <div class="float-right">
                            <select class="form-control form-control-sm" name="" id="quiz-time" data-toggle="tooltip" data-placement="top" title="Time per question">
                                <option value="15">15s</option>
                                <option value="20">20s</option>
                                <option value="30">30s</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-add-question" class="form-question" method="POST">
                            <input type="hidden" id="id">
                            <div class="form-group">
                                <textarea class="form-control" id="question" rows="3" placeholder="Write your question here"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="select-answer" id="check-1" value="0">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="answer" id="a-1" placeholder="Answer 1" autocomplete="off">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="select-answer" id="check-2" value="1">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="answer" id="a-2" placeholder="Answer 2" autocomplete="off">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="select-answer" id="check-3" value="2">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="answer" id="a-3" placeholder="Answer 3" autocomplete="off">
                                </div>
                            </div>                            
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="select-answer" id="check-4" value="3">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="answer" id="a-4" placeholder="Answer 4" autocomplete="off">
                                </div>
                            </div>                            
                            
                            <button type="submit" class="btn btn-primary mt-2 float-right" id="add-modal-btn">Add Question</button>
                            <button type="button" class="btn btn-light mt-2 mr-2 float-right cancel-btn" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete Question -->
    <div class="modal fade" id="modal-delete-question" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header card-header-custom">
                        <div class="float-left mt-1">
                            <span>Delete Question</span>
                        </div>
                        <div class="float-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>   
                        </div>                    
                </div>
                <div class="card-body">
                    <form action="/question/delete" method="POST">
                        <div class="form-group">
                            <input type="hidden" id="question-id" name="id">
                            <label>Are you sure delete question <strong id="delete-modal-question-title"></strong> ?</label>
                        </div>
                        
                        <button type="submit" class="btn btn-light mt-2 float-right cancel-btn">Delete Question</button>
                        <button type="button" class="btn btn-primary mt-2 mr-2 float-right" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Change Title -->
    <div class="modal fade" id="modal-change-quiz-title" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header card-header-custom">
                        <div class="float-left mt-1">
                            <span>Change Quiz Title</span>
                        </div>
                        <div class="float-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>   
                        </div>                    
                </div>
                <div class="card-body">
                    <form action="/quiz/update-title" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" placeholder="Title For This Quiz" autocomplete="off" value="<?= $quiz['title'] ?>" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-2 float-right">Change Quiz Title</button>
                        <button type="button" class="btn btn-light mt-2 mr-2 float-right cancel-btn" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>