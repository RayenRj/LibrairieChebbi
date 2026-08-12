let SignInCard = document.querySelector(".signin-part");
let SignUpCard = document.querySelector(".signup-part");
let SignInButton = document.querySelector("#sign-in");
let SignUpButton = document.querySelector("#sign-up");
let beforeSignIn = document.querySelector(".before-signin");
let beforeSignUp = document.querySelector(".before-signup");
let body = document.body;
let logOutButton = document.querySelector("#log_out");
let bars = document.querySelector("#barMenu");
// let bars = document.querySelector("#");

let list = document.querySelector(".listMenu");
let responsiveOverlay = document.querySelector(".Listoverlay");
let closeList = document.querySelectorAll(".closeList")

let cartCount = document.querySelector(".cartCount");

bars.addEventListener("click",function(){
    list.style.display = "flex";
    responsiveOverlay.style.display= "block";

})


closeList.forEach(close =>{
    close.addEventListener("click",function(){
        list.style.display="none";
        responsiveOverlay.style.display="none";
    })
})

function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}


cartCount.textContent = getLocalStorageArticlesList().length ;











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

beforeSignIn.addEventListener("click",()=>{
    SignInCard.setAttribute("hidden","");
    body.style.overflow="";

})
beforeSignUp.addEventListener("click",()=>{
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
})

switchSignIn.addEventListener("click", (event)=>{
    SignUpCard.setAttribute("hidden","");
    SignInCard.removeAttribute("hidden");
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