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
    public function getId_utilisateur(){
        return $this->id_utilisateur;
    }
    public function setId_utilisateur($id_utilisateur){
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getNom(){
        return $this->nom;
    }
    public function setNom($nom){
        $this->nom = $nom;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getMdp(){
        return $this->mdp;
    }
    public function setMdp($mdp){
        $this->mdp = $mdp;
    }

    public function getRole(){
        return $this->role;
    }
    public function setRole($role){
        $this->role = $role;
    }

}
?>