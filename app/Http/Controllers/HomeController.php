<?php

namespace App\Http\Controllers;

use App\Models\Warung;
use App\Models\Pesanan;
use App\Models\Detailpesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $warungs = DB::table('warungs')->orderBy('id', 'desc')->get();
        return view('pages.fronts.index', compact('warungs'));
    }

    public function lihatproduk($id)
    {
        $warung = \App\Models\Warung::findOrFail($id);
        $mejas = DB::table('mejas')->orderBy('id', 'asc')->get();
        $produks = DB::table('produks')->where('id_warung', $id)->orderBy('produks.id', 'desc')->get();
        return view('pages.fronts.lihatproduk', compact('warung','produks', 'mejas'));
    }

    public function dashboard(Request $request)
    {
        $produks = DB::table('produks')->orderBy('id', 'desc')->get();
        return view('pages.dashboard', compact('produks'));
    }

    public function lihatpdf(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $pesanans = DB::table('detailpesanans')
                    ->join('pesanans', 'pesanans.id', '=', 'detailpesanans.pesanan_id')
                    ->join('produks', 'produks.id', '=', 'detailpesanans.produk_id')
                    ->whereBetween('pesanans.tgl_pemesanan', [$start_date, $end_date])
                    ->where('pesanans.status_pembayaran', 'Paid')
                    ->select('pesanans.*', 'detailpesanans.*', 'produks.nama_produk')
                    ->get();

        $total = DB::table('detailpesanans')
            ->join('pesanans', 'pesanans.id', '=', 'detailpesanans.pesanan_id')
            ->whereBetween('pesanans.tgl_pemesanan', [$start_date, $end_date])
            ->where('pesanans.status_pembayaran', 'Paid')
            ->select('pesanans.*', 'detailpesanans.*')
            ->sum('detailpesanans.subtotal');

        $pdf = PDF::loadView('lappenjualanpdf', compact('pesanans','total'));
        $pdf->setPaper('A4', 'potrait');
        return $pdf->stream('lappenjualanpdf.pdf');
    }

    public function lapwarunglaris()
    {
        $datawarung = DB::table('detailpesanans')
                    ->join('warungs', 'warungs.id', '=', 'detailpesanans.id_warung')
                    ->select('warungs.nama_warung as warung', DB::raw('count(detailpesanans.id) as total'))
                    ->groupBy('warung')
                    ->orderBy('total', 'desc')
                    ->get();

        return view('pages.pembayarans.lapwarunglaris', compact('datawarung'));
    }

    public function lapproduklaris()
    {
        $dataproduk = DB::table('detailpesanans')
        ->join('produks', 'produks.id', '=', 'detailpesanans.produk_id')
        ->select('produks.nama_produk as produk', DB::raw('count(detailpesanans.id) as total'))
        ->groupBy('produk')
        ->orderBy('total', 'desc')
        ->get();

        return view('pages.pembayarans.lapproduklaris', compact('dataproduk'));
    }
}
