<?php

namespace src\Controllers;

use src\Models\Ile;
use src\Models\Pays;
use src\Models\Slide;
use src\Models\Ville;
use src\Models\Produit;
use src\Models\Categorie;
use src\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Afficher la page d'accueil du site
     *
     * @return void
     */
    public function home()
    {
        $produits = new Produit($this->db);
        $produits = $produits->all("produit_id");
        
        $slides = (new Slide($this->db))->all("slide_id");

        $categories = (new Categorie($this->db))->all("categorie_id");

        return $this->twig->display("boutique/index.html.twig", compact("produits", "slides", "categories"));
    }

    /**
     * Afficher les détails d'un article
     *
     * @param integer $id
     * @return void
     */
    public function afficher_produit(int $id)
    {
        $produits = new Produit($this->db);
        $produit = $produits->afficherParId("produit_id", $id);
        return $this->twig->display("boutique/details_article.html.twig", compact("produit"));
    }

    /**
     * Afficher les détails d'un article
     *
     * @param integer $id
     * @return void
     */
    public function afficher(string $slug)
    {
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            var_dump($_POST);
            
       } else {
            $produits = new Produit($this->db);
            $produit = $produits->afficherParId("slug", $slug);
            $produits = new Produit($this->db);
            $produits = $produits->all("produit_id");
            $imgs = (unserialize($produit->photos))['name'];
       }
       

        return $this->twig->display("boutique/details_article.html.twig", compact("produit", "imgs", "produits"));
    }

    public function catalogue()
    {
        $produits = new Produit($this->db);
        $produits = $produits->all("produit_id");
        

        $categories = (new Categorie($this->db))->all("categorie_id");

        return $this->twig->display("boutique/catalogue.html.twig", compact("produits", "categories"));
    }


    public function panier(?array $panier = null)
    {
        $villes = (new Ville($this->db))->all("nom_ville", "ASC");

        $iles = (new Ile($this->db))->all("ile_nom", "ASC");
        
        $produits = new Produit($this->db);
        $produits = $produits->all("produit_id");
        
        return $this->twig->display("boutique/panier.html.twig", compact("panier", "villes", "iles", "produits"));
    }

    /**
     * fonction de recherche
     *
     * @return void
     */
    public function recherche()
    {
        # code...
    }
}