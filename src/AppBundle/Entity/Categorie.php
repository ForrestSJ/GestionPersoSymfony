<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=50)
     */
    private $designation;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Categorie", mappedBy="parentCategorie")
     */
    private $sousCategories;

    /**
     * @var \AppBundle\Entity\Categorie
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Categorie", inversedBy="sousCategories")
     * @ORM\JoinColumn(name="parent_categorie_id", referencedColumnName="id")
     */
    private $parentCategorie;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sousCategories = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return Categorie
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Add sousCategory
     *
     * @param \AppBundle\Entity\Categorie $sousCategory
     *
     * @return Categorie
     */
    public function addSousCategory(Categorie $sousCategory)
    {
        $this->sousCategories[] = $sousCategory;

        return $this;
    }

    /**
     * Remove sousCategory
     *
     * @param \AppBundle\Entity\Categorie $sousCategory
     */
    public function removeSousCategory(Categorie $sousCategory)
    {
        $this->sousCategories->removeElement($sousCategory);
    }

    /**
     * Get sousCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSousCategories()
    {
        return $this->sousCategories;
    }

    /**
     * Set parentCategorie
     *
     * @param \AppBundle\Entity\Categorie $parentCategorie
     *
     * @return Categorie
     */
    public function setParentCategorie(Categorie $parentCategorie = null)
    {
        $this->parentCategorie = $parentCategorie;

        return $this;
    }

    /**
     * Get parentCategorie
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getParentCategorie()
    {
        return $this->parentCategorie;
    }
}
