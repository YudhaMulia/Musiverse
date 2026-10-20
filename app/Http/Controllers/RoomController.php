<?php

namespace App\Http\Controllers;

use App\Events\RuangDiperbarui;
use App\Models\Room;
use App\Models\RoomPlayer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RoomController extends Controller
{
    private const NAMA_GAME = [
        'match' => 'Musiverse Match',
        'quiz' => 'Musiverse Quiz',
        'puzzle' => 'Musiverse Puzzle',
    ];

    private const NAMA_BOT = ['Bot Ampera', 'Bot Musi', 'Bot Pempek', 'Bot Songket', 'Bot Bidar', 'Bot Limas'];

    // Dipanggil tombol "Main Bersama": pakai ruangan menunggu milikmu, atau buat yang baru
    public function masuk(Request $request, string $game): RedirectResponse
    {
        $user = $request->user();

        $room = Room::where('host_id', $user->id)
            ->where('game', $game)
            ->where('status', 'waiting')
            ->latest('id')
            ->first();

        if (! $room) {
            $room = DB::transaction(function () use ($user, $game) {
                $room = Room::create([
                    'code' => Room::buatKode(),
                    'game' => $game,
                    'host_id' => $user->id,
                    'status' => 'waiting',
                ]);

                // Avatar pemain diambil dari profil (kalau belum memilih, pakai karakter 1)
                $room->players()->create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'avatar' => $user->avatar ?: 1,
                    'is_host' => true,
                ]);

                return $room;
            });
        }
        $this->siarkan($room);

        return redirect()->route('rooms.show', $room);
    }

    // Tamu memasukkan kode di modal "Masuk Ruangan"
    public function gabung(Request $request): RedirectResponse
    {
        // "bdy7k2 " -> "BDY7K2"
        $request->merge(['code' => strtoupper(trim((string) $request->input('code')))]);

        $request->validate(
            ['code' => ['required', 'string', 'size:6']],
            [
                'code.required' => 'Kode ruangan wajib diisi.',
                'code.size' => 'Kode ruangan harus 6 karakter.',
            ]
        );

        $user = $request->user();

        $room = DB::transaction(function () use ($request, $user) {
            // kunci baris ruangan supaya dua orang yang masuk bersamaan tidak melebihi batas
            $room = Room::where('code', $request->input('code'))->lockForUpdate()->first();

            if (! $room) {
                throw ValidationException::withMessages(['code' => 'Ruangan dengan kode itu tidak ditemukan.']);
            }

            // Sudah jadi anggota ruangan ini: langsung masuk saja
            if ($room->players()->where('user_id', $user->id)->exists()) {
                return $room;
            }

            if (! $room->sedangMenunggu()) {
                throw ValidationException::withMessages(['code' => 'Permainan di ruangan ini sudah dimulai.']);
            }

            $pemain = $room->players()->get();

            if ($pemain->count() >= Room::MAKS_PEMAIN) {
                throw ValidationException::withMessages(['code' => 'Ruangan sudah penuh.']);
            }

            // Avatar dari profil; kalau sudah dipakai pemain lain, ambil karakter yang masih bebas
            $avatar = $user->avatar ?: 1;
            if ($pemain->contains('avatar', $avatar)) {
                $avatar = collect(range(1, 10))->diff($pemain->pluck('avatar'))->first() ?? $avatar;
            }

            $room->players()->create([
                'user_id' => $user->id,
                'name' => $user->name,
                'avatar' => $avatar,
            ]);

            return $room;
        });

        return redirect()->route('rooms.show', $room);
    }

    // Halaman ruang tunggu
    public function show(Request $request, Room $room): View|RedirectResponse
    {
        $this->pemainSaya($request, $room);   // 403 kalau kamu belum ada di ruangan ini

        if (! $room->sedangMenunggu()) {
            $this->siarkan($room);
        }

        return view('games.ruang-tunggu', [
            'room' => $room,
            'namaGame' => self::NAMA_GAME[$room->game],
            'state' => $this->state($room, $request->user()->id),
            'karakter' => self::NAMA_KARAKTER,
            'urlMain' => $this->urlMain($room),
            // alamat halaman Games tanpa "http://", misal 127.0.0.1:8000/games
            'alamat' => preg_replace('#^https?://#', '', route('games.index')),
        ]);
    }

    // Dipanggil JavaScript tiap beberapa detik untuk mengambil data terbaru ruangan
    public function sinkron(Request $request, Room $room): JsonResponse
    {
        $this->pemainSaya($request, $room);   // 403 kalau kamu sudah tidak ada di ruangan ini

        return response()->json($this->state($room, $request->user()->id));
    }

    // Ganti karakter milikku (hanya di ruangan ini, profil tidak berubah)
    public function avatar(Request $request, Room $room): JsonResponse
    {
        $saya = $this->pemainSaya($request, $room);
        abort_unless($room->sedangMenunggu(), 409, 'Permainan sudah dimulai.');

        $data = $request->validate(['avatar' => ['required', 'integer', 'between:1,10']]);
        $saya->update(['avatar' => $data['avatar']]);
        $this->siarkan($room);

        return response()->json($this->state($room, $request->user()->id));
    }

    // Tuan rumah menambah bot
    public function tambahBot(Request $request, Room $room): JsonResponse
    {
        $this->pastikanTuanRumah($request, $room);
        abort_unless($room->sedangMenunggu(), 409, 'Permainan sudah dimulai.');

        DB::transaction(function () use ($room) {
            Room::lockForUpdate()->find($room->id);   // cegah dua klik bersamaan melebihi batas

            $pemain = $room->players()->get();
            abort_if($pemain->count() >= Room::MAKS_PEMAIN, 422, 'Ruangan sudah penuh.');

            $nama = collect(self::NAMA_BOT)->first(fn ($n) => ! $pemain->contains('name', $n)) ?? 'Bot '.random_int(10, 99);
            $bebas = collect(range(1, 10))->diff($pemain->pluck('avatar'))->values();
            $avatar = $bebas->isNotEmpty() ? $bebas->random() : random_int(1, 10);

            $room->players()->create(['name' => $nama, 'avatar' => $avatar, 'is_bot' => true]);
        });
        $this->siarkan($room);

        return response()->json($this->state($room, $request->user()->id));
    }

    // Tuan rumah mengeluarkan pemain (bot maupun manusia), kecuali dirinya sendiri
    public function hapusPemain(Request $request, Room $room, RoomPlayer $pemain): JsonResponse
    {
        $this->pastikanTuanRumah($request, $room);
        abort_unless($room->sedangMenunggu(), 409, 'Permainan sudah dimulai.');
        abort_unless($pemain->room_id === $room->id, 404);
        abort_if($pemain->is_host, 422, 'Tuan rumah tidak bisa mengeluarkan dirinya sendiri. Pakai tombol Keluar.');

        $pemain->delete();
        $this->siarkan($room);

        return response()->json($this->state($room, $request->user()->id));
    }

    // Tuan rumah menekan "Mulai"
    public function mulai(Request $request, Room $room): JsonResponse
    {
        $this->pastikanTuanRumah($request, $room);
        abort_unless($room->sedangMenunggu(), 409, 'Permainan sudah dimulai.');
        abort_if($room->players()->count() < 2, 422, 'Butuh minimal 2 pemain.');

        $room->update(['status' => 'playing', 'started_at' => now()]);
        $this->siarkan($room);

        return response()->json($this->state($room, $request->user()->id) + ['url' => $this->urlMain($room)]);
    }

    // Tombol "Keluar" dan "Kembali ke Games":
    // - pemain biasa: keluar sendiri
    // - tuan rumah: jabatan diserahkan ke pemain manusia berikutnya (bot dilewati);
    //   kalau tidak ada manusia lain, ruangan ditutup
    public function keluar(Request $request, Room $room): RedirectResponse
    {
        $userId = $request->user()->id;

        DB::transaction(function () use ($room, $userId) {
            Room::lockForUpdate()->find($room->id);   // cegah dua orang keluar bersamaan saling bentrok

            $saya = $room->players()->where('user_id', $userId)->first();
            if (! $saya) {
                return;   // sudah tidak terdaftar (misal sudah dikeluarkan tuan rumah)
            }

            $saya->delete();

            // Manusia yang masih tersisa, urut dari yang paling dulu masuk
            $manusia = $room->players()->where('is_bot', false)->get();

            if ($manusia->isEmpty()) {
                $room->delete();   // tinggal bot atau kosong: tutup ruangan
            } elseif ($saya->is_host) {
                $baru = $manusia->first();
                $baru->update(['is_host' => true]);
                $room->update(['host_id' => $baru->user_id]);
            }
        });

        $this->siarkan($room);

        return redirect()->route('games.index');
    }

    // Tombol "Main Lagi" (main bersama): kembali ke ruang tunggu berisi pemain yang sama
    public function mainLagi(Request $request, Room $room): RedirectResponse
    {
        // Kamu sudah keluar / dikeluarkan dari ruangan ini: kembali ke halaman Games
        if (! $room->players()->where('user_id', $request->user()->id)->exists()) {
            return redirect()->route('games.index');
        }

        // "ronde" = penanda permainan yang baru selesai (waktu mulainya).
        // Ruangan hanya dikembalikan ke "menunggu" kalau masih ronde itu. Kalau tuan rumah
        // sudah memulai ronde baru, ruangan tidak boleh diganggu.
        $ronde = (int) $request->query('ronde');

        if ($room->status === 'playing' && $room->started_at && $room->started_at->timestamp === $ronde) {
            $room->update(['status' => 'waiting', 'started_at' => null]);
            $this->siarkan($room);
        }

        return redirect()->route('rooms.show', $room);
    }

    // ---------------------------------------------------------------------------------

    // Baris room_players milik user yang sedang login; 403 kalau bukan anggota ruangan
    private function pemainSaya(Request $request, Room $room): RoomPlayer
    {
        $saya = $room->players()->where('user_id', $request->user()->id)->first();
        abort_unless($saya, 403, 'Kamu belum bergabung di ruangan ini.');

        return $saya;
    }

    private function pastikanTuanRumah(Request $request, Room $room): void
    {
        abort_unless($this->pemainSaya($request, $room)->is_host, 403, 'Hanya tuan rumah yang boleh melakukan ini.');
    }

    // Kabari semua pemain di ruangan lewat Pusher: "ada perubahan, ambil data terbaru"
    private function siarkan(Room $room): void
    {
        try {
            RuangDiperbarui::dispatch($room->code);
        } catch (\Throwable $e) {
            // Kunci Pusher salah / internet putus: catat saja, ruang tunggu tetap jalan lewat pengecekan cadangan
            report($e);
        }
    }

    private function urlMain(Room $room): string
    {
        // "ronde" = penanda permainan ini (waktu dimulainya), dipakai tombol "Main Lagi" di rekap
        $param = ['ruang' => $room->code];
        if ($room->started_at) {
            $param['ronde'] = $room->started_at->timestamp;
        }

        return match ($room->game) {
            'match' => route('games.match.play', $param),
            'quiz' => route('games.quiz.play', $param),
            'puzzle' => route('games.puzzle.play', $param),
        };
    }

    // Data ruangan yang dikirim ke JavaScript
    private function state(Room $room, int $userId): array
    {
        // Tuan rumah SELALU urutan pertama (game menganggap pemain nomor 0 = tuan rumah),
        // sisanya urut dari yang paling dulu masuk
        $pemain = $room->players()->get()
            ->sort(fn ($a, $b) => [! $a->is_host, $a->id] <=> [! $b->is_host, $b->id])
            ->values();

        return [
            'kode' => $room->code,
            'status' => $room->status,
            'maks' => Room::MAKS_PEMAIN,
            'url' => $this->urlMain($room),
            'tuanRumah' => (bool) $pemain->firstWhere('user_id', $userId)?->is_host,
            'pemain' => $pemain->map(fn (RoomPlayer $p) => [
                'id' => $p->id,
                'nama' => $p->name,
                'avatar' => $p->avatar,
                'bot' => $p->is_bot,
                'host' => $p->is_host,
                'kamu' => $p->user_id === $userId,
            ])->values()->all(),
        ];
    }

    private const NAMA_KARAKTER = [
        1 => 'Tanjak Merah', 2 => 'Aesan Gede', 3 => 'Kerudung Songket', 4 => 'Peci Hitam',
        5 => 'Sanggul Melati', 6 => 'Tanjak Emas', 7 => 'Caping Musi', 8 => 'Ikat Kepala',
        9 => 'Si Kacamata', 10 => 'Kepang Dua',
    ];
}
