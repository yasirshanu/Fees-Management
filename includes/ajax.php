<?php
    if(isset($_POST['request']))
    {
        include_once("connect.php");
        include_once("methods.php");
        if($_POST['request'] == 'passchange')
        {
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['newpass'];
            $repeatpass = $_POST['repeatpass'];
            $hash = getvalue('password', 'confidential', json_encode(['user_id'=>$_SESSION['user_id']]), '');
            if($oldpass == '' || $newpass == '' || $repeatpass == '')
            {
                echo 0;
            }
            else if($newpass !== $repeatpass)
            {
                echo 1;
            }
            else if(strlen($newpass) < 5 || strlen($repeatpass) < 5)
            {
                echo 2;
            }
            else if(!password_verify($oldpass, $hash))
            {
                echo 3;
            }
            else
            {
                $newhash = password_hash($newpass, PASSWORD_DEFAULT);
                if(password_verify($oldpass, $hash))
                {
                    if($newpass == $oldpass)
                    {
                        echo 6;
                    }
                    else
                    {
                        if(update("confidential", "password='$newhash'", json_encode(['user_id'=>$_SESSION['user_id']]), ''))
                        {
                            echo 4;
                        }
                        else
                        {
                            echo 5;
                        }
                    }
                }
            }
        }
        else if($_POST['request'] == 'updateut')
        {
            $utid = $_POST['usertype_id'];
            $ut = $_POST['usertype'];
            if(getrows('usertype', json_encode(['usertype_id' => $utid]), '') == 0)
            {
                echo 0;
            }
            else if($ut == '')
            {
                echo 1;
            }
            else if(strlen($ut) > 20)
            {
                echo 2;
            }
            else if(getrows('usertype', json_encode(['usertype_name' => $ut]), '') > 0)
            {
                echo 3;
            }
            else
            {
                if(update("usertype", "usertype_name='$ut'", json_encode(['usertype_id' => $utid]), ''))
                {
                    echo 4;
                }
                else
                {
                    echo 5;
                }
            }
        }
        else if($_POST['request'] == 'addusertype')
        {
            $usertype = $_POST['usertype'];
            if($usertype == '')
            {
                echo 0;
            }
            else if(strlen($usertype) > 20)
            {
                echo 1;
            }
            else if(getrows('usertype', json_encode(['usertype_name' => $usertype]), '') > 0)
            {
                echo 2;
            }
            else
            {
                $time = time();
                $added_by = $_SESSION['user_id'];
                if(insert('usertype', json_encode(['usertype_name' => $usertype, 'created_by' => $added_by, 'time' => $time])))
                {
                    echo 3;
                }
                else
                {
                    echo 4;
                }
            }
        }
        else if($_POST['request'] == 'detut')
        {
            $utid = $_POST['usertype_id'];
            if(getrows('usertype', json_encode(['usertype_id' => $utid]), '') == 0)
            {
                echo 0;
            }
            else
            {
                if(delete('usertype', json_encode(['usertype_id' => $utid]), ''))
                {
                    echo 1;
                }
                else
                {
                    echo 2;
                }
            }
        }
        else if($_POST['request'] == 'getUserTypeData')
        {
            ?>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Type</th>
                        <th>Added By</th>
                        <th>Added Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $rows = getrows('usertype', '', 'usertype_id > 0');
                        $result = getresult('*', 'usertype', '', 'usertype_id > 0', 'time', '', '');
                        while($row = mysqli_fetch_array($result))
                        {
                            if($row['usertype_id'] != 1)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['usertype_name']; ?></td>
                                    <td>
                                        <?php
                                            $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['created_by']]), '');
                                            $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['created_by']]), '');
                                            $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['created_by']]), '');
                                            echo $first." ".$middle." ".$last;
                                        ?>
                                    </td>
                                    <td><?php echo date("d-m-Y h:i:s A", $row['time']); ?></td>
                                    <td><i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="setupdate('<?php echo $row['usertype_id']; ?>', '<?php echo $row['usertype_name']; ?>')"></i> <?php if(getrows('confidential', json_encode(['usertype' => $row['usertype_id']]), '') == 0){ ?><i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="delut('<?php echo $row['usertype_id'] ?>')"></i><?php } ?></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": false,
                        "info": true,
                        "autoWidth": true,
                        "responsive": true,
                        "buttons": ["pdf", "print"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
            <?php
        }
        else if($_POST['request'] == 'unamecheck')
        {
            $uid = $_POST['uid'];
            $uname = $_POST['username'];
            if($uname == '')
            {
                echo 0;
            }
            else if(strlen($uname) < 5)
            {
                echo 1;
            }
            else if(strlen($uname) > 15)
            {
                echo 2;
            }
            else
            {
                if($uid != '')
                {
                    $olduname = getvalue('username', 'confidential', json_encode(['user_id' => $uid]), '');
                    if($olduname == $uname)
                    {
                        echo 5;
                    }
                    else if(getrows('confidential', json_encode(['username' => $uname]), '') > 0)
                    {
                        echo 3;
                    }
                    else
                    {
                        echo 4;
                    }
                }
                else if(getrows('confidential', json_encode(['username' => $uname]), '') > 0)
                {
                    echo 3;
                }
                else
                {
                    echo 4;
                }
            }
        }
        else if($_POST['request'] == 'emailcheck')
        {
            $uid = $_POST['uid'];
            $email = $_POST['email'];
            if($email == '')
            {
                echo 0;
            }
            else if(strlen($email) < 5)
            {
                echo 1;
            }
            else if(strlen($email) > 50)
            {
                echo 2;
            }
            else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                echo 4;
            }
            else
            {
                if($uid != '')
                {
                    $oldemail = getvalue('email', 'confidential', json_encode(['user_id' => $uid]), '');
                    if($oldemail == $email)
                    {
                        echo 6;
                    }
                    else if(getrows('confidential', json_encode(['email' => $email]), '') > 0)
                    {
                        echo 3;
                    }
                    else
                    {
                        echo 5;
                    }
                }
                else if(getrows('confidential', json_encode(['email' => $email]), '') > 0)
                {
                    echo 3;
                }
                else
                {
                    echo 5;
                }
            }
        }
        else if($_POST['request'] == 'updateUser')
        {
            $uid = $_POST['uid'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $usertype = $_POST['usertype'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            if(getrows('confidential', json_encode(['user_id' => $uid]), '') == 0)
            {
                echo 0;
            }
            else if($fname == '')
            {
                echo 1;
            }
            else if(strlen($fname) > 15)
            {
                echo 2;
            }
            else if($mname !== '' && strlen($mname) > 15)
            {
                echo 3;
            }
            else if($lname == '')
            {
                echo 4;
            }
            else if(strlen($lname) > 15)
            {
                echo 5;
            }
            else if($usertype == '')
            {
                echo 6;
            }
            else if(getrows('usertype', json_encode(['usertype_id' => $usertype]), '') == 0)
            {
                echo 7;
            }
            else if($username == '')
            {
                echo 8;
            }
            else if(strlen($username) < 5)
            {
                echo 9;
            }
            else if(strlen($username) > 15)
            {
                echo 10;
            }
            else if(($username != getvalue('username', 'confidential', json_encode(['user_id' => $uid]), '')) && (getrows('confidential', json_encode(['username' => $username]), '') > 0))
            {
                echo 11;
            }
            else if($email == '')
            {
                echo 12;
            }
            else if(strlen($email) < 5)
            {
                echo 13;
            }
            else if(strlen($email) > 50)
            {
                echo 14;
            }
            else if(($email != getvalue('email', 'confidential', json_encode(['user_id' => $uid]), '')) && (getrows('confidential', json_encode(['email' => $email]), '') > 0))
            {
                echo 15;
            }
            else
            {
                if(update("confidential", "fname='$fname', mname='$mname', lname='$lname', usertype='$usertype', username='$username', email='$email'", json_encode(['user_id' => $uid]), ""))
                {
                    echo 16;
                }
                else
                {
                    echo 17;
                }
            }
        }
        else if($_POST['request'] == 'addUser')
        {
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $lname = $_POST['lname'];
            $usertype = $_POST['usertype'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $pass1 = $_POST['pass1'];
            $pass2 = $_POST['pass2'];
            if($fname == '')
            {
                echo 0;
            }
            else if(strlen($fname) > 15)
            {
                echo 1;
            }
            else if($mname !== '' && strlen($mname) > 15)
            {
                echo 2;
            }
            else if($lname == '')
            {
                echo 3;
            }
            else if(strlen($lname) > 15)
            {
                echo 4;
            }
            else if($usertype == '')
            {
                echo 5;
            }
            else if(getrows('usertype', json_encode(['usertype_id' => $usertype]), '') == 0)
            {
                echo 6;
            }
            else if($username == '')
            {
                echo 7;
            }
            else if(strlen($username) < 5)
            {
                echo 8;
            }
            else if(strlen($username) > 15)
            {
                echo 9;
            }
            else if(getrows('confidential', json_encode(['username' => $username]), '') > 0)
            {
                echo 10;
            }
            else if($email == '')
            {
                echo 11;
            }
            else if(strlen($email) < 5)
            {
                echo 12;
            }
            else if(strlen($email) > 50)
            {
                echo 13;
            }
            else if(getrows('confidential', json_encode(['email' => $email]), '') > 0)
            {
                echo 14;
            }
            else if($pass1 !== $pass2)
            {
                echo 15;
            }
            else if(strlen($pass1) < 5 || strlen($pass1) < 5)
            {
                echo 16;
            }
            else if(strlen($pass1) > 25 || strlen($pass2) > 25)
            {
                echo 17;
            }
            else
            {
                $time = time();
                $added_by = $_SESSION['user_id'];
                $passhash = password_hash($pass1, PASSWORD_DEFAULT);
                if(insert('confidential', json_encode(['fname' => $fname, 'mname' => $mname, 'lname' => $lname, 'usertype' => $usertype, 'username' => $username, 'email' => $email, 'password' => $passhash, 'added_by' => $added_by, 'time' => $time])))
                {
                    echo 18;
                }
                else
                {
                    echo 19;
                }
            }
        }
        else if($_POST['request'] == 'getUsersData')
        {
            ?>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Added By</th>
                        <th>Added Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $rows = getrows('confidential', '', 'user_id > 0');
                        $result = getresult('*', 'confidential', '', 'user_id > 0', 'time', '', '');
                        while($row = mysqli_fetch_array($result))
                        {
                            if($row['user_id'] != 1)
                            {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row['fname']." ".$row['mname']." ".$row['lname']; ?></td>
                                    <td><?php echo $row['username']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo getvalue('usertype_name', 'usertype', json_encode(['usertype_id' => $row['usertype']]), ''); ?></td>
                                    <td>
                                        <?php
                                            $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                            $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                            $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                            echo $first." ".$middle." ".$last;
                                        ?>
                                    </td>
                                    <td><?php echo date("d-m-Y h:i:s A", $row['time']); ?></td>
                                    <td><i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="updateuser('<?php echo $row['user_id']; ?>', '<?php echo $row['fname']; ?>', '<?php echo $row['mname']; ?>', '<?php echo $row['lname']; ?>', '<?php echo $row['usertype']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['email']; ?>')"></i> <i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="deluser('<?php echo $row['user_id']; ?>')"></i></td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true,
                        "responsive": true,
                        "buttons": ["pdf", "print"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
            <?php
        }
        else if($_POST['request'] == 'delUser')
        {
            $uid = $_POST['userid'];
            if(getrows('confidential', json_encode(['user_id' => $uid]), '') == 1)
            {
                if(delete('confidential', json_encode(['user_id' => $uid]), ''))
                {
                    echo 0;
                }
                else
                {
                    echo 1;
                }
            }
            else
            {
                echo 2;
            }
        }
    }
?>