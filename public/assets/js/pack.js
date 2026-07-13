let addToCartButton = document.querySelectorAll(".addToCart")


function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}
cartCount.textContent = getLocalStorageArticlesList().length ;



addToCartButton.forEach(button=>{
    button.addEventListener("click", function(event){
        event.preventDefault();
        let idpack = event.target.dataset.idpack;
        let cartTable = getLocalStorageArticlesList();
        for(let article of cartTable){
            if(article["idproduit"] == idpack){
                article["quantity"] = 1 + parseInt(article["quantity"])
                localStorage.setItem("cartTable",JSON.stringify(cartTable))
                return;
            }
        }
        cartCount.textContent = parseInt(cartCount.textContent) + 1 ;
        cartTable.push({
            idproduit: idpack,
            quantity: 1
        });
        localStorage.setItem("cartTable",JSON.stringify(cartTable))
        return;

    })
})