let signInForm = document.querySelector("#signInForm");
let signIninput = document.querySelectorAll(".signin .input");
let signInlabel = document.querySelectorAll(".signin .inputLabel");



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
// =========================================================================
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


    const response = await fetch("/api/users/signIn", {
        method : "POST",
        body: dataForm
    });

    const result = await response.json();
    if(result.success){
        if(result.data == null){window.location.href = result.redirect;}
        else{window.location.reload();}
    }else{
        // lahnee win famma mochkla <<<<<<<<<<<<<<<<<<<<<<<<<<<
        document.querySelector(".errorMessage").innerHTML = result.message
        signIninput.forEach(input=>{
            input.style.borderColor="red";
        })
        signInlabel.forEach(label=>{
            label.style.color="red";
        })
        triggerError();
    }
})





