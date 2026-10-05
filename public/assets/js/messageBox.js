
// n => name
// i => icon
// c => color of icons
// t => tel
// d => date
// full => fullDate
// e => email
// m => message
var messages=[];
window.addEventListener("load",async function() {
    let urlParsed = new URLSearchParams(window.location.search);
    let data = new FormData();
    for(let [key , val] of urlParsed.entries()){
        data.set(key,val);
    }
    for(let [key , val] of data.entries()){
        console.log(key + " : " +val);
    }
    let response = await fetch("/api/users/messages", {
        method:"POST",
        body:data
    });
    let result = await response.json();
    let allMessages = result.data;
    for(let i = 0 ; i < allMessages.length; i++){
        let mess = allMessages[i];
        let unread = false;
        if(mess["statut"]=="lu") unread = true; 
        messages.push({ n:mess["first_name"] + " " + mess["last_name"], 
                        i:mess["first_name"].charAt(0) + mess["last_name"].charAt(0), 
                        c:"c1",
                        e:mess["email"], 
                        t:mess["tel"], 
                        d:mess["date_envoie"], 
                        full:mess["date_envoie"], 
                        unread:unread})
    }
    console.log(messages)
    renderList();
})
console.log(messages)



// const messages = [
//   {n:"Ahmed Ben Ali", i:"AB", c:"c1", e:"ahmed@gmail.com", t:"22 123 456", d:"05 Oct. 13:02", full:"05 octobre 2026 à 13:02", unread:true,
//    m:"Bonjour,\n\nJe voudrais savoir si le pack scolaire de 5ème année est encore disponible ? Et est-ce possible de venir le récupérer directement à la librairie ?\n\nMerci d'avance."},
//   {n:"Mariem Trabelsi", i:"MT", c:"c2", e:"mariem@gmail.com", t:"55 456 789", d:"05 Oct. 11:47", full:"05 octobre 2026 à 11:47", m:"Est-ce que vous faites la livraison à domicile ?"},
//   {n:"Yassine K.", i:"YK", c:"c3", e:"yassine@gmail.com", t:"98 321 654", d:"04 Oct. 18:21", full:"04 octobre 2026 à 18:21", m:"Je cherche un cartable pour un enfant de 8 ans. Avez-vous des modèles disponibles ?"},
//   {n:"Safa Lazreg", i:"SL", c:"c4", e:"safa@gmail.com", t:"50 987 654", d:"04 Oct. 16:03", full:"04 octobre 2026 à 16:03", unread:true, m:"Bonjour, est-ce que vous avez les cahiers d'activités pour le niveau 3ème ?\nMerci d'avance."},
//   {n:"Karim Ben Ammar", i:"KB", c:"c5", e:"karim@gmail.com", t:"27 654 321", d:"03 Oct. 12:45", full:"03 octobre 2026 à 12:45", m:"Je voudrais connaître le prix du sac à dos avec roulettes bleu."},
//   {n:"Dhouha Lajmi", i:"DL", c:"c6", e:"dhouha@gmail.com", t:"52 111 222", d:"02 Oct. 17:30", full:"02 octobre 2026 à 17:30", m:"Est-ce que vous acceptez les paiements par carte bancaire ?"}
// ];


let pageMessageBox = document.querySelector(".pageMessageBox");
let list_one = pageMessageBox.querySelector("#list");
let panel = pageMessageBox.querySelector("#panel");
let searchInput = pageMessageBox.querySelector('.filters input[type="search"]');
let nomInput = pageMessageBox.querySelector('.filters input[placeholder="Nom client"]');
let emailInput = pageMessageBox.querySelector('.filters input[type="email"]');
let phoneInput = pageMessageBox.querySelector('.filters input[type="tel"]');
let statusSelect = pageMessageBox.querySelector(".filters select");
let filterForm = pageMessageBox.querySelector(".filters");
let countElement = pageMessageBox.querySelector(".count");
let counter = pageMessageBox.querySelector(".counter");
let closeButton = pageMessageBox.querySelector(".close");
let pagination = pageMessageBox.querySelector(".pagination");
let messagesPerPageSelect = pagination.querySelector("select");
let current = 0;
let filteredMessages = [...messages];


/* =========================================================
COUNTERS
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
   RENDER LIST
========================================================= */

function renderList() {
    if (filteredMessages.length === 0) {
        list_one.innerHTML = `
            <div class="empty">
                <p>Aucun message trouvé.</p>
            </div>
        `;
        return;
    }

    list_one.innerHTML = filteredMessages.map((x, k) => {

        let originalIndex = messages.indexOf(x);

        return `
            <article
                class="msg ${x.unread ? "unread" : "read"} ${originalIndex === current ? "active" : ""}"
                data-index="${originalIndex}"
            >

                <div class="avatar ${x.c}">
                    ${x.i}
                </div>

                <div class="body">

                    <h3>${x.n}</h3>

                    <p class="contact">
                        ${x.e} · ${x.t}
                    </p>

                    <p class="excerpt">
                        ${x.m.replace(/\n+/g, " ")}
                    </p>

                </div>

                <div class="side">

                    <div class="meta">

                        <span class="badge ${x.unread ? "new" : "lu"}">
                            ${x.unread ? "Nouveau" : "Lu"}
                        </span>

                        <span>${x.d}</span>

                    </div>

                    <button
                        type="button"
                        class="view"
                        data-k="${originalIndex}"
                    >
                        👁 Voir le message
                    </button>

                </div>

            </article>
        `;
    }).join("");
}


/* =========================================================
   RENDER DETAIL PANEL
========================================================= */

function renderPanel() {

    let x = messages[current];

    if (!x) {
        panel.style.display = "none";
        return;
    }

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

    avatar.className = "avatar " + x.c;
    avatar.textContent = x.i;

    name.textContent = x.n;

    email.textContent = x.e;

    phone.textContent = x.t;

    date.textContent = "Envoyé le " + x.full;

    text.textContent = x.m;

    badge.className =
        "badge " + (x.unread ? "new" : "lu");

    badge.textContent =
        x.unread ? "Nouveau" : "Lu";

    button.style.display =
        x.unread ? "" : "none";

    footer.classList.toggle(
        "is-read",
        !x.unread
    );
}


/* =========================================================
   SELECT MESSAGE
========================================================= */

function selectMessage(index) {

    if (
        index < 0 ||
        index >= messages.length
    ) {
        return;
    }

    current = index;

    renderList();

    renderPanel();
}


/* =========================================================
   CLICK ON MESSAGE LIST
========================================================= */

list_one.addEventListener("click", function (event) {

    let button = event.target.closest(".view");

    if (button) {

        let index = Number(button.dataset.k);

        selectMessage(index);

        return;
    }

    let message = event.target.closest(".msg");

    if (message) {

        let index = Number(
            message.dataset.index
        );

        selectMessage(index);
    }

});


/* =========================================================
   MARK AS READ
========================================================= */

pageMessageBox
    .querySelector("#p-btn")
    .addEventListener("click", function () {

        let message = messages[current];

        if (!message) {
            return;
        }

        message.unread = false;

        updateCounters();

        renderList();

        renderPanel();
    });


/* =========================================================
   CLOSE PANEL
========================================================= */

closeButton.addEventListener("click", function () { panel.style.display = "none"; });


/* =========================================================
   SEARCH / FILTER
========================================================= */

filterForm.addEventListener("submit", function (event) {

    event.preventDefault();

    let search =
        searchInput.value
            .trim()
            .toLowerCase();

    let nom =
        nomInput.value
            .trim()
            .toLowerCase();

    let email =
        emailInput.value
            .trim()
            .toLowerCase();

    let phone =
        phoneInput.value
            .trim()
            .toLowerCase();

    let status =
        statusSelect.value;

    filteredMessages = messages.filter(message => {

        /* Search global */

        let matchesSearch =
            !search ||
            message.n.toLowerCase().includes(search) ||
            message.e.toLowerCase().includes(search) ||
            message.t.toLowerCase().includes(search);


        /* Nom */

        let matchesNom =
            !nom ||
            message.n.toLowerCase().includes(nom);


        /* Email */

        let matchesEmail =
            !email ||
            message.e.toLowerCase().includes(email);


        /* Téléphone */

        let matchesPhone =
            !phone ||
            message.t.toLowerCase().includes(phone);


        /* Statut */

        let matchesStatus = true;

        if (status === "Non lus") {

            matchesStatus = message.unread;

        } else if (status === "Lus") {

            matchesStatus = !message.unread;

        }


        return (
            matchesSearch &&
            matchesNom &&
            matchesEmail &&
            matchesPhone &&
            matchesStatus
        );

    });


    /*
     * If the currently selected message
     * is not inside the filtered result,
     * select the first result.
     */

    if (
        filteredMessages.length > 0 &&
        !filteredMessages.includes(messages[current])
    ) {

        current =
            messages.indexOf(filteredMessages[0]);

    }


    renderList();

    renderPanel();

    updateCounters();

});


/* =========================================================
   RESET FILTERS
========================================================= */

filterForm.addEventListener("reset", function () {

    /*
     * Reset happens automatically by the browser,
     * so wait one event loop cycle before rendering.
     */

    setTimeout(function () {

        filteredMessages = [...messages];

        current = 0;

        renderList();

        renderPanel();

        updateCounters();

    }, 0);

});


/* =========================================================
   PAGINATION BUTTONS
========================================================= */

pagination.addEventListener("click", function (event) {

    let button =
        event.target.closest("button");
    if (!button) {
        return;
    }
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


function setCurrentPage(page) {

    let buttons =
        pagination.querySelectorAll("button");

    buttons.forEach(button => {

        button.classList.remove("current");

        if (
            button.textContent.trim() ===
            String(page)
        ) {

            button.classList.add("current");

        }

    });

}


/* =========================================================
   MESSAGES PER PAGE
========================================================= */

messagesPerPageSelect.addEventListener(
    "change",
    function () {

        console.log(
            "Messages par page :",
            this.value
        );

        /*
         * Later, when you connect this to PHP/API,
         * you can use this value for pagination.
         */

    }
);


/* =========================================================
   INITIALIZATION
========================================================= */

updateCounters();
renderList();
renderPanel();

