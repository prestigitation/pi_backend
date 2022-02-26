<?php

namespace App\Repositories;

use App\Models\News;

use Stevebauman\Purify\Purify;

class NewsRepository
{
    private $purifier;
    public function __construct(Purify $purifier)
    {
        $this->purifier = $purifier;
    }
    public function getAll() {
        return News::all();
    }

    public function addNewsInfo(News $news, array $data) {
        $news->title = $data['title'];
        $news->description =  $this->purifier->clean($data['description']);
        $news->category_id = $data['category_id'];
    }

    public function create(array $data)
    {
        $news = new News;
        $this->addNewsInfo($news, $data);
        $news->save();
    }

    public function update(array $data, int $id)
    {
        $news = News::find($id);
        $this->addNewsInfo($news, $data);
        $news->save();
    }
}
