<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/utilisateur.css">
</head>
<body>

    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div class="users">
        <div class="heading-text">


            <div>
                <H2>Admins <i class="fa-solid fa-user-group"></i></H2>
                <p>Gérez les admins de votre platforme</p>
            </div>

            
            <div>
                <div>
                    <input type="text" name="" id="" placeholder="Rechercher...">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <div>
                    <select name="" id="criteres">
                        <option value="">Email</option>
                        <option value="">ID</option>
                        <option value="">Nom</option>
                        <option value="">Prénom</option>
                    </select>
                    <!-- <i class="fa-solid fa-caret-down"></i> -->
                </div>
            </div>
        </div>


        <div class="table">
            <table>
                <thead>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>

                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>#USR-1001</td>
                        <td>Ben ali</td>
                        <td>Yassine</td>
                        <td>Yassine.benali@gmail.com</td>
                        <td>

                            <button><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        

        <div class="bottom-users">
            <p>Affichage de 1 à 6 sur 125 Admins</p>
            <div class="pagination">
                <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                <a href="#" class="pagination-selected">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#" id="three-dots">...</a>
                <a href="#" id="post"><i class="fa-solid fa-angle-right"></i></a>
            </div>
        </div>
    </div>
</body>
</html>