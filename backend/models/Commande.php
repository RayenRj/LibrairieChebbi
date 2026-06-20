<?php
    class Commande {
    private int $id_commande;
    private int $id_client;
    private string $dateCommande;
    private string $statut;
    private string $addresse;
    private string $ville;
    private string $codePostal;
    private float $prix_totale;
    private string $comment;

    // Constructor
    public function __construct(
        int $id_commande,
        int $id_client,
        string $dateCommande,
        string $statut,
        string $addresse,
        string $ville,
        string $codePostal,
        float $prix_totale,
        string $comment
    ) {
        $this->id_commande = $id_commande;
        $this->id_client = $id_client;
        $this->dateCommande = $dateCommande;
        $this->statut = $statut;
        $this->addresse = $addresse;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
        $this->prix_totale = $prix_totale;
        $this->comment = $comment;
    }

    // Getters
    public function getIdCommande(): int {
        return $this->id_commande;
    }

    public function getIdClient(): int {
        return $this->id_client;
    }

    public function getDateCommande(): string {
        return $this->dateCommande;
    }

    public function getStatut(): string {
        return $this->statut;
    }

    public function getAddresse(): string {
        return $this->addresse;
    }

    public function getVille(): string {
        return $this->ville;
    }

    public function getCodePostal(): string {
        return $this->codePostal;
    }

    public function getPrixTotale(): float {
        return $this->prix_totale;
    }

    public function getComment(): string {
        return $this->comment;
    }

    // Setters
    public function setIdCommande(int $id_commande): void {
        $this->id_commande = $id_commande;
    }

    public function setIdClient(int $id_client): void {
        $this->id_client = $id_client;
    }

    public function setDateCommande(string $dateCommande): void {
        $this->dateCommande = $dateCommande;
    }

    public function setStatut(string $statut): void {
        $this->statut = $statut;
    }

    public function setAddresse(string $addresse): void {
        $this->addresse = $addresse;
    }

    public function setVille(string $ville): void {
        $this->ville = $ville;
    }

    public function setCodePostal(string $codePostal): void {
        $this->codePostal = $codePostal;
    }

    public function setPrixTotale(float $prix_totale): void {
        $this->prix_totale = $prix_totale;
    }

    public function setComment(string $comment): void {
        $this->comment = $comment;
    }

    // ToString
    public function __toString(): string {
        return "Commande {
            id_commande = {$this->id_commande},
            id_client = {$this->id_client},
            dateCommande = {$this->dateCommande},
            statut = {$this->statut},
            addresse = {$this->addresse},
            ville = {$this->ville},
            codePostal = {$this->codePostal},
            prix_totale = {$this->prix_totale},
            comment = {$this->comment}
        }";
    }

    }



?>