<?php

namespace Database\Seeders;

use App\Models\KuisQuestion;
use Illuminate\Database\Seeder;

class KuisQuestionSeeder extends Seeder
{
    /**
     * Isi tabel kuis_questions dengan 45 soal budaya Palembang.
     * Format tiap baris:
     * [pertanyaan, opsi A, opsi B, opsi C, opsi D, jawaban benar (a/b/c/d), penjelasan, kategori]
     */
    public function run(): void
    {
        // Kosongkan dulu supaya kalau seeder dijalankan dua kali, soal tidak dobel.
        KuisQuestion::truncate();

        $soal = [
            // ───────── KULINER ─────────
            ['Makanan khas Palembang yang dibuat dari ikan giling dan tepung sagu adalah...', 'Tekwan', 'Siomay', 'Otak-otak', 'Pempek', 'd', 'Pempek terbuat dari daging ikan giling yang dicampur tepung sagu.', 'Kuliner'],
            ['Kuah hitam kecokelatan yang rasanya asam, manis, dan pedas untuk menyantap pempek disebut...', 'Sambal terasi', 'Cuko', 'Kinca', 'Saus kacang', 'b', 'Cuko (cuka) dibuat dari gula merah, cabai, bawang putih, dan asam.', 'Kuliner'],
            ['Pempek yang berisi telur ayam utuh dikenal dengan nama...', 'Pempek lenjer', 'Pempek adaan', 'Pempek kapal selam', 'Pempek kulit', 'c', 'Pempek kapal selam berisi sebutir telur ayam di dalamnya.', 'Kuliner'],
            ['Masakan Palembang berkuah asam pedas dengan bahan ikan patin disebut...', 'Rawon', 'Soto', 'Gulai', 'Pindang', 'd', 'Pindang patin adalah hidangan berkuah segar khas Palembang.', 'Kuliner'],
            ['Hidangan berkuah bening dengan bola-bola ikan, udang, jamur kuping, dan bengkoang adalah...', 'Burgo', 'Laksan', 'Tekwan', 'Bakso ikan', 'c', 'Tekwan disajikan dengan kuah kaldu udang yang segar.', 'Kuliner'],
            ['Kue lapis khas Palembang dari telur dan susu kental yang sering hadir di hari raya bernama...', 'Bika ambon', 'Lapis legit', 'Maksuba', 'Spekoek', 'c', 'Maksuba dibuat berlapis-lapis dan sering disajikan saat hajatan.', 'Kuliner'],
            ['Mi dengan kuah santan, udang kering, dan telur rebus khas Palembang bernama...', 'Mi aceh', 'Mi kocok', 'Mi ayam', 'Mi celor', 'd', 'Mi celor disajikan dengan kuah santan yang gurih.', 'Kuliner'],
            ['Kerupuk ikan khas Palembang yang dipanggang dan bertekstur renyah disebut...', 'Kemplang', 'Emping', 'Rengginang', 'Kerupuk udang', 'a', 'Kemplang terbuat dari ikan dan sagu, lalu dipanggang atau digoreng.', 'Kuliner'],
            ['Burgo adalah makanan khas Palembang yang disajikan dengan...', 'Kuah kacang', 'Kuah soto', 'Saus tomat', 'Kuah santan ikan', 'd', 'Burgo berupa gulungan tipis dari tepung beras dan sagu dengan kuah santan ikan.', 'Kuliner'],

            // ───────── SEJARAH ─────────
            ['Kerajaan besar bercorak Buddha yang berpusat di Palembang adalah...', 'Sriwijaya', 'Majapahit', 'Mataram', 'Samudra Pasai', 'a', 'Sriwijaya adalah kerajaan maritim yang berjaya pada abad ke-7 sampai ke-13.', 'Sejarah'],
            ['Prasasti Kedukan Bukit yang menyebut Sriwijaya berangka tahun...', '683 M', '1025 M', '1293 M', '1511 M', 'a', 'Prasasti ini bertarikh 683 M dan sering dikaitkan dengan hari jadi kota Palembang.', 'Sejarah'],
            ['Prasasti Kedukan Bukit ditulis dalam bahasa...', 'Sanskerta Baru', 'Jawa Kuno', 'Melayu Kuno', 'Arab Melayu', 'c', 'Prasasti ini berbahasa Melayu Kuno dan beraksara Pallawa.', 'Sejarah'],
            ['Hari jadi Kota Palembang diperingati setiap tanggal...', '17 Juni', '17 Agustus', '1 Januari', '28 Oktober', 'a', 'Hari jadi Kota Palembang diperingati setiap 17 Juni, merujuk tahun 683 M.', 'Sejarah'],
            ['Benteng Kuto Besak dibangun pada masa pemerintahan...', 'Sultan Mahmud Badaruddin I', 'Sultan Agung', 'Sultan Hasanuddin', 'Raden Fatah', 'a', 'Pembangunannya dimulai oleh Sultan Mahmud Badaruddin I pada abad ke-18.', 'Sejarah'],
            ['Sultan Mahmud Badaruddin II diasingkan oleh Belanda ke...', 'Ternate', 'Ambon', 'Banda', 'Digul', 'a', 'Beliau diasingkan ke Ternate dan wafat di sana pada 1852.', 'Sejarah'],
            ['Kesultanan Islam yang berpusat di Palembang bernama...', 'Kesultanan Deli', 'Kesultanan Siak', 'Kesultanan Palembang Darussalam', 'Kesultanan Banten', 'c', 'Kesultanan Palembang Darussalam berdiri pada abad ke-17.', 'Sejarah'],
            ['Perang Menteng tahun 1819 adalah perlawanan rakyat Palembang melawan...', 'Portugis', 'Jepang', 'Inggris', 'Belanda', 'd', 'Pasukan Palembang berhasil menahan serangan Belanda pada Perang Menteng 1819.', 'Sejarah'],
            ['Museum Negeri Sumatera Selatan di Palembang diberi nama...', 'Museum Balaputra Dewa', 'Museum Fatahillah', 'Museum Mulawarman', 'Museum Sangiran', 'a', 'Balaputradewa adalah salah satu raja Sriwijaya yang terkenal.', 'Sejarah'],
            ['Julukan Palembang sebagai pusat kerajaan masa lalu adalah...', 'Kota Kembang', 'Bumi Sriwijaya', 'Kota Gudeg', 'Kota Hujan', 'b', 'Palembang dijuluki Bumi Sriwijaya karena pernah menjadi pusat kerajaan itu.', 'Sejarah'],

            // ───────── PAKAIAN & TEKSTIL ─────────
            ['Kain tenun Palembang dengan benang emas yang mewah bernama...', 'Songket', 'Batik tulis', 'Ulos', 'Tenun ikat Sumba', 'a', 'Songket Palembang ditenun dengan benang emas dan dikenal sebagai kain kebesaran.', 'Pakaian & Tekstil'],
            ['Kain khas Palembang yang dibuat dengan teknik ikat dan celup warna disebut...', 'Lurik', 'Jumputan', 'Sasirangan', 'Endek', 'b', 'Jumputan dibuat dengan menjumput atau mengikat kain sebelum dicelup.', 'Pakaian & Tekstil'],
            ['Pakaian pengantin adat Palembang yang megah dengan dominasi warna merah dan emas bernama...', 'Baju bodo', 'Kebaya encim', 'Ulee balang', 'Aesan Gede', 'd', 'Aesan Gede dipakai pengantin dan melambangkan kebesaran bangsawan Palembang.', 'Pakaian & Tekstil'],
            ['Motif songket Palembang yang menggambarkan dua naga bernama...', 'Pucuk rebung', 'Nago Besaung', 'Bunga melati', 'Tumpal', 'b', 'Nago Besaung adalah salah satu motif songket Palembang yang terkenal.', 'Pakaian & Tekstil'],
            ['Warna emas pada kain dan ukiran Palembang diperoleh dari teknik...', 'Batik cap', 'Sulam', 'Prada', 'Lukis kaca', 'c', 'Prada adalah teknik pewarnaan atau penempelan lapisan emas pada kain atau kayu.', 'Pakaian & Tekstil'],
            ['Warna yang paling identik dengan kemewahan songket Palembang adalah...', 'Hijau muda', 'Biru langit', 'Merah marun dan emas', 'Abu-abu', 'c', 'Merah marun dipadukan benang emas menjadi ciri khas songket Palembang.', 'Pakaian & Tekstil'],

            // ───────── SENI & TARI ─────────
            ['Tarian untuk menyambut tamu agung di Palembang yang diiringi lagu dengan nama sama adalah...', 'Tari Kecak', 'Tari Gending Sriwijaya', 'Tari Saman', 'Tari Piring', 'b', 'Tari Gending Sriwijaya menggambarkan keramahan masyarakat menyambut tamu.', 'Seni & Tari'],
            ['Tari Tanggai terkenal dengan hiasan di jari penarinya yang disebut...', 'Cincin kawin', 'Selendang', 'Gelang kaki', 'Tanggai', 'd', 'Tanggai adalah kuku panjang berbahan logam yang dipasang di jari penari.', 'Seni & Tari'],
            ['Lagu daerah yang berasal dari Sumatera Selatan adalah...', 'Ampar-Ampar Pisang', 'Cuk Mak Ilang', 'Rasa Sayange', 'Bungong Jeumpa', 'b', 'Cuk Mak Ilang adalah lagu daerah dari Sumatera Selatan.', 'Seni & Tari'],
            ['Gending Sriwijaya dikenal sebagai...', 'Alat musik tiup', 'Senjata tradisional', 'Lagu dan tarian penyambutan', 'Upacara panen', 'c', 'Gending Sriwijaya berupa lagu sekaligus tarian untuk menyambut tamu kehormatan.', 'Seni & Tari'],
            ['Ukiran kayu khas Palembang biasanya berwarna...', 'Biru tua', 'Hitam polos', 'Putih', 'Emas', 'd', 'Ukiran Palembang sering disepuh warna emas dengan motif flora.', 'Seni & Tari'],

            // ───────── ARSITEKTUR & IKON KOTA ─────────
            ['Rumah adat Palembang dengan atap berbentuk limas dan lantai bertingkat disebut...', 'Rumah Limas', 'Rumah Gadang', 'Rumah Joglo', 'Rumah Panjang', 'a', 'Rumah Limas memiliki lantai bertingkat yang menunjukkan kedudukan penghuninya.', 'Arsitektur'],
            ['Rumah terapung dari bambu yang berada di atas Sungai Musi disebut...', 'Rumah Panggung', 'Rumah Gadang', 'Rumah Rakit', 'Rumah Betang', 'c', 'Rumah Rakit mengapung di atas air mengikuti pasang surut Sungai Musi.', 'Arsitektur'],
            ['Jembatan ikon Kota Palembang yang melintasi Sungai Musi bernama...', 'Jembatan Suramadu', 'Jembatan Barelang', 'Jembatan Kapuas', 'Jembatan Ampera', 'd', 'Jembatan Ampera menghubungkan kawasan Seberang Ulu dan Seberang Ilir.', 'Arsitektur'],
            ['Nama awal Jembatan Ampera ketika dibangun adalah...', 'Jembatan Musi', 'Jembatan Bung Karno', 'Jembatan Sriwijaya', 'Jembatan Merdeka', 'b', 'Jembatan ini awalnya bernama Jembatan Bung Karno, lalu berganti menjadi Ampera.', 'Arsitektur'],
            ['Sungai terbesar yang membelah Kota Palembang adalah...', 'Sungai Kapuas', 'Sungai Mahakam', 'Sungai Musi', 'Sungai Barito', 'c', 'Sungai Musi menjadi urat nadi kehidupan dan perdagangan Palembang.', 'Arsitektur'],
            ['Julukan Palembang yang menggambarkan banyaknya sungai dan perairan adalah...', 'Kota Seribu Candi', 'Venesia dari Timur', 'Kota Pelajar', 'Kota Baja', 'b', 'Palembang dijuluki Venesia dari Timur karena banyak sungai dan kanal.', 'Arsitektur'],

            // ───────── BAHASA ─────────
            ['Dalam bahasa Palembang, kata "galo" berarti...', 'Semua', 'Sedikit', 'Besok', 'Kemarin', 'a', '"Galo" berarti semua, seperti dalam ungkapan "kito galo".', 'Bahasa'],
            ['Kata "cak mano" dalam bahasa Palembang artinya...', 'Siapa', 'Di mana', 'Kapan', 'Bagaimana', 'd', '"Cak mano" artinya bagaimana.', 'Bahasa'],
            ['Kata "nian" pada kalimat "Enak nian!" berarti...', 'Sedikit', 'Sekali', 'Mungkin', 'Hampir', 'b', '"Nian" berarti sekali atau sangat.', 'Bahasa'],
            ['Kata "dak" dalam bahasa Palembang artinya...', 'Ya', 'Mau', 'Bisa', 'Tidak', 'd', '"Dak" atau "idak" berarti tidak.', 'Bahasa'],
            ['"Dak pacak" dalam bahasa Palembang berarti...', 'Tidak mau', 'Tidak tahu', 'Tidak bisa', 'Tidak ada', 'c', '"Pacak" artinya bisa, sehingga "dak pacak" berarti tidak bisa.', 'Bahasa'],

            // ───────── TRADISI & LEGENDA ─────────
            ['Lomba perahu panjang tahunan di Sungai Musi bernama...', 'Pacu Jalur', 'Dragon Boat Bali', 'Festival Bidar', 'Lomba Jukung', 'c', 'Festival Bidar digelar di Sungai Musi, biasanya di sekitar Hari Kemerdekaan dan HUT Kota.', 'Tradisi'],
            ['Legenda cinta Tan Bun An dan Siti Fatimah berkaitan dengan...', 'Pulau Kemaro', 'Bukit Siguntang', 'Benteng Kuto Besak', 'Pasar 16 Ilir', 'a', 'Pulau Kemaro di Sungai Musi memiliki pagoda dan klenteng yang terkait legenda ini.', 'Tradisi'],
            ['Bukit Siguntang di Palembang dikenal sebagai...', 'Pusat perdagangan modern', 'Pelabuhan utama', 'Pasar tradisional', 'Situs sakral tempat peristirahatan para raja', 'd', 'Bukit Siguntang dianggap suci dan dikaitkan dengan raja-raja Melayu dan Sriwijaya.', 'Tradisi'],
            ['Masjid Agung Palembang dibangun pada masa pemerintahan...', 'Sultan Iskandar Muda', 'Sultan Mahmud Badaruddin I', 'Sultan Syarif Kasim', 'Raja Ali Haji', 'b', 'Masjid ini dibangun pada awal abad ke-18 oleh Sultan Mahmud Badaruddin I.', 'Tradisi'],
        ];

        foreach ($soal as [$tanya, $a, $b, $c, $d, $benar, $penjelasan, $kategori]) {
            KuisQuestion::create([
                'pertanyaan'    => $tanya,
                'opsi_a'        => $a,
                'opsi_b'        => $b,
                'opsi_c'        => $c,
                'opsi_d'        => $d,
                'jawaban_benar' => $benar,
                'penjelasan'    => $penjelasan,
                'kategori'      => $kategori,
            ]);
        }
    }
}