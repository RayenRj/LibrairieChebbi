<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librairie Chebbi</title>
    <link rel="icon" type="image/png" href="../assets/images/logo/logo1.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link rel="stylesheet" href="../assets/css/signin.css">
</head>
<body>

    <!--start of partie header-->
    <header>
        <div class="left-part">
            <div class="logo">
                <img src="../assets/images/logo/logo2.png"  alt="logo">
            </div>
            <div class="categories">
                <button>📦 Categories ▾ </button>
                <ul class="dropdown-menu">
                    <li><a href="">📚 Books</a></li>
                    <li><a href="">🎒 School Bags</a></li>
                    <li><a href="">✏️ Writing Tools</a></li>
                    <li><a href="">📐 Geometry Tools</a></li>
                    <li><a href="">🔮 Accessories</a></li>
                    <li><a href="">🛍️ All Products</a></li>
                    <li><a href="">🛍️ jouets</a></li>
                </ul>
            </div>
            <div class="search">
                <form action="" method="GET">
                    
                    <div class="input-container">
                        <span>🔍︎</span>
                        <input type="search" placeholder="Search school supplies..." id="search">
                    </div>
                </form>
            </div>
        </div>


        <div class="part-two">
            <ul>
                <li><a href="#" id="sign-in">Sign in</a></li>
                <li><a href="#" id="sign-up">Sign up</a></li>
                <li><a href="../pages/Panier.php" id="cart">🛒 cart<span class="cartCount">0</span></a></li>
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
                    <li><a href="">🛍️ <span>All Products</span></a></li>
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




    <!-- start of sign up part-->
    <div class="signup-part" hidden>
        <span class="before-signup"></span>
        <div class="signup">
            <div class="choose">
                <h1>Sign up</h1>
                <form action="">
                    <div class="name">
                        <input type="text" name="name" id="name" class="input">
                        <label for="">Name</label>
                    </div>
                    <div class="email">
                        <input type="email" name="email" class="input">
                        <label for="">Email</label>
                    </div>
                    <div class="password">
                        <input type="password" name="password" id="" class="input">
                        <label for="">Password</label>
                    </div>
                    <div class="button">
                        <input type="submit" value="Sign Up">
                    </div>
                    <p>Already have an account ? <a href="">Sign in</a></p>
                    <div class="line">
                        <hr>
                        <span>or</span>
                    </div>
                    <div class="signup-google">
                        <a href="">
                            <img src="../assets/images/google.png" alt="">
                            Sign up With Google</a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <!--end of signup-part-->




    <!-- partie sign in -->
    <div class="signin-part" hidden>
        <span class="before-signin"></span>
        <div class="signin">
            <div class="choose">
                <h1>Sign in</h1>
                <form action="">
                    <div class="email">
                        <input type="email" name="email" class="input">
                        <label for="">Email</label>
                    </div>
                    <div class="password">
                        <input type="password" name="password" id="" class="input">
                        <label for="">Password</label>
                    </div>
                    <div class="checkbox">
                        <input type="checkbox" name="keepLog" id="keepLog">
                        <label for="keepLog">Keep me logged in</label>
                    </div>
                    <div class="button">
                        <input type="submit" value="Sign In">
                    </div>
                    <p>don't have an account ? <a href="">Sign up</a></p>
                    <div class="line">
                        <hr>
                        <span>or</span>
                    </div>
                    <div class="signin-google">
                        <a href="">
                            <img src="../assets/images/google.png" alt="">
                            Sign in With Google</a>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <!--end of sign in part-->

    <script src="../assets/js/header_script.js"></script>
</body>
</html>