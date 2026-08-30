let articleContainer = document.querySelector(".article")
let noArticleContainer = document.querySelector(".no-article")
let tbody = document.querySelector("#panierTableBody");
let passerCommande = document.querySelector(".passerCommande");

// Loading part script
// en tout début de fichier, avec vos autres let
const MIN_DURATION = 500;
const loaderStart = performance.now();

function finishLoader(){
    const loader = document.getElementById('page-loader');
    if(!loader) return;
    const elapsed = performance.now() - loaderStart;
    const wait = Math.max(0, MIN_DURATION - elapsed);
    setTimeout(() => loader.classList.add('done'), wait);
}
// end of loading part


function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}






window.addEventListener("load",async function(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){
        cartTable = JSON.parse(cartTableString)
        noArticleContainer.setAttribute("hidden","")
        articleContainer.removeAttribute("hidden")
    }else{
        articleContainer.setAttribute("hidden","")
        noArticleContainer.removeAttribute("hidden")
    }




    tbody.innerHTML = "";
    let totale = 0;




    for(article of cartTable){
        let response = await fetch(`/api/products/${article.idproduit}`);
        let result = await response.json();

        tbody.innerHTML += `
                    <tr>
                        <td>
                            <img class="img" height="100%" src="${result.data.image_url}" alt="">
                        </td>
                        <td>
                            <div class="description">
                                <p>${result.data.libelle}</p>
                            </div>
                        </td>
                        <td class="td-quantite">
                            <div>
                            <button class="minusQuantityButton">-</button>
                            <input type="number" data-idproduit="${result.data.id_produit}" class="quantiteInput"  value="${article.quantity}">
                            <button class="plusQuantityButton">+</button>
                            </div>
                        </td>
                        <td class="prixUnitaire">
                            <span class="prix-unitaire">${(parseFloat(result.data.prix) - parseFloat(result.data.remise)).toFixed(3)} Dt</span>
                        </td>
                        <td>
                            <span class="prix-totale">${(article.quantity * (result.data.prix - result.data.remise)).toFixed(3)} Dt</span>
                        </td>

                        <td class="td-delete">
                            <!-- delete button  -->
                            <button class="delete" data-idproduit="${result.data.id_produit}">
                                <svg viewBox="0 0 448 512" class="svgIcon"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"></path></svg>
                            </button>
                        </td>
                    </tr>
        `
        totale += article.quantity * (parseFloat(result.data.prix) - parseFloat(result.data.remise))
    }

    // let beforeLast_tr = `
    //                 <tr>
    //                     <td colspan="5"  class="total-payer">Total a payer</td>
    //                     <td id="totalAmount">${totale.toFixed(3)}dt</td>
    //                     <td></td>
    //                 </tr>
    let beforeLast_tr = `
                    <tr>
                        <td colspan="5"  class="total-payer">Total a payer:  <span id="totalAmount">${totale.toFixed(3)} Dt</span></td>
                        
                        <td></td>
                    </tr>
    `

    let last_tr = ` <tr class="last-tr">
                        <td colspan="7" >
                            <div class="button">
                        <!-- From Uiverse.io by carlosepcc --> 
                                    <a data-total="${totale}" class="passerCommande cursor-pointer transition-all bg-blue-500 text-white px-6 py-2 rounded-lg
                                    border-blue-600
                                    border-b-[4px] hover:brightness-110 hover:-translate-y-[1px] hover:border-b-[6px]
                                    active:border-b-[2px] active:brightness-90 active:translate-y-[2px] button-commande">
                                    passer la commande >>
                                    </a>
                            </div>
                        </td>
                    </tr> `;
                    
    if(cartTable.length !==0){
        tbody.innerHTML += beforeLast_tr
        tbody.innerHTML += last_tr

    }else{
        articleContainer.setAttribute("hidden","")
        noArticleContainer.removeAttribute("hidden")
    }


    finishLoader()   // <-- ajouté ici

})



// shop now button when the cart is empty
let shopNowButton = document.querySelector(".shopNow");
shopNowButton.addEventListener("click",function(){
    window.location.href="/products"
})

// buttons of quantity
let plusQuantityButtonList = document.querySelectorAll(".plusQuantityButton");
let minusQuantityButtonList = document.querySelectorAll(".minusQuantityButton");


tbody.addEventListener("click",async function(event){
    if(event.target.classList.contains("plusQuantityButton")){
        let prixUnitaire = event.target.parentElement.parentElement.nextElementSibling.firstElementChild;
        let totalAmount = event.target.parentElement.parentElement.nextElementSibling.nextElementSibling.firstElementChild;
        let globalTotalAmount = document.querySelector("#totalAmount");
        event.preventDefault();
        let quantity = event.target.previousElementSibling
        let idProduit = quantity.dataset.idproduit
        quantity.value = parseInt(quantity.value) + 1
        let productList = getLocalStorageArticlesList()
        totalAmount.innerHTML = ((quantity.value) * parseFloat(prixUnitaire.textContent)).toFixed(3) + " Dt"
        globalTotalAmount.innerHTML = ((parseFloat(globalTotalAmount.innerHTML) + parseFloat(prixUnitaire.textContent))).toFixed(3) + " Dt"
        document.querySelector(".passerCommande").dataset.total = parseFloat(globalTotalAmount.innerHTML);



        for(let i=0 ; i < productList.length ; i++){
            if(productList[i].idproduit == idProduit){
                productList[i].quantity = quantity.value;
            }
        }
        localStorage.setItem("cartTable", JSON.stringify(productList))
    }   


    if(event.target.classList.contains("minusQuantityButton")){
        let prixUnitaire = event.target.parentElement.parentElement.nextElementSibling.firstElementChild;
        let totalAmount = event.target.parentElement.parentElement.nextElementSibling.nextElementSibling.firstElementChild;
        let globalTotalAmount = document.querySelector("#totalAmount");
        event.preventDefault();

        let quantity = event.target.nextElementSibling
        let idProduit = quantity.dataset.idproduit

        if(quantity.value > 1){
            quantity.value = parseInt(quantity.value) - 1
            totalAmount.innerHTML = ((quantity.value) * parseFloat(prixUnitaire.textContent)).toFixed(3) + " Dt"
            globalTotalAmount.innerHTML = (parseFloat(globalTotalAmount.innerHTML) - parseFloat(prixUnitaire.textContent)).toFixed(3) + " Dt"
            document.querySelector(".passerCommande").dataset.total = parseFloat(globalTotalAmount.innerHTML);
            let productList = getLocalStorageArticlesList()
            for(let i=0 ; i < productList.length ; i++){
                if(productList[i].idproduit == idProduit){
                    productList[i].quantity = quantity.value;
                }
            }
            localStorage.setItem("cartTable", JSON.stringify(productList))
        }

    } 
    
    

    if(event.target.classList.contains("delete") || event.target.parentElement.classList.contains("delete") ||event.target.parentElement.parentElement.classList.contains("delete")  ){
        let element = event.target.classList.contains("delete") ? event.target : event.target.parentElement.classList.contains("delete") ?  event.target.parentElement : event.target.parentElement.parentElement;
        let globalTotalAmount = document.querySelector("#totalAmount");
        let totalAmount = parseFloat(element.parentElement.previousElementSibling.firstElementChild.textContent);
        globalTotalAmount.innerHTML = (parseFloat(globalTotalAmount.innerHTML) - totalAmount).toFixed(3) + " Dt"
        document.querySelector(".passerCommande").dataset.total = parseFloat(globalTotalAmount.innerHTML);
        event.preventDefault();

        cartCount.textContent = parseInt(cartCount.textContent) - 1
        let idProduct= element.dataset.idproduit;
        let productList = getLocalStorageArticlesList()
        productList = productList.filter(product => product.idproduit !== idProduct);
        localStorage.setItem("cartTable",JSON.stringify(productList))
        element.parentElement.parentElement.remove();
        let tbody = document.querySelector("#panierTableBody");
        if(tbody.children.length==2){
            articleContainer.setAttribute("hidden","")
            noArticleContainer.removeAttribute("hidden")
        }

    }

    // passer commande button
    if(event.target.classList.contains("passerCommande")){
        event.preventDefault()
        let total = parseFloat(event.target.dataset.total).toFixed(3)
        let result = await fetch("/api/users/isClientLoggedIn");
        let response = await result.json();
        if(response.success && response.data){
            window.location.href = `/commande?total=${total}`;
        }else if(response.success && !response.data){
            SignInCard.removeAttribute("hidden");
            SignInCard.style.top =window.scrollY + "px";
            body.style.maxHeight= "100vdh";
            body.style.overflow="hidden";
        }else{alert(response.message);}
    }
})




