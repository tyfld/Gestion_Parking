<?php
class Voiture{
    private $id;
    private $modele;
    private $plaque_immatriculation;

    public function __construct($id = 0, $modele, $plaque_immatriculation){
        $this->id = $id;
        $this->modele = $modele;
        $this->plaque_immatriculation = $plaque_immatriculation;
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

}
?>