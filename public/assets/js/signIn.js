let signInForm = document.querySelector("#signInForm");


signInForm.addEventListener("submit",async function(event){

    event.preventDefault();
    const dataForm = new FormData(signInForm);
    for(const[key,value] in dataForm.entries()){
        console.log(key,value);
    }

    const response = await fetch("/api/users/signIn", {
        method : "POST",
        body: dataForm
    });
    const result = await response.json();
    console.log(result);
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