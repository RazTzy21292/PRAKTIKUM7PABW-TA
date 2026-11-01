<?php

namespace Tests\Feature;

use App\Models\TongSampah;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthenticationAndLaporanTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_protected_pages(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
        $this->get(route('laporan.index'))->assertRedirect(route('login'));
    }

    public function test_logout_ends_the_authenticated_session_with_post(): void
    {
        $user = User::create([
            'nama' => 'Siswa Logout',
            'email' => 'logout@example.test',
            'password' => 'password123',
            'role' => 'siswa',
        ]);

        $this->actingAs($user)->post(route('logout'))->assertRedirect('/landing');

        $this->assertGuest();
        $this->get('/logout')->assertMethodNotAllowed();
    }

    public function test_user_seeder_creates_faker_accounts_with_hashed_passwords(): void
    {
        $this->seed(UserSeeder::class);

        $this->assertDatabaseCount('users', 13);
        $user = User::where('email', 'dummy.01@smacan.sch.id')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $user->password));

        $this->seed(UserSeeder::class);
        $this->assertDatabaseCount('users', 13);
    }

    public function test_registration_validates_and_stores_a_hashed_password(): void
    {
        $this->from('/register')->post('/register', [
            'nama' => 'Siswa Uji',
            'email' => 'siswa@example.test',
            'password' => 'short',
            'password_confirm' => 'different',
        ])->assertSessionHasErrors(['password', 'password_confirm']);

        $this->from('/register')->post('/register', [
            'nama' => 'Siswa Uji',
            'email' => 'siswa@example.test',
            'password' => 'password123',
            'password_confirm' => 'password123',
        ])->assertRedirect('/dashboard');

        $user = User::where('email', 'siswa@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame('password123', $user->password);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_login_accepts_valid_credentials_and_rejects_invalid_credentials(): void
    {
        User::create([
            'nama' => 'Siswa Login',
            'email' => 'login@example.test',
            'password' => 'password123',
            'role' => 'siswa',
        ]);

        $this->from('/login')->post('/login', [
            'email' => 'login@example.test',
            'password' => 'password123',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->post('/logout');

        $this->from('/login')->post('/login', [
            'email' => 'login@example.test',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_report_upload_is_replaced_and_deleted_with_its_record(): void
    {
        Storage::fake('public');
        $user = User::create([
            'nama' => 'Pemilik Laporan',
            'email' => 'pemilik@example.test',
            'password' => 'password123',
            'role' => 'siswa',
        ]);
        $tong = TongSampah::create([
            'nama_tong' => 'Tong Uji',
            'lokasi' => 'Halaman sekolah',
        ]);

        $this->actingAs($user)->post(route('laporan.store'), [
            'tong_id' => $tong->id,
            'status' => 'penuh',
            'keterangan' => 'Perlu segera dikosongkan.',
            'foto' => UploadedFile::fake()->create('tong-lama.jpg', 10, 'image/jpeg'),
        ])->assertRedirect(route('laporan.index'));

        $laporan = $user->laporan()->firstOrFail();
        $fotoLama = $laporan->foto;
        $this->assertNull($laporan->edited_at);
        Storage::disk('public')->assertExists($fotoLama);

        $this->put(route('laporan.update', $laporan), [
            'tong_id' => $tong->id,
            'status' => 'sedang',
            'keterangan' => 'Status diperbarui.',
            'foto' => UploadedFile::fake()->create('tong-baru.png', 10, 'image/png'),
        ])->assertRedirect(route('laporan.index'));

        $laporan->refresh();
        $fotoBaru = $laporan->foto;
        $this->assertNotSame($fotoLama, $fotoBaru);
        $this->assertNotNull($laporan->edited_at);
        Storage::disk('public')->assertMissing($fotoLama);
        Storage::disk('public')->assertExists($fotoBaru);
        $this->actingAs($user)->get(route('laporan.index'))->assertOk()->assertSee('Edited');

        $this->delete(route('laporan.destroy', $laporan))->assertRedirect(route('laporan.index'));
        Storage::disk('public')->assertMissing($fotoBaru);
        $this->assertDatabaseMissing('laporan_sampah', ['id' => $laporan->id]);
    }
}
