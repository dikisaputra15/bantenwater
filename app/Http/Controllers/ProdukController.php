<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $produks = DB::table('produks')->orderBy('id', 'desc')->get();
        return view('pages.produks.index', compact('produks'));
    }

    public function create()
    {
        return view('pages.produks.create');
    }

    public function store(Request $request)
    {
        $file = $request->file('gambar');
        $extension = $file->getClientOriginalExtension();
        $nama_produk = str_replace(" ", "-", $request->nama_produk);
        $num = hexdec(uniqid());
        $filename = $nama_produk.'_'.$num.'.'.$extension;

        Storage::putFileAs('public/gambarproduk', $file, $filename);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'stock' => $request->stock,
            'harga' => $request->harga,
            'deskripsi_produk' => $request->deskripsi_produk,
            'path_gambar' => $filename
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk successfully created');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk successfully deleted');
    }

    public function edit($id)
    {
        $produk = \App\Models\Produk::findOrFail($id);
        return view('pages.produks.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $cekfile = $request->gambar;
        $old_file = $request->old_file;
        $file = $request->file('gambar');

        if ($cekfile != "") {

            if (Storage::exists('public/gambarproduk/' . $old_file)) {
                Storage::delete('public/gambarproduk/' . $old_file);
            }

            $extension = $file->getClientOriginalExtension();

            $nama_file = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $nama_file = str_replace(" ", "-", $nama_file);

            $num = hexdec(uniqid());

            $filename = $nama_file . '_' . $num . '.' . $extension;

            Storage::putFileAs('public/gambarproduk', $file, $filename);

            DB::table('produks')->where('id', $id)->update([
                'nama_produk'      => $request->nama_produk,
                'stock'            => $request->stock,
                'harga'            => $request->harga,
                'deskripsi_produk' => $request->deskripsi_produk,
                'path_gambar'      => $filename
            ]);
        }else{
            DB::table('produks')->where('id',$id)->update([
                'nama_produk' => $request->nama_produk,
                'stock' => $request->stock,
                'harga' => $request->harga,
                'deskripsi_produk' => $request->deskripsi_produk
            ]);
        }

        return redirect()->route('produk.index')->with('success', 'Produk successfully updated');

    }
}
