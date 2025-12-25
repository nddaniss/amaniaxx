<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        // PERBAIKAN DI SINI:
        // Ganti get() menjadi paginate(10) agar fitur halaman ($menus->links()) berfungsi
        $menus = Menu::latest()->paginate(10); 
        
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'category' => 'required',
        'price' => 'required|numeric',
        'is_available' => 'required|boolean', // <--- Validasi Status
        'image' => 'required|image|max:2048',
    ]);

    $imagePath = $request->file('image')->store('menus', 'public');

    Menu::create([
        'name' => $request->name,
        'category' => $request->category,
        'price' => $request->price,
        'is_available' => $request->is_available, // <--- Simpan status (1 atau 0)
        'description' => $request->description,
        'image' => $imagePath,
    ]);

    return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan');
}

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'is_available' => 'required|boolean', // <--- Validasi Status
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        if($menu->image) Storage::disk('public')->delete($menu->image);
        $data['image'] = $request->file('image')->store('menus', 'public');
    }

    $menu->update($data); // Data is_available otomatis terupdate karena ada di $request->all()

    return redirect()->route('admin.menus.index')->with('success', 'Menu diperbarui');
}

    public function destroy(Menu $menu)
    {
        if($menu->image) Storage::disk('public')->delete($menu->image);
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu dihapus');
    }
}