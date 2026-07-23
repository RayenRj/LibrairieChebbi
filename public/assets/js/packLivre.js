let anneeScolaireSelect = document.querySelectorAll(".anneeScolaire")
let addToCartButton = document.querySelectorAll("article button");

let face = document.querySelectorAll(".face")
var cart = document.querySelector(".cartCount");



function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}
const sectionsEtude = [
    // Primaire
    { value: "1-primaire", label: "1ère année primaire" },
    { value: "2-primaire", label: "2ème année primaire" },
    { value: "3-primaire", label: "3ème année primaire" },
    { value: "4-primaire", label: "4ème année primaire" },
    { value: "5-primaire", label: "5ème année primaire" },
    { value: "6-primaire", label: "6ème année primaire" },

    // Collège
    { value: "7-base", label: "7ème année de base" },
    { value: "8-base", label: "8ème année de base" },
    { value: "9-base", label: "9ème année de base" },

    // Lycée - Tronc commun
    { value: "1-secondaire", label: "1ère année secondaire" },

    // 2ème secondaire
    { value: "2-lettres", label: "2ème année Lettres" },
    { value: "2-economie", label: "2ème année Économie et Gestion" },
    { value: "2-sciences", label: "2ème année Sciences Expérimentales" },
    { value: "2-informatique", label: "2ème année Informatique" },

    // 3ème secondaire
    { value: "3-lettres", label: "3ème année Lettres" },
    { value: "3-economie", label: "3ème année Économie et Gestion" },
    { value: "3-sciences", label: "3ème année Sciences Expérimentales" },
    { value: "3-math", label: "3ème année Mathématiques" },
    { value: "3-technique", label: "3ème année Technique" },
    { value: "3-informatique", label: "3ème année Informatique" },
    { value: "3-sport", label: "3ème année Sport" },

    // Bac
    { value: "bac-lettres", label: "Bac Lettres" },
    { value: "bac-economie", label: "Bac Économie et Gestion" },
    { value: "bac-sciences", label: "Bac Sciences Expérimentales" },
    { value: "bac-math", label: "Bac Mathématiques" },
    { value: "bac-technique", label: "Bac Technique" },
    { value: "bac-informatique", label: "Bac Informatique" },
    { value: "bac-sport", label: "Bac Sport" }
];


const collectionsParascolaires = [
    "Kounouz Ennajeh",
    "Kounouz Education",
    "Al Moutafawik",
    "Al Moutamayez",
    "Al Mourchid",
    "Al Wadhih",
    "Al Manhal",
    "Al Mofid",
    "Al Najeh",
    "Al Irtiqa",
    "Al Imtiaz",
    "Al Tamyouz",
    "Al Tafaouq",
    "Al Ibdae",
    "Al Ibtikar",
    "Al Moubdi",
    "Al Moubarak",
    "Al Raed",
    "Al Oustadh",
    "Al Qimma",
    "Al Hikma",
    "Al Amal",
    "Al Fajr",
    "Mes Productions",
    "Premier Pas",
    "Objectif Réussite",
    "Objectif Bac",
    "Objectif Excellence",
    "Réussir",
    "Excellence",
    "Excellence Plus",
    "Révision Express",
    "Fiches de Révision",
    "Révision Complète",
    "Révision Finale",
    "Mon Cahier",
    "Mon Premier Cahier",
    "Mon Premier Livre",
    "Série Concours",
    "Série Bac",
    "Série Pilote",
    "Série Excellence",
    "Série Réussite",
    "Série Premium",
    "Série Performance",
    "Le Complet Résolu",
    "Le Guide",
    "Le Guide Complet",
    "Le Guide du Bac",
    "Le Prof",
    "Le Coach",
    "Top Niveau",
    "Top Révision",
    "Top Maths",
    "Top Sciences",
    "Top Français",
    "Top Anglais",
    "Top Informatique",
    "100% Réussite",
    "100% Bac",
    "100% Maths",
    "100% Sciences",
    "100% Français",
    "100% Anglais",
    "Bac Success",
    "Bac Plus",
    "Bac Excellence",
    "Bac Facile",
    "Cap Réussite",
    "Cap Excellence",
    "Cap sur le Bac",
    "Réussite Plus",
    "Maths Faciles",
    "Maths Expert",
    "Physique Expert",
    "Chimie Expert",
    "SVT",
    "Français Plus",
    "Anglais Plus",
    "Allemand Plus",
    "Espagnol Plus",
    "Arabe Plus",
    "Informatique Plus",
    "Autre"
];

anneeScolaireSelect.forEach(select =>{
    let html = `<option value="">-- Sélectionnez une année --</option>`
    for(let obj of sectionsEtude){
        html +=  `<option value="${obj["value"]}">${obj["label"]}</option>`
    }
    select.innerHTML = html;
})

///////////////////////////////////
///////////////////////////////////
///////////////////////////////////
///////// reglage ll button eli fl pack article /////////
///////////////////////////////////
///////////////////////////////////
///////////////////////////////////
//done
addToCartButton.forEach(button =>{
    button.addEventListener("click",async function(event){
        event.preventDefault();
        let produitId = button.dataset.idproduit
        let table = getLocalStorageArticlesList();
        if(table == [] || table == null){
            localStorage.setItem("cartTable", JSON.stringify({
                idproduit : produitId,
                quantity : 1
            }))
        }else{
            for(let i=0 ; i<table.length ; i++){
                if(table[i].idproduit == produitId){
                    table[i].quantity += 1;
                    localStorage.setItem("cartTable" , JSON.stringify(table));
                    return;
                }
            }
            table.push({
                idproduit: produitId,
                quantity:1
            })

            cart.textContent= parseInt(cart.textContent) + 1;

            localStorage.setItem("cartTable" , JSON.stringify(table));
            return;
        }

        
    })
})



let formParascolaire = document.querySelector("#formParascolaire");
let searchButton = document.querySelector(".submitButton")
searchButton.addEventListener("click",function(event){
    event.preventDefault();
    console.log(searchButton)
    var formData = new FormData(formParascolaire);
    var query = ""
    for(var[key , val] of formData.entries()){
        if(val !==""){
            query += `${key}=${val}&`;
        }
    }
    if(query!==""){query = query.slice(0,-1)}
    window.location.href = `/packs/livres/parascolaire?${query}`;

})


// partie el collection 
var collection_parascolaire  = document.querySelector("#collection_parascolaire");
let htmlString = "<option value=''>-- Choisir une collection --</option>"
for(let i = 0 ; i< collectionsParascolaires.length ; i++){
    htmlString += `<option value="${collectionsParascolaires[i]}">${collectionsParascolaires[i]}</option>`
}

if(collection_parascolaire !== null){
collection_parascolaire.innerHTML=htmlString
}



// reglage ll height wl width ta3 packs
let facePart = document.querySelectorAll(".containerBackFlip .face")


facePart.forEach(face=>{
    face.style.height = (face.nextElementSibling.children[0].getBoundingClientRect().height) + "px";
    let img = face.children[0]
    img.style.height = "100%";
    
})