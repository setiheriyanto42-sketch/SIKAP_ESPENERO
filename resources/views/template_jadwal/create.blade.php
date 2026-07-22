@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">

            <h4>Tambah Template Jadwal</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('template-jadwal.store') }}"
                  method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>Nama Template</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Durasi JP (Menit)</label>

                        <input
                            type="number"
                            name="durasi_jp"
                            value="40"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Jam Masuk</label>

                        <input
                            type="time"
                            name="jam_masuk"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Jumlah JP</label>

                        <input
                            type="number"
                            name="jumlah_jp"
                            value="10"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Istirahat setelah JP</label>

                        <input
                            type="number"
                            name="istirahat_setelah"
                            value="3"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Durasi Istirahat</label>

                        <input
                            type="number"
                            name="durasi_istirahat"
                            value="20"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Ishoma setelah JP</label>

                        <input
                            type="number"
                            name="ishoma_setelah"
                            value="6"
                            class="form-control">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label>Durasi Ishoma</label>

                        <input
                            type="number"
                            name="durasi_ishoma"
                            value="40"
                            class="form-control">

                    </div>

                </div>

                <button
                    class="btn btn-primary">

                    Simpan

                </button>

                <a href="{{ route('template-jadwal.index') }}"
                   class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection