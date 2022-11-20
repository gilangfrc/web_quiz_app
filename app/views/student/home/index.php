<?php
$recent = $data['recent_quiz'];
?>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-sm-auto">
                <h3>Quiz</h3>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-5 col-md-8">

                <div class="card shadow-sm w-100">
                    <div class="card-header card-header-custom">
                        Start Quiz
                    </div>
                    <div class="card-body">
                        <div class="form-group my-0">
                            <form action="/quiz/play" method="POST">
                                <div class="input-group input-group-lg">
                                    <input type="text" class="form-control" name="quiz-code" placeholder="Enter Code" maxlength="6" autocomplete="off" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary ">Play</button>
                                    </div>
                                </div>
                            </form>
                        </div>        
                    </div>
                </div>

            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-sm-auto">
                <h3>Recently Played Quiz</h3>
            </div>
        </div>
        <div class="row justify-content-left mt-3">
            <?php foreach($recent as $quiz) : ?>
            <div class="col-md-auto flex-left mt-3 mb-3">
                <div class="card shadow-sm text-center h-100" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title"><?= $quiz['title'] ?></h5>
                        <p class="card-text">By. <a href="/quiz/by/<?= $quiz['username'] ?>" target="_blank"><?= $quiz['name'] ?></a></p>
                        <form action="/quiz/play" method="POST">
                            <input type="hidden" name="quiz-code" value="<?= $quiz['quiz_code'] ?>">
                            <button type="submit" class="btn btn-primary" <?= $quiz['is_published'] == 0 ? 'disabled' : '' ?>>Play Again</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>