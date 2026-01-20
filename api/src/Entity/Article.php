<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ORM\Table(name: 'articles')]
class Article
{
    #[Groups(['article:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Le titre ne peut être vide')]
    #[Assert\Length(min: 5, max: 90,
        minMessage: 'Le titre ne peut faire moins de {{ limit }} caractères',
        maxMessage: 'Le titre ne peut faire plus de {{ limit }} caractères')
    ]
    #[Groups(['article:read'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['article:read'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['article:read'])]
    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[Groups(['article:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[Groups(['article:read'])]
    #[ORM\ManyToOne(targetEntity: Author::class, cascade: ['persist'], inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): static
    {
        $this->author = $author;

        return $this;
    }
}
