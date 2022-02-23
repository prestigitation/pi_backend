<?php

namespace App\Repositories;

use App\Models\News;

class NewsRepository
{
    public function getAll() {
        return News::all();
    }

    public function create(array $data)
    {
        $news = new News;
        $news->title = $data['title'];
        $news->description =  htmlentities($data['description']);
        $news->category_id = $data['category_id'];
        $news->save();
    }
}
