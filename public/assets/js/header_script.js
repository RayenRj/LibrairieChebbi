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


// les champ  
let signUpEmail = document.querySelector("#EmailSignUp");
let signUppassword = document.querySelector("#PasswordSignUp");


// changement entre sign in et sign up
let switchSignUp = document.querySelector("#switchSignUp");
let switchSignIn = document.querySelector("#switchSignIn");

console.log(switchSignUp);
switchSignUp.addEventListener("click", (event)=>{
    SignInCard.setAttribute("hidden","");
    SignUpCard.removeAttribute("hidden");
})

switchSignIn.addEventListener("click", (event)=>{
    SignUpCard.setAttribute("hidden","");
    SignInCard.removeAttribute("hidden");
})
