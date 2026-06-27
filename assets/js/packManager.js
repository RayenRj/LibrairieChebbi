let addPackButton = document.querySelector("#addPack");
let addPackForm = document.querySelector(".addPackContainer");
let closeButton = document.querySelector("#closeButton")
let closeoverlay = document.querySelector(".popUpContainer .overlay")
let inputImage = document.querySelector("#file")
let inputFileContainer = document.querySelector(".custum-file-upload");
let resetButton =  document.querySelector("#reset");
let selectedArticleTable = document.querySelector(".articleSelectionne #addPackTable tbody")
addPackButton.addEventListener("click",function(){
    addPackForm.removeAttribute("hidden");
})
closeButton.addEventListener("click",function(){
    addPackForm.setAttribute("hidden","");
    inputFileContainer.style.backgroundImage = ``;
    inputFileContainer.style.backgroundSize = ``;
    inputFileContainer.style.backgroundRepeat = ``;
    inputFileContainer.style.backgroundPosition = ``;
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
})
closeoverlay.addEventListener("click",function(){
    addPackForm.setAttribute("hidden","");
    inputFileContainer.style.backgroundImage = ``;
    inputFileContainer.style.backgroundSize = ``;
    inputFileContainer.style.backgroundRepeat = ``;
    inputFileContainer.style.backgroundPosition = ``;
    document.querySelector(".custum-file-upload .icon").style.opacity="1";
    document.querySelector(".custum-file-upload .text").style.opacity="1";
})


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
