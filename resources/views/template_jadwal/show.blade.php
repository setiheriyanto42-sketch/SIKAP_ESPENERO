@extends('layouts.app')

@section('content')

<div class="container">

    <h3>
        📅 {{ $templateJadwal->nama }}
    </h3>

    <a href="{{ route('template-jadwal.index') }}"
       class="btn btn-secondary mb-3">

        ← Kembali

    </a>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>No</th>
            <th>Jenis</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>

        </tr>

        </thead>

        <tbody>

        @foreach($templateJadwal->jamPelajaran as $jam)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ strtoupper(str_replace('_',' ',$jam->jenis)) }}</td>

                <td>{{ $jam->jam_mulai }}</td>

                <td>{{ $jam->jam_selesai }}</td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection