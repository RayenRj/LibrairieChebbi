
const chart1 = document.getElementById('evolution_vente');
const days = ["Dimanche","Lundi" , "Mardi","Mercredi","Jeudi","Vendredi" , "Samedi"]
let legendVentePack = document.querySelector(".legend");
window.addEventListener("load",async function name(params) {


  let date = new Date()
  let aujourdhui = date.getDay();
  let data = []
  for(let i =0 ; i< 7 ; i++){
    let response = await fetch("/api/venteParJour/"+ i);
    let result = await response.json();
    console.log(result)
    data.unshift(result.data)
  }
  
  console.log(data)
  let chart = new Chart(chart1, {
    type: 'line',
    data: {
      labels: [days[aujourdhui-6 >= 0 ? aujourdhui-6 : aujourdhui-6 + 7 ],
               days[aujourdhui-5 >= 0 ? aujourdhui-5 : aujourdhui-5 + 7 ],
               days[aujourdhui-4 >= 0 ? aujourdhui-4 : aujourdhui-4 + 7 ], 
               days[aujourdhui-3 >= 0 ? aujourdhui-3 : aujourdhui-3 + 7 ], 
               days[aujourdhui-2 >= 0 ? aujourdhui-2 : aujourdhui-2 + 7 ], 
               days[aujourdhui-1 >= 0 ? aujourdhui-1 : aujourdhui-1 + 7 ], 
               "Aujourd'hui"],
      datasets: [{
        label: "Nombre de vente",
        data: data,
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
        legend :{
                display:false,
                labels: {
                    boxWidth: 0
                }
        },
        tooltip : {enabled:true}
      },
      animations : {
        y: {from:1000}
      }

    }
  });




  ///////////////////////////////////////
  ///////////////////////////////////////
  ///////////////////////////////////////
  ///////// Second Chart : doughout /////
  ///////////////////////////////////////
  ///////////////////////////////////////
  ///////////////////////////////////////
  let response2 = await fetch("/api/venteParCategorie")
  let result2 = await response2.json()
  let data2 = result2.data;
  var html ="";
  if (data2!== null){
    // le cas ou il ya des vente
    let pourcentage =[];
    let somme= 0;
    for(let article of data2){
      somme += parseInt(article["nombreVente"]);
    }


    pourcentageArray = data2.map(function(article){
      return {    "type": article["type"],
                  "pourcentage" : (article["nombreVente"] * 100 / somme).toFixed(2)}
    })
    
    for(let i =0 ; i<data2.length;i++){
      html += ` 
                                  <li>
                                      <h5>${data2[i]["type"]}</h5>
                                      <p>${pourcentageArray[i]["pourcentage"]}% (${data2[i]["nombreVente"]} ventes)</p>
                                  </li>`;      
    }
   
  }else{
    // en cas de pas de vente : remplir avec des data faux
      Label = ["Primaire" , "Secondaire" , "College","Bac"]
      for(let text of Label){
      html += ` 
                                  <li>
                                      <h5>${text}</h5>
                                      <p>0% (0 ventes)</p>
                                  </li>`; 
      data2.push({
        "type" : text,
        "nombreVente" : 50
      })     
    }
  }

 legendVentePack.innerHTML = html;

  let doughnut = new Chart(document.querySelector("#pie-chart"),{
  type: 'doughnut',
  data: {
    labels : data2.map(row => row["type"]) ,
    datasets :[{
      data : data2.map(row=> row["nombreVente"]),
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
        enabled:false,
        padding:15,
        displayColors:false
      }
    }
  }
})
})


  // donut chart

