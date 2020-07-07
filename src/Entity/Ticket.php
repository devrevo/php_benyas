<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=30)
     */
    private $priorite;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="date")
     */
    private $datecreation;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateecheance;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $statut;

     /**
     * @ORM\ManyToOne(targetEntity=Personel::class, inversedBy="tickets")
     */
    private $personel;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

       public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(?\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    public function getDateecheance(): ?\DateTimeInterface
    {
        return $this->dateecheance;
    }

    public function setDateecheance(\DateTimeInterface $dateecheance): self
    {
        $this->dateecheance = $dateecheance;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPersonel(): ?Personel
    {
        return $this->personel;
    }

    public function setPersonel(?Personel $personel): self
    {
        $this->personel = $personel;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
