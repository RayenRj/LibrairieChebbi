let close = document.querySelector(".dismiss.button");
let popup = document.querySelector("div.popup");
let confimerCommandeButton = document.querySelector(".btn-confirmation");
let cartCount = document.querySelector(".cartCount");
let delegationContainer = document.querySelector("#delegation");
let gouvernoratContainer = document.querySelector("#gouvernorat");

const gouvernorats = {
  "Ariana": [
    "Ariana Ville", "Cité Ettadhamen", "Kalâat El Andalous", "La Soukra",
    "Mnihla", "Raoued", "Sidi Thabet"
  ],
  "Béja": [
    "Amdoun", "Béja Nord", "Béja Sud", "Goubellat", "Medjez El Bab",
    "Nefza", "Téboursouk", "Testour", "Thibar"
  ],
  "Ben Arous": [
    "Ben Arous", "Bou Mhel El Bassatine", "El Mourouj", "Ezzahra",
    "Fouchana", "Hammam Chott", "Hammam Lif", "Medina Jedida",
    "Mégrine", "Mohamedia", "Mornag", "Radès"
  ],
  "Bizerte": [
    "Bizerte Nord", "Bizerte Sud", "El Alia", "Ghar El Melh", "Ghezala",
    "Joumine", "Mateur", "Menzel Bourguiba", "Menzel Jemil", "Ras Jebel",
    "Sejnane", "Tinja", "Utique", "Zarzouna"
  ],
  "Gabès": [
    "Dkhilet Toujane", "El Hamma", "Gabès Médina", "Gabès Ouest",
    "Gabès Sud", "Ghannouch", "Habib Thameur Bouatouch", "Mareth",
    "Matmata", "Menzel El Habib", "Métouia", "Nouvelle Matmata", "Oudhref"
  ],
  "Gafsa": [
    "Belkhir", "El Guettar", "El Ksar", "Gafsa Nord", "Gafsa Sud",
    "Mdhila", "Métlaoui", "Moularès", "Redeyef", "Sened", "Sidi Aïch",
    "Sidi Boubaker", "Zannouch"
  ],
  "Jendouba": [
    "Aïn Draham", "Balta - Bou Aouane", "Bou Salem", "Fernana",
    "Ghardimaou", "Jendouba", "Jendouba Nord", "Oued Meliz", "Tabarka"
  ],
  "Kairouan": [
    "Aïn Djeloula", "Bou Hajla", "Chebika", "Echrarda", "El Alâa",
    "Haffouz", "Hajeb el Ayoun", "Kairouan Nord", "Kairouan Sud",
    "Menzel Mehiri", "Nasrallah", "Oueslatia", "Sbikha"
  ],
  "Kasserine": [
    "El Ayoun", "Ezzouhour", "Fériana", "Foussana", "Haïdra",
    "Hassi El Ferid", "Jedelienne", "Kasserine Nord", "Kasserine Sud",
    "Majel Bel Abbès", "Sbeïtla", "Sbiba", "Thala"
  ],
  "Kébili": [
    "Douz Nord", "Douz Sud", "Faouar", "Kébili Nord", "Kébili Sud",
    "Rjim Maatoug", "Souk Lahad"
  ],
  "Kef": [
    "Dahmani", "El Ksour", "Jérissa", "Kalâat Khasba", "Kalaat Senan",
    "Kef Est", "Kef Ouest", "Nebeur", "Sakiet Sidi Youssef", "Sers",
    "Tajerouine", "Touiref"
  ],
  "Mahdia": [
    "Bou Merdes", "Chebba", "Chorbane", "El Bradâa", "El Jem", "Essouassi",
    "Hebira", "Ksour Essef", "Mahdia", "Melloulèche", "Ouled Chamekh",
    "Rejiche", "Sidi Alouane"
  ],
  "Manouba": [
    "Borj El Amri", "Djedeida", "Douar Hicher", "El Batan", "Manouba",
    "Mornaguia", "Oued Ellil", "Tebourba"
  ],
  "Médenine": [
    "Ben Gardane", "Beni Khedache", "Djerba Ajim", "Djerba Houmt Souk",
    "Djerba Midoun", "Médenine Nord", "Médenine Sud", "Sidi Makhlouf", "Zarzis"
  ],
  "Monastir": [
    "Bekalta", "Bembla", "Beni Hassen", "Jemmal", "Ksar Hellal",
    "Ksibet El Médiouni", "Moknine", "Monastir", "Ouerdanine", "Sahline",
    "Sayada - Lamta - Bouhjar", "Téboulba", "Zéramdine"
  ],
  "Nabeul": [
    "Béni Khalled", "Béni Khiar", "Bou Argoub", "Dar Châabane El Fehri",
    "El Haouaria", "El Mida", "Grombalia", "Hammamet", "Hammam Ghezèze",
    "Kélibia", "Korba", "Menzel Bouzelfa", "Menzel Temime", "Nabeul",
    "Soliman", "Takelsa"
  ],
  "Sfax": [
    "Agareb", "Bir Ali Ben Khalifa", "El Amra", "El Hencha", "Graïba",
    "Jebiniana", "Kerkennah", "Mahrès", "Menzel Chaker", "Sakiet Eddaïer",
    "Sakiet Ezzit", "Sfax Ouest", "Sfax Sud", "Sfax Ville", "Skhira", "Thyna"
  ],
  "Sidi Bouzid": [
    "Bir El Hafey", "Cebbala Ouled Asker", "El Hichria", "Essaïda", "Jilma",
    "Meknassy", "Menzel Bouzaiane", "Mezzouna", "Ouled Haffouz", "Regueb",
    "Sidi Ali Ben Aoun", "Sidi Bouzid Est", "Sidi Bouzid Ouest", "Souk Jedid"
  ],
  "Siliana": [
    "Bargou", "Bou Arada", "El Aroussa", "El Krib", "Gaâfour", "Kesra",
    "Makthar", "Rouhia", "Sidi Bou Rouis", "Siliana Nord", "Siliana Sud"
  ],
  "Sousse": [
    "Akouda", "Bouficha", "Enfida", "Hammam Sousse", "Hergla", "Kalâa Kebira",
    "Kalâa Seghira", "Kondar", "M'saken", "Sidi Bou Ali", "Sidi El Hani",
    "Sousse Jawhara", "Sousse Médina", "Sousse Riadh", "Sousse Sidi Abdelhamid",
    "Zaouiet - Ksibet Thrayet"
  ],
  "Tataouine": [
    "Beni Mehira", "Bir Lahmar", "Dehiba", "Ghomrassen", "Remada", "Smâr",
    "Tataouine Nord", "Tataouine Sud"
  ],
  "Tozeur": [
    "Degache", "El Hamma du Jérid", "Hazoua", "Nefta", "Tamerza", "Tozeur"
  ],
  "Tunis": [
    "Bab El Bhar", "Bab Souika", "Carthage", "Cité El Khadra",
    "Djebel Jelloud", "El Hraïria", "El Kabaria", "El Menzah", "El Omrane",
    "El Omrane Supérieur", "El Ouardia", "Ettahrir", "Ezzouhour",
    "La Goulette", "La Marsa", "Le Bardo", "Le Kram", "Medina", "Séjoumi",
    "Sidi El Béchir", "Sidi Hassine"
  ],
  "Zaghouan": [
    "Bir Mcherga", "El Fahs", "Nadhour", "Saouaf", "Zaghouan", "Zriba"
  ]
};




function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}
cartCount.textContent = getLocalStorageArticlesList().length ;



//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////// reglage ll close pop Up cardd ///////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
close.addEventListener("click",()=>{
    popup.setAttribute("hidden","");
    document.body.style.overflowY="scroll";
})



confimerCommandeButton.addEventListener("click",async (event)=>{
    event.preventDefault();
    let formData = new FormData(document.querySelector("#commandeForm"));
    for(const[key,val] of formData.entries()){
        if(key == "tel"){
            let nmr = "1234567890+";
            for(let caractere of val){
                if(nmr.indexOf(caractere) === -1){
                    alert("La Valeur Du Numéro de Telephone Est Invalide .");
                    return;
                }
            }
        }
        if(["comment","codePostal"].indexOf(key) === -1 && val.trim()==""){
            alert("Ce champ est obligatoire : " +key.toUpperCase());
            return;
        }
    }

    let date = new Date();
    let dateCommande = `${date.getFullYear()}-${String(date.getMonth() +1).padStart(2,"0")}-${String(date.getDate()).padStart(2,'0')} ${String(date.getHours()).padStart(2,"0")}:${String(date.getMinutes()).padStart(2,"0")}:${String(date.getSeconds()).padStart(2,'0')}`;
    let idClient = event.target.dataset.idclient
    let statut = "attente";
    let ville = formData.get("gouvernorat") + " , " + formData.get("delegation")
    let prix = parseFloat(event.target.dataset.prixtotale) + 7 ;

    formData.append("id_client",idClient)
    formData.append("date_commande",dateCommande)
    formData.append("statut",statut)
    formData.append("ville" , ville);
    formData.append("prix_totale",prix)
    let articlesList = JSON.parse(localStorage.getItem("cartTable"));
    let newList=[]
    for(let article of articlesList){
            newList.push({    [article["idproduit"]] : article["quantity"]    })
    }
    formData.append("ligneCommandes", JSON.stringify(newList))
    


    if(confirm("Voulez-vous confirmer votre commande ? Une fois confirmée, elle sera envoyée pour traitement.")){
        let response = await fetch("/api/commandes/save",{
            method:"POST",
            body: formData
        })

        let result = await response.json();
        if(result.success && result.data){
            window.scrollTo(0,0);
            cartCount.innerText=0;
            localStorage.clear();
            popup.removeAttribute("hidden");
            document.body.style.overflowY="hidden";
        }else{
            alert(result.message)
        }
    }

})



//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////// getting item for the resumeee ///////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
window.addEventListener("load",async function(event){
    let articles= document.querySelector(".articles")
    let article_list = getLocalStorageArticlesList();

    for(article of article_list){
        let response = await fetch(`/api/products/${article.idproduit}`);
        let product = await response.json();
        product= product.data;
        articles.innerHTML += `
                            <article data-idarticle=${article.idproduit} data-quantity=${article.quantity} >
                                <div>
                                    <img src="${product.image_url}" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">${product.libelle}</p>
                                        <p class="quantite">x${article.quantity}</p> <!-- from localStore -->
                                    </div>
                                </div>
                                <p class="prix">${product.prix * article.quantity} Dt</p>
                            </article>
        `;
    }

})


//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////// reglage ll partie gouvernorat ///////
//////////////////////////////////////////////
//////////////////////////////////////////////
//////////////////////////////////////////////
gouvernoratContainer.addEventListener("change",function(){
    const gouvernoratSelectedValue = gouvernoratContainer.value;
    html = `<option value="" selected>Sélectionnez votre délégation</option>`
    if(gouvernoratSelectedValue!=""){
        for(let delegation of gouvernorats[gouvernoratSelectedValue]){
            html += `<option value="${delegation}">${delegation}</option>` ;
        }
    }
    delegationContainer.innerHTML= html;

})