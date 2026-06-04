let close = document.querySelector(".dismiss.button");
let popup = document.querySelector("div.popup");
let confimerCommandeButton = document.querySelector(".btn-confirmation");
console.log(popup);

close.addEventListener("click",()=>{popup.setAttribute("hidden","");
    document.body.style.overflowY="scroll";
})
confimerCommandeButton.addEventListener("click",()=>{
    popup.removeAttribute("hidden");
    document.body.style.overflowY="hidden";
})