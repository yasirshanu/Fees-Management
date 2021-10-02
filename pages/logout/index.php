<?php
    session_start();
    session_unset();
    session_destroy();
    require_once('../../includes/connect.php');
    require_once('../../includes/methods.php');
    $time = time();
    if(isset($_COOKIE['user_id']) && isset($_COOKIE['rem']) && isset($_COOKIE['remcode']))
    {
        $user_id = $_COOKIE['user_id'];
        $rem = $_COOKIE['rem'];
        $remcode = $_COOKIE['remcode'];
        update('loginrecord', "logout='1'", json_encode(['user_id'=>$user_id, 'cookie'=>$remcode]), '');
        if($rem == 1)
        {
            setcookie("user_id", "", $time - 31536000, "/");
            setcookie("rem", "", $time - 31536000, "/");
            setcookie("remcode", "", $time - 31536000, "/");
        }
        else
        {
            setcookie("user_id", $user_id, $time - 86400, "/");
            setcookie("rem", $rem, $time - 86400, "/");
            setcookie("remcode", $remcode, $time - 86400, "/");
        }
    }
    else
    {
        if(isset($_COOKIE['user_id']))
        {
            setcookie('user_id', '', $time - 31536000, "/");
        }
        if(isset($_COOKIE['rem']))
        {
            setcookie('rem', '', $time - 31536000, "/");
        }
        if(isset($_COOKIE['remcode']))
        {
            setcookie('remcode', '', $time - 31536000, "/");
        }
    }
    ?>
    <script>window.location.href='../login';</script>
    <?php
?>