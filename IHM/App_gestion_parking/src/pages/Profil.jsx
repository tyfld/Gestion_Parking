import { useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";

function Profil() {

    const navigate = useNavigate();

  // Simule les données utilisateur
  const [utilisateur, setUtilisateur] = useState({
    email: "utilisateur@example.com",
    motDePasse: "********", // masqué pour l'affichage
    emprunts: [
      { modele: "Toyota Yaris", plaque: "AB-123-CD" },
      { modele: "Renault Clio", plaque: "XY-456-ZT" },
    ],
  });

  const handleDeconnexion = () => {
    // TODO: supprimer token ou session réelle
    alert("Déconnecté");
    navigate("/connexion");
  };

  return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
      <div className="bg-white p-8 rounded shadow-md w-full max-w-xl">
        <h2 className="text-2xl font-bold mb-6 text-center">Profil</h2>

        <div className="mb-6 space-y-2">
          <p><span className="font-semibold">Email :</span> {utilisateur.email}</p>
          <p><span className="font-semibold">Mot de passe :</span> {utilisateur.motDePasse}</p>
        </div>

        <h3 className="text-lg font-semibold mb-2">Voitures empruntées :</h3>
        {utilisateur.emprunts.length === 0 ? (
          <p className="text-gray-600">Aucune voiture empruntée.</p>
        ) : (
          <ul className="space-y-2 mb-6">
            {utilisateur.emprunts.map((voiture, index) => (
              <li
                key={index}
                className="border rounded px-4 py-2 bg-gray-50 flex justify-between items-center"
              >
                <div>
                  <p className="font-medium">{voiture.modele}</p>
                  <p className="text-sm text-gray-600">Plaque : {voiture.plaque}</p>
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