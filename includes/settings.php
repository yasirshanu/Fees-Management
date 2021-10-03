<?php
    $username = getvalue('username', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
    $email = getvalue('email', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
    $usert_id = getvalue('usertype', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
    $usert = getvalue('usertype_name', 'usertype', json_encode(['usertype_id'=> $usert_id]), '');
    $fullname = $fname." ".$mname." ".$lname;
?>