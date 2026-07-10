let articleList = document.querySelectorAll(".thirdCard label")
let deconnexion = document.querySelector(".logOut")
console.log(articleList)

articleList.forEach(label=>{
    label.addEventListener("click", (event)=>{
        label.classList.toggle("clicked")
        let arrowContainer = label.querySelector(".arrowContainer");
        if(label.classList.contains("clicked")){
            arrowContainer.innerHTML=`<i class="fa-solid fa-angle-down"></i>`
        }else{
            arrowContainer.innerHTML = `<i class="fa-solid fa-angle-right"></i>`
        }
    })
})

deconnexion.addEventListener("click",async function(event){
    event.preventDefault()
    let response = await fetch("/api/users/logout");
    let result = await response.json();
    if(result.success){
        window.location.href = "/main";
    }else{
        alert(result.message);
    }

})