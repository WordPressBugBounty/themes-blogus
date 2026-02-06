/* =================================
===        PRELOADER       ====
=================================== */
const preloaderElementExists = document.querySelector('.preloader') !== null;
    if (preloaderElementExists) {
    var loader = document.getElementById('preloader');
    window.addEventListener("load", function(){
            loader.style.display= "none";
        }
    )
}