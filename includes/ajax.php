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
            else if(($ut != getvalue('usertype_name', 'usertype', json_encode(['usertype_id' => $utid]), '')) && (getrows('usertype', json_encode(['usertype_name' => $ut]), '') > 0))
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
                                    <td><?php echo date("d M Y h:i:s A", $row['time']); ?></td>
                                    <td>
                                        <i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="setupdate('<?php echo $row['usertype_id']; ?>', '<?php echo $row['usertype_name']; ?>')"></i> 
                                        <?php if(getrows('confidential', json_encode(['usertype' => $row['usertype_id']]), '') == 0){ ?><i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="delut('<?php echo $row['usertype_id'] ?>')"></i><?php } ?>
                                    </td>
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
                                    <td><?php echo date("d M Y h:i:s A", $row['time']); ?></td>
                                    <td>
                                        <i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="updateuser('<?php echo $row['user_id']; ?>', '<?php echo $row['fname']; ?>', '<?php echo $row['mname']; ?>', '<?php echo $row['lname']; ?>', '<?php echo $row['usertype']; ?>', '<?php echo $row['username']; ?>', '<?php echo $row['email']; ?>')"></i> 
                                        <i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="deluser('<?php echo $row['user_id']; ?>')"></i>
                                    </td>
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
        else if($_POST['request'] == 'updateCourse')
        {
            $cid = $_POST['cid'];
            $course = $_POST['course'];
            $cfee = $_POST['cfee'];
            $cexam = $_POST['cexam'];
            $cp = $_POST['cp'];
            $cremark = $_POST['cremark'];
            if(getrows('course', json_encode(['course_id' => $cid]), '') == 0)
            {
                echo 0;
            }
            else if($course == '')
            {
                echo 1;
            }
            else if(strlen($course) > 50)
            {
                echo 2;
            }
            else if(($course != getvalue('course_name', 'course', json_encode(['course_id' => $cid]), '')) && (getrows('course', json_encode(['course_name' => $course]), '') > 0))
            {
                echo 3;
            }
            else if($cfee == '' || $cexam == '')
            {
                echo 4;
            }
            else if($cfee > 9999999 || $cexam > 9999999)
            {
                echo 5;
            }
            else if($cp == '')
            {
                echo 6;
            }
            else
            {
                $co = explode("_", $cp);
                $ctype = $co[0];
                $cperiod = $co[1];
                if(update("course", "course_name='$course', course_tuition_fee='$cfee', course_exam_fee='$cexam', course_type='$ctype', course_period='$cperiod', course_remark='$cremark'", json_encode(['course_id' => $cid]), ''))
                {
                    echo 7;
                }
                else
                {
                    echo 8;
                }
            }
        }
        else if($_POST['request'] == 'delCourse')
        {
            $cid = $_POST['cid'];
            if(getrows('course', json_encode(['course_id' => $cid]), '') == 0)
            {
                echo 0;
            }
            else
            {
                if(delete('course', json_encode(['course_id' => $cid]), ''))
                {
                    echo 1;
                }
                else
                {
                    echo 2;
                }
            }
        }
        else if($_POST['request'] == 'addCourse')
        {
            $cname = $_POST['cname'];
            $cfee = $_POST['cfee'];
            $cexam = $_POST['cexam'];
            $cp = explode("_", $_POST['cp']);
            $type = $cp[0];
            $count = $cp[1];
            $cremark = $_POST['cremark'];
            if($cname == '')
            {
                echo 0;
            }
            else if(strlen($cname) > 50)
            {
                echo 1;
            }
            else if(getrows('course', json_encode(['course_name' => $cname]), '') > 0)
            {
                echo 2;
            }
            else if($cfee == '' || $cexam == '')
            {
                echo 3;
            }
            else if($cfee > 9999999 || $cexam > 9999999)
            {
                echo 4;
            }
            else
            {
                $time = time();
                $added_by = $_SESSION['user_id'];
                if(insert('course', json_encode(['course_name' => $cname, 'course_tuition_fee'=> $cfee, 'course_exam_fee'=> $cexam, 'course_type' => $type, 'course_period' => $count, 'course_remark' => $cremark, 'added_by' => $added_by, 'added_time' => $time])))
                {
                    echo 5;
                }
                else
                {
                    echo 6;
                }
            }
        }
        else if($_POST['request'] == 'showCourses')
        {
            ?>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Tuition Fees</th>
                        <th>Exam Fees</th>
                        <th>Course Period</th>
                        <th>Added By</th>
                        <th>Added Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $rows = getrows('course', '', 'course_id > 0');
                        $result = getresult('*', 'course', '', 'course_id > 0', 'added_time', '', '');
                        while($row = mysqli_fetch_array($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['course_name']; ?></td>
                                <td>₹<?php echo $row['course_tuition_fee']; ?></td>
                                <td>₹<?php echo $row['course_exam_fee']; ?></td>
                                <td>
                                    <?php
                                        $period = $row['course_period'];
                                        $ctype = $row['course_type'];
                                        $cp = $ctype."_".$period;
                                        if($ctype == 0)
                                        {
                                            echo $period;
                                            if($period == 1)
                                            {
                                                echo " Year";
                                            }
                                            else
                                            {
                                                echo " Years";
                                            }
                                        }
                                        else
                                        {
                                            echo $period;
                                            if($period == 1)
                                            {
                                                echo " Semester";
                                            }
                                            else
                                            {
                                                echo " Semesters";
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                        $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                        $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                        echo $first." ".$middle." ".$last;
                                    ?>
                                </td>
                                <td><?php echo date("d M Y h:i:s A", $row['added_time']); ?></td>
                                <td>
                                    <i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $row['course_name']; ?>', '<?php if($row['course_remark'] == ''){ echo 'No Remark'; }else{ echo $row['course_remark']; } ?>')"></i>
                                    <i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="setupdate('<?php echo $row['course_id']; ?>', '<?php echo $row['course_name']; ?>', '<?php echo $row['course_tuition_fee']; ?>', '<?php echo $row['course_exam_fee']; ?>', '<?php echo $cp; ?>', '<?php echo $row['course_remark']; ?>')"></i> 
                                    <?php if(getrows('student', json_encode(['course' => $row['course_id']]), '') == 0){ ?><i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="del('<?php echo $row['course_id'] ?>')"></i><?php } ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
            <div class="modal fade" id="course-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-head" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="example2" class="table table-bordered table-striped">
                                <tr>
                                    <th>Remark</th>
                                </tr>
                                <tr>
                                    <td id="modal-remark"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
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
        else if($_POST['request'] == 'updateStudent')
        {
            $sid = $_POST['sid'];
            $sname = $_POST['sname'];
            $f_name = $_POST['fname'];
            $m_name = $_POST['mname'];
            $dob = $_POST['dob'];
            $enroll = $_POST['enroll'];
            $roll = $_POST['roll'];
            $email = $_POST['email'];
            $mob1 = str_replace("_", "",$_POST['mob1']);
            $mob2 = str_replace("_", "",$_POST['mob2']);
            $add1 = $_POST['add1'];
            $add2 = $_POST['add2'];
            $add3 = $_POST['add3'];
            if(getrows('student', json_encode(['student_id' => $sid]), '') == 0)
            {
                echo 0;
            }
            else if($sname == '')
            {
                echo 1;
            }
            else if(strlen($sname) > 50)
            {
                echo 2;
            }
            else if($f_name == '')
            {
                echo 3;
            }
            else if(strlen($f_name) > 50)
            {
                echo 4;
            }
            else if($m_name == '')
            {
                echo 5;
            }
            else if(strlen($m_name) > 50)
            {
                echo 6;
            }
            else if($dob == '')
            {
                echo 7;
            }
            else if(($enroll != getvalue('enroll', 'student', json_encode(['student_id' => $sid]), '')) && ($enroll != '') && (getrows('student', json_encode(['enroll' => $enroll]), '') > 0))
            {
                echo 8;
            }
            else if(($roll != getvalue('roll', 'student', json_encode(['student_id' => $sid]), '')) && ($roll != '') && (getrows('student', json_encode(['roll' => $roll]), '') > 0))
            {
                echo 9;
            }
            else if(($email != '') && (strlen($email) < 5))
            {
                echo 10;
            }
            else if(($email != '') && (strlen($email) > 50))
            {
                echo 11;
            }
            else if(($email != '') && (!filter_var($email, FILTER_VALIDATE_EMAIL)))
            {
                echo 12;
            }
            else if(($mob1 != '') && (strlen($mob1) != 10))
            {
                echo 13;
            }
            else if(($mob2 != '') && (strlen($mob2) != 10))
            {
                echo 14;
            }
            else
            {
                $cdob = strtotime($dob);
                if(update("student", "student_name='$sname', f_name='$f_name', m_name='$m_name', dob='$cdob', enroll='$enroll', roll='$roll', student_email='$email', student_mob1='$mob1', student_mob2='$mob2', student_add1='$add1', student_add2='$add2', student_add3='$add3'", json_encode(['student_id' => $sid]), ''))
                {
                    echo 15;
                }
                else
                {
                    echo 16;
                }
            }
        }
        else if($_POST['request'] == 'addStudent')
        {
            $sname = $_POST['sname'];
            $f_name = $_POST['fname'];
            $m_name = $_POST['mname'];
            $dob = $_POST['dob'];
            $course = $_POST['course'];
            $eyear = $_POST['eyear'];
            $enroll = $_POST['enroll'];
            $roll = $_POST['roll'];
            $email = $_POST['email'];
            $mob1 = str_replace("_", "",$_POST['mob1']);
            $mob2 = str_replace("_", "",$_POST['mob2']);
            $add1 = $_POST['add1'];
            $add2 = $_POST['add2'];
            $add3 = $_POST['add3'];
            if($sname == '')
            {
                echo 0;
            }
            else if(strlen($sname) > 50)
            {
                echo 1;
            }
            else if($f_name == '')
            {
                echo 2;
            }
            else if(strlen($f_name) > 50)
            {
                echo 3;
            }
            else if($m_name == '')
            {
                echo 4;
            }
            else if(strlen($m_name) > 50)
            {
                echo 5;
            }
            else if($dob == '')
            {
                echo 6;
            }
            else if($course == '')
            {
                echo 7;
            }
            else if(getrows('course', json_encode(['course_id' => $course]), '') != 1)
            {
                echo 8;
            }
            else if($eyear == '')
            {
                echo 9;
            }
            else if($eyear < 2010)
            {
                echo 10;
            }
            else if($eyear > date('Y', time()))
            {
                echo 11;
            }
            else if(($enroll != '') && (getrows('student', json_encode(['enroll' => $enroll]), '') > 0))
            {
                echo 12;
            }
            else if(($roll != '') && (getrows('student', json_encode(['roll' => $roll]), '') > 0))
            {
                echo 13;
            }
            else if(($email != '') && (strlen($email) < 5))
            {
                echo 14;
            }
            else if(($email != '') && (strlen($email) > 50))
            {
                echo 15;
            }
            else if(($email != '') && (!filter_var($email, FILTER_VALIDATE_EMAIL)))
            {
                echo 16;
            }
            else if(($mob1 != '') && (strlen($mob1) != 10))
            {
                echo 17;
            }
            else if(($mob2 != '') && (strlen($mob2) != 10))
            {
                echo 18;
            }
            else
            {
                $cdob = strtotime($dob);
                $course_tuition_fee = getvalue('course_tuition_fee', 'course', json_encode(['course_id' => $course]), '');
                $course_exam_fee = getvalue('course_exam_fee', 'course', json_encode(['course_id' => $course]), '');
                $course_type = getvalue('course_type', 'course', json_encode(['course_id' => $course]), '');
                $course_period = getvalue('course_period', 'course', json_encode(['course_id' => $course]), '');
                $time = time();
                $added_by = $_SESSION['user_id'];
                if(insert('student', json_encode(['student_name' => $sname, 'f_name'=> $f_name, 'm_name' => $m_name, 'dob' => $cdob, 'course' => $course, 'enroll_year' => $eyear, 'course_tuition_fee' => $course_tuition_fee, 'course_exam_fee' => $course_exam_fee, 'course_type' => $course_type, 'course_period' => $course_period, 'enroll' => $enroll, 'roll' => $roll, 'student_email' => $email, 'student_mob1' => $mob1, 'student_mob2' => $mob2, 'student_add1' => $add1, 'student_add2' => $add2, 'student_add3' => $add3,'added_by' => $added_by, 'added_time' => $time])))
                {
                    echo 19;
                }
                else
                {
                    echo 20;
                }
            }
        }
        else if($_POST['request'] == 'delStu')
        {
            $sid = $_POST['sid'];
            if(getrows('student', json_encode(['student_id' => $sid]), '') == 0)
            {
                echo 0;
            }
            else
            {
                if(delete('student', json_encode(['student_id' => $sid]), ''))
                {
                    echo 1;
                }
                else
                {
                    echo 2;
                }
            }
        }
        else if($_POST['request'] == 'getStudentsData')
        {
            ?>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Father's Name</th>
                        <th>Date of Birth</th>
                        <th>Course</th>
                        <th>Enrollment Number</th>
                        <th>Roll Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $rows = getrows('student', '', 'student_id > 0');
                        $result = getresult('*', 'student', '', 'student_id > 0', 'added_time', '', '');
                        while($row = mysqli_fetch_array($result))
                        {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['f_name']; ?></td>
                                <td><?php echo date("d M Y", $row['dob']); ?></td>
                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?></td>
                                <td><?php echo $row['enroll']; ?></td>
                                <td><?php echo $row['roll']; ?></td>
                                <td>
                                    <?php
                                        $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                        $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                        $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                        $added_by = $first." ".$middle." ".$last;
                                        $added_time = date("d M Y h:i:s A", $row['added_time']);
                                    ?>
                                    <i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $row['student_id']; ?>', '<?php echo $row['student_name']; ?>', '<?php echo $row['f_name']; ?>', '<?php echo $row['m_name']; ?>', '<?php echo date('d M Y', $row['dob']); ?>', '<?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?>', '<?php echo $row['enroll_year']; ?>', '<?php echo $row['enroll']; ?>', '<?php echo $row['roll']; ?>', '<?php echo $row['student_email']; ?>', '<?php echo $row['student_mob1']; ?>', '<?php echo $row['student_mob2']; ?>', '<?php echo $row['student_add1']; ?>', '<?php echo $row['student_add2']; ?>', '<?php echo $row['student_add3']; ?>', '<?php echo $added_by; ?>', '<?php echo $added_time; ?>')"></i> 
                                    <i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="setupdate('<?php echo $row['student_id']; ?>', '<?php echo $row['student_name']; ?>', '<?php echo $row['f_name']; ?>', '<?php echo $row['m_name']; ?>', '<?php echo date('Y-m-d', $row['dob']); ?>', '<?php echo $row['enroll']; ?>', '<?php echo $row['roll']; ?>', '<?php echo $row['student_email']; ?>', '<?php echo $row['student_mob1']; ?>', '<?php echo $row['student_mob2']; ?>', '<?php echo $row['student_add1']; ?>', '<?php echo $row['student_add2']; ?>', '<?php echo $row['student_add3']; ?>')"></i> 
                                    <?php if(getrows('invoice_content', json_encode(['student_id' => $row['student_id']]), '') == 0){ ?><i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="delut('<?php echo $row['student_id'] ?>')"></i><?php } ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
            <div class="modal fade" id="student-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-head" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th>Student Name</th>
                                    <td id="modal-sname"></td>
                                </tr>
                                <tr>
                                    <th>Father's Name</th>
                                    <td id="modal-fname"></td>
                                </tr>
                                <tr>
                                    <th>Mother's Name</th>
                                    <td id="modal-mname"></td>
                                </tr>
                                <tr>
                                    <th>Date of Birth</th>
                                    <td id="modal-dob"></td>
                                </tr>
                                <tr>
                                    <th>Course Enrolled</th>
                                    <td id="modal-course"></td>
                                </tr>
                                <tr>
                                    <th>Enrollment Year</th>
                                    <td id="modal-eyear"></td>
                                </tr>
                                <tr>
                                    <th>Enrollment Number</th>
                                    <td id="modal-enroll"></td>
                                </tr>
                                <tr>
                                    <th>Roll Number</th>
                                    <td id="modal-roll"></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="modal-email"></td>
                                </tr>
                                <tr>
                                    <th>Primary Contact Number</th>
                                    <td id="modal-mob1"></td>
                                </tr>
                                <tr>
                                    <th>Secondary Contact Number</th>
                                    <td id="modal-mob2"></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td id="modal-address"></td>
                                </tr>
                                <tr>
                                    <th>Enrolled By</th>
                                    <td id="modal-added_by"></td>
                                </tr>
                                <tr>
                                    <th>Enrolled Time</th>
                                    <td id="modal-added_time"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <a id="modal-receipt" href="" target="_blank"><button type="button" class="btn btn-primary">Payment Details</button></a>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "responsive": true,
                        "buttons": ["pdf", "print"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
            <?php
        }
        else if($_POST['request'] == 'headStatus')
        {
            $ihead = $_POST['ihead'];
            $sid = $_POST['sid'];
            if($ihead == '')
            {
                echo 0;
            }
            else if($ihead == 100 || $ihead == 101 || $ihead == 102 || $ihead == 103 || $ihead == 104 || $ihead == 105 || $ihead == 106 || $ihead == 107)
            {
                echo 1;
            }
            else if($ihead == 200)
            {
                echo 2;
            }
            else
            {
                $ctype = getvalue('course_type', 'student', json_encode(['student_id' => $sid]), '');
                $cperiod = getvalue('course_period', 'student', json_encode(['student_id' => $sid]), '');
                $sy = $ihead;
                for($i = 1; $i <= $cperiod; $i++)
                {
                    if($sy == $i)
                    {
                        echo 3;
                    }
                }
                if($sy > $cperiod)
                {
                    echo 4;
                }
                // else
                // {
                //     echo 5;
                // }
            }
        }
        else if($_POST['request'] == 'updatePayment')
        {
            $icid = $_POST['icid'];
            $sid = $_POST['sid'];
            $ihead = $_POST['ihead'];
            $idesc = $_POST['idesc'];
            $amount = $_POST['amount'];
            $itax = $_POST['itax'];
            $remark = $_POST['remark'];
            $subt = sprintf('%.2f', ((($amount * $itax)/100) + $amount));
            if($icid == '')
            {
                echo 0;
            }
            else if(getrows('invoice_content', json_encode(['invoice_content_id' => $icid]), '') != 1)
            {
                echo 1;
            }
            else if($ihead == '')
            {
                echo 2;
            }
            else if($idesc == '')
            {
                echo 3;
            }
            else if(getrows('invoice_content', '', "head='$ihead' AND dsc='$idesc' AND dsc!='Exam Fee (Backlog)' AND student_id='$sid' AND invoice_content_id != '$icid'") > 0)
            {
                echo 4;
            }
            else if($amount == '')
            {
                echo 5;
            }
            else if($itax == '')
            {
                echo 6;
            }
            else
            {
                if(update("invoice_content", "head='$ihead', dsc='$idesc', amount='$amount', tax='$itax', subt='$subt', remark='$remark'", json_encode(['invoice_content_id' => $icid]), ''))
                {
                    echo 7;
                }
                else
                {
                    echo 8;
                }
            }
        }
        else if($_POST['request'] == 'addPayment')
        {
            $sid = $_POST['sid'];
            $ihead = $_POST['ihead'];
            $idesc = $_POST['idesc'];
            $amount = $_POST['amount'];
            $itax = $_POST['itax'];
            $remark = $_POST['remark'];
            $subt = sprintf('%.2f', ((($amount * $itax)/100) + $amount));
            if($sid == '')
            {
                echo 0;
            }
            else if(getrows('student', json_encode(['student_id' => $sid]), '') != 1)
            {
                echo 1;
            }
            else if($ihead == '')
            {
                echo 2;
            }
            else if($idesc == '')
            {
                echo 3;
            }
            else if(getrows('invoice_content', '', "head='$ihead' AND dsc='$idesc' AND dsc!='Exam Fee (Backlog)' AND student_id='$sid'") > 0)
            {
                echo 4;
            }
            else if($amount == '')
            {
                echo 5;
            }
            else if($itax == '')
            {
                echo 6;
            }
            else
            {
                $time = time();
                $added_by = $_SESSION['user_id'];
                if(insert('invoice_content', json_encode(['student_id' => $sid, 'head'=> $ihead, 'dsc' => $idesc, 'amount' => $amount, 'tax' => $itax, 'subt' => $subt, 'remark' => $remark, 'added_by' => $added_by, 'added_time' => $time])))
                {
                    echo 7;
                }
                else
                {
                    echo 8;
                }
            }
        }
        else if($_POST['request'] == 'delPay')
        {
            $icid = $_POST['icid'];
            if(getrows('invoice_content', json_encode(['invoice_content_id' => $icid]), '') == 0)
            {
                echo 0;
            }
            else
            {
                if(delete('invoice_content', json_encode(['invoice_content_id' => $icid]), ''))
                {
                    echo 1;
                }
                else
                {
                    echo 2;
                }
            }
        }
        else if($_POST['request'] == 'getPaymentDetails')
        {
            $sid = $_POST['sid'];
            ?>
            <div class="row">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Payment Head</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>GST Rate</th>
                                <th>Subtotal</th>
                                <th>Added by</th>
                                <th>Added Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                $rows = getrows("invoice_content", "", "(invoice_id is NULL || invoice_id = '') AND student_id='$sid'");
                                $result = getresult("*", "invoice_content", "", "(invoice_id is NULL || invoice_id = '') AND student_id='$sid'", 'added_time', '', '');
                                while($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php
                                                $h = $row['head'];
                                                if($h == 100)
                                                {
                                                    echo "Caution Money";
                                                }
                                                else if($h == 101)
                                                {
                                                    echo "Development Fee";
                                                }
                                                else if($h == 102)
                                                {
                                                    echo "ID Card Fee";
                                                }
                                                else if($h == 103)
                                                {
                                                    echo "Laboratory Fee";
                                                }
                                                else if($h == 104)
                                                {
                                                    echo "Library Fee";
                                                }
                                                else if($h == 105)
                                                {
                                                    echo "Training & Placement";
                                                }
                                                else if($h == 106)
                                                {
                                                    echo "Late Fee";
                                                }
                                                else if($h == 107)
                                                {
                                                    echo "Fee Concession";
                                                }
                                                else if($h == 200)
                                                {
                                                    echo "Other";
                                                }
                                                else
                                                {
                                                    $sid = $row['student_id'];
                                                    $ctype = getvalue('course_type', 'student', json_encode(['student_id' => $sid]), '');
                                                    $cperiod = getvalue('course_period', 'student', json_encode(['student_id' => $sid]), '');
                                                    if($ctype == 0)
                                                    {
                                                        $set = '';
                                                        for($a = 1; $a <= $cperiod; $a++)
                                                        {
                                                            if($a == $h)
                                                            {
                                                                $set = $h;
                                                            }
                                                        }
                                                        if(isset($set) && $set != '')
                                                        {
                                                            echo "Year ".$set;
                                                        }
                                                        else
                                                        {
                                                            echo "Unknown";
                                                        }
                                                    }
                                                    else if($ctype == 1)
                                                    {
                                                        $set = '';
                                                        for($a = 1; $a <= $cperiod; $a++)
                                                        {
                                                            if($a == $h)
                                                            {
                                                                $set = $h;
                                                            }
                                                        }
                                                        if(isset($set) && $set != '')
                                                        {
                                                            echo "Semester ".$set;
                                                        }
                                                        else
                                                        {
                                                            echo "Unknown";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo "Unknown";
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $row['dsc']; ?></td>
                                        <td>₹<?php echo sprintf('%.2f', $row['amount']); ?></td>
                                        <td><?php echo $row['tax']; ?>%</td>
                                        <td>₹<?php echo sprintf('%.2f', $row['subt']); ?></td>
                                        <td>
                                            <?php
                                                $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                $added_by = $first." ".$middle." ".$last;
                                                echo $added_by;
                                            ?>
                                        </td>
                                        <td><?php echo date("d M Y h:i:s A", $row['added_time']); ?></td>
                                        <td>
                                            <?php
                                                if($row['remark'] == '')
                                                {
                                                    $remark = "No Remark!";
                                                }
                                                else
                                                {
                                                    $remark = $row['remark'];
                                                }
                                            ?>
                                            <i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $row['dsc']; ?>', '<?php echo $remark; ?>')"></i>
                                            <i class="fas fa-edit text-primary" style="cursor: pointer;" onclick="setupdate('<?php echo $row['invoice_content_id']; ?>', '<?php echo $row['head']; ?>', '<?php echo $row['dsc']; ?>', '<?php echo $row['amount']; ?>', '<?php echo $row['tax']; ?>', '<?php echo $row['subt']; ?>', '<?php echo $row['remark']; ?>', '<?php if($row['dsc'] == 'Tuition Fee'){ echo 1; }else{ echo 0; } ?>')"></i> 
                                            <i class="fas fa-trash text-danger" style="cursor: pointer;" onclick="delut('<?php echo $row['invoice_content_id'] ?>')"></i>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="idate">Invoice Date:</label>
                        <input type="date" id="idate" class="form-control" placeholder="Enter Invoice Date" value="<?php echo date('Y-m-d', time()); ?>">
                    </div>
                </div>
                <div class="offset-md-6 col-md-3" style="align-self: end;">
                    <div class="form-group">
                        <input type="button" value="Generate Invoice" id="addInvoice" class="btn btn-success btn-block" onclick="addin()">
                    </div>
                </div>
            </div>
            <div class="modal fade" id="student-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="modal-head" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <tr>
                                    <th>Payment Remark</th>
                                </tr>
                                <tr>
                                    <td id="modal-remark"></td>
                                </tr>
                                <tr>
                            </table>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": false,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": false,
                        "info": false,
                        "autoWidth": true,
                        "responsive": true
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
            <?php
        }
        else if($_POST['request'] == 'addIn')
        {
            $time = time();
            $added_by = $_SESSION['user_id'];
            $sid = $_POST['sid'];
            $idate = $_POST['idate'];
            if($idate == '')
            {
                echo 0;
            }
            else
            {
                $newdate = strtotime($idate);
                if(insert('invoice', json_encode(['invoice_date' => $newdate, 'added_by' => $added_by, 'added_time' => $time])))
                {
                    $lastid = lastinsert();
                    $inv = "MAT/".date('Y', $time)."/".$lastid;
                    if(update("invoice", "invoice_no='$inv'", json_encode(['invoice_id' => $lastid]), ""))
                    {
                        if(update("invoice_content", "invoice_id='$lastid'", "", "(invoice_id='' OR invoice_id IS NULL) AND student_id='$sid'"))
                        {
                            echo 1;
                        }
                        else
                        {
                            if(delete('invoice', json_encode(['invoice_id' => $lastid]), ''))
                            {
                                echo 2;
                            }
                            else
                            {
                                echo 3;
                            }
                        }
                    }
                    else
                    {
                        echo 4;
                    }
                    
                }
                else
                {
                    echo 5;
                }
            }
        }
        else if($_POST['request'] == 'getAllInvoices')
        {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice Number</th>
                                <th>Invoice Date</th>
                                <th>Added By</th>
                                <th>Added Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                $result = getresult('*', 'invoice', '', 'invoice_id > 0', 'invoice_id DESC', '', '');
                                while($row = mysqli_fetch_array($result))
                                {
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><a href="../single-invoice/?id=<?php echo $row['invoice_id']; ?>" target="_blank"><?php echo $row['invoice_no']; ?></a></td>
                                        <td><?php echo date('d M Y', $row['invoice_date']); ?></td>
                                        <td>
                                            <?php
                                                $uid = $row['added_by'];
                                                $fname = getvalue('fname', 'confidential', json_encode(['user_id' => $uid]), '');
                                                $mname = getvalue('mname', 'confidential', json_encode(['user_id' => $uid]), '');
                                                $lname = getvalue('lname', 'confidential', json_encode(['user_id' => $uid]), '');
                                                echo $fname." ".$mname." ".$lname;
                                            ?>
                                        </td>
                                        <td><?php echo date('d M Y h:i:s a', $row['added_time']); ?></td>
                                        <td><a href="../single-invoice/?id=<?php echo $row['invoice_id']; ?>" target="_blank" style="color: black;"><i class="fas fa-eye" style="cursor: pointer;"></i></a></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "responsive": true
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                });
            </script>
            <?php
        }
        else if($_POST['request'] == 'advstusearch')
        {
            $course = $_POST['course'];
            $enroll = $_POST['enroll'];
            $roll = $_POST['roll'];
            $eyear = $_POST['eyear'];
            $name = $_POST['name'];
            $fname = $_POST['fname'];
            $mname = $_POST['mname'];
            $dob = $_POST['dob'];
            $email = $_POST['email'];
            $mob = $_POST['mob'];
            if($course == '' && $enroll == '' && $roll == '' && $eyear == '' && $name == '' && $fname == '' && $mname == '' && $dob == '' && $email == '' && $mob == '')
            {
                ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">Advanced Search Result</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Father's Name</th>
                                            <th>Date of Birth</th>
                                            <th>Course</th>
                                            <th>Enrollment Number</th>
                                            <th>Roll Number</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $i = 1;
                                            $result = getresult('*', 'student', '', 'student_id > 0', '', '', '');
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['student_name']; ?></td>
                                                    <td><?php echo $row['f_name']; ?></td>
                                                    <td><?php echo date("d M Y", $row['dob']); ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?></td>
                                                    <td><?php echo $row['enroll']; ?></td>
                                                    <td><?php echo $row['roll']; ?></td>
                                                    <td>
                                                        <?php
                                                            $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                            $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                            $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                            $added_by = $first." ".$middle." ".$last;
                                                            $added_time = date("d M Y h:i:s A", $row['added_time']);
                                                        ?>
                                                        <i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $row['student_id']; ?>', '<?php echo $row['student_name']; ?>', '<?php echo $row['f_name']; ?>', '<?php echo $row['m_name']; ?>', '<?php echo date('d M Y', $row['dob']); ?>', '<?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?>', '<?php echo $row['enroll_year']; ?>', '<?php echo $row['enroll']; ?>', '<?php echo $row['roll']; ?>', '<?php echo $row['student_email']; ?>', '<?php echo $row['student_mob1']; ?>', '<?php echo $row['student_mob2']; ?>', '<?php echo $row['student_add1']; ?>', '<?php echo $row['student_add2']; ?>', '<?php echo $row['student_add3']; ?>', '<?php echo $added_by; ?>', '<?php echo $added_time; ?>')"></i>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="student-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 id="modal-head" class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <tr>
                                                <th>Student Name</th>
                                                <td id="modal-sname"></td>
                                            </tr>
                                            <tr>
                                                <th>Father's Name</th>
                                                <td id="modal-fname"></td>
                                            </tr>
                                            <tr>
                                                <th>Mother's Name</th>
                                                <td id="modal-mname"></td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td id="modal-dob"></td>
                                            </tr>
                                            <tr>
                                                <th>Course Enrolled</th>
                                                <td id="modal-course"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrollment Year</th>
                                                <td id="modal-eyear"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrollment Number</th>
                                                <td id="modal-enroll"></td>
                                            </tr>
                                            <tr>
                                                <th>Roll Number</th>
                                                <td id="modal-roll"></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td id="modal-email"></td>
                                            </tr>
                                            <tr>
                                                <th>Primary Contact Number</th>
                                                <td id="modal-mob1"></td>
                                            </tr>
                                            <tr>
                                                <th>Secondary Contact Number</th>
                                                <td id="modal-mob2"></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td id="modal-address"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrolled By</th>
                                                <td id="modal-added_by"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrolled Time</th>
                                                <td id="modal-added_time"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <a id="modal-receipt" href="" target="_blank"><button type="button" class="btn btn-primary">Payment Details</button></a>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <script>
                            $(function () {
                                $("#example1").DataTable({
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true,
                                    "responsive": true,
                                    "buttons": ["pdf", "print"]
                                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });
                        </script>
                    </div>
                </div>
                <?php
            }
            else
            {
                $i = 1;
                $where = "";
                if($course != "")
                {
                    $where .= "course='$course' AND ";
                }
                if($enroll != "")
                {
                    $where .= "enroll='$enroll' AND ";
                }
                if($roll != "")
                {
                    $where .= "roll='$roll' AND ";
                }
                if($eyear != "")
                {
                    $where .= "enroll_year='$eyear' AND ";
                }
                if($name != "")
                {
                    $where .= "student_name='$name' AND ";
                }
                if($fname != "")
                {
                    $where .= "f_name='$fname' AND ";
                }
                if($dob != "")
                {
                    $cdob = strtotime($dob);
                    $where .= "dob='$cdob' AND ";
                }
                if($email != "")
                {
                    $where .= "student_email='$email' AND ";
                }
                if($mob != "")
                {
                    $where .= "(student_mob1='$mob' OR student_mob2='$mob') AND ";
                }
                $where = substr($where, 0, -5);
                $result = getresult('*', 'student', '', $where, '', '', '');
                ?>
                <div class="card card-primary card-outline">
                    <div class="card-header">Advanced Search Result</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Father's Name</th>
                                            <th>Date of Birth</th>
                                            <th>Course</th>
                                            <th>Enrollment Number</th>
                                            <th>Roll Number</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($row = mysqli_fetch_array($result))
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $row['student_name']; ?></td>
                                                    <td><?php echo $row['f_name']; ?></td>
                                                    <td><?php echo date("d M Y", $row['dob']); ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?></td>
                                                    <td><?php echo $row['enroll']; ?></td>
                                                    <td><?php echo $row['roll']; ?></td>
                                                    <td>
                                                        <?php
                                                            $first = getvalue('fname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                            $middle = getvalue('mname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                            $last = getvalue('lname', 'confidential', json_encode(['user_id' => $row['added_by']]), '');
                                                            $added_by = $first." ".$middle." ".$last;
                                                            $added_time = date("d M Y h:i:s A", $row['added_time']);
                                                        ?>
                                                        <i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $row['student_id']; ?>', '<?php echo $row['student_name']; ?>', '<?php echo $row['f_name']; ?>', '<?php echo $row['m_name']; ?>', '<?php echo date('d M Y', $row['dob']); ?>', '<?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?>', '<?php echo $row['enroll_year']; ?>', '<?php echo $row['enroll']; ?>', '<?php echo $row['roll']; ?>', '<?php echo $row['student_email']; ?>', '<?php echo $row['student_mob1']; ?>', '<?php echo $row['student_mob2']; ?>', '<?php echo $row['student_add1']; ?>', '<?php echo $row['student_add2']; ?>', '<?php echo $row['student_add3']; ?>', '<?php echo $added_by; ?>', '<?php echo $added_time; ?>')"></i>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal fade" id="student-modal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 id="modal-head" class="modal-title"></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <tr>
                                                <th>Student Name</th>
                                                <td id="modal-sname"></td>
                                            </tr>
                                            <tr>
                                                <th>Father's Name</th>
                                                <td id="modal-fname"></td>
                                            </tr>
                                            <tr>
                                                <th>Mother's Name</th>
                                                <td id="modal-mname"></td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth</th>
                                                <td id="modal-dob"></td>
                                            </tr>
                                            <tr>
                                                <th>Course Enrolled</th>
                                                <td id="modal-course"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrollment Year</th>
                                                <td id="modal-eyear"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrollment Number</th>
                                                <td id="modal-enroll"></td>
                                            </tr>
                                            <tr>
                                                <th>Roll Number</th>
                                                <td id="modal-roll"></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td id="modal-email"></td>
                                            </tr>
                                            <tr>
                                                <th>Primary Contact Number</th>
                                                <td id="modal-mob1"></td>
                                            </tr>
                                            <tr>
                                                <th>Secondary Contact Number</th>
                                                <td id="modal-mob2"></td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td id="modal-address"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrolled By</th>
                                                <td id="modal-added_by"></td>
                                            </tr>
                                            <tr>
                                                <th>Enrolled Time</th>
                                                <td id="modal-added_time"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <a id="modal-receipt" href="" target="_blank"><button type="button" class="btn btn-primary">Payment Details</button></a>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <script>
                            $(function () {
                                $("#example1").DataTable({
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true,
                                    "responsive": true,
                                    "buttons": ["pdf", "print"]
                                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });
                        </script>
                    </div>
                </div>
                <?php
            }
        }
        else if($_POST['request'] == 'pendingFees')
        {
            ?>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Total Tuition Fees</th>
                        <th>Paid Tuition Fees</th>
                        <th>Total Exam Fees</th>
                        <th>Paid Exam Fees</th>
                        <th>Total Fees Paid</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = getresult('*', 'student', '', 'student_id > 0', 'course', '', '');
                    $i = 1;
                    while($row = mysqli_fetch_array($result))
                    {
                        $sid = $row['student_id'];
                        $tuition = $row['course'];
                        $collected = 0;
                        $exam_fees = 0;
                        $total = 0;
                        $result1 = getresult("*", "invoice_content", "", "student_id='$sid' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL", "", "", "");
                        while($row1 = mysqli_fetch_array($result1))
                        {
                            $collected += $row1['amount'];
                        }
                        $result2 = getresult("*", "invoice_content", "", "student_id='$sid' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL", "", "", "");
                        while($row2 = mysqli_fetch_array($result2))
                        {
                            $exam_fees += $row2['amount'];
                        }
                        $result3 = getresult("*", "invoice_content", "", "student_id='$sid' AND invoice_id IS NOT NULL", "", "", "");
                        while($row3 = mysqli_fetch_array($result3))
                        {
                            $total += $row3['amount'];
                        }
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row['student_name']; ?></td>
                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?></td>
                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $row['course_tuition_fee']); ?></td>
                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $collected); ?></td>
                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $row['course_exam_fee']); ?></td>
                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $exam_fees); ?></td>
                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $total); ?></td>
                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $row['student_name']; ?>')"></i></td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <div class="modal fade" id="status-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div id="moverlay" style="display: none !important;" class="overlay d-flex justify-content-center align-items-center">
                            <i class="fas fa-2x fa-sync fa-spin"></i>
                        </div>
                        <div class="modal-header">
                            <h4 id="modal-head" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="modal-content" class="modal-body"></div>
                        <div class="modal-footer justify-content-between">
                            <a id="modal-receipt" href="#" target="_blank"><button type="button" class="btn btn-primary">Payment Details</button></a>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": false,
                        "lengthChange": false,
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
        else if($_POST['request'] == 'searchPStatus')
        {
            $course = $_POST['course'];
            $period = $_POST['period'];
            $eyear = $_POST['eyear'];
            $ft = $_POST['ft'];
            $ps = $_POST['ps'];
            $str = '';
            if($course != '')
            {
                $str .= "course='$course' AND ";
            }
            if($eyear != '')
            {
                $str .= "enroll_year='$eyear' AND ";
            }
            if($str != '')
            {
                $str = substr($str, 0, -5);
            }
            else
            {
                $str = 'student_id > 0';
            }
            ?>
            <table id="example1" class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Total Tuition Fees</th>
                        <th>Paid Tuition Fees</th>
                        <th>Total Exam Fees</th>
                        <th>Paid Exam Fees</th>
                        <th>Total Fees Paid</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $result = getresult('*', 'student', '', $str, '', '', '');
                        while($row = mysqli_fetch_array($result))
                        {
                            $sid = $row['student_id'];
                            $ttfee = $row['course_tuition_fee'];
                            $tefee = $row['course_exam_fee'];
                            $cp = $row['course_period'];
                            $course = $row['course'];
                            $sname = $row['student_name'];
                            if($ttfee != 0)
                            {
                                $etfee = $ttfee/$cp;
                            }
                            else
                            {
                                $etfee = 0;
                            }
                            if($tefee != 0)
                            {
                                $eefee = $tefee/$cp;
                            }
                            else
                            {
                                $eefee = 0;
                            }
                            $tfeepaid = 0;
                            $texampaid = 0;
                            $tpaid = 0;
                            $result1 = getresult("*", "invoice_content", "", "student_id='$sid' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL", "", "", "");
                            while($row1 = mysqli_fetch_array($result1))
                            {
                                $tfeepaid += $row1['amount'];
                            }
                            $result2 = getresult("*", "invoice_content", "", "student_id='$sid' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL", "", "", "");
                            while($row2 = mysqli_fetch_array($result2))
                            {
                                $texampaid += $row2['amount'];
                            }
                            $result3 = getresult("*", "invoice_content", "", "student_id='$sid' AND invoice_id IS NOT NULL", "", "", "");
                            while($row3 = mysqli_fetch_array($result3))
                            {
                                $tpaid += $row3['amount'];
                            }
                            if($ps == '')
                            {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $sname; ?></td>
                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                </tr>
                                <?php
                                $i++;
                            }
                            else if($ps == 0)
                            {
                                if($period == '' && $ft == 0)
                                {
                                    if(getrows("invoice_content", "", "student_id='$sid' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL") == 0)
                                    {
                                        if($ttfee != 0)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row['student_name']; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $row['course']]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                }
                                else if($period == '' && $ft == 1)
                                {
                                    if(getrows("invoice_content", "", "student_id='$sid' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL") == 0)
                                    {
                                        if($tefee != 0)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sname; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                }
                                else if($period != '' && $ft == '')
                                {
                                    if(getrows("invoice_content", "", "student_id='$sid' AND head='$period' AND invoice_id IS NOT NULL") == 0)
                                    {
                                        if($ttfee != 0 && $tefee != 0)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sname; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                }
                                else if($period != '' && $ft == 0)
                                {
                                    if(getrows("invoice_content", "", "student_id='$sid' AND head='$period' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL") == 0)
                                    {
                                        if($ttfee != 0)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sname; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    else
                                    {
                                        if($ttfee != 0)
                                        {
                                            $tuitionfee = 0;
                                            $result4 = getresult("*", "invoice_content", "", "student_id='$sid' AND head='$period' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL", "", "", "");
                                            while($row4 = mysqli_fetch_array($result4))
                                            {
                                                $tuitionfee += $row4['amount'];
                                            }
                                            if($tuitionfee < $etfee)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $sname; ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                    }
                                }
                                else if($period != '' && $ft == 1)
                                {
                                    if(getrows("invoice_content", "", "student_id='$sid' AND head='$period' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL") == 0)
                                    {
                                        if($tefee != 0)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sname; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    else
                                    {
                                        if($ttfee != 0)
                                        {
                                            $tuitionfee = 0;
                                            $result4 = getresult("*", "invoice_content", "", "student_id='$sid' AND head='$period' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL", "", "", "");
                                            while($row4 = mysqli_fetch_array($result4))
                                            {
                                                $tuitionfee += $row4['amount'];
                                            }
                                            if($tuitionfee < $eefee)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $sname; ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if(getrows("invoice_content", "", "student_id='$sid' AND invoice_id IS NOT NULL") == 0)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
                            else if($ps == 1)
                            {
                                if($period == '' && $ft == 0)
                                {
                                    if($ttfee == $tfeepaid)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                else if($period == '' && $ft == 1)
                                {
                                    if($tefee == $texampaid)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                else if($period != '' && $ft == '')
                                {
                                    $result4 = getresult("*", "invoice_content", "", "student_id='$sid' AND head='$period' AND invoice_id IS NOT NULL", "", "", "");
                                    if(mysqli_num_rows($result4) > 0)
                                    {
                                        if($ttfee != 0 && $tefee != 0)
                                        {
                                            $tuitionfee = 0;
                                            $examfee = 0;
                                            while($row = mysqli_fetch_array($result4))
                                            {
                                                if($row['dsc'] == 'Tuition Fee')
                                                {
                                                    $tuitionfee += $row['amount'];
                                                }
                                                else if($row['dsc'] == 'Exam Fee (Regular)')
                                                {
                                                    $examfee += $row['amount'];
                                                }
                                            }
                                            if($etfee <= $tuitionfee && $eefee <= $examfee)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $sname; ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        else if($ttfee != 0 && $tefee == 0)
                                        {
                                            $tuitionfee = 0;
                                            $examfee = 0;
                                            while($row = mysqli_fetch_array($result4))
                                            {
                                                if($row['dsc'] == 'Tuition Fee')
                                                {
                                                    $tuitionfee += $row['amount'];
                                                }
                                            }
                                            if($etfee <= $tuitionfee && $tefee <= $examfee)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $sname; ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        else if($ttfee == 0 && $tefee != 0)
                                        {
                                            $tuitionfee = 0;
                                            $examfee = 0;
                                            while($row = mysqli_fetch_array($result4))
                                            {
                                                if($row['dsc'] == 'Exam Fee (Regular)')
                                                {
                                                    $examfee += $row['amount'];
                                                }
                                            }
                                            if($ttfee <= $tuitionfee && $eefee <= $examfee)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $sname; ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        else if($ttfee == 0 && $tefee == 0)
                                        {
                                            $tuitionfee = 0;
                                            $examfee = 0;
                                            if($ttfee <= $tuitionfee && $tefee <= $examfee)
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $sname; ?></td>
                                                    <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                    <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                    <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                    }
                                    else if($ttfee == 0 && $tefee == 0)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                else if($period != '' && $ft == 0)
                                {
                                    $result4 = getresult("*", "invoice_content", "", "student_id='$sid' AND head='$period' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL", "", "", "");
                                    if(mysqli_num_rows($result4) > 0)
                                    {
                                        $tuitionfee = 0;
                                        while($row4 = mysqli_fetch_array($result4))
                                        {
                                            $tuitionfee += $row4['amount'];
                                        }
                                        if($tuitionfee >= $etfee)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sname; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    else if($ttfee == 0)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                else if($period != '' && $ft == 1)
                                {
                                    $result4 = getresult("*", "invoice_content", "", "student_id='$sid' AND head='$period' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL", "", "", "");
                                    if(mysqli_num_rows($result4) > 0)
                                    {
                                        $examfee = 0;
                                        while($row4 = mysqli_fetch_array($result4))
                                        {
                                            $examfee += $row4['amount'];
                                        }
                                        if($examfee >= $eefee)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $sname; ?></td>
                                                <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                                <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                                <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    else if($tefee == 0)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                else
                                {
                                    if($ttfee <= $tfeepaid && $tefee <= $texampaid)
                                    {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $sname; ?></td>
                                            <td><?php echo getvalue('course_name', 'course', json_encode(['course_id' => $course]), ''); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $ttfee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tfeepaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tefee); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $texampaid); ?></td>
                                            <td style="text-align: right;">₹<?php echo sprintf('%.2f', $tpaid); ?></td>
                                            <td><i class="fas fa-eye" style="cursor: pointer;" onclick="showModal('<?php echo $sid; ?>', '<?php echo $sname; ?>')"></i></td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
            <div class="modal fade" id="status-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div id="moverlay" style="display: none !important;" class="overlay d-flex justify-content-center align-items-center">
                            <i class="fas fa-2x fa-sync fa-spin"></i>
                        </div>
                        <div class="modal-header">
                            <h4 id="modal-head" class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="modal-content" class="modal-body"></div>
                        <div class="modal-footer justify-content-between">
                            <a id="modal-receipt" href="#" target="_blank"><button type="button" class="btn btn-primary">Payment Details</button></a>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <script>
                $(function () {
                    $("#example1").DataTable({
                        "paging": false,
                        "lengthChange": false,
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
        else if($_POST['request'] == 'statusModal')
        {
            $sid = $_POST['sid'];
            $ttfee = getvalue('course_tuition_fee', 'student', json_encode(['student_id' => $sid]), '');
            $tefee = getvalue('course_exam_fee', 'student', json_encode(['student_id' => $sid]), '');
            $ctype = getvalue('course_type', 'student', json_encode(['student_id' => $sid]), '');
            if($ctype == 0)
            {
                $ctname = 'Year';
            }
            else
            {
                $ctname = 'Semester';
            }
            $cp = getvalue('course_period', 'student', json_encode(['student_id' => $sid]), '');
            $etfee = $ttfee/$cp;
            $eefee = $tefee/$cp;
            ?>
            <table class="table table-bordered table-striped table-hover">
                <tr>
                    <th>#</th>
                    <th><?php echo $ctname; ?></th>
                    <th>Tuition Fees</th>
                    <th>Exam Fees</th>
                </tr>
                <?php
                    for($i = 1; $i <= $cp; $i++)
                    {
                        ?>
                        <tr>
                            <th><?php echo $i; ?></th>
                            <th><?php echo $ctname." ".$i; ?></th>
                            <th>
                                <?php
                                    if($ttfee == 0)
                                    {
                                        ?>
                                        <span class="badge bg-success">Paid</span>
                                        <?php
                                    }
                                    else
                                    {
                                        $tuition = getrows("invoice_content", "", "student_id='$sid' AND head='$i' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL");
                                        if($tuition == 0)
                                        {
                                            ?>
                                            <span class="badge bg-danger">Due</span>
                                            <?php
                                        }
                                        else
                                        {
                                            $feepaid = getvalue("amount", "invoice_content", "", "student_id='$sid' AND head='$i' AND dsc='Tuition Fee' AND invoice_id IS NOT NULL");
                                            if($feepaid == $etfee)
                                            {
                                                ?>
                                                <span class="badge bg-success">Paid</span>
                                                <?php
                                            }
                                            else if($feepaid == 0)
                                            {
                                                ?>
                                                <span class="badge bg-danger">Due</span>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <span class="badge bg-warning">Partially Paid</span>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </th>
                            <th>
                                <?php
                                    if($tefee == 0)
                                    {
                                        ?>
                                        <span class="badge bg-success">Paid</span>
                                        <?php
                                    }
                                    else
                                    {
                                        $exam = getrows("invoice_content", "", "student_id='$sid' AND head='$i' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL");
                                        if($exam == 0)
                                        {
                                            ?>
                                            <span class="badge bg-danger">Due</span>
                                            <?php
                                        }
                                        else
                                        {
                                            $feepaid = getvalue("amount", "invoice_content", "", "student_id='$sid' AND head='$i' AND dsc='Exam Fee (Regular)' AND invoice_id IS NOT NULL");
                                            if($feepaid == $eefee)
                                            {
                                                ?>
                                                <span class="badge bg-success">Paid</span>
                                                <?php
                                            }
                                            else if($feepaid == 0)
                                            {
                                                ?>
                                                <span class="badge bg-danger">Due</span>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <span class="badge bg-warning">Partially Paid</span>
                                                <?php
                                            }
                                        }
                                    }
                                ?>
                            </th>
                        </tr>
                        <?php
                    }
                ?>
            </table>
            <?php
        }
        else if($_POST['request'] == 'statusGetCp')
        {
            $course = $_POST['course'];
            $ctype = getvalue("course_type", "course", json_encode(['course_id' => $course]), "");
            $cperiod = getvalue("course_period", "course", json_encode(['course_id' => $course]), "");
            if($ctype == 0)
            {
                $system = "Year";
            }
            else
            {
                $system = "Semester";
            }
            ?>
            <option value="">--All--</option>
            <?php
            for($i = 1; $i <= $cperiod; $i++)
            {
                ?>
                <option value="<?php echo $i; ?>"><?php echo $system." ".$i; ?></option>
                <?php
            }
        }
    }
?>