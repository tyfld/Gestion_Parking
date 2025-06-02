import { Link, useParams } from "react-router-dom";
import { useState, useEffect} from "react";

function Historique_Emprunt() {

  const { id } = useParams(); // ID de la voiture

  const [sessionData, setSessionData] = useState({"session": false});
  const [voitureData, setVoitureData] = useState([]);

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
  
  const fetchData = async () => {
    const URL = "http://localhost/projets/Gestion_Parking/emprunts-historique-voiture";
    try {
      // envoyre le useParam en POST
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
    fetchData();
  }, [])

  // Données simulées (à remplacer par une API plus tard)
  /*const historique = [
    { utilisateur: "Alice", date: "2024-12-01" },
    { utilisateur: "Bob", date: "2025-01-15" },
    { utilisateur: "Charlie", date: "2025-03-22" },
  ];*/

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
        <h1 className="text-2xl font-bold">Historique d'emprunt</h1>
        {sessionData.session ? (
          <a href="/profil" className="border rounded-full px-4 py-2">Profil</a>
        ) : (
          <a href="/connexion" className="border rounded-full px-4 py-2">Connexion</a>
        )}
      </header>

      {/* Contenu principal */}
      <div className="flex flex-col items-center gap-6">
        <p className="text-xl mb-4">
          <strong>Voiture:</strong> {voitureData.modele}
        </p>

        <div className="bg-white shadow rounded w-full max-w-md">
          <table className="w-full table-auto">
            <thead className="bg-gray-200">
              <tr>
                <th className="border px-4 py-2">Utilisateur</th>
                <th className="border px-4 py-2">Date d'emprunt</th>
                <th className="border px-4 py-2">Date de rendu</th>
              </tr>
            </thead>
            <tbody>
              {voitureData.map((v, index) => (
                <tr key={index} className="text-center">
                  <td className="border px-4 py-2">{v.nom_utilisateur}</td>
                  <td className="border px-4 py-2">{v.date_debut}</td>
                  <td className="border px-4 py-2">{v.date_fin ? (v.date_fin) : ("Toujours empruntée")}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        <Link to="/voitures">
          <button className="mt-6 border px-6 py-2 rounded hover:bg-gray-100">
            Retour à la liste des voitures
          </button>
        </Link>
      </div>
    </div>
  );
}

export default Historique_Emprunt;