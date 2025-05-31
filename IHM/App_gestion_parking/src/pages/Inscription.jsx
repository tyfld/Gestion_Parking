import { useState, useEffect } from "react";
import { Link, useNavigate } from "react-router-dom";

function Inscription() {
    
    const [sessionData, setSessionData] = useState({"session": false});
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
        if (sessionData.session) {
            navigate("/");
        }
    }
        
    useEffect(() => {
        fetchSession();
    }, [])

    useEffect(() => {
    if (sessionData !== null && sessionData.session === true) {
      navigate("/")
    }
  }, [sessionData, navigate])
    
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
        try {
            const URL = "http://localhost/projets/Gestion_Parking/inscription";
            fetch(URL, {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    "nom": form.nom,
                    "email": form.email,
                    "mot_de_passe": form.motDePasse,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Compte créé avec succès !");
                    navigate("/connexion");
                } else {
                    setErreur(data.message || "Erreur lors de la création du compte.");
                }
            })
        } catch (error) {
            console.error("Erreur lors de la création du compte :", error);
            setErreur("Une erreur est survenue. Veuillez réessayer plus tard.");
            return;
        }
    };
    
    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">

            {/* En-tête */}
            <header className="flex justify-between items-center mb-8">
                <Link to="/">
                <button className="border rounded-full px-4 py-2">Accueil</button>
                </Link>
            </header>

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