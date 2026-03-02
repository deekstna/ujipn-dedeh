@extends('admin.layouts.templates')

@section('content')
        <div class="table-box">
            <h3>Kelola Data Aspirasi</h3>
        @if(session('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ (session('error')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
        @endif
            <table>
                <thead>
                    <tr>
                        <th class="bg-primary" width="60">No</th>
                        <th class="bg-primary">Nama Siswa</th>
                        <th class="bg-primary">Judul</th>
                        <th class="bg-primary">Kategori</th>
                        <th class="bg-primary">Status</th>
                        <th class="bg-primary text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aspirasi as $item)
                        <tr>
                            <td>{{ $loop ->iteration + ($aspirasi->currentPage() -1) * $aspirasi->perPage() }}</td>
                            <td>{{ $item->siswa->user->nama }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->kategori->nama_kategori }}</td>
                            <td><span class="status {{ $item->status }}" style="text-capitalize;">{{ $item->status }}</span></td>
                            <td class="text-center">
                                @if ($item->status == 'menunggu')
                                    <a href="" class="btn btn-sm btn-success m-0 me-2 tombolEdit" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id='{{ $item->id }}'>
                                        <i class="fas fa-comment"></i>Tanggapi
                                    </a>
                                 @else
                                    <a href="" class="btn btn-sm btn-info m-0 px-4 me-2 text-white tombolEdit {{ $item->status || $item->status == 'ditolak' ? 'disabled' : ''}}" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $item->id }}">
                                        <i class="fas fa-edit"></i>Ubah
                                    </a>
                                @endif
                                <a href="/admin/aspirasi/delete/{{ $item->id }}" class="btn btn-sm btn-danger m-0 {{ !in_array ($item->status, ['selesai', 'ditolak']) ? 'disabled' : ''}}" onclick="return confirm('Yakin aspirasi akan dihapus?')">
                                        <i class="fas fa-trash-alt"></i>Hapus
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

{{-- modal tanggapan --}}
<!-- Button trigger modal -->

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
            <label for="isi" class="form-label">Uraian aspirasi</label>
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
        $('.tombolEdit').on('click', function() {
            const id=$(this).data('id');
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
                        $('isi_tanggapan').val(data.tanggapan.isi-tanggapan);
                        $('status').val(data.aspirasi.status);
                    }
                }
            });
        })

        $('#exampleModal').on('hidden.bs.modal', function(){
            location.reload();
        });
    </script>
@endsection
