<?php
    require_once("../../includes/nonsessionrequire.php");
    if(isset($_GET['email']) && isset($_GET['key']))
    {
        if($_GET['email'] == '' || $_GET['key'] == '')
        {
            ?>
            <script>
                window.location.href = '../login';
            </script>
            <?php
        }
        else
        {
            $email = $_GET['email'];
            $key = $_GET['key'];
            if(getrows('confidential', json_encode(['email' => $email, 'passresetkey' => $key]), '') == 1)
            {}
            else
            {
                ?>
                <script>
                    window.location.href = '../login';
                </script>
                <?php
            }
        }
    }
    else
    {
        ?>
        <script>
            window.location.href = '../login';
        </script>
        <?php
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $sitename; ?> :: Password Recovery</title>
        <?php include_once("../../includes/css.php"); ?>
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><?php echo $sitetitle; ?></a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Create new password</p>
                    <?php
                        if(isset($_POST['change']))
                        {
                            $pass1 = $_POST['pass1'];
                            $pass2 = $_POST['pass2'];
                            if($pass1 != $pass2)
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Passwords are not matching!</h5>
                                </div>
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <input class="form-control" placeholder="Email" value="<?php echo $email; ?>" readonly>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" name="pass1" class="form-control" placeholder="Enter New Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" name="pass2" class="form-control" placeholder="Repeat New Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" name="change" class="btn btn-primary btn-block">Change Password</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                                <?php
                            }
                            else if(strlen($pass1) < 5)
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Password must have atleast 3 characters!</h5>
                                </div>
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <input class="form-control" placeholder="Email" value="<?php echo $email; ?>" readonly>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" name="pass1" class="form-control" placeholder="Enter New Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" name="pass2" class="form-control" placeholder="Repeat New Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" name="change" class="btn btn-primary btn-block">Change Password</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                                <?php
                            }
                            else if(strlen($pass1) > 25)
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Password is too long!</h5>
                                </div>
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <input class="form-control" placeholder="Email" value="<?php echo $email; ?>" readonly>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" name="pass1" class="form-control" placeholder="Enter New Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" name="pass2" class="form-control" placeholder="Repeat New Password" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-lock"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" name="change" class="btn btn-primary btn-block">Change Password</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                                <?php
                            }
                            else
                            {
                                $passhash = password_hash($pass1, PASSWORD_DEFAULT);
                                if(update("confidential", "password='$passhash', passreset=0, passresetkey=NULL", json_encode(['email' => $email]), ""))
                                {
                                    ?>
                                    <div class="alert alert-success">
                                        <h5><i class="icon fas fa-check"></i> Password changed</h5>
                                    </div>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <div class="alert alert-danger">
                                        <h5><i class="icon fas fa-ban"></i> Something went wrong!</h5>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        else
                        {
                            ?>
                            <form action="" method="post">
                                <div class="input-group mb-3">
                                    <input class="form-control" placeholder="Email" value="<?php echo $email; ?>" readonly>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" name="pass1" class="form-control" placeholder="Enter New Password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" name="pass2" class="form-control" placeholder="Repeat New Password" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" name="change" class="btn btn-primary btn-block">Change Password</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                            <?php
                        }
                    ?>
                    <p class="mt-3 mb-1">
                        <a href="../login">Login to Account</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
        <?php include_once("../../includes/scripts.php"); ?>
    </body>
</html>