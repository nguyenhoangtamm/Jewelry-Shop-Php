<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Jewelry;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_deleted', 0)->limit(12)->get();
        $newProducts = Jewelry::with(['files' => function($q){ $q->limit(1); }])
            ->where('is_deleted', 0)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Add random discount/sold for demo (should be in DB ideally)
        foreach ($newProducts as $product) {
            $product->discount = rand(10, 30);
            $product->sold = rand(100, 500);
            $file = $product->files->first();
            $product->path = $file ? $file->path : null;
        }

        return view('user.home', compact('categories', 'newProducts'));
    }
}
