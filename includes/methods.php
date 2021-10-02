<?php
    function insert($table, $receive)
    {
        global $conn;
        $fields = '';
        $values = '';
        $data = json_decode($receive);
        foreach($data as $key => $value)
        {
            $fields .= $key.', ';
            $values .= "'$value', ";
        }
        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        return mysqli_query($conn, $sql);
    }
    function update($table, $set, $condi, $custom)
    {
        global $conn;
        if($custom == '')
        {
            $where = json_decode($condi);
            $condition = '';
            foreach($where as $key => $value)
            {
                $condition .= "$key='$value' AND ";
            }
            $condition = substr($condition, 0, -5);
            $sql = "UPDATE $table SET $set WHERE $condition";
            return mysqli_query($conn, $sql);
        }
        else
        {
            $condition = $custom;
            $sql = "UPDATE $table SET $condition,";
            return mysqli_query($conn, $sql);
        }
    }
    function getvalue($field, $table, $condi, $custom)
    {
        global $conn;
        if($custom == '')
        {
            $where = json_decode($condi);
            $condition = '';
            foreach($where as $key => $value)
            {
                $condition .= "$key='".$value."' AND ";
            }
            $condition = substr($condition, 0, -5);
            $sql = "SELECT $field FROM $table WHERE $condition";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_array($result);
                return $row[$field];
            }
            else
            {
                return '';
            }
        }
    }
    function getresult($fields, $table, $condi, $custom, $order, $group, $lim)
    {
        global $conn;
        if($custom == '')
        {
            if($order == '')
            {
                $orderby = '';
            }
            else
            {
                $orderby = 'ORDER BY '.$order;
            }
            if($group == '')
            {
                $groupby = '';
            }
            else
            {
                $groupby = 'GROUP BY '.$group;
            }
            if($lim == '')
            {
                $limit = '';
            }
            else
            {
                $limit = 'LIMIT '.$lim;
            }
            $where = json_decode($condi);
            $condition = '';
            foreach($where as $key => $value)
            {
                $condition .= "$key='$value' AND ";
            }
            $condition = substr($condition, 0, -5);
            $sql = "SELECT $fields FROM $table WHERE $condition $orderby $groupby $limit";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
        else
        {
            if($order == '')
            {
                $orderby = '';
            }
            else
            {
                $orderby = 'ORDER BY '.$order;
            }
            if($group == '')
            {
                $groupby = '';
            }
            else
            {
                $groupby = 'GROUP BY '.$group;
            }
            if($lim == '')
            {
                $limit = '';
            }
            else
            {
                $limit = 'LIMIT '.$lim;
            }
            $condition = $custom;
            $sql = "SELECT $fields FROM $table WHERE $condition $orderby $groupby $limit";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }
    function getrows($table, $condi, $custom)
    {
        global $conn;
        if($custom == '')
        {
            $where = json_decode($condi);
            $condition = '';
            foreach($where as $key => $value)
            {
                $condition .= "$key='$value' AND ";
            }
            $condition = substr($condition, 0, -5);
            $sql = "SELECT * FROM $table WHERE $condition";
            $rows = mysqli_num_rows(mysqli_query($conn, $sql));
            return $rows;
        }
        else
        {
            $condition = $custom;
            $sql = "SELECT * FROM $table WHERE $condition";
            $rows = mysqli_num_rows(mysqli_query($conn, $sql));
            return $rows;
        }
    }
?>