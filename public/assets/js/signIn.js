let signInForm = document.querySelector("#signInForm");
let signIninput = document.querySelectorAll(".signin .input");
let signInlabel = document.querySelectorAll(".signin .inputLabel");

for(let i=0 ; i<signIninput.length; i++){
    let input = signIninput[i];
    input.addEventListener("blur",function(){
        let label = signInlabel[i];
        if(input.value!==""){
            label.classList.add("inputFocus")
            input.style.border="1px solid var(--blue)";
        }else{
            label.classList.remove("inputFocus");
            input.style.border="0.5px solid var(--gray-400);";
        }
    })
}


signInForm.addEventListener("submit",async function(event){

    event.preventDefault();
    const dataForm = new FormData(signInForm);
    for(const[key,value] of dataForm.entries()){
        console.log(key,value);
    }

    const response = await fetch("/api/users/signIn", {
        method : "POST",
        body: dataForm
    });

    const result = await response.json();
    if(result.success){
        if(result.data == false){
            alert("Adreese email ou mot de passe incorrect!");
        }else{
            window.location.reload();

        }
    }else{
        alert("Adreese email ou mot de passe incorrect!");
    }
})