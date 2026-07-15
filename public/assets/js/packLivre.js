let anneeScolaireSelect = document.querySelectorAll(".anneeScolaire")

const sectionsEtude = [
    // Primaire
    { value: "1-primaire", label: "1ère année primaire" },
    { value: "2-primaire", label: "2ème année primaire" },
    { value: "3-primaire", label: "3ème année primaire" },
    { value: "4-primaire", label: "4ème année primaire" },
    { value: "5-primaire", label: "5ème année primaire" },
    { value: "6-primaire", label: "6ème année primaire" },

    // Collège
    { value: "7-base", label: "7ème année de base" },
    { value: "8-base", label: "8ème année de base" },
    { value: "9-base", label: "9ème année de base" },

    // Lycée - Tronc commun
    { value: "1-secondaire", label: "1ère année secondaire" },

    // 2ème secondaire
    { value: "2-lettres", label: "2ème année Lettres" },
    { value: "2-economie", label: "2ème année Économie et Gestion" },
    { value: "2-sciences", label: "2ème année Sciences Expérimentales" },
    { value: "2-informatique", label: "2ème année Informatique" },

    // 3ème secondaire
    { value: "3-lettres", label: "3ème année Lettres" },
    { value: "3-economie", label: "3ème année Économie et Gestion" },
    { value: "3-sciences", label: "3ème année Sciences Expérimentales" },
    { value: "3-math", label: "3ème année Mathématiques" },
    { value: "3-technique", label: "3ème année Technique" },
    { value: "3-informatique", label: "3ème année Informatique" },
    { value: "3-sport", label: "3ème année Sport" },

    // Bac
    { value: "bac-lettres", label: "Bac Lettres" },
    { value: "bac-economie", label: "Bac Économie et Gestion" },
    { value: "bac-sciences", label: "Bac Sciences Expérimentales" },
    { value: "bac-math", label: "Bac Mathématiques" },
    { value: "bac-technique", label: "Bac Technique" },
    { value: "bac-informatique", label: "Bac Informatique" },
    { value: "bac-sport", label: "Bac Sport" }
];

anneeScolaireSelect.forEach(select =>{
    let html = `<option value="">-- Sélectionnez une année --</option>`
    for(let obj of sectionsEtude){
        html +=  `<option value="${obj["value"]}">${obj["label"]}</option>`
    }
    select.innerHTML = html;
})