<table>
    <tr>
        <!-- <td style="width:150px;"><img src="{{ public_path('img/garfu.jpg') }}" style="width: 80px; height: 60px;"></td> -->
        <td><h3 style="text-align: center;">Laporan Penjualan</h3></td>
    </tr>
  </table>
<hr>

<table border="1" cellspacing="0" cellpadding="5">
  <tr>
    <th>No</th>
    <th>Tanggal Pemesanan</th>
    <th>Nama Produk</th>
    <th>Jumlah</th>
    <th>Harga Bayar</th>
    <th>Sub Total</th>
  </tr>
  @php($i = 1)
  @foreach($pesanans as $pesan)
  <tr>
    <td>{{ $i++ }}</td>
    <td>{{$pesan->tgl_pemesanan}}</td>
    <td>{{$pesan->nama_produk}}</td>
    <td>{{$pesan->qty}}</td>
    <td>Rp. {{$pesan->harga}}</td>
    <td>Rp. {{$pesan->subtotal}}</td>
  </tr>
  @endforeach
  <tr>

    <td colspan="5" style="text-align: center;">Total Pendapatan</td>
    <td>Rp. {{$total}}</td>
  </tr>
</table><br><br>



