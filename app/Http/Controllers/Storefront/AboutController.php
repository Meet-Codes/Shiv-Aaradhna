<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        try {
            $heritage = CmsSection::getByKey('about_heritage');
            $mission = CmsSection::getByKey('mission_vision');
            $process = CmsSection::getByKey('sourcing_process');
            $contact = CmsSection::getByKey('contact_verified');
        } catch (\Throwable $e) {
            report($e);
            $heritage = null;
            $mission = null;
            $process = null;
            $contact = null;
        }

        return view('storefront.about', compact('heritage', 'mission', 'process', 'contact'));
    }
}
