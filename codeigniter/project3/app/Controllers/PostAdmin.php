<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PostModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PostAdmin extends BaseController
{
    public function index()
    {
        $post = new PostModel();
        $data['posts'] = $post->findAll();
        echo view('admin/admin_post_list', $data);
    }

    //--------------------------------------------------------------

    public function preview($id)
    {
        $post = new PostModel();
        $commentModel = new \App\Models\CommentModel();

        $data['post'] = $post->select('posts.*, categories.name as category_name')
                             ->join('categories', 'categories.id = posts.category_id', 'left')
                             ->where('posts.id', $id)
                             ->first();

        if(!$data['post']){
            throw PageNotFoundException::forPageNotFound();
        }

        $data['comments'] = $commentModel->where('post_id', $data['post']['id'])->orderBy('created_at', 'DESC')->findAll();

        echo view('post_detail', $data);
    }

    //--------------------------------------------------------------

    public function create()
    {
        // lakukan validasi
        $validation =  \Config\Services::validation();
        $validation->setRules(['title' => 'required']);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $categoryId = $this->request->getPost('category_id');
            if ($categoryId === 'new') {
                $newCategoryName = $this->request->getPost('new_category');
                if (!empty($newCategoryName)) {
                    $categoryModel = new CategoryModel();
                    $categoryModel->insert([
                        'name' => $newCategoryName,
                        'slug' => url_title($newCategoryName, '-', true)
                    ]);
                    $categoryId = $categoryModel->insertID();
                } else {
                    $categoryId = null; // or handle error
                }
            }

            // Thumbnail Upload
            $thumbnailName = null;
            $thumbnailFile = $this->request->getFile('thumbnail');
            if ($thumbnailFile && $thumbnailFile->isValid() && !$thumbnailFile->hasMoved()) {
                $thumbnailName = $thumbnailFile->getRandomName();
                $thumbnailFile->move(FCPATH . 'uploads/thumbnails/', $thumbnailName);
            }

            $slug = $this->generateUniqueSlug($this->request->getPost('title'));

            $post = new PostModel();
            $post->insert([
                "title" => $this->request->getPost('title'),
                "content" => $this->request->getPost('content'),
                "status" => $this->request->getPost('status'),
                "category_id" => $categoryId,
                "author" => user()->username ?? 'Admin',
                "slug" => $slug,
                "thumbnail" => $thumbnailName
            ]);
            return redirect('admin/post')->with('message', 'Artikel berhasil ditambahkan.');
        }

        // ambil data kategori
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        // tampilkan form create
        echo view('admin/admin_post_create', $data);
    }

    //--------------------------------------------------------------

    public function edit($id)
    {
        // ambil artikel yang akan diedit
        $post = new PostModel();
        $data['post'] = $post->where('id', $id)->first();

        // lakukan validasi data artikel
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'id' => 'required',
            'title' => 'required'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $categoryId = $this->request->getPost('category_id');
            if ($categoryId === 'new') {
                $newCategoryName = $this->request->getPost('new_category');
                if (!empty($newCategoryName)) {
                    $categoryModel = new CategoryModel();
                    $categoryModel->insert([
                        'name' => $newCategoryName,
                        'slug' => url_title($newCategoryName, '-', true)
                    ]);
                    $categoryId = $categoryModel->insertID();
                } else {
                    $categoryId = $data['post']['category_id']; // fallback
                }
            }

            $slug = $this->generateUniqueSlug($this->request->getPost('title'), $id);

            $updateData = [
                "title" => $this->request->getPost('title'),
                "content" => $this->request->getPost('content'),
                "status" => $this->request->getPost('status'),
                "category_id" => $categoryId,
                "author" => user()->username ?? 'Admin',
                "slug" => $slug
            ];

            // Thumbnail Upload
            $thumbnailFile = $this->request->getFile('thumbnail');
            if ($thumbnailFile && $thumbnailFile->isValid() && !$thumbnailFile->hasMoved()) {
                $thumbnailName = $thumbnailFile->getRandomName();
                $thumbnailFile->move(FCPATH . 'uploads/thumbnails/', $thumbnailName);
                $updateData['thumbnail'] = $thumbnailName;
            }

            $post->update($id, $updateData);
            return redirect('admin/post')->with('message', 'Artikel berhasil diperbarui.');
        }

        // ambil data kategori
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        // tampilkan form edit
        echo view('admin/admin_post_update', $data);
    }

    //--------------------------------------------------------------

    private function generateUniqueSlug($title, $id = null)
    {
        $postModel = new PostModel();
        $slug = url_title($title, '-', true);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = $postModel->where('slug', $slug);
            if ($id !== null) {
                $query->where('id !=', $id);
            }
            if ($query->countAllResults() == 0) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function delete($id)
    {
        $post = new PostModel();
        $post->delete($id);
        return redirect('admin/post');
    }

    //--------------------------------------------------------------
    // Category AJAX Endpoints
    //--------------------------------------------------------------

    public function getCategories()
    {
        $categoryModel = new CategoryModel();
        return $this->response->setJSON($categoryModel->findAll());
    }

    public function storeCategory()
    {
        $name = $this->request->getJSON()->name ?? '';
        if(empty($name)) return $this->response->setJSON(['status' => 'error', 'message' => 'Nama tidak boleh kosong']);

        $categoryModel = new CategoryModel();
        $categoryModel->insert([
            'name' => $name,
            'slug' => url_title($name, '-', true)
        ]);
        return $this->response->setJSON(['status' => 'success', 'id' => $categoryModel->insertID()]);
    }

    public function updateCategory($id)
    {
        $name = $this->request->getJSON()->name ?? '';
        if(empty($name)) return $this->response->setJSON(['status' => 'error']);

        $categoryModel = new CategoryModel();
        $categoryModel->update($id, [
            'name' => $name,
            'slug' => url_title($name, '-', true)
        ]);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function deleteCategory($id)
    {
        $categoryModel = new CategoryModel();
        // Check if there are posts using this category
        $postModel = new PostModel();
        if ($postModel->where('category_id', $id)->countAllResults() > 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Kategori sedang digunakan oleh artikel.']);
        }
        $categoryModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function uploadImage()
    {
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/images', $newName);
            
            return $this->response->setJSON([
                'status' => 'success',
                'url' => base_url('uploads/images/' . $newName)
            ]);
        }
        
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengunggah gambar.']);
    }
}