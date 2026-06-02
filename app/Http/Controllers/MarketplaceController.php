<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MarketplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Admin sees all, Schools see active only (or admin sees all + unlisted if they want)
        // For now, let's show all active products to everyone.
        // Super Admin might want to see inactive ones too in a separate view or same view with filters.

        $products = MarketplaceProduct::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);

        if (Auth::user()->hasRole('Super Admin')) {
            $products = MarketplaceProduct::orderBy('created_at', 'desc')->paginate(12);
        }

        return view('marketplace.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }
        return view('marketplace.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_info' => 'nullable|string',
            'link' => 'nullable|url',
            'commission_percentage' => 'nullable|numeric|min:0|max:100'
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['price'] = $request->price ?? 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('marketplace', 'public');
            $data['image'] = $imagePath;
        }

        MarketplaceProduct::create($data);

        return redirect()->route('marketplace.index')->with('success', 'Product listed successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = MarketplaceProduct::findOrFail($id);
        return view('marketplace.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }
        $product = MarketplaceProduct::findOrFail($id);
        return view('marketplace.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $product = MarketplaceProduct::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'nullable|numeric',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_info' => 'nullable|string',
            'link' => 'nullable|url',
            // 'status' => 'required|boolean', // Status handled manually below
            'commission_percentage' => 'nullable|numeric|min:0|max:100'
        ]);

        $data = $request->all();
        $data['price'] = $request->price ?? 0;
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('marketplace', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('marketplace.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        $product = MarketplaceProduct::findOrFail($id);
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('marketplace.index')->with('success', 'Product deleted successfully.');
    }
}
