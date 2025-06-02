import { useParams, Link, useNavigate } from "react-router-dom";
import { useState, useEffect} from 'react';

function Emprunter() {

  const [sessionData, setSessionData] = useState({"session": false});
  const [voitureData, setVoitureData] = useState({});
  const navigate = useNavigate();
    
  const fetchSession = async () => {
    const URL = "http://localhost/projets/Gestion_Parking/session";
    try {
      const response = await fetch(URL, {
        method: "GET",
        credentials: "include",
        headers: { "Content-Type": "application/json" }
      })
      const sessionData = await response.json();
      setSessionData(sessionData);
    } catch (error) {
      console.error("Erreur lors de la récupération de la session : ", error);
    }
  }

  const fetchVoiture = async () => {
    const URL = "http://localhost/projets/Gestion_Parking/voiture-disponible";
    try {
      const response = await fetch(URL, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ "id_voiture": id })
      })
      const data = await response.json();
      setVoitureData(data);
    } catch (error) {
      console.error("Erreur lors de la récupération des données : ", error);
    }
  }


  useEffect(() => {
    fetchSession();
    fetchVoiture();
  }, [])

  const { id } = useParams();

  // Exemple de données simulées (à remplacer par une API plus tard)
  /*const voiture = {
    id,
    modele: "Toyota Yaris",
    plaque_immatriculation: "AB-123-CD",
  };*/

  const handleEmprunt = () => {
    if (sessionData.session == false) {
      alert('Vous devez être connecté pour emprunter une voiture!');
      navigate("/connexion");
    }
    // suite accessible que si connecté
    else {

      // Pour emprunter la voiture ------------------------------------------------------
      if (voitureData.disponible == true) {
        try {
          const URL = "http://localhost/projets/Gestion_Parking/emprunter-voiture";
          console.log(sessionData.id_utilisateur);
          console.log(voitureData.id_voiture);
          fetch(URL, {
            method: "POST",
            credentials: "include",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              "id_utilisateur": sessionData.id_utilisateur,
              "id_voiture": voitureData.id_voiture
            })
          })
          .then(response => response.json())
          .then(data => {
                if (data.success) {
                  alert("Voiture empruntée !");
                  navigate("/voitures");
                } else {
                  alert(data.message || "Erreur lors de l'emprunt de la voiture");
                }
            })
        } catch (error) {
          console.error("Erreur lors de l'emprunt' :", error);
          alert("Une erreur est survenue. Veuillez réessayer plus tard.");
          return;
        }
      } 
      
      // Pour rendre la voiture ---------------------------------------------------------
      else {
        if (sessionData.id_utilisateur == voitureData.id_utilisateur) {
          try {
            const URL = "http://localhost/projets/Gestion_Parking/rendre-voiture";
            fetch(URL, {
              method: "POST",
              credentials: "include",
              headers: {"Content-Type": "application/json"},
              body: JSON.stringify({"id_emprunt": voitureData.id_emprunt}),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  alert("Voiture rendue !");
                  navigate("/voitures");
                } else {
                  alert(data.message || "Erreur lors du retour de la voiture");
                }
            })
          } catch (error) {
            console.error("Erreur lors du rendu :", error);
            alert("Une erreur est survenue. Veuillez réessayer plus tard.");
            return;
          }
        } else {alert('Erreur')} // normalement pas nécessaire, l'affichage des boutons gère cette éventualité
      }

    }
  };

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
        <h1 className="text-2xl font-bold">Emprunter</h1>
        {sessionData.session ? (
          <a href="/profil" className="border rounded-full px-4 py-2">Profil</a>
        ) : (
          <a href="/connexion" className="border rounded-full px-4 py-2">Connexion</a>
        )}
      </header>

      {/* Contenu principal */}
      <div className="flex flex-col items-center gap-6 mt-12">
        <p className="text-xl">
          <strong>Modèle:</strong> {voitureData.modele}
        </p>
        <p className="text-xl">
          <strong>Plaque d'immatriculation:</strong> {voitureData.plaque_immatriculation}
        </p>

        {voitureData.disponible ? (
          <button onClick={handleEmprunt} className="border px-6 py-2 rounded hover:bg-gray-100">
            Emprunter cette voiture
          </button>
         ) : (
          sessionData.id_utilisateur == voitureData.id_utilisateur) ? (
            <button onClick={handleEmprunt} className="border px-6 py-2 rounded hover:bg-gray-100">
              Rendre la voiture
            </button>
          ) : (<p className="border px-6 py-2 rounded hover:bg-gray-100">La voiture n'est pas accessible pour le moment</p>)
        }

        <Link to="/voitures">
          <button className="border px-6 py-2 rounded hover:bg-gray-100">
            Retour à la liste des voitures
          </button>
        </Link>
      </div>
    </div>
  );
}

export default Emprunter;
