<?php

namespace src\Controllers;

use src\Models\Ile;
use src\Models\Ville;
use src\Models\Produit;
use src\Controllers\Controller;


class PanierController extends Controller {

    public function panier(?array $panier = null)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            var_dump($_POST);

            
        }else {
            $villes = (new Ville($this->db))->all("nom_ville", "ASC");

            $iles = (new Ile($this->db))->all("ile_nom", "ASC");
            
            $produits = new Produit($this->db);
            $produits = $produits->all("produit_id");
        }
        
        return $this->twig->display("boutique/panier.html.twig", compact("panier", "villes", "iles", "produits"));
    }
}