<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $pelanggans = DB::table('users')->where('roles', 'pelanggan')->get();
        return view('pages.pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('pages.kategoris.create');
    }

    public function store(Request $request)
    {
        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori successfully created');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori successfully deleted');
    }

    public function edit($id)
    {
        $kategori = \App\Models\Kategori::findOrFail($id);
        return view('pages.kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        DB::table('kategoris')->where('id',$id)->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori successfully updated');
    }

    public function pilihkategori($id)
    {
        $produks = DB::table('produks')->where('id_kategori', $id)->orderBy('produks.id', 'desc')->get();
        $mejas = DB::table('mejas')->orderBy('id', 'asc')->get();
        $kategori = \App\Models\Kategori::findOrFail($id);
        return view('pages.fronts.pilihkategori', compact('produks','kategori','mejas'));
    }
}
