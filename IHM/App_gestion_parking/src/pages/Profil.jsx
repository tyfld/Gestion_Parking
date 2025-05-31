import { useNavigate, Link } from "react-router-dom";
import { useState, useEffect } from "react";

function Profil() {

  const navigate = useNavigate();
  const [sessionData, setSessionData] = useState(null);
  const [utilisateur, setUtilisateur] = useState({});
  const [voitures, setVoitures] = useState([]);

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

  
  const fetchUtilisateur = async () => {
    const URL = "http://localhost/projets/Gestion_Parking/profil";
    try {
      const response = await fetch(URL, {
        method: "GET",
        credentials: "include",
        headers: { "Content-Type": "application/json" }
      })
      const profilData = await response.json();
      setUtilisateur(profilData);
      console.log(profilData)
    } catch (error) {
      console.error("Erreur lors de la récupération des données de l'utilisateur : ", error);
    }
  }

  const fetchVoitures = async () => {
    const URL = "http://localhost/projets/Gestion_Parking/emprunts-historique-utilisateur";
    try {
      const response = await fetch(URL, {
        method: "GET",
        credentials: "include",
        headers: { "Content-Type": "application/json" }
      })
      const  voituresData= await response.json();
      setVoitures(voituresData);
      console.log(voituresData)
    } catch (error) {
      console.error("Erreur lors de la récupération des données des voitures : ", error);
    }
  }

  useEffect(() => {
      fetchSession();
  }, [])

  useEffect(() => {
    if (sessionData !== null && sessionData.session === false) {
      navigate("/connexion")
    } else if (sessionData && sessionData.session === true) {
      fetchUtilisateur();
      fetchVoitures();
    }
  }, [sessionData, navigate])

  const handleDeconnexion = () => {
    const URL = "http://localhost/projets/Gestion_Parking/deconnexion";
    try {
      fetch(URL, {
        method: "GET",
        credentials: "include",
        headers: { "Content-Type": "application/json" }
      })
    } catch (error) {
      console.error("Erreur lors de la déconnexion : ", error);
    }
    alert("Déconnecté");
    navigate("/connexion");
  };

  return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
      </header>
      <div className="bg-white p-8 rounded shadow-md w-full max-w-xl">
        <h2 className="text-2xl font-bold mb-6 text-center">Profil</h2>

        <div className="mb-6 space-y-2">
          <p><span className="font-semibold">Email :</span> {utilisateur.email}</p>
          <p><span className="font-semibold">Mot de passe :</span> ********</p>
        </div>

        <h3 className="text-lg font-semibold mb-2">Voitures empruntées :</h3>
        {voitures.length === 0 ? (
          <p className="text-gray-600">Aucune voiture empruntée.</p>
        ) : (
          <ul className="space-y-2 mb-6">
            {voitures.map((v, index) => (
              <li
                key={index}
                className="border rounded px-4 py-2 bg-gray-50 flex justify-between items-center"
              >
                <div>
                  <p className="font-medium">{v.modele}</p>
                  <p className="text-sm text-gray-600">Plaque : {v.plaque_immatriculation}</p>
                  <p className="text-sm text-gray-600">
                    Date d'emprunt: {v.date_debut}, Date de rendu: {v.date_fin ? v.date_fin : "Emprunt en cours"}</p>
                  {!(v.date_fin) && 
                    <a href={`/emprunter/${v.id_voiture}`} className="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Rendre la voiture</a>
                  }
                </div>
              </li>
            ))}
          </ul>
        )}

        <button
          onClick={handleDeconnexion}
          className="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600 w-full"
        >
          Se déconnecter
        </button>
      </div>
    </div>
  );
}

export default Profil;