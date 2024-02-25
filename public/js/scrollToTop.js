// Or if using vanilla JavaScript
window.addEventListener('scroll', function() {
    var scrollToTopButton = document.getElementById('scrollToTopButton');
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        scrollToTopButton.style.display = "block";
    } else {
        scrollToTopButton.style.display = "none";
    }
});

document.getElementById('scrollToTopButton').addEventListener('click', function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
});