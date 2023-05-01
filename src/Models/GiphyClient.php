<?php declare(strict_types=1);

namespace GiphyApp\Models;

use GuzzleHttp\Client;

class GiphyClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchSearched() : array
    {
        $response = $this->client->get('api.giphy.com/v1/gifs/search', [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'q' => 'cats',
                'limit' => 6,
                'offset' => floor(rand(0, 1000))
            ]
        ]);
        return $this->createCollection(json_decode($response->getBody()->getContents())->data);
    }

    public function fetchTrending(): array
    {
        $response = $this->client->get('api.giphy.com/v1/gifs/trending', [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'limit' => 4,
                'offset' => floor(rand(0, 1000))
            ]
        ]);
        return $this->createCollection(json_decode($response->getBody()->getContents())->data);
    }

    private function createCollection(array $fetchedRecords): array
    {
        $collection = [];
        foreach ($fetchedRecords as $giphy) {
            $collection[] = new Giphy(
                $giphy->title,
                $giphy->images->fixed_height->url
            );
        }
        return $collection;
    }
}