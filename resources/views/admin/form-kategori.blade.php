@extends('admin.layouts.templates')

@section('content')
<div class="shadow p-3 row justify-content-center">
    <div class="col-10 p-3">
        <h3>FORM TAMBAH DATA KATEGORI</h3>
        <p class="lead">Silahkan isi data dalam form di bawah ini dengan benar :</p>
            <form action="{{ route('admin.tambah-kategori') }}" method="POST">
                @csrf
                <div class="form-group row mb-3 align-items-center">
                    <label for="nama_kategori" class="form-label col-3">Nama Kategori</label>
                    <div class="col-9">
                        <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Nama Kategori ...">
                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-3 align-items-center">
                    <label for="deskripsi" class="form-label col-3">Deskripsi</label>
                    <div class="col-9">
                        <input type="text" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Nama Deskripsi ...">
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-success px-5" type="submit">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.kategori') }}" class="btn btn-secondary px-4">
                        <i class="fas fa-undo"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

