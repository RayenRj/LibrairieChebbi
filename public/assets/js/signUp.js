let signUpButton = document.querySelector("#signUpButton");
let fname = document.querySelector("#firstName").value;
let lname = document.querySelector("#lastName").value;
let email = document.querySelector("#EmailSignUp").value;
let password = document.querySelector("#PasswordSignUp").value;
let tel = document.querySelector("#tel").value;
let form = document.querySelector("#signUpForm");

// signUpButton.addEventListener("click",function(event){
//     event.preventDefault();
//     let text = "1234567890+"
//     for(let i =0 ; i < tel.length; i++){
//         if(text.indexOf(tel.charAt(i))!=-1){
//             alert("Numero de telephone est invalide!!");
//             return false;
//         }  
//     }
//     formData = new FormData()

// })


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