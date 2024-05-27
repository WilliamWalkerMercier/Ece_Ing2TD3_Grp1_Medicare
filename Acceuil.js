document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        document.getElementById("intro").style.display = "none";
        document.getElementById("main").style.display = "block";
        document.body.style.overflow = "auto";
    }, 3000);

    let i = 1;
    const totalimage = 5;
    const interval = 3000;

    function showNextItem() {
        i++;
        if (i>totalimage) {
            i=1;
        }
        document.getElementById(`c${i}`).checked = true;
    }
    setInterval(showNextItem, interval);
});

