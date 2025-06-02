<?php
class Utilisateur{
    private $id_utilisateur;
    private $nom;
    private $email;
    private $mdp;
    private $role;

    public function __construct($id_utilisateur, $nom, $email, $mdp, $role){
        $this->id_utilisateur = $id_utilisateur;
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
        $this->role = $role;
    }

    // Getter et Setter
    public function get_id_utilisateur(){
        return $this->id_utilisateur;
    }
    public function set_id_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
    }

    public function get_nom(){
        return $this->nom;
    }
    public function set_nom($nom){
        $this->nom = $nom;
    }

    public function get_email(){
        return $this->email;
    }
    public function set_email($email){
        $this->email = $email;
    }

    public function get_mdp(){
        return $this->mdp;
    }
    public function set_mdp($mdp){
        $this->mdp = $mdp;
    }

    public function get_role(){
        return $this->role;
    }
    public function set_role($role){
        $this->role = $role;
    }

}
?>