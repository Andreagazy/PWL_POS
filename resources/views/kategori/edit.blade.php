@extends('layouts.app')
@section('subtitle', 'Kategori')
@section('content_header_title','Kategori')
@section('content_header_subtitle','Edit')

@section('content')
<div class="cotainer">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Edit kategori</h3>
        </div>

        <form action="{{ route('kategori.edit',$data->kategori_id) }}" method="post">
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="kodeKategori">Kode Kategori</label>
                    <input type="text" class="form-control" id="kodeKategori" name="kodeKategori"
                        placeholder="Untuk makanan cnt: MKN" value="{{ $data->kategori_kode }}">
                </div>
                <div class="form-group">
                    <label for="namaKategori">Nama Kategori</label>
                    <input type="text" class="form-control" id="namaKategori" name="namaKategori"
                        placeholder="Nama Kategori" value="{{ $data->kategori_nama }}">
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
