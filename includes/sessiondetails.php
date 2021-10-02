<?php
    $fname = getvalue('fname', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
    $mname = getvalue('mname', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
    $lname = getvalue('lname', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
?>