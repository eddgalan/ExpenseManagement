<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = array(
            'news' => $model->getNews(),
            'title' => 'News archive',
        );

        return view('templates/header', $data)
            . view('news/index', $data)
            . view('templates/footer');
    }

    public function view($slug = null)
    {
        $model = new NewsModel();
        $data['news'] = $model->getNews($slug);

        if (empty($data['news'])) {
            throw new PageNotFoundException('Cannot find the news item: ' . $slug);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }

    public function create()
    {
        helper('form');

        // Checks whether the form is submitted.
        if (! $this->request->is('post')) {
            // The form is not submitted, so returns the form.
            return view('templates/header', ['title' => 'Create a news item'])
                . view('news/create')
                . view('templates/footer');
        }

        $post = $this->request->getPost(['title', 'body']);

        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            // The validation fails, so returns the form.
            return view('templates/header', ['title' => 'Create a news item'])
                . view('news/create')
                . view('templates/footer');
        }

        //$model = model(NewsModel::class);

        $model = Factories::models('NewsModel');

        $model->save([
            'title' => $post['title'],
            'slug'  => url_title($post['title'], '-', true),
            'body'  => $post['body'],
        ]);

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success', array("operation" => 'created'))
            . view('templates/footer');
    }

    public function edit($id)
    {
        helper('form');

        $model = model(NewsModel::class);
        $data['new'] = $model->find($id);

        return view('templates/header', ['title' => 'Edit a news item'])
            . view('news/edit', $data)
            . view('templates/footer');
    }

    public function update($id)
    {
        $post = $this->request->getPost(['title', 'body']);
        $newsModel = model(NewsModel::class);
        // Checks whether the submitted data passed the validation rules.
        if (! $this->validateData($post, [
            'title' => 'required|max_length[255]|min_length[3]',
            'body'  => 'required|max_length[5000]|min_length[10]',
        ])) {
            $data['new'] = $newsModel->find($id);
            return view('templates/header', ['title' => 'Edit a news item'])
                . view('news/edit', $data)
                . view('templates/footer');
        }
        $newsModel->save(
            array(
                'id' => $id,
                'title' => $post['title'],
                'slug' => url_title($post['title'], '-', true),
                'body' => $post['body'],
            )
        );
        return view('templates/header', ['title' => 'Update a news item'])
            . view('news/success', array("operation" => 'updated'))
            . view('templates/footer');
    }

}
