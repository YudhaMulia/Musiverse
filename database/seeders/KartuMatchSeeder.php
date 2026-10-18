<?php

namespace Database\Seeders;

use App\Models\KartuMatch;
use Illuminate\Database\Seeder;

class KartuMatchSeeder extends Seeder
{
    /**
     * 32 kartu Musiverse Match.
     * Gambar: public/images/games/match/{nomor 2 digit}-{slug}.svg
     * Contoh: nomor 1 + slug "jembatan-ampera" => 01-jembatan-ampera.svg
     * Urutan di bawah menentukan nomor (1 sampai 32), jadi jangan diacak.
     */
    public function run(): void
    {
        $kartu = [
            ['jembatan-ampera', 'Jembatan Ampera', 'Bangunan & Tempat',
                'Jembatan raksasa di atas Sungai Musi yang menghubungkan Seberang Ilir dan Seberang Ulu. Diresmikan pada 1965 dan menjadi ikon Kota Palembang. Namanya singkatan dari Amanat Penderitaan Rakyat.'],
            ['masjid-agung', 'Masjid Agung', 'Bangunan & Tempat',
                'Masjid Agung Palembang dibangun pada masa Sultan Mahmud Badaruddin I pada abad ke-18. Arsitekturnya memadukan unsur Nusantara, Tiongkok, dan Eropa.'],
            ['benteng-kuto-besak', 'Benteng Kuto Besak', 'Bangunan & Tempat',
                'Benteng berdinding tebal di tepi Sungai Musi peninggalan Kesultanan Palembang Darussalam, selesai pada akhir abad ke-18. Kawasannya kini menjadi tempat warga berkumpul dan menikmati sungai.'],
            ['rumah-limas', 'Rumah Limas', 'Bangunan & Tempat',
                'Rumah panggung kayu khas Palembang dengan atap berbentuk limas. Lantainya berundak-undak sesuai kedudukan penghuni dan tamu.'],
            ['pagoda-pulau-kemaro', 'Pagoda Pulau Kemaro', 'Bangunan & Tempat',
                'Pagoda sembilan lantai di pulau kecil tengah Sungai Musi. Tempat ini terkenal dengan legenda cinta Tan Bun An dan Siti Fatimah, dan ramai saat Cap Go Meh.'],
            ['bukit-siguntang', 'Bukit Siguntang', 'Bangunan & Tempat',
                'Bukit yang dianggap suci pada masa Sriwijaya. Di puncaknya terdapat makam yang diyakini sebagai tempat peristirahatan raja dan bangsawan Melayu-Sriwijaya.'],
            ['perahu-ketek', 'Perahu Ketek', 'Transportasi Sungai',
                'Perahu kayu bermesin kecil yang menjadi angkutan menyeberangi Sungai Musi. Wisatawan juga memakainya untuk menyusuri sungai.'],
            ['perahu-bidar', 'Perahu Bidar', 'Transportasi Sungai',
                'Perahu panjang yang didayung banyak orang dan dilombakan di Sungai Musi. Lomba bidar antara lain digelar saat peringatan hari jadi Kota Palembang.'],
            ['pempek-kapal-selam', 'Pempek Kapal Selam', 'Kuliner',
                'Pempek berukuran besar yang berisi sebutir telur utuh di dalamnya. Disantap dengan kuah cuko yang asam, manis, dan pedas.'],
            ['pempek-lenjer', 'Pempek Lenjer', 'Kuliner',
                'Pempek berbentuk panjang seperti silinder, dibuat dari ikan dan sagu. Biasa disajikan dengan cuko, mi kuning, dan irisan mentimun.'],
            ['tekwan', 'Tekwan', 'Kuliner',
                'Sup bakso ikan berkuah kaldu udang dengan bihun dan jamur kuping, ditaburi bawang goreng. Kuliner khas Palembang yang segar dan gurih.'],
            ['model', 'Model', 'Kuliner',
                'Olahan ikan dan sagu khas Palembang yang diisi tahu dan disajikan dengan kuah. Masih bersaudara dengan pempek dan tekwan.'],
            ['mi-celor', 'Mi Celor', 'Kuliner',
                'Mi tebal dengan kuah kental berkaldu udang, ditaburi bawang goreng dan telur rebus. Biasa disantap pada pagi hari.'],
            ['pindang-patin', 'Pindang Patin', 'Kuliner',
                'Sup ikan patin berkuah bening yang segar, asam, dan pedas. Bumbunya antara lain serai, daun salam, belimbing wuluh, dan tomat.'],
            ['kue-maksuba', 'Kue Maksuba', 'Kuliner',
                'Kue lapis manis yang legit, dibuat dari telur dan susu kental manis. Hidangan istimewa untuk hajatan dan hari raya.'],
            ['kue-lapan-jam', 'Kue Lapan Jam', 'Kuliner',
                'Dibuat dari telur, mentega, dan susu kental manis, lalu dikukus sangat lama. Teksturnya lembut dan legit, dan kue ini identik dengan acara hajatan.'],
            ['laksan', 'Laksan', 'Kuliner',
                'Olahan ikan dan sagu seperti pempek yang disajikan dengan kuah santan gurih, bukan kuah cuko.'],
            ['burgo', 'Burgo', 'Kuliner',
                'Kuliner berbahan tepung beras dan tepung sagu yang digulung, lalu disajikan dengan kuah santan gurih berasa ikan.'],
            ['kerupuk-kemplang', 'Kerupuk Kemplang', 'Kuliner',
                'Kerupuk khas Palembang dari ikan dan sagu yang dipanggang atau digoreng. Salah satu oleh-oleh favorit dari Palembang.'],
            ['martabak-har', 'Martabak HAR', 'Kuliner',
                'Martabak telur bersiram kuah kari kentang. Namanya diambil dari singkatan nama pembuat pertamanya, Haji Abdul Rozak.'],
            ['bolu-kojo', 'Bolu Kojo', 'Kuliner',
                'Kue basah tradisional Palembang yang lembut dan manis. Sering hadir pada acara hajatan dan hari raya.'],
            ['kain-songket', 'Kain Songket', 'Busana & Kerajinan',
                'Kain tenun tradisional dengan benang emas atau perak. Pada masa kesultanan, songket dikenakan bangsawan dan dalam upacara adat.'],
            ['aesan-gede', 'Aesan Gede', 'Busana & Kerajinan',
                'Pakaian adat pengantin kebesaran Palembang, dipadukan dengan songket dan perhiasan emas. Melambangkan keagungan bangsawan Kesultanan Palembang Darussalam.'],
            ['tanjak', 'Tanjak', 'Busana & Kerajinan',
                'Penutup kepala pria tradisional Melayu dari kain yang dilipat. Dipakai dalam upacara adat dan pernikahan sebagai tanda kehormatan.'],
            ['kain-jumputan', 'Kain Jumputan', 'Busana & Kerajinan',
                'Kain bermotif warna-warni yang dibuat dengan teknik ikat celup: kain diikat atau dijumput sebelum dicelup pewarna, sehingga membentuk corak unik.'],
            ['kipas-tari', 'Kipas Tari', 'Seni & Adat',
                'Properti yang digerakkan penari untuk memperindah dan mempertegas gerakan dalam tarian tradisional.'],
            ['tepak-sirih', 'Tepak Sirih', 'Seni & Adat',
                'Wadah tradisional untuk menyimpan sirih dan pinang. Tepak disuguhkan kepada tamu sebagai lambang penghormatan dalam adat Melayu.'],
            ['lemari-lak', 'Lemari Lak', 'Busana & Kerajinan',
                'Perabot kayu tradisional Palembang berhias ukiran dan warna lak. Menunjukkan keterampilan pengrajin dan kemewahan rumah tradisional.'],
            ['prasasti-kedukan-bukit', 'Prasasti Kedukan Bukit', 'Sejarah',
                'Prasasti bertarikh 682 M beraksara Pallawa dan berbahasa Melayu Kuno, ditemukan pada 1920 di tepi Sungai Tatang, Palembang. Isinya menjadi bukti awal berdirinya Kerajaan Sriwijaya.'],
            ['ikan-belida', 'Ikan Belida', 'Alam',
                'Ikan air tawar berdaging pulen yang dahulu menjadi bahan utama pempek terbaik. Kini semakin langka, sehingga pempek banyak memakai ikan lain seperti tenggiri.'],
            ['tanggai', 'Tanggai', 'Seni & Adat',
                'Kuku palsu dari logam yang dipasang di jari penari Tari Tanggai, tarian penyambutan tamu. Penarinya berbusana Aesan Gede dengan gerakan yang lemah gemulai.'],
            ['keris', 'Keris', 'Seni & Adat',
                'Senjata tikam tradisional Nusantara yang juga menjadi pusaka dan pelengkap busana adat pria. UNESCO menetapkan keris sebagai Warisan Budaya Takbenda pada 2005.'],
        ];

        foreach ($kartu as $i => [$slug, $nama, $kategori, $penjelasan]) {
            KartuMatch::updateOrCreate(
                ['slug' => $slug],
                [
                    'nomor'      => $i + 1,
                    'nama'       => $nama,
                    'kategori'   => $kategori,
                    'penjelasan' => $penjelasan,
                ]
            );
        }
    }
}