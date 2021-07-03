<?php


namespace Plugin\Entity;


class Categorie
{
    private ?string $name;
    private ?int $id;

    /**
     * Categorie constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(?string $name): Categorie
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Créé une categorie si elle n'existe pas deja et set l'id de cette category
     *
     **/
    public function setId(): Categorie
    {
        //Recupere l'id de la categorie si elle existe
        $id = term_exists( $this->getName(), 'product_cat', "" );
        if ( is_array( $id ) ) {
            $id = $id['term_id'];
        }
        //Si elle n'existe pas il la créé
        else{
            wp_insert_term( $this->getName(), 'product_cat',
                array(
                    'description' => "desc", // optional
                )
            );
            //Enfin on recupere l'id de celle ci
            $id = term_exists( $this->getName(), 'product_cat', "" );
            if ( is_array( $id ) ) {
                $id = $id['term_id'];
            }
        }
        $this->id = $id;
        return $this;
    }


}