
function getLocalStorageArticlesList(){
    let cartTableString = localStorage.getItem("cartTable");
    var cartTable = [];
    if(cartTableString !== null){cartTable = JSON.parse(cartTableString)}
    return cartTable
}

var table = getLocalStorageArticlesList();
async function getPrix(idproduit){
    let response = await fetch(`/api/products/${idproduit}`)
    let result = await response.json();
    return result.data["prix"];
}
async function getRemise(idproduit){
    let response = await fetch(`/api/products/${idproduit}`)
    let result = await response.json();
  
    return result.data["remise"] || 0;
}

async function calcTotaleCart(table){
    let s = 0;
    for(let i =0; i< table.length ; i++){
        s += parseFloat(await (getPrix(table[i].idproduit))) - parseFloat(await getRemise(table[i].idproduit)) * table[i].quantity;
    }
    return s;
}

(async function(){
  let cartCount = table.length;
  let cartTotal = await calcTotaleCart(table);

  const region = document.getElementById('toast-region');


  function showAddedToCartToast({ name, price }){
    cartCount += 1;
    cartTotal += price;

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
      <div class="toast-perf"></div>
      <div class="toast-body">
        <span class="stamp">Ajouté ✓</span>
        <div class="toast-top">
          <div>
            <div class="toast-eyebrow">Ajouté au panier</div>
            <div class="toast-title">${name}</div>
            <div class="toast-detail">${price.toFixed(3)} DT · qté 1</div>
          </div>
        </div>
        <div class="toast-footer">
          <div class="toast-total">Panier : <b>${cartCount} art. · ${cartTotal.toFixed(3)} DT</b></div>
          <button class="toast-cta" type="button">Voir le panier</button>
        </div>
        <button class="toast-close" aria-label="Fermer" type="button">&times;</button>
      </div>
    `;

    region.appendChild(toast);
    requestAnimationFrame(() => requestAnimationFrame(() => toast.classList.add('show')));
    document.querySelector(".toast-cta").addEventListener("click",function(event){
        event.preventDefault()
        window.location.href = "/panier"
    })

    function dismiss(){
      toast.classList.remove('show');
      toast.classList.add('hide');
      setTimeout(() => toast.remove(), 380);
    }

    const timer = setTimeout(dismiss, 3800);
    toast.querySelector('.toast-close').addEventListener('click', () => { clearTimeout(timer); dismiss(); });
    toast.querySelector('.toast-cta').addEventListener('click', () => { clearTimeout(timer); dismiss(); });
  }


  let allButtons = document.querySelectorAll(".addToCartBtn")
    allButtons.forEach(button =>{
        button.addEventListener('click', () => {
        showAddedToCartToast({
            name: button.dataset.name,
            price: parseFloat(button.dataset.price)
        });
        });
})})();

