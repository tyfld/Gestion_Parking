import { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";

function Ajout_Utilisateur_Admin() {

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

        try {
          let role_bdd;
          if (form.role === "utilisateur") {
            role_bdd = 0;
          } else if (form.role === "admin") {
            role_bdd = 1;
          }
          const URL = "http://localhost/projets/Gestion_Parking/inscription-admin";
          fetch(URL, {
            method: "POST",
            credentials: "include",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              "nom": form.nom,
              "email": form.email,
              "role_utilisateur": role_bdd,
              "mot_de_passe": form.motDePasse
            }),
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Utilisateur ajoutée avec succès !");
            } else {
              alert(data.message || "Erreur lors de l'ajout d'un utilisateur.");
            }
          })
        } catch (error) {
          console.error("Erreur lors de la création du compte :", error);
          alert("Une erreur est survenue. Veuillez réessayer plus tard.");
          return;
        }

        setForm({
          nom: "",
          email: "",
          motDePasse: "",
          role: "utilisateur",
        });
    };
    
    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-gray-100 px-4">
        <Link to="/">
          <button className="border rounded-full px-4 py-2">Accueil</button>
        </Link>
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