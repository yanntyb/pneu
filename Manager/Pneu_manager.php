<?php

namespace Plugin\Manager;

require_once __DIR__ . "/../Entity/Categorie.php";
require_once __DIR__ . "/../Entity/Pneu.php";

use Plugin\Entity\Pneu;
use Plugin\Traits\GlobalManager;

class Pneu_manager
{
    use GlobalManager;

    /**
     * Check si le pneu a deja été inséré
     * @param Pneu $product
     * @return false|mixed|string
     */
    public function selectInDB(Pneu $product)
    {
        $conn = $this->db->prepare("SELECT * FROM pneu WHERE name = :name AND catID = :cat");
        $conn->bindValue(":name", $product->getName());
        $conn->bindValue(":cat", $product->getCategorie()->getId());
        if ($conn->execute()) {
            $id = $conn->fetch();
            if ($id) {
                return $id;
            } else {
                return false;
            }
        } else {
            return "error";
        }
    }

    /**
     * Insertion du pneu en BDD
     * @param Pneu $product
     * @param int $product_id
     * @return bool
     */
    public function insertInDB(Pneu $product)
    {
        $conn = $this->db->prepare("INSERT INTO pneu 
                                            (name, catID, stock, product_id, price, taille, classe, capacite_charge, capacite_charge_version, vitesse_max, conso_carburant, adherence, bruit_ext, decibels, neige, glace, full_name) 
                                            VALUES 
                                                   (:name, :catID, :stock, 0, :price, :taille, :classe, :capacite_charge, :capacite_charge_version, :vitesse_max, :conso_carburant, :adherence, :bruit_ext, :decibels, :neige, :glace, :full_name)");
        $conn->bindValue(":name", $product->getName());
        $conn->bindValue(":catID", $product->getCategorie()->getId());
        $conn->bindValue(":stock", $product->getStock());
        $conn->bindValue(":price", $product->getPrix());
        $conn->bindValue(":taille", $product->getTaille());
        $conn->bindValue(":classe", $product->getClasse());
        $conn->bindValue(":capacite_charge", $product->getCapaciteCharge());
        $conn->bindValue(":capacite_charge_version", $product->getCapaciteChargeVersion());
        $conn->bindValue(":vitesse_max", $product->getVitesseMax());
        $conn->bindValue(":conso_carburant", $product->getConsomationCarburant());
        $conn->bindValue(":adherence", $product->getAdherence());
        $conn->bindValue(":bruit_ext", $product->getBruitExt());
        $conn->bindValue(":decibels", $product->getDecibels());
        $conn->bindValue(":neige", $product->getNeige());
        $conn->bindValue(":glace", $product->getGlace());
        $conn->bindValue(":full_name", $product->getFullName());
        if ($conn->execute()) {
            return intval($this->db->lastInsertId());
        }
        return false;
    }

    /**
     * Update product_id (l'id du post wp correspondant au produit)
     * @param int $product_id
     * @param int $id
     * @return bool
     */
    public function updateProductId(int $product_id, int $id): bool
    {
        $conn = $this->db->prepare("UPDATE pneu SET product_id = :product_id WHERE id = :id");
        $conn->bindValue(":id", $id);
        $conn->bindValue(":product_id", $product_id);
        if ($conn->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Update pneu en BDD avec le nouveau prix et le stock
     * @param Pneu $product
     * @param int $id
     * @return bool
     */
    private function updateInDB(Pneu $product, int $id): bool
    {
        $conn = $this->db->prepare("UPDATE pneu SET stock = :stock, price = :price WHERE id = :id");
        $conn->bindValue(":stock", $product->getStock());
        $conn->bindValue(":price", $product->getPrix());
        $conn->bindValue(":id", $id);
        if ($conn->execute()) {
            return true;
        }
        return false;

    }

    /**
     * Insert Pneu entity into woocommerce DB
     * @param Pneu $product
     * @return array
     */
    public function product_insert(Pneu $product): array
    {
        //Si le produit n'est pas encore en BDD alors on l'insert
        $select = $this->selectInDB($product);
        switch (gettype($select)) {

            //Cas ou le pneu n'a pas encore été inséré
            case "boolean":
                $insertion = $this->insertInDB($product);
                switch (gettype($insertion)) {
                    //Cas ou l'insertion a fonctionné
                    case "integer":
                        $post_id = wp_insert_post(array(
                            'post_author' => 1,
                            'post_title' => $product->getName(),
                            'post_content' => "<table>
                                                    <tr>
                                                        <td><strong>Désignation</strong></td>
                                                        <td>{$product->getName()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Désignation complète</strong></td>
                                                        <td>{$product->getFullName()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Taille</strong></td>
                                                        <td>{$product->getTaille()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Classe</strong></td>
                                                        <td>{$product->getClasse()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Index de capacité de charge</strong></td>
                                                        <td>{$product->getCapaciteCharge()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Version de capacité de charge</strong></td>
                                                        <td>{$product->getCapaciteChargeVersion()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Vitesse maximum</strong></td>
                                                        <td>{$product->getVitesseMax()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Consommation de carburant</strong></td>
                                                        <td>{$product->getConsomationCarburant()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Adhérence</strong></td>
                                                        <td>{$product->getAdherence()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Bruit extérieur</strong></td>
                                                        <td>{$product->getBruitExt()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Décibels</strong></td>
                                                        <td>{$product->getDecibels()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Utilisation sur neige</strong></td>
                                                        <td>{$product->getNeige()}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Utilisation sur glace</strong></td>
                                                        <td>{$product->getGlace()}</td>
                                                    </tr>
                                                    </table>",
                            'post_status' => 'publish',
                            'post_type' => "product",
                        ));

                        //Si erreur lors de l'insertion
                        if (!$post_id) {
                            return ["error" => "true", "error_type" => "BDD woocommerce insertion" , "name" => $product->getName() ];
                        }

                        //Sinon on set les meta du produit
                        else {
                            $this->updateProductId($post_id, $insertion);
                            $this->product_meta($post_id, $product);
                            return ["error" => "false", "error_type" => "Product insertion" , "name" => $product->getName() ];
                        }

                    //Cas ou l'insertion n'a pas fonctionné
                    case "boolean":
                        return ["error" => "true", "error_type" => "BDD insertion" , "name" => $product->getName() ];

                }
                break;

            //Cas ou le produit a deja été inséré
            case "array":

                //Check si il ya eu une modification des propriété
                $productArray =
                    [
                        "name" => $product->getName(),
                        "catID" => $product->getCategorie()->getId(),
                        "stock" => $product->getStock(),
                        "price" => $product->getPrix(),
                        "taille" => $product->getTaille(),
                        "classe" => $product->getClasse(),
                        "capacite_charge" => $product->getCapaciteCharge(),
                        "capacite_charge_version" => $product->getCapaciteChargeVersion(),
                        "vitesse_max" => $product->getVitesseMax(),
                        "conso_carburant" => $product->getConsomationCarburant(),
                        "adherence" => $product->getAdherence(),
                        "bruit_ext" => $product->getBruitExt(),
                        "decibels" => $product->getDecibels(),
                        "neige" => $product->getNeige(),
                        "glace" => $product->getGlace(),
                        "full_name" => $product->getFullName()
                    ];

                //Si il n'y a eu aucun changement alors aucunes modifications ne sont faites
                if(array_diff($productArray,$select) === []){
                    return ["error" => "false", "error_type" => "No change" , "name" => $product->getName() ];
                }

                //On update les champs de la BDD
                if ($this->updateInDB($product, $select["id"])) {
                    //On update les meta du produit
                    $this->product_meta($select["product_id"], $product);
                    return ["error" => "false", "error_type" => "BDD update" , "name" => $product->getName() ];
                }
                return ["error" => "true", "error_type" => "BDD connection", "name" => $product->getName()];

            //Cas ou il ya eu une erreur lors du select du produit en BDD
            case "string":
                return ["error" => "true", "error_type" => "BDD connection", "name" => $product->getName()];

        }
    }

    /**
     * Set les different parametres du produit
     * @param int $post_id
     * @param Pneu $product
     */
    public function product_meta(int $post_id, Pneu $product)
    {
        wp_set_object_terms($post_id, 'simple', 'product_type');
        update_post_meta($post_id, '_visibility', 'visible');
        update_post_meta($post_id, '_stock_status', 'instock');
        update_post_meta($post_id, '_manage_stock', 'yes');
        update_post_meta($post_id, '_price', $product->getPrix());
        update_post_meta($post_id, '_stock', $product->getStock());
        //Update postContent
        wp_update_post(["ID" => $post_id,"post_content" =>
            "
            <table>
                   <tr>
                        <td><strong>Désignation</strong></td>
                        <td>{$product->getName()}</td>
                    </tr>
                    <tr>
                        <td><strong>Désignation complète</strong></td>
                        <td>{$product->getFullName()}</td>
                    </tr>
                    <tr>
                        <td><strong>Taille</strong></td>
                        <td>{$product->getTaille()}</td>
                    </tr>
                    <tr>
                        <td><strong>Classe</strong></td>
                        <td>{$product->getClasse()}</td>
                    </tr>
                    <tr>
                        <td><strong>Index de capacité de charge</strong></td>
                        <td>{$product->getCapaciteCharge()}</td>
                    </tr>
                    <tr>
                        <td><strong>Version de capacité de charge</strong></td>
                        <td>{$product->getCapaciteChargeVersion()}</td>
                    </tr>
                    <tr>
                        <td><strong>Vitesse maximum</strong></td>
                        <td>{$product->getVitesseMax()}</td>
                    </tr>
                    <tr>
                        <td><strong>Consommation de carburant</strong></td>
                        <td>{$product->getConsomationCarburant()}</td>
                    </tr>
                    <tr>
                        <td><strong>Adhérence</strong></td>
                        <td>{$product->getAdherence()}</td>
                    </tr>
                    <tr>
                        <td><strong>Bruit extérieur</strong></td>
                        <td>{$product->getBruitExt()}</td>
                    </tr>
                    <tr>
                        <td><strong>Décibels</strong></td>
                        <td>{$product->getDecibels()}</td>
                    </tr>
                    <tr>
                        <td><strong>Utilisation sur neige</strong></td>
                        <td>{$product->getNeige()}</td>
                    </tr>
                    <tr>
                        <td><strong>Utilisation sur glace</strong></td>
                        <td>{$product->getGlace()}</td>
                    </tr>
            </table>"]
        );

        //Relie le produit a sa categorie
        wp_set_object_terms($post_id, $product->getCategorie()->getId(), 'product_cat');
    }


}