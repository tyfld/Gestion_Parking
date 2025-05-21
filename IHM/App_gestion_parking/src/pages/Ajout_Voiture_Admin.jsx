import { useState } from "react";

function Ajout_Voiture_Admin() {

    const [form, setForm] = useState({
        marque: "",
        plaque: "",
        annee: "",
        disponible: true,
      });
    
      const [voitures, setVoitures] = useState([]);
    
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
    
        // Réinitialise le formulaire
        setForm({ marque: "", plaque: "", annee: "", disponible: true });
    
        alert("Voiture ajoutée !");
      };
    
      return (
        <div className="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-4">
          <div className="bg-white p-8 rounded shadow-md w-full max-w-xl">
            <h2 className="text-2xl font-bold mb-6 text-center">Ajouter une voiture</h2>
    
            <form onSubmit={handleSubmit} className="space-y-4">
              <input
                type="text"
                name="marque"
                placeholder="Marque / Modèle"
                value={form.marque}
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
              <input
                type="number"
                name="annee"
                placeholder="Année"
                value={form.annee}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
                required
              />
              <label className="flex items-center space-x-2">
                <input
                  type="checkbox"
                  name="disponible"
                  checked={form.disponible}
                  onChange={handleChange}
                  className="w-4 h-4"
                />
                <span>Disponible</span>
              </label>
    
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
                      <p className="font-medium">{v.marque} ({v.annee})</p>
                      <p className="text-sm text-gray-600">
                        Plaque : {v.plaque} — {v.disponible ? "Disponible" : "Indisponible"}
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