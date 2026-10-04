let deleteAdminButtonList = document.querySelectorAll(".deleteAdminButton") ?? [];


// reglage ll toast
document.addEventListener('DOMContentLoaded', () => {
    const toast = sessionStorage.getItem('showToast');

    if (toast) {
        sessionStorage.removeItem('showToast');
        showToast(toast);
    }
});
// fin de reglage ll toast

deleteAdminButtonList.forEach(button =>{
    button.addEventListener("click",async function(){
        let idAdmin = button.dataset.idadmin;
        let response = await fetch(`/api/users/deletAdmin/${idAdmin}`,{
            method: "PATCH",
            body:{}
        }) 
        let result = await response.json();
        if(result.success && result.data){
            sessionStorage.setItem('showToast', 'adminDeleted');
            window.location.reload();
        }
        else{alert(response.message);}  
    })
})