<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return News::all();
    }

    /**
     * Находит статью по slug
     * @param string $slug
     * @return News
     */
    public function findBySlug(string $slug): News
    {
        return $this->newsRepository->findBySlug($slug);
    }
}
