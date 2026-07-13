let plusButton= document.querySelector("#plusButton");
let minusButton= document.querySelector("#minusButton");
let quantity = document.querySelector("#quantity");
let review = document.querySelector(".n-review");
let addToCart = document.querySelector(".add-to-cart");


// reglage ll count cart f awel reload 
if(localStorage.getItem("cartTable")){
    cartCount.innerHTML = (JSON.parse(localStorage.getItem("cartTable"))).length
}else{cartCount.innerHTML=0}
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



// Action sur le bouton add to cart
addToCart.addEventListener("click",function(event){
    event.preventDefault();
    let quantity = parseInt(document.querySelector("#quantity").value);
    let idpack = addToCart.dataset.idpack;
    let table = JSON.parse(localStorage.getItem("cartTable")) ?? [];
    if(table !== []){
        for(let i =0; i<table.length ; i++){
            let product = table[i]
            if(product.idproduit == idpack){
                table[i].quantity += quantity ;
                localStorage.setItem("cartTable", JSON.stringify(table));
                return;
            }
        }
    }
    let pack = {
        idproduit: idpack,
        quantity :  quantity
    }
    table.push(pack);
    localStorage.setItem("cartTable", JSON.stringify(table));
    console.log(cartCount.textContent)
    cartCount.textContent = parseInt(cartCount.textContent) + 1 ;
})