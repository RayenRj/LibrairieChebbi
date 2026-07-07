<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/sidebar.css">
</head>
<body>
    <aside>
        <div>
            <h2>
                <i class="fa-solid fa-shield-halved"></i>
                ADMIN PANEL
            </h2>

            <ul>
                <a href="/dashboard">
                    <li>
                        <i class="fa-solid fa-chart-column"></i>
                        <p>Dashboard</p>
                    </li>
                </a>
                <a href="/dashboard/commandes">
                    <li>
                        <i class="fa-solid fa-cart-flatbed"></i>
                        <p>Commandes</p>
                    </li>
                </a>
                <a href="/dashboard/packs">
                    <li>
                        <i class="fa-solid fa-box-open"></i>
                        <p>Packs Manager</p>
                    </li>
                </a>
                <a href="/dashboard/articles">
                    <li>
                        <i class="fa-solid fa-cart-flatbed"></i>
                        <p>Articles Manager</p>
                    </li>
                </a>
                <a href="/dashboard/promotions">
                    <li>
                        <i class="fa-solid fa-tag"></i>
                        <p>Promotions</p>
                    </li>
                </a>
                <a href="/dashboard/clients">
                    <li>
                        <i class="fa-solid fa-user"></i>
                        <p>Utilisateurs</p>
                    </li>
                </a>
                <a href="/dashboard/admins">
                    <li>
                        <i class="fa-solid fa-user-shield"></i>
                        <p>Admins</p>
                    </li>
                </a>
                <a href="/main" id="deconnexion">
                    <li>
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <p>Déconnexion</p>
                    </li>
                </a>


            </ul>
        </div>

        <div class="admin-account">
            <!-- <img src="" alt=""> -->
            <div>
                <div class="icons">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="text">
                    <h4>Admin</h4>
                    <?php if(isset($_SESSION["lastName"]) && isset($_SESSION["firstName"])): ?>
                        <p><?= $_SESSION["lastName"] ?> <?= $_SESSION["firstName"] ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- <i class="fa-solid fa-angle-down"></i> -->
            <!-- <i class="fa-solid fa-caret-right"></i> -->
            <i class="fa-solid fa-angle-right"></i>
        </div>
    </aside>
</body>
</html>