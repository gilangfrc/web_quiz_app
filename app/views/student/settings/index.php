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
            <div class="col-md-5">
                <div class="card shadow w-100">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-user mr-1" aria-hidden="true"></i>
                        Profile
                    </div>
                    <div class="card-body">
                        <form id="form-profil">
                            <label for="username">Username</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="username" placeholder="Username" value="<?= $user['username'] ?>" autocomplete="off" required>
                            </div>
                            <label for="email">Email</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-at"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" value="<?= $user['email'] ?>" placeholder="Email" autocomplete="off" required>
                            </div>                                                
                            <button type="submit" class="btn btn-primary mt-2 float-right">Change Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-5">
                <div class="card shadow w-100">
                    <div class="card-header card-header-custom">
                        <i class="fas fa-lock mr-1" aria-hidden="true"></i>
                        Password
                    </div>
                    <div class="card-body">
                        <form id="form-password">
                            <label for="password">New Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="password" placeholder="New Password" autocomplete="off" required>
                            </div>  
                            <label for="password">New Password</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password" autocomplete="off" required>
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