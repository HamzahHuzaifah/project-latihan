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

        // Endpoint yang Anda berikan
        $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-preview-09-2025:generateContent?key=' . $apiKey;

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

            // Cek sukses kembalian
            if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
                $reply = $body['candidates'][0]['content']['parts'][0]['text'];
                return $this->response->setJSON(['reply' => $reply]);
            } else {
                return $this->response->setJSON(['error' => 'Format balasan tidak terbaca dari server Gemini.', 'debug' => $body]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}
