
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/verifyEmail.css">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">
    <title>Librairie Chebbi | Vérification Email</title>
</head>

<body>
    <div class="verifyEmail">
        <form class="otp-Form" id="verificationForm">
        
            <span class="mainHeading">Enter OTP</span>
            <p class="otpSubheading">We have sent a verification code to your mobile number</p>
            <div class="inputContainer">
                <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input1" data-next="otp-input2">
                <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input2" data-next="otp-input3">
                <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input3" data-next="otp-input4">
                <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input4" data-next="otp-input5"> 
                <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input5" data-next="otp-input6"> 
                <input required="required" maxlength="1" type="text" class="otp-input" id="otp-input6">  
            </div>
            <button class="verifyButton" type="submit">Verify</button>
            <button class="exitBtn">×</button>
            <p class="resendNote">Didn't receive the code? <button class="resendBtn" id="resendCode">Resend Code</button></p>
                
        </form>

    </div>




<script src="/assets/js/verifyEmail.js"></script>
</body>

</html>

