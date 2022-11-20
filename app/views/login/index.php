<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="icon/ico" href="/img/favicon.ico">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <!-- FontAweome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
    
    <?php Support::flash() ?>

    <div class="login_box info_box activeInfo">
    
        <div class="card" id="login-box" style="<?= isset($_SESSION['failed']) ? 'display:none' : '' ?>">
            <div class="card-header float-right bg-transparent">
                <h4 class="my-0">Login</h4>
            </div>
            <div class="card-body">
            <form id="login-form" action="" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off" autofocus required>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off" required>
                </div>
                       
            </div>
            <div class="card-footer bg-transparent">             
                <button type="submit" class="btn btn-primary float-right">Login</button>
                <button class="btn btn-light float-right mr-2 cancel-btn" id="register">Register</button>
            </div>
            </form>
        </div>

        <div class="card" id="register-box" style="<?= isset($_SESSION['failed']) ? '' : 'display:none' ?>">
            <?php unset($_SESSION['failed']) ?>
            <div class="card-header float-right bg-transparent">
                <h4 class="my-0">Register</h4>
            </div>
            <div class="card-body">
            <form id="register-form" action="/register" method="POST">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-user-circle"></i></span>
                    </div>
                    <input type="text" class="form-control" id="reg-name" name="name" placeholder="Full Name" autocomplete="off">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                    </div>
                    <input type="text" class="form-control" id="reg-username" name="username" placeholder="Username" autocomplete="off">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-at"></i></span>
                    </div>
                    <input type="email" class="form-control" id="reg-email" name="email" placeholder="Email" autocomplete="off">
                </div>
                <div class="form-group">
                    <select name="user-type" class="custom-select">
                        <option value="1">Student</option>
                        <option value="2">Teacher</option>
                    </select>
                </div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="reg-password" name="password" placeholder="Password" autocomplete="off">
                </div>        
            </div>
            <div class="card-footer bg-transparent">             
                <button type="submit" class="btn btn-primary float-right">Register</button>
                <button class="btn btn-light float-right mr-2 cancel-btn" id="back">Back</button>
            </div>
            </form>
        </div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/js/remove-alert.js"></script>
    <script>
        $(function () {

            $('#register').click(function (e) { 
                e.preventDefault();
                $('#login-box').hide();
                $('#register-box').show();
            });

            $('#back').click(function (e) { 
                e.preventDefault();
                $('#login-box').show();
                $('#register-box').hide();
            });

            // $('#login-form').on('submit', function (e) {
            //     e.preventDefault();
            //     const username = $('#username').val();
            //     const password = $('#password').val();
                
            //     $.ajax({
            //         type: "POST",
            //         url: "http://localhost/QuizApp/login/login",
            //         data: {username:username, password:password},
            //         dataType: "JSON",
            //         success: function (response) {
            //             if (response.status) {
            //                 $('.alert-message').removeClass('alert-danger').addClass('alert-success');
            //                 $('#alert-message').html(response.message);
            //                 window.location.href = "http://localhost/QuizApp/welcome/";
            //             }
            //             else {
            //                 $('.alert-message').removeClass('alert-success').addClass('alert-danger');
            //                 $('#alert-message').html(response.message);
            //                 disposeTime('#alert');
            //             }
            //             $('#alert').modal('show');
            //         }
            //     });
            // });

            // $('#register-form').on('submit', function (e) {
            //     e.preventDefault();
            //     const reg_username = $('#reg-username').val();
            //     const reg_email = $('#reg-email').val();
            //     const user_type = $('#user-type').val();
            //     const reg_password = $('#reg-password').val();
            //     // const re_password = $('#re-password').val();
                
            //     $.ajax({
            //         type: "POST",
            //         url: "http://localhost/QuizApp/register/register",
            //         data: {username:reg_username, email:reg_email, user_type:user_type, password:reg_password},
            //         dataType: "JSON",
            //         success: function (response) {
            //             if (response.status) {
            //                 $('.alert-message').removeClass('alert-danger').addClass('alert-success');
            //                 $('.alert-message').addClass('alert-success');
            //                 $('#alert-message').html(response.message);
            //                 disposeTime('#alert');
            //                 $('#reg-username').val('');
            //                 $('#reg-email').val('');
            //                 $('#reg-type').val('');
            //                 $('#reg-password').val('');
            //             }
            //             else {
            //                 $('.alert-message').removeClass('alert-success').addClass('alert-danger');
            //                 $('.alert-message').addClass('alert-success');
            //                 $('#alert-message').html(response.message);
            //                 disposeTime('#alert');
            //             }
            //             $('#alert').modal('show');
            //         }
            //     });
            // });
        });

    </script>
</body>
</html>