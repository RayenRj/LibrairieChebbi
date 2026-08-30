let signUpButton = document.querySelector("#signUpButton");
let fname = document.querySelector("#firstName").value;
let lname = document.querySelector("#lastName").value;
let email = document.querySelector("#EmailSignUp").value;
let password = document.querySelector("#PasswordSignUp").value;
let tel = document.querySelector("#tel").value;
let form = document.querySelector("#signUpForm");

let signUpinput = document.querySelectorAll(".signup .input");
let signUplabel = document.querySelectorAll(".signup .inputLabel");



// =========================== ERROR CARD ==================================
  var timeoutId;

  function triggerError(){
    const card = document.getElementById('errorCard');
    clearTimeout(timeoutId);
    card.classList.add('show');
    timeoutId = setTimeout(hideError, 4000);
  }

  function hideError(){
    document.getElementById('errorCard').classList.remove('show');
  }

// ====================================================================
for(let i=0 ; i<signUpinput.length; i++){
    let input = signUpinput[i];
    input.addEventListener("blur",function(){
        let label = signUplabel[i];
        if(input.value!==""){
            label.classList.add("inputFocus")
            input.style.border="1px solid var(--blue)";
        }else{
            label.classList.remove("inputFocus");
            input.style.border="0.5px solid var(--gray-400);";
        }
    })
}


form.addEventListener("submit",async function(event){
    event.preventDefault();
    const formData = new FormData(form);

    const response = await fetch("/api/users/createUser",{
        method: "POST",
        body : formData
    });

    const result = await response.json();
    if(result.success){
        window.location.href = result.redirect;
    }else{
        document.querySelector(".errorMessage").innerHTML = result.message
        triggerError();
    }

})






