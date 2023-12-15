<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAboutRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view('index');
    }

    public function adminIndex()
    {
        return view('admin.orders.index');
    }

    public function about()
    {
        return view('about');
    }

    public function adminAbout()
    {
        $contents = File::get(base_path('resources/views/partials/about.blade.php'));
        return view('admin.about', ['contents' => $contents]);
    }

    public function adminAboutUpdate(UpdateAboutRequest $request)
    {
        $validated = $request->validated();
        File::put(base_path('resources/views/partials/about.blade.php'), $validated['about']);
        return redirect()->route('admin.about')->with('status', 'About page updated!');
    }
}
