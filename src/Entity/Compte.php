<?php

namespace App\Entity;

use App\Repository\CompteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CompteRepository::class)
 * @UniqueEntity(
 *      fields={"Email"},
 *      message="L'email que vous avez indique est deja utilise !"
 * )
 */
class Compte implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255) 
     * @Assert\Email(
     *     message = "Entrez un email valide."
     * )
     */
    private $Email;

  /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length( min = 8 , minMessage="Votre mot de passe est trop court."
     * )
     */
    private $Password;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Personel::class, cascade={"persist", "remove"})
     */
    private $Personel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;


    
    public function eraseCredentials(){}

    public function getSalt(){}

    public function getRoles() : array
    {
        return ['ROLE_USER'];
    }
    public function __toString()
    {
        return $this->Username;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

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

    public function getPersonel(): ?Personel
    {
        return $this->Personel;
    }

    public function setPersonel(?Personel $Personel): self
    {
        $this->Personel = $Personel;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }
    public function serialize()
{
    //die('serialize');
    return serialize(array(
        $this->id,
        $this->Email,
        $this->Password
    ));
}

public function unserialize( $serialized )
{
    list (
        $this->id,
        $this->Email,
        $this->Password
        ) = unserialize($serialized, ['allowed_classes' => false]);
}
}
