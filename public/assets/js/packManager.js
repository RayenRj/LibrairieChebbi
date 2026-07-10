let addPackButton = document.querySelector("#addPack");
let addPackForm = document.querySelector(".addPackContainer");
let closeButton = document.querySelector("#closeButton")
let closeoverlay = document.querySelector(".popUpContainer .overlay")
let inputImage = document.querySelector("#file")
let inputFileContainer = document.querySelector(".custum-file-upload");
let resetButton =  document.querySelector("#reset");
let selectedArticleTable = document.querySelector(".articleSelectionne #addPackTable tbody")
let tbody = document.querySelector("#articleSelectionnéeTBody");
let packManagerContainerBody = document.querySelector(".pack-manager");
var limit = 8;
let tablePart = document.querySelector(".table-part")


///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////////// Reglage ll PopUp Card Dimension ///////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
function reglageHeightOverlay(){
    var popUpHeight = addPackForm.getBoundingClientRect().height;  
    packManagerContainerBody.style.height = (popUpHeight - 80).toString() + "px" ;
    packManagerContainerBody.style.overflow="hidden";

}



///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////// table row of the first table in the add pack pop up card ///////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////

let firstTablePopUpCard = document.querySelector("#firstTablePopUpCard")
addPackButton.addEventListener("click",async function(){
    addPackForm.removeAttribute("hidden");
    remplirTableDataFromDB(1,limit);
})

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////// partie close lel pop up : overlay + button  ////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
closeButton.addEventListener("click",function(){
    addPackForm.setAttribute("hidden","");
    inputFileContainer.style.backgroundImage = ``;
    inputFileContainer.style.backgroundSize = ``;
    inputFileContainer.style.backgroundRepeat = ``;
    inputFileContainer.style.backgroundPosition = ``;
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
    packManagerContainerBody.style.height = "";
    packManagerContainerBody.style.overflow ="";
})
closeoverlay.addEventListener("click",function(){
    addPackForm.setAttribute("hidden","");
    inputFileContainer.style.backgroundImage = ``;
    inputFileContainer.style.backgroundSize = ``;
    inputFileContainer.style.backgroundRepeat = ``;
    inputFileContainer.style.backgroundPosition = ``;
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
    packManagerContainerBody.style.height = "";
    packManagerContainerBody.style.overflow ="";
})

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////// partie image fl form ta3 pop up ////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
inputImage.addEventListener("change",function(){
    let file = this.files[0];
    if(file){
        let reader = new FileReader();
        reader.onload = function(e){
            inputFileContainer.style.backgroundImage = `url(${e.target.result})`;
            inputFileContainer.style.backgroundSize = `contain`;
            inputFileContainer.style.backgroundRepeat = `no-repeat`;
            inputFileContainer.style.backgroundPosition = `center`;
        }   
        reader.readAsDataURL(file);
        document.querySelector(".custum-file-upload .icon").style.opacity="0";
        document.querySelector(".custum-file-upload .text").style.opacity="0";
    }
});

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////// reglage ll button reset ////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
// reset button
resetButton.addEventListener("click",function(){
    inputFileContainer.style.backgroundImage = ``;
    inputFileContainer.style.backgroundSize = ``;
    inputFileContainer.style.backgroundRepeat = ``;
    inputFileContainer.style.backgroundPosition = ``;
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
    selectedArticleTable.innerHTML="";
});


///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////// Partie Submit ll form eli fl pop up ////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
let packFilterForm = document.querySelector("#packManagerForm")
packFilterForm.addEventListener("submit", async function(event){
    event.preventDefault();
    const formData = new FormData(packFilterForm);
    let str= "?";
    for(const [key , value] of formData){
        if(value !==""){str += `${key}=${value.trim()}&`;}
    }
    if(str !=="?"){str= str.slice(0,-1)}
    else{str=""}   
    window.location.href=`/dashboard/packs${str}`;
})

///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////// partie el add pack submit //////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////// 
let formAddPack = document.querySelector("#addPackForm");
formAddPack.addEventListener("submit",async function(event){
    event.preventDefault();
    let articleSelectionner = document.querySelectorAll(".articleSelectionner");
    if(articleSelectionner.length == 0){alert("le pack doit possédé des articles");}
    // creating a list of object that contains the selected articleId + quantity
    let articleList = [];
    articleSelectionner.forEach(article => {
        articleList.push({
            idProduit : article.dataset.idproduit ,
            quantity : article.dataset.quantity
        })
    })
    let formData = new FormData(formAddPack);
    formData.append("articleList", JSON.stringify(articleList));
    console.log(typeof(formData.get("articleList")))
    let response = await fetch("/api/packs/createPack",{
        method:"POST", 
        body:formData
    })

    let result = await response.json();
    if(result.success && result.data){
        window.location.reload();
        alert(result.message);
    }else{
        alert(result.message)
    }


})




//done : el partie hedhi responsable 3al delete ta3 el row ki tenzzel 3al button supprimé .
tbody.addEventListener("click", (event)=>{
    if(event.target.classList.contains("deleteProduct")){event.target.closest("tr").remove();}
})
//done : el parie hedhi ki tenzel 3al bouton confirmé tzidlk row fl table loutani
firstTablePopUpCard.addEventListener("click", function(event){
    if(event.target.classList.contains("confirmProduct")){
        event.preventDefault();
        let tr_destination = document.createElement("tr");
        
        tr_source = (event.target.parentElement).parentElement;
        let quantity = document.createElement("td");
        let button = document.createElement("button");
        let BUTTON_TD = document.createElement("td");
        for(let i = 0 ; i< tr_source.children.length -2 ; i++){
            tr_destination.append(tr_source.children[i].cloneNode(true))
        }

        quantity.innerText = tr_source.children[tr_source.children.length -2].children[0].value
        lastButtonValue = tr_source.children[tr_source.children.length -1].children[0].dataset.idproduit
        tr_destination.append(quantity);
        button.innerText = "Supprimée";
        button.classList.add("deleteProduct");
        button.setAttribute("type" ,"button");
        button.setAttribute("data-idproduit",lastButtonValue);
        BUTTON_TD.append(button);
        
        // reglage finale ll tr destination 
        tr_destination.classList.add("articleSelectionner")
        tr_destination.setAttribute("data-idproduit" , tr_source.children[tr_source.children.length -1].children[0].dataset.idproduit)
        tr_destination.setAttribute("data-quantity" , tr_source.children[tr_source.children.length -2].children[0].value)
        tr_destination.append(BUTTON_TD);

        tbody.append(tr_destination);
    }
})







/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////// partie eli feha affichage ll les article lors du click sur le bouton rechercher /////////////
/////////// function bech nesta3melha barcha marrat  ////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
async function remplirTableDataFromDB(current_page, limit){
    firstTablePopUpCard.innerHTML="";
    let formData = new FormData();
    formData.append("categorie", document.querySelector("#productCategorie").value);
    formData.append("libelle",document.querySelector("#productLibelle").value)
    formData.append("prixMax",document.querySelector("#productPrixMax").value)
    formData.append("prixMin",0)
    formData.append("stock",document.querySelector("#productStock").value)
    formData.append("trie",document.querySelector("#productTrie").value)
    formData.append("page",current_page)
    formData.append("limit",limit)

    let str="?";
    for(const[key,val] of formData){
        if(val!=="") str += `${key}=${val}&`;
    }
    str = str.slice(0,-1);

    let response = await fetch(`/api/articles/search${str}`)
    let result = await response.json();
    let nombre_totale_de_ligne_recherche = result.numberOfLine;
    let nombre_page_totale = Math.ceil(nombre_totale_de_ligne_recherche / limit)

    //remplissage du tableau avec data du database
    for(let i=0 ; i<result.data.length ; i++){
        let newRow = document.createElement("tr");
        let td1 = document.createElement("td")
        let td2 = document.createElement("td")
        let td3 = document.createElement("td")
        let td4 = document.createElement("td")
        let td5 = document.createElement("td")
        let td6 = document.createElement("td")
        let td7 = document.createElement("td")
        // Td1
        td1.innerHTML=`
            <img src="${result.data[i]["image_url"]}" alt="">
            <div class="text">
                <h4>${result.data[i]["libelle"]}</h4>
                    <p>${result.data[i]["description"]}</p>
            </div>`;
        // partie image taw narj3oulha ba3d
        // Td2
        td2.innerHTML = `<td>${result.data[i]["categorie"]}</td>`
        // Td3
        td3.innerHTML = `<td>${result.data[i]["marque"]}</td>`
        // Td4
        td4.innerHTML = `<td>${result.data[i]["prix_unitaire"]} DT</td>`
        // Td5
        td5.innerHTML = `<td>${result.data[i]["quantite_stock"]}</td>`
        // Td6
        td6.innerHTML = `<td><input type="number" name="" id="" value="1"></td>`
        // TD7
        td7.innerHTML = `<td><button class="confirmProduct" type="button" data-idproduit="${result.data[i]["id_produit"]}">Confirmé</button></td>`

        // appending all elements
        newRow.append(td1)
        newRow.append(td2)
        newRow.append(td3)
        newRow.append(td4)
        newRow.append(td5)
        newRow.append(td6)
        newRow.append(td7)
        firstTablePopUpCard.append(newRow);

       
        
    }
    //partie pagination
    let paginationContainer = document.querySelector(".popUpContainer .bottom .pagination");
    html =`<a href="" id="prev"><i class="fa-solid fa-angle-left"></i></a>`;
    for(let i = 1; i<= nombre_page_totale ; i++){ html += `<a href="" class="${i==current_page ? "pagination-selected" : ""}">${i}</a>`;}
    html += `<a href="" id="post"><i class="fa-solid fa-angle-right"></i></a>`;
    paginationContainer.innerHTML = html;

    // partie nzidou fl href ll lienet
    let liste_pagination_links =paginationContainer.children;
    for(let link of liste_pagination_links){
        link.addEventListener("click",function(event){
            event.preventDefault();
            page = event.target.innerText;
            remplirTableDataFromDB(page , limit)
        })
    }
    reglageHeightOverlay();
    
}


let buttonRechercher = document.querySelector("#bouttonRechercher");

buttonRechercher.addEventListener("click",function(event){
    firstTablePopUpCard.innerHTML="";
    let current_page = 1;
    let limit = 8;
    remplirTableDataFromDB(current_page , limit)
})



///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
////////////// Reglage ll boutton show packks   ///////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////
tablePart.addEventListener("click",function(event){
    console.log(event.target)
    if(event.target.classList.contains("showLink")){
        event.preventDefault()
        let idPack = event.target.dataset.idpack;
        window.location.href = `/packs/pack?idPack=${idPack}`;
    }
})