import { useState } from "react";

function Ajout_Utilisateur_Admin() {

    const [form, setForm] = useState({
        nom: "",
        email: "",
        motDePasse: "",
        role: "utilisateur",
    });
    
    const [utilisateurs, setUtilisateurs] = useState([]);
    
    const handleChange = (e) => {
    const { name, value } = e.target;
        setForm({ ...form, [name]: value });
    };
    
    const handleSubmit = (e) => {
        e.preventDefault();
        setUtilisateurs([...utilisateurs, form]);
        setForm({
          nom: "",
          email: "",
          motDePasse: "",
          role: "utilisateur",
        });
        alert("Utilisateur ajouté !");
    };
    
    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
        <div className="bg-white p-8 rounded shadow-md w-full max-w-xl">
        <h2 className="text-2xl font-bold mb-6 text-center">Ajouter un utilisateur</h2>
    
        <form onSubmit={handleSubmit} className="space-y-4">
            <input
                type="text"
                name="nom"
                placeholder="Nom"
                value={form.nom}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
                required
            />
            <input
                type="email"
                name="email"
                placeholder="Email"
                value={form.email}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
                required
            />
            <input
                type="password"
                name="motDePasse"
                placeholder="Mot de passe"
                value={form.motDePasse}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
                required
            />
            <select
                name="role"
                value={form.role}
                onChange={handleChange}
                className="border rounded px-4 py-2 w-full"
            >
                <option value="utilisateur">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
    
            <button
                type="submit"
                className="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 w-full"
            >
                Ajouter
            </button>
            </form>
    
            {/* Liste des utilisateurs ajoutés */}
            {utilisateurs.length > 0 && (
              <div className="mt-8">
                <h3 className="text-lg font-semibold mb-2">Utilisateurs ajoutés :</h3>
                <ul className="space-y-2">
                  {utilisateurs.map((u, i) => (
                    <li key={i} className="bg-gray-50 border rounded px-4 py-2">
                      <p className="font-medium">{u.nom} ({u.role})</p>
                      <p className="text-sm text-gray-600">Email : {u.email}</p>
                    </li>
                  ))}
                </ul>
              </div>
            )}
          </div>
        </div>
      );
}

export default Ajout_Utilisateur_Admin;