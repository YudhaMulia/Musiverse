<?php

namespace Database\Seeders;

use App\Models\MuseumItem;
use Illuminate\Database\Seeder;

class MuseumItemSeeder extends Seeder
{
    /**
     * Data contoh Galeri Budaya.
     * Foto masih contoh (acak dari picsum.photos), nanti diganti foto asli.
     * Format: [slug, nama, kategori, asal daerah, deskripsi singkat, unggulan?]
     */
    public function run(): void
    {
                $data = [
            // ---------- Permainan Tradisional ----------
            ['egrang', 'Egrang', 'permainan', 'Sumatera Selatan',
                'Permainan berjalan di atas dua batang bambu yang punya pijakan kaki. Melatih keseimbangan dan keberanian, dan sering dilombakan pada perayaan kemerdekaan.', false],
            ['cak-engkle', 'Cak Engkle', 'permainan', 'Palembang',
                'Nama Palembang untuk engklek, yaitu melompat dengan satu kaki di petak-petak yang digambar di tanah sambil mendorong gacuk dengan ujung kaki.', false],
            ['cuki', 'Cuki', 'permainan', 'Palembang',
                'Permainan papan dari Kesultanan Palembang Darussalam. Namanya dari kata "di-cuk-i" yang berarti diambil, dan papannya mirip permainan igo atau baduk. Butuh ketelitian dan strategi.', false],
            ['gudang-kero', 'Gudang Kero', 'permainan', 'Sumatera Selatan',
                'Salah satu dari 17 permainan tradisional masyarakat Melayu Sumatera Selatan yang tercatat dalam penelitian UIN Raden Fatah Palembang. Permainan seperti ini menanamkan kejujuran, sportivitas, dan kerja sama.', false],
            ['bentengan', 'Bentengan', 'permainan', 'Sumatera Selatan',
                'Permainan dua regu yang masing-masing menjaga bentengnya dan berusaha menyentuh atau menangkap lawan. Melatih kekompakan, strategi, dan kelincahan.', false],

            // ---------- Kuliner ----------
            ['pempek', 'Pempek', 'kuliner', 'Palembang',
                'Makanan ikon Palembang dari ikan giling dan sagu, disajikan dengan kuah cuko yang asam, manis, dan pedas. Ada banyak ragamnya, seperti kapal selam, lenjer, dan adaan.', true],
            ['tekwan', 'Tekwan', 'kuliner', 'Palembang',
                'Sup bola ikan kecil-kecil berkuah kaldu udang yang gurih, ditambah bengkuang, jamur, dan bihun.', false],
            ['mi-celor', 'Mi Celor', 'kuliner', 'Palembang',
                'Mi kuning tebal dengan kuah santan dan kaldu udang yang kental, disajikan bersama telur rebus dan taburan bawang goreng.', false],
            ['kue-maksuba', 'Kue Maksuba', 'kuliner', 'Palembang',
                'Kue lapis manis dari telur, susu, dan mentega. Sering dihidangkan pada acara adat dan hari raya.', false],
            ['model', 'Model', 'kuliner', 'Palembang',
                'Tahu isi adonan ikan tenggiri yang disiram kuah kaldu udang. Mirip tekwan, tetapi ukurannya lebih besar dan berisi tahu.', false],
            ['laksan', 'Laksan', 'kuliner', 'Palembang',
                'Pempek lenjer yang disajikan dengan kuah santan kental berbumbu bawang putih, ketumbar, dan kunyit.', false],
            ['celimpungan', 'Celimpungan', 'kuliner', 'Palembang',
                'Pempek berbentuk bulat yang lebih besar, disajikan dengan kuah santan kuning. Biasa dihidangkan saat Lebaran.', false],
            ['burgo', 'Burgo', 'kuliner', 'Palembang',
                'Hidangan mirip kwetiau yang disajikan dengan kuah santan gurih. Cocok disantap pada pagi hari.', false],
            ['pindang-patin', 'Pindang Patin', 'kuliner', 'Palembang',
                'Ikan patin yang dimasak menjadi pindang berkuah gurih, pedas, dan asam yang segar.', false],

            // ---------- Pakaian Adat ----------
            ['aesan-gede', 'Aesan Gede', 'pakaian', 'Palembang',
                'Pakaian adat pengantin kebesaran Palembang dengan warna merah dan emas. Dikenakan pada upacara pernikahan adat bersama mahkota dan perhiasan yang megah.', false],
            ['aesan-paksangko', 'Aesan Paksangko', 'pakaian', 'Palembang',
                'Pakaian pengantin adat Palembang lainnya. Ciri khasnya adalah mahkota bersusun yang disebut paksangko dan kain songket.', false],
            ['tanjak', 'Tanjak', 'pakaian', 'Sumatera Selatan',
                'Penutup kepala dari kain songket yang dilipat dengan bentuk tertentu. Dikenakan laki-laki pada acara adat.', false],
            ['dodot', 'Dodot', 'pakaian', 'Palembang',
                'Bagian atas busana pengantin Palembang dengan motif tumpal zigzag di sisi kanan dan kiri. Melambangkan pengantin yang berbudi luhur, ramah, dan saling menghormati.', false],
            ['baju-kurung', 'Baju Kurung', 'pakaian', 'Palembang',
                'Busana longgar dan tertutup dari pengaruh budaya Melayu-Islam. Pada pengantin Palembang berupa baju kurung merah bertabur motif bunga emas.', false],

            // ---------- Kain Tradisional ----------
            ['songket-palembang', 'Songket Palembang', 'kain', 'Palembang',
                'Kain tenun berbenang emas dan perak yang dikenal sebagai salah satu kain terbaik Nusantara. Dibuat dengan tangan, satu kain bisa memakan waktu berminggu-minggu.', true],
            ['kain-jumputan', 'Kain Jumputan', 'kain', 'Palembang',
                'Kain dengan motif warna-warni yang dibuat dengan teknik ikat dan celup, sehingga tiap lembar punya pola yang berbeda.', false],
            ['songket-lepus', 'Songket Lepus', 'kain', 'Palembang',
                'Salah satu ragam songket Palembang yang motif emasnya memenuhi hampir seluruh permukaan kain, sehingga tampak sangat mewah.', false],
            ['songket-tawur', 'Songket Tawur', 'kain', 'Palembang',
                'Songket Palembang yang benang emasnya tersebar di permukaan kain, berbeda dengan songket lepus yang emasnya penuh. Disebut juga songket berbatur.', false],
            ['tenun-tajung', 'Tenun Tajung', 'kain', 'Palembang',
                'Tenun tanpa benang emas yang dipakai laki-laki sebagai sarung. Ragam motifnya antara lain limar, limar patut, petak-petak, dan gerbik.', false],
            ['tenun-blongsong', 'Tenun Blongsong', 'kain', 'Palembang',
                'Kain tenun untuk perempuan dengan proses pembuatan yang mirip tenun tajung. Masyarakat Palembang menyebut kain-kain seperti ini sewet.', false],

            // ---------- Seni dan Tari ----------
            ['tari-gending-sriwijaya', 'Tari Gending Sriwijaya', 'seni-tari', 'Palembang',
                'Tari penyambutan tamu kehormatan yang anggun, dibawakan dengan pakaian adat Aesan Gede dan iringan lagu Gending Sriwijaya.', true],
            ['tari-tepak-keraton', 'Tari Tepak Keraton', 'seni-tari', 'Palembang',
                'Tari sambut Palembang bercorak Islami dengan ragam gerak berunsur pencak silat. Diciptakan oleh Anna Kumari.', false],
            ['dul-muluk', 'Dul Muluk', 'seni-tari', 'Palembang',
                'Seni teater tradisional Palembang yang menggabungkan cerita, nyanyian, dan lawakan, biasanya dipentaskan pada malam hari.', false],
            ['tari-tanggai', 'Tari Tanggai', 'seni-tari', 'Palembang',
                'Tari penyambutan Palembang dengan penari berkuku panjang (tanggai) dan hiasan kepala khas. Biasa tampil di awal acara pernikahan dan penyambutan tamu.', false],
            ['tari-pagar-pengantin', 'Tari Pagar Pengantin', 'seni-tari', 'Palembang',
                'Tari khas Palembang yang dibawakan empat penari sebagai perpisahan pengantin perempuan dengan keluarga lamanya.', false],
            ['gambus-palembang', 'Musik Gambus Palembang', 'seni-tari', 'Palembang',
                'Musik perpaduan budaya Timur Tengah dan Melayu yang dilestarikan masyarakat keturunan Arab di Palembang. Memadukan gaya gambus klasik, Melayu, dan modern.', false],

            // ---------- Cerita Rakyat ----------
            ['legenda-pulau-kemaro', 'Legenda Pulau Kemaro', 'cerita', 'Palembang',
                'Kisah cinta Tan Bun An dan Siti Fatimah yang berakhir di sebuah pulau kecil di tengah Sungai Musi. Pulau itu kini dikenal sebagai Pulau Kemaro.', false],
            ['si-pahit-lidah', 'Si Pahit Lidah', 'cerita', 'Sumatera Selatan',
                'Cerita tentang seorang sakti yang ucapannya bisa mengubah apa pun menjadi batu. Kisahnya diwariskan turun-temurun dan dikenal luas di Sumatera Selatan.', false],
            ['legenda-bukit-siguntang', 'Legenda Bukit Siguntang', 'cerita', 'Palembang',
                'Bukit yang sejak lama dianggap suci dan dikaitkan dengan para raja pada masa Sriwijaya.', false],
            ['putri-dayang-merindu', 'Putri Dayang Merindu', 'cerita', 'Palembang',
                'Putri jelita yang diperebutkan dua pria lewat lomba perahu bidar di Sungai Musi. Dikenang sebagai asal-usul tradisi lomba Bidar, dan di Ogan Komering Ulu dikaitkan dengan Goa Putri di Padang Bindu.', false],
            ['ratu-bagus-kuning', 'Ratu Bagus Kuning', 'cerita', 'Palembang',
                'Tokoh perempuan sakti yang dalam legenda mengalahkan para pendekar dan siluman kera, lalu memimpin wilayahnya. Makamnya dipercaya berada di Plaju, Palembang.', false],
            ['putri-kembang-dadar', 'Putri Kembang Dadar', 'cerita', 'Palembang',
                'Tokoh legendaris Palembang yang makamnya berada di kompleks pemakaman Bukit Siguntang. Ada tiga versi cerita tentang ayahnya, salah satunya menyebut ia putri Raja Siguntang Alam.', false],

            // ---------- Kerajinan ----------
            ['ukiran-palembang', 'Ukiran Kayu Palembang', 'kerajinan', 'Palembang',
                'Ukiran kayu bermotif flora yang biasanya dilapisi warna emas. Dipakai pada rumah adat, lemari, dan perabot.', false],
            ['anyaman-purun', 'Anyaman Purun', 'kerajinan', 'Sumatera Selatan',
                'Kerajinan tikar, tas, dan wadah yang dianyam dari tanaman purun yang tumbuh di lahan rawa.', false],
            ['lakuer-palembang', 'Lakuer Palembang', 'kerajinan', 'Palembang',
                'Kerajinan kayu yang dibentuk dengan bubut lalu dilapisi lakuer, biasanya berwarna merah hati, kuning, atau hitam. Pengaruhnya datang dari Tiongkok, dan Palembang dikenal sebagai satu-satunya daerah dengan teknik ini.', false],
            ['tepak-sirih-lakuer', 'Tepak Sirih Lakuer', 'kerajinan', 'Palembang',
                'Wadah perlengkapan sirih yang dibuat dengan teknik lakuer. Dalam adat Palembang, tepak sirih disuguhkan kepada tamu sebagai tanda penghormatan.', false],
            ['tikar-purun-pedamaran', 'Tikar Purun Pedamaran', 'kerajinan', 'Ogan Komering Ilir',
                'Tikar anyaman purun dari rawa gambut Pedamaran. Kerajinan ini sudah ada sejak abad ke-19, umumnya dikerjakan kaum perempuan dengan motif geometris.', false],
            ['perak-tanjung-raja', 'Kerajinan Perak Tanjung Raja', 'kerajinan', 'Ogan Ilir',
                'Perhiasan ukir perak buatan perajin Tanjung Raja. Kecamatan Tanjung Batu di sekitarnya dikenal sebagai daerah perajin perak dan emas.', false],
        ];

                // Penjelasan mendalam (3 paragraf) per budaya. Antar paragraf dipisah baris kosong.
        // Budaya yang belum diisi akan memakai deskripsi singkat.
        $lengkap = [
            'aesan-gede' => implode("\n\n", [
                'Aesan Gede adalah pakaian kebesaran adat Palembang yang dikenakan pengantin pada upacara munggah, puncak rangkaian pernikahan adat. Dalam bahasa Palembang, baju disebut aesan, dan gede berarti besar. Busananya didominasi warna merah dan emas, lengkap dengan mahkota, kalung, gelang, dan banyak aksesori lain.',
                'Kilau emasnya sering dikaitkan dengan masa kejayaan Sriwijaya, yang dahulu dikenal sebagai Swarnadwipa atau pulau emas. Bagian bawahnya berupa songket lepus yang emasnya memenuhi kain, dipadukan dengan dodot dan penutup dada yang disebut terate. Karena tampilannya lebih terbuka, Aesan Gede sering disamakan dengan busana masa Hindu-Buddha.',
                'Selain di pelaminan, busana ini juga dikenakan oleh penari Gending Sriwijaya dan Tanggai. Karena itu, Aesan Gede bukan sekadar baju pengantin, tetapi juga lambang kebesaran dan identitas Palembang yang masih dijaga sampai sekarang.',
            ]),
            'aesan-paksangko' => implode("\n\n", [
                'Aesan Paksangko adalah pakaian pengantin adat Palembang yang lahir pada masa Kesultanan Palembang Darussalam, diperkirakan sekitar abad ke-16. Berbeda dengan Aesan Gede, busana ini membawa unsur Islam yang kuat. Menurut salah satu kajian, Paksangko dikenakan pada upacara nyumputi dan pengantin balik.',
                'Pengantin perempuan memakai baju kurung tertutup berwarna merah dari beludru, bertabur bunga emas, dengan kerah, ujung lengan, dan tepi depan dihiasi kuningan setengah lingkaran yang dihubungkan benang merah. Kepalanya dihiasi mahkota paksangko, kembang goyang, dan kembang kenago. Pengantin laki-laki memakai songket, jubah bermotif tabur bunga emas, selempang songket, dan songkok emas.',
                'Baju kurung yang tertutup mencerminkan ketentuan berbusana bagi muslimah, sementara emas dan songketnya tetap menunjukkan kemewahan. Jika Aesan Gede terasa megah dan klasik, Paksangko terasa lebih anggun dan sopan. Keduanya saling melengkapi sebagai wajah busana pengantin Palembang.',
            ]),
            'tanjak' => implode("\n\n", [
                'Tanjak adalah penutup kepala laki-laki yang dibuat dari sehelai kain persegi, biasanya songket, lalu dilipat dengan teknik tertentu. Di Palembang, tanjak sudah dikenal sejak masa Kesultanan Palembang Darussalam dan masih dipakai sampai sekarang. Tanjak Palembang juga tercatat sebagai Warisan Budaya Takbenda.',
                'Ada dua jenis yang sering dibedakan: tanjak kesultanan yang lipatannya masuk ke dalam, dan tanjak songket yang lipatannya menonjol keluar. Beberapa bentuk lipatan punya nama sendiri, seperti tanjak meler, kepundang, dan bela mumbang. Warna yang paling dikenal adalah merah marun dengan kuning keemasan.',
                'Dalam acara adat, tanjak biasa dipakai keluarga pengantin pria pada resepsi pernikahan, dipadukan dengan jas dan songket. Kini tanjak juga menjadi ikon yang banyak dicari wisatawan sebagai koleksi atau aksesori.',
            ]),
            'dodot' => implode("\n\n", [
                'Dodot adalah bagian atas busana pengantin Palembang yang dikenakan pada Aesan Gede. Bentuknya melilit tubuh dengan sedikit jahitan sehingga memberi kesan megah, dan bagian bahunya ditutup dengan terate.',
                'Ciri utamanya adalah motif tumpal berbentuk garis zigzag di sisi kanan dan kiri. Motif ini serupa dengan motif tumpal pada kain songket Palembang.',
                'Maknanya adalah harapan agar pengantin berbudi luhur, ramah, tidak sombong, dan saling menghormati sebagai makhluk sosial. Karena itu dodot bukan sekadar hiasan, tetapi juga pesan tentang sikap hidup yang dibawa pengantin.',
            ]),
            'baju-kurung' => implode("\n\n", [
                'Baju kurung adalah busana khas Melayu yang berpotongan longgar dan tertutup. Di Sumatera Selatan, baju kurung dikenakan perempuan maupun laki-laki, baik pada acara adat maupun sehari-hari, dan mencerminkan nilai kesopanan.',
                'Dalam busana pengantin Palembang, baju kurung hadir sebagai pengaruh budaya Melayu-Islam. Pengantin perempuan memakai baju kurung merah dengan taburan bunga emas, dan motifnya dibuat serasi dengan jubah pengantin laki-laki.',
                'Taburan bunga emas pada baju itu melambangkan kebahagiaan pengantin perempuan atas pernikahannya. Dipadukan dengan songket dan perhiasan, baju kurung menunjukkan bahwa adat Palembang menyatukan keanggunan dengan kesopanan.',
            ]),

             // ---------- Permainan Tradisional ----------
            'egrang' => implode("\n\n", [
                'Egrang adalah permainan berjalan di atas dua batang bambu panjang yang diberi pijakan untuk kaki. Permainan ini tidak hanya ada di Sumatera Selatan. Di berbagai daerah ia punya nama sendiri, misalnya tengkak-tengkak di Sumatera Barat, jangkungan di Jawa Tengah, batungkau di Kalimantan Selatan, serta dongga atau longga di Sulawesi Selatan.',
                'Egrang yang baik berawal dari bambu yang lurus dan bulat sempurna, dengan diameter sekitar 10 cm. Kesalahan kecil saat mengukur tinggi pijakan bisa membuat egrang sulit dipakai. Setelah jadi, pemain harus menjaga keseimbangan saat melangkah. Egrang biasa dilombakan dalam bentuk balap jalan cepat atau adu menjatuhkan lawan.',
                'Karena itu egrang mengajarkan lebih dari sekadar keseimbangan. Para peneliti menyebut tiga nilai di dalamnya: kerja keras untuk menguasai keterampilan, ketekunan saat membuatnya, dan sportivitas saat bertanding, termasuk menerima kekalahan. Pada perayaan kemerdekaan, egrang masih sering muncul sebagai lomba yang disambut meriah.',
            ]),
            'cak-engkle' => implode("\n\n", [
                'Cak engkle adalah sebutan Palembang untuk permainan engklek. Pemain menggambar petak-petak di tanah, lalu melompat dengan satu kaki dari petak ke petak. Benda kecil yang disebut gacuk dilempar atau didorong ke petak tertentu, dan pemain harus melewati petak itu sesuai aturan.',
                'Permainan ini hanya butuh kapur atau ranting dan sebidang tanah, sehingga mudah dimainkan siapa saja. Di Jawa Barat, permainan serupa dikenal dengan nama sondah, sedangkan di banyak daerah lain disebut engklek. Bentuk petaknya bisa berbeda, tetapi pola dasarnya sama: lompat, jaga keseimbangan, dan jangan menginjak garis.',
                'Cak engkle melatih keseimbangan, ketepatan membidik, dan kesabaran menunggu giliran. Anak-anak juga belajar jujur pada aturan, sebab pelanggaran seperti menginjak garis biasanya ditentukan sendiri oleh para pemain. Di Sumatera Selatan, cak engleng juga termasuk dalam daftar permainan tradisional Melayu yang diteliti oleh akademisi.',
            ]),
            'cuki' => implode("\n\n", [
                'Cuki adalah permainan papan dari Kesultanan Palembang Darussalam. Menurut pegiat budaya Kemas Muhammad Yunus Fahmi, permainan ini diperkirakan sudah ada sejak zaman Sriwijaya. Namanya kemungkinan berasal dari kata "di-cuk-i" dalam bahasa Palembang yang berarti diambil, merujuk pada cara bidak diambil satu per satu.',
                'Papannya mirip igo atau baduk, tetapi aturannya berbeda. Perlengkapannya berupa papan, 120 batu (60 hitam dan 60 putih), dadu, serta bidak bernama oncak. Pemain, dua sampai empat orang, melempar dadu untuk menentukan jumlah batu yang boleh diambil. Jika dadu menunjukkan angka lima, pemain harus menemukan lima batu sewarna dalam satu garis lurus, mendatar atau menurun. Pemain dengan batu terbanyak menang.',
                'Konon cuki dulu dimainkan kalangan bangsawan dan dipakai untuk melatih siasat perang. Minat pada permainan ini bangkit lagi setelah Komunitas Sriwijaya Antique Heritage menemukan batu yang diduga bidak cuki di dasar Sungai Musi, pada kedalaman 7 sampai 9 meter, bersama keramik Dinasti Ming. Tiga papan cuki kini disimpan di Museum Sultan Mahmud Badaruddin II dan Museum Balaputradewa, sementara para pegiatnya mengajarkannya kepada generasi muda.',
            ]),
            'gudang-kero' => implode("\n\n", [
                'Gudang kero adalah salah satu permainan tradisional masyarakat Melayu Sumatera Selatan. Permainan ini tercatat pertama dalam daftar 17 permainan yang diteliti Neni Noviza dan Arinil Hidayah (2018) dari UIN Raden Fatah Palembang. Daftar itu juga memuat gamang, adang-adangan, cak engleng, bentengan-bentengan, dan layangan.',
                'Penelitian itu dibuat untuk mencari alternatif bagi anak-anak yang gemar menirukan tantangan berbahaya di media sosial, seperti Skip Challenge. Permainan tradisional dipilih karena melatih kejujuran, sportivitas, kerja sama, strategi, dan jiwa kepemimpinan, tanpa membahayakan tubuh pemainnya.',
                'Para peneliti juga menemukan bahwa permainan-permainan itu mengandung nilai-nilai yang sejalan dengan ajaran Islam, antara lain tolong-menolong, ketaatan pada aturan, kerja keras, dan kerendahan hati. Gudang kero mengingatkan kita bahwa budaya bukan hanya bangunan atau benda kuno, tetapi juga kebiasaan bermain yang membentuk karakter anak.',
            ]),
            'bentengan' => implode("\n\n", [
                'Bentengan adalah permainan dua regu. Setiap regu memiliki benteng, yaitu tiang atau tempat yang ditentukan sebagai markas, lalu berusaha menyentuh benteng lawan atau menangkap pemain lawan. Di Sumatera Selatan permainan ini dikenal sebagai bentengan atau benteng-bentengan, dan tercatat dalam penelitian tentang 17 permainan tradisional Melayu di daerah itu.',
                'Permainan ini butuh lapangan yang cukup luas dan banyak pemain, sehingga biasanya dimainkan beramai-ramai pada sore hari. Pemain harus pandai berlari, mengecoh lawan, dan menentukan kapan menyerang atau bertahan. Aturan rinci bisa berbeda antardaerah, tetapi gagasan pokoknya sama: menjaga benteng sendiri sambil menembus pertahanan lawan.',
                'Nilai yang paling menonjol adalah kekompakan. Satu pemain yang cepat tidak akan menang kalau timnya tidak saling melindungi. Pemain juga belajar memimpin, mengatur strategi, dan menerima hasil dengan lapang dada. Karena itu penelitian pendidikan sering memakai bentengan sebagai contoh permainan yang menanamkan sportivitas pada anak.',
            ]),      

            // ---------- Kuliner ----------
            'pempek' => implode("\n\n", [
                'Pempek adalah makanan paling terkenal dari Palembang, dibuat dari daging ikan giling yang dicampur sagu atau tapioka. Asal-usulnya tidak tercatat pasti. Menurut cerita yang hidup di masyarakat, pada sekitar abad ke-16 seorang perantau Tionghoa tua di tepi Sungai Musi mengolah ikan yang tidak laku dengan campuran tepung, lalu menjualnya keliling. Orang memanggilnya "pek-apek", dan sebutan itu diyakini berkembang menjadi pempek. Ini tradisi lisan, bukan fakta yang terdokumentasi.',
                'Ada pula pendapat bahwa leluhurnya adalah kelesan, hidangan ikan dan sagu yang dikukus, dan nama itu dikaitkan dengan alat cetak bernama piri\'an. Sungai Musi, Ogan, dan Komering yang kaya ikan membuat bahan dasarnya mudah didapat. Ikan tenggiri paling umum dipakai, sedangkan belida sering disebut paling istimewa walaupun harganya mahal.',
                'Pempek hampir selalu disantap dengan cuko, kuah hitam kecokelatan dari gula aren, asam, bawang putih, cabai, dan garam. Konon cuko dulu dibuat tanpa cabai supaya anak-anak bisa ikut makan. Ragamnya banyak: kapal selam berisi telur utuh, lenjer yang memanjang, adaan yang bulat dengan irisan bawang, keriting, kulit, hingga pempek tahu. Karena itu pempek bukan sekadar jajanan, tetapi identitas yang membuat Palembang dijuluki kota pempek.',
            ]),
            'tekwan' => implode("\n\n", [
                'Tekwan adalah sup bola-bola ikan dari Palembang dengan kuah bening berkaldu udang. Isinya biasanya bengkuang, jamur kuping, bunga sedap malam kering, dan mi putih atau bihun, lalu ditaburi daun bawang, seledri, dan bawang goreng. Bakso ikannya dicubit kecil-kecil dan direbus sampai mengapung, sehingga bentuknya tidak beraturan dan sedikit keriting.',
                'Ada cerita bahwa nama tekwan berasal dari ungkapan Palembang "berkotek samo kawan", yang berarti mengobrol bersama teman. Asal nama ini dikutip dari salah satu media dan belum tentu jadi satu-satunya penjelasan, tetapi gambarannya pas, sebab tekwan memang enak dinikmati hangat sambil berbincang, terutama saat sarapan.',
                'Keistimewaan tekwan ada pada perpaduan teksturnya. Bola ikan yang kenyal berpadu dengan bengkuang yang renyah dan segar, sementara kuah kaldu udangnya gurih dan ringan. Hidangan ini juga menunjukkan kecerdikan dapur Palembang dalam mengolah ikan sungai menjadi banyak jenis masakan, bukan hanya pempek.',
            ]),
            'mi-celor' => implode("\n\n", [
                'Mi celor adalah mi berkuah kental khas Palembang. Mi kuning yang tebal, kira-kira setebal soba, diseduh sebentar dengan air panas, lalu disiram kuah santan berkaldu udang. Dalam logat Melayu Sumatera Selatan, celor atau celur berarti menyiram bahan dengan air mendidih, mirip teknik blansir, dan itulah asal nama hidangan ini.',
                'Kuahnya terasa gurih karena udang, yang bisa berupa udang segar maupun ebi. Jika memakai udang segar, udang kupas diletakkan di atas mi. Jika memakai ebi, serbuk ebi ditaburkan. Pelengkapnya telur rebus, tauge, irisan seledri, daun bawang, dan bawang goreng, sering dengan sambal di piring terpisah bagi yang suka pedas.',
                'Mi celor sering dianggap saudara dekat pempek dalam hal ketenaran, walaupun mi serupa juga dijual di kota lain di Sumatera. Beberapa rumah makan di Palembang masih menyimpan resep keluarga yang diwariskan dari generasi ke generasi, sehingga setiap mangkuk membawa rasa dan cerita dapur yang berbeda.',
            ]),
            'kue-maksuba' => implode("\n\n", [
                'Maksuba adalah kue lapis tradisional Palembang yang sudah dikenal sejak masa Kesultanan Palembang. Sekilas mirip lapis legit, tetapi maksuba tidak memakai tepung sehingga teksturnya lebih padat dan tidak berpori. Bahan utamanya telur bebek, dan konon kue ini dibuat agar tahan sekitar lima hari pada zaman sebelum ada lemari es.',
                'Karena bahan-bahannya mahal dan pengerjaannya lama, dahulu maksuba hanya dinikmati kalangan atas. Resepnya dijaga oleh juru masak mahir yang disebut panggong, lalu diwariskan. Proses pembuatannya yang panjang membuat maksuba dikenal sebagai lambang kesabaran dan ketekunan.',
                'Kini siapa pun bisa menikmatinya, tetapi kue ini tetap punya tempat istimewa dalam acara penting seperti lamaran, pernikahan, dan hari raya. Menghidangkan maksuba kepada tamu dianggap tanda penghormatan, karena di balik rasa manisnya ada waktu dan kerja keras yang panjang.',
            ]),
            'model' => implode("\n\n", [
                'Model adalah olahan ikan khas Palembang yang masih sekerabat dengan pempek. Adonan ikan dan sagu dibentuk, diisi tahu atau telur, lalu digoreng. Bentuknya mirip pempek kapal selam yang dipotong-potong, kemudian disajikan dalam kuah kaldu.',
                'Orang sering membandingkannya dengan tekwan karena keduanya berkuah kaldu. Bedanya, tekwan berupa bola ikan kecil tanpa isi yang direbus, sedangkan model berisi dan digoreng dulu sebelum masuk kuah. Kuah model cenderung lebih manis, sementara kuah tekwan lebih berbumbu. Sebagian orang Palembang bahkan memakai kuah yang sama untuk keduanya, dan ada juga yang menyantap model dengan cuko pempek.',
                'Model menunjukkan betapa luwesnya pengolahan ikan di Palembang. Dari adonan yang kurang lebih sama lahir hidangan dengan tekstur dan rasa berbeda: kenyal di dalam, gurih di luar, dan hangat oleh kuah. Itu sebabnya model sering dicari sebagai pilihan lain bagi penggemar pempek.',
            ]),
            'laksan' => implode("\n\n", [
                'Laksan adalah pempek lenjer yang disajikan dalam kuah santan, bukan dengan cuko. Potongan lenjer dari ikan dan sagu direndam dalam kuah santan berwarna oranye. Ikan yang dipakai antara lain belida, gabus, tenggiri, atau kakap.',
                'Kuahnya dibumbui ebi, lengkuas, kemiri, jahe, ketumbar, dan cabai merah, lalu dimasak hingga kental dan gurih. Penyajiannya mirip lontong sayur, dengan kuah yang menjadi bintang hidangannya.',
                'Laksan sering dijajakan berdampingan dengan burgo dan celimpungan, sebab ketiganya sama-sama berkuah santan. Perbedaan itu menunjukkan bahwa dari satu bahan pokok, yaitu ikan dan sagu, dapur Palembang mampu menghadirkan beragam rasa, dari yang asam-manis-pedas seperti pempek cuko hingga yang gurih dan lembut seperti laksan.',
            ]),
            'celimpungan' => implode("\n\n", [
                'Celimpungan adalah turunan pempek yang berbentuk bulat pipih dan dibuat dari ikan serta sagu. Hidangan ini disiram kuah santan kental yang kuning pekat, sehingga mirip opor. Kuah dibumbui berbagai rempah dan terasa gurih.',
                'Celimpungan biasanya disajikan saat Lebaran. Hidangan ini sering dijajakan bersama laksan dan burgo, sesama hidangan berkuah santan yang lekat dengan suasana hari raya.',
                'Dibanding pempek cuko yang segar dan pedas, celimpungan terasa lebih hangat dan mengenyangkan. Hidangan ini menjadi salah satu penanda bahwa kuliner Palembang tidak berhenti pada pempek.',
            ]),
            'burgo' => implode("\n\n", [
                'Burgo adalah hidangan berkuah santan yang terbuat dari tepung beras dan tepung sagu. Adonan digulung, dipotong-potong kecil, lalu disiram kuah santan putih yang dibumbui bawang putih, ketumbar, dan lengkuas. Ikan dipakai sebagai bahan kuah, sehingga rasanya gurih dan paling nikmat saat masih hangat.',
                'Burgo diperkirakan sudah ada sekitar 200 tahun lalu, mungkin lebih lama karena beras di Palembang sudah dikenal sejak abad ke-17. Pada 2021, Kementerian Pendidikan dan Kebudayaan menetapkannya sebagai Warisan Budaya Takbenda dari Sumatera Selatan dengan nomor pencatatan 202101401.',
                'Pembuatan burgo yang panjang dimaknai sebagai simbol kesabaran dan keuletan, sedangkan perpaduan adonan dan kuahnya dianggap melambangkan persatuan. Burgo biasanya bukan makanan utama dan sering dijual bersama laksan dan celimpungan, sehingga ketiganya terasa seperti satu keluarga hidangan santan khas Palembang.',
            ]),
            'pindang-patin' => implode("\n\n", [
                'Pindang patin adalah hidangan ikan patin berkuah asam, pedas, dan segar yang sangat khas Sumatera Selatan. Patin banyak dibudidayakan di Palembang dan kaya protein. Bumbunya terdiri dari bawang merah, bawang putih, serai, jahe, kunyit, dan cabai merah giling, dengan asam dari asam jawa.',
                'Kesegarannya muncul dari nanas, tomat, dan daun kemangi, sedangkan rasa pedasnya datang dari cabai rawit. Beberapa juru masak menyebut asamnya juga berasal dari tomat kecil yang disebut cung kediro, dan terasi serta nanas membuat rasanya lebih mantap. Di tangan koki yang berbeda, hasilnya pun berbeda-beda.',
                'Pindang patin punya banyak versi. Pindang kuah kuning dikenal dari Musi Rawas, kuah merah dari Banyuasin, dan ada pula pindang patin tempoyak. Hidangan ini biasa disantap dengan nasi hangat, sambal terasi, dan lalapan seperti wortel serta labu siam. Perpaduan asam, pedas, dan gurihnya membuat pindang patin terasa segar sekaligus mengenyangkan.',
            ]),

                        // ---------- Kain Tradisional ----------
            'songket-palembang' => implode("\n\n", [
                'Songket Palembang adalah kain tenun dengan benang tambahan berwarna emas atau perak yang disisipkan di antara benang dasar. Teknik ini dilakukan dengan mengangkat sebagian benang lungsi sehingga motifnya tampak timbul, dan para peneliti menghubungkan prinsip itu dengan asal kata songket. Ada beberapa penjelasan tentang kata ini. Salah satunya menyebut songket berasal dari "disongsong" dan "di-teket", dengan teket berarti sulam dalam bahasa Palembang lama.',
                'Tenun songket dikaitkan dengan masa Sriwijaya, kerajaan yang dikenal dengan julukan Swarnadwipa atau pulau emas. Dalam hikayat rakyat, songket lahir dari perdagangan dua bangsa, yaitu benang sutra dari Tiongkok dan benang emas serta perak dari India. Kisah ini perlu dibaca sebagai tradisi lisan, tetapi ia menggambarkan Palembang yang sejak lama menjadi tempat bertemunya budaya Melayu, Timur Tengah, dan Tionghoa.',
                'Motifnya kaya makna. Nago Besaung berupa dua naga saling berhadapan dan dimaknai sebagai lambang kemakmuran, kebaikan, dan kejayaan, sehingga dipakai pada pernikahan sebagai doa bagi pengantin. Ada pula motif bunga seperti bungo mawar, bungo melati, dan bungo tanjung, serta bintang dan tampuk manggis. Songket ditenun manual secara tradisional, dan menurut satu sumber satu kain bisa memakan waktu satu sampai tiga bulan. Wajar jika kain ini menjadi lambang kebesaran dan selalu hadir pada acara adat.',
            ]),
            'kain-jumputan' => implode("\n\n", [
                'Kain jumputan dibuat dengan teknik ikat celup. Kain diikat atau dijumput pada bagian tertentu sesuai pola, lalu dicelup ke dalam pewarna. Setelah dikeringkan, ikatan dibuka, dan bagian yang terikat tetap putih atau lebih terang karena tidak terkena warna. Kata jumput sendiri berasal dari bahasa Jawa dan berarti memungut dengan ujung-ujung jari.',
                'Karena hasilnya bergantung pada cara dan kuatnya ikatan, tidak ada dua lembar jumputan yang benar-benar sama. Polanya biasanya berupa lingkaran, garis, atau bentuk abstrak yang berulang, dengan warna yang bisa dihasilkan dari pewarna alami maupun sintetis. Di Palembang kainnya sering berwarna-warni sehingga dijuluki pelangi, dan ada ragam pola bernama seperti bintang lima, kembang janur, cuncung, dan beberapa jenis bintik.',
                'Teknik ikat celup juga dikenal di Jawa, Bali, dan Kalimantan Selatan. Di Jawa ia disebut tritik atau plangkan. Di Palembang, jumputan dipakai pada acara adat seperti pernikahan, sering dalam satu set bawahan, atasan, dan selendang yang serasi. Dari satu helai kain dan seutas tali, perajin menciptakan karya yang selalu unik.',
            ]),
            'songket-lepus' => implode("\n\n", [
                'Songket lepus disebut sebagai songket paling istimewa di Palembang. Nama lepus berarti menutupi, karena benang emasnya menutup hampir seluruh permukaan kain. Hasilnya kain yang berkilau dan terlihat sangat mewah, berbeda dari songket yang emasnya hanya tersebar di beberapa bagian.',
                'Menurut sebuah kajian tahun 2022 di Jurnal Dinamika Sosial Budaya, songket lepus bermula dari lingkungan keluarga kerajaan. Kajian lain menyebut bahwa di keraton, songket jenis lepus yang dipakai, sedangkan warga biasa memakai songket tawur. Dahulu perbedaan jenis songket ini ikut menandai strata sosial pemakainya.',
                'Motif yang disebut pada lepus antara lain bintang, buah anggur, rantai, dan ulir, sementara warna yang paling sering dipakai pada songket Palembang adalah merah dan emas. Para peneliti menyebutnya warisan multikultural yang berharga, sebab Palembang sejak dulu bertemu berbagai pengaruh budaya. Mereka juga mengajak generasi muda ikut melestarikannya.',
            ]),
            'songket-tawur' => implode("\n\n", [
                'Songket tawur adalah songket Palembang dengan benang emas yang diletakkan berserakan di atas kain. Emasnya tersebar di permukaan kain. Ini membedakannya dari songket lepus yang benang emasnya menutup hampir seluruh kain.',
                'Menurut sebuah kajian, perbedaan itu dulu menjadi penanda kelas sosial. Songket lepus dipakai kalangan keraton, sedangkan warga biasa memakai songket tawur. Motif yang disebutkan pada tawur antara lain lintang dan bintang. Ada pula varian yang dinamai menurut bunganya, seperti tawur bungo cino yang disebut dipakai warga keturunan Tionghoa dan tawur bungo pacik yang dipakai warga keturunan Arab.',
                'Varian itu menggambarkan wajah Palembang yang beragam, ketika berbagai komunitas memakai kain yang sama-sama bernama songket tetapi dengan corak dan makna sendiri. Songket seperti ini dipakai pada acara adat, misalnya lamaran dan pernikahan.',
            ]),
            'tenun-tajung' => implode("\n\n", [
                'Tenun tajung adalah kain tenun khas Palembang tanpa benang emas, dipakai laki-laki sebagai sarung sehingga sering disebut sarung tajung. Berbeda dari songket yang gemerlap, tajung tampil lebih bersahaja.',
                'Motifnya antara lain limar, limar patut, petak-petak, dan gerbik. Benang diwarnai dan dikeringkan terlebih dahulu sebelum ditenun, dan menurut salah satu sumber proses ini bisa memakan waktu dua sampai tiga hari atau lebih. Kain dipakai dengan cara dililitkan di pinggul seperti sarung atau disampirkan di bahu.',
                'Tajung biasa dikenakan pada acara adat seperti lamaran dan pernikahan. Ia menunjukkan bahwa tradisi tenun Palembang tidak hanya tentang songket emas. Ada pula kain yang tampil sopan dan sederhana, tetapi tetap lahir dari ketelitian tangan penenunnya.',
            ]),
            'tenun-blongsong' => implode("\n\n", [
                'Blongsong adalah kain tenun Palembang untuk perempuan. Pada penelitian tentang kerajinan Palembang, blongsong disebut sebagai padanan tajung yang dipakai laki-laki, yaitu tenun tanpa benang emas. Namun menurut sebuah ulasan, blongsong kadang diberi tambahan benang emas.',
                'Warnanya cenderung pucat dan kalem, sehingga tampil anggun tanpa berlebihan. Pembuatannya mirip tenun tajung: benang diwarnai dahulu, dikeringkan, lalu ditenun. Perempuan memakainya sebagai bawahan yang dililitkan di pinggul atau pinggang lalu diikat dengan tali, sering dipadukan dengan selendang yang senada.',
                'Dalam berbusana adat Palembang, tajung dan blongsong membentuk pasangan yang serasi. Keduanya menjadi pengingat bahwa warisan kain Palembang luas, mulai dari songket emas yang megah sampai tenun sederhana yang dipakai pada acara keluarga.',
            ]),

                        // ---------- Seni dan Tari ----------
            'tari-gending-sriwijaya' => implode("\n\n", [
                'Tari Gending Sriwijaya lahir pada masa pendudukan Jepang. Saat itu pemerintah meminta Kantor Penerangan menciptakan tarian dan lagu untuk menyambut tamu yang berkunjung ke Karesidenan Palembang. Menurut catatan yang ada, lagunya digubah pada Oktober sampai Desember 1943 oleh A. Dahlan Muhabat dengan syair karya Nungcik AR, sedangkan tariannya mulai disusun pada 1943 dan rampung pada 1944 oleh Tina Haji Gong dan Sukadan A. Rozak, dengan bertolak dari tari tradisi Palembang.',
                'Tarian ini dibawakan sembilan penari perempuan berbusana Aesan Gede dengan songket, dodot, paksangko, dan tanggai berlapis emas. Pada versi yang lebih lengkap, dua pengawal laki-laki menjaga para penari dengan payung kuning dan tombak berlapis emas. Penari utama membawa tepak berisi sirih, pinang, dan kapur untuk upacara sekapur sirih, sementara dua penari lain membawa pridon dari kuningan. Busananya diyakini memadukan unsur Melayu, Jawa, dan Tionghoa.',
                'Makna tarian ini adalah kemegahan Kerajaan Sriwijaya, sekaligus ungkapan keramahan tuan rumah dan keluhuran adab keraton. Hingga kini Gending Sriwijaya identik dengan penyambutan tamu kehormatan di Palembang.',
            ]),
            'tari-tepak-keraton' => implode("\n\n", [
                'Tari Tepak Keraton diciptakan oleh seniman Palembang, Anna Kumari, yang akrab dipanggil Cek Anna. Ia lahir pada 10 November 1945 dan sejak muda menekuni tari. Pada usia 17 tahun, ia menjadi penari Istana Negara, lalu mendirikan Sanggar Tari Anna Kumari pada 1967. Ia disebut telah menciptakan sekitar 50 tarian dan menulis buku tentang adat Palembang.',
                'Menurut Antara, tarian ini bermula ketika Anna memimpin grup seni Kodam II Sriwijaya dan diminta Komandan Inmindam IV Sriwijaya, Kolonel Makmun Rasjid, menyiapkan tarian baru. Tari Gending Sriwijaya yang populer ketika itu dilarang tampil dengan alasan politik, sehingga Anna menciptakan Tepak Keraton sebagai penggantinya. Tarian ini menggambarkan kejayaan Kesultanan Palembang Darussalam dan bercorak Islami dengan ragam gerak yang berunsur pencak silat.',
                'Seperti Gending Sriwijaya, Tepak Keraton dipakai untuk menyambut tamu. Kepopulerannya mencapai puncak ketika tarian ini ditampilkan pada pembukaan MTQ Internasional 2015 di Palembang. Kisahnya menunjukkan bahwa tradisi bisa terus tumbuh: seniman masa kini tidak hanya menjaga karya lama, tetapi juga menciptakan karya baru yang berakar pada sejarah daerahnya.',
            ]),
            'dul-muluk' => implode("\n\n", [
                'Dul Muluk atau Dulmuluk adalah teater tradisional khas Palembang yang diperkirakan muncul sekitar 1845. Tokoh awalnya adalah Wan Bakar, nama asli Syekh Achmad Bakar, pedagang keturunan Arab yang membacakan syair di depan rumahnya di Tangga Takat, 16 Ulu. Syair yang ia bacakan adalah Syair Abdul Muluk, yang disebut selesai ditulis pada 2 Juli 1845. Penulisnya berbeda menurut dua versi, yaitu Raja Ali Haji atau Saleha, sepupu Raja Ali Haji.',
                'Pada 1919 pembacaan syair mulai berkembang menjadi dialog dengan gerak tubuh di lapangan terbuka. Pada masa pendudukan Jepang, pertunjukannya naik ke atas panggung dan tampil di acara perkawinan, khitanan, dan syukuran. Unsurnya berupa musik gambus dan terbangan, dialog syair, lawakan, kuda berhias manik-manik, serta pembukaan dan penutup yang disebut beremas. Kisah utamanya berpusat pada tokoh Abdul Muluk, dengan 1.814 bait dalam 18 bagian cerita.',
                'Pada awalnya semua peran, termasuk tokoh perempuan, dimainkan laki-laki. Kini perempuan juga ikut tampil. Dulmuluk menunjukkan bagaimana sebuah syair berubah menjadi seni panggung yang mengundang tawa sekaligus menyampaikan pesan, dan bagaimana budaya Melayu, Arab, dan Palembang saling bertemu di atas satu panggung.',
            ]),
            'tari-tanggai' => implode("\n\n", [
                'Tari Tanggai dikenal juga sebagai tari kuku panjang karena penarinya mengenakan tanggai, yaitu hiasan kuku yang panjang. Tarian ini digunakan untuk menyambut tamu kehormatan dan hadir pada acara resmi atau pernikahan. Penarinya membawa tepak, kotak kecil dari kayu yang menjadi simbol penghormatan dalam adat Palembang.',
                'Mengenai asal-usulnya, Wikipedia menyebut tarian ini diciptakan pada 1965 di Jakarta oleh Elly Rudy, setelah Gending Sriwijaya dan tari Dong dilarang karena alasan politik, dan memakai lagu "Enam Saudara". Informasi tentang tahun dan tokoh penciptanya masih bisa berbeda antar sumber, dan Gending Sriwijaya sendiri jelas sudah ada sejak 1944. Karena itu sejarah Tanggai sebaiknya dibaca sebagai penjelasan yang masih terus dikaji.',
                'Tanggai juga tidak berdiri sendiri. Hiasan tanggai dipakai penari Gending Sriwijaya dan juga dalam Tari Pagar Pengantin, ketika kuku panjang itu dipasangkan di jari pengantin perempuan sebagai lambang kelembutan dan keanggunan. Jari-jari lentik berhias tanggai itulah yang membuat gerak tarian ini terlihat halus dan memikat.',
            ]),
            'tari-pagar-pengantin' => implode("\n\n", [
                'Tari Pagar Pengantin adalah tarian adat Palembang yang ditampilkan dalam upacara atau resepsi pernikahan. Menurut Good News from Indonesia, penciptanya adalah Sukainah A. Rozak, seorang penari pada 1960-an. Maknanya adalah perpisahan: pengantin perempuan berpamitan kepada keluarga, kerabat, dan teman karena telah dipersunting, sekaligus ungkapan syukur dan tanda berakhirnya masa lajang.',
                'Tiap gerakannya punya arti. Pengantin perempuan menari di atas dulang agung berwarna emas, yang melambangkan batas ruang gerak dalam rumah tangga. Penari dayang memasangkan tanggai sepanjang sekitar 10 cm di jarinya sebagai simbol kelembutan dan keanggunan, lalu menari bersama sambil menaburkan beras kunyit. Pengantin pria berdiri di belakang pengantin perempuan sebagai lambang kesiapan menjaga dan menafkahi keluarga. Dua penari membawa tombak, tanda harapan agar rumah tangga terhindar dari malapetaka.',
                'Di bagian akhir, dayang mengantar pengantin ke pelaminan, lalu meninggalkan arena dengan berjalan berjinjit membawa nampan dengan gerakan seperti elang terbang. Dalam adat setempat, gadis yang sudah dipersunting tidak menari di depan umum kecuali atas izin suami. Karena itu tarian ini bukan sekadar hiburan, tetapi juga penanda peralihan hidup yang penuh makna.',
            ]),
            'gambus-palembang' => implode("\n\n", [
                'Gambus Palembang adalah musik yang lahir dari pertemuan budaya Timur Tengah dan Melayu. Alat musik gambus, yang mirip oud, diperkirakan dibawa pedagang Arab dan Persia. Di Palembang, musik ini hadir sejak ratusan tahun lalu seiring berkembangnya komunitas keturunan Arab di wilayah bekas Sriwijaya. Akarnya adalah qasidah dan syair salawat, yang pada mulanya berisi puji-pujian lalu berkembang menjadi nyanyian dan pengiring tari.',
                'Selain gambus, pertunjukannya memakai rebana atau marwas, darbuka, gendang, hingga drum, bas, dan keyboard. Gayanya memadukan gambus klasik, gambus Melayu, dan gambus modern. Lagunya meliputi salawat, qasidah, bahkan dangdut dan pop. Salawat Badar disebut sebagai lagu wajib. Tempo lambat biasa dipakai untuk suasana sedih atau rindu, sedangkan tempo sedang hingga cepat untuk suasana gembira.',
                'Pada 1960 sampai 1970-an, Palembang punya ratusan musisi dan kelompok gambus. Kini kelompok yang aktif jauh lebih sedikit, dan menurut satu kajian hanya sekitar empat yang masih bertahan, antara lain Al-Mubarok dan Mozaig. Meski begitu, gambus masih tampil pada hajatan, pernikahan, khitanan, dan pengajian, dan para pegiatnya terus menyesuaikan aransemen agar lebih mudah diterima.',
            ]),

            // ---------- Cerita Rakyat ----------
            'legenda-pulau-kemaro' => implode("\n\n", [
                'Pulau Kemaro adalah delta kecil di tengah Sungai Musi, Palembang. Menurut legenda, pulau ini lahir dari kisah cinta Tan Bun An, saudagar atau pangeran dari Tiongkok, dan Siti Fatimah, putri raja Palembang. Tan Bun An datang untuk berdagang, jatuh hati pada sang putri, lalu mengajaknya ke Tiongkok untuk bertemu orang tuanya. Dalam perjalanan pulang membawa sembilan guci hadiah, ia kecewa karena yang tampak hanya sayuran yang menutupi guci, lalu menendang guci-guci itu ke sungai. Guci yang pecah memperlihatkan emas di dalamnya.',
                'Tan Bun An menyesal dan melompat ke sungai untuk menyelamatkan emas itu, dan ia tidak pernah muncul lagi. Siti Fatimah ikut terjun menyusulnya. Konon dari tempat itulah muncul gundukan tanah yang kini menjadi Pulau Kemaro. Nama kemaro sering diartikan sebagai kemarau, sebab pulau ini dipercaya tidak pernah terendam walau Sungai Musi sedang pasang dan deras. Di dekat klenteng ada makam yang dipercaya sebagai makam kedua kekasih itu, dan sebuah Pohon Cinta yang melambangkan cinta mereka.',
                'Kisah ini hidup lewat bangunan nyata. Klenteng Hok Tjing Rio atau Klenteng Kwan Im berdiri sejak 1962, di sampingnya ada pagoda sembilan lantai, dan setiap perayaan Cap Go Meh ribuan orang menyeberang dengan perahu ke pulau ini. Karena tokohnya berasal dari dua budaya dan agama berbeda, legenda ini sering dibaca sebagai lambang toleransi antara masyarakat Melayu dan Tionghoa di Palembang. Perlu diingat, ini adalah legenda yang ceritanya punya beberapa versi, bukan catatan sejarah yang terbukti.',
            ]),
            'si-pahit-lidah' => implode("\n\n", [
                'Si Pahit Lidah adalah julukan Serunting Sakti, tokoh sakti dalam cerita rakyat Sumatera Selatan. Kisahnya bermula dari iri hati. Ladang adik iparnya, Aria Tebing, ditumbuhi cendawan yang berubah menjadi emas, sedangkan ladang Serunting hanya ditumbuhi tanaman tak berguna. Serunting menuduh adik iparnya curang dan menantangnya berduel. Ia kalah, lalu pergi ke Gunung Siguntang dan bertapa hampir dua tahun hingga tubuhnya tertutup daun bambu.',
                'Dari pertapaan itu ia memperoleh kesaktian: apa pun yang ia kutuk akan terjadi. Itulah asal julukan Si Pahit Lidah. Kesaktian ini membuatnya sombong, dan banyak versi menggambarkan ia mengutuk orang-orang yang serakah atau kasar. Masyarakat di berbagai daerah juga mengaitkan batu-batu besar dan bentuk batuan unik dengan kutukannya. Dalam satu versi populer, ia berhadapan dengan Si Mata Empat, tokoh sakti dari India, dan keduanya sama-sama celaka karena memakan buah beracun.',
                'Cerita ini tersebar luas di Sumatera Selatan, Bengkulu, dan Lampung, sehingga alurnya berbeda-beda. Ada versi yang berakhir dengan Serunting berdamai dengan keluarganya, ada pula yang berakhir tragis. Pesan yang paling sering dikaji adalah bahaya iri hati, kesombongan, dan ucapan yang tidak dijaga. Karena itu, di balik tokohnya yang menyeramkan, legenda ini sebenarnya pelajaran tentang menjaga lidah dan hati.',
            ]),
            'legenda-bukit-siguntang' => implode("\n\n", [
                'Bukit Siguntang adalah bukit kecil setinggi sekitar 29 sampai 30 meter di tepi utara Sungai Musi, dan merupakan titik tertinggi di kota Palembang. Dalam naskah Sejarah Melayu (Sulalatus Salatin), bukit ini disebut sebagai tempat turunnya Sang Sapurba, tokoh yang disebut sebagai keturunan Iskandar Zulkarnain. Dari tokoh inilah para raja Melayu di Sumatera, Kalimantan Barat, dan Semenanjung Malaya diceritakan berasal, termasuk raja-raja Malaka.',
                'Bukit ini juga dipandang sebagai bagian dari Gunung Mahameru, gunung suci dalam kepercayaan Hindu-Buddha. Karena itu orang Melayu menyucikannya sebagai tanah leluhur. Di puncaknya terdapat makam-makam yang dikaitkan dengan tokoh legendaris seperti Raja Sigentar Alam, Pangeran Raja Batu Api, Putri Kembang Dadar, Putri Rambut Selako, serta beberapa panglima. Peziarah masih datang ke sini sampai sekarang.',
                'Jejak sejarahnya juga nyata. Pada 1920-an di lereng selatan bukit ditemukan arca Buddha bergaya Amarawati, serta pecahan prasasti beraksara Pallawa dan berbahasa Melayu Kuno. Namun nama-nama tokoh pada makamnya berasal dari tradisi lisan, dan para arkeolog belum sepenuhnya sepakat bahwa makam itu benar milik raja-raja Sriwijaya. Jadi Bukit Siguntang adalah tempat bertemunya legenda, kepercayaan, dan bukti arkeologi.',
            ]),
            'putri-dayang-merindu' => implode("\n\n", [
                'Putri Dayang Merindu adalah tokoh legenda yang dikaitkan dengan asal-usul lomba perahu bidar di Sungai Musi. Dalam versi Palembang, ia adalah gadis jelita dari hulu yang diperebutkan dua pemuda. Satu sumber menyebut keduanya bernama Kemala Negara dan Dewa Jaya. Untuk membuktikan cinta, mereka berlomba mendayung perahu bidar yang ditonton seluruh masyarakat.',
                'Akhir ceritanya tragis. Dayang Merindu tidak sanggup kehilangan keduanya dan mengakhiri hidupnya. Sebelum itu ia berpesan agar jasadnya dibagi dua dan dimakamkan bersama kedua pria yang mencintainya. Masyarakat menghormatinya karena sikap adilnya. Kisah ini punya banyak versi di Sumatera Selatan, Jambi, Bengkulu, dan Lampung. Di Ogan Komering Ulu, ia dikaitkan dengan Goa Putri di Padangbindu, bahkan ada cerita yang mempertemukannya dengan Serunting Sakti.',
                'Perlu dibedakan antara legenda dan catatan sejarah. Menurut dokumentasi, lomba bidar mulai digelar sekitar 1898 dalam perayaan ulang tahun Ratu Belanda Wilhelmina, sementara perahu bidar sendiri dikenal sebagai perahu panjang yang juga dipakai untuk patroli sungai. Namun masyarakat Palembang tetap menyimpan kisah Dayang Merindu sebagai cerita asal-usulnya, dan lomba bidar masih menjadi tontonan utama setiap perayaan 17 Agustus di sekitar Jembatan Ampera dan Benteng Kuto Besak.',
            ]),
            'ratu-bagus-kuning' => implode("\n\n", [
                'Ratu Bagus Kuning adalah tokoh perempuan sakti dalam cerita rakyat Palembang. Dalam kisah yang beredar, Bagus Kuning digambarkan sebagai perempuan suci yang berbeda dari orang lain. Ia dihadang para pendekar tetapi tidak gentar, lalu menantang raja siluman kera dan menang. Karena kemenangan itu ia bergelar ratu dan memimpin wilayahnya sampai akhir hayat.',
                'Menurut sebagian versi, Ratu Bagus Kuning adalah murid salah satu Wali Songo dari Jawa yang datang untuk menyebarkan Islam di sekitar Sungai Musi. Sebuah kajian menyebut nama aslinya Putri Mulia Syarifah Mahani dan menyebutnya keturunan Nabi Muhammad melalui garis Zainal Abidin. Karena itu ia dikenang bukan hanya sebagai pemimpin yang kuat, tetapi juga sebagai penyebar agama yang dihormati.',
                'Makamnya dipercaya berada di kawasan Plaju, Palembang, dan kera-kera yang berkeliaran di sekitarnya diyakini sebagai keturunan raja siluman kera yang menjaga makam itu. Catatan kehati-hatian: di Bukit Siguntang juga ada makam yang disebut Panglima Bagus Kuning, dan tidak jelas apakah keduanya tokoh yang sama. Kisahnya adalah tradisi lisan dengan banyak versi, jadi sebaiknya dibaca sebagai legenda, bukan sejarah yang pasti.',
            ]),
            'putri-kembang-dadar' => implode("\n\n", [
                'Putri Kembang Dadar adalah putri legendaris yang makamnya berada di kompleks pemakaman Bukit Siguntang. Ada tiga versi tentang ayahnya. Versi yang paling sering disebut menyebutnya putri Raja Sigentar Alam atau Raja Siguntang Alam, versi lain menyebut Demang Lebar Daun, tokoh yang muncul dalam Sejarah Melayu. Namanya pun beragam, ada yang menyebutnya Siti Soleha atau Putri Bunga Melur.',
                'Dalam cerita yang paling dikenal, dua kerajaan, Hulu dan Hilir, saling bertikai. Ketika semua penasihat diam, sang putri berani maju dan meminta izin ayahnya untuk menyelesaikan masalah itu. Ia menyamar sebagai penjual sayur di negeri lawan, menarik hati Raja Hulu, lalu menjadi permaisurinya. Dengan kesaktiannya, ia kemudian menemui ayahnya untuk memohon agar permusuhan diakhiri, dan perdamaian pun terwujud.',
                'Pesan yang sering diambil dari kisah ini adalah keberanian, kecerdasan, dan pengorbanan seorang perempuan demi perdamaian. Namanya masih dipakai untuk jalan dan kapal di Palembang. Meski makamnya nyata dan banyak diziarahi, kisah dan identitas sang putri berasal dari tradisi lisan, sehingga tahun hidupnya tidak dapat dipastikan dan sebaiknya dibaca sebagai legenda.',
            ]),

            // ---------- Kerajinan ----------
            'ukiran-palembang' => implode("\n\n", [
                'Ukiran kayu Palembang dikenal lewat ragam hiasnya yang didominasi motif tumbuhan, seperti sulur-suluran dan bunga, termasuk bunga mawar. Warnanya khas: emas, hitam, dan merah tua. Kayu yang paling sering dipakai adalah tembesu, kayu keras yang tahan lama. Seni ukir ini erat kaitannya dengan rumah limas, rumah adat Palembang, yang balok, dinding, dan perlengkapannya dihiasi ukiran.',
                'Teknik ukirnya bermacam-macam. Para peneliti menyebut ada ukiran rendah (timbul tipis), ukiran tinggi (timbul tebal), dan ukiran tembus yang membuat kayu berlubang berpola seperti renda. Kajian terhadap koleksi museum menunjukkan ragam hias ini menyerap pengaruh budaya Hindu-Buddha dan Islam. Motif tumbuhan juga dominan pada masa Kesultanan Palembang, dan ukiran dipakai pada bangunan serta benda-benda rumah tangga.',
                'Sekarang ukiran Palembang hadir pada lemari hias, kursi, meja, kaca rias, dan bingkai. Sentra pengrajinnya antara lain berada di kawasan 19 Ilir, Palembang, dan banyak usahanya berupa industri rumahan. Tantangannya adalah bahan kayu berkualitas yang makin sulit dan mahal, serta cat emas untuk menyepuhnya. Karena itu menjaga ukiran Palembang berarti menjaga keahlian tangan sekaligus rantai usaha kecil di sekelilingnya.',
            ]),
            'anyaman-purun' => implode("\n\n", [
                'Purun adalah tumbuhan rawa yang tumbuh liar di lebak dan lahan gambut Sumatera Selatan. Batangnya yang ramping, panjang, dan lentur sejak lama dimanfaatkan masyarakat, khususnya di Kabupaten Ogan Komering Ilir dan Ogan Ilir, untuk dianyam menjadi tikar, topi, tas, sandal, kipas, serta wadah bumbu dapur dan ikan.',
                'Prosesnya panjang dan dikerjakan tangan. Purun diambil dari rawa, dijemur di bawah terik matahari, dipipihkan dengan cara ditumbuk, diberi warna, lalu dianyam. Pengrajinnya sebagian besar perempuan, dan keterampilan menganyam diwariskan dari ibu ke anak. Kini para pengrajin juga membuat produk baru, misalnya tas laptop berpadu kulit, sandal bermotif batik, dan mainan anak, agar kerajinan ini tetap diminati.',
                'Anyaman purun juga terkait dengan lingkungan. Purun tumbuh di rawa gambut, sehingga mengelolanya secara berkelanjutan membantu menjaga kondisi rawa itu dan fungsinya mengatur air. Namun lahan purun menyempit ketika rawa berubah menjadi perkebunan. Jadi nasib kerajinan ini bergantung pada nasib rawanya: kalau rawa hilang, bahan anyamannya ikut hilang.',
            ]),
            'lakuer-palembang' => implode("\n\n", [
                'Lakuer, atau lak, adalah bahan pelapis yang dipakai untuk melindungi dan mengawetkan barang kerajinan, terutama dari kayu. Di Palembang kata ini juga dipakai untuk menyebut seluruh kerajinan yang dilapisi dengan teknik tersebut. Menurut sumber-sumber kajian, kerajinan lakuer Palembang dipengaruhi budaya Tiongkok, dan kerajinan ini disebut sebagai salah satu kerajinan unggulan kota, bersama songket dan ukiran kayu.',
                'Bahan kayu yang lazim dipakai adalah mahoni, tembesu, dan sungkai. Lakuer diterapkan pada wadah dan peralatan rumah tangga, serta benda hias, lalu dikembangkan juga ke lukisan lakuer. Di atas kayu, lapisan lakuer membuat permukaan tampak mengilap dan lebih awet, sehingga barangnya bernilai sebagai pajangan maupun benda adat.',
                'Kerajinan ini tidak selalu berjalan mulus. Peneliti mencatat bahwa pada sekitar tahun 2000-an lakuer di Palembang sempat mengalami masa surut, lalu mulai dihidupkan kembali lewat pelatihan, lukisan, dan pengembangan produk. Lakuer menunjukkan bahwa budaya Palembang tumbuh dari pertemuan banyak pengaruh dan terus diolah menjadi sesuatu yang khas.',
            ]),
            'tepak-sirih-lakuer' => implode("\n\n", [
                'Tepak sirih adalah wadah perlengkapan sirih. Dalam tradisi Melayu, sirih disuguhkan kepada tamu dan dikenal lewat ungkapan sekapur sirih, yaitu sambutan atau pembuka dalam sebuah acara. Di Palembang, tepak sirih banyak dibuat dengan teknik lakuer sehingga permukaannya mengilap dan awet.',
                'Sebuah kajian tentang tepak sirih lakuer Palembang menjelaskan bentuknya menyerupai limas terpotong, dengan kemiringan sisi sekitar 25 derajat. Hiasannya berupa motif hewan yang digayakan dan motif tumbuhan. Fungsinya bukan hanya tempat menyimpan sirih, pinang, dan perlengkapannya, tetapi juga benda adat yang dibawa atau disuguhkan dalam acara penyambutan dan upacara.',
                'Kehadiran tepak sirih lakuer juga hidup dalam seni pertunjukan. Tarian penyambutan Palembang seperti Tari Tepak Keraton memakai tepak sirih sebagai bagian dari penyambutan tamu. Karena itu benda ini sering dilihat sebagai lambang keramahan dan penghormatan, yang menyatu dengan sopan santun Melayu Palembang.',
            ]),
            'tikar-purun-pedamaran' => implode("\n\n", [
                'Kecamatan Pedamaran di Kabupaten Ogan Komering Ilir dijuluki Kota Tikar karena tikar purunnya sudah menjadi identitas masyarakat. Purun diambil dari lebak dan rawa gambut di sekitar desa, lalu dijemur, dipipihkan, dan dianyam. Kerajinan ini sudah ada turun-temurun dan dilaporkan telah dimanfaatkan masyarakat selama ratusan tahun.',
                'Menganyam tikar adalah keterampilan yang menyebar luas di antara perempuan. Satu laporan menyebut hampir 90 persen perempuan Pedamaran bisa menganyam tikar. Motifnya beragam, termasuk pola geometris dan motif yang diberi nama seperti sisik salak. Membuat satu tikar bisa memakan waktu sekitar satu pekan, sementara harga jual dari pengrajin ke pengepul pada satu laporan tahun 2021 hanya sekitar Rp8 ribu per tikar.',
                'Masa depan tikar purun bergantung pada lebak tempat purun tumbuh. Warga Pedamaran menyebut lebak purun yang dulu luas banyak menghilang sejak perkebunan sawit meluas, dan kini mereka memperjuangkan akses kelola atas lebak yang tersisa. Karena itu tikar purun Pedamaran bukan hanya kerajinan, tetapi juga cerita tentang perempuan, rawa gambut, dan identitas yang ingin dijaga.',
            ]),
            'perak-tanjung-raja' => implode("\n\n", [
                'Di Kabupaten Ogan Ilir, perajin perak dan emas banyak ditemukan di Kecamatan Tanjung Batu dan juga di Tanjung Raja. Seorang perajin dari Desa Tanjung Raja menyebut keahlian membuat perhiasan perak ini dikerjakan manual dengan tangan dan sudah ada turun-temurun sejak zaman nenek moyang. Karena itu kerajinan ini lebih tepat dibaca sebagai warisan keterampilan keluarga, bukan sebagai kerajinan dengan sejarah tertulis yang rinci.',
                'Cara kerjanya cukup khas. Menurut perajin itu, bahan perak tidak berasal dari Tanjung Raja. Bahan sering diantar pemilik toko atau pelanggan ke rumah perajin, lalu dibentuk sesuai pesanan, kemudian dikirim ke toko perhiasan di Palembang dan Baturaja. Dari bahan 200 gram, seorang perajin bisa menghasilkan sekitar 30 cincin dalam waktu hingga lima hari. Jenisnya antara lain cincin, kalung, dan gelang.',
                'Harga perhiasan perak mengikuti harga emas dan dijual per gram, sementara pesanan naik menjelang Lebaran. Perajin juga mengeluh bahan baku kadang sulit didapat, dan ketika bahan tidak ada mereka terpaksa berhenti berproduksi. Penelitian tentang Tanjung Batu menyebut proses pembuatan emas dan perak di sana masih mempertahankan teknik tradisional yang diwariskan turun-temurun dengan alat modern sederhana.',
            ]),
        ];

        foreach ($data as [$slug, $nama, $kategori, $asal, $singkat, $unggulan]) {
            MuseumItem::updateOrCreate(
                ['slug' => $slug],
                [
                    'nama'              => $nama,
                    'kategori'          => $kategori,
                    'asal_daerah'       => $asal,
                    'deskripsi_singkat' => $singkat,
                    'image_url'         => file_exists(public_path("images/galeri/{$slug}.webp"))
                            ? asset("images/galeri/{$slug}.webp")
                            : "https://picsum.photos/seed/{$slug}/900/600",
                    'is_featured'       => $unggulan,
                    'deskripsi_lengkap' => $lengkap[$slug] ?? null,
                ]
            );
        }
        
        // Hapus data lama yang tidak ada di daftar baru
        MuseumItem::whereNotIn('slug', array_column($data, 0))->delete();
    }
}