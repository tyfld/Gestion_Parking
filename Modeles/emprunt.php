<?php
class Emprunt{
    private $id_emprunt;
    private $id_voiture;
    private $id_utilisateur;
    private $date_debut;
    private $date_fin;

    public function __construct($id_emprunt, $id_voiture, $id_utilisateur, $date_debut, $date_fin){
        $this->id_emprunt = $id_emprunt;
        $this->id_voiture = $id_voiture;
        $this->id_utilisateur = $id_utilisateur;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
    }

    // Getter et Setter
    public function get_id_emprunt(){
        return $this->id_emprunt;
    }
    public function set_id_emprunt($id_emprunt){
        $this->id_emprunt = $id_emprunt;
    }

    public function get_id_voiture(){
        return $this->id_voiture;
    }
    public function set_id_voiture($id_voiture){
        $this->id_voiture = $id_voiture;
    }

    public function get_id_utilisateur(){
        return $this->id_utilisateur;
    }
    public function set_id_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
    }

    public function get_date_debut(){
        return $this->date_debut;
    }
    public function set_date_debut($date_debut){
        $this->date_debut = $date_debut;
    }

    public function get_date_fin(){
        return $this->date_fin;
    }
    public function set_date_fin($date_fin){
        $this->date_fin = $date_fin;
    }


    // Fonction sur les objets
}
?>