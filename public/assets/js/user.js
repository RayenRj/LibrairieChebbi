let addAdminList = document.querySelectorAll(".addAdmin");
let deleteClient = document.querySelectorAll(".deleteClient");

addAdminList.forEach(button =>{
    button.addEventListener("click", async function(event){
        event.preventDefault();
        if(confirm("Est Ce que Tu Veux Réellement Ajouter Cette Utilisateur Comme Admin ? ")){
            var idClient = event.target.dataset.idclient;
            let response = await fetch(`/api/users/addAdmin/${idClient}`,{
                method: "PATCH",
                body: {}
            });
            let result = await response.json();
            if(!(result.success && result.data)){
                alert(result.message);
            }
        }
    })
})


deleteClient.forEach(button =>{
    button.addEventListener("click", async function(event){
        event.preventDefault();
        if(confirm(`Est Ce Que Tu Veux Réellement Supprimer Cette Utilisateur ? `)){
            var idClient = event.target.dataset.idclient;
            let response = await fetch(`/api/users/deleteClient/${idClient}`,{
                method: "DELETE",
                body: {}
            });
            let result = await response.json();
            if(result.success && result.data){
                window.location.reload()
            }else{
                alert(result.message);
            }
        }
    })
<<<<<<< HEAD
=======
})


/// partie search 
let form = document.querySelector("#userForm");
form.addEventListener("submit",function(event){
    event.preventDefault();
    let data = document.querySelector("#data").value.toLowerCase();
    let critere = document.querySelector("#criteres");

    window.location.search = `${critere}=${data}`;
>>>>>>> 0f9756d5dbf91bc0b9ba4de46df3d1ac2a245825
})