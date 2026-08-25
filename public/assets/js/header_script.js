let SignInCard = document.querySelector(".signin-part");
let SignUpCard = document.querySelector(".signup-part");
let SignInButton = document.querySelector("#sign-in");
let SignUpButton = document.querySelector("#sign-up");
let SignInButtonRes = document.querySelector("#sign-in-button");
let SignUpButtonRes = document.querySelector("#sign-up-button");
let beforeSignIn = document.querySelector(".before-signin");
let beforeSignUp = document.querySelector(".before-signup");
let body = document.body;
let logOutButton = document.querySelector("#log_out");
let logOutButtonRes = document.querySelector("#log_out-button");
let bars = document.querySelector("#barMenu");
// let bars = document.querySelector("#");
let responsiveCartCount = document.querySelector("#responsiveCount");

let list = document.querySelector(".listMenu");
let responsiveOverlay = document.querySelector(".Listoverlay");
let closeList = document.querySelectorAll(".closeList")

let cartCount = document.querySelector(".cartCount");

bars.addEventListener("click",function(){
    responsiveOverlay.style.display= "block";
    responsiveOverlay.style.top = window.scrollY + "px";
    list.style.display = "flex";
    const scrollY =  window.scrollY
    document.body.dataset.scrollY = scrollY;
    document.body.style.position = "fixed"
    document.body.style.top = `-${scrollY}px`;
    document.body.style.left = "0";
    document.body.style.right ="0";
    document.body.style.overflow ="hidden";
})


closeList.forEach(close =>{
    close.addEventListener("click",function(){
        list.style.display="none";
        responsiveOverlay.style.display="none";
        body.style.overflowY= "auto";

        let scrollY = parseFloat(document.body.dataset.scrollY || 0);
        document.body.style.position = ""
        document.body.style.top = "";
        document.body.style.left = "";
        document.body.style.right ="";
        document.body.style.overflow ="";

        window.scrollTo(0,scrollY);
    })
})

function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}


cartCount.textContent = getLocalStorageArticlesList().length ;
responsiveCartCount.textContent = getLocalStorageArticlesList().length ;











SignInButton.addEventListener("click",()=>{
    SignInCard.removeAttribute("hidden");
    body.style.maxHeight= "100vdh";
    body.style.overflow="hidden";
})

SignUpButton.addEventListener("click",()=>{
    SignUpCard.removeAttribute("hidden");
    body.style.maxHeight= "100vdh";
    body.style.overflow="hidden";
})

// responsive button
SignInButtonRes.addEventListener("click",(event)=>{
    event.preventDefault();
    SignInCard.removeAttribute("hidden");
    body.style.maxHeight= "100vdh";
    body.style.overflow="hidden";
    console.log("clicked");

})

SignUpButtonRes.addEventListener("click",(event)=>{
    event.preventDefault();
    SignUpCard.removeAttribute("hidden");
    body.style.maxHeight= "100vdh";
    body.style.overflow="hidden";
    console.log("clicked")
    

})
/////////////////////////

beforeSignIn.addEventListener("click",(event)=>{
    event.preventDefault();
    SignInCard.setAttribute("hidden","");
    body.style.overflow="";

})
beforeSignUp.addEventListener("click",(event)=>{
    event.preventDefault();
    SignUpCard.setAttribute("hidden","");
    body.style.overflow="";

})


// les champ  
let signUpEmail = document.querySelector("#EmailSignUp");
let signUppassword = document.querySelector("#PasswordSignUp");


// changement entre sign in et sign up
let switchSignUp = document.querySelector("#switchSignUp");
let switchSignIn = document.querySelector("#switchSignIn");
    
switchSignUp.addEventListener("click", (event)=>{
    SignInCard.setAttribute("hidden","");
    SignUpCard.removeAttribute("hidden");
    console.log(window.scrollY);
    SignUpCard.style.top = window.scrollY + "px";
    body.style.overflow = "hidden";
    body.style.maxHeight = "100dvh";
    body.style.maxWidth = "100dvw";
})

switchSignIn.addEventListener("click", (event)=>{
    SignUpCard.setAttribute("hidden","");
    SignInCard.removeAttribute("hidden");
    SignInCard.style.top = window.scrollY + "px";
    console.log(window.scrollY);
})


// partie log out + remove session
logOutButton.addEventListener("click", async function(event){
    event.preventDefault()
    let response = await fetch("/api/users/logout");
    let result = await response.json();
    if(result.success){
        window.location.href = "/main";
    }else{
        alert(result.message);
    }
})
logOutButtonRes.addEventListener("click", async function(event){
    event.preventDefault()
    let response = await fetch("/api/users/logout");
    let result = await response.json();
    if(result.success){
        window.location.href = "/main";
    }else{
        alert(result.message);
    }
})