<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GuruDapodikImport
{
    /**
     * Mapping KODE GURU SIKAP -> NAMA GURU DI DAPODIK
     *
     * Kode guru TIDAK BOLEH diganti.
     * Kode ini adalah penghubung dengan jadwal yang sudah kita parse.
     */
    protected array $mapping = [

        'A'  => 'Supriyanto',
        'B'  => 'Erna Irianingsih',
        'C'  => 'Lina Fayakuntarti',
        'D'  => 'Hery Suryanto',
        'E'  => 'Sri Prihatin',
        'F'  => 'Sumiati',
        'G'  => 'Ida Musfiana',
        'H'  => 'Giyat',
        'I'  => 'Wahyuni Widyastuti',
        'J'  => 'Giyarsi',
        'K'  => 'Sutarni',
        'L'  => 'Titik Kurniawati',
        'M'  => 'Prihatini Wisnu Utami',
        'N'  => 'Agus Budiyanto',
        'O'  => 'Siswanto',
        'P'  => 'Sumarno',
        'Q'  => 'Suhartanti',
        'R'  => 'Anditya Rahardianto',
        'S'  => 'Ribut Widodo',
        'T'  => 'Agus Rudianto',
        'U'  => 'Seti Heriyanto',
        'V'  => 'NOPITA TRI HASTUTININGSIH',
        'W'  => 'Riskhi Anita Tirta Utama',
        'X'  => 'Joko Santoso',

        // Tidak ada di Dapodik, tetapi tetap dipertahankan
        'Y'  => null,
        'Z'  => null,

        'AA' => 'DIAN MAHARINI',

        // Tidak ada di Dapodik, tetapi tetap dipertahankan
        'AB' => null,
    ];

    public function run(string $path): array
    {
        if (!file_exists($path)) {
            throw new \Exception("File Dapodik tidak ditemukan: {$path}");
        }

        $sheet = IOFactory::load($path)
            ->getActiveSheet()
            ->toArray(null, true, true, true);

        /**
         * Header asli Dapodik berada di baris ke-5.
         * Data guru dimulai dari baris ke-6.
         */
        $rows = array_slice($sheet, 5);

        $dapodik = [];

        foreach ($rows as $row) {

            $nama = trim((string) ($row['B'] ?? ''));

            if ($nama === '') {
                continue;
            }

            // Lewati jika bukan baris guru
            if (strtolower($nama) === 'nama') {
                continue;
            }

            $dapodik[] = [
                'nama'         => $nama,
                'nip'          => $this->clean($row['G'] ?? null),
                'jk'           => $this->clean($row['D'] ?? null),
                'status'       => $this->clean($row['H'] ?? null),
                'jenis_ptk'    => $this->clean($row['I'] ?? null),
                'hp'           => $this->clean($row['S'] ?? null),
                'email'        => $this->clean($row['T'] ?? null),
            ];
        }

        $hasil = [
            'dapodik_dibaca' => count($dapodik),
            'guru_diupdate' => 0,
            'guru_tidak_ditemukan' => 0,
            'akun_dibuat' => 0,
            'akun_diperbarui' => 0,
            'mapping_tidak_ditemukan' => [],
        ];

        DB::transaction(function () use ($dapodik, &$hasil) {

            foreach ($this->mapping as $kode => $namaDapodik) {

                /**
                 * Guru tidak ada di Dapodik.
                 * Jangan dihapus.
                 * Jangan dibuat ulang.
                 *
                 * Y = Galih
                 * Z = Budi
                 * AB = Eko
                 */
                if ($namaDapodik === null) {

                    $guru = Guru::where('kode_guru', $kode)->first();

                    if ($guru) {
                        $hasil['guru_tidak_ditemukan']++;
                        $hasil['mapping_tidak_ditemukan'][] = [
                            'kode_guru' => $kode,
                            'nama' => $guru->nama,
                            'status' => 'TIDAK ADA DI DAPODIK - DIPERTAHANKAN',
                        ];
                    }

                    continue;
                }

                $data = collect($dapodik)->first(function ($item) use ($namaDapodik) {
                    return $this->normalize($item['nama'])
                        === $this->normalize($namaDapodik);
                });

                if (!$data) {

                    $hasil['guru_tidak_ditemukan']++;

                    $hasil['mapping_tidak_ditemukan'][] = [
                        'kode_guru' => $kode,
                        'nama_dapodik_dicari' => $namaDapodik,
                        'status' => 'TIDAK DITEMUKAN',
                    ];

                    continue;
                }

                /**
                 * Cari guru berdasarkan kode_guru.
                 *
                 * KODE GURU adalah identitas internal SIKAP.
                 * Jangan mencari berdasarkan NIP.
                 */
                $guru = Guru::where('kode_guru', $kode)->first();

                if (!$guru) {

                    $guru = Guru::create([
                        'kode_guru' => $kode,
                        'nama' => $data['nama'],
                        'nip' => $data['nip'],
                        'jenis_kelamin' => $data['jk'],
                        'no_hp' => $data['hp'],
                        'email' => $data['email'],
                        'aktif' => true,
                    ]);

                } else {

                    $guru->update([
                        'nama' => $data['nama'],
                        'nip' => $data['nip'],
                        'jenis_kelamin' => $data['jk'],
                        'no_hp' => $data['hp'],
                        'email' => $data['email'],
                        'aktif' => true,
                    ]);
                }

                $hasil['guru_diupdate']++;

                /**
                 * ==============================
                 * BUAT / UPDATE AKUN GURU
                 * ==============================
                 */

                $username = $data['nip'];

                /**
                 * Guru tanpa NIP:
                 * gunakan nama sebagai username.
                 */
                if (!$username) {
                    $username = Str::slug($data['nama']);
                }

                /**
                 * Cari akun berdasarkan guru_id.
                 */
                $user = DB::table('users')
                    ->where('guru_id', $guru->id)
                    ->first();

                if ($user) {

                    /**
                     * Jangan mengganti password guru yang
                     * sudah pernah digunakan.
                     *
                     * Username/email tetap disinkronkan.
                     */
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update([
                            'name' => $data['nama'],
                            'username' => $username,
                            'email' => $data['email'],
                            'role_id' => 2,
                            'updated_at' => now(),
                        ]);

                    $hasil['akun_diperbarui']++;

                } else {

                    DB::table('users')->insert([
                        'guru_id' => $guru->id,
                        'role_id' => 2,
                        'name' => $data['nama'],
                        'username' => $username,
                        'email' => $data['email'],
                        'password' => Hash::make($username),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $hasil['akun_dibuat']++;
                }
            }
        });

        return $hasil;
    }

    /**
     * Normalisasi nama untuk pencocokan.
     */
    protected function normalize(?string $value): string
    {
        if (!$value) {
            return '';
        }

        $value = strtoupper(trim($value));

        // Hilangkan gelar akademik yang ada pada master
        $value = preg_replace(
            '/\b(S\.PD\.|S\.KOM\.|M\.PD\.|M\.PD\.I\.|S\.SI\.|S\.SOS\.|S\.S\.|S\.KOM)\b/i',
            '',
            $value
        );

        // Hilangkan tanda baca
        $value = preg_replace('/[^A-Z0-9 ]/', ' ', $value);

        // Rapikan spasi
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }

    /**
     * Bersihkan nilai Excel.
     */
    protected function clean($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}