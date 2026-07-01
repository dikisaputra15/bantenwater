<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KurirController extends Controller
{
    public function index()
    {
        $pengantaran = DB::table('pesanans')
            ->join('users','users.id','=','pesanans.id_user')
            ->select(
                'pesanans.*',
                'users.name',
                'users.email'
            )
            ->whereIn('status_pesanan',[
                'dikirim',
                'dalam perjalanan',
                'selesai'
            ])
            ->latest()
            ->get();

        return view('pages.kurir.index',compact('pengantaran'));
    }

    public function mulai($id)
    {
        DB::table('pesanans')
            ->where('id',$id)
            ->update([
                'status_pesanan'=>'dalam perjalanan'
            ]);

        return back();
    }

    public function selesai($id)
    {
        DB::table('pesanans')
            ->where('id',$id)
            ->update([
                'status_pesanan'=>'selesai'
            ]);

        return back();
    }

    public function show($id)
    {
        $pesanan = DB::table('pesanans')
            ->join('users','users.id','=','pesanans.id_user')
            ->where('pesanans.id',$id)
            ->select(
                'pesanans.*',
                'users.name',
                'users.email',
                'users.no_hp',
                'users.alamat_lengkap'
            )
            ->first();

        $detail = DB::table('detailpesanans')
            ->join('produks','produks.id','=','detailpesanans.id_produk')
            ->where('id_pesanan',$id)
            ->select(
                'produks.nama_produk',
                'produks.path_gambar',
                'detailpesanans.qty',
                'detailpesanans.harga'
            )
            ->get();

        return view('pages.kurir.show',compact(
            'pesanan',
            'detail'
        ));
    }
}
