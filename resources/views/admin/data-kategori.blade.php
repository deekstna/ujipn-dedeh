@extends('admin.layouts.templates')

@section('content')
<div class="shadow p-3">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses</strong> {{ session('success') }}
            <button type="button" class="btn-close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Gagal</strong> {{ session('error') }}
            <button type="button" class="btn-close"></button>
        </div>
    @endif
    <a href="{{ route('admin.form-kategori') }}" class="btn btn-success mb-4 px-4">
        <i class="fas fa-plus"></i>Tambah Data Kategori
    </a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="bg-success text-light" >No</th>
                <th class="bg-success text-light" >Nama Kategori</th>
                <th class="bg-success text-light" >Deskripsi</th>
                <th class="bg-success text-light">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $index => $kat)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kat->nama_kategori }}</td>
                    <td>{{ $kat->deskripsi }}</td>
                    <td class="text-center">
                        <a href="/admin/kategori/edit/{{ $kat->id }}" class="btn btn-sm btn-info m-0" style="box-shadow: none !important">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="/admin/kategori/delete/{{ $kat->id }}" class="btn btn-sm btn-danger m-0 @if ($kat->aspirasi->count() > 0) disabled @endif" style="box-shadow: none !Important"
                           onclick="return confirm('Yakin data kategori ini akan dihapus?')">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
