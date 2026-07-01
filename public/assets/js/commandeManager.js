let trashLink = document.querySelectorAll(".commandeTrashLink");

trashLink.forEach(link => {
    link.addEventListener("click", async function(event){
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
    })
})