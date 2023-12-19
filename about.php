<?php include "inc/header.php" ?>
<style>
    .box {
        border-top-color: var(--teal)!important;
    }
</style>
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">ABOUT US</h2>
    <div class="h-line bg-dark"></div>
    <p class="mt-4 text-center">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla deserunt quisquam, quo saepe dolores quasi vitae eligendi laboriosam consequatur reprehenderit ut recusandae, iste blanditiis non odio, dolor cumque est aut.</p>

</div>
<div class="container">
    <div class="row d-flex justify-content-between align-items-center">
        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
            <h3 class="mb-3">Lorem ipsum dolor sit.</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Rerum enim autem inventore!</p>
        </div>
        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-1 order-1">
            <img src="images/about/about.jpg" alt="" class="w-100">
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/hotel.svg" alt="" width="70px">
                <H6 class="mt-3">200+ ROOMS</H6>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/staff.svg" alt="" width="70px">
                <H6 class="mt-3">200+ STAFF</H6>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/rating.svg" alt="" width="70px">
                <H6 class="mt-3">150+ REVIEW</H6>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4 px-4">
            <div class="bg-white rounded shadow p-4 border-top border-4 text-center box">
                <img src="images/about/customers.svg" alt="" width="70px">
                <H6 class="mt-3">100+ COSTOMERS</H6>
            </div>
        </div>
    </div>
</div>
<H4 class="fw-bold h-font text-center my-5">MANAGEMENT TEAM</H4>
<div class="container px-4">
    <div class="swiper myswiper">
        <div class="swiper-wrapper mb-5">
            <?php
                $about_r = selectAll('team_detail');
                $path = ABOUT_IMG_PATH;
                foreach($about_r as $row){
                    echo <<<data
                        <div class="swiper-slide bg-white text-center overflow-hidden rounded py-2">
                            <img src="$path$row[picture]" class="w-100">
                            <h5 class="mt-2">$row[name]</h5>
                        </div>
                    data;
                }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
<?php include "inc/footer.php" ?>
<script>
    var swiper = new Swiper(".myswiper",{
        slidesPerView :4,
        spaceBerween : 40,
        pagination: {
            el : ".swiper-pagination",
        },
        breakpoints : {
        320 : {
            slidesPerView :1
        },
        640 : {
            slidesPerView :1
        },
        768 : {
            slidesPerView :3
        },
        1024 : {
            slidesPerView :3
        },
    },
    })
</script>