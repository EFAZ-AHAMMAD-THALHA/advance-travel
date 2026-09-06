var slideIndex = 1;

document.addEventListener("DOMContentLoaded", function() {
    var x = document.getElementsByClassName("mySlides");
    if (x && x.length > 0) {
        showDivs(slideIndex);
    }
});

function plusDivs(n) {
    showDivs(slideIndex += n);
}

function showDivs(n) {
    var i;
    var x = document.getElementsByClassName("mySlides");
    if (!x || x.length === 0) return;
    if (n > x.length) { slideIndex = 1; }
    if (n < 1) { slideIndex = x.length; }
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    if (x[slideIndex - 1]) {
        x[slideIndex - 1].style.display = "block";
    }
}
