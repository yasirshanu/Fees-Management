<?php require_once("../../includes/nonsessionrequire.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> :: Login</title>
        <?php include_once("../../includes/css.php"); ?>
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><?php echo $sitetitle; ?></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <?php
                        if(isset($_POST['submit']))
                        {
                            $username = mysqli_real_escape_string($conn, $_POST['username']);
                            $password = mysqli_real_escape_string($conn, $_POST['password']);
                            if(isset($_POST['remember']))
                            {
                                $remember = 1;
                            }
                            else
                            {
                                $remember = 0;
                            }
                            if($username == '' || $password == '')
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <span>Username or Password cannot be blank!</span>
                                </div>
                                <?php
                            }
                            else
                            {
                                if(getrows('confidential', json_encode(['username' => $username]), '') == 1)
                                {
                                    $hash = getvalue('password', 'confidential', json_encode(['username' => $username]), '');
                                    if(password_verify($password, $hash))
                                    {
                                        $result = getresult('*', 'confidential', json_encode(['username' => $username]), '', '', '', '');
                                        $row = mysqli_fetch_array($result);
                                        $_SESSION['user_id'] = $row['user_id'];
                                        $_SESSION['fname'] = $row['fname'];
                                        $_SESSION['mname'] = $row['mname'];
                                        $_SESSION['lname'] = $row['lname'];
                                        $_SESSION['email'] = $row['email'];
                                        $_SESSION['username'] = $row['username'];
                                        $_SESSION['rem'] = $remember;
                                        ?>
                                        <div class="alert alert-success">
                                            <span>Login Successful<br>Redirecting...</span>
                                        </div>
                                        <script>window.location.href='../dashboard';</script>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <div class="alert alert-danger">
                                            <span>Invalid Password!</span>
                                        </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <div class="alert alert-danger">
                                        <span>Invalid Username!</span>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    ?>
                    <form action="" method="post">
                        <div class="input-group mb-3">
                            <input id="username" name="username" type="text" class="form-control" placeholder="Enter Username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Enter Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span id="see" class="fas fa-eye-slash"></span>
                                </div>
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4">
                                <button id="login-btn" name="submit" type="submit" class="btn btn-primary btn-block" disabled>Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        <?php
                            if($mailer != 0)
                            {
                                ?>
                                <div class="row">
                                    <div class="col-12">
                                    <a href="../forgot-password">Forgot Password?</a>
                                    </div>
                                </div>
                                <?php
                            }
                        ?>
                    </form>
                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.login-box -->
        <?php include_once("../../includes/scripts.php"); ?>
        <script>
            document.getElementById("see").addEventListener("click", passsee);
            document.getElementById("username").addEventListener("change", logincheck);
            document.getElementById("password").addEventListener("change", logincheck);
            function passsee(){
                eye = document.getElementById("see").classList;
                pass = document.getElementById("password");
                if(eye.contains("fa-eye-slash")){
                    eye.replace("fa-eye-slash", "fa-eye");
                    pass.type = "text";
                }
                else{
                    eye.replace("fa-eye", "fa-eye-slash");
                    pass.type = "password";
                }
            }

            function logincheck(){
                username = document.getElementById("username").value;
                password = document.getElementById("password").value;
                loginbtn = document.getElementById("login-btn");
                if(username == '' || password == '')
                {
                    loginbtn.disabled = true;
                }
                else
                {
                    loginbtn.disabled = false;
                }
            }
        </script>
    </body>
</html>
