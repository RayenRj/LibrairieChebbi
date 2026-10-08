let pageMessageBox = document.querySelector(".pageMessageBox");
let filterForm = pageMessageBox.querySelector(".filters");
let closeButton = pageMessageBox.querySelector(".close");
let list_one = pageMessageBox.querySelector("#list");
let panel = pageMessageBox.querySelector("#panel");

let searchInput = pageMessageBox.querySelector('.filters input[type="search"]');
let nomInput = pageMessageBox.querySelector('.filters input[placeholder="Nom client"]');
let emailInput = pageMessageBox.querySelector('.filters input[type="email"]');
let phoneInput = pageMessageBox.querySelector('.filters input[type="tel"]');
let statusSelect = pageMessageBox.querySelector(".filters select");
let countElement = pageMessageBox.querySelector(".count");
let counter = pageMessageBox.querySelector(".counter");
let pagination = pageMessageBox.querySelector(".pagination");
let messagesPerPageSelect = pagination.querySelector("select#limitSelection");
let current = 0;


/* =========================================================
COUNTERS ELI MEL fou9
========================================================= */

function updateCounters() {
    let total = messages.length;
    let unread = messages.filter(
        message => message.unread
    ).length;
    counter.innerHTML = `
        ${total} messages
        <small>${unread} non lus</small>
    `;
    countElement.textContent =
        `1–${Math.min(10, filteredMessages.length)} sur ${filteredMessages.length} messages`;
}
/* =========================================================
   SELECT MESSAGE
========================================================= */
// yab9a <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
function selectMessage(idmessage,index){
    if(idmessage<=0) return;
    if(document.querySelector("article.active")){
        document.querySelector("article.active").classList.toggle("active");
    }

    document.querySelector(`article[data-idmessage='${idmessage}'`).classList.toggle("active");
    current = idmessage;
    renderPanel(idmessage, index);
}

/* =========================================================
   CLICK ON MESSAGE LIST
========================================================= */
// yab9a <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
list_one.addEventListener("click", function (event) {

    let button = event.target.closest(".view");

    if (button){
        let idmessage = Number(button.dataset.idmessage);
        let index = Number(button.dataset.index);
        selectMessage(idmessage,index);
        return;
    }
    
    let message = event.target.closest(".msg");
    if (message) {
        let idmessage = Number(message.dataset.idmessage);
        let index = Number(message.dataset.index); 
        selectMessage(idmessage,index);
    }

});



/* =========================================================
   RENDER DETAIL PANEL : Reglééééé
========================================================= */
async function renderPanel(idmessage,index) {
    let apiCall = await fetch("/api/client/message/" + idmessage );
    let apiResponse = await apiCall.json();
    if (!apiResponse.success) {
        panel.style.display = "none";
        return;
    }
    apiResponse = apiResponse.data;
    panel.style.display = "";

    let avatar = pageMessageBox.querySelector("#p-avatar");
    let name = pageMessageBox.querySelector("#p-name");
    let email = pageMessageBox.querySelector("#p-email");
    let phone = pageMessageBox.querySelector("#p-phone");
    let date = pageMessageBox.querySelector("#p-date");
    let text = pageMessageBox.querySelector("#p-text");
    let badge = pageMessageBox.querySelector("#p-badge");
    let button = pageMessageBox.querySelector("#p-btn");
    let footer = pageMessageBox.querySelector("#p-foot");

    // color
    avatar.className = "avatar c" + (idmessage % 6);
    avatar.textContent = apiResponse["first_name"][0] +  apiResponse["first_name"][1];

    name.textContent = apiResponse["first_name"] + " " +  apiResponse["last_name"];

    email.textContent = apiResponse["email"];

    phone.textContent = apiResponse["tel"];

    date.textContent = "Envoyé le " + apiResponse["date_envoie"];

    text.textContent = apiResponse["content"];

    badge.className =
        "badge " + (apiResponse["statut"]== "non lu" ? "new" : "lu");

    badge.textContent =
        apiResponse["statut"] == "non lu"  ? "Nouveau" : "Lu";


    button.dataset.idmessage=apiResponse["id_message"];
    button.dataset.index=index;
    button.style.display = apiResponse["statut"] == "non lu"  ?  "" : "none";


    footer.classList.toggle(
        "is-read",
        !apiResponse["statut"] == "non lu"
    );
}


/* =========================================================
   MARK AS READ
========================================================= */
if(pageMessageBox.querySelector("#p-btn")){
pageMessageBox
    .querySelector("#p-btn")
    .addEventListener("click", async function (event) {

        let idmessage = Number(event.target.dataset.idmessage);
        let index = Number(event.target.dataset.index)
        if (!idmessage) return;

        let apiCall = await fetch("/api/client/messages/marquerlu/" + idmessage,{method:"POST"});
        let apiResponse = await apiCall.json();

        if(apiResponse.success){
            let url = new URLSearchParams(window.location.search);
            url.set("selectedIndex",index);
            window.location.search = url.toString();
            // window.location.reload();
        }else{
            alert(apiResponse.message)
        }

    });
}

/* =========================================================
   CLOSE PANEL : REGLEEEEEEEE
========================================================= */

if(closeButton){
    closeButton.addEventListener("click", function () { panel.style.display = "none"; });
}


/* =========================================================
   SEARCH / FILTER
========================================================= */

filterForm.addEventListener("submit", function (event) {

    event.preventDefault();
    let UrlParser = new URLSearchParams(window.location.search);

    let formData = new FormData(filterForm);
    for(let [key , val] of formData.entries()){
        if(val=="") continue;
        if(key == "nom"){

            if(val.indexOf(" ") != -1){
                let firstName = val.substring(0,val.indexOf(" "))
                let lastName = val.substring(val.indexOf(" ") + 1);
                UrlParser.set("nom" , firstName);
                UrlParser.set("prenom", lastName);
                continue;
            }else{
                UrlParser.delete("prenom");
            }
        }


        UrlParser.set(key , val);

    }
    window.location.search = UrlParser.toString();
});

/* =========================================================
   RESET FILTERS
========================================================= */

filterForm.addEventListener("reset", function () {
    window.location.search = ""
});


/* =========================================================
   PAGINATION BUTTONS
========================================================= */

pagination.addEventListener("click", function (event) {

    let button =
        event.target.closest("button");
    if (!button) return;
    let buttons =
        [...pagination.querySelectorAll("button")];

    let currentButton =
        pagination.querySelector("button.current");

    let currentPage =
        Number(currentButton?.textContent) || 1;


    /* Previous */

    if (button.textContent.trim() === "‹") {
        if (currentPage > 1) {
            setCurrentPage(currentPage - 1);
        }

        return;
    }


    /* Next */

    if (button.textContent.trim() === "›") {
        setCurrentPage(currentPage + 1);
        return;
    }


    /* Numeric page */

    let page =
        Number(button.textContent);

    if (!Number.isNaN(page)) {
        setCurrentPage(page);
    }

});

// REGLEEE
function setCurrentPage(page) {
    let urlParsed = new URLSearchParams(window.location.search);
    urlParsed.set("page",page);
    window.location.search = urlParsed.toString();
}


/* =========================================================
   MESSAGES PER PAGE : Regleee
========================================================= */

messagesPerPageSelect.addEventListener(
    "change",
    function () {
        let limit = messagesPerPageSelect.value;
        let urlParsed = new URLSearchParams(window.location.search)
        urlParsed.set("limit",limit);
        window.location.search = urlParsed.toString();
    });


