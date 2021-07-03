<?php

namespace Plugin\Entity;

use Plugin\Entity\Categorie;

class Pneu
{
    private ?string $name;
    private ?string $full_name;
    private ?string $desc;
    private ?string $prix;
    private ?string $stock;
    private ?Categorie $categorie;
    private ?string $taille;
    private ?string $classe;
    private ?string $capacite_charge;
    private ?string $capacite_charge_version;
    private ?string $vitesse_max;
    private ?string $consomation_carburant;
    private ?string $adherence;
    private ?string $bruit_ext;
    private ?string $decibels;
    private ?string $neige;
    private ?string $glace;

    /**
     * Pneu constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    /**
     * @param string|null $full_name
     * @return Pneu
     */
    public function setFullName(?string $full_name): Pneu
    {
        $this->full_name = $full_name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaille(): ?string
    {
        return $this->taille;
    }

    /**
     * @param string|null $taille
     * @return Pneu
     */
    public function setTaille(?string $taille): Pneu
    {
        $this->taille = $taille;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClasse(): ?string
    {
        return $this->classe;
    }

    /**
     * @param string|null $classe
     */
    public function setClasse(?string $classe): Pneu
    {
        $this->classe = $classe;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCapaciteCharge(): ?string
    {
        return $this->capacite_charge;
    }

    /**
     * @param string|null $capacite_charge
     */
    public function setCapaciteCharge(?string $capacite_charge): Pneu
    {
        $this->capacite_charge = $capacite_charge;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getCapaciteChargeVersion(): ?string
    {
        return $this->capacite_charge_version;
    }

    /**
     * @param string|null $capacite_charge_version
     */
    public function setCapaciteChargeVersion(?string $capacite_charge_version): Pneu
    {
        $this->capacite_charge_version = $capacite_charge_version;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getVitesseMax(): ?string
    {
        return $this->vitesse_max;
    }

    /**
     * @param string|null $vitesse_max
     */
    public function setVitesseMax(?string $vitesse_max): Pneu
    {
        $this->vitesse_max = $vitesse_max;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getConsomationCarburant(): ?string
    {
        return $this->consomation_carburant;
    }

    /**
     * @param string|null $consomation_carburant
     */
    public function setConsomationCarburant(?string $consomation_carburant): Pneu
    {
        $this->consomation_carburant = $consomation_carburant;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getAdherence(): ?string
    {
        return $this->adherence;
    }

    /**
     * @param string|null $adherence
     */
    public function setAdherence(?string $adherence): Pneu
    {
        $this->adherence = $adherence;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBruitExt(): ?string
    {
        return $this->bruit_ext;
    }

    /**
     * @param string|null $bruit_ext
     */
    public function setBruitExt(?string $bruit_ext): Pneu
    {
        $this->bruit_ext = $bruit_ext;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDecibels(): ?string
    {
        return $this->decibels;
    }

    /**
     * @param string|null $decibels
     */
    public function setDecibels(?string $decibels): Pneu
    {
        $this->decibels = $decibels;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNeige(): ?string
    {
        return $this->neige;
    }

    /**
     * @param string|null $neige
     */
    public function setNeige(?string $neige): Pneu
    {
        $this->neige = $neige;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getGlace(): ?string
    {
        return $this->glace;
    }

    /**
     * @param string|null $glace
     */
    public function setGlace(?string $glace): Pneu
    {
        $this->glace = $glace;
        return $this;
    }


    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): Pneu
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDesc(): ?string
    {
        return $this->desc;
    }

    /**
     * @param string|null $desc
     * @return $this
     */
    public function setDesc(?string $desc): Pneu
    {
        $this->desc = $desc;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrix(): ?string
    {
        return $this->prix;
    }

    /**
     * @param string|null $prix
     * @return $this
     */
    public function setPrix(?string $prix): Pneu
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * @return Categorie|null
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string|null $categorie
     * @return $this
     */
    public function setCategorie(?Categorie $categorie): Pneu
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStock(): ?string
    {
        return $this->stock;
    }

    /**
     * @param string|null $stock
     * @return $this
     */
    public function setStock(?string $stock): Pneu
    {
        $this->stock = $stock;
        return $this;
    }


}