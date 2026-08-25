let addButton = document.querySelectorAll(".price .button")
let typeList = document.querySelectorAll(".typeSac li")
let genderButtons = document.querySelectorAll(".gender-buttons button")

let url = new URLSearchParams(window.location.search);
let typeInUrl = url.get("type") ?? "";

addButton.forEach(button =>{
    button.addEventListener("click",function(event){
        event.preventDefault();
    })

    // fel refrech ta3 el page 

})


// adding element to the cart 
addButton.forEach(button => {
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


// end


// list
typeList.forEach(item =>{
    let value = item.dataset.value;
    item.addEventListener("click",function(event){
        event.preventDefault();
        let url = new URLSearchParams(window.location.search)
        if(value==""){
            url.delete("type");
        }else{
            url.set("type",value)
        }
        window.location.search= url.toString();
    })


    if(value==typeInUrl){item.children[0].classList.add("selected")}
    else{item.children[0].classList.remove("selected")}
})


// partie gender button
genderButtons.forEach(button=>{
    button.addEventListener("click",function(event){
        event.preventDefault();
        let data = button.dataset.value;
        //  dima fl search use urlSearchParams
        let url = new URLSearchParams(window.location.search)
        url.delete("page");
        if(data=="mixte"){url.delete("genre")}
        else{
            url.set("genre",data);
        }
        window.location.search = url.toString();
    })
})