<?php

namespace App\Console\Commands;

use App\Services\JadwalPdfParser;
use Illuminate\Console\Command;
use Throwable;

class TestJadwalPdf extends Command
{
    protected $signature = 'jadwal:test-pdf
                            {file : Path file PDF jadwal}';

    protected $description = 'Test membaca PDF jadwal tanpa menyimpan ke database';

    public function handle(JadwalPdfParser $parser): int
    {
        $file = $this->argument('file');

        /*
         * Jika path relatif, kita anggap relatif
         * terhadap folder project Laravel.
         */
        if (! str_starts_with($file, DIRECTORY_SEPARATOR)
            && ! preg_match('/^[A-Za-z]:[\\\\\\/]/', $file)
        ) {
            $file = base_path($file);
        }

        if (! file_exists($file)) {
            $this->error('❌ File PDF tidak ditemukan.');
            $this->line("Path: {$file}");

            return self::FAILURE;
        }

        $this->info('==============================================');
        $this->info(' TEST PEMBACAAN PDF JADWAL SIKAP ESPENERO');
        $this->info('==============================================');

        $this->line('');
        $this->line("File : {$file}");
        $this->line('');

        try {
            $hasil = $parser->parse($file);

            $this->info('✅ PDF berhasil dibaca.');
            $this->line('');

            $this->info(
                'Jumlah record hasil pembacaan: '
                . count($hasil)
            );

            $this->line('');

            if (empty($hasil)) {
                $this->warn(
                    '⚠️ Parser belum menghasilkan record.'
                );

                return self::SUCCESS;
            }

            /*
             * Statistik kode guru.
             */
            $kodeGuru = [];

            foreach ($hasil as $item) {
                $kode = $item['kode_guru'] ?? null;

                if ($kode) {
                    $kodeGuru[$kode] =
                        ($kodeGuru[$kode] ?? 0) + 1;
                }
            }

            ksort($kodeGuru);

            $this->info('KODE GURU YANG TERBACA:');

            foreach ($kodeGuru as $kode => $jumlah) {
                $this->line(
                    "  {$kode} = {$jumlah} jadwal"
                );
            }

            $this->line('');

            /*
             * Tampilkan maksimal 30 record.
             */
            $this->info('30 RECORD PERTAMA:');
            $this->line('');

            $rows = [];

            foreach (array_slice($hasil, 0, 30) as $item) {
                $rows[] = [
                    $item['hari'] ?? '-',
                    $item['jam_ke'] ?? '-',
                    $item['jam_mulai'] ?? '-',
                    $item['jam_selesai'] ?? '-',
                    $item['kelas'] ?? '-',
                    $item['kode_guru_raw'] ?? '-',
                    $item['kode_guru'] ?? '-',
                ];
            }

            $this->table(
                [
                    'Hari',
                    'Jam',
                    'Mulai',
                    'Selesai',
                    'Kelas',
                    'Kode Raw',
                    'Kode Guru',
                ],
                $rows
            );

            $this->line('');

            /*
             * Rekap hari.
             */
            $rekapHari = [];

            foreach ($hasil as $item) {
                $hari = $item['hari'] ?? 'Tidak diketahui';

                $rekapHari[$hari] =
                    ($rekapHari[$hari] ?? 0) + 1;
            }

            $this->info('REKAP PER HARI:');

            foreach ($rekapHari as $hari => $jumlah) {
                $this->line(
                    "  {$hari} = {$jumlah} jadwal"
                );
            }

            $this->line('');

            $this->info(
                '=============================================='
            );

            $this->info(
                ' TEST SELESAI — DATABASE TIDAK DIUBAH'
            );

            $this->info(
                '=============================================='
            );

            return self::SUCCESS;

        } catch (Throwable $e) {

            $this->error(
                '❌ GAGAL MEMBACA PDF'
            );

            $this->error(
                get_class($e)
            );

            $this->error(
                $e->getMessage()
            );

            $this->line('');

            $this->warn(
                'Database TIDAK disentuh.'
            );

            return self::FAILURE;
        }
    }
}