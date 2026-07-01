<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermintaanStokController extends Controller
{
    public function index()
    {
        $permintaan = DB::table('permintaan_stoks')
            ->join('produks','produks.id','=','permintaan_stoks.id_produk')
            ->select(
                'permintaan_stoks.*',
                'produks.nama_produk',
                'produks.stock'
            )
            ->get();

        return view('permintaanstok.index',compact('permintaan'));
    }

    public function verifikasi($id)
    {
        $data = DB::table('permintaan_stoks')->where('id',$id)->first();

        DB::table('produks')
            ->where('id',$data->id_produk)
            ->increment('stock',$data->qty);

        DB::table('permintaan_stoks')
            ->where('id',$id)
            ->update([
                'status'=>'disetujui'
            ]);

        return back()->with('success','Permintaan stok berhasil disetujui.');
    }

    public function tolak($id)
    {
        DB::table('permintaan_stoks')
            ->where('id',$id)
            ->update([
                'status'=>'ditolak'
            ]);

        return back()->with('success','Permintaan stok ditolak.');
    }

    public function create($id)
    {
        $produk = DB::table('produks')
            ->where('id',$id)
            ->first();

        return view('permintaanstok.create',compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'=>'required',
            'qty'=>'required|numeric|min:1'
        ]);

        DB::table('permintaan_stoks')->insert([

            'id_produk'=>$request->produk_id,

            'qty'=>$request->qty,

            'status'=>'menunggu',

            'keterangan'=>$request->keterangan,

            'created_at'=>now(),

            'updated_at'=>now()

        ]);

        return redirect()
            ->route('produk.index')
            ->with('success','Permohonan stok berhasil dikirim ke pimpinan.');
    }
}
