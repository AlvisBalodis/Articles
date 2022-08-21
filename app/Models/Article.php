<?php

namespace App\Models;

class Article
{
    private string $title;
    private string $description;
    private string $url;
    private string $image;
    private ?int $id;

    public function __construct(string $title, string $description, string $url, string $image, ?int $id = 0)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->image = $image;
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUrl(): string
    {
        return !empty($this->url) ? $this->url : '/articles/' . $this->getId();
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}