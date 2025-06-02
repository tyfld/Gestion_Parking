import { Link } from "react-router-dom";
import { useState, useEffect} from "react";

function Home() {

  const [sessionData, setSessionData] = useState({"session": false});

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
      console.log(sessionData)
    } catch (error) {
      console.error("Erreur lors de la récupération de la session : ", error);
    }
  }

  useEffect(() => {
      fetchSession();
    }, [])

    return (
      <div className="min-h-screen bg-gray-100 p-6">
        {/* En-tête */}
        <header className="flex justify-between items-center mb-8">
          <h1 className="text-2xl font-semibold">Page d'accueil</h1>
          {sessionData.session ? (
          <a href="/profil" className="border rounded-full px-4 py-2">Profil</a>
        ) : (
          <a href="/connexion" className="border rounded-full px-4 py-2">Connexion</a>
        )}
        </header>
  
        <div className="flex gap-4">
          {/* Colonne gauche - réservé aux admins */}
          {sessionData.session && sessionData.session == true && sessionData.role == 1 && (
            <div className="border border-red-400 p-4 flex flex-col gap-4 w-fit">
              <a href="/ajout_voiture" className="border rounded px-4 py-2 hover:bg-gray-100">
                Ajouter une voiture
              </a>
              <a href="/ajout_utilisateur" className="border rounded px-4 py-2 hover:bg-gray-100">
                Ajouter un utilisateur
              </a>
            </div>
          )}
  
          {/* Section principale */}
          <main className="flex-1 flex flex-col items-center justify-center border rounded-lg p-16 bg-white shadow">
            <h2 className="text-3xl font-bold mb-8">Loca Super 2000</h2>
            <Link to="/voitures">
                <button className="border rounded px-6 py-3 hover:bg-gray-100">
                Voir les voitures
                </button>
            </Link>
          </main>
        </div>
      </div>
    );
}

  export default Home;