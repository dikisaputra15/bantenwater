<?php

namespace App\Http\Controllers;

use App\Models\Warung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class WarungController extends Controller
{
    public function index(Request $request)
    {
        $warungs = DB::table('warungs')->orderBy('id', 'desc')->get();
        return view('pages.warungs.index', compact('warungs'));
    }

    public function create()
    {
        return view('pages.warungs.create');
    }

    public function store(Request $request)
    {
        $file = $request->file('gambar_warung');
        $extension = $file->getClientOriginalExtension();
        $nama_warung = str_replace(" ", "-", $request->nama_warung);
        $num = hexdec(uniqid());
        $filename = $nama_warung.'_'.$num.'.'.$extension;

        Storage::putFileAs('public/gambarwarung', $file, $filename);

        Warung::create([
            'nama_warung' => $request->nama_warung,
            'deskripsi_warung' => $request->deskripsi_warung,
            'gambar_warung' => $filename
        ]);

        return redirect()->route('warung.index')->with('success', 'Kategori successfully created');
    }

    public function destroy(Warung $warung)
    {
        $warung->delete();
        return redirect()->route('warung.index')->with('success', 'Warung successfully deleted');
    }

    public function edit($id)
    {
        $warung = \App\Models\Warung::findOrFail($id);
        return view('pages.warungs.edit', compact('warung'));
    }

    public function update(Request $request, $id)
    {
        $cekfile = $request->gambar_warung;
        $old_file = $request->old_file;
        $file = $request->file('gambar_warung');


        if($cekfile != ""){

            $filedel = Storage::url('gambarwarung/'. $old_file);

            if(File::exists($filedel)) {
                File::delete($filedel);
            }

            $extension = $file->getClientOriginalExtension();

            $nama_file = str_replace(" ", "-", $request->gambar_warung);
            $num = hexdec(uniqid());

            $filename = $nama_file.'_'.$num.'.'.$extension;

            Storage::putFileAs('public/gambarproduk', $file, $filename);

            DB::table('warungs')->where('id',$id)->update([
                'nama_warung' => $request->nama_warung,
                'deskripsi_warung' => $request->deskripsi_warung,
                'gambar_warung' => $filename
            ]);
         }else{
            DB::table('warungs')->where('id',$id)->update([
                'nama_warung' => $request->nama_warung,
                'deskripsi_warung' => $request->deskripsi_warung
            ]);
         }

        return redirect()->route('warung.index')->with('success', 'Warung successfully updated');
    }

    public function pilihwarung($id)
    {
        $warung = \App\Models\Warung::findOrFail($id);
        return view('pages.fronts.pilihwarung', compact('warung'));
    }
}
