
let formTest = document.querySelector("#formToSend");
formTest.addEventListener("submit",async function(event){
    event.preventDefault();
    let formData = new FormData(formTest);
    let callApi = await fetch("/api/users/message/send",{
        method: "POST",
        body: formData
    });
    
    formTest.querySelectorAll("input").forEach(input =>{
        input.value="";
    })
    formTest.querySelector("textarea").value="" ;
})