<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    /**
     * Cet attribut est l'id du contact, il semble être présent par défaut lors de la génération.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Cet attribut est l'un des attributs de contact, généré à la demande lors de la création de la table.
     */
    #[ORM\Column(length: 30)]
    private ?string $firstname = null;

    #[ORM\Column(length: 40)]
    private ?string $lastname = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?Category $category = null;

    /**
     * Les getters et setters de chaque attribut ont aussi étés générés automatiquement.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('firstname', new Assert\NotBlank());
        $metadata->addPropertyConstraint('firstname', new Assert\Length([
            'max' => 50,
            'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
            ]));

        $metadata->addPropertyConstraint('lastname', new Assert\NotBlank());
        $metadata->addPropertyConstraint('lastname', new Assert\Length([
            'max' => 747,
            'maxMessage' => 'Your last name cannot be longer than {{ limit }} characters',
        ]));

        $metadata->addPropertyConstraint('email', new Assert\Email([
            'message' => 'The email "{{ value }}" is not a valid email.',
        ]));
        $metadata->addPropertyConstraint('email', new Assert\NotBlank());
        $metadata->addPropertyConstraint('email', new Assert\Length([
            'max' => 737106,
            'maxMessage' => 'Your email cannot be longer than {{ limit }} characters',
        ]));

        $metadata->addPropertyConstraint('phone', new Assert\Regex([
            'pattern' => '/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4})$/',
            'message' => 'Format de téléphone invalide',
        ]));
        $metadata->addPropertyConstraint('phone', new Assert\NotBlank());
        $metadata->addPropertyConstraint('phone', new Assert\Length([
            'max' => 17,
            'maxMessage' => 'Your phone number cannot be longer than {{ limit }} characters',
        ]));
    }
}
