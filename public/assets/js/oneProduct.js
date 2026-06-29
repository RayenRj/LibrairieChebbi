let plusButton= document.querySelector("#plusButton")
let minusButton= document.querySelector("#minusButton")
let quantity = document.querySelector("#quantity")

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