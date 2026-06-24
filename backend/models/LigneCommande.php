<?php 
    require_once(__DIR__ . "/Product.php");

    class LigneCommande {
        private Product $produit;
        private int $quantite;
        private float $prixTotale;

        public function __construct(
            Product $produit,
            int $quantite,
        ) {
            $this->produit = $produit;
            $this->quantite = $quantite;
            $this->prixTotale = $quantite * $produit->getPrix();
        }

        // ================= GETTERS =================



        public function getProduit(): Product {
            return $this->produit;
        }

        public function getQuantite(): int {
            return $this->quantite;
        }

        public function getPrixTotale(): float {
            return $this->prixTotale;
        }

        // ================= SETTERS =================


        public function setProduit(Product $produit): void {
            $this->produit = $produit;
        }

        public function setQuantite(int $quantite): void {
            $this->quantite = $quantite;
        }

        public function setPrixTotale(float $prixTotale): void {
            $this->prixTotale = $prixTotale;
        }
    }

?>