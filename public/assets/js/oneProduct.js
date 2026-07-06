let plusButton= document.querySelector("#plusButton")
let minusButton= document.querySelector("#minusButton")
let quantity = document.querySelector("#quantity")
let review = document.querySelector(".n-review")
plusButton.addEventListener("click", function(e){
    e.preventDefault();
    quantity.value = (parseInt(quantity.value) + 1).toString();
})
minusButton.addEventListener("click", function(e){
    e.preventDefault();
    if(quantity.value > 1){
        quantity.value = (parseInt(quantity.value) - 1).toString();
    }
})

//reglage review rating
let random;
do{
    random = Math.random() * 150
}while(random< 25)
if(random - parseInt(random) !== 0.5){random = Math.round(random)}
review.innerHTML= `(${random} Reviews)`



