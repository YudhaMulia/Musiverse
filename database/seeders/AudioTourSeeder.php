<?php

namespace Database\Seeders;

use App\Models\AudioTour;
use App\Models\CagarBudaya;
use Illuminate\Database\Seeder;

class AudioTourSeeder extends Seeder
{
    public function run(): void
    {
        AudioTour::truncate();

        $menara = CagarBudaya::where('slug', 'menara-air-palembang')->first();
        $benteng = CagarBudaya::where('slug', 'benteng-kuto-besak')->first();
        $museum = CagarBudaya::where('slug', 'museum-smb-ii')->first();
        $masjid = CagarBudaya::where('slug', 'masjid-agung-palembang')->first();
        $siguntang = CagarBudaya::where('slug', 'bukit-siguntang')->first();
        $kapitan = CagarBudaya::where('slug', 'kampung-kapitan')->first();

        if ($menara) {
            AudioTour::create([
                'cagar_budaya_id' => $menara->id,
                'title' => 'Hikayat Air Bersih Gemeente: Menara Air 1928',
                'narration' => 'Selamat datang di Menara Air Palembang. Pada tahun 1928, arsitek kenamaan Ir. Thomas Karsten merancang menara air megah setinggi 35 meter ini untuk mendistribusikan air bersih dari Sungai Musi ke seluruh penjuru kota. Mengadopsi perpaduan arsitektur Art Deco fungsionalis Eropa dengan fondasi yang kokoh menembus tanah rawa, menara ini menjadi tonggak modernisasi tata kota Palembang. Kini, bangunan bersejarah ini tetap tegak berdiri dan difungsikan sebagai Kantor Walikota Palembang.',
                'audio_file_url' => 'audio/tours/menara-air-palembang.mp3',
                'duration_seconds' => 31,
                'narrator' => 'Pemandu Budaya Palembang (Ardi)',
                'language' => 'id',
            ]);
        }

        if ($benteng) {
            AudioTour::create([
                'cagar_budaya_id' => $benteng->id,
                'title' => 'Benteng Pertahanan Kesultanan: Kuto Besak',
                'narration' => 'Selamat datang di Benteng Kuto Besak, lambang kebanggaan dan kedaulatan Palembang. Didirikan pada tahun 1780 oleh Sultan Mahmud Badaruddin I, benteng ini merupakan satu-satunya benteng di Nusantara yang dibangun mandiri oleh kesultanan pribumi berbahan batu bata putih dengan perekat kapur sirih. Menghadap langsung ke lajur strategis Sungai Musi, Kuto Besak menjadi benteng pertahanan utama kesultanan dari berbagai ancaman dan serangan masa lampau.',
                'audio_file_url' => 'audio/tours/benteng-kuto-besak.mp3',
                'duration_seconds' => 34,
                'narrator' => 'Pemandu Budaya Palembang (Gadis)',
                'language' => 'id',
            ]);
        }

        if ($museum) {
            AudioTour::create([
                'cagar_budaya_id' => $museum->id,
                'title' => 'Warisan Arsitektur Indische: Museum SMB II',
                'narration' => 'Selamat datang di Museum Sultan Mahmud Badaruddin II. Bangunan bergaya Indische Empire yang anggun ini didirikan pada tahun 1823 di atas tapak Kraton Kuto Lamo peninggalan kesultanan. Dengan tangga kayu berganda yang megah serta pilar-pilar neoklasik yang kokoh, museum ini menyimpan ratusan artefak berharga mulai dari kain songket Palembang, keris pusaka, hingga naskah kuno yang merekam kejayaan kebudayaan Palembang Darussalam.',
                'audio_file_url' => 'audio/tours/museum-smb-ii.mp3',
                'duration_seconds' => 26,
                'narrator' => 'Pemandu Budaya Palembang (Ardi)',
                'language' => 'id',
            ]);
        }

        if ($masjid) {
            AudioTour::create([
                'cagar_budaya_id' => $masjid->id,
                'title' => 'Pusat Spiritualitas Melayu: Masjid Agung Palembang',
                'narration' => 'Selamat datang di Masjid Agung Sultan Mahmud Badaruddin I Palembang. Didirikan pada tahun 1738, masjid ini merupakan saksi bisu pusat keagamaan dan kebudayaan Melayu Islam di bumi Sriwijaya. Arsitekturnya yang memukau memadukan tiga peradaban dunia: atap limas khas Nusantara, ornamen atap melengkung bergaya Tionghoa, serta pilar-pilar marmer elegan bergaya Eropa. Hingga hari ini, Masjid Agung tetap menjadi episentrum spiritual masyarakat Palembang.',
                'audio_file_url' => 'audio/tours/masjid-agung-palembang.mp3',
                'duration_seconds' => 37,
                'narrator' => 'Pemandu Budaya Palembang (Gadis)',
                'language' => 'id',
            ]);
        }

        if ($siguntang) {
            AudioTour::create([
                'cagar_budaya_id' => $siguntang->id,
                'title' => 'Puncak Sakral Sriwijaya: Bukit Siguntang',
                'narration' => 'Selamat datang di Bukit Siguntang, dataran tertinggi di Palembang purba yang diselimuti kabut sejarah ribuan tahun. Sejak abad ke-7 pada masa keemasan Kedatuan Sriwijaya, bukit ini dipercaya sebagai kompleks pemakaman para raja bangsawan Melayu dan pusat meditasi spiritual. Di kawasan sakral inilah ditemukan arca Buddha Amarawati setinggi hampir tiga meter yang membuktikan kedigdayaan peradaban maritim Sriwijaya di mata dunia.',
                'audio_file_url' => 'audio/tours/bukit-siguntang.mp3',
                'duration_seconds' => 25,
                'narrator' => 'Pemandu Budaya Palembang (Ardi)',
                'language' => 'id',
            ]);
        }

        if ($kapitan) {
            AudioTour::create([
                'cagar_budaya_id' => $kapitan->id,
                'title' => 'Jejak Multikultural Musi: Kampung Kapitan',
                'narration' => 'Selamat datang di Kampung Kapitan yang terletak di bantaran Sungai Musi. Didirikan sejak abad ke-16, kawasan cagar budaya ini menjadi saksi interaksi multikultural saudagar Tionghoa dan Kesultanan Palembang. Rumah-rumah panggung bergaya Limas berpadu harmonis dengan ornamen arsitektur Tionghoa klasik. Kampung Kapitan merefleksikan nilai luhur toleransi dan denyut nadi perdagangan maritim Palembang tempo dulu.',
                'audio_file_url' => 'audio/tours/kampung-kapitan.mp3',
                'duration_seconds' => 31,
                'narrator' => 'Pemandu Budaya Palembang (Gadis)',
                'language' => 'id',
            ]);
        }
    }
}
