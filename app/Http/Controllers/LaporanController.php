<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
     public function index(Request $request)
    {

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $laporan = DB::table('pesanans')

        ->join('users','users.id','=','pesanans.id_user')

        ->join('detailpesanans','detailpesanans.id_pesanan','=','pesanans.id')

        ->join('produks','produks.id','=','detailpesanans.id_produk')

        ->select(

            'pesanans.*',

            'users.name',

            'produks.nama_produk',

            'detailpesanans.qty',

            'detailpesanans.harga'

        )

        ->whereMonth('tgl_pemesanan',$bulan)

        ->whereYear('tgl_pemesanan',$tahun);

        if($request->produk){

            $laporan->where('produks.id',$request->produk);

        }

        if($request->status){

            $laporan->where('status_pesanan',$request->status);

        }

        $laporan=$laporan->get();

        $produk=DB::table('produks')->get();

        $chart=[];

        for($i=1;$i<=31;$i++){

            $chart[] = DB::table('pesanans')

            ->whereDay('tgl_pemesanan',$i)

            ->whereMonth('tgl_pemesanan',$bulan)

            ->sum('total');

        }

        return view('pages.laporan.index',compact(

            'laporan',

            'produk',

            'chart'

        ));

    }

    public function print(Request $request)
    {

        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $laporan = DB::table('pesanans')

            ->join('users','users.id','=','pesanans.id_user')
            ->join('detailpesanans','detailpesanans.id_pesanan','=','pesanans.id')
            ->join('produks','produks.id','=','detailpesanans.id_produk')

            ->select(
                'pesanans.*',
                'users.name',
                'produks.nama_produk',
                'detailpesanans.qty'
            )

            ->whereMonth('tgl_pemesanan',$bulan)
            ->whereYear('tgl_pemesanan',$tahun);

        if($request->produk){

            $laporan->where('produks.id',$request->produk);

        }

        if($request->status){

            $laporan->where('status_pesanan',$request->status);

        }

        $laporan = $laporan->get();

        return view('pages.laporan.print',compact(
            'laporan',
            'bulan',
            'tahun'
        ));

    }

    public function pdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $laporan = DB::table('pesanans')
            ->join('users', 'users.id', '=', 'pesanans.id_user')
            ->join('detailpesanans', 'detailpesanans.id_pesanan', '=', 'pesanans.id')
            ->join('produks', 'produks.id', '=', 'detailpesanans.id_produk')
            ->select(
                'pesanans.*',
                'users.name',
                'produks.nama_produk',
                'detailpesanans.qty',
                'detailpesanans.harga'
            )
            ->whereMonth('tgl_pemesanan', $bulan)
            ->whereYear('tgl_pemesanan', $tahun);

        if ($request->filled('produk')) {
            $laporan->where('produks.id', $request->produk);
        }

        if ($request->filled('status')) {
            $laporan->where('pesanans.status_pesanan', $request->status);
        }

        $laporan = $laporan->get();

        $total = $laporan->sum('total');

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'laporan',
            'bulan',
            'tahun',
            'total'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan-Penjualan.pdf');
    }
}
