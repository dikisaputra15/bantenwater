<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Detailpesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function status()
    {
        $pesanans = DB::table('pesanans')
            ->where('id_user', auth()->id())
            ->orderByDesc('id')
            ->get();

        foreach ($pesanans as $pesanan) {

            $pesanan->detail = DB::table('detailpesanans')
                ->join('produks','detailpesanans.id_produk','=','produks.id')
                ->select(
                    'detailpesanans.*',
                    'produks.nama_produk',
                    'produks.harga',
                    'produks.path_gambar'
                )
                ->where('detailpesanans.id_pesanan',$pesanan->id)
                ->get();

        }

        return view('pages.pelanggan.status',compact('pesanans'));
    }
}
