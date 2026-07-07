let close = document.querySelector(".dismiss.button");
let popup = document.querySelector("div.popup");
let confimerCommandeButton = document.querySelector(".btn-confirmation");
let cartCount = document.querySelector(".cartCount");




function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}
cartCount.textContent = getLocalStorageArticlesList().length ;




close.addEventListener("click",()=>{popup.setAttribute("hidden","");
    document.body.style.overflowY="scroll";
})
confimerCommandeButton.addEventListener("click",()=>{
    popup.removeAttribute("hidden");
    document.body.style.overflowY="hidden";

    localStorage.clear();
    cartCount.innerText=0;
})




window.addEventListener("load",async function(event){
    let articles= document.querySelector(".articles")
    let article_list = getLocalStorageArticlesList();
    console.log(article_list)


    for(article of article_list){
        let response = await fetch(`/api/products/${article.idproduit}`);
        let product = await response.json();
        product= product.data;
        articles.innerHTML += `
                            <article>
                                <div>
                                    <img src="${product.image_url}" alt="">
                                    <div class="txt">
                                        <p class="nom-produit">${product.libelle}</p>
                                        <p class="quantite">x${article.quantity}</p> <!-- from localStore -->
                                    </div>
                                </div>
                                <p class="prix">${product.prix * article.quantity} Dt</p>
                            </article>
        `;
    }

})