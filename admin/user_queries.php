<?php 
    include("inc/header.php");
    // include("inc/config.php");
    if(isset($_GET['seen'])){
        $frm_data = filteration($_GET);
        if($frm_data['seen'] == 'all'){
            $q = "UPDATE `user_queries` SET `seen`=?";
            $values = [1,];
            if(update($q, $values, 'i')){
                alert('success', 'Mark all as read');
            }else{
                alert('error', 'Opration faild');
            }
            // $_GET['seen']="";
        }else{
            $q = "UPDATE `user_queries` SET `seen`=?   WHERE `sr_no`=?";
            $values = [1, $frm_data['seen']];
            if(update($q, $values, 'ii')){
                alert('success', 'Mark as read');
            }else{
                alert('error', 'Opration faild');
            }
        }
    }
    if(isset($_GET['del'])){
        $frm_data = filteration($_GET);
        if($frm_data['del'] == 'all'){
            $q = "DELETE FROM `user_queries`";
            if(mysqli_query($con, $q)){
                alert('success', 'Data Deleted');
            }else{
                alert('error', 'Opration faild');
            }
            // $_GET['del']="";
        }else{
            $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if(del($q, $values, 'i')){
                alert('success', 'Data Deleted');
            }else{
                alert('error', 'Opration faild');
            }
        }
    }
?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">User queries</h4>
                <!-- Carousel section -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <a href="?seen=all" class="btn btn-success shadow-none">Mark all read</a>
                            <a href="?del=all" class="btn btn-danger shadow-none">Delete all </a>
                        </div>
                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll">
                            <table class="table table-hover border">
                                <thead class="">
                                    <tr class="bg-info text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col" width = 20%>Subject</th>
                                        <th scope="col" width = 30%>Message</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT * FROM user_queries ORDER BY `sr_no` DESC";
                                        $data = mysqli_query($con, $q);
                                        $i = 0;
                                        
                                        while($row = mysqli_fetch_assoc($data)){
                                            $i++;
                                            $seen = "";
                                            $date = date('m-y-d', strtotime($row['datetime']));
                                            if($row['seen'] != 1){
                                                $seen = "<a href='?seen=$row[sr_no]' class = 'btn btn-sm btn-primary'>Mark as read</a>";
                                            }
                                            $seen.= "<a href='?del=$row[sr_no]' class = 'btn btn-sm btn-danger mt-2'>Delete</a>";
                                            echo <<<data
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$date</td>
                                                    <td>$seen</td>
                                                </tr>
                                            data;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include("inc/script.php"); ?>
    <?php include("inc/footer.php"); ?> 
</body>
</html>