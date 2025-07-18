<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RajaOngkirService
{
    protected $baseUrl;
    protected $apiKey;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl = config('rajaongkir.url'); // atau env('RAJAONGKIR_URL')
        $this->apiKey = config('rajaongkir.api_key'); // atau env('RAJAONGKIR_API_KEY')
        $this->timeout = config('rajaongkir.timeout', 30); // atau env('RAJAONGKIR_TIMEOUT', 30)
    }

    public function searchDestination(string $search)
    {
        $response = Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->timeout($this->timeout)->get('https://api-sandbox.collaborator.komerce.id/tariff/api/v1/destination/search', [
            'keyword' => $search,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['data'];
        }
    }

    // Method untuk testing koneksi API
    public function testConnection()
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Accept' => 'application/json'
            ])->timeout($this->timeout)->get($this->baseUrl . '/destination/search', [
                'keyword' => 'jakarta'
            ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
                'headers' => $response->headers()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }


    public function getCost(string $destination, int $weight, string $courier): array
    {
        try {
            $response = Http::withHeaders([
                'key' => $this->apiKey
            ])->post($this->baseUrl . "/calculate/domestic-cost?origin=151&destination=$destination&weight=$weight&courier=$courier");

            if ($response->successful()) {
                $data = $response->json();

                Log::info('RajaOngkir getCost data:', ['data' => $data]);

                return $data['data'] ?? [];
            }

            Log::error('RajaOngkir getCost Error', [
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('RajaOngkir getCost Exception', [
                'message' => $e->getMessage()
            ]);

            return [];
        }
    }
}
