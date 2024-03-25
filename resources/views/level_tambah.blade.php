@extends('layouts.app')

@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Create')

@section('content')

    <div class="card card-primary">
        <div class="card-header">

            <h3 class="card-title">Form Tambah</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('level.tambahsimpan') }}" method="POST">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group">
                    <label for="kodeLevel">Kode Level</label>
                    <input type="text" class="form-control" id="kodeLevel" name="kodeLevel" placeholder="Contoh : Untuk Administrator. ADM">
                </div>
                <div class="form-group">
                    <label for="namaLevel">Nama Level</label>
                    <input type="text" class="form-control" id="namaLevel" name="namaLevel" placeholder="Nama Level">
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
