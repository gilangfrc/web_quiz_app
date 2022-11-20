<?php
$user = $data['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="icon" type="icon/ico" href="/img/favicon.ico">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    <nav class="navbar sticky-top navbar-expand-xl navbar-dark bg-primary">
        <?php if ($data['home']) : ?>
            <a class="navbar-brand" href="/"><b>QUIZ APP</b></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>   
        
        <?php elseif (!$data['home'] || isset($data['edit-quiz'])) : ?>
            <a class="navbar-brand ml-2" href="/"><i class="fas fa-chevron-left" aria-hidden="true"></i></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

        <?php endif ?>  

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if ($data['home']) : ?>
                <li class="nav-item ml-2">
                    <a href="/quiz" class="nav-link">My Quiz</a>
                </li>
                <?php endif ?>
            </ul>

            <ul class="navbar-nav">
                <?php if ($data['home']) : ?>
                <button type="button" class="btn btn-light mr-3 w-mx-custom" id="create" data-toggle="modal" data-target="#modal-create-quiz">
                    <i class="fas fa-plus"></i> Create Quiz
                </button>
                <?php endif ?>
                
                <?php if (isset($data['edit-quiz'])) : ?>
                    <?php $quiz = $data['quiz'] ?>
                    <?php if($quiz['is_published'] == 1) : ?>
                    <button type="button" class="btn btn-light mr-2 w-mx-custom" data-clipboard-text="<?= $quiz['quiz_code'] ?>" id="quiz-code" data-toggle="tooltip" data-placement="bottom">
                        <i class="fas fa-copy" aria-hidden="true"></i>
                        <?= $quiz['quiz_code'] ?>
                    </button>
                    <button type="button" class="btn btn-light mr-2 w-mx-custom" onclick="window.location.href='/quiz/pause'" id="pause">Pause</button>
                    <?php else : ?>
                        <button type="button" class="btn btn-light mr-2 w-mx-custom" onclick="window.location.href='/quiz/publish'" <?= count($data['question']) < 1 ? 'Disabled' : '' ?>>Publish</button>
                    <?php endif ?>  
                <?php else : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle" src="<?= Support::getAvatar($user['name']) ?>" alt="" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <div class="dropdown-header">
                            <h6 class="mb-0 text-center"><?= $user['name'] ?></h6>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="/settings" class="dropdown-item">
                            <i class="fas fa-cog mr-2" aria-hidden="true"></i>Settings
                        </a>
                        <a href="/logout" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2" aria-hidden="true"></i>Logout
                        </a>
                    </div>
                </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>

    <?php Support::flash() ?>