let addToCartButton = document.querySelectorAll(".add-to-cart")


function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}



/////////////////////////////////////////////////
/////////////////////////////////////////////////
/////////////////////////////////////////////////
////////// adding pack to cart //////////////////
/////////////////////////////////////////////////
/////////////////////////////////////////////////
/////////////////////////////////////////////////
addToCartButton.forEach(button => {
    button.addEventListener("click",function(event){
        event.preventDefault();
        let element = event.target == button.firstElementChild ? event.target.parentElement : event.target;
        let cartTableString = localStorage.getItem("cartTable");

        if(cartTableString !== null){
            var cartTable = JSON.parse(cartTableString);
        }else{
            var cartTable = [];
        }
        let idProduct = element.dataset.idproduit;
        let exist = 0;
        for(let i =0 ; i<cartTable.length ; i++){        
            if(cartTable[i].idproduit == idProduct){
                cartTable[i].quantity += 1;
                exist = true;
            }
        }
        if(!exist){
            cartCount.textContent = parseFloat(cartCount.textContent) + 1
            responsiveCartCount.textContent = parseFloat(responsiveCartCount.textContent) + 1
            cartTable.push({
                idproduit : idProduct,
                    quantity :1
            });
        }
        localStorage.setItem(
            "cartTable",
            JSON.stringify(cartTable)
        )
    })
})