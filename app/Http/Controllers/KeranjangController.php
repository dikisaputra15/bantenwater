<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Meja;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{

    public function index()
    {
        $cart = session('cart', []);

        return view('pages.keranjangs.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $sub_total = $request->harga_bayar * $request->jml;
        Keranjang::create([
            'id_produk' => $request->id_produk,
            'id_meja' => $request->id_meja,
            'id_warung' => $request->id_warung,
            'jml' => $request->jml,
            'harga_bayar' => $request->harga_bayar,
            'sub_total' => $sub_total
        ]);

        return redirect("/")->with('success', 'Data successfully created');

    }

    public function destroykeranjang($id)
    {
        $meja = Keranjang::find($id);
        $id_meja = $meja->id_meja;
        $mastermeja = Meja::find($id_meja);

        DB::table('keranjangs')->where('id',$id)->delete();
        return redirect("meja/$mastermeja->id/lihatpesanan")->with('success', 'Data successfully Deleted');
    }

    public function createpenjualan(Request $request)
    {
        $produks = DB::table('produks')->orderBy('id', 'desc')->get();

        return view('pages.keranjangs.allproduk', compact('produks'));
    }

    public function addToCart(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        $cart = session()->get('cart', []);

        if(isset($cart[$produk->id])) {

            $cart[$produk->id]['stock']++;

        } else {

            $cart[$produk->id] = [
                'id' => $produk->id,
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'gambar' => $produk->path_gambar,
                'stock' => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

   public function update(Request $request)
    {
        $cart = session()->get('cart', []);

        foreach ($request->stock as $id => $qty) {

            $produk = Produk::find($id);

            if (!$produk) {
                continue;
            }

            if ($qty > $produk->stock) {

                return redirect()->back()->with(
                    'error',
                    'Qty produk '.$produk->nama_produk.
                    ' tidak boleh melebihi stok tersedia ('.$produk->stock.')'
                );
            }

            if (isset($cart[$id])) {
                $cart[$id]['stock'] = $qty;
            }
        }

        session()->put('cart', $cart);

        return redirect()->back()->with(
            'success',
            'Keranjang berhasil diperbarui'
        );
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return back()->with('success','Produk dihapus');
    }

}
