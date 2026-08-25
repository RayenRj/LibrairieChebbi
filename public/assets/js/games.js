let button = document.querySelectorAll(".button")
let genreList = document.querySelector("#genre");


// fazaaa hedhi bech tetzed barcha fl js -------------
let params = new URLSearchParams(window.location.search);
let genreVal = params.get("genre") ?? "";
genreList.value = genreVal



// changement de genre
genreList.addEventListener("change",function(){
    let genre = genreList.value
    console.log(genre)
    if(genre==""){
        window.location.search =""
        return;
    }
    window.location.search= `genre=${genre}`
    genreList.value = genre
})



button.forEach(button =>{
    button.addEventListener("click",function(event){
        event.preventDefault();
        let element = event.target == button.firstElementChild ? event.target.parentElement : event.target;
        console.log(element);
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
