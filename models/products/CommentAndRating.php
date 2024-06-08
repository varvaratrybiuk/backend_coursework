<?php

namespace models\products;

class CommentAndRating
{
    private int $id;
    private int $userId;
    private int $productId;
    private string $comment;
    private int $stars;
    public function __construct(int $userId, int $productId, string $comment, int $stars)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->comment = $comment;
        $this->stars = $stars;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function getProductId(): int
    {
        return $this->productId;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function getStars(): int
    {
        return $this->stars;
    }
}