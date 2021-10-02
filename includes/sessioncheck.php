<?php
    if(isset($_SESSION['user_id']))
    {
        if(isset($_COOKIE['user_id']) && isset($_COOKIE['rem']) && isset($_COOKIE['remcode']))
        {
            $user_id = $_COOKIE['user_id'];
            $rem = $_COOKIE['rem'];
            $remcode = $_COOKIE['remcode'];
            $cookieloginsql = "SELECT confidential.user_id, loginrecord.browser, loginrecord.device FROM confidential LEFT JOIN loginrecord ON confidential.user_id = loginrecord.user_id AND loginrecord.blocked='0' AND loginrecord.logout='0' AND loginrecord.active='1' WHERE confidential.user_id='$user_id' AND loginrecord.cookie='$remcode'";
            $cookieloginresult = mysqli_query($conn, $cookieloginsql);
            if(mysqli_num_rows($cookieloginresult) == 1)
            {
                $fetch = mysqli_fetch_array($cookieloginresult);
                $browser = $fetch['browser'];
                $device = $fetch['device'];
                if($browser == $user_browser && $device == $user_device)
                {
                    $_SESSION['user_id'] = $fetch['user_id'];
                    $time = time();
                    if($rem == 1)
                    {
                        setcookie("user_id", $user_id, $time + 31536000, "/");
                        setcookie("rem", $rem, $time + 31536000, "/");
                        setcookie("remcode", $remcode, $time + 31536000, "/");
                    }
                    else
                    {
                        setcookie("user_id", $user_id, $time + 86400, "/");
                        setcookie("rem", $rem, $time + 86400, "/");
                        setcookie("remcode", $remcode, $time + 86400, "/");
                    }
                    $user_id = $fetch['user_id'];
                    update('loginrecord', "ip='$ip'", json_encode(['user_id'=>$user_id, 'cookie'=>$remcode, 'active'=>'1']), '');
                    $platform = $user_os;
                    $browser = $user_browser;
                    $device = $user_device;
                    require_once('sessionrequire.php');
                }
                else
                {
                    update('loginrecord', "active='0'", json_encode(['user_id'=>$user_id, 'cookie'=>$remcode, 'active'=>'1']), '');
                    ?>
                    <script type="text/javascript">
                        window.location.href="../logout";
                    </script>
                    <?php
                }
            }
            else
            {
                ?>
                <script type="text/javascript">
                    window.location.href="../logout";
                </script>
                <?php
            }
        }
        else if(!isset($_COOKIE['user_id']) && !isset($_COOKIE['rem']) && !isset($_COOKIE['remcode']))
        {
            $user_id = $_SESSION['user_id'];
            $rem = $_SESSION['rem'];
            $remcode = md5(rand());
            $time = time();
            if($rem == 1)
            {
                setcookie("user_id", $user_id, $time + 31536000, "/");
                setcookie("rem", $rem, $time + 31536000, "/");
                setcookie("remcode", $remcode, $time + 31536000, "/");
            }
            else
            {
                setcookie("user_id", $user_id, $time + 86400, "/");
                setcookie("rem", $rem, $time + 86400, "/");
                setcookie("remcode", $remcode, $time + 86400, "/");
            }
            $platform = $user_os;
            $browser = $user_browser;
            $device = $user_device;
            $data = json_encode(['user_id'=>$user_id, 'cookie'=>$remcode, 'ip'=>$ip, 'platform'=>$platform, 'browser'=>$user_browser, 'device'=>$device, 'first_login'=>$time]);
            insert('loginrecord', $data);
            require_once('sessionrequire.php');
        }
        else
        {
            ?>
            <script type="text/javascript">
                window.location.href="../logout";
            </script>
            <?php
        }
    }
    else if(isset($_COOKIE['user_id']) && isset($_COOKIE['rem']) && isset($_COOKIE['remcode']))
    {
        $user_id = $_COOKIE['user_id'];
        $rem = $_COOKIE['rem'];
        $remcode = $_COOKIE['remcode'];
        $cookieloginsql = "SELECT confidential.user_id, loginrecord.browser, loginrecord.device FROM confidential LEFT JOIN loginrecord ON confidential.user_id = loginrecord.user_id AND loginrecord.blocked='0' AND loginrecord.logout='0' AND loginrecord.active='1' WHERE confidential.user_id='$user_id' AND loginrecord.cookie='$remcode'";
        $cookieloginresult = mysqli_query($conn, $cookieloginsql);
        if(mysqli_num_rows($cookieloginresult) == 1)
        {
            $fetch = mysqli_fetch_array($cookieloginresult);
            $browser = $fetch['browser'];
            $device = $fetch['device'];
            if($browser == $user_browser && $device == $user_device)
            {
                $_SESSION['user_id'] = $fetch['user_id'];
                $_SESSION['rem'] = $rem;
                $time = time();
                if($rem == 1)
                {
                    setcookie("user_id", $user_id, $time + 31536000, "/");
                    setcookie("rem", $rem, $time + 31536000, "/");
                    setcookie("remcode", $remcode, $time + 31536000, "/");
                }
                else
                {
                    setcookie("user_id", $user_id, $time + 86400, "/");
                    setcookie("rem", $rem, $time + 86400, "/");
                    setcookie("remcode", $remcode, $time + 86400, "/");
                }
                $user_id = $fetch['user_id'];
                update('loginrecord', "ip='$ip', last_login='$time'", json_encode(['user_id'=>$user_id, 'cookie'=>$remcode]), '');
                $platform = $user_os;
                $browser = $user_browser;
                $device = $user_device;
                require_once('sessionrequire.php');
            }
            else
            {
                update('loginrecord', "active='0'", json_encode(['user_id'=>$user_id, 'cookie'=>$remcode]), '');
                ?>
                <script type="text/javascript">
                    window.location.href="../logout";
                </script>
                <?php
            }
        }
        else
        {
            ?>
            <script type="text/javascript">
                window.location.href="../logout";
            </script>
            <?php
        }
    }
    else
    {
        ?>
        <script type="text/javascript">
            window.location.href="../logout";
        </script>
        <?php
    }
?>