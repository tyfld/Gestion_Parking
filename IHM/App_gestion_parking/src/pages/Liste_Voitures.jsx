import { Link } from "react-router-dom";
import { useState, useEffect} from "react";

function Liste_Voitures() {

  const [sessionData, setSessionData] = useState({"session": false});
  const [voituresData, setVoituresData] = useState([]);


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

  // Données simulées (à remplacer par une API plus tard)
  /*const voitures = [
    { id: 1, modele: "Toyota Yaris", disponible: true },
    { id: 2, modele: "Peugeot 208", disponible: true },
    { id: 3, modele: "Renault Clio", disponible: false },
    { id: 4, modele: "Citroën C3", disponible: false },
    { id: 5, modele: "Dacia Sandero", disponible: true },
  ];*/

  

  const fetchData = async () => {
    const URL = "http://localhost/projets/Gestion_Parking/liste-voitures";
    try {
      const response = await fetch(URL)
      const data = await response.json();
      setVoituresData(data);
    } catch (error) {
      console.error("Erreur lors de la récupération des données : ", error);
    }
  }

  useEffect(() => {
      fetchSession();
      fetchData();
    }, [])

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
        <h1 className="text-2xl font-bold">Loca Super 2000</h1>
        {/*affiche profil ou connexion en fonction de la session ouverte*/}
        {sessionData.session ? (
          <a href="/profil" className="border rounded-full px-4 py-2">Profil</a>
        ) : (
          <a href="/connexion" className="border rounded-full px-4 py-2">Connexion</a>
        )}
      </header>

      {/* Tableau */}
      <div className="overflow-x-auto">
        <table className="min-w-full border bg-white rounded shadow">
          <thead className="bg-gray-200">
            <tr>
              <th className="border px-4 py-2">Modèle</th>
              <th className="border px-4 py-2">Disponible</th>
              <th className="border px-4 py-2">Emprunter</th>
              <th className="border px-4 py-2">Historique d'emprunt</th>
            </tr>
          </thead>
          <tbody>
            {voituresData.map((v) => (
              <tr key={v.id_voiture} className="text-center">
                <td className="border px-4 py-2">{v.modele}</td>
                <td className="border px-4 py-2">{v.disponible ? "OUI" : "NON"}</td>
                <td className="border px-4 py-2">
                  {v.disponible ? (

                    <Link to="/emprunter">
                        <button className="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        Emprunter
                        </button>
                    </Link>
                  ) : (
                    sessionData.id_utilisateur == v.id_utilisateur) ? (
                      <Link to={`/emprunter/${v.id_voiture}`}>
                        <button className="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                          Rendre la voiture
                        </button>
                      </Link>
                    ) : ("---")
                  }
                  
                </td>

                <td className="border px-4 py-2">
                  <a></a>
                  <Link to={`/historique_emprunt/${v.id_voiture}`}>
                    <button className="border rounded px-3 py-1 hover:bg-gray-100">
                        Voir historique
                    </button>
                  </Link>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

export default Liste_Voitures;