
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librairie Chebbi</title>
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/signup.css">
    <link rel="stylesheet" href="/assets/css/signin.css">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">
</head>
<body>
    
    <!-- ######################################### -->
    <!-- ######################################### -->
    <!-- ######## start of partie header #########-->
    <!-- ######################################### -->
    <!-- ######################################### -->
    <header>
        <div class="left-part">
            <div class="logo">
                <img src="/assets/images/logo/logo2.png"  alt="logo">
            </div>  
            <div class="categories">
                <button>📦 Categories ▾</button>
                <ul class="dropdown-menu">
                    <li><a href="/main">⭐ <span>main</span></a></li>
                    <li><a href="/products">🛍️ <span>All Products</span></a></li>
                    <li><a href="/packs">📦 <span>Nos Packs</span></a></li>
                    <li><a href="/packs/livres">📚 <span>Livres</span></a></li>
                    <li><a href="/packs/livres/parascolaire">📚 <span>Parascolaires</span></a></li>
                    <li><a href="/collections">🎒 <span>School Bags</span></a></li>
                    <li><a href="/products">✏️ <span>Writing Tools</span></a></li>
                    <li><a href="/products">📐 <span>Geometry Tools</span></a></li>
                    <li><a href="/games">🧸 <span>jouets</span></a></li>
                    <li><a href="/products">🔮 <span>Autres Accessories</span></a></li>
                </ul>
            </div>
            <div class="search">
                <form action="" method="GET" id="searchBar">
                    <div class="input-container">
                        <span>🔍︎</span>
                        <input type="search" placeholder="Search school supplies..." id="search">
                    </div>
                </form>
            </div>
        </div>


        <div class="part-two">
            <ul>
                <li <?= isset($_SESSION["userId"]) ? "hidden" : "" ?>><a href="#" id="sign-in" >Sign in</a></li>
                <li <?= isset($_SESSION["userId"]) ? "hidden" : "" ?>><a href="#" id="sign-up">Sign up</a></li>
                <li <?= !isset($_SESSION["userId"]) ? "hidden" : "" ?>><a href="#" id="log_out" ><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a></li>
                <li <?= (!isset($_SESSION["userId"]) || !isset($_SESSION["role"]) || !($_SESSION["role"]=="admin")) ? "hidden" : "" ?>   ><a href="/dashboard" id="admin_part">📊 Dashboard</a></li>
                <li <?= !isset($_SESSION["userId"]) ? "hidden" : "" ?>><a href="/client" id="profile" ><i class="fa-solid fa-user"></i> Profile</a></li>
                <li><a href="/panier" id="cart">🛒 cart<span class="cartCount">0</span></a></li>
            </ul>
        </div>
        <i class="fa-solid fa-bars"></i>
        <div class="responsive">
            
            
            <i class="fa-solid fa-x"></i>
            <div class="list">
                <ul>
                    <li><a href="">📚 <span>Books</span></a></li>
                    <li><a href="">🎒 <span>School Bags</span></a></li>
                    <li><a href="">✏️ <span>Writing Tools</span></a></li>
                    <li><a href="">📐 <span>Geometry Tools</span></a></li>
                    <li><a href="">🔮 <span>Accessories</span></a></li>
                    <li><a href="">🛍️ <span>All products</span></a></li>
                    <li><a href="">🛍️ <span>jouets</span></a></li>
                </ul>
            </div>
            <hr>
            <div class="button-list">
                <ul>
                    <li><a href="">Login</a></li>
                    <li><a href="">sign-up</a></li>
                    <li><a href="">Log out</a></li>
                </ul>
            </div>
        </div>
    </header>
    <!--end of partie header-->

    <!-- ######################################### -->
    <!-- ######################################### -->
    <!-- ######### start of sign up part #########-->
    <!-- ######################################### -->
    <!-- ######################################### -->
    <div class="signup-part" hidden>
        <span class="before-signup"></span>
        <div class="signup">
            <div class="choose">
                <h1>Sign Up</h1>
                <form action="<?= __DIR__ ?>/" method="POST" id="signUpForm">
                    <div class="name">
                        <input type="text" name="firstName" id="firstName" class="input" required>
                        <label for="firstName" class="inputLabel">Prénom</label>
                    </div>
                    <div class="name">
                        <input type="text" name="lastName" id="lastName" class="input" required>
                        <label for="lastName" class="inputLabel">Nom</label>
                    </div>
                    <div class="email">
                        <input type="email" name="email" id="EmailSignUp" class="input" required>
                        <label for="EmailSignUp" class="inputLabel">Email</label>
                    </div>
                    <div class="password">
                        <input type="password" name="password" id="PasswordSignUp" class="input" required>
                        <label for="PasswordSignUp" class="inputLabel">Password</label>
                    </div>
                    <div class="password">
                        <input type="text" name="tel" id="tel" class="input" required>
                        <label for="tel" class="inputLabel">Telephone</label>
                    </div>
                    <div class="button">
                        <input type="submit" value="Sign Up" id="signUpButton">
                    </div>
                    <p>Already have an account ? <a href="#" id="switchSignIn">Sign in</a></p>
                    <div class="line">
                        <hr>
                        <span>or</span>
                    </div>
                    <!-- <div class="signup-google">
                        <a href="">
                            <img src="../assets/images/google.png" alt="">
                            Sign up With Google</a>
                    </div> -->


                    <a href="">
                        <button class="buttonGoogle">
                            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262">
                                <path fill="#4285F4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"></path>
                                <path fill="#34A853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"></path>
                                <path fill="#FBBC05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"></path>
                                <path fill="#EB4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"></path>
                            </svg>
                            Continue with Google
                        </button>
                    </a>
                    
                </form>
            </div>
        </div>
        
    </div>
    <!--end of signup-part-->

    <!-- ######################################### -->
    <!-- ######################################### -->
    <!-- ####### start of partie sign in #########-->
    <!-- ######################################### -->
    <!-- ######################################### -->
    <div class="signin-part" hidden>
        <span class="before-signin"></span>
        <div class="signin">
            <div class="choose">
                <h1 class="header">Sign in</h1>
                <form id="signInForm">
                    <div class="email">
                        <input type="email" name="email" class="input" required id="email">
                        <label for="email" class="inputLabel">Email</label>
                    </div>
                    <div class="password">
                        <input type="password" name="password" id="password" class="input" required>
                        <label for="password" class="inputLabel">Password</label>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="keepLog" id="keepLog">
                        <label for="keepLog">Keep me logged in</label>
                    </div>
                    <div class="button">
                        <input type="submit" value="Sign In">
                    </div>
                    <p>don't have an account ? <a href="#" id="switchSignUp">Sign up</a></p>
                    <div class="line">
                        <hr>
                        <span>or</span>
                    </div>
                    <!-- <div class="signin-google">
                        <a href="">
                            <img src="../assets/images/google.png" alt="">
                            Sign in With Google</a>
                    </div> -->
                    <a href="/google-login">
                        <button class="buttonGoogle" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" viewBox="0 0 256 262">
                                <path fill="#4285F4" d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"></path>
                                <path fill="#34A853" d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"></path>
                                <path fill="#FBBC05" d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"></path>
                                <path fill="#EB4335" d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"></path>
                            </svg>
                            Continue with Google
                        </button>
                    </a>
    
                </form>
            </div>
        </div>
        
    </div>
    <!--end of sign in part-->
    <script src="/assets/js/header_script.js"></script>
    <script src="/assets/js/signUp.js"></script>
    <script src="/assets/js/signIn.js"></script>
</body>
</html>