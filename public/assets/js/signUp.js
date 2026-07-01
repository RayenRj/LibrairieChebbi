let signUpButton = document.querySelector("#signUpButton");
let fname = document.querySelector("#firstName").value;
let lname = document.querySelector("#lastName").value;
let email = document.querySelector("#EmailSignUp").value;
let password = document.querySelector("#PasswordSignUp").value;
let tel = document.querySelector("#tel").value;
let form = document.querySelector("#signUpForm");



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