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
    #[Groups(['article:read', 'article:write'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'article.title.empty')]
    #[Assert\Length(min: 5, max: 90,
        minMessage: 'article.title.minMessage',
        maxMessage: 'article.title.MaxMessage')
    ]
    #[Groups(['article:read', 'article:write'])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups(['article:read', 'article:write'])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[Groups(['article:read'])]
    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[Groups(['article:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[Groups(['article:read', 'article:write'])]
    #[ORM\ManyToOne(targetEntity: Author::class, cascade: ['persist'], inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
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
