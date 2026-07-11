let trashLink = document.querySelectorAll(".commandeTrashLink");
let checkLink = document.querySelectorAll(".check");
let livreeLink = document.querySelectorAll(".truck");
let printButton = document.querySelectorAll(".print");
let annuleeButton = document.querySelectorAll(".croit-rouge")

trashLink.forEach(link => {
    link.addEventListener("click", async function(event){
        if(confirm("Cette action supprimera définitivement cette commande. Souhaitez-vous continuer ?")){
            event.preventDefault();
            // dataset = object yetsna3lk ml les attribut ta3 el element 3la chart el attribut yabda esmou : data-nomAttribut
            const idCommande = event.currentTarget.dataset.id;
            
            const response = await fetch(`/api/commandes/${idCommande}`,{
                method : "DELETE",
                body : {}
            })
            console.log("idCommande : ",idCommande);
            const result = await response.json();
            if(result.success && result.data){
                window.location.reload();
            }else{
                alert(result.message);
            }
        }
    })
})


checkLink.forEach(link => {
    link.addEventListener("click" , async function(event){
        event.preventDefault();
        idCommande = event.currentTarget.dataset.id;

        const response = await fetch(`/api/commandes/confirme/${idCommande}`,{
            method: "PATCH" , 
            body: {}
        });

        const result = await response.json();
        if(result.success && result.data){
            window.location.reload();
        }else{
            alert(result.message);
        }
    })
})


let commandeSearch = document.querySelector("#commandeSearch");
commandeSearch.addEventListener("submit",async function(event){
    event.preventDefault();
    let formData = new FormData(commandeSearch);
    let str = "";
    for(const[key,value] of formData){
        if(value && value !== ""){
            str += `${key}=${value}&`;
        }
    }
    if(str!=""){
        str = str.slice(0,-1);
        console.log(str);
    }

    window.location.href= `/dashboard/commandes?${str}#commandeTable`;


})


livreeLink.forEach(button => {
    button.addEventListener("click",async function(event){
        event.preventDefault();
        let idCommande= button.dataset.id;
        console.log(idCommande);
        let result = await fetch(`/api/commandes/livre/${idCommande}`,{
            method:"PATCH",
            body:{}
        });
        let response = await result.json();

        if(response.success && response.data){
            window.location.reload();
        }else{
            alert(response.message);
        }
    })
});



annuleeButton.forEach(button => {
    button.addEventListener("click",async function(event){
        if(confirm("Confirmez-vous l'annulation de cette commande ?")){
            event.preventDefault();
            let idCommande= button.dataset.id;
            let result = await fetch(`/api/commandes/annule/${idCommande}`,{
                method:"PATCH",
                body:{}
            });
            let response = await result.json();
            if(response.success && response.data){window.location.reload();}
            else{alert(response.message);}
        }
    })
});