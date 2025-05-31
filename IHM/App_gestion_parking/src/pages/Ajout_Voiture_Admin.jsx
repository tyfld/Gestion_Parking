import { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";

function Ajout_Voiture_Admin() {

  const [sessionData, setSessionData] = useState({"session": false});
  const [voitures, setVoitures] = useState([]);
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
    
  useEffect(() => {
    fetchSession();
  }, [])

  useEffect(() => {
    if (sessionData.session && sessionData.role != 1) {
      navigate("/")
    }
  }, [sessionData, navigate])

  const [form, setForm] = useState({
    modele: "",
    plaque: "",
  });
    
  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setForm({
      ...form,
      [name]: type === "checkbox" ? checked : value,
    });
  };
    
  const handleSubmit = (e) => {
    e.preventDefault();
    setVoitures([...voitures, form]);

    try {
      const URL = "http://localhost/projets/Gestion_Parking/ajouter-voiture";
      fetch(URL, {
        method: "POST",
        credentials: "include",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
          "modele": form.modele,
          "plaque_immatriculation": form.plaque
        }),
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Voiture ajoutée avec succès !");
        } else {
          alert(data.message || "Erreur lors de l'ajout d'une voiture'.");
        }
      })
    } catch (error) {
      console.error("Erreur lors de la création de la voiture :", error);
      alert("Une erreur est survenue. Veuillez réessayer plus tard.");
      return;
    }
    // Réinitialise le formulaire
    setForm({ modele: "", plaque: ""});
  };
    
      return (
        <div className="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-4">
          <Link to="/">
            <button className="border rounded-full px-4 py-2">Accueil</button>
          </Link>
          <div className="bg-white p-8 rounded shadow-md w-full max-w-xl">
            <h2 className="text-2xl font-bold mb-6 text-center">Ajouter une voiture</h2>
    
            <form onSubmit={handleSubmit} className="space-y-4">
              <input
                type="text"
                name="modele"
                placeholder="Marque / Modèle"
                value={form.modele}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
                required
              />
              <input
                type="text"
                name="plaque"
                placeholder="Plaque d'immatriculation"
                value={form.plaque}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
                required
              />
    
              <button
                type="submit"
                className="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 w-full"
              >
                Ajouter
              </button>
            </form>
    
            {/* Liste des voitures ajoutées */}
            {voitures.length > 0 && (
              <div className="mt-8">
                <h3 className="text-lg font-semibold mb-2">Voitures ajoutées :</h3>
                <ul className="space-y-2">
                  {voitures.map((v, i) => (
                    <li key={i} className="bg-gray-50 border rounded px-4 py-2">
                      <p className="font-medium">{v.modele}</p>
                      <p className="text-sm text-gray-600">
                        Plaque : {v.plaque_immatriculation}
                      </p>
                    </li>
                  ))}
                </ul>
              </div>
            )}
          </div>
        </div>
      );
}

export default Ajout_Voiture_Admin;