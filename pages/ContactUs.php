<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/contactUs.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">

</head>
<body>
    <?php include("../includes/header.php"); ?>

    <h1 class="first-header">Get in <span>Touch</span></h1>
    <main class="contact">
        <div class="first-part">
            <h2>Send a Message</h2>
            <form action="">
                <div class="double">
                    <div>
                        <label for="">Nom</label>
                        <input type="text" name="firstName" id="" placeholder="Entrer votre nom">
                    </div>
                    <div>
                        <label for="">Prénom</label>
                        <input type="text" name="lastName" id="" placeholder="Entrer votre prénom">
                    </div>
                </div>
                <div class="double">
                    <div>
                        <label for="">Email</label>
                        <input type="email" name="email" id="" placeholder="example@gmail.com">
                    </div>
                    <div>
                        <label for="">Mobile</label>
                        <input type="tel" name="lastName" id="" placeholder="+216 0000 0000">
                    </div>
                </div>
                <div class="message">
                    <label for="">Message</label>
                    <textarea name="" cols="30" rows="10" id="" placeholder="Write your message here ..."></textarea>
                </div>
                <div class="buttons">
                    <button type="submit">
                        <i class="fa-solid fa-paper-plane"></i>
                        Envoyer
                    </button>
                    <button type="reset">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                        Reset
                    </button>
                </div>
            </form>
        </div>

        <div class="second-part">
            <div class="card-one">
                <h3>Contact Info</h3>

                <ul class="contact-info">
                    <li>
                        <div class="icons">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <p>Localisation</p>
                    </li>
                    <li>
                        <div class="icons">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <p>librairiechebbi4@gmail.com</p>
                    </li>
                    <li>
                        <div class="icons">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <p>+216 50559320</p>
                    </li>
                </ul>


                <div class="social-media">
                    <ul>
                        <a href="https://www.facebook.com/profile.php?id=61564376203054"><li><i class="fa-brands fa-facebook"></i></li></a>
                        <a href=""><li><i class="fa-brands fa-instagram"></i></li></a>
                        <a href=""><li><i class="fa-brands fa-whatsapp"></i></li></a>

                    </ul>
                </div>
            </div>

            <div class="card-two">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12789.19938733625!2d10.246275277256077!3d36.73937321923667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12fd3700596a85b7%3A0xa0a7f7fa5a05f303!2sLibrairie%20Chebbi!5e0!3m2!1sfr!2stn!4v1781240355181!5m2!1sfr!2stn" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </main>

    <div class="dernier-part">
        <div class="text">
            <i class="fa-regular fa-envelope"></i>
            <div>
                <h2>Ne manquez aucune promotion !</h2>
                <p>Recevez nos nouveautés et offres spéciales directement dans votre boite mail.</p>
            </div>
        </div>
        <form action="">
            <input type="email" placeholder="Votre email">
            <input type="submit" value="S'abonner">
        </form>
    </div>


    <?php include("../includes/footer.php"); ?>
</body>
</html>