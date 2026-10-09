<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class FeaturedController extends Controller
{
    /**
     * Display the dedicated international transportation and logistics showcase page.
     */
    public function index(): View
    {
        return view('storefront.featured');
    }
}
