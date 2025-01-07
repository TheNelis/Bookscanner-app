<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class BookDataController extends Controller
{
    public function getBook($isbn)
    {
        try {
            $client = new Client();

            $query = [
                'query' => 'query BookData {
                    editions(where: {isbn_13: {_eq: "' . $isbn . '"}}) {
                        book {
                            title
                            image {
                                url
                            }
                            cached_contributors
                        }
                    }
                }'
            ];

            $guzzleRequest = new GuzzleRequest(
                'POST', 
                'https://api.hardcover.app/v1/graphql', 
                [
                    'Authorization' => 'Bearer ' . env('HARDCOVER_API_TOKEN'),
                    'Content-Type' => 'application/json',
                ],
                json_encode($query)
            );

            $response = $client->send($guzzleRequest);

            $body = $response->getBody()->getContents();
            $bookData = json_decode($body, true);

            // Controleer of er boeken zijn gevonden
            if (empty($bookData['data']['editions'])) {
                return view('book-details', [
                    'book' => null,
                    'isbn' => $isbn
                ]);
            }

            // Geef de view weer met de boekgegevens
            return view('book-details', ['book' => $bookData['data']['editions'][0]['book']]);

        } catch (RequestException $e) {
            // Foutafhandeling
            return view('book-details', [
                'book' => null,
                'isbn' => $isbn,
                'error' => $e->getMessage()
            ]);
        }
    }
}