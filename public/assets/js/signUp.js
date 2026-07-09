let signUpButton = document.querySelector("#signUpButton");
let fname = document.querySelector("#firstName").value;
let lname = document.querySelector("#lastName").value;
let email = document.querySelector("#EmailSignUp").value;
let password = document.querySelector("#PasswordSignUp").value;
let tel = document.querySelector("#tel").value;
let form = document.querySelector("#signUpForm");

let signUpinput = document.querySelectorAll(".signup .input");
let signUplabel = document.querySelectorAll(".signup .inputLabel");
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
    console.log(result);
    if(result.success){
        window.location.reload();
    }

})