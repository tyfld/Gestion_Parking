import { Link, useParams } from "react-router-dom";

function Historique_Emprunt() {

  const { id } = useParams(); // ID de la voiture

  // Données simulées (à remplacer par une API plus tard)
  const historique = [
    { utilisateur: "Alice", date: "2024-12-01" },
    { utilisateur: "Bob", date: "2025-01-15" },
    { utilisateur: "Charlie", date: "2025-03-22" },
  ];

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
        <h1 className="text-2xl font-bold">Historique d'emprunt</h1>
        <button className="border rounded-full px-4 py-2">Profil</button>
      </header>

      {/* Contenu principal */}
      <div className="flex flex-col items-center gap-6">
        <p className="text-xl mb-4">
          <strong>Voiture ID:</strong> {id}
        </p>

        <div className="bg-white shadow rounded w-full max-w-md">
          <table className="w-full table-auto">
            <thead className="bg-gray-200">
              <tr>
                <th className="border px-4 py-2">Utilisateur</th>
                <th className="border px-4 py-2">Date</th>
              </tr>
            </thead>
            <tbody>
              {historique.map((entry, index) => (
                <tr key={index} className="text-center">
                  <td className="border px-4 py-2">{entry.utilisateur}</td>
                  <td className="border px-4 py-2">{entry.date}</td>
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