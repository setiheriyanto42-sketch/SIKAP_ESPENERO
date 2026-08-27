@extends('layouts.app')

@section('content')

<div class="container">

    <h2>🤖 Struktur Modul Ajar</h2>

    <pre>

{{ print_r($struktur,true) }}

    </pre>

    <form
        action="{{ route('modul-ajar.upload.save') }}"
        method="POST">

        @csrf

        <button
            class="btn btn-success">

            💾 Simpan ke Database

        </button>

    </form>

</div>

@endsection