<?php declare(strict_types=1);

namespace GiphyApp\Controllers;

use GiphyApp\Models\GiphyClient;

class GiphyController
{
    private GiphyClient $client;

    public function __construct()
    {
        $this->client = new GiphyClient();
    }

    public function search(): array
    {
        return $this->client->fetchSearched();
    }

    public function trending(): ?array
    {
        return $this->client->fetchTrending();
    }
}