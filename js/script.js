let hambars = document.querySelector("#hambars_icon");
let xmark = document.querySelector(".xmark");
let mobileManue = document.querySelector(".mobileManue");

let cursor = document.querySelector(".cursor");
window.addEventListener("mousemove", (event)=>{
    
    gsap.to(cursor, {
        display: "block",
        x: event.pageX - 4,
        y: event.pageY -4,
        duration: 0.3
    });
})

window.addEventListener("wheel", (event)=>{
    if(event.deltaY > 0){
        gsap.to(".marquee_box img",{
            rotate: 0,
            duration: 1,
        });
        gsap.to(".marquee_box",{
            x: "-50%",
            repeat:-1,
            duration: 5,
            ease:"linear"
        });
    }else{
        gsap.to(".marquee_box img",{
            rotate: 180,
            duration: 1,
        });
        gsap.to(".marquee_box",{
            x: "50%",
            repeat:-1,
            duration: 5,
            ease:"linear"
        });
    }
})

let tl = gsap.timeline();

tl.from("#brandName", {
    opacity: 0,
    y: -20,
    duration: 0.4,
    delay: 0.1
});

gsap.from(hambars,{
    opacity: 0,
    y: -20,
    duration: 0.4,
    delay: 0.4
})

tl.from(".desktopManue li", {
    opacity: 0,
    y: -20,
    duration: 0.4,
    stagger: 0.2
});


gsap.from(".binner_header .leftText", {
    y: 50,
    rotateY: 200,
    duration: 0.4,
    delay: 0.7,
    stagger:0.2,
});

gsap.from(".binner_header .rightText", {
    y: 50,
    rotateY: 200,
    duration: 0.4,
    delay: 0.7,
    stagger:-0.2,
});



let tl2 = gsap.timeline();

tl2.to(hambars,{
    opacity: 0,
    duration: 0.1,
    delay: 0.01
});

tl2.to(".mobileManue", {
    right: 0,
    duration: 0.6
});

tl2.from(".mobileManue li",{
    x:80,
    opacity:0,
    duration:0.5,
    stagger:0.2
})

tl2.from(".xmark",{
    opacity: 0,
    duration: 0.1
});
tl2.pause();

hambars.addEventListener("click", ()=>{
    tl2.play();
});

xmark.addEventListener("click", ()=>{
    tl2.reverse();
});

























