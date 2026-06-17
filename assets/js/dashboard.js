
const chart1 = document.getElementById('evolution_vente');

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

new Chart(chart1, {
    type: 'line',
    data: {
      labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'May'],
      datasets: [{
        label: "Chiffre d'affaires(DT)",
        data: data.map(row => row.montant),
        borderWidth: 2,
        borderColor: "#3B82F6",
      }]
    },
    options: {
      animation: {
      duration: 1500,        // animation speed
      easing: 'easeOutQuart' // smooth effect
    },
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins : {
        legend : {display:false,},
        tooltip : {enabled:true}
      },
      animations : {
        y: {from:1000}
      }

    }
  });


  // donut chart
new Chart(document.querySelector("#pie-chart"),{
  type: 'doughnut',
  data: {
    labels : ["Primaire" , "Collège", "Secondaire", "Bac"] ,
    datasets :[{
      data : data2.map(row=> row.montant),
      backgroundColor: ['green','#3B82F6','#FFDD57',"purple"],
      hoverOffset: 7,
      borderWidth : 2,
      borderColor : new Array(4).fill("white")
    }]
  },

  options: {
    responsive:true,
    animation:{
      animateRotate: true,
      animateScale:true,
      duration : 2000 , 
      easing : 'easeOutBounce'
    },
    cutout: '65%',
    plugins:{
      legend:{
        display:false,
      },
      tooltip:{
        enabled:true,
        padding:15,
        displayColors:false
      }
    }
  }
})
