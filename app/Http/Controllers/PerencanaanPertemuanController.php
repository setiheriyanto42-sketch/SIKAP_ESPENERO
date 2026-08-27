<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PerencanaanBab;
use App\Models\PerencanaanPertemuan;

class PerencanaanPertemuanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CEK KEPEMILIKAN MODUL
    |--------------------------------------------------------------------------
    |
    | Guru hanya boleh mengelola BAB / Pertemuan miliknya sendiri.
    | Admin atau user tanpa guru_id tetap dapat mengakses sesuai hak akses
    | yang nantinya kita atur melalui middleware/role.
    |
    */
    private function pastikanMilikGuru($modul): void
    {
        $user = auth()->user();

        if (
            $user &&
            $user->guru_id &&
            $modul &&
            (int) $modul->guru_id !== (int) $user->guru_id
        ) {
            abort(
                403,
                'Anda tidak memiliki akses ke perencanaan pembelajaran ini.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE PERTEMUAN
    |--------------------------------------------------------------------------
    */
    public function generate(PerencanaanBab $bab)
    {
        /*
        | Ambil Modul induk BAB.
        */
        $bab->load('modul');

        if (!$bab->modul) {
            return back()->with(
                'error',
                'Modul induk BAB tidak ditemukan.'
            );
        }

        /*
        | Proteksi kepemilikan.
        */
        $this->pastikanMilikGuru($bab->modul);

        /*
        | Jangan generate ulang jika sudah ada.
        */
        if ($bab->pertemuans()->exists()) {

            return back()->with(
                'error',
                'Pertemuan untuk BAB ini sudah pernah dibuat.'
            );
        }

        /*
        | Pastikan jumlah pertemuan valid.
        */
        if (
            !$bab->jumlah_pertemuan ||
            $bab->jumlah_pertemuan < 1
        ) {
            return back()->with(
                'error',
                'Jumlah pertemuan pada BAB belum ditentukan.'
            );
        }

        /*
        | Generate Pertemuan.
        */
        for ($i = 1; $i <= $bab->jumlah_pertemuan; $i++) {

            PerencanaanPertemuan::create([

                'perencanaan_bab_id' =>
                    $bab->id,

                'pertemuan_ke' =>
                    $i,

                'judul' =>
                    'Pertemuan ' . $i,

                'materi' =>
                    null,

                'tujuan' =>
                    null,

                'metode' =>
                    null,

                'media' =>
                    null,

                'lkpd' =>
                    null,

                'asesmen' =>
                    null,

                'catatan' =>
                    null,

                'refleksi' =>
                    null,

                'tanggal' =>
                    null,

                'sudah_diajarkan' =>
                    false,

                'ada_penilaian' =>
                    false,
            ]);
        }

        return back()->with(
            'success',
            $bab->jumlah_pertemuan .
            ' pertemuan berhasil dibuat.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN / EDITOR PERTEMUAN
    |--------------------------------------------------------------------------
    */
    public function show(PerencanaanPertemuan $pertemuan)
    {
        $pertemuan->load([

            'bab.modul.mataPelajaran',

            'bab.modul.guru',

            'bab.modul.tahunAjaran',

        ]);

        /*
        | Pastikan struktur induk ditemukan.
        */
        if (
            !$pertemuan->bab ||
            !$pertemuan->bab->modul
        ) {
            return redirect()
                ->route('modul-ajar.index')
                ->with(
                    'error',
                    'Modul induk Pertemuan tidak ditemukan.'
                );
        }

        /*
        | Proteksi kepemilikan guru.
        */
        $this->pastikanMilikGuru(
            $pertemuan->bab->modul
        );

        return view(
            'modul_pertemuan.show',
            compact('pertemuan')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PERTEMUAN
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        PerencanaanPertemuan $pertemuan
    ) {
        /*
        |--------------------------------------------------------------------------
        | LOAD MODUL INDUK
        |--------------------------------------------------------------------------
        */

        $pertemuan->load(
            'bab.modul'
        );

        if (
            !$pertemuan->bab ||
            !$pertemuan->bab->modul
        ) {
            return redirect()
                ->route('modul-ajar.index')
                ->with(
                    'error',
                    'Modul induk Pertemuan tidak ditemukan.'
                );
        }

        /*
        | Proteksi kepemilikan.
        */
        $this->pastikanMilikGuru(
            $pertemuan->bab->modul
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'judul' =>
                'required|string|max:255',

            'tanggal' =>
                'nullable|date',

            'materi' =>
                'nullable|string',

            'tujuan' =>
                'nullable|string',

            'metode' =>
                'nullable|string',

            'media' =>
                'nullable|string',

            'lkpd' =>
                'nullable|string',

            'asesmen' =>
                'nullable|string',

            'catatan' =>
                'nullable|string',

            'refleksi' =>
                'nullable|string',

        ]);


        /*
        |--------------------------------------------------------------------------
        | CHECKBOX
        |--------------------------------------------------------------------------
        */

        $validated['sudah_diajarkan'] =
            $request->boolean(
                'sudah_diajarkan'
            );

        $validated['ada_penilaian'] =
            $request->boolean(
                'ada_penilaian'
            );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATABASE
        |--------------------------------------------------------------------------
        */

        $pertemuan->update(
            $validated
        );


        /*
        |--------------------------------------------------------------------------
        | JIKA ADA PENILAIAN
        |--------------------------------------------------------------------------
        */

        if ($validated['ada_penilaian']) {

            /*
            | Jika update dilakukan dalam proses mengajar,
            | mungkin tersedia sesi_mengajar_id.
            */

            $sesiMengajarId =
                $request->input(
                    'sesi_mengajar_id'
                );

            if ($sesiMengajarId) {

                return redirect()
                    ->route(
                        'penilaian.create',
                        [
                            'sesiMengajar' =>
                                $sesiMengajarId
                        ]
                    )
                    ->with(
                        'success',
                        'Pertemuan berhasil disimpan. Silakan isi penilaian.'
                    );
            }

            /*
            | Jika dibuka dari Modul Ajar,
            | belum ada sesi mengajar.
            */

            return redirect()
                ->route(
                    'pertemuan.show',
                    $pertemuan
                )
                ->with(
                    'success',
                    'Pertemuan berhasil disimpan dan ditandai memiliki penilaian.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA TIDAK ADA PENILAIAN
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'pertemuan.show',
                $pertemuan
            )
            ->with(
                'success',
                'Data Pertemuan ' .
                $pertemuan->pertemuan_ke .
                ' berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | HAPUS PERTEMUAN
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        /*
        | Ambil manual berdasarkan ID agar aman dari masalah
        | nama parameter Route Model Binding.
        */

        $pertemuan =
            PerencanaanPertemuan::with([
                'bab.modul'
            ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN BAB DAN MODUL ADA
        |--------------------------------------------------------------------------
        */

        if (
            !$pertemuan->bab ||
            !$pertemuan->bab->modul
        ) {
            return redirect()
                ->route('modul-ajar.index')
                ->with(
                    'error',
                    'Modul induk Pertemuan tidak ditemukan.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | PROTEKSI KEPEMILIKAN
        |--------------------------------------------------------------------------
        */

        $this->pastikanMilikGuru(
            $pertemuan->bab->modul
        );


        /*
        |--------------------------------------------------------------------------
        | SIMPAN MODUL ID
        |--------------------------------------------------------------------------
        |
        | Disimpan sebelum Pertemuan dihapus untuk redirect.
        |
        */

        $modulAjarId =
            $pertemuan
                ->bab
                ->perencanaan_pembelajaran_id;


        /*
        |--------------------------------------------------------------------------
        | JANGAN HAPUS JIKA SUDAH DIAJARKAN
        |--------------------------------------------------------------------------
        */

        if ($pertemuan->sudah_diajarkan) {

            return redirect()
                ->route(
                    'modul-ajar.show',
                    [
                        'modulAjar' =>
                            $modulAjarId
                    ]
                )
                ->with(
                    'error',
                    'Pertemuan tidak dapat dihapus karena sudah digunakan dalam proses pembelajaran.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | HAPUS PERTEMUAN
        |--------------------------------------------------------------------------
        */

        $nomorPertemuan =
            $pertemuan->pertemuan_ke;

        $pertemuan->delete();


        /*
        |--------------------------------------------------------------------------
        | KEMBALI KE MODUL
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'modul-ajar.show',
                [
                    'modulAjar' =>
                        $modulAjarId
                ]
            )
            ->with(
                'success',
                'Pertemuan ' .
                $nomorPertemuan .
                ' berhasil dihapus.'
            );
    }
}