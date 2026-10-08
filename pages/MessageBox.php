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
    $limit = isset($_GET["limit"]) ? $_GET["limit"] : 5;

    
    $listeMessage = $client_services->getMessageList($firstName , $lastName , $email , $tel ,$statut ,$page , $limit);
    $listMessageLength = $client_services->getMessageListLength($firstName , $lastName , $email , $tel ,$statut);
    $nombreMessageNonLus = $client_services->nombreMessageNonLus();
    

    $selectedIndex =isset($_GET["selectedIndex"]) ? $_GET["selectedIndex"] : 0;
    if($listMessageLength >= 1 && $selectedIndex < $listMessageLength){
      $selectedMessage = $listeMessage[$selectedIndex];
    }
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
    <div class="counter">
      <?= $listMessageLength ?> messages
      <small><?= $nombreMessageNonLus ?> non lus</small>
    </div>
  </main>

  <form class="filters" onsubmit="return false">
    <label>Nom<input type="text" name="nom" placeholder="Nom client"></label>
    <label>Email<input type="email" name="email" placeholder="Email"></label>
    <label>Téléphone<input type="tel" name="tel" placeholder="Téléphone"></label>
    <label>Statut
      <select name="statut">
        <option value="">Tous</option>
        <option value="non lu">Non lus</option>
        <option value="lu">Lus</option>
      </select>
    </label>
    <button class="btn primary" type="submit">Filtrer</button>
    <button class="btn" type="reset">⟳ Réinitialiser</button>
  </form>

  <p class="count"><?= (($page -1) * $limit ) + 1 ?>– <?= min($listMessageLength , $page * $limit) ?> sur <?= $listMessageLength ?> messages</p>

  <div class="layout">
    <section class="list" id="list">
      <?php if($listMessageLength == 0): ?>
        <div class="empty">
            <p>Aucun message trouvé. <?= $listMessageLength ?></p>
        </div>
      <?php else: ?>

            <?php foreach($listeMessage as $index => $msg): ?>
              <!-- chaque message = un article -->
                <article class="msg <?= $msg["statut"]== "lu" ? "read" : "unread" ?> <?= $index == $selectedIndex ? "active" : "" ?>" data-idmessage="<?= $msg["id_message"]?>" data-index="<?= $index ?>">

                  <div class="avatar c<?= $index + 1 ?>">
                      <?= $msg["first_name"][0] . $msg["last_name"][0]?>
                  </div>

                  <div class="body">

                      <h3><?= $msg["first_name"] . " " . $msg["last_name"] ?></h3>

                      <p class="contact">
                          <?= $msg["email"] ?>· <?= $msg["tel"] ?>
                      </p>

                      <p class="excerpt">
                          <?= $msg["content"] ?>
                      </p>

                  </div>

                  <div class="side">

                      <div class="meta">

                          <span class="badge <?= $msg["statut"]== "lu" ? "lu" : "new" ?>">
                              <?= $msg["statut"]== "lu" ? "Lu" : "Nouveau" ?>
                          </span>

                          <span><?= $msg["date_envoie"] ?></span>

                      </div>

                      <button
                          
                          type="button"
                          class="view"
                          data-k="${originalIndex}"
                          data-idmessage=<?= $msg["id_message"]  ?>
                          data-index = <?= $index ?>
                      >
                          👁 Voir le message
                      </button>

                  </div>

              </article>
              
            <?php endforeach; ?>

          </section>
          
          <aside class="panel" id="panel">
                  <div class="panel-head"><h2>Message client</h2><button class="close" aria-label="Fermer">✕</button></div>
            <div class="person">
              <div class="avatar c<?= $selectedIndex+1 ?>" id="p-avatar">
                <?= $selectedMessage["first_name"][0] . $selectedMessage["last_name"][0]?>
              </div>
              <div><h3 id="p-name"><?= $selectedMessage["first_name"] . " " . $selectedMessage["last_name"]  ?></h3><p>✉ <span id="p-email"><?= $selectedMessage["email"] ?></span><br>📞 <span id="p-phone"><?= $selectedMessage["tel"] ?></span></p></div>
            </div>
            <p class="sent">📅 <span id="p-date">Envoyé Le <?= explode(" ",$selectedMessage["date_envoie"],2)[0]?> à <?= explode(" ",$selectedMessage["date_envoie"],2)[1]?></span></p>
            <div class="content" id="p-text">
              <?= $selectedMessage["content"] ?>
            </div>
            <div class="panel-foot" id="p-foot" >
              <span class="badge <?= $selectedMessage["statut"]== "lu" ? "lu" : "new" ?>" id="p-badge">
                <?= $selectedMessage["statut"]== "lu" ? "Lu" : "Nouveau" ?>
              </span>
              <button class="btn primary" id="p-btn" style="display: <?= $selectedMessage["statut"]=="lu" ? "none" : ""; ?>;"  data-idmessage=<?= $selectedMessage["id_message"]  ?>>✓ Marquer comme lu</button>
              
            </div>
          </aside>
      <?php endif; ?>
  </div>

  <nav class="pagination">
    <button>‹</button>
    <?php for($i= max($page -3 ,1) ; $i <= min($nombre_page_totale , $page +3); $i++): ?>
        <button class="<?= $i==$page ? "current": "" ?>"><?= $i ?></button>
    <?php endfor; ?>
    <button>›</button>



    <select id="limitSelection">
      <option value="5" <?=($limit == "5" ||$limit =="") ? "selected" : ""?>>5 messages par page</option>
      <option value="8" <?= $limit == "8" ? "selected" : ""?>>8 messages par page</option>
      <option value="10" <?= $limit == "10" ? "selected" : ""?>>10 messages par page</option>
      <option value="15" <?= $limit == "15" ? "selected" : ""?>>15 messages par page</option>
    </select>
  </nav>
</div>


<script src="/assets/js/messageBox.js"></script>
</body>
</html>


<?php endif; ?>