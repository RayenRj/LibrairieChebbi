let deleteAdminButtonList = document.querySelectorAll(".deleteAdminButton") ?? [];
console.log(deleteAdminButtonList)
deleteAdminButtonList.forEach(button =>{
    button.addEventListener("click",async function(){
        console.log("Hello")
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