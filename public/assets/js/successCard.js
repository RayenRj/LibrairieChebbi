
/* ===== Librairie Chebbi toast – JS ===== */

var TOAST_PRESETS_SUCCESS = {

    addProduct: {
        title: 'Produit ajouté !',
        text: 'Le produit a été ajouté avec succès.',
        icon: '📦',
        label: 'Nouveau produit',
        sub: 'Article ajouté au stock',
        deco: '✏️'
    },

    addPack: {
        title: 'Pack ajouté !',
        text: 'Le pack scolaire a été ajouté avec succès.',
        icon: '🎒',
        label: 'Nouveau pack',
        sub: 'Pack disponible à la vente',
        deco: '📚'
    },

    updateProduct: {
        title: 'Produit modifié !',
        text: 'Les modifications du produit ont été enregistrées.',
        icon: '📖',
        label: 'Produit mis à jour',
        sub: 'Fiche produit mise à jour',
        deco: '🖊️'
    },

    deleteProduct: {
        title: 'Produit supprimé !',
        text: 'Le produit a été supprimé avec succès.',
        icon: '📦',
        label: 'Produit supprimé',
        sub: 'Article retiré du stock',
        deco: '✏️'
    },

    addOrder: {
        title: 'Commande créée !',
        text: 'La commande a été créée avec succès.',
        icon: '🧾',
        label: 'Nouvelle commande',
        sub: 'Commande enregistrée',
        deco: '📚'
    },

    updateOrder: {
        title: 'Commande modifiée !',
        text: 'La commande a été mise à jour avec succès.',
        icon: '🧾',
        label: 'Commande mise à jour',
        sub: 'Modifications enregistrées',
        deco: '🖊️'
    },

    deleteCommande: {
        title: 'Commande supprimée !',
        text: 'La commande a été supprimée avec succès.',
        icon: '🧾',
        label: 'Commande supprimée',
        sub: 'Commande retirée',
        deco: '🗑️'
    },

    commandeAnnulee: {
        title: 'Commande annulée !',
        text: 'La commande a été annulée avec succès.',
        icon: '❌',
        label: 'Commande annulée',
        sub: 'Commande annulée par le système',
        deco: '🚫'
    },

    commandeLivree: {
        title: 'Commande livrée !',
        text: 'La commande a été livrée avec succès.',
        icon: '📦',
        label: 'Commande livrée',
        sub: 'Commande remise au client',
        deco: '🚚'
    },

    commandeConfirmee: {
        title: 'Commande confirmée !',
        text: 'La commande a été confirmée avec succès.',
        icon: '✅',
        label: 'Commande confirmée',
        sub: 'Commande validée',
        deco: '🧾'
    },

    adminDeleted: {
        title: 'Administrateur supprimé !',
        text: 'Le compte administrateur a été supprimé avec succès.',
        icon: '👤',
        label: 'Administrateur supprimé',
        sub: 'Compte retiré du système',
        deco: '🗑️'
    },

    adminAdded: {
        title: 'Administrateur ajouté !',
        text: 'Le compte administrateur a été créé avec succès.',
        icon: '👤',
        label: 'Nouvel administrateur',
        sub: 'Compte ajouté au système',
        deco: '➕'
    },

    clientDeleted: {
        title: 'Client supprimé !',
        text: 'Le client a été supprimé avec succès.',
        icon: '👤',
        label: 'Client supprimé',
        sub: 'Compte client retiré',
        deco: '🗑️'
    },

    promotionAdded: {
        title: 'Promotion ajoutée !',
        text: 'La promotion a été ajoutée avec succès.',
        icon: '🏷️',
        label: 'Nouvelle promotion',
        sub: 'Promotion disponible à la vente',
        deco: '🎉'
    },

    addPack: {
        title: 'Pack ajouté !',
        text: 'Le pack scolaire a été ajouté avec succès.',
        icon: '🎒',
        label: 'Nouveau pack',
        sub: 'Pack disponible à la vente',
        deco: '📚'
    },

    updatePack: {
        title: 'Pack modifié !',
        text: 'Les modifications du pack ont été enregistrées.',
        icon: '🎒',
        label: 'Pack mis à jour',
        sub: 'Informations du pack actualisées',
        deco: '🖊️'
    },

    deletePack: {
        title: 'Pack supprimé !',
        text: 'Le pack scolaire a été supprimé avec succès.',
        icon: '🎒',
        label: 'Pack supprimé',
        sub: 'Pack retiré de la vente',
        deco: '🗑️'
    }
};


function showToast(key, overrides, duration = 4000){
  const c = Object.assign({}, TOAST_PRESETS_SUCCESS[key] || TOAST_PRESETS_SUCCESS.addProduct, overrides);
  const el = document.createElement('div');
  el.className = 'ct';
  el.setAttribute('role', 'status');
  el.innerHTML = `
    <div class="ct-body">
      <div class="ct-ic">
        <div class="ct-ok"><svg width="24" height="24" viewBox="0 0 24 24"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></div>
        <div class="ct-deco"></div>
      </div>
      <div class="ct-txt">
        <h2></h2><p></p>
        <div class="ct-item"><div class="bk"></div><div><b></b><span></span></div></div>
      </div>
      <button class="ct-x" aria-label="Fermer">×</button>
    </div>
    <div class="ct-bar"><i style="animation-duration:${duration}ms"></i></div>`;
  // textContent = safe against HTML injection
  el.querySelector('h2').textContent = c.title;
  el.querySelector('p').textContent = c.text;
  el.querySelector('.bk').textContent = c.icon;
  el.querySelector('.ct-deco').textContent = c.deco;
  el.querySelector('.ct-item b').textContent = c.label;
  el.querySelector('.ct-item span').textContent = c.sub;

  let timer;
  const close = () => {
    clearTimeout(timer);
    if (el.classList.contains('out')) return;
    el.classList.add('out');
    setTimeout(() => el.remove(), 300);
  };
  el.querySelector('.ct-x').addEventListener('click', close);
  timer = setTimeout(close, duration);
  document.getElementById('toasts').appendChild(el);
}

/* demo wiring */

