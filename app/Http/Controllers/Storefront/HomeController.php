<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use App\Services\Catalog\CatalogService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __construct(protected CatalogService $catalogService)
    {
    }

    public function index(): View
    {
        try {
            $categories = $this->catalogService->getActiveCategoryTree();
            $featuredProducts = $this->catalogService->getFeaturedProducts(6);

            $hero = CmsSection::getByKey('hero');
            $heritage = CmsSection::getByKey('about_heritage');
            $process = CmsSection::getByKey('sourcing_process');
            $mission = CmsSection::getByKey('mission_vision');
            $contact = CmsSection::getByKey('contact_verified');
        } catch (\Throwable $e) {
            report($e);
            $categories = collect();
            $featuredProducts = collect();
            $hero = null;
            $heritage = null;
            $process = null;
            $mission = null;
            $contact = null;
        }

        return view('storefront.home', compact(
            'categories',
            'featuredProducts',
            'hero',
            'heritage',
            'process',
            'mission',
            'contact'
        ));
    }
}
