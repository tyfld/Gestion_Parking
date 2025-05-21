import { Link } from "react-router-dom";

function Liste_Voitures() {
  // Données simulées (à remplacer par une API plus tard)
  const voitures = [
    { id: 1, modele: "Toyota Yaris", dispo: true },
    { id: 2, modele: "Peugeot 208", dispo: true },
    { id: 3, modele: "Renault Clio", dispo: false },
    { id: 4, modele: "Citroën C3", dispo: false },
    { id: 5, modele: "Dacia Sandero", dispo: true },
  ];

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
        <h1 className="text-2xl font-bold">Loca Super 2000</h1>
        <button className="border rounded-full px-4 py-2">Profil</button>
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
            {voitures.map((v) => (
              <tr key={v.id} className="text-center">
                <td className="border px-4 py-2">{v.modele}</td>
                <td className="border px-4 py-2">{v.dispo ? "OUI" : "NON"}</td>
                <td className="border px-4 py-2">
                  {v.dispo ? (

                    <Link to="/emprunter">
                        <button className="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                        Emprunter
                        </button>
                    </Link>
                  ) : (
                    "---"
                  )}
                </td>
                <Link to="/historique_emprunt">
                    <td className="border px-4 py-2">
                    <button className="border rounded px-3 py-1 hover:bg-gray-100">
                        Voir historique
                    </button>
                    </td>
                </Link>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

export default Liste_Voitures;