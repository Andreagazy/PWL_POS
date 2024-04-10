@extends('layouts.template')
@section('content')
<form method="POST" action="{{ url('penjualan') }}">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <div class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Nama Pembeli</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="pembeli" value="{{ old('pembeli') }}" required>
                        @error('pembeli')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label col-form-label">Tanggal</label>
                    <div class="col-10">
                        <input type="datetime-local" class="form-control" name="tanggal" value="{{ old('tanggal') }}"
                            required>
                        @error('tanggal')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Barang</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Keranjang</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped table-hover table-sm" id="table_keranjang">
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Sub total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="m-3">
            <h4>Total : <span id="total">0</span></h4>
        </div>
        <div class="form-group row">
            <label class="col-0 mx-2 control-label col-form-label"></label>
            <div class="col-10">
                <button type="submit" class="btn btn-primary btn-sm" id="buatTransaksi">Buat Transaksi</button>
                <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
            </div>
        </div>
    </div>
</form>
{{-- Modal --}}
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="barang_nama">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="number" placeholder="Masukkan Jumlah" min="1" value="1" class="form-control"
                    id="jumlah_barang">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Masukkan Keranjang</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@endsection
@push('css')
@endpush
@push('js')
<script>
    $(document).ready(function() {
        var dataUser = $('#table_barang').DataTable({
          serverSide: true,
          ajax: {
                "url": "{{ url('penjualan/list_barang') }}",
                "dataType": "json",
                "type": "POST",
          },
          columns: [
                {
                    data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },{
                    data: "barang_kode",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },{
                    data: "barang_nama",
                    className: "",
                    orderable: true, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: true // searchable: true, jika ingin kolom ini bisa dicari
                },{
                    data: "stok.stok_jumlah",
                    className: "",
                    orderable: true,
                    searchable: false
                },{
                    data: "harga_jual",
                    className: "",
                    orderable: true,
                    searchable: false
                },{
                    data: "aksi",
                    className: "",
                    orderable: false, // orderable: true, jika ingin kolom ini bisa diurutkan
                    searchable: false // searchable: true, jika ingin kolom ini bisa dicari
                }
            ]
        })
    })
</script>

<script>
    let barang = {};
    function pilihBarang(barang_kode,barang_nama,harga,stok) {
        $('#modal-default').modal('show');
        $('#barang_nama').text(barang_nama);
        $('#jumlah_barang').attr('max',stok);
        barang = {
            barang_kode: barang_kode,
            barang_nama: barang_nama,
            harga: harga,
            stok: stok
        }
    }
    $('#modal-default .btn-primary').click(function() {
        // check jumlah
        let jumlah = $('#jumlah_barang').val();
        let stok = barang.stok;
        // convert to integer
        jumlah = parseInt(jumlah);
        stok = parseInt(stok);
        if (jumlah > barang.stok) {
            alert('Jumlah melebihi stok');
            return;
        }
        // add to keranjang
        let subtotal = jumlah * barang.harga;
        addBarangToKeranjang(barang.barang_kode,barang.barang_nama,jumlah,barang.harga,subtotal);
        $('#modal-default').modal('hide');
        // clear input
        $('#jumlah_barang').val(1);
        // reset barang
        barang = {};
    })

    function addBarangToKeranjang(barang_kode,barang_nama,jumlah,harga,subtotal) {
        let html = `
            <tr>
                <td>${barang_kode}</td>
                <td>${barang_nama}</td>
                <td>${jumlah}</td>
                <td>${harga}</td>
                <td>${subtotal}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapusBarang('${barang_kode}')">Hapus</button>
                </td>
            </tr>
        `;
        $('#table_keranjang tbody').append(html);
        // add hidden input array
        let input = `<input type="hidden" name="barang_kode[]" value="${barang_kode}">`;
        input += `<input type="hidden" name="jumlah[]" value="${jumlah}">`;
        input += `<input type="hidden" name="harga[]" value="${harga}">`;
        $('#table_keranjang').append(input);
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        $('#table_keranjang tbody tr').each(function() {
            let subtotal = $(this).find('td:eq(4)').text();
            total += parseInt(subtotal);
        })
        // pad zero
        $('#total').text(total);
    }

    function hapusBarang(id) {
        $(`#table_keranjang tbody tr:contains('${id}')`).remove();
        updateTotal();
    }

    // prevent form submit
    $('#buatTransaksi').click(function(e) {
        let total = $('#total').text();
        if (total == 0) {
            e.preventDefault();
            alert('Keranjang masih kosong');
            return;
        }
    })
</script>
@endpush
