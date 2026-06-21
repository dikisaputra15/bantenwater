@extends('layouts.appfront')

@section('title', 'detail Pesanan')

@push('style')
    <script type="text/javascript"
		src="{{config('midtrans.snap_url')}}"
    data-client-key="{{config('midtrans.client_key')}}"></script>
@endpush

@section('main')
<h1 class="h3 mb-2 text-gray-800">Detail Pesanan</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan</h6>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Gambar</th>
                        <th>Jumlah</th>
                        <th>Harga Bayar</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php($i = 1)
                    @foreach ($detailpesans as $detail)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{$detail->nama_produk}}</td>
                        <td><img src="{{ Storage::url('gambarproduk/'.$detail->path_gambar) }}" style="width:60px; height:60px;"></td>
                        <td>{{$detail->jml}}</td>
                        <td>{{$detail->harga_bayar}}</td>
                        <td>{{$detail->sub_total}}</td>
                    </tr>
                @endforeach

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td>
                            {{$pesanan->total_bayar}}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Atas Nama Pemesan</td>
                        <td>
                          {{$pesanan->nama_pemesan}}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Nomor Meja</td>
                        <td>
                          {{$meja->no_meja}}
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
      // Also, use the embedId that you defined in the div above, here.
      window.snap.pay('{{$snapToken}}', {
        onSuccess: function (result) {
          /* You may add your own implementation here */
            // alert("payment success!");
            window.location.href = '/pembayaran'
            console.log(result);
        },
        onPending: function (result) {
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
        },
        onError: function (result) {
          /* You may add your own implementation here */
          alert("payment failed!"); console.log(result);
        },
        onClose: function () {
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      });
    });
  </script>
@endpush
