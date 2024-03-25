@extends('layouts.app')

@section('subtitle', 'User')
@section('content_header_title', 'Home')
@section('content_header_subtitle','User')

@section('content_body')
<div class="container">
    <div class="card">
        <div class="card-header">Manage User</div>
        <div class="p-3">
            <a href="{{ route('m_user.create') }}" class="btn btn-primary">Tambah User</a>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{ $dataTable->scripts() }}
@endpush
