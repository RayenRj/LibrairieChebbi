let SignInCard = document.querySelector(".signin-part");
let SignUpCard = document.querySelector(".signup-part");
let SignInButton = document.querySelector("#sign-in");
let SignUpButton = document.querySelector("#sign-up");
let beforeSignIn = document.querySelector(".before-signin");
let beforeSignUp = document.querySelector(".before-signup");
let body = document.body;
console.log(body);
SignInButton.addEventListener("click",()=>{
    SignInCard.removeAttribute("hidden");
    body.style.maxHeight= "100dh";
})

SignUpButton.addEventListener("click",()=>{
    SignUpCard.removeAttribute("hidden");
    body.style.maxHeight= "100vdh";
})

beforeSignIn.addEventListener("click",()=>{
    SignInCard.setAttribute("hidden","");
})
beforeSignUp.addEventListener("click",()=>{
    SignUpCard.setAttribute("hidden","");
})



