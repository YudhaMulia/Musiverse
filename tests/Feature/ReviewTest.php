<?php

namespace Tests\Feature;

use App\Models\CagarBudaya;
use App\Models\Era;
use App\Models\Location;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private function createCagarBudaya(): CagarBudaya
    {
        $era = Era::create([
            'name' => 'Era Kesultanan Palembang',
            'slug' => 'era-kesultanan',
            'period' => '1659 - 1823',
            'description' => 'Masa Kesultanan Palembang Darussalam',
        ]);

        $location = Location::create([
            'name' => 'Kawasan Benteng Kuto Besak',
            'address' => 'Jl. Sultan Mahmud Badaruddin',
            'district' => '19 Ilir',
            'postal_code' => '30113',
            'latitude' => -2.9912,
            'longitude' => 104.7608,
        ]);

        return CagarBudaya::create([
            'name' => 'Benteng Kuto Besak',
            'slug' => 'benteng-kuto-besak',
            'era_id' => $era->id,
            'location_id' => $location->id,
            'short_description' => 'Benteng pertahanan megah di tepi Sungai Musi.',
            'status' => 'terdaftar',
        ]);
    }

    public function test_cagar_budaya_page_displays_reviews_section(): void
    {
        $cagar = $this->createCagarBudaya();

        $response = $this->get(route('cagar-budaya.show', $cagar->slug));
        $response->assertStatus(200);
        $response->assertSee('Ulasan Pengunjung');
    }

    public function test_guest_is_redirected_when_accessing_create_review(): void
    {
        $cagar = $this->createCagarBudaya();

        $response = $this->get(route('review.create', $cagar));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_create_review_page(): void
    {
        $user = User::factory()->create();
        $cagar = $this->createCagarBudaya();

        $response = $this->actingAs($user)->get(route('review.create', $cagar));
        $response->assertStatus(200);
        $response->assertSee('Bagikan Pengalaman Anda');
    }

    public function test_authenticated_user_can_store_review(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $cagar = $this->createCagarBudaya();
        $file = UploadedFile::fake()->image('test_photo.jpg');

        $response = $this->actingAs($user)->post(route('review.store', $cagar), [
            'rating' => 5,
            'content' => 'Pengalaman yang sangat mengesankan di cagar budaya ini. Pemandangan dan suasananya luar biasa.',
            'photos' => [$file],
        ]);

        $response->assertRedirect(route('cagar-budaya.show', $cagar->slug).'#ulasan-pengunjung');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'cagar_budaya_id' => $cagar->id,
            'rating' => 5,
        ]);
    }

    public function test_user_can_update_their_own_review(): void
    {
        $user = User::factory()->create();
        $cagar = $this->createCagarBudaya();

        $review = Review::create([
            'user_id' => $user->id,
            'cagar_budaya_id' => $cagar->id,
            'rating' => 4,
            'content' => 'Ulasan awal sebelum dilakukan pembaruan oleh pengunjung.',
        ]);

        $response = $this->actingAs($user)->put(route('review.update', $review), [
            'rating' => 5,
            'content' => 'Ulasan baru setelah diperbarui: tempat ini benar-benar luar biasa dan bersih.',
        ]);

        $response->assertRedirect(route('cagar-budaya.show', $cagar->slug).'#ulasan-pengunjung');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'rating' => 5,
            'content' => 'Ulasan baru setelah diperbarui: tempat ini benar-benar luar biasa dan bersih.',
        ]);
    }

    public function test_user_cannot_update_another_users_review(): void
    {
        $author = User::factory()->create();
        $otherUser = User::factory()->create();
        $cagar = $this->createCagarBudaya();

        $review = Review::create([
            'user_id' => $author->id,
            'cagar_budaya_id' => $cagar->id,
            'rating' => 4,
            'content' => 'Ulasan oleh pengguna pertama untuk diuji otorisasi.',
        ]);

        $response = $this->actingAs($otherUser)->put(route('review.update', $review), [
            'rating' => 1,
            'content' => 'Percobaan meretas atau mengubah ulasan orang lain tanpa izin.',
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_photo_from_review(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $cagar = $this->createCagarBudaya();

        $review = Review::create([
            'user_id' => $user->id,
            'cagar_budaya_id' => $cagar->id,
            'rating' => 5,
            'content' => 'Review dengan foto untuk testing penghapusan foto.',
        ]);

        $photo = $review->photos()->create([
            'photo_path' => 'reviews/sample_test.jpg',
        ]);

        $response = $this->actingAs($user)->delete(route('review.deletePhoto', $photo->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('review_photos', [
            'id' => $photo->id,
        ]);
    }
}
