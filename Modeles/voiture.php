<?php
class voiture{
    private $id;
    private $modele;
    private $plaque_immatriculation;
    private $date_debut;
    private $date_fin;

    public function __construct($id = 0, $modele, $plaque_immatriculation, $date_debut, $date_fin){
        $this->id = $id;
        $this->modele = $modele;
        $this->plaque_immatriculation = $plaque_immatriculation;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
    }

    // Getter et Setter
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getModele(){
        return $this->modele;
    }
    public function setModele($modele){
        $this->modele = $modele;
    }

    public function getPlaque_immatriculation(){
        return $this->plaque_immatriculation;
    }
    public function setPlaque_immatriculation($plaque_immatriculation){
        $this->plaque_immatriculation = $plaque_immatriculation;
    }

    public function getDate_debut(){
        return $this->date_debut;
    }
    public function setDate_debut($date_debut){
        $this->date_debut = $date_debut;
    }

    public function getDate_fin(){
        return $this->date_fin;
    }
    public function setDate_fin($date_fin){
        $this->date_fin = $date_fin;
    }

}
?>