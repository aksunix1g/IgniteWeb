<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ProduitRepository;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_produit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_produit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie_produit;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix_produit;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantite_produit;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description_produit;

    /**
     * @ORM\ManyToMany(targetEntity=Commande::class, mappedBy="produit")
     */
    private $commandes;



    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(?string $nom_produit): self
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getImageProduit(): ?string
    {
        return $this->image_produit;
    }

    public function setImageProduit(?string $image_produit): self
    {
        $this->image_produit = $image_produit;

        return $this;
    }

    public function getCategorieProduit(): ?string
    {
        return $this->categorie_produit;
    }

    public function setCategorieProduit(string $categorie_produit): self
    {
        $this->categorie_produit = $categorie_produit;

        return $this;
    }

    public function getPrixProduit(): ?float
    {
        return $this->prix_produit;
    }

    public function setPrixProduit(?float $prix_produit): self
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }

    public function getQuantiteProduit(): ?int
    {
        return $this->quantite_produit;
    }

    public function setQuantiteProduit(?int $quantite_produit): self
    {
        $this->quantite_produit = $quantite_produit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->description_produit;
    }

    public function setDescriptionProduit(?string $description_produit): self
    {
        $this->description_produit = $description_produit;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }

    public function __toString():String
    {
        return $this->nom_produit;
    }

}
