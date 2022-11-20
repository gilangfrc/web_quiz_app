<?php 
$dataQuiz = $data['quiz'];
?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <div class="col-sm-auto">
                <h3>Quiz by <?= $data['username'] ?></h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <?php foreach($dataQuiz as $quiz) : ?>
            <div class="col-md-auto flex-left mt-3 mb-3">
                <div class="card shadow-sm text-center h-100" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title mb-4"><?= $quiz['title'] ?></h5>
                        <form action="/quiz/play" method="POST">
                            <input type="hidden" name="quiz-code" value="<?= $quiz['quiz_code'] ?>">
                            <button type="submit" class="btn btn-primary" <?= $quiz['is_published'] == 0 ? 'disabled' : '' ?> style="width: 5rem;">Play</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach ?>

        </div>
        <div class="row justify-content-center mt-5 mb-3">
            <p>Copyright 2021</p>
        </div>
    </div>