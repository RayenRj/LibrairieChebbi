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
})