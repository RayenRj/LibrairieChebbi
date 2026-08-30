
let firstChart = document.querySelector("#chart1");
let secondeChart = document.querySelector("#chart2");
let categorieSelect = document.querySelector(".selectCategoriePopUp")
const months = [
  "Janvier", "Février", "Mars", "Avril",
  "Mai", "Juin", "Juillet", "Août",
  "Septembre", "Octobre", "Novembre", "Décembre"
];

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





let date= new Date();
let dateList= [];
let monthNameList =[];
let venteParMois = [];
for(let i = 0 ; i<5 ; i++){
    let date= new Date();
    date.setMonth(date.getMonth() - i +1);
    monthNameList.unshift(months[date.getMonth()-1]);
    dateList.unshift({
        month: date.getMonth(),
        year: date.getFullYear()
    })
}

// wa9teli el window tloadi
window.addEventListener("load", async function(event){
    for(let date of dateList){
        let response = await fetch("/api/articles/vente",{
        method:"POST",
        body: JSON.stringify(date)
        })
        let result = await response.json();
        venteParMois.push(parseFloat(result.data));

    }

    //barChart Properties
    let barChart = new Chart(firstChart , {     type:"bar",
                                                data : {
                                                        labels : monthNameList, // label : les nom 
                                                        datasets:[{
                                                            data : venteParMois,
                                                            backgroundColor: [
                                                            'rgba(255, 99, 132, 0.2)',
                                                            'rgba(255, 159, 64, 0.2)',
                                                            'rgba(255, 205, 86, 0.2)',
                                                            'rgba(75, 192, 192, 0.2)',
                                                            'rgba(54, 162, 235, 0.2)',
                                                            'rgba(153, 102, 255, 0.2)',
                                                            'rgba(201, 203, 207, 0.2)'
                                                            ],
                                                            borderColor: [
                                                            'rgb(255, 99, 132)',
                                                            'rgb(255, 159, 64)',
                                                            'rgb(255, 205, 86)',
                                                            'rgb(75, 192, 192)',
                                                            'rgb(54, 162, 235)',
                                                            'rgb(153, 102, 255)',
                                                            'rgb(201, 203, 207)'
                                                            ],
                                                            borderWidth: 1
                                                        }]
                                                        },
                                                        options: {
                                                            scales: {y: {beginAtZero:true}},
                                                            plugins: {legend :{display:false,}}, 
                                                            animation: {duration : 2000,easing: 'easeOutQuart'},
                                                            animations : {y: {from:Math.max[venteParMois]}}
                                                        }
                                                    })


    // chart 2 : donught chart

    // appelle de l api
    let response2 = await fetch("/api/articles/ventes/categories");
    let resultat2 = await response2.json();
    let dataList = resultat2.data ?? [];

    
    // Data pour remplissaage
    const labels = ["Écriture",
                    "Papeterie",
                    "Classement",
                    "Géométrie",
                    "Coupe et collage",
                    "Dessin et arts",
                    "Sacs",
                    "Calcul et sciences",
                    "Numérique",
                    "Livres pédagogiques",
                    "parascolaire",
                    "jouet",
                    "sac a dos",
                    "sac a chariot",
                    "panier",
                    "trousse",
                    "Fournitures de bureau",
                    "Others"
                    ];
    const values = ["ecriture",
                    "papeterie",
                    "classement",
                    "geometrie",
                    "coupe_collage",
                    "dessin_arts",
                    "sac",
                    "calcul_sciences",
                    "numerique",
                    "livres_pedagogiques",
                    "parascolaire",
                    "jouet",
                    "sac a dos",
                    "sac a chariot",
                    "panier",
                    "trousse",
                    "fournitures_bureau",
                    "others"
                    ];

    // tableau fih les valeur mta3 tous les categories
    let chartValues = new Array(values.length).fill(0);
    for(let cat of dataList){
        chartValues[values.indexOf(cat.categorie.toLowerCase())] = parseInt(cat.nombreVente);
    }

    // ==================================================================================
    // ==================================================================================
    // ==================== remplissage la liste ba7dha chart UI ========================
    // ==================================================================================
    // ==================================================================================
    // remplissage la liste ba7dha chart UI
    let ul_Chart = this.document.querySelectorAll(".articleManager .top-chart .chartList");
    let html_content_1 = "";
    let html_content_2 = "";
    for(let i =0 ; i<9 ; i++){
        html_content_1 += `     <li>
                                    <p><i class="fa-solid fa-circle"></i> ${labels[i]}</p>
                                    <p>${chartValues[i]}</p>
                                </li>`;
        if(i<=8){
            html_content_2 += `      <li>
                                        <p><i class="fa-solid fa-circle"></i> ${labels[9+i]}</p>
                                        <p>${chartValues[i+9]}</p>
                                    </li>`;
        }
    }
    ul_Chart[0].innerHTML = html_content_1;
    ul_Chart[1].innerHTML = html_content_2;


    // =====================================================================================
    // =====================================================================================
    // ================================== Chart Creation ===================================
    // =====================================================================================
    // =====================================================================================
    let donughtChart = new Chart(secondeChart ,{
                                                    type: "doughnut" ,
                                                    data :{
                                                        labels: labels,
                                                        datasets:[{
                                                            data: chartValues,
                                                            backgroundColor: [
                                                                'rgb(255, 99, 132)',   // rose
                                                                'rgb(255, 159, 64)',   // orange
                                                                'rgb(255, 205, 86)',   // jaune
                                                                'rgb(75, 192, 192)',   // turquoise
                                                                'rgb(54, 162, 235)',   // bleu
                                                                'rgb(153, 102, 255)',  // violet
                                                                'rgb(201, 203, 207)',  // gris
                                                                'rgb(46, 204, 113)',   // vert
                                                                'rgb(231, 76, 60)',    // rouge
                                                                'rgb(52, 152, 219)',   // bleu clair
                                                                'rgb(155, 89, 182)',   // violet foncé
                                                                'rgb(241, 196, 15)'    // doré
                                                                ],
                                                            hoverOffset: 10,
                                                            borderColor: new Array(5).fill("white",0,5),
                                                            borderWidth: 3,
                                                        }]
                                                    },
                                                    options :{
                                                        // responsive:true,
                                                        
                                                        animation: {
                                                            duration: 1500,
                                                            easing: 'easeOutQuart'
                                                        },
                                                        cutout: '60%' ,
                                                        plugins :{legend :{display:false}}
                                                    },

                                                })
})










let resetButton = document.querySelector("#resetButton");
let input = document.querySelector("#file");
let container = document.querySelector(".custum-file-upload")
// reglage ll partie popUp
let articleContainer = document.querySelector(".articleManager");
let addArticleButton = document.querySelector("#addArticle");
let popUpForm= document.querySelector(".popUpPart");
let popUpContainer = document.querySelector(".popUpCard");
let closePopUp = document.querySelector("#popUpClose");
let overlay = document.querySelector(".popUpContainer .overlay");
addArticleButton.addEventListener("click",function(event){
    event.preventDefault();
    popUpForm.removeAttribute("hidden");
    var height = popUpForm.getBoundingClientRect().height;
    articleContainer.style.height = (height - 80).toString() + "px" ;
    articleContainer.style.overflowY = "hidden";
})
closePopUp.addEventListener("click",function(event){
    event.preventDefault();
    popUpForm.setAttribute("hidden","");
    articleContainer.style.height = "";
    articleContainer.style.overflowY = "";
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
    container.style.backgroundImage= "";
    container.style.backgroundSize= "";
    container.style.backgroundRepeat = "";
    container.style.backgroundPosition= "";
})
overlay.addEventListener("click",function(event){
    popUpForm.setAttribute("hidden","");
    articleContainer.style.height = "";
    articleContainer.style.overflowY = "";
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
    container.style.backgroundImage= "";
    container.style.backgroundSize= "";
    container.style.backgroundRepeat = "";
    container.style.backgroundPosition= "";
})


// partie el input de type image + adding back img to the container
input.addEventListener("change",function(event){
    let file = this.files[0];
    if(file){
        let reader = new FileReader();
        reader.onload = function(e){
            container.style.backgroundImage= `url(${e.target.result})`;
            container.style.backgroundSize= "contain";
            container.style.backgroundRepeat = "no-repeat";
            container.style.backgroundPosition= "center";
        };
        reader.readAsDataURL(file);
        document.querySelector(".custum-file-upload .icon").style.opacity="0";
        document.querySelector(".custum-file-upload .text").style.opacity="0";
    }
})

// removing the image when pressing the reset button
resetButton.addEventListener("click",function(){
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
    container.style.backgroundImage= "";
    container.style.backgroundSize= "";
    container.style.backgroundRepeat = "";
    container.style.backgroundPosition= "";
})

// partie form : ajouter un article
let addArticleForm = document.querySelector("#addArticleForm");
console.log(addArticleForm)
addArticleForm.addEventListener("submit",async function(event){
    event.preventDefault();
    const formData = new FormData(addArticleForm);
    // for(let [key,val] of formData.entries()){
    //     console.log(key, val)
    // }
    // for(let [key,val] of formData.entries()){
    //     if(val.trim() == ""){
    //         formData.delete(key)
    //     }
    // }
    // for(let [key,val] of formData.entries()){
    //     console.log(key ,val)
    // }



    let categorie = formData.get("categorie")
    let response = await fetch("/api/articles",{
        method: "POST", 
        body: formData
    });
    let result = await response.json();
    if(result.success == true){
        alert("Product added successfully!");
        window.location.reload();
    }else{
        alert(result.message);
    }
    

})


//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
///////////// partie filtrage ////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////
//////////////////////////////////////////////////

let formFilter = document.querySelector("#formFiltrage");
formFilter.addEventListener("submit", function(event){
    event.preventDefault();
    let formData = new FormData(formFilter);
    let str = "";
    for(const[key ,value] of formData){
        if(value !== ""){str += `${key}=${value}&`;}
    }
    if(str!==""){
        str = "?" + str;
        str = str.slice(0,-1)
    }

    window.location.href = `/dashboard/articles${str}#formFiltrage`;
})

let deleteArticleButtonList = document.querySelectorAll(".deleteArticleButton")
deleteArticleButtonList.forEach(article =>{
    article.addEventListener("click",async function(event) {
        event.preventDefault();
        let idProduit = article.dataset.idproduit;
        let response = await fetch(`/api/articles/${idProduit}`,{
            method: "DELETE"
        });
        let result = await response.json();

        if(result.success && result.data){window.location.reload()}
        else{alert(result.message)}
    })
})


// reglage ll add articles
let div = document.querySelector(".singleGenre")
categorieSelect.addEventListener("change",function(){
    if(categorieSelect.value == "sac a dos" || categorieSelect.value == "sac a chariot" || categorieSelect.value=="jouet" || categorieSelect.value=="panier" || categorieSelect.value=="trousse"){
        div.style.display = "flex"
    }else{
        div.style.display = "none"
    }
})

// reglagge ll parascolaire

let divPara = document.querySelector(".singleCollectionParascolaire")
categorieSelect.addEventListener("change",function(){
    if(categorieSelect.value == "parascolaire"){
        divPara.style.display = "flex"
    }else{
        divPara.style.display = "none"
    }
})

// reglagge ll parascolaire

let divLivre = document.querySelector(".singleAnneeParascolaireLivre")
categorieSelect.addEventListener("change",function(){
    if(categorieSelect.value == "parascolaire" || categorieSelect.value == "livres_pedagogiques"){
        divLivre.style.display = "flex";
        document.querySelector(".singleMatiere").style.display = "flex"
        document.querySelector(".marqueDiv").style.display = "none";
    }else{
        divLivre.style.display = "none"
        document.querySelector(".marqueDiv").display = "";
        document.querySelector(".singleMatiere").style.display = ""
    }
})


// remplissage ll donné wst el select
let select = document.querySelector("select#anneeScolaire")
let html = `<option value="" >-- Sélectionnez une année --</option>`
for(let obj of sectionsEtude){
        html +=  `<option value="${obj["value"]}">${obj["label"]}</option>`
}
select.innerHTML = html;


// partie el collection 
var collection_parascolaire  = document.querySelector("#collection_parascolaire");
let htmlString = "<option value=''>-- Choisir une collection --</option>"
for(let i = 0 ; i< collectionsParascolaires.length ; i++){
    htmlString += `<option value="${collectionsParascolaires[i]}">${collectionsParascolaires[i]}</option>`
}

if(collection_parascolaire !== null){collection_parascolaire.innerHTML=htmlString}



// remplissage select du matiere 
const matiereSelect = document.getElementById("matiere");

const matieres = [
    // Général / commun
    "Arabe",
    "Français",
    "Anglais",
    "Mathématiques",
    "Sciences",
    "Informatique",

    // Primaire
    "Éducation islamique",
    "Éducation civique",
    "Éducation scientifique",
    "Éducation artistique",
    "Éducation musicale",
    "Éducation physique",

    // Collège
    "Histoire",
    "Géographie",
    "Technologie",
    "Sciences de la vie et de la Terre",
    "Physique",
    "Chimie",

    // Secondaire
    "Philosophie",
    "Économie",
    "Gestion",
    "Droit",
    "Comptabilité",

    // Section Mathématiques
    "Mathématiques - Section Mathématiques",

    // Section Sciences expérimentales
    "Sciences naturelles",
    "Physique - Section Sciences",

    // Section Technique
    "Technologie industrielle",
    "Génie mécanique",
    "Génie électrique",
    "Génie civil",

    // Section Informatique
    "Algorithmique",
    "Programmation",
    "Systèmes et réseaux",
    "Bases de données",

    // Section Économie et Gestion
    "Économie et statistiques",
    "Gestion",

    // Section Lettres
    "Littérature",
    "Pensée islamique",

    // Langues
    "Italien",
    "Allemand",
    "Espagnol"
];

matieres.forEach(matiere => {
    const option = document.createElement("option");
    option.value = matiere;
    option.textContent = matiere;

    matiereSelect.appendChild(option);
});