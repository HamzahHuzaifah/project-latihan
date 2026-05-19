<?php

namespace App\Controllers;

use App\Models\PostModel;

class Search extends BaseController
{
    public function index()
    {
        $keyword = $this->request->getPost('keyword') ?? $this->request->getGet('keyword');
        
        if (empty($keyword)) {
            return redirect()->back()->with('error', 'Silakan masukkan kata kunci pencarian.');
        }

        $postModel = new PostModel();
        // Ambil data artikel yang di-publish beserta kategori
        $articles = $postModel->select('posts.*, categories.name as category_name')
                              ->join('categories', 'categories.id = posts.category_id', 'left')
                              ->where('posts.status', 'published')
                              ->findAll();
        
        if (empty($articles)) {
            return view('search_results', ['results' => [], 'keyword' => $keyword]);
        }

        // Format data artikel untuk prompt, ambil sebagian konten untuk menghemat token
        $articlesData = array_map(function($post) {
            return [
                'id' => $post['id'],
                'title' => $post['title'],
                'author' => $post['author'] ?? 'Admin',
                'category' => $post['category_name'] ?? 'Umum',
                'content' => substr(strip_tags($post['content']), 0, 500) 
            ];
        }, $articles);

        $prompt = "Berdasarkan kata kunci pencarian user '{$keyword}', pilih artikel mana yang paling relevan dari daftar artikel berikut. Pertimbangkan kecocokan pada judul, isi konten, kategori, dan nama penerbit (author):\n" . 
                  json_encode($articlesData) . "\n" .
                  "Kembalikan response hanya dalam format JSON berisi array ID artikel yang relevan, contoh: [1, 5, 8]. Jangan tambahkan teks lain.";

        // Pastikan API key diset di file .env
        $geminiApiKey = getenv('GEMINI_API_KEY');
        if (empty($geminiApiKey)) {
            return redirect()->back()->with('error', 'API Key Gemini belum disetting di .env (tambahkan baris GEMINI_API_KEY=your_api_key).');
        }

        // Endpoint Gemini API 
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $geminiApiKey;

        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        // Memaksa Gemini untuk mengembalikan format JSON
                        'response_mime_type' => 'application/json'
                    ]
                ]
            ]);

            $body = json_decode($response->getBody(), true);
            $responseText = $body['candidates'][0]['content']['parts'][0]['text'] ?? '[]';
            
            // Hapus formatting code block bawaan jika ada
            $responseText = str_replace(['```json', '```'], '', $responseText);
            
            $relevantIds = json_decode(trim($responseText), true);

            if (!is_array($relevantIds)) {
                $relevantIds = [];
            }

            $searchResults = [];
            if (!empty($relevantIds)) {
                // Ambil artikel yang ID-nya dikembalikan oleh Gemini
                $searchResults = $postModel->select('posts.*, categories.name as category_name')
                                           ->join('categories', 'categories.id = posts.category_id', 'left')
                                           ->whereIn('posts.id', $relevantIds)
                                           ->where('posts.status', 'published')
                                           ->findAll();
            }

            return view('search_results', [
                'results' => $searchResults,
                'keyword' => $keyword
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memanggil API Gemini: ' . $e->getMessage());
        }
    }
}
