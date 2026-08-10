let addCartButtonList = document.querySelectorAll(".addCartButton");
let articleContainer = document.querySelector(".articles")
let emptyHeart = document.querySelectorAll(".fa-regular.fa-heart")
let categorieLinks = document.querySelectorAll(".list-categorie .checkBoxLabel input[type='checkbox']")
let marqueLinks = document.querySelectorAll(".list-marque .checkBoxLabel input[type='checkbox']")
let stock = document.querySelector("#stockCheck");
let range1 = document.querySelector("#range1")
let range2 = document.querySelector("#range2")
let prixMax = document.querySelector("#prixMax")
let prixMin = document.querySelector("#prixMin")
let buttonFiltrer = document.querySelector("#buttonFiltrer")
let searchForm = document.querySelector("#searchBar")
let selectTrie = document.querySelector("#trie")


selectTrie.addEventListener("change",()=>{
    let value = selectTrie.value;

    if(window.location.search.indexOf("trie") === -1){
        window.location.search =  `${window.location.search}&trie=${value}`;
    }else{
        console.log(`window.location.search.slice(0,window.location.search.indexOf("&trie="))}&trie=${value}`)
        window.location.search =  `${window.location.search.slice(0,window.location.search.indexOf("&trie="))}&trie=${value}`;
    }

})


searchForm.addEventListener("submit",function(event){
    event.preventDefault();
    console.log("submitted");
    let searchBar = document.querySelector("#searchBar #search");
    window.location.href=`/products?libelle=${searchBar.value.toLowerCase()}`
})

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

        }else{
            categorieStr = categorieStr.slice(0,categorieStr.indexOf(button.value)) + categorieStr.slice(categorieStr.indexOf(button.value) + button.value.length + 1)
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
        }
})
})

buttonFiltrer.addEventListener("click",function(event){
    let queryText="";
    if(marqueStr !== ""){
        queryText += `marque=${marqueStr.slice(0,-1)}&`;
        marqueStr="";
    }
    if(categorieStr !==""){
        queryText += `categorie=${categorieStr.slice(0,-1)}&`;
        categorieStr = "";
    }

    if(enStock){
        queryText += "stock=disponible&";
    }


    if(parseFloat(prixMax.textContent)!=0 && parseFloat(prixMin.textContent) !=0){
        max = Math.max(prixMax.textContent, prixMin.textContent);
        min = Math.min(prixMax.textContent, prixMin.textContent);
        queryText += `prixMax=${max}&prixMin=${min}&`;
    }else if(parseFloat(prixMax.textContent) !==0){queryText += `prixMax=${parseFloat(prixMax.textContent)}&`;}
    else if(parseFloat(prixMin.textContent) !=0){queryText += `prixMin=${parseFloat(prixMin.textContent)}&`}
    if(queryText) queryText = queryText.slice(0,-1);


    window.location.href=`/products?${queryText}`;
})

////////////////////////////////////
////////////////////////////////////
////////////////////////////////////



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
        localStorage.setItem(
            "cartTable",
            JSON.stringify(cartTable)
        )
    })
})

emptyHeart.forEach(heart =>{
    heart.addEventListener("mouseover", _ =>{
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





