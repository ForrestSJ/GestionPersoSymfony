<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 *
 * @ORM\Table(name="transaction")
 * @ORM\Entity
 */
class Transaction
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
     * @var \AppBundle\Entity\TypeTransaction
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeTransaction")
     * @ORM\JoinColumn(name="typeTransactionId", referencedColumnName="id")
     */
    private $typeTransaction;

    /**
     * @var \AppBundle\Entity\Facture
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture", inversedBy="transactions")
     * @ORM\JoinColumn(name="factureId", referencedColumnName="id")
     */
    private $facture;


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
     * @return Transaction
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
     * @return Transaction
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
     * @return Transaction
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
     * Set typeTransaction
     *
     * @param \AppBundle\Entity\TypeTransaction $typeTransaction
     *
     * @return Transaction
     */
    public function setTypeTransaction(\AppBundle\Entity\TypeTransaction $typeTransaction = null)
    {
        $this->typeTransaction = $typeTransaction;

        return $this;
    }

    /**
     * Get typeTransaction
     *
     * @return \AppBundle\Entity\TypeTransaction
     */
    public function getTypeTransaction()
    {
        return $this->typeTransaction;
    }

    /**
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Transaction
     */
    public function setFacture(\AppBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }
}
