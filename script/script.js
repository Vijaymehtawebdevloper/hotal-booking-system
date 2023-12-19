// <!-- Initialize Swiper -->

var swiper = new Swiper(".slider-container", {
    slidesPerView: 1,
    grabCursor: true,
    spaceBetween: 30,
    effect: "fade",
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false
    },
});
//  testimonials  Swiper
var swiper = new Swiper(".SwiperTestimonial", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    // slidesPerView: "auto",
    slidesPerView: "4",
    loop: true,
    coverflowEffect: {
        rotate: 50,
        stretch: 1,
        depth: 100,
        modifier: 1,
        slideShadows: false,
    },
    pagination: {
        el: ".swiper-pagination",
    },
    breakpoints: {
        320: {
            slidesPerView: 1
        },
        640: {
            slidesPerView: 1
        },
        768: {
            slidesPerView: 2
        },
        1024: {
            slidesPerView: 2
        },
    },

});

function setActive() {
    let navbar = document.getElementById("nav-bar");
    let a_tags = navbar.getElementsByTagName("a");
    for (i = 0; i < a_tags.length; i++) {
        let file = a_tags[i].href.split('/').pop();
        let file_name = file.split('.')[0];
        if (document.location.href.indexOf(file_name) >= 0) {
            a_tags[i].classList.add('active');
        }
    }


}
setActive();