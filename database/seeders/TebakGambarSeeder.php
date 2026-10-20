<?php

namespace Database\Seeders;

use App\Models\TebakGambar;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TebakGambarSeeder extends Seeder
{
    public function run(): void
    {
        // Penjelasan singkat tiap gambar.
        // Kunci = nama file TANPA ekstensi (.jpg/.webp/dll), persis seperti di folder.
        $penjelasan = [
            '01-aesan-gede' => 'Aesan Gede adalah pakaian adat pengantin kebesaran Palembang, dipadukan dengan songket dan perhiasan emas. Busana ini melambangkan keagungan bangsawan Kesultanan Palembang Darussalam.',
            '02-belida' => 'Belida adalah ikan air tawar berdaging pulen yang dahulu menjadi bahan utama pempek terbaik. Kini ikan ini semakin langka, sehingga pempek banyak memakai ikan lain seperti tenggiri.',
            '03-bolu-kojo' => 'Bolu kojo adalah kue basah tradisional Palembang yang lembut dan manis. Kue ini sering hadir pada acara hajatan dan hari raya.',
            '04-burgo' => 'Burgo adalah kuliner khas Palembang berbahan tepung beras dan tepung sagu, disajikan dengan kuah santan gurih. Burgo telah ditetapkan sebagai Warisan Budaya Tak Benda Indonesia pada 2021.',
            '05-cuko' => 'Cuko adalah kuah pendamping pempek yang berasa asam, manis, dan pedas. Bahannya antara lain gula merah, cabai, dan bawang putih.',
            '06-engkak-ketan' => 'Engkak ketan adalah kue manis tradisional dari ketan dan santan dengan tekstur legit dan kenyal. Kue ini biasa disajikan saat hajatan dan hari raya.',
            '07-ikan-sepat-rawa' => 'Ikan sepat rawa adalah ikan air tawar yang hidup di rawa-rawa Sumatera Selatan. Ikan ini biasa digoreng atau dikeringkan menjadi ikan asin.',
            '08-jembatan-ampera' => 'Jembatan Ampera membentang di atas Sungai Musi dan menghubungkan Seberang Ilir dengan Seberang Ulu. Jembatan ini menjadi ikon Kota Palembang dan diresmikan pada 1965.',
            '09-kain-songket' => 'Songket Palembang adalah kain tenun tradisional dengan benang emas atau perak. Pada masa kesultanan, kain ini dikenakan oleh bangsawan dan dalam upacara adat.',
            '10-kampung-kapitan' => 'Kampung Kapitan adalah kawasan permukiman Tionghoa bersejarah di tepi Sungai Musi. Kapitan adalah pemimpin komunitas Tionghoa pada masa pemerintahan kolonial Belanda.',
            '11-kemaro' => 'Pulau Kemaro adalah pulau kecil di tengah Sungai Musi yang terkenal dengan pagoda sembilan lantai dan kelenteng. Pulau ini punya legenda cinta Tan Bun An dan Siti Fatimah, dan ramai saat Cap Go Meh.',
            '12-kemplang' => 'Kemplang adalah kerupuk khas Palembang dari ikan dan sagu yang dipanggang atau digoreng. Kemplang menjadi salah satu oleh-oleh favorit dari Palembang.',
            '13-kue-delapan-jam' => 'Kue delapan jam dibuat dari telur, mentega, dan susu kental manis, lalu dikukus sangat lama. Teksturnya lembut dan legit, dan kue ini identik dengan acara hajatan.',
            '14-lenggang' => 'Lenggang adalah hidangan Palembang dari adonan ikan dan telur yang digoreng seperti omelet, lalu disajikan dengan cuko. Hidangan ini juga dikenal sebagai pempek lenggang.',
            '15-masjid-agung' => 'Masjid Agung Palembang dibangun pada masa Sultan Mahmud Badaruddin I pada abad ke-18. Arsitekturnya memadukan unsur Nusantara, Tiongkok, dan Eropa.',
            '16-mie-celor' => 'Mie celor adalah mi tebal dengan kuah kental berkaldu udang, ditaburi bawang goreng dan telur rebus. Hidangan ini biasa disantap pada pagi hari.',
            '17-model' => 'Model adalah olahan ikan dan sagu khas Palembang yang diisi tahu dan disajikan dengan kuah. Hidangan ini masih bersaudara dengan pempek dan tekwan.',
            '18-musi-rawas' => 'Musi Rawas adalah sebuah kabupaten di Sumatera Selatan. Namanya diambil dari dua sungai besar di wilayah itu, yaitu Sungai Musi dan Sungai Rawas.',
            '19-nasi-minyak-kambing' => 'Nasi minyak adalah nasi gurih beraroma rempah dengan pengaruh budaya Arab. Hidangan ini disajikan pada hajatan dan penyambutan tamu, lengkap dengan lauk seperti kari kambing.',
            '20-patin' => 'Patin adalah ikan air tawar khas sungai-sungai Sumatera. Dagingnya empuk dan gurih, dan paling terkenal diolah menjadi pindang patin.',
            '21-pempek-kapal-selam' => 'Pempek kapal selam adalah pempek besar yang berisi sebutir telur utuh di dalamnya. Pempek ini disantap dengan kuah cuko.',
            '22-pempek-lenjer' => 'Pempek lenjer adalah pempek berbentuk panjang seperti silinder. Pempek ini disajikan dengan cuko, mi kuning, dan irisan mentimun.',
            '23-perahu-bidar' => 'Perahu bidar adalah perahu panjang yang didayung banyak orang dan dilombakan di Sungai Musi. Lomba bidar antara lain digelar saat peringatan hari jadi Kota Palembang.',
            '24-perahu-ketek' => 'Perahu ketek adalah perahu kayu bermesin kecil yang menjadi angkutan menyeberangi Sungai Musi. Perahu ini juga dipakai wisatawan untuk menyusuri sungai.',
            '25-pindang' => 'Pindang adalah sup ikan khas Palembang berkuah kuning yang segar, asam, dan pedas. Kuahnya diracik dari serai, daun salam, belimbing wuluh, dan tomat.',
            '26-punti-kayu' => 'Punti Kayu adalah taman wisata alam berhutan pinus di tengah Kota Palembang. Dalam bahasa Komering, punti kayu berarti pohon pepaya.',
            '27-rumah-bari' => 'Rumah Bari adalah rumah tradisional Palembang berarsitektur kayu yang berusia sangat tua. Kata bari berarti lama atau kuno.',
            '28-rumah-limas' => 'Rumah Limas adalah rumah panggung kayu khas Palembang dengan atap berbentuk limas. Lantainya berundak-undak sesuai tingkat kedudukan penghuni dan tamu.',
            '29-rumah-rakit' => 'Rumah rakit adalah rumah yang mengapung di atas rakit di tepian Sungai Musi. Rumah ini mencerminkan kehidupan masyarakat Palembang yang erat dengan sungai.',
            '30-siguntang' => 'Bukit Siguntang adalah bukit yang dianggap suci pada masa Sriwijaya. Di puncaknya terdapat makam yang diyakini sebagai tempat peristirahatan raja dan bangsawan Melayu-Sriwijaya.',
            '31-sungai-musi' => 'Sungai Musi membelah Kota Palembang menjadi Seberang Ilir dan Seberang Ulu. Sungai ini sejak masa Sriwijaya menjadi jalur utama perdagangan dan transportasi.',
            '32-tari-tanggai' => 'Tari Tanggai adalah tarian penyambutan tamu dengan penari memakai tanggai, yaitu kuku palsu dari logam di jari. Penarinya berbusana Aesan Gede dan gerakannya lemah lembut.',
            '33-tari-tepak-keraton' => 'Tari Tepak Keraton adalah tarian penyambutan tamu kehormatan dengan membawa tepak, wadah sirih. Tarian ini menggambarkan penghormatan khas keraton Palembang.',
            '34-tekwan' => 'Tekwan adalah sup bakso ikan berkuah kaldu udang dengan bihun dan jamur kuping. Hidangan ini ditaburi bawang goreng dan menjadi kuliner khas Palembang.',
            '35-tepak-sirih' => 'Tepak sirih adalah wadah tradisional untuk menyimpan sirih dan pinang. Tepak disuguhkan kepada tamu sebagai lambang penghormatan dalam adat Melayu.',
        ];

        $ekstensi = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'avif'];

        foreach (File::files(public_path('images/games/tebak-gambar')) as $file) {
            if (! in_array(strtolower($file->getExtension()), $ekstensi)) {
                continue;
            }

            $nama = $file->getFilenameWithoutExtension();
            $kata = preg_replace('/^\d+[-_ .]+/', '', $nama);    // buang nomor urut di depan
            $kata = trim(preg_replace('/[-_]+/', ' ', $kata));   // strip jadi spasi

            TebakGambar::updateOrCreate(
                ['gambar' => $file->getFilename()],
                [
                    'jawaban'    => Str::title($kata),
                    'penjelasan' => $penjelasan[$nama] ?? null,
                ]
            );
        }
        
        // Hapus soal lama yang file gambarnya sudah tidak ada (misalnya sebelum diganti .webp)
        TebakGambar::all()->each(function ($t) {
            if (! File::exists(public_path('images/games/tebak-gambar/' . $t->gambar))) {
                $t->delete();
            }
        });
    }
}