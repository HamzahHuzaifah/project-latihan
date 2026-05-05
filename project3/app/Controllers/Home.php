<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
    public function index(): string
    {
        $postModel = new PostModel();
        $categoryModel = new CategoryModel();

        $keyword = $this->request->getGet('q');
        $categorySlug = $this->request->getGet('category');

        $postModel->select('posts.*, categories.name as category_name, categories.slug as category_slug')
                  ->join('categories', 'categories.id = posts.category_id', 'left')
                  ->where('posts.status', 'published');

        if ($keyword) {
            $postModel->groupStart()
                      ->like('posts.title', $keyword)
                      ->orLike('posts.content', $keyword)
                      ->groupEnd();
        }

        if ($categorySlug) {
            $postModel->where('categories.slug', $categorySlug);
        }

        $data['posts'] = $postModel->orderBy('posts.created_at', 'DESC')->findAll();
        $data['categories'] = $categoryModel->findAll();
        $data['keyword'] = $keyword;
        $data['current_category'] = $categorySlug;
        $data['is_blog_page'] = false; // Flag to show hero section

        return view('home', $data);
    }

    public function globalChat()
    {
        $question = $this->request->getJSON()->question ?? '';
        if(empty($question)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pertanyaan kosong.']);
        }

        $apiKey = getenv('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'API Key Gemini belum diatur.']);
        }

        // Get recent posts to provide context
        $postModel = new PostModel();
        $recentPosts = $postModel->select('title, content')
                                 ->where('status', 'published')
                                 ->orderBy('created_at', 'DESC')
                                 ->findAll(5); // Get up to 5 recent posts for context

        $context = "Ini adalah website MyBlog, sebuah blog yang membahas berbagai inovasi, tutorial, dan ide.\n\nBerikut adalah beberapa artikel terbaru di blog ini:\n";
        foreach ($recentPosts as $post) {
            $context .= "- " . $post['title'] . ": " . substr(strip_tags($post['content']), 0, 150) . "...\n";
        }

        $prompt = "Kamu adalah asisten AI resmi untuk website MyBlog. Tugasmu adalah menjawab pertanyaan pengunjung dengan cerdas.\n\n" .
                  "--- DATA WEBSITE & ARTIKEL TERBARU ---\n" .
                  $context . "\n" .
                  "----------------------------------------\n\n" .
                  "Pertanyaan pengunjung: " . $question . "\n\n" .
                  "Instruksi:\n" .
                  "1. Jika pertanyaan berkaitan dengan artikel, rekomendasikan atau rangkum artikel dari Data Website di atas.\n" .
                  "2. Jika pertanyaan di luar artikel (seperti koding, pengetahuan umum, dll), tetap jawab dengan cerdas layaknya ChatGPT, jangan pernah menolak menjawab.\n" .
                  "3. Jawab dengan ramah, natural, dan gunakan emoji jika perlu.";

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . trim($apiKey, '"\'');
        
        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => 0.7,
                "maxOutputTokens" => 800
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tidak dapat terhubung ke server AI. Periksa koneksi internet Anda.']);
        }

        $result = json_decode($response, true);
        
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $answer = $result['candidates'][0]['content']['parts'][0]['text'];
            return $this->response->setJSON(['status' => 'success', 'answer' => $answer]);
        } else {
            // User-friendly error messages
            if ($httpCode == 429) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'AI sedang kelelahan 😴 Kuota harian habis. Silakan coba lagi dalam beberapa menit.']);
            } elseif ($httpCode == 403) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'API Key tidak valid atau tidak memiliki akses.']);
            } else {
                $apiError = $result['error']['message'] ?? 'Terjadi kesalahan tidak diketahui.';
                return $this->response->setJSON(['status' => 'error', 'message' => 'AI Error: ' . $apiError]);
            }
        }
    }
}
