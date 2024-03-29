@extends('layout.app')

@section('subtitle','Kategori')
@section('content_header_title','Home')
@section('content_header_title','Kategori')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Manage Kategori</div>
        <div class="p-3">
            <a href="{{ url('/kategori/create') }}" class="btn btn-primary">Tambah Kategori</a>
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