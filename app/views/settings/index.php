<?php

$user = $data['user'];

?>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-auto">
                <h3>Settings</h3>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow-sm w-100">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-user mr-1" aria-hidden="true"></i>
                        Profile
                    </div>
                    <div class="card-body">
                        <form id="form-profil" action="/settings/update" method="POST">
                            <label for="name">Name</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle"></i></span>
                                </div>
                                <input type="text" class="form-control" name="name" placeholder="Full Name" value="<?= $user['name'] ?>" autocomplete="off" required>
                            </div>
                            <label for="username">Username</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" name="username" placeholder="Username" value="<?= $user['username'] ?>" autocomplete="off" required>
                            </div>
                            <label for="email">Email</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-at"></i></span>
                                </div>
                                <input type="email" class="form-control" name="email" value="<?= $user['email'] ?>" placeholder="Email" autocomplete="off" required>
                            </div>                                                
                            <button type="submit" class="btn btn-primary mt-2 float-right">Change Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-lg-5 col-md-8">
                <div class="card shadow-sm w-100">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-lock mr-1" aria-hidden="true"></i>
                        Password
                    </div>
                    <div class="card-body">
                        <form id="form-password" action="/settings/update" method="POST">
                            <label for="password">New Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" name="password" placeholder="New Password" autocomplete="off" required>
                            </div>  
                            <label for="password">Confirm New Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" name="confirm-password" placeholder="Confirm New Password" autocomplete="off" required>
                            </div> 
                            <button type="submit" class="btn btn-primary mt-2 float-right">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5 mb-3">
            <p>Copyright 2021</p>
        </div>
    </div>