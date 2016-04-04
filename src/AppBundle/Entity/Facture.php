<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity
 */
class Facture
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
     * @ORM\Column(name="lieu", type="string", length=50)
     */
    private $lieu;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="decimal", precision=10, scale=5)
     */
    private $montant;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="Operation", mappedBy="facture")
     */
    private $operations;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FactureLigne", mappedBy="facture", cascade={"persist"})
     */
    private $lignes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FactureFidelite", mappedBy="facture", cascade={"persist"})
     */
    private $fidelites;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->lignes = new ArrayCollection();
        $this->fidelites = new ArrayCollection();
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
     * Set lieu
     *
     * @param string $lieu
     *
     * @return Facture
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set montant
     *
     * @param string $montant
     *
     * @return Facture
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return string
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Facture
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add operation
     *
     * @param Operation $operation
     *
     * @return Facture
     */
    public function addOperation(Operation $operation)
    {
        $this->operations[] = $operation;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param Operation $operation
     */
    public function removeOperation(Operation $operation)
    {
        $this->operations->removeElement($operation);
    }

    /**
     * Get operations
     *
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Add ligne
     *
     * @param FactureLigne $ligne
     *
     * @return Facture
     */
    public function addLigne(FactureLigne $ligne)
    {
        if($ligne) $ligne->setFacture($this);
        $this->lignes[] = $ligne;

        return $this;
    }

    /**
     * Remove ligne
     *
     * @param FactureLigne $ligne
     */
    public function removeLigne(FactureLigne $ligne)
    {
        $this->lignes->removeElement($ligne);
    }

    /**
     * Get lignes
     *
     * @return FactureLigne[]
     */
    public function getLignes()
    {
        return $this->lignes;
    }

    /**
     * Add fidelite
     *
     * @param FactureFidelite $fidelite
     *
     * @return Facture
     */
    public function addFidelite(FactureFidelite $fidelite)
    {
        if($fidelite) $fidelite->setFacture($this);
        $this->fidelites[] = $fidelite;

        return $this;
    }

    /**
     * Remove fidelite
     *
     * @param FactureFidelite $fidelite
     */
    public function removeFidelite(FactureFidelite $fidelite)
    {
        $this->fidelites->removeElement($fidelite);
    }

    /**
     * Get fidelites
     *
     * @return FactureFidelite[]
     */
    public function getFidelites()
    {
        return $this->fidelites;
    }
}
