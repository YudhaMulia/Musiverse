<?php

namespace Database\Seeders;

use App\Models\CagarBudaya;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        $cagarBudayas = CagarBudaya::all();
        if ($cagarBudayas->isEmpty()) {
            return;
        }

        $sampleReviews = [
            'benteng-kuto-besak' => [
                [
                    'rating' => 5,
                    'content' => 'Pemandangan sore di Benteng Kuto Besak sangat memukau dengan latar belakang Sungai Musi dan Jembatan Ampera. Angin sepoi-sepoi dan gemerlap lampu malam hari membuat suasana bersejarah semakin terasa hidup.',
                ],
                [
                    'rating' => 5,
                    'content' => 'Salah satu situs pertahanan bersejarah Kesultanan Palembang yang luar biasa. Sangat direkomendasikan datang bersama keluarga saat matahari terbenam.',
                ],
                [
                    'rating' => 4,
                    'content' => 'Tempat yang kaya akan sejarah dan sangat strategis. Informasi papan cagar budaya sudah cukup informatif, hanya perlu penataan area pejalan kaki yang lebih rapi.',
                ],
            ],
            'museum-smb-ii' => [
                [
                    'rating' => 5,
                    'content' => 'Koleksi artefak kesultanan dan masa kolonial sangat lengkap. Audio tour di aplikasi ini sangat membantu saya memahami sejarah Sultan Mahmud Badaruddin II secara mendalam!',
                ],
                [
                    'rating' => 4,
                    'content' => 'Arsitektur bangunan bergaya kolonial tropis dengan atap limas yang khas. Sangat terawat dan pemandu di museum sangat ramah.',
                ],
            ],
            'menara-air-palembang' => [
                [
                    'rating' => 4,
                    'content' => 'Simbol ikonik perkembangan arsitektur modern awal abad ke-20 di Palembang. Bangunan masih kokoh berdiri dan kini menjadi kantor walikota. Sangat bersejarah!',
                ],
            ],
            'masjid-agung-palembang' => [
                [
                    'rating' => 5,
                    'content' => 'Arsitektur perpaduan budaya Melayu, Tionghoa, dan Eropa yang sangat megah. Suasana ibadah sangat khusyuk dan sejuk di tengah pusat kota Palembang.',
                ],
            ],
            'bukit-siguntang' => [
                [
                    'rating' => 5,
                    'content' => 'Tempat yang sarat akan sejarah Kerajaan Sriwijaya. Suasana asri dinaungi pepohonan rindang di puncak bukit, sangat damai dan menenangkan.',
                ],
            ],
            'kampung-kapitan' => [
                [
                    'rating' => 4,
                    'content' => 'Rumah perwira Tionghoa masa kolonial di tepi Sungai Musi. Ornamen kayu dan ukirannya sangat detail dan unik, warisan multikultural Palembang.',
                ],
            ],
        ];

        foreach ($sampleReviews as $slug => $reviews) {
            $cagar = $cagarBudayas->firstWhere('slug', $slug);
            if (! $cagar) {
                continue;
            }

            foreach ($reviews as $idx => $data) {
                $user = $users[$idx % $users->count()];

                // Hanya buat review jika user belum pernah mengulas tempat ini
                $exists = Review::where('user_id', $user->id)
                    ->where('cagar_budaya_id', $cagar->id)
                    ->exists();

                if (! $exists) {
                    Review::create([
                        'user_id' => $user->id,
                        'cagar_budaya_id' => $cagar->id,
                        'rating' => $data['rating'],
                        'content' => $data['content'],
                        'created_at' => now()->subDays(rand(1, 14)),
                        'updated_at' => now()->subDays(rand(0, 1)),
                    ]);
                }
            }
        }
    }
}
