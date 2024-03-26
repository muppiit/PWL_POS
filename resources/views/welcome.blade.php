@extends('layout.app')

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle','Welcome')

@section('content_body')
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Form Tabel m_user</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Level ID</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Nama</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Password</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title">Form Tabel m_level</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Level ID</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Level Kode</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                        <label for="inputLevelID" class="col-sm-2 col-form-label">Level Nama</label>
                        <input type="text" class="form-control" placeholder="Enter ...">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
@stop

@push('css')

@endpush

@push('js')
<script>
    console.log("Hi, I'am using the Laravel-AdminLTE pakcage !")
</script>
@endpush