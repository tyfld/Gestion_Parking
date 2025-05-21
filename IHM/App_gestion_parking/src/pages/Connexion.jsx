import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";

function Connexion() {

    const navigate = useNavigate();

  const [form, setForm] = useState({
    email: "",
    motDePasse: "",
  });

  const [erreur, setErreur] = useState("");

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    // TODO: vérification via une vraie API (backend)
    if (form.email === "admin@example.com" && form.motDePasse === "admin123") {
      // Exemple fictif
      alert("Connexion réussie !");
      navigate("/"); // Redirige vers la page d’accueil
    } else {
      setErreur("Identifiants incorrects.");
    }
  };

  return (
    <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
      <div className="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 className="text-2xl font-bold mb-6 text-center">Connexion</h2>

        {erreur && <p className="text-red-500 mb-4">{erreur}</p>}

        <form onSubmit={handleSubmit} className="flex flex-col gap-4">
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

          <button
            type="submit"
            className="bg-blue-600 text-white py-2 rounded hover:bg-blue-700"
          >
            Se connecter
          </button>
        </form>

        <p className="text-sm text-center mt-4">
          Pas encore de compte ?{" "}
          <Link to="/inscription" className="text-blue-600 hover:underline">
            S'inscrire
          </Link>
        </p>
      </div>
    </div>
  );
}

export default Connexion;