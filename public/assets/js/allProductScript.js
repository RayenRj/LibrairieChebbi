let addCartButtonList = document.querySelectorAll(".addCartButton");
let articleContainer = document.querySelector(".articles")
let emptyHeart = document.querySelectorAll(".fa-regular.fa-heart")

function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}
cartCount.textContent = getLocalStorageArticlesList().length ;



addCartButtonList.forEach(button => {
    button.addEventListener("click",function(event){
        event.preventDefault();
        let element = event.target == button.firstElementChild ? event.target.parentElement : event.target;
        let cartTableString = localStorage.getItem("cartTable");

        if(cartTableString !== null){
            var cartTable = JSON.parse(cartTableString);
        }else{
            var cartTable = [];
        }
        console.log(cartTable)
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
            cartTable.push({
                idproduit : idProduct,
                    quantity :1
            });
        }
        console.log(cartTable)
        localStorage.setItem(
            "cartTable",
            JSON.stringify(cartTable)
        )
    })
})

console.log(emptyHeart)
emptyHeart.forEach(heart =>{
    heart.addEventListener("mouseover", _ =>{
        console.log(heart)
        heart.classList.remove("fa-regular");
        heart.classList.add("fa-solid")
        heart.style.color = "red"
    });

    heart.addEventListener("mouseout",_=>{
        heart.classList.add("fa-regular");
        heart.classList.remove("fa-solid")
        heart.style.color = "";
    });

    heart.addEventListener("click",(event)=>{
        event.preventDefault();
        heart.classList.toggle("fa-regular")
        heart.classList.toggle("fa-solid")
    })
})





