<?php
    $db_host = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "hpwebsite";

    $con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if(!$con){
        die("connection faild". mysqli_connect_error());
    }


    function filteration($data){
        foreach ($data as $key => $value){
            $value = trim($value);
            $value = stripslashes($value);
            $value = strip_tags($value);
            $value = htmlspecialchars($value);
            $data[$key] = $value;
        }
        return $data;
    }

    function selectAll($table){
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql, $values, $datatypes){
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }else{
                mysqli_stmt_close($stmt);
                die("Query can not be excuted - select");
            }
        }else{
            die('Query can not be prepare - Select');
        }
    }

    function update($sql, $values, $datatypes){
        $con = $GLOBALS['con'];
        // $stmt = mysqli_prepare($con, $sql);
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
               $res = mysqli_stmt_affected_rows($stmt);
               mysqli_stmt_close($stmt);
               return $res;
            }else{
                mysqli_stmt_close($stmt);
                die ('updadte query not excuted - update');
            }
        }else{
            die ('updadte query can not be prepare - update');
        }
        
            

        
    }

    function insert($sql, $values, $datatypes){
        $con = $GLOBALS['con'];
        // $stmt = mysqli_prepare($con, $sql);
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
               $res = mysqli_stmt_affected_rows($stmt);
               mysqli_stmt_close($stmt);
               return $res;
            }else{
                mysqli_stmt_close($stmt);
                die ('updadte query not excuted - insert');
            }
        }else{
            die ('updadte query can not be prepare - insert');
        }  
    }

    // function delete($sql, $values, $datatypes){
    //     $con = $GLOBALS['con'];
    //     // $stmt = mysqli_prepare($con, $sql);
    //     if($stmt = mysqli_prepare($con, $sql)){
    //         mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
    //         if(mysqli_stmt_execute($stmt)){
    //            $res = mysqli_stmt_affected_rows($stmt);
    //            mysqli_stmt_close($stmt);
    //            return $res;
    //         }else{
    //             mysqli_stmt_close($stmt);
    //             die ('updadte query not excuted - delete');
    //         }
    //     }else{
    //         die ('updadte query can not be prepare - delete');
    //     }
    // }

    function del($sql, $values, $datatypes){
        $con = $GLOBALS['con'];
        // $stmt = mysqli_prepare($con, $sql);
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if(mysqli_stmt_execute($stmt)){
               $res = mysqli_stmt_affected_rows($stmt);
               mysqli_stmt_close($stmt);
               return $res;
            }else{
                mysqli_stmt_close($stmt);
                die ('updadte query not excuted - insert');
            }
        }else{
            die ('updadte query can not be prepare - insert');
        }  
    }
?>