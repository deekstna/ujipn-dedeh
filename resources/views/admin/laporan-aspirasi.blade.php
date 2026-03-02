@extends('admin.layouts.templates')

@section('content')
    <div class="table-box">
        <h3>Daftar Aspirasi Siswa</h3>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('admin.laporan') }}" method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="nama" class="form-control" placeholder="Cari Nama Siswa..."
                    value="{{ request('nama') }}">
            </div>

            <div class="col-md-4">
                <select name="kategori" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 d-flex">
                <button type="submit" class="btn btn-primary m-0 me-2">Filter</button>
                <a href="{{ route('admin.laporan') }}" class="btn btn-secondary m-0">Reset</a>
                <a href="{{ route('admin.cetak-laporan', request()->query()) }}" class="btn btn-info m-0 ms-auto text-light"
                    target="_blank">Cetak
                    Laporan</a>
            </div>
        </form>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th class="bg-primary" width="60">No</th>
                    <th class="bg-primary">Nama Siswa</th>
                    <th class="bg-primary">Judul</th>
                    <th class="bg-primary">Kategori</th>
                    <th class="bg-primary text-center">Status</th>
                    <th class="text-center bg-primary">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aspirasi as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($aspirasi->currentPage() - 1) * $aspirasi->perPage() }}</td>
                        <td>{{ $item->siswa->user->nama }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td class="text-center"><span
                                class="status {{ $item->status }} text-capitalize">{{ $item->status }}</span></td>
                        <td class="text-center">
                            <a href="" class="btn btn-sm btn-info m-0 px-4 me-2 text-white tombolDetail"
                                data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $item->id }}">
                                <i class="fas fa-edit"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-34 d-flex justify-content-center">
            {{ $aspirasi->links() }}
        </div>
    </div>


    {{-- Modal Tanggapan --}}
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Form Tanggapan Aspirasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.tanggapan') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="aspirasi_id" id="aspirasi_id">
                        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                        <div class="form-group mb-3">
                            <label for="judul" class="form-label">Judul Aspirasi</label>
                            <input type="text" class="form-control" id="judul" disabled>
                        </div>
                        <div class="form-group mb-3">
                            <label for="isi" class="form-label">Uraian Aspirasi</label>
                            <textarea id="isi" rows="3" class="form-control" disabled></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="isi_tanggapan" class="form-label">Isi Tanggapan</label>
                            <textarea name="isi_tanggapan" id="isi_tanggapan" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Ubah Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Ubah Status</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $('.tombolDetail').on('click', function() {
            const id = $(this).data('id');
            $.ajax({
                url: '/admin/get-aspirasi',
                method: 'post',
                dataType: 'json',
                data: {
                    id: id,
                    userId: {{ auth()->user()->id }}
                },
                success: function(data) {
                    $('#aspirasi_id').val(data.aspirasi.id)
                    $('#judul').val(data.aspirasi.judul)
                    $('#isi').val(data.aspirasi.isi)

                    if (data.tanggapan) {
                        $('#isi_tanggapan').val(data.tanggapan.isi_tanggapan);
                        $('#status').val(data.aspirasi.status);
                    }
                }
            });
        });

        $('#exampleModal').on('hidden.bs.modal', function() {
            location.reload();
        });
    </script>
@endsection
