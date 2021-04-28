<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="categorieProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $categorieproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="nomCategorie", type="string", length=50, nullable=false)
     * @Assert\NotNull(message="ce champs ne peut pas etre null")
     */
    private $nomcategorie;

    public function getCategorieproduit(): ?int
    {
        return $this->categorieproduit;
    }

    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(string $nomcategorie): self
    {
        $this->nomcategorie = $nomcategorie;

        return $this;
    }


}
