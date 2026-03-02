@extends('siswa.layouts.templates')

@section('content')
<div class="main-content min-vh-100">
    <div class="box shadow p-5">
        <div class="row justify-content-center">
            <div class="col-10">
                <h2 class="text-center mb-4">FORM EDIT ADUAN ASPIRASI</h2>
                <p class="lead fst-italic text-center">Isi data di bawah ini dengan benar</p>
                <form action="{{ route('siswa.proses-edit') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Hidden ID -->
                    <input type="hidden" name="id" value="{{ $aspirasi->id }}">
                    <!-- Nama Siswa -->
                    <div class="form-group row mb-3 align-items-center">
                        <label class="col-3">Nama Siswa</label>
                        <div class="col-9">
                            <input type="text"
                                   class="form-control"
                                   value="{{ auth()->user()->nama }}"
                                   disabled>
                        </div>
                    </div>
                    <!-- Kelas -->
                    <div class="form-group row mb-3 align-items-center">
                        <label class="col-3">Kelas</label>
                        <div class="col-9">
                            <input type="text"
                                   class="form-control"
                                   value="{{ auth()->user()->siswa->kelas }}"
                                   disabled>
                        </div>
                    </div>
                    <!-- Kategori -->
                    <div class="form-group row mb-3 align-items-center">
                        <label class="col-3">Kategori</label>
                        <div class="col-9">
                            <select name="kategori_id"
                                    class="form-control @error('kategori_id') is-invalid @enderror">

                                <option value="">-- Pilih Kategori --</option>

                                @foreach($kategori as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $aspirasi->kategori_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Judul -->
                    <div class="form-group row mb-3 align-items-center">
                        <label class="col-3">Judul</label>
                        <div class="col-9">
                            <input type="text"
                                   name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ $aspirasi->judul }}">
                            @error('judul')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Isi Pesan -->
                    <div class="form-group row mb-3 align-items-center">
                        <label class="col-3">Isi Pesan</label>
                        <div class="col-9">
                            <textarea name="isi"
                                      rows="5"
                                      class="form-control @error('isi') is-invalid @enderror">{{ $aspirasi->isi }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Tombol -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-edit"></i> Edit Aduan
                        </button>
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
