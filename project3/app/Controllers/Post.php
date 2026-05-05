<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PostModel;
use App\Models\CommentModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    public function index()
    {
        $postModel = new PostModel();
        $categoryModel = new \App\Models\CategoryModel();

        // Get filter category if any
        $categorySlug = $this->request->getGet('category');
        $keyword = $this->request->getGet('q');
        
        $builder = $postModel->select('posts.*, categories.name as category_name, categories.slug as category_slug')
                             ->join('categories', 'categories.id = posts.category_id', 'left')
                             ->where('posts.status', 'published');
                             
        if ($categorySlug) {
            $builder->where('categories.slug', $categorySlug);
        }
        
        if ($keyword) {
            $builder->groupStart()
                    ->like('posts.title', $keyword)
                    ->orLike('posts.content', $keyword)
                    ->groupEnd();
        }
        
        $data['posts'] = $builder->orderBy('posts.created_at', 'DESC')->findAll();
        $data['categories'] = $categoryModel->findAll();
        $data['current_category'] = $categorySlug;
        $data['keyword'] = $keyword;
        $data['is_blog_page'] = true; // Flag to hide hero section

        return view('home', $data);
    }

	//------------------------------------------------------------

	public function viewPost($slug)
	{
		$post = new PostModel();
        $commentModel = new CommentModel();
        $categoryModel = new CategoryModel();

		$data['post'] = $post->select('posts.*, categories.name as category_name')
                             ->join('categories', 'categories.id = posts.category_id', 'left')
                             ->where(['posts.slug' => $slug, 'posts.status' => 'published'])
                             ->first();

        // tampilkan 404 error jika data tidak ditemukan
		if (!$data['post']) {
			throw PageNotFoundException::forPageNotFound();
		}

        $data['comments'] = $commentModel->where('post_id', $data['post']['id'])->orderBy('created_at', 'DESC')->findAll();

		echo view('post_detail', $data);
	}

    public function addComment($postId)
    {
        $commentModel = new CommentModel();
        $postModel = new PostModel();
        
        $post = $postModel->find($postId);
        if(!$post) return redirect()->back()->with('error', 'Post tidak ditemukan');

        $commentModel->insert([
            'post_id' => $postId,
            'name' => $this->request->getPost('name'),
            'comment' => $this->request->getPost('comment')
        ]);

        return redirect()->to(base_url('post/' . $post['slug']))->with('message', 'Komentar berhasil ditambahkan');
    }

    public function likePost($postId)
    {
        $postModel = new PostModel();
        $post = $postModel->find($postId);
        
        if($post) {
            $postModel->update($postId, ['likes' => $post['likes'] + 1]);
            return $this->response->setJSON(['status' => 'success', 'likes' => $post['likes'] + 1]);
        }
        
        return $this->response->setJSON(['status' => 'error'], 400);
    }

    public function chat($postId)
    {
        $postModel = new PostModel();
        $post = $postModel->find($postId);
        
        if(!$post) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Artikel tidak ditemukan.']);
        }

        $question = $this->request->getJSON()->question ?? '';
        if(empty($question)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Pertanyaan kosong.']);
        }

        $apiKey = getenv('GEMINI_API_KEY');
        if (empty($apiKey)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'API Key Gemini belum diatur.']);
        }

        $articleContext = "Judul: " . $post['title'] . "\nKonten: " . strip_tags($post['content']);
        $prompt = "Kamu adalah asisten blog AI yang bertugas menjawab pertanyaan pembaca tentang artikel ini.\n\n" .
                  "--- ARTIKEL ---\n" .
                  $articleContext . "\n" .
                  "---------------\n\n" .
                  "Pertanyaan pembaca: " . $question . "\n\n" .
                  "Tolong jawab dengan ramah, singkat, jelas, dan hanya berdasarkan informasi dari artikel di atas. Jika pertanyaan tidak relevan dengan artikel, beri tahu pembaca dengan sopan bahwa kamu hanya bisa menjawab seputar artikel ini.";

        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey;
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
                "maxOutputTokens" => 500
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
        
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $answer = $result['candidates'][0]['content']['parts'][0]['text'];
            return $this->response->setJSON(['status' => 'success', 'answer' => $answer]);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'AI sedang sibuk atau error. Coba lagi nanti.']);
        }
    }
}