let trashLink = document.querySelectorAll(".commandeTrashLink");
let checkLink = document.querySelectorAll(".check");
let livreeLink = document.querySelectorAll(".truck");
let printButton = document.querySelectorAll(".print");
let annuleeButton = document.querySelectorAll(".croit-rouge")
let showCommandeButton = document.querySelectorAll(".eye")
let bonLivraisonContainer = document.querySelector(".bonLivraisonContainer")
let overlay = document.querySelector(".commandeContainerOverlay")
let commandeContainer = document.querySelector(".commandeContainer")

const mois = [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre"
        ];



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
    }

    window.location.href= `/dashboard/commandes?${str}#commandeTable`;


})


livreeLink.forEach(button => {
    button.addEventListener("click",async function(event){
        event.preventDefault();
        let idCommande= button.dataset.id;
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





//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
////////// partie ki t printi el bon de livraison ////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////
//////////////////////////////////////////////////////


printButton.forEach(button =>{
    button.addEventListener("click", async function(event){
        event.preventDefault()

        // chercher les données de la commande
        let idCommande = button.dataset.id
        let response = await fetch("/api/commandes/" + idCommande)
        let result = await response.json()
        let commande = result.data // toutes les données sur cette commande
        // chercher les données du client
        let idClient = commande["id_client"]
        let response2 = await fetch("/api/users/user/"+idClient)
        let result2 = await response2.json()
        let client = result2.data // le client qui a passé cette commande


        // chercher les donnés des articles de commande
        let response3 = await fetch(`/api/commandes/${idCommande}/articles`);
        let result3 = await response3.json();
        let articlesDeLaCommande = result3.data

        const dateCommande = new Date()
        let numCommande = "#CMD-" + commande["id_commande"];
        let date = `${String(dateCommande.getDate()).padStart(2,"0")} ${mois[dateCommande.getMonth()]} ${String(dateCommande.getFullYear())}`
        let totalPayer = parseFloat(commande["prix_totale"]) + 7


        let headerLabel = document.querySelector(".bonLivraisonContainer .header-label .text-right")
        let total = document.querySelector(".bonLivraisonContainer .total-section span")
        let tableBody = document.querySelector(".bonLivraisonContainer table tbody")
        let clientBoxAdresse = document.querySelector(".address-box.client p")
        tableBody.innerHTML=""
        var html= ""





        // filling data
        tableBody.innerHTML = html
        // fill : totale à payer
        total.innerHTML = totalPayer.toFixed(3)
        // fill : num commande + date
        headerLabel.innerHTML = `   <strong>N° de Commande :</strong> ${numCommande}<br>
                                    <strong>Date :</strong> ${date}`;
        // fill : table des articles
        for(let i =0 ; i<articlesDeLaCommande.length;i++){
            let article = articlesDeLaCommande[i]
            html += `   <tr>
                            <td>${article["libelle"]}</td>
                            <td class="text-center">${article["quantite"]}</td>
                            <td class="text-right">${parseFloat((article["prix"])).toFixed(3)} TND</td>
                            <td class="text-right">${parseFloat(article["sous_total"]).toFixed(3)} TND</td>
                        </tr>`
        }
        tableBody.innerHTML = html
        //fill : adrese client
        let boxContent = `          
                    <strong>${client["nom"]} ${client["prenom"]}</strong><br>
                    ${commande["adresse"]}<br>
                    ${commande["ville"]}, Tunisie<br>
                    Tél: ${commande["tel"]} `;
                                        
        if(commande["commentaire"]!==""){boxContent += `commentaire : ${commande["commentaire"]}`}
        clientBoxAdresse.innerHTML = boxContent;


        window.print()
    })
})



/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
////////// partie ki tenzel bch tchou le contenue de la commande ////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

showCommandeButton.forEach(button=>{
    button.addEventListener("click", async function(event){
        event.preventDefault();




        let topPart = document.querySelector(".commandeContainer .topPart");
        let articleContainer = document.querySelector(".commandeContainer .articleContainer")
        let bottomPart = document.querySelector(".commandeContainer .bottomPart");


        let commandeId = button.dataset.id

        let response = await fetch("/api/commandes/" + commandeId );
        let result = await response.json();
        let commande = result.data

        let response2 = await fetch(`/api/commandes/${commandeId}/articles`);
        let result2 = await response2.json();
        let articles = result2.data


        var html=``;
        for(let i=0; i< articles.length ; i++){
            let article = articles[i]
            html += `
                        <li>
                            <ul>
                                <li>
                                    <img src="${article["image_url"]}" alt="Image d'une fourniture scholaire | Librairie chebbi | tunisie">
                                    <div class="text">
                                        <h5>${article["libelle"]}</h5>
                                        <p>${article["categorie"]}, ${article["marque"]}</p>
                                    </div>
                                </li>
                                <li>x${article["quantite"]}</li>
                                <li>${article["sous_total"]} Dt</li>
                            </ul>
                        </li>
            
            `;   
        }
        


        // //fill data
        // // fill top part 
        var statut ="";
        if(commande["statut"] == "confirmée" || commande["statut"] == "attente") statut = `<p class="statutExpediee statutCommande">En attente</p>`
        if(commande["statut"] == "annulée") statut = `<p class="statutAnnulee statutCommande">Annulée</p>`;
        if(commande["statut"] == "livrée") statut = `<p class="statutLivree statutCommande">Livrée</p>`;

        //fill : top part elli feha donnée 3al commande
        topPart.innerHTML= `                
                                            <div>
                                                <div>
                                                    <h4>Commande#${commande["id_commande"]}</h4>
                                                    ${statut}
                                                </div>
                                                <p>${(commande["date_commande"]).substr(0,commande["date_commande"].indexOf(" "))} <br> ${(commande["date_commande"]).substr(commande["date_commande"].indexOf(" ") +1)}</p>
                                                </div>
                                            </div>

                                            <div>
                                                <p>Total : <span>${commande["prix_totale"]} Dt</span></p>
                                            </div>        
        
        `;

        // fill : les articles de la commande
        articleContainer.innerHTML = html

        // fill : partie eli feha el prix totale
        bottomPart.innerHTML=`
                                        <div class="double">
                                            <h5>Sous-total</h5>
                                            <p>${commande["prix_totale"]} Dt</p>
                                        </div>
                                        <div class="double">
                                            <h5>Livraison</h5>
                                            <p>7,000 Dt</p>
                                        </div>
                                        <hr>
                                        <div class="double">
                                            <h3>Total</h3>
                                            <h3>${(parseFloat(commande["prix_totale"]) + 7).toFixed(3)} Dt</h3>
                                        </div>
        `;

        
        commandeContainer.style.display = "flex";
        overlay.removeAttribute("hidden");
        let height = commandeContainer.getBoundingClientRect().height;

        if(height * 0.5 > window.scrollY * 2){
            commandeContainer.style.top = `50px `;
            commandeContainer.style.transform = `translate(-50% )`;
            console.log("hello")
            
        }else{
            commandeContainer.style.marginTop ="0px";
            commandeContainer.style.top = `calc(50%)`;
            commandeContainer.style.transform = " translate(-50%, 50%)";
        }
        // commandeContainer.style.top = `3em`;

        overlay.style.minHeight = Math.max(document.body.getBoundingClientRect().height, height + window.scrollY) + 200 + "px";
        console.log(document.body.getBoundingClientRect().height)
        console.log(height + window.scrollY)
    })


})



/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
////////// partie ki tenzel bch tchou le contenue de la commande ////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////

overlay.addEventListener("click",function(){
    commandeContainer.style.display = "none";
    overlay.setAttribute("hidden","")
})