
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