
document.addEventListener("DOMContentLoaded", function() {
    setTimeout(function() {
        document.getElementById("intro").style.display = "none";
        document.body.style.overflow = "auto";
    }, 3000);

    let i = 1;
    const totalimage = 5;
    const interval = 3000;
    function Carrousel() {
        i++;
        if (i>totalimage) {
            i=1;
        }
        document.getElementById(`c${i}`).checked = true;
    }
    setInterval(Carrousel, interval);

    const fond1=document.querySelector('.fond1')
    const fond2=document.querySelector('.fond2')
    const fond3=document.querySelector('.fond3')
    const fond5=document.querySelector('.fond5')
    const fond6=document.querySelector('.fond6')
    const titre=document.querySelector('.titre')
    const titre2=document.querySelector('.titre2')
    const titre3=document.querySelector('.titre3')
    document.addEventListener('scroll',function (){
        let position=window.scrollY
        titre.style.marginTop=position*1.1+'px'
        fond5.style.marginLeft=-position+'px'
        fond6.style.marginLeft=position+'px'
        fond3.style.marginBottom=-position+'px'
        fond2.style.marginBottom=-position*1.2+'px'
        fond1.style.marginBottom=-position*1.3+'px'
        titre2.style.marginTop=-position*0.1+'px'
        titre3.style.marginTop=-position*0.05+'px'
    })
});

