<?php include "inc/header.php" ?>
<style>
    .pop:hover{
        border-top-color: var(--teal) !important;
        transform: scale(1.03);
        transition: all 0.3s;

    }
</style>
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
    <div class="h-line bg-dark"></div>
    <p class="mt-3 text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla deserunt quisquam, quo saepe dolores quasi vitae eligendi laboriosam consequatur reprehenderit ut recusandae, iste blanditiis non odio, dolor cumque est aut.</p>

</div>
<div class="container">
    <div class="row">
        <?php
            $res = mysqli_query($con, "SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5");
            $path = FACILITIES_IMG_PATH;
            while($row = mysqli_fetch_assoc($res)){
                echo <<< data
                    <div class="col-lg-4 col-md-6 mb-5 px-4">
                        <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                            <div class="d-flex align-items-center mb-2">
                                <img src="$path$row[icon]" width="40px">
                                <h5 class="m-0 ms-3">$row[name]</h5>
                            </div>
                            <p>$row[discription]</p>
                        </div>
                    </div>
                data;
            }
        ?>
        
    </div>
</div>
<?php include "inc/footer.php" ?>