let confirmerButton = document.querySelectorAll(".confirmerButton");
let promotionForm = document.querySelector("#promotionForm");


// reglage ll toast
document.addEventListener('DOMContentLoaded', () => {
    const toast = sessionStorage.getItem('showToast');

    if (toast) {
        sessionStorage.removeItem('showToast');
        showToast(toast);
    }
});
// fin de reglage ll toast

confirmerButton.forEach(button=>{
    button.addEventListener("click",async function(event){
        event.preventDefault();
        let idproduit = button.dataset.idproduit;
        let inputValue = button.parentElement.previousElementSibling.children[0].value;
        if(inputValue==""){
            alert("Veuillez remplir le champ « Remise » avant de continuer.")
        }else{
            let response = await fetch("/api/articles/remise/" + idproduit , {
                method:"PATCH",
                body:JSON.stringify({
                    "remise": inputValue
                })
            })

            let result = await response.json();
            if(result.success && result.data){
                sessionStorage.setItem('showToast', 'promotionAdded');
                window.location.reload()
            }
            else{alert(result.message)}

        }
    })
})


promotionForm.addEventListener("submit",function(event){
    event.preventDefault();
    let formData = new FormData(promotionForm);
    let str= "?";
    for(const [key,val] of formData.entries()){
        if(val!=""){
            str += key + "=" + val + "&";
        }
    }
    if(str=="?"){window.location.href = "/dashboard/promotions"}
    else{window.location.href = `/dashboard/promotions${str.slice(0,-1)}`}
})