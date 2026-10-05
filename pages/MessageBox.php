<?php
    require_once(__DIR__ . "/../backend/services/ClientServices.php");

    $client_services = new ClientServices();
    
    // url attr 
    $firstName = isset($_GET["nom"]) ? $_GET["nom"] : "";
    $lastName = isset($_GET["prenom"]) ? $_GET["prenom"] : "";
    $tel = isset($_GET["tel"]) ? $_GET["tel"] : "";
    $email = isset($_GET["email"]) ? $_GET["email"] : "";
    $statut = isset($_GET["statut"]) ? $_GET["statut"] : "";
    $page = isset($_GET["page"]) ? $_GET["page"] : 1;
    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 6;
    

    $listeMessage = $client_services->getMessageList($firstName , $lastName , $email , $tel ,$statut ,$page , $limit);
    $listMessageLength = $client_services->getMessageListLength($firstName , $lastName , $email , $tel ,$statut);
    
    $nombre_page_totale = intval(ceil($listMessageLength / $limit));

    $query_array= [];
    foreach($_GET as $key=>$val){
        if($key !== "page")
        $query_array[] = "$key=$val";
        
    } 
    $query_string = implode("&", $query_array) ?? "";
    // partie el add pack

    if(!isset($_SESSION["role"]) || $_SESSION["role"]!="admin"):
        header("Location: /main");
    else:

?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/assets/css/messageBox.css">
<title>Messages clients | Librairie Chebbi</title>

</head>
<body>
    <?php include(__DIR__ . "/../includes/header.php");
    include(__DIR__ . "/../includes/sidebar.php") ?>

<div class="pageMessageBox">

  <main class="messageBoxHeader">
    <div class="icon">💬</div>
    <div>
      <h1>Messages clients</h1>
      <p>Consultez les demandes et messages envoyés par vos clients</p>
    </div>
    <div class="counter">24 messages<small>5 non lus</small></div>
  </main>

  <form class="filters" onsubmit="return false">
    <label>Nom<input type="text" placeholder="Nom client"></label>
    <label>Email<input type="email" placeholder="Email"></label>
    <label>Téléphone<input type="tel" placeholder="Téléphone"></label>
    <label>Statut
      <select><option>Tous</option><option>Non lus</option><option>Lus</option></select>
    </label>
    <button class="btn primary" type="submit">Filtrer</button>
    <button class="btn" type="reset">⟳ Réinitialiser</button>
  </form>

  <p class="count">1–10 sur 24 messages</p>

  <div class="layout">
    <section class="list" id="list"></section>

    <aside class="panel" id="panel">
      <div class="panel-head"><h2>Message client</h2><button class="close" aria-label="Fermer">✕</button></div>
      <div class="person">
        <div class="avatar" id="p-avatar"></div>
        <div><h3 id="p-name"></h3><p>✉ <span id="p-email"></span><br>📞 <span id="p-phone"></span></p></div>
      </div>
      <p class="sent">📅 <span id="p-date"></span></p>
      <div class="content" id="p-text"></div>
      <div class="panel-foot" id="p-foot">
        <span class="badge" id="p-badge"></span>
        <button class="btn primary" id="p-btn">✓ Marquer comme lu</button>
      </div>
    </aside>
  </div>

  <nav class="pagination">
    <button>‹</button><button class="current">1</button><button>2</button><button>3</button>
    <button>4</button><button>5</button><span>…</span><button>12</button><button>›</button>
    <select><option>10 messages par page</option><option>25 messages par page</option></select>
  </nav>
</div>



<script src="/assets/js/messageBox.js"></script>
</body>
</html>


<?php endif; ?>