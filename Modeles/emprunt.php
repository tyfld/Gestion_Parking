<?php
class Emprunt{
    private $id;
    private $id_voiture;
    private $id_utilisateur;
    private $date_emprunt;

    public function __construct($id = 0, $id_voiture, $id_utilisateur, $date_emprunt){
        $this->id = $id;
        $this->id_voiture = $id_voiture;
        $this->id_utilisateur = $id_utilisateur;
        $this->date_emprunt = $date_emprunt;
    }

    // Getter et Setter
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getId_voiture(){
        return $this->id_voiture;
    }
    public function setId_voiture($id_voiture){
        $this->id_voiture = $id_voiture;
    }

    public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getDate_emprunt(){
        return $this->date_emprunt;
    }
    public function setDate_emprunt($date_emprunt){
        $this->date_emprunt = $date_emprunt;
    }
}
?>