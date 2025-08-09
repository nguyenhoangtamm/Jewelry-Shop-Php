<?php

namespace App\Http\Controllers\User;

use App\Models\Jewelry;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageHelper;

class ProductController extends Controller
{
    /**
     * Display a listing of all products
     */
    public function index(Request $request)
    {
        $query = Jewelry::with('category')
            ->where('is_deleted', 0);

        // Filter by category if provided
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search by name if provided
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort products
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');

        $allowedSorts = ['name', 'price', 'created_at', 'sold'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Get items per page from request, default 16
        $perPage = $request->get('per_page', 16);
        $allowedPerPage = [16, 24, 32, 48];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 16;
        }

        $products = $query->paginate($perPage)->appends($request->all());

        // Get all categories for filter
        $categories = Category::where('is_deleted', 0)->get();

        return view('user.products.index', compact('products', 'categories'));
    }

    /**
     * Display all products with sidebar filters (like the image)
     */
    public function showAll(Request $request)
    {
        $query = Jewelry::with(['category', 'jewelryFiles.file'])
            ->where('is_deleted', 0);

        // Filter by category if provided
        if ($request->has('category') && $request->category != '') {
            if ($request->category === 'bestseller') {
                $query->orderBy('sold', 'desc');
            } elseif ($request->category === 'hot') {
                $query->where('sold', '>', 50);
            } else {
                $query->where('category_id', $request->category);
            }
        }

        // Search by name if provided
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Multiple price range filters
        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRanges = is_array($request->price_range) ? $request->price_range : [$request->price_range];

            $query->where(function ($q) use ($priceRanges) {
                foreach ($priceRanges as $range) {
                    $parts = explode('-', $range);
                    if (count($parts) == 2) {
                        $min = (int) $parts[0];
                        if ($parts[1] === 'max') {
                            $q->orWhere('price', '>=', $min);
                        } else {
                            $max = (int) $parts[1];
                            $q->orWhereBetween('price', [$min, $max]);
                        }
                    }
                }
            });
        }

        // Legacy single price range filters (for backward compatibility)
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by multiple brands
        if ($request->has('brand') && !empty($request->brand)) {
            $brands = is_array($request->brand) ? $request->brand : [$request->brand];
            $query->whereIn('brand', $brands);
        }

        // Filter by multiple genders
        if ($request->has('gender') && !empty($request->gender)) {
            $genders = is_array($request->gender) ? $request->gender : [$request->gender];
            $query->whereIn('gender', $genders);
        }

        // Filter by brand_type (additional brands like blazer, croptop, etc.)
        if ($request->has('brand_type') && !empty($request->brand_type)) {
            $brandTypes = is_array($request->brand_type) ? $request->brand_type : [$request->brand_type];
            $query->whereIn('brand', $brandTypes);
        }

        // Filter by size (if you have size field in future)
        if ($request->has('size') && $request->size != '') {
            // Assuming you might add size field later
            // $query->where('size', $request->size);
        }

        // Advanced sorting
        $sort = $request->get('sort', 'created_at');
        switch ($sort) {
            case 'price':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'sold':
                $query->orderBy('sold', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'created_at':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get items per page from request, default 16
        $perPage = $request->get('per_page', 16);
        $allowedPerPage = [16, 24, 32, 48];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 16;
        }

        // Paginate with all query parameters preserved
        $products = $query->paginate($perPage)->appends($request->all());

        // Map image_path for each product using ImageHelper (main image or fallback)
        foreach ($products as $product) {
            $img = ImageHelper::getMainImage($product);
            $product->image_path = $img; // used by current views
            $product->image = $img;      // alias for convenience
        }

        // Get all categories for filter
        $categories = Category::where('is_deleted', 0)->get();

        // Get unique brands for filter
        $brands = Jewelry::where('is_deleted', 0)
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->distinct()
            ->pluck('brand')
            ->sort()
            ->values();

        // Get price ranges for filter
        $priceRanges = [
            ['min' => 0, 'max' => 100000, 'label' => 'Dưới 100,000đ'],
            ['min' => 100000, 'max' => 300000, 'label' => '100,000đ - 300,000đ'],
            ['min' => 300000, 'max' => 500000, 'label' => '300,000đ - 500,000đ'],
            ['min' => 500000, 'max' => 1000000, 'label' => '500,000đ - 1,000,000đ'],
            ['min' => 1000000, 'max' => 2000000, 'label' => '1,000,000đ - 2,000,000đ'],
            ['min' => 2000000, 'max' => 5000000, 'label' => '2,000,000đ - 5,000,000đ'],
            ['min' => 5000000, 'max' => null, 'label' => 'Trên 5,000,000đ'],
        ];

        return view('user.all', compact('products', 'categories', 'brands', 'priceRanges'));
    }

    /**
     * Display the specified product with pagination-aware URL
     */
    public function show($id, Request $request)
    {
        $product = Jewelry::with('category')->findOrFail($id);

        // Get related products from same category with pagination
        $relatedProducts = Jewelry::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->where('is_deleted', 0)
            ->limit(8)
            ->get();

        // Store referrer URL for back navigation
        $referrer = $request->headers->get('referer');
        if ($referrer && str_contains($referrer, route('products.all'))) {
            session(['product_referrer' => $referrer]);
        }

        return view('user.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Store a newly created product in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'main_stone' => 'nullable|string|max:100',
            'sub_stone' => 'nullable|string|max:100',
            'gender' => 'required|in:M,F,U',
            'brand' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|url|max:255',
            'stock' => 'required|integer|min:0'
        ]);

        Jewelry::create($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    /**
     * Get featured products for homepage
     */
    public function getFeatured($limit = 8)
    {
        return Jewelry::where('is_deleted', 0)
            ->orderBy('sold', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get products by category with optional pagination
     */
    public function getByCategory($categoryId, $limit = null, $paginate = false)
    {
        $query = Jewelry::where('category_id', $categoryId)
            ->where('is_deleted', 0)
            ->orderBy('created_at', 'desc');

        if ($paginate) {
            return $query->paginate($limit ?: 16);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get filter statistics for UI
     */
    public function getFilterStats()
    {
        $stats = [
            'total_products' => Jewelry::where('is_deleted', 0)->count(),
            'categories' => Category::withCount(['jewelries' => function ($query) {
                $query->where('is_deleted', 0);
            }])->where('is_deleted', 0)->get(),
            'price_ranges' => [
                'under_100k' => Jewelry::where('is_deleted', 0)->where('price', '<', 100000)->count(),
                '100k_300k' => Jewelry::where('is_deleted', 0)->whereBetween('price', [100000, 300000])->count(),
                '300k_500k' => Jewelry::where('is_deleted', 0)->whereBetween('price', [300000, 500000])->count(),
                '500k_1m' => Jewelry::where('is_deleted', 0)->whereBetween('price', [500000, 1000000])->count(),
                '1m_2m' => Jewelry::where('is_deleted', 0)->whereBetween('price', [1000000, 2000000])->count(),
                '2m_5m' => Jewelry::where('is_deleted', 0)->whereBetween('price', [2000000, 5000000])->count(),
                'over_5m' => Jewelry::where('is_deleted', 0)->where('price', '>', 5000000)->count(),
            ],
            'brands' => Jewelry::where('is_deleted', 0)
                ->whereNotNull('brand')
                ->where('brand', '!=', '')
                ->selectRaw('brand, COUNT(*) as count')
                ->groupBy('brand')
                ->orderBy('count', 'desc')
                ->get(),
            'genders' => [
                'M' => Jewelry::where('is_deleted', 0)->where('gender', 'M')->count(),
                'F' => Jewelry::where('is_deleted', 0)->where('gender', 'F')->count(),
                'U' => Jewelry::where('is_deleted', 0)->where('gender', 'U')->count(),
            ]
        ];

        return response()->json($stats);
    }

    /**
     * Clear all filters and redirect to clean products page
     */
    public function clearFilters()
    {
        return redirect()->route('products.all');
    }
}
