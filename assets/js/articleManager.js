
let firstChart = document.querySelector("#chart1");
let secondeChart = document.querySelector("#chart2");



const data = [
    {"montant" : 250},
    {"montant" : 350},
    {"montant" : 140},
    {"montant" : 200},
    {"montant" : 1000}
]
const data2 = [
    {"montant" : 250},
    {"montant" : 350},
    {"montant" : 140},
    {"montant" : 200},
]

new Chart(firstChart , {
    type:"bar",
    data : {
        labels : ["jan","feb","mars","april" ,"may"],
        datasets:[{
            data : data.map(line=> line.montant),
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
        plugins: {
            legend :{display:false,}
        }, 
        animation: {
            duration : 2000,
            easing: 'easeOutQuart'
        },
        animations : {
            y: {from:500}
        }
    }
})


new Chart(secondeChart ,{
    type: "doughnut" ,
    data :{
        labels: ["Cahiers","Stylos" , "Sacs" , "Livres" , "Autres"],
        datasets:[{
            data: data.map(item=>item.montant),
            backgroundColor: [       
                'rgb(255, 99, 132)',
                'rgb(255, 159, 64)',
                'rgb(255, 205, 86)',
                'rgb(54, 162, 235)',
                'rgb(153, 102, 255)',  ],
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
    console.log(height.toString() + "px");
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