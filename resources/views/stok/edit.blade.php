@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($stok)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('stok') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else
        <form method="POST" action="{{ url('/stok/'.$stok->stok_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!}
            <!-- tambahkan baris ini untuk proses edit
            yang butuh method PUT -->
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Kode Barang</label>
                <div class="col-10">
                    <input type="text" class="form-control" value="{{ $stok->barang->barang_kode }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama Barang</label>
                <div class="col-10">
                    <input type="text" class="form-control" value="{{ $stok->barang->barang_nama }}" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Jumlah Stok</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="stok_jumlah" value="{{ $stok->stok_jumlah }}"
                        required>
                    @error('stok_jumlah')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Tanggal Stok</label>
                <div class="col-10">
                    <input type="datetime-local" class="form-control" name="stok_tanggal"
                        value="{{ $stok->stok_tanggal }}" required>
                    @error('stok_jumlah')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('stok') }}">Kembali</a>
                </div>
            </div>
        </form>
        @endempty
    </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush
