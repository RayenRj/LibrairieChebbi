

const form = document.getElementById("verificationForm");
const message = document.getElementById("message");
let otpInput = document.querySelectorAll(".otp-input")



const resendButton = document.getElementById("resendCode");
const resendMessage = document.getElementById("resendMessage");

resendButton.addEventListener("click", async function () {

    resendButton.disabled = true;

    try {

        const response = await fetch(
            "/api/users/resend-code",
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                }
            }
        );

        const result = await response.json();

        // resendMessage.textContent = result.message;

    } catch (error) {

        console.error(error);

        // resendMessage.textContent =
        //     "Une erreur est survenue.";

    }

    // Réactiver après 30 secondes
    setTimeout(() => {
        resendButton.disabled = false;
    }, 30000);
});



otpInput.forEach((input,index) =>{

    input.addEventListener("input",function(){
        if(input.value.length == 1 && index < otpInput.length -1){
            otpInput[index  +1 ].focus();
        }
    })

    input.addEventListener("keydown",(e)=>{
        if(e.key=="Backspace" && input.value == "" && index > 0){
            otpInput[index - 1].focus();
        }
    });

});




form.addEventListener("submit", async function(event) {
event.preventDefault();
let code = "";
otpInput.forEach(input=>{
    code += input.value.trim()
})
code = code.trim();
try {
    const response = await fetch("/api/users/verify-email",{
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify({verificationCode: code})});

    const result = await response.json();
    if(result.success){window.location.href = "/products";}
}catch (error) {
    // message.textContent = "Une erreur est survenue.";
    console.log("Une erreur est survenue.")
}});
