import { useParams, Link } from "react-router-dom";

function Emprunter() {
  const { id } = useParams(); // id passé dans l'URL (ex: /emprunter/2)

  // Exemple de données simulées (à remplacer par une API plus tard)
  const voiture = {
    id,
    modele: "Toyota Yaris",
    plaque: "AB-123-CD",
  };

  const handleEmprunt = () => {
    // Action à effectuer pour emprunter
    alert(`Vous avez emprunté la voiture ${voiture.modele}`);
    // API call ici
  };

  return (
    <div className="min-h-screen bg-gray-100 p-6">
      {/* En-tête */}
      <header className="flex justify-between items-center mb-8">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
        <h1 className="text-2xl font-bold">Emprunter</h1>
        <button className="border rounded-full px-4 py-2">Profil</button>
      </header>

      {/* Contenu principal */}
      <div className="flex flex-col items-center gap-6 mt-12">
        <p className="text-xl">
          <strong>Modèle:</strong> {voiture.modele}
        </p>
        <p className="text-xl">
          <strong>Plaque d'immatriculation:</strong> {voiture.plaque}
        </p>

        <button
          onClick={handleEmprunt}
          className="border px-6 py-2 rounded hover:bg-gray-100"
        >
          Emprunter cette voiture
        </button>

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
