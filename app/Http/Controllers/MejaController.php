<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Pesanan;
use App\Models\Keranjang;
use App\Models\Detailpesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MejaController extends Controller
{
    public function index(Request $request)
    {
        $mejas = DB::table('mejas')->orderBy('id', 'desc')->get();
        return view('pages.mejas.index', compact('mejas'));
    }

    public function create()
    {
        return view('pages.mejas.create');
    }

    public function store(Request $request)
    {
        Meja::create([
            'no_meja' => $request->no_meja
        ]);

        return redirect()->route('meja.index')->with('success', 'No Meja successfully created');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect()->route('meja.index')->with('success', 'No Meja successfully deleted');
    }

    public function edit($id)
    {
        $meja = \App\Models\Meja::findOrFail($id);
        return view('pages.mejas.edit', compact('meja'));
    }

    public function update(Request $request, $id)
    {
        DB::table('mejas')->where('id',$id)->update([
            'no_meja' => $request->no_meja
        ]);

        return redirect()->route('meja.index')->with('success', 'No Meja successfully updated');
    }

    public function lihatpesanan($id)
    {
        $keranjangs = DB::table('keranjangs')
                ->join('produks', 'produks.id', '=', 'keranjangs.id_produk')
                ->join('mejas', 'mejas.id', '=', 'keranjangs.id_meja')
                ->select('keranjangs.*', 'produks.nama_produk', 'produks.path_gambar', 'mejas.no_meja')->where('keranjangs.id_meja', $id)->orderBy('keranjangs.id', 'desc')->get();
        $total = DB::table('keranjangs')
                ->where('keranjangs.id_meja', $id)
                ->sum('sub_total');
       
        $meja = Meja::find($id);
       
        return view('pages.mejas.lihatpesanan', compact('keranjangs','total','meja'));
        
    }

    public function storepesan(Request $request)
    {
        $id_meja = $request->id_meja;
        $nama_pemesan = $request->nama_pemesan;
        $tgl = Carbon::now();
        $tgl_now = $tgl->format('Y-m-d');

       $pesan = Pesanan::create([
            'id_meja' => $id_meja,
            'tgl_pemesanan' => $tgl_now,
            'nama_pemesan' => $nama_pemesan,
            'total_bayar' => $request->total_bayar,
            'status' => 'Unpaid',
            'keterangan' => 'diproses'
        ]);

        if($pesan){
            $last_id = Pesanan::latest()->first();
            $pesan_id = $last_id->id;
            $keranjangs = DB::table('keranjangs')
                        ->where('id_meja', $id_meja)
                        ->get();
            foreach ($keranjangs as $keranjang) {
                Detailpesanan::create([
                    'id_pesanan' => $pesan_id,
                    'id_produk' => $keranjang->id_produk,
                    'id_warung' => $keranjang->id_warung,
                    'jml' => $keranjang->jml,
                    'harga_bayar' => $keranjang->harga_bayar,
                    'sub_total' => $keranjang->sub_total
                ]);
            }

            DB::table('keranjangs')->where('id_meja',$id_meja)->delete();
        }

        return redirect()->route('pembayaran.index')->with('success', 'Pesanan successfully created');
    }


}
