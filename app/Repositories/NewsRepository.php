<?php
namespace App\Repositories;

use App\Models\News;
use \Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class NewsRepository extends BaseRepository {
    private $fileRepository;
    public function __construct(FileRepository $fileRepository) {
        $this->fileRepository = $fileRepository;
    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return News::class;
    }


    public function create(array $data) {
        if(isset($data['image'])) {
            $image = $data['image']->store('public/news');
            $path = $this->fileRepository->getFileLink($image);
            $data['image'] = $path;
        }
        $data['slug'] = Str::slug($data['title']);
        News::create($data);
    }

    public function findBySlug(string $slug): News
    {
        return News::where('slug', $slug)->first();
    }
}
