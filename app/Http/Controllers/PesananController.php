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
        if(auth()->user()->roles == 'admin'){
            $pesanans = DB::table('pesanans')
            ->orderByDesc('id')
            ->get();
        }else{
            $pesanans = DB::table('pesanans')
                ->where('id_user', auth()->id())
                ->orderByDesc('id')
                ->get();
        }

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

    public function pembayaran(Request $request)
    {
        $pesanans = DB::table('pesanans')
                    ->where('status_pembayaran', 'menunggu verifikasi')
                    ->orderByDesc('id')
                    ->get();

        foreach ($pesanans as $pesanan) {

        $pesanan->detail = DB::table('detailpesanans')
                ->join('produks', 'detailpesanans.id_produk', '=', 'produks.id')
                ->select(
                    'detailpesanans.*',
                    'produks.nama_produk',
                    'produks.path_gambar'
                )
                ->where('detailpesanans.id_pesanan', $pesanan->id)
                ->get();
        }

        return view('pages.pelanggan.verifybayar', compact('pesanans'));
    }

    public function verifikasi($id)
    {
        DB::table('pesanans')
            ->where('id', $id)
            ->update([
                'status_pembayaran' => 'lunas',
                'status_pesanan'    => 'dikirim'
            ]);

        return redirect()
                ->back()
                ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function adminallpesan(Request $request)
    {
        $query = DB::table('pesanans')
        ->join('users','pesanans.id_user','=','users.id')
        ->select(
            'pesanans.*',
            'users.name'
        );

        if($request->filled('status')){
            $query->where('status_pesanan',$request->status);
        }

        if($request->filled('tanggal')){
            $query->whereDate('tgl_pemesanan',$request->tanggal);
        }

        $pesanans = $query
            ->orderBy('tgl_pemesanan','desc')
            ->get();

        return view('pages.pelanggan.adminallpesan', compact('pesanans'));
    }
}
