let deleteAdminButtonList = document.querySelectorAll(".deleteAdminButton") ?? [];
deleteAdminButtonList.forEach(button =>{
    button.addEventListener("click",async function(){
        let idAdmin = button.dataset.idadmin;
        let response = await fetch(`/api/users/deletAdmin/${idAdmin}`,{
            method: "PATCH",
            body:{}
        }) 
        let result = await response.json();
        if(result.success && result.data){window.location.reload();}
        else{alert(response.message);}  
    })
})