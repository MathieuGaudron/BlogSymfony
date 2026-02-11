<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Comment
{
    public const STATUS_VALIDATED = 'valide';
    public const STATUS_PENDING   = 'en_attente';
    public const STATUS_DELETED   = 'supprime';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 30)]
    private ?string $status = self::STATUS_PENDING;

    // Comment -> User
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $author = null;

    // Comment -> Post
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $post = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getContent(): ?string { return $this->content; }
    public function setContent(string $content): static { $this->content = $content; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->createdAt; }
    public function setCreatedAt(\DateTimeImmutable $createdAt): static { $this->createdAt = $createdAt; return $this; }

    public function getStatus(): ?string { return $this->status; }
    public function setStatus(string $status): static { $this->status = $status; return $this; }

    public function getAuthor(): ?User { return $this->author; }
    public function setAuthor(User $author): static { $this->author = $author; return $this; }

    public function getPost(): ?Post { return $this->post; }
    public function setPost(Post $post): static { $this->post = $post; return $this; }
}
