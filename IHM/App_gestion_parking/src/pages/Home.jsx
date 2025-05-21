import { Link } from "react-router-dom";

function Home({ isAdmin }) {
    return (
      <div className="min-h-screen bg-gray-100 p-6">
        {/* En-tête */}
        <header className="flex justify-between items-center mb-8">
          <h1 className="text-2xl font-semibold">Page d'accueil</h1>
          <button className="border rounded-full px-4 py-2">Profil</button>
        </header>
  
        <div className="flex gap-4">
          {/* Colonne gauche - réservé aux admins */}
          {isAdmin && (
            <div className="border border-red-400 p-4 flex flex-col gap-4 w-fit">
              <button className="border rounded px-4 py-2 hover:bg-gray-100">
                Ajouter une voiture
              </button>
              <button className="border rounded px-4 py-2 hover:bg-gray-100">
                Voir liste utilisateur
              </button>
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