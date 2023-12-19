<?php 
    include("inc/header.php");
    // include("inc/config.php");
   
?>
    <div class="container-fluid " id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h4 class="mb-4">Users</h4>
                <!-- feture section -->
                <div class="card border shadow mb-4 mt-2">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Users</h5>
                            <input type="text" oninput="search_users(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Search users">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width:1300px">
                                <thead class="">
                                    <tr class="bg-info text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone no</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">D.O.B.</th>
                                        <th scope="col">Verifired</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="users-data">
                                    
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
    <script src="script-js/users.js"></script>
</body>
</html>