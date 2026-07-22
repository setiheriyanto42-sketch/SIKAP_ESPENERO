@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>📅 Template Jadwal</h3>

        <a href="{{ route('template-jadwal.create') }}"
           class="btn btn-primary">
            + Tambah Template
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                <tr>

                    <th width="60">No</th>
                    <th>Nama Template</th>
                    <th>Durasi JP</th>
                    <th>Jam Masuk</th>
                    <th>Jumlah JP</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($templates as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->nama }}</td>

                        <td>{{ $item->durasi_jp }} Menit</td>

                        <td>{{ $item->jam_masuk }}</td>

                        <td>{{ $item->jumlah_jp }}</td>

                        <td>

                            @if($item->aktif)

                                <span class="badge bg-success">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Tidak Aktif
                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="#" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <a href="#" class="btn btn-danger btn-sm">
                                Hapus
                            </a>

                            <form action="{{ route('template-jadwal.generate', $item) }}"
                                method="POST"
                                style="display:inline;">

                                @csrf

                                <button type="submit"
                                        class="btn btn-success btn-sm"
                                        onclick="return confirm('Generate ulang jadwal ini? Semua JP lama akan dihapus.')">

                                    ⚙ Generate

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            Belum ada Template Jadwal

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection