@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3>Template Jam Pelajaran</h3>

        <a href="{{ route('template-jam.create') }}"
           class="btn btn-primary">

            + Tambah Template

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>No</th>
                        <th>Template</th>
                        <th>JP</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($templateJam as $item)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $item->nama_template }}</td>

                        <td>{{ $item->jp }}</td>

                        <td>{{ $item->jam_mulai }}</td>

                        <td>{{ $item->jam_selesai }}</td>

                        <td>{{ ucfirst(str_replace('_',' ',$item->jenis)) }}</td>

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

                            Edit |
                            Hapus

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center">

                            Belum ada data

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection