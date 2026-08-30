<?php 
    require_once(__DIR__ . "/../backend/services/ClientServices.php");
    $client_services = new ClientServices();

    $limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 10;
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
    $list_admin = $client_services->getAllAdmins($limit,$page) ?? [];
    $nombre_totale_list_admin = $client_services->nombreLigneAllAdmin() ?? 0;

    $nombre_page_totale = intval(ceil($nombre_totale_list_admin / $limit));

    // liste de query
    $query_array= [];
    foreach($_GET as $key=>$val){$query_array[] = "$key=$val";} 
    $query_string = implode("&", $query_array) ?? "";
    

    if(!isset($_SESSION["role"]) || $_SESSION["role"]!="admin"):
        header("Location: /main");
    else:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admins | Librairie Chebbi</title>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    />
    <link rel="stylesheet" href="../assets/css/utilisateur.css">
    <link rel="icon" type="image/png" href="/assets/images/logo/logo1.png">

</head>
<body>

    <?php include("../includes/header.php"); ?>
    <?php include("../includes/sidebar.php"); ?>

    <div class="users">
        <div class="heading-text">


            <div>
                <H2>Admins 🧑‍💼</H2>
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
                    <th>Tel</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    <?php foreach($list_admin as $admin): ?>
                    <tr>
                        <td><?= $admin["id_client"] ?></td>
                        <td><?= $admin["nom"] ?></td>
                        <td><?= $admin["prenom"] ?></td>
                        <td><?= $admin["tel"] ?></td>
                        <td><?= $admin["email"] ?></td>
                        <td>
                            <button data-idadmin="<?= $admin["id_client"] ?>" class="deleteAdminButton">
                                <i class="fa-solid fa-trash-can" data-idadmin="<?= $admin["id_client"] ?>" class="deleteAdminButton"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
           
        </div>
        

        <!-- el partie eli feha el pagination -->
        <div class="bottom bottom-users">
            <p>Affichage de <?php echo($nombre_totale_list_admin == 0 ? 0 : (($page - 1) * $limit ) +1);  ?> à <?= min($page * $limit  , $nombre_totale_list_admin) ?> sur <?= $nombre_totale_list_admin ?> admins</p>
            <div class="pagination">
                <!-- before -->
                <?php if($page > 1) : ?>
                    <a  href="/dashboard/admins?page=<?= $page - 1 ?>#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                <?php else : ?>
                    <a href="#" id="prev"><i class="fa-solid fa-angle-left"></i></a>
                <?php endif; ?>


                <?php if($page> 3):?>
                    <a href="#" id="three-dots">...</a>
                <?php endif; ?>


                <?php for($i=max(1 , $page - 2) ; $i < $page ; $i++):?>
                    <a href="/dashboard/admins?page=<?= $i ?>#"><?= $i ?></a>
                <?php endfor; ?>

                <!-- current page -->
                <a href="#" class="pagination-selected"><?= $page ?></a>
                <?php for($i=$page +1  ; $i <= min($page + 2 , $nombre_page_totale) ; $i++):?>
                    <a href="/dashboard/admins?page=<?= $i ?>#"><?= $i ?></a>
                <?php endfor; ?> 
                                    
                            
                <?php if(($nombre_page_totale - $page)> 2): ?>
                    <a href="#" id="three-dots" data-value = <?= $i ?>>...</a>
                <?php endif; ?>

                <!-- after -->
                <?php if($page < $nombre_page_totale) : ?>
                    <a href="/dashboard/admins?page=<?= $page + 1 ?>#" id="post"><i class="fa-solid fa-angle-right"></i></a>
                <?php else : ?>
                    <a href="#formFiltrage" id="post"><i class="fa-solid fa-angle-right"></i></a>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="/assets/js/admin.js"></script>
</body>
</html>

<?php endif;?>