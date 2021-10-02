<?php
    if(isset($_COOKIE['user_id']) && isset($_COOKIE['rem']) && isset($_COOKIE['remcode']))
    {
        ?>
        <script>
            window.location.href='../dashboard';
        </script>
        <?php
    }
    else if(isset($_COOKIE['user_id']) || isset($_COOKIE['rem']) || isset($_COOKIE['remcode']))
    {
        ?>
        <script>
            window.location.href='../logout';
        </script>
        <?php
    }
    else
    {}
?>