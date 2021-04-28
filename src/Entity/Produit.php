<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="categorieProduit", columns={"categorieProduit"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="idProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="nomProduit", type="string", length=30, nullable=false)
     * @Assert\NotNull(message="ce champs ne peut pas etre null")
     */
    private $nomproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="imageProduit", type="string", length=100, nullable=false)
     */
    private $imageproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="categorieProduit", type="integer", nullable=false)
     */
    private $categorieproduit;

    /**
     * @var float
     *
     * @ORM\Column(name="prixProduit", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotNull(message="ce champs ne peut pas etre null")
     * 
     * @Assert\Length(min=3, minMessage="Le prix  doit contenir au minimum 3 caracteres !")
     */
    private $prixproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="quantiteProduit", type="integer", nullable=false)
     * @Assert\NotNull(message="ce champs ne peut pas etre null")
     */
    private $quantiteproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionProduit", type="string", length=300, nullable=false)
     *@Assert\NotNull(message="ce champs ne peut pas etre null")
     */
    private $descriptionproduit;

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getNomproduit(): ?string
    {
        return $this->nomproduit;
    }

    public function setNomproduit(string $nomproduit): self
    {
        $this->nomproduit = $nomproduit;

        return $this;
    }

    public function getImageproduit()
    {
        return $this->imageproduit;
    }

    public function setImageproduit( $imageproduit)
    {
        $this->imageproduit = $imageproduit;

        return $this;
    }

    public function getCategorieproduit(): ?int
    {
        return $this->categorieproduit;
    }

    public function setCategorieproduit(int $categorieproduit): self
    {
        $this->categorieproduit = $categorieproduit;

        return $this;
    }

    public function getPrixproduit(): ?float
    {
        return $this->prixproduit;
    }

    public function setPrixproduit(float $prixproduit): self
    {
        $this->prixproduit = $prixproduit;

        return $this;
    }

    public function getQuantiteproduit(): ?int
    {
        return $this->quantiteproduit;
    }

    public function setQuantiteproduit(int $quantiteproduit): self
    {
        $this->quantiteproduit = $quantiteproduit;

        return $this;
    }

    public function getDescriptionproduit(): ?string
    {
        return $this->descriptionproduit;
    }

    public function setDescriptionproduit(string $descriptionproduit): self
    {
        $this->descriptionproduit = $descriptionproduit;

        return $this;
    }


}
