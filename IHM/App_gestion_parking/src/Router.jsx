import { createBrowserRouter, RouterProvider} from "react-router-dom";
import Home from "./pages/Home";
import Liste_Voitures from "./pages/Liste_Voitures";
import Inscription from "./pages/Inscription";
import Connexion from "./pages/Connexion";
import Profil from "./pages/Profil";
import Emprunter from "./pages/Emprunter";
import Historique_Emprunt from "./pages/Historique_Emprunt";
import Ajout_Utilisateur_Admin from "./pages/Ajout_Utilisateur_Admin";
import Ajout_Voiture_Admin from "./pages/Ajout_Voiture_Admin";

const router = createBrowserRouter([
    {
        path: "/",
        element: <Home />
    },
    {
        path: "/voitures",
        element: <Liste_Voitures />
    },
    {
        path: "/inscription",
        element: <Inscription />
    },
    {
        path: "/connexion",
        element: <Connexion />
    },
    {
        path: "/profil",
        element: <Profil />
    },
    {
        path: "/emprunter",
        element: <Emprunter />
    },
    {
        path: "/historique_emprunt",
        element: <Historique_Emprunt />
    },
    {
        path: "/ajout_utilisateur",
        element: <Ajout_Utilisateur_Admin />
    },
    {
        path: "/ajout_voiture",
        element: <Ajout_Voiture_Admin />
    },
])

export default function Router() {
    return (
        <RouterProvider router={router} />
    )
}