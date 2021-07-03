<?php
/*
Plugin Name: insertion pneu
Plugin URI:
Description: Plugin insertion
Author: Yann tyb
Version: 1.0
Author URI: http://mon-siteweb.com/
*/

require_once __DIR__ . "./Entity/Pneu.php";
require_once __DIR__ . "./Entity/Categorie.php";
require_once __DIR__ . "./Classe/DB.php";
require_once __DIR__ . "./Trait/Manager.php";
require_once __DIR__ . "./Manager/Pneu_manager.php";

use Plugin\Entity\Categorie;
use Plugin\Entity\Pneu;
use Plugin\Manager\Pneu_manager;

class classPneu{
    public function __construct(){
        add_action( 'admin_menu', [ $this, 'my_plugin_menu'] );
        wp_enqueue_style("style", plugin_dir_url(__FILE__) . "/inc/style.css", array(), "1.0");
    }

    public function my_plugin_menu(){
        add_menu_page(
            __('Pneu', 'Pneu'), // Page title
            __('Pneu', 'Pneu'), // Menu title
            'manage_options',  // Capability
            'pneu', // Slug
            [ $this, 'firstPage'] // Callback page function
        );
        add_submenu_page("pneu", "Ajout de produit", "Ajout de produit", "manage_options","pneu_ajout",[ $this, 'showAddProduct']);
        add_submenu_page("pneu", "Suppression produit","Suppression produit","manage_options","pneu_sup", [$this, "showDeleteProduct"]);
    }

    public function firstPage(){
        echo "<h1>Plugin fait par Yann Tyb</h1><br>";
        echo "<span>Pour ajouter des produits, cliquer sur le sous menu 'Ajout de produit'</span>";
    }

    public function showDeleteProduct(){
        echo "<h1>Rechercher un pneu</h1>";
        echo "<form id='searchform' method='get' action='" . esc_url( home_url( '/' ) ) . "'>
            <input type='text' class='search-field' name='s' placeholder='Search' value='" .  get_search_query() . "'>
            <input type='submit' value='Search'>
        </form>";
    }

    public function showAddProduct(){
        echo
        "
            <h1>Résultat</h1>
           
        ";
        $this->addProduct();
    }

    public function addProduct(){
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, '<command>');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_USERPWD, 'melmo01' . ':' . '8hp7md');

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        $inserted = [];
        $pneu = new Pneu();
        $cat = new Categorie();

        $cat
            ->setName("cat_test5")
            ->setId();

        $pneu
            ->setName("bla")
            ->setDesc("test")
            ->setPrix("12")
            ->setStock("16")
            ->setTaille("test")
            ->setClasse("test")
            ->setCapaciteCharge("test")
            ->setCapaciteChargeVersion("test")
            ->setVitesseMax("test")
            ->setConsomationCarburant("bla")
            ->setAdherence("test")
            ->setBruitExt("test")
            ->setDecibels("test5")
            ->setNeige("test")
            ->setGlace("test")
            ->setFullName("test")
            ->setCategorie($cat);

        $pneu2 = clone $pneu;
        $pneu2
            ->setPrix("10")
            ->setName("blo");

        $pneus = [["pneu" => $pneu, "cat" => $cat],["pneu" => $pneu2, "cat" => $cat]];
        $manager = new Pneu_manager();

        //Insertion des pneus en BDD
        foreach($pneus as $pneuOne){
            $pneuOne["cat"]->setId();
            $pneuOne["pneu"]->setCategorie($pneuOne["cat"]);
            $inserted[] = $manager->product_insert($pneuOne["pneu"]);
        }

        //Affichage des log
        echo "<table><tr><th>action</th><th>nom du produit</th></tr>";
        foreach($inserted as $log){
            if($log["error"] === "true"){$color = "#FCA299";}else{$color = "#A4F792";}
            echo
            "
                <tr style='border: 1px solid black; background-color: ". $color  . "'>
                    <td style='border: 1px solid black'>{$log['error_type']}</td>
                    <td style='border: 1px solid black'>{$log['name']}</td>
                </tr>
                    
            ";
        }
        echo "</table>";
    }
}

new classPneu();
