<?php

namespace App\Controllers;

class Chatbot extends BaseController
{
    public function process()
    {
        $message = $this->request->getPost('message');
        
        // Membaca API Key dari file .env
        $apiKey = getenv('GEMINI_API_KEY');

        if (!$message) {
            return $this->response->setJSON(['error' => 'Pesan kosong!']);
        }

        if (!$apiKey) {
            return $this->response->setJSON(['error' => 'API Key belum di-setup di .env']);
        }

        // Menggunakan model Gemini 2.5 Flash yang tersedia di API key Anda saat ini
        $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

        $client = \Config\Services::curlrequest();
        
        // Format body disesuaikan untuk Gemini API
        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $message]
                    ]
                ]
            ]
        ];

        try {
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => $data,
                'http_errors' => false
            ]);

            $body = json_decode($response->getBody(), true);

            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $body['candidates'][0]['content']['parts'][0]['text'];
                return $this->response->setJSON(['reply' => $reply]);
            } else if (isset($body['error']['message'])) {
                return $this->response->setJSON(['error' => 'Dari Gemini: ' . $body['error']['message']]);
            } else {
                return $this->response->setJSON(['error' => 'Respon tidak terduga, struktur JSON salah.', 'debug' => $body]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}
