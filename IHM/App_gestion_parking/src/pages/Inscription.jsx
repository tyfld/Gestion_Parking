import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";

function Inscription() {
    
    const navigate = useNavigate();
    
    const [form, setForm] = useState({
        nom: "",
        email: "",
        motDePasse: "",
        confirmation: "",
    });
    
    const [erreur, setErreur] = useState("");
    
    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };
    
    const handleSubmit = (e) => {
    e.preventDefault();
    
    // Vérification simple
    if (form.motDePasse !== form.confirmation) {
        setErreur("Les mots de passe ne correspondent pas.");
        return;
    }
    
    // TODO: envoyer les données vers une API
    alert("Compte créé !");
    navigate("/"); // Redirige vers l'accueil
    };
    
    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
        <div className="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 className="text-2xl font-bold mb-6 text-center">Créer un compte</h2>
    
        {erreur && <p className="text-red-500 mb-4">{erreur}</p>}
    
        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
            <input
            type="text"
            name="nom"
            placeholder="Nom"
            value={form.nom}
            onChange={handleChange}
            className="border rounded px-4 py-2"
            required
            />
            <input
            type="email"
            name="email"
            placeholder="Email"
            value={form.email}
            onChange={handleChange}
            className="border rounded px-4 py-2"
            required
            />
            <input
            type="password"
            name="motDePasse"
            placeholder="Mot de passe"
            value={form.motDePasse}
            onChange={handleChange}
            className="border rounded px-4 py-2"
            required
            />
            <input
            type="password"
            name="confirmation"
            placeholder="Confirmer le mot de passe"
            value={form.confirmation}
            onChange={handleChange}
            className="border rounded px-4 py-2"
            required
            />
    
            <button
            type="submit"
            className="bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
            >
                Créer un compte
            </button>
        </form>
    
        <p className="text-sm text-center mt-4">
            Déjà inscrit ?{" "}
            <Link to="/connexion" className="text-blue-600 hover:underline">
                Se connecter
            </Link>
        </p>
        </div>
    </div>
    );
}

export default Inscription;