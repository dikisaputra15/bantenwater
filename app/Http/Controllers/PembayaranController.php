<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Detailpesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pesanans = DB::table('pesanans')
                ->join('mejas', 'mejas.id', '=', 'pesanans.id_meja')
                ->select('pesanans.*', 'mejas.no_meja')
                ->orderBy('pesanans.id', 'desc')->get();
        return view('pages.pembayarans.index', compact('pesanans'));
    }

    public function bayar($id)
    {
        $pesanan = Pesanan::find($id);
        $id_meja = $pesanan->id_meja;
        $meja = Meja::find($id_meja);
        $detailpesans = DB::table('detailpesanans')
            ->join('produks', 'produks.id', '=', 'detailpesanans.id_produk')
            ->select('detailpesanans.*', 'produks.nama_produk', 'produks.path_gambar')
            ->where('detailpesanans.id_pesanan', $id)->orderBy('detailpesanans.id', 'desc')->get();

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $pesanan->id,
                'gross_amount' => $pesanan->total_bayar,
            ),
            'customer_details' => array(
                'name' => $pesanan->nama_pemesan,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('pages.pembayarans.bayar', compact('snapToken', 'pesanan', 'meja', 'detailpesans'));
    }

    public function invoice($id)
    {
        $pesanan = DB::table('pesanans')
        ->where('id', $id)
        ->first();

        $detailPesanan = DB::table('detailpesanans')
            ->join('produks', 'detailpesanans.produk_id', '=', 'produks.id')
            ->join('pesanans', 'detailpesanans.pesanan_id', '=', 'pesanans.id')
            ->select(
                'detailpesanans.*',
                'produks.nama_produk',
                'produks.harga as harga_produk',
                'pesanans.kode_pesanan'
            )
            ->where('detailpesanans.pesanan_id', $id)
            ->get();

        return view('pages.pembayarans.invoice', compact(
            'pesanan',
            'detailPesanan'
        ));
    }

    public function callback(Request $request)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;

        $notif = new \Midtrans\Notification();

        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;

        $pesanan = Pesanan::where('kode_pesanan', $orderId)->first();

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan']);
        }

        if (
            $transaction == 'settlement' ||
            $transaction == 'capture'
        ) {

            $pesanan->update([
                'status_pembayaran' => 'Paid'
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function transaksi(Request $request)
    {
        return view('pages.pembayarans.transaksi');
    }

    public function pesananmasuk(Request $request)
    {
        $id = auth()->user()->id_warung;
        $pesanans = DB::table('pesanans')
        ->join('mejas', 'mejas.id', '=', 'pesanans.id_meja')
        ->join('detailpesanans', 'pesanans.id', '=', 'detailpesanans.id_pesanan')
        ->select('pesanans.*', 'mejas.no_meja', 'detailpesanans.*')
        ->where('pesanans.status', 'Paid')
        ->where('pesanans.keterangan', 'diproses')
        ->where('detailpesanans.id_warung', $id)
        ->orderBy('pesanans.id', 'desc')
        ->get();
        return view('pages.pembayarans.pesananmasuk', compact('pesanans'));
    }

    public function updatepesananmasuk($id)
    {
        $detail = \App\Models\Detailpesanan::findOrFail($id);
        $id_pesanan = $detail->id_pesanan;
        DB::table('pesanans')->where('id',$id_pesanan)->update([
            'keterangan' => 'selesai'
        ]);

        return redirect("/pesananmasuk");
    }

    public function allpesanan(Request $request)
    {
        $pesanans = DB::table('pesanans')
        ->orderBy('pesanans.id', 'desc')
        ->get();
        return view('pages.pembayarans.allpesanan', compact('pesanans'));
    }

    public function nota($id)
    {
        $pesanan = Pesanan::find($id);
        $produks = DB::table('pesanans')
        ->join('mejas', 'mejas.id', '=', 'pesanans.id_meja')
        ->join('detailpesanans', 'pesanans.id', '=', 'detailpesanans.id_pesanan')
        ->join('produks', 'produks.id', '=', 'detailpesanans.id_produk')
        ->select('detailpesanans.*', 'mejas.no_meja', 'produks.nama_produk', 'pesanans.*')
        ->where('pesanans.id', $id)
        ->orderBy('pesanans.id', 'desc')
        ->get();
        return view('pages.pembayarans.nota', compact('pesanan','produks'));
    }

    public function checkout()
    {
        $cart = session('cart', []);

        if(count($cart) == 0){
            return redirect()->route('cart')
                ->with('error','Keranjang masih kosong');
        }

        return view('pages.pembayarans.index', compact('cart'));
    }

    public function createOrder(Request $request)
    {
        $sekarang = Carbon::now();
        $cart = session('cart', []);

        DB::beginTransaction();

        try {

            $total = 0;

            foreach($cart as $item){
                $total += $item['harga'] * $item['stock'];
            }

            $pesanan = Pesanan::create([
                'kode_pesanan' => 'ORD'.time(),
                'tgl_pemesanan' => $sekarang,
                'nama_pembeli' => $request->nama_pembeli,
                'no_hp' => $request->no_hp,
                'total_harga' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' =>
                    $request->metode_pembayaran == 'Cash'
                        ? 'Paid'
                        : 'Pending'
            ]);

            foreach($cart as $item){

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item['id'],
                    'qty' => $item['stock'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['harga'] * $item['stock']
                ]);

                if($request->metode_pembayaran == 'Cash'){

                    Produk::where('id',$item['id'])
                        ->decrement('stock',$item['stock']);
                }
            }

            if($request->metode_pembayaran == 'QRIS'){

                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = false;
                Config::$isSanitized = true;
                Config::$is3ds = true;

                $params = [

                    'transaction_details' => [
                        'order_id' => $pesanan->kode_pesanan,
                        'gross_amount' => $total
                    ],

                    'customer_details' => [
                        'first_name' => $request->nama_pembeli,
                        'phone' => $request->no_hp
                    ]
                ];

                $snapToken = Snap::getSnapToken($params);

                $pesanan->update([
                    'snap_token' => $snapToken,
                    'status_pembayaran' => 'Paid'
                ]);

                DB::commit();

                return response()->json([
                    'type' => 'qris',
                    'snap_token' => $snapToken
                ]);
            }

            DB::commit();

            session()->forget('cart');

            return response()->json([
                'type' => 'cash',
                'redirect' => route('allpesanan')
            ]);

        } catch (\Exception $e){

            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage()
            ],500);
        }
    }
}
