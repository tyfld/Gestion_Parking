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
    public function get_id_voiture(){
        return $this->id_voiture;
    }
    public function set_id_voiture($id_voiture){
        $this->id_voiture = $id_voiture;
    }

    public function get_modele(){
        return $this->modele;
    }
    public function set_modele($modele){
        $this->modele = $modele;
    }

    public function get_plaque_immatriculation(){
        return $this->plaque_immatriculation;
    }
    public function set_plaque_immatriculation($plaque_immatriculation){
        $this->plaque_immatriculation = $plaque_immatriculation;
    }

}
?>