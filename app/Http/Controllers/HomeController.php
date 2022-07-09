<?php

namespace App\Http\Controllers;

use RTech\Repositories\PostRepository;
use RTech\Repositories\ProductRepository;
use RTech\Repositories\TeamMembersRepository;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    private $teamMembersRepository;
    private $productRepository;
    private $postRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository;
        $this->teamMembersRepository = new TeamMembersRepository;
        $this->postRepository = new PostRepository;
    }

    public function index()
    {
        $data = (object) [
            'ourProducts' => $this->productRepository->getListActive(),
            'teamMembers' => $this->teamMembersRepository->getListActive(),
            'posts' => $this->postRepository->getListActive(),
        ];
        return view('pages/home/home', compact('data'));
    }
}
