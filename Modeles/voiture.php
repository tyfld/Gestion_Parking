<?php
class Voiture{
    private $id_voiture;
    private $modele;
    private $plaque_immatriculation;

    public function __construct($id_voiture, $modele, $plaque_immatriculation){
        $this->id_voiture = $id_voiture;
        $this->modele = $modele;
        $this->plaque_immatriculation = $plaque_immatriculation;
    }

    // Getter et Setter
    public function getId_voiture(){
        return $this->id_voiture;
    }
    public function setId_voiture($id_voiture){
        $this->id_voiture = $id_voiture;
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

}
?>