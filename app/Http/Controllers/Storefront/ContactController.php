<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CmsSection;
use Illuminate\Contracts\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        try {
            $contact = CmsSection::getByKey('contact_verified');
        } catch (\Throwable $e) {
            report($e);
            $contact = null;
        }

        return view('storefront.contact', compact('contact'));
    }
}
