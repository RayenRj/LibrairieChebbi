let addCartButtonList = document.querySelectorAll(".addCartButton");
let articleContainer = document.querySelector(".articles")
let emptyHeart = document.querySelectorAll(".fa-regular.fa-heart")
let categorieLinks = document.querySelectorAll(".list-categorie .checkBox input[type='checkbox']")
let marqueLinks = document.querySelectorAll(".list-marque .checkBox input[type='checkbox']")
let stock = document.querySelector("#stockCheck");
let range1 = document.querySelector("#range1")
let range2 = document.querySelector("#range2")
let prixMax = document.querySelector("#prixMax")
let prixMin = document.querySelector("#prixMin")


//////////////////////////////////
//////////////////////////////////
//////////////////////////////////
//////// reglage de filters //////
//////////////////////////////////
//////////////////////////////////
//////////////////////////////////
let categorieStr= "";
let marqueStr="";
let enStock = false;
stock.addEventListener("click",()=>{enStock = !enStock})
categorieLinks.forEach(button =>{
    button.addEventListener("click", function(){
        if(!button.checked){
            categorieStr += button.value + "$"
            console.log(categorieStr)
        }else{
            categorieStr = categorieStr.slice(0,categorieStr.indexOf(button.value)) + categorieStr.slice(categorieStr.indexOf(button.value) + button.value.length + 1)
            console.log(categorieStr)
        }
    })
})
range1.addEventListener("change",function(){
    prixMax.innerHTML = range1.value
})
range2.addEventListener("change",function(){
    prixMin.innerHTML = range2.value
})
marqueLinks.forEach(button=>{
    button.addEventListener("click",function(){
        if(!button.checked){
            marqueStr += button.value + "$"
            console.log(marqueStr)
        }else{
            marqueStr = marqueStr.slice(0,marqueStr.indexOf(button.value)) + marqueStr.slice(marqueStr.indexOf(button.value) + button.value.length + 1)
            console.log(marqueStr)
        }
})
})






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





