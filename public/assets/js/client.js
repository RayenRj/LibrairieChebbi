let articleList = document.querySelectorAll(".thirdCard label");
let deconnexion = document.querySelector(".logOut");
let saveButton = document.querySelector(".saveModification");
let clientForm = document.querySelector("#clientForm");
let passwordShow = document.querySelector(".passwordIcon");
let passwordInput = document.querySelector("#passwordInput");

articleList.forEach(label=>{
    label.addEventListener("click", (event)=>{
        label.classList.toggle("clicked")
        let arrowContainer = label.querySelector(".arrowContainer");
        if(label.classList.contains("clicked")){
            arrowContainer.innerHTML=`<i class="fa-solid fa-angle-down"></i>`
        }else{
            arrowContainer.innerHTML = `<i class="fa-solid fa-angle-right"></i>`
            passwordSh
        }
    })
})

deconnexion.addEventListener("click",async function(event){
    event.preventDefault()
    let response = await fetch("/api/users/logout");
    let result = await response.json();
    if(result.success){
        window.location.href = "/main";
    }else{
        alert(result.message);
    }

})

// partie modification des donée du client
saveButton.addEventListener("click", async function(event){
    event.preventDefault();
    let formData = new FormData(clientForm);
    formData.set("idClient",saveButton.dataset.idclient);
    let response = await fetch("/api/users/update",{
        method:"POST",
        body: formData
    })
    let result = await response.json();
    if(result.success){window.location.reload();}
    else{alert("Probleme lors de la mise a jour du donnée client!!");}
})

// boutton show password
passwordShow.addEventListener("click",function(event){
    event.preventDefault();
    let type = passwordInput.getAttribute("type");
    
    if(type=="text"){
        passwordInput.setAttribute("type","password");
        passwordShow.innerHTML=`<i class="fa-solid fa-eye"></i>`
    }else{
        passwordInput.setAttribute("type","text");
        passwordShow.innerHTML = `<i class="fa-solid fa-eye-slash"></i>`;
    }
})