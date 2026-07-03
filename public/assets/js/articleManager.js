
let firstChart = document.querySelector("#chart1");
let secondeChart = document.querySelector("#chart2");
const months = [
  "Janvier", "Février", "Mars", "Avril",
  "Mai", "Juin", "Juillet", "Août",
  "Septembre", "Octobre", "Novembre", "Décembre"
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
        console.log(`for month ${date.month} : ${result.data}`);
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

    let response2 = await fetch("/api/articles/ventes/categories");
    let resultat2 = await response2.json();
    let dataList = resultat2.data ?? [];
    
    
    const labels = ["Écriture",
                    "Papeterie",
                    "Classement",
                    "Géométrie",
                    "Coupe et collage",
                    "Dessin et arts",
                    "Sacs et accessoires",
                    "Calcul et sciences",
                    "Numérique",
                    "Livres pédagogiques",
                    "Fournitures de bureau",
                    "Others"
                    ];
    const values = ["ecriture",
                    "papeterie",
                    "classement",
                    "geometrie",
                    "coupe_collage",
                    "dessin_arts",
                    "sacs_accessoires",
                    "calcul_sciences",
                    "numerique",
                    "livres_pedagogiques",
                    "fournitures_bureau",
                    "others"
                    ];


    let chartValues = new Array(values.length).fill(0);
    for(let cat of dataList){
        chartValues[values.indexOf(cat.categorie)] = parseInt(cat.nombreVente);
    }
    // remplissage la liste ba7dha chart UI
    let ul_Chart = this.document.querySelectorAll(".articleManager .top-chart .chartList");
    let html_content_1 = "";
    let html_content_2 = "";
    for(let i =0 ; i<=5 ; i++){
        html_content_1 += `      <li>
                                    <p><i class="fa-solid fa-circle"></i> ${labels[i]}</p>
                                    <p>${chartValues[i]}%</p>
                                </li>`;
        html_content_2 += `      <li>
                                    <p><i class="fa-solid fa-circle"></i> ${labels[6+i]}</p>
                                    <p>${chartValues[i+6]}%</p>
                                </li>`;
    }
    ul_Chart[0].innerHTML = html_content_1;
    ul_Chart[1].innerHTML = html_content_2;

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

// partie form

let addArticleForm = document.querySelector("#addArticleForm");
addArticleForm.addEventListener("submit",async function(event){
    event.preventDefault();
    const formData = new FormData(addArticleForm);
    for(const [key,value] of formData.entries()){
        console.log(key,value);
    }

    let response = await fetch("/api/articles",{
        method: "POST", 
        body: formData
    });
    let result = await response.json();
    console.log(result)
    if(result.success == true){
        alert("Product added successfully!");
        window.location.reload();
    }else{
        alert(result.message);
    }
    

})