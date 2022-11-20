<?php

$dataQuiz = $data['data_quiz'];

?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <div class="col-sm-auto">
                <h3>My Quiz</h3>
            </div>
        </div>
        <div class="row justify-content-left">
            <?php foreach($dataQuiz as $quiz) : ?>
            <div class="col-sm-auto flex-left mt-3 mb-3">
                <div class="card shadow-sm text-center h-100" style="width: 18rem;">
                    <div class="card-header-custom-2 mt-2 mr-3">
                        <div class="float-right">
                            <button type="button" class="close delete-quiz-btn" data-quiz-id="<?= $quiz['id'] ?>" data-quiz-title="<?= $quiz['title'] ?>" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>   
                        </div>    
                    </div>
                    <div class="card-body pt-0">
                        <h5 class="card-title tit"><?= $quiz['title'] ?></h5>
                        <p class="card-text"><?= $quiz['total_question'] ?> Question<?= $quiz['total_question'] > 1 ? 's' : ''?></p>
                        <a href="/quiz/edit/<?= $quiz['id'] ?>"><button type="button" class="btn btn-primary">Edit Quiz</button></a>
                    </div>
                    <?php $quiz['is_published'] == 0 ? $is_published = "Draf" : $is_published = "Published" ?>
                    <div class="card-footer text-muted">
                        <b><?= $is_published ?></b>
                    </div>
                </div>
            </div>
            <?php endforeach ?>

        </div>
        <div class="row justify-content-center mt-5 mb-3">
            <p>Copyright 2021</p>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-create-quiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header card-header-custom">
                        <div class="float-left mt-1">
                            <span>Quiz Title</span>
                        </div>
                        <div class="float-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>   
                        </div>                    
                </div>
                <div class="card-body">
                    <form action="/quiz/create" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" name="quiz-title" placeholder="Title for new quiz" autocomplete="off" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-2 float-right">Create Quiz</button>
                        <button type="button" class="btn btn-light mt-2 mr-2 float-right cancel-btn" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete-quiz" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="card-header card-header-custom">
                        <div class="float-left mt-1">
                            <span>Delete Quiz</span>
                        </div>
                        <div class="float-right">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>   
                        </div>                    
                </div>
                <div class="card-body">
                        <form id="delete-quiz" action="/quiz/delete" method="POST">
                            <div class="form-group">
                                <input type="hidden" name="quiz-id" id="quiz-id">
                                <label>Are you sure delete quiz <strong id="delete-modal-quiz-title"></strong> ?</label>
                            </div>
                            
                            <button type="submit" class="btn btn-light mt-2 float-right cancel-btn">Delete Quiz</button>
                            <button type="button" class="btn btn-primary mt-2 mr-2 float-right" data-dismiss="modal">Cancel</button>
                        </form>
                </div>
            </div>
        </div>
    </div>