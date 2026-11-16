# RENCANA Pengerjaan: Modul Gallery & SEO (BAB X–XI) — Adaptasi Proyek Prakerin

Dokumen ini adalah panduan langkah-langkah pengerjaan untuk memenuhi tuntutan `modul_gallery_laravel.md` dan `modul_penggunaan_seo_laravel.md` pada proyek prakerin (Laravel 13, objek data Jurusan & Kompetensi). Dikerjakan sendiri berdasarkan dokumen ini, dengan mekanisme branching per fitur.

---

## 1. Analisis Modul vs. Kondisi Proyek Saat Ini

### 1.1 Tuntutan Modul Gallery (`modul_gallery_laravel.md`)
- **Model Post**: tabel `posts` (id, title string 200, description mediumText nullable, picture nullable, timestamps); model `Post`.
- **GalleryController** resource: `index` menampilkan post yang memiliki gambar (picture != '' dan not null), paginate 30; `create` form upload; `store` validasi title/description/picture, simpan ke `posts_image` dengan nama unik.
- **View**: `gallery/index.blade.php` (grid gambar + Lightbox2), `gallery/create.blade.php` (form upload).
- **Route**: `Route::resource('gallery', GalleryController::class)`.
- **Menu**: tambah item "Gallery" di navbar.
- **Lightbox2**: download, ekstrak ke `public/`, include css/js di layout.
- **Tugas 1**: buat fungsi **Edit** dan **Delete** (ganti/hapus gambar gallery).
- **Tugas 2**: implementasikan tema tampilan ke website portofolio.
- **Tugas 3**: push ke branch `pertemuan_11`.

### 1.2 Tuntutan Modul SEO (`modul_penggunaan_seo_laravel.md`)
- **Kolom baru** `buku_seo` dan `foto` pada tabel `buku`.
- **Halaman `list_buku`**: tampilan foto + judul buku.
- **Halaman `detail_buku`**: semua galeri buku terkait:
  - Route: `Route::get('/detail-buku/{title}', [BukuController::class, 'galbuku'])->name('galeri.buku')`.
  - Model: `photos()` hasMany Galeri (`id_buku` → `id`).
  - Controller: `galbuku($title)` → cari buku by `buku_seo`, ambil photos paginated (6), return view.
  - View: `galeri-buku.blade.php` (gambar lightbox + nama galeri + pagination).
- **Lightbox**: include css/js di layout.

### 1.3 Kondisi Proyek Prakerin (terakhir)
- Auth & middleware sudah terpasang; `JurusanController`, `KompetensiController`, `UserController` (admin) ada.
- Model: `Jurusan`, `Kompetensi`, `User`. Belum ada `Post`.
- Tabel: `jurusan`, `kompetensi`, `users`. Belum ada `posts`, belum ada kolom seo/foto.
- Tampilan sudah Bootstrap (Tahap 1–6) → view baru harus konsisten.
- Pesan validasi sudah Bahasa Indonesia (`lang/id/validation.php`).
- Lightbox2 belum terpasang.
- Laravel **13** / PHP **8.3**.

### 1.4 Adaptasi yang Wajib Dilakukan
| Aspek di Modul | Adaptasi di Prakerin |
|---|---|
| Model `Post` (tabel `posts`) | Tetap buat `Post` model + tabel `posts` (fitur Gallery mandiri, sesuai modul). |
| Layout `auth.layouts` | Proyek memakai `layouts.app` → view gallery extend `layouts.app`. |
| `Route::resource('gallery', ...)` tanpa middleware | Proyek konsisten memproteksi halaman dengan `auth` (dashboard sudah diproteksi). Tambahkan `->middleware('auth')` agar konsisten. |
| Lightbox2 path `lightbox2/dist/...` | Sesuaikan path sesuai lokasi ekstrak (mis. `public/lightbox2/`). Include di `layouts/app.blade.php`. |
| `buku` (SEO module) | Adaptasi ke `Jurusan` (entitas utama). Kolom `jurusan_seo` + `foto`. |
| `photos()` hasMany `Galeri` | Prakerin sudah punya relasi `Jurusan hasMany Kompetensi` (`jurusan_id`). Gunakan relasi existing sebagai "detail" content (tidak perlu tabel Galeri baru). `photos()` diadaptasi menjadi `kompetensi()` (sudah ada). |
| `list_buku` / `detail_buku` | Adaptasi menjadi `list_jurusan` (foto + nama jurusan) dan `detail_jurusan/{slug}` (foto lightbox + daftar kompetensi). |
| `buku_seo` (slug) | Auto-generate dari `nama` jurusan via `Str::slug()` saat create/update. |
| `asset('images/...')` (SEO view) | Ganti ke `asset('storage/...')` / `asset($jurusan->foto)` sesuai penyimpanan. |
| Pagination 6 (SEO) | Tetap 6 per halaman (sesuai modul) untuk detail. |

---

## 2. Strategi Branching

- Pola nama: `feature/<nama-fitur>`, dibuat dari `develop` yang **sudah up-to-date** (`git pull origin develop` dulu).
- Setiap branch = 1 fitur/modul, commit terpisah dengan pesan `feat: ...`.
- Urutan branch mengikuti **dependensi** (lihat bagian 3).

Perintah dasar tiap branch:
```bash
git checkout develop
git pull origin develop
git checkout -b feature/<nama-fitur>
# ... kerjakan ...
# verifikasi, lalu commit & push sendiri
```

---

## 3. Rencana Branch (berurutan)

### Branch 1 — `feature/gallery-post`
**Tujuan:** Implementasi Modul Gallery (Post model, upload, tampilan grid + Lightbox2) + Tugas Edit & Delete.

**Perintah:**
```bash
php artisan make:model Post --migration
php artisan make:controller GalleryController -r
php artisan storage:link   # jika belum pernah
```

**File yang dibuat/diubah:**

- `database/migrations/<timestamp>_create_posts_table.php` (baru)
  ```php
  public function up(): void
  {
      Schema::create('posts', function (Blueprint $table) {
          $table->id();
          $table->string('title', 200);
          $table->mediumText('description')->nullable();
          $table->string('picture')->nullable();
          $table->timestamps();
      });
  }

  public function down(): void
  {
      Schema::dropIfExists('posts');
  }
  ```

- `app/Models/Post.php` (baru)
  ```php
  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Post extends Model
  {
      use HasFactory;

      protected $fillable = ['title', 'description', 'picture'];
  }
  ```

- `app/Http/Controllers/GalleryController.php` (baru, resource)
  ```php
  namespace App\Http\Controllers;

  use App\Models\Post;
  use Illuminate\Http\Request;

  class GalleryController extends Controller
  {
      public function index()
      {
          $galleries = Post::where('picture', '!=', '')
              ->whereNotNull('picture')
              ->orderBy('created_at', 'desc')
              ->paginate(30);

          return view('gallery.index', compact('galleries'));
      }

      public function create()
      {
          return view('gallery.create');
      }

      public function store(Request $request)
      {
          $request->validate([
              'title' => 'required|max:255',
              'description' => 'required',
              'picture' => 'image|nullable|max:1999',
          ]);

          if ($request->hasFile('picture')) {
              $filenameWithExt = $request->file('picture')->getClientOriginalName();
              $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
              $extension = $request->file('picture')->getClientOriginalExtension();

              $basename = uniqid() . time();
              $filenameSimpan = "{$basename}.{$extension}";
              $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
          } else {
              $filenameSimpan = 'noimage.png';
          }

          Post::create([
              'title' => $request->title,
              'description' => $request->description,
              'picture' => $filenameSimpan,
          ]);

          return redirect()->route('gallery.index')->with('success', 'Berhasil menambahkan data baru.');
      }

      public function edit(Post $post)
      {
          return view('gallery.edit', compact('post'));
      }

      public function update(Request $request, Post $post)
      {
          $request->validate([
              'title' => 'required|max:255',
              'description' => 'required',
              'picture' => 'image|nullable|max:1999',
          ]);

          if ($request->hasFile('picture')) {
              if ($post->picture && $post->picture !== 'noimage.png') {
                  \Illuminate\Support\Facades\Storage::disk('public')->delete('posts_image/' . $post->picture);
              }
              $filenameWithExt = $request->file('picture')->getClientOriginalName();
              $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
              $extension = $request->file('picture')->getClientOriginalExtension();
              $basename = uniqid() . time();
              $filenameSimpan = "{$basename}.{$extension}";
              $request->file('picture')->storeAs('posts_image', $filenameSimpan, 'public');
              $post->picture = $filenameSimpan;
          }

          $post->title = $request->title;
          $post->description = $request->description;
          $post->save();

          return redirect()->route('gallery.index')->with('success', 'Data gallery berhasil diperbarui.');
      }

      public function destroy(Post $post)
      {
          if ($post->picture && $post->picture !== 'noimage.png') {
              \Illuminate\Support\Facades\Storage::disk('public')->delete('posts_image/' . $post->picture);
          }
          $post->delete();

          return redirect()->route('gallery.index')->with('success', 'Data gallery berhasil dihapus.');
      }
  }
  ```

- `routes/web.php` — tambah:
  ```php
  use App\Http\Controllers\GalleryController;
  
  Route::resource('gallery', GalleryController::class)->parameters(['gallery' => 'post'])->middleware('auth');
  ```

- `resources/views/gallery/index.blade.php` (baru)
  ```blade
  @extends('layouts.app')

  @section('title', 'Gallery')

  @section('content')
      <div class="d-flex justify-content-between align-items-center mb-3">
          <h1 class="mb-0">Gallery</h1>
          <a href="{{ route('gallery.create') }}" class="btn btn-dark btn-sm">Upload Gambar</a>
      </div>

      <div class="card shadow-sm">
          <div class="card-body">
              <div class="row g-2">
                  @forelse ($galleries as $gallery)
                      <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                          <a href="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                             data-lightbox="roadtrip"
                             data-title="{{ $gallery->description }}">
                              <img class="img-fluid rounded mb-2"
                                   src="{{ asset('storage/posts_image/' . $gallery->picture) }}"
                                   alt="{{ $gallery->title }}">
                          </a>
                          <div class="d-flex gap-1 mb-2">
                              <a href="{{ route('gallery.edit', $gallery) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                              <form method="POST" action="{{ route('gallery.destroy', $gallery) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus gambar ini?')">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                              </form>
                          </div>
                      </div>
                  @empty
                      <div class="col-12 text-center text-muted">Tidak ada data.</div>
                  @endforelse
              </div>

              <div class="mt-3">
                  {{ $galleries->links() }}
              </div>
          </div>
      </div>
  @endsection
  ```

- `resources/views/gallery/create.blade.php` (baru)
  ```blade
  @extends('layouts.app')

  @section('title', 'Upload Gambar')

  @section('content')
      <h1 class="mb-3">Upload Gambar</h1>

      <div class="card shadow-sm" style="max-width: 640px;">
          <div class="card-body">
              <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
                  @csrf

                  <div class="mb-3">
                      <label for="title" class="form-label">Title</label>
                      <input type="text" name="title" id="title" value="{{ old('title') }}"
                          class="form-control @error('title') is-invalid @enderror">
                      @error('title')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label for="description" class="form-label">Description</label>
                      <textarea name="description" id="description" rows="5"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                      @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label for="picture" class="form-label">File input</label>
                      <input type="file" name="picture" id="picture" accept="image/*"
                          class="form-control @error('picture') is-invalid @enderror">
                      @error('picture')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-dark">Submit</button>
                      <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">Batal</a>
                  </div>
              </form>
          </div>
      </div>
  @endsection
  ```

- `resources/views/gallery/edit.blade.php` (baru, Tugas 1)
  ```blade
  @extends('layouts.app')

  @section('title', 'Edit Gambar')

  @section('content')
      <h1 class="mb-3">Edit Gambar</h1>

      <div class="card shadow-sm" style="max-width: 640px;">
          <div class="card-body">
              <form method="POST" action="{{ route('gallery.update', $post) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="mb-3">
                      <label for="title" class="form-label">Title</label>
                      <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                          class="form-control @error('title') is-invalid @enderror">
                      @error('title')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label for="description" class="form-label">Description</label>
                      <textarea name="description" id="description" rows="5"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description', $post->description) }}</textarea>
                      @error('description')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label class="form-label">Gambar saat ini</label>
                      @if ($post->picture && $post->picture !== 'noimage.png')
                          <div class="mb-2">
                              <img src="{{ asset('storage/posts_image/' . $post->picture) }}" alt="" width="120" class="rounded">
                          </div>
                      @endif
                      <label for="picture" class="form-label">Ganti Gambar (opsional)</label>
                      <input type="file" name="picture" id="picture" accept="image/*"
                          class="form-control @error('picture') is-invalid @enderror">
                      @error('picture')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>

                  <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-dark">Simpan</button>
                      <a href="{{ route('gallery.index') }}" class="btn btn-outline-secondary">Batal</a>
                  </div>
              </form>
          </div>
      </div>
  @endsection
  ```

- `resources/views/layouts/app.blade.php` — tambah menu Gallery + Lightbox includes:
  ```blade
  <li class="nav-item">
      <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}" href="{{ route('gallery.index') }}">Gallery</a>
  </li>
  ```
  Di `<head>`:
  ```blade
  <link rel="stylesheet" href="{{ asset('lightbox2/dist/css/lightbox.min.css') }}">
  ```
  Sebelum `</body>`:
  ```blade
  <script src="{{ asset('lightbox2/dist/js/lightbox-plus-jquery.min.js') }}"></script>
  ```

- `php artisan storage:link` (jika belum) — agar `storage/posts_image` dapat diakses.

**Verifikasi:** upload gambar → tersimpan di `storage/app/public/posts_image`, tampil di gallery grid, klik gambar → Lightbox2 preview; edit gambar → gambar terganti; hapus → record & file terhapus; validasi menolak file non-gambar/>~2MB.

**Commit:** `feat: gallery post dengan upload gambar dan lightbox`

---

### Branch 2 — `feature/seo-jurusan`
**Tujuan:** Implementasi Modul SEO (kolom `jurusan_seo` + `foto`, halaman list & detail jurusan, Lightbox).

**Perintah:**
```bash
php artisan make:migration add_seo_and_foto_to_jurusan_table
```

**File yang dibuat/diubah:**

- `database/migrations/<timestamp>_add_seo_and_foto_to_jurusan_table.php` (baru)
  ```php
  public function up(): void
  {
      Schema::table('jurusan', function (Blueprint $table) {
          $table->string('jurusan_seo')->nullable()->unique();
          $table->string('foto')->nullable();
      });
  }

  public function down(): void
  {
      Schema::table('jurusan', function (Blueprint $table) {
          $table->dropColumn(['jurusan_seo', 'foto']);
      });
  }
  ```

- `app/Models/Jurusan.php` — tambah `jurusan_seo`, `foto` ke `$fillable`; tambah method `photos()` (adaptasi hasMany ke Kompetensi):
  ```php
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Support\Str;

  protected $fillable = ['nama', 'kode', 'filename', 'filepath', 'jurusan_seo', 'foto'];

  // Adaptasi dari modul: photos() -> hasMany Galeri. Di prakerin, detail menampilkan Kompetensi jurusan.
  public function photos()
  {
      return $this->hasMany(Kompetensi::class, 'jurusan_id', 'id');
  }

  public function getRouteKeyName(): string
  {
      return 'jurusan_seo';
  }
  ```

- `app/Http/Controllers/JurusanController.php` — tambah method `listJurusan()` dan `detailJurusan($title)`:
  ```php
  public function listJurusan()
  {
      $jurusans = Jurusan::whereNotNull('foto')->orderBy('nama')->paginate(12);

      return view('jurusan.list', compact('jurusans'));
  }

  public function detailJurusan($title)
  {
      $jurusan = Jurusan::where('jurusan_seo', $title)->firstOrFail();
      $kompetensis = $jurusan->photos()->orderBy('id', 'desc')->paginate(6);

      return view('jurusan.detail', compact('jurusan', 'kompetensis'));
  }
  ```
  - Pada `store()` & `update()`, auto-generate slug:
    ```php
    $validated['jurusan_seo'] = \Illuminate\Support\Str::slug($validated['nama']);
    ```
    dan handle upload `foto` (nullable|image) mirip thumbnail (simpan ke `jurusan_foto`).

- `routes/web.php` — tambah:
  ```php
  Route::get('/list-jurusan', [JurusanController::class, 'listJurusan'])->name('jurusan.list');
  Route::get('/detail-jurusan/{title}', [JurusanController::class, 'detailJurusan'])->name('jurusan.detail');
  ```

- `resources/views/jurusan/list.blade.php` (baru)
  ```blade
  @extends('layouts.app')

  @section('title', 'List Jurusan')

  @section('content')
      <h1 class="mb-4">List Jurusan</h1>

      <div class="row g-3">
          @forelse ($jurusans as $jurusan)
              <div class="col-md-3">
                  <a href="{{ route('jurusan.detail', $jurusan->jurusan_seo) }}" class="text-decoration-none">
                      <div class="card h-100 shadow-sm">
                          @if ($jurusan->foto)
                              <img src="{{ asset('storage/' . $jurusan->foto) }}" class="card-img-top" alt="{{ $jurusan->nama }}" style="height: 160px; object-fit: cover;">
                          @endif
                          <div class="card-body text-center">
                              <h6 class="card-title mb-0">{{ $jurusan->nama }}</h6>
                          </div>
                      </div>
                  </a>
              </div>
          @empty
              <div class="col-12 text-center text-muted">Belum ada data.</div>
          @endforelse
      </div>

      <div class="mt-3">
          {{ $jurusans->links() }}
      </div>
  @endsection
  ```

- `resources/views/jurusan/detail.blade.php` (baru)
  ```blade
  @extends('layouts.app')

  @section('title', 'Detail Jurusan')

  @section('content')
      <section class="py-3 text-center bg-light">
          <div class="container">
              <h2>Jurusan: {{ $jurusan->nama }}</h2>
              <hr>
              <div class="row">
                  @if ($jurusan->foto)
                      <div class="col-md-4 mb-3">
                          <a href="{{ asset('storage/' . $jurusan->foto) }}" data-lightbox="image-1" data-title="{{ $jurusan->nama }}">
                              <img src="{{ asset('storage/' . $jurusan->foto) }}" style="width:200px; height:150px" class="rounded">
                          </a>
                      </div>
                  @endif
                  @foreach ($kompetensis as $kompetensi)
                      <div class="col-md-4 mb-3">
                          <div class="card h-100">
                              <div class="card-body">
                                  <h5 class="card-title">{{ $kompetensi->kode }}</h5>
                                  <p class="card-text">{{ $kompetensi->nama }}</p>
                              </div>
                          </div>
                      </div>
                  @endforeach
              </div>
              <div class="mt-3">{{ $kompetensis->links() }}</div>
          </div>
      </section>
  @endsection
  ```

- `resources/views/layouts/app.blade.php` — tambah link "List Jurusan" (opsional) di navbar dan Lightbox includes (sudah dari Branch 1; pastikan ada).

**Verifikasi:** 
- Buka `/list-jurusan` → tampil foto + nama jurusan, klik → `/detail-jurusan/{slug}`.
- Detail tampil foto (lightbox) + daftar kompetensi + pagination.
- Lightbox berfungsi (klik foto → preview).
- Slug SEO-friendly (contoh: `desain-permodelan-dan-informasi-bangunan`).

**Commit:** `feat: SEO jurusan (slug, list & detail dengan lightbox)`

---

## 4. Adaptasi Penting (Catatan untuk Eksekusi)

1. **Lightbox2**: download dari https://github.com/lokesh/lightbox2, ekstrak ke `public/lightbox2/`. Include css di `<head>` dan js sebelum `</body>` di `layouts/app.blade.php`. Path: `lightbox2/dist/css/lightbox.min.css` dan `lightbox2/dist/js/lightbox-plus-jquery.min.js`.
2. **Storage link**: `php artisan storage:link` (sekali) agar `public/storage` → `storage/app/public`.
3. **Post model**: tabel `posts` dengan kolom `title`, `description`, `picture`. Validasi `image|nullable|max:1999` (≈2MB).
4. **Nama file unik**: `uniqid() . time()` + ekstensi (sesuai modul).
5. **SEO slug**: `Str::slug($nama)` disimpan di `jurusan_seo`. Route pakai `{title}` param dan cari by `jurusan_seo`.
6. **Relasi photos()**: modul pakai hasMany Galeri (id_buku). Prakerin adaptasi ke hasMany Kompetensi (jurusan_id) — tidak perlu tabel baru.
7. **Auth/middleware**: gallery diproteksi `auth`; jurusan list/detail bisa publik atau diproteksi (rekomendasi: proteksi `auth` untuk konsistensi; atau biarkan publik untuk SEO). Catatan: jika publik, pastikan tidak expose data sensitif.
8. **Konsistensi tampilan**: semua view memakai Bootstrap (mengikuti Tahap 1–6 sebelumnya); pesan validasi Bahasa Indonesia sudah aktif.

---

## 5. Urutan Eksekusi & Dependensi

```
Branch 1 (gallery-post) ──► Branch 2 (seo-jurusan)
```

Branch 2 membutuhkan `layouts/app.blade.php` yang sudah include Lightbox (dari Branch 1) dan kolom `foto` pada jurusan.

---

## 6. Checklist Keseluruhan

- [ ] Migration `posts` berjalan
- [ ] Model `Post` dengan `$fillable`
- [ ] `GalleryController` resource (index, create, store, edit, update, destroy)
- [ ] View `gallery/index`, `gallery/create`, `gallery/edit` (Bootstrap)
- [ ] Route `gallery` dengan middleware `auth`
- [ ] Menu "Gallery" di navbar
- [ ] Lightbox2 terpasang (`public/lightbox2/` + include di layout)
- [ ] `php artisan storage:link` dijalankan
- [ ] Upload gambar berfungsi (tampil di grid + lightbox)
- [ ] Edit & hapus gallery berfungsi
- [ ] Migration `jurusan_seo` + `foto` pada `jurusan`
- [ ] Halaman `list_jurusan` (foto + nama, link ke detail)
- [ ] Halaman `detail_jurusan/{slug}` (foto lightbox + kompetensi + pagination)
- [ ] Auto-generate slug `jurusan_seo` saat create/update jurusan
- [ ] `php artisan view:cache` & uji manual sukses

---

## 7. Kredensial & Catatan Uji

- Login sebagai `admin@example.com` / `password` (gallery & jurusan dikelola admin/login).
- Pastikan folder `storage/app/public/posts_image` writable (dibuat otomatis saat upload pertama).
- Cek `public/storage` ada setelah `storage:link`.
- Uji lightbox: klik thumbnail gambar → preview besar muncul.

---

## 8. Catatan untuk Laporan (opsional)

Jika nantinya membuat laporan praktikum gallery & SEO, poin adaptasi yang layak dicatat: penggunaan `layouts.app` (bukan `auth.layouts`), proteksi route gallery dengan `auth`, adaptasi relasi `photos()` ke `Kompetensi` (karena prakerin tidak memiliki tabel Galeri terpisah), auto-generate slug `jurusan_seo` dari nama jurusan, dan integrasi Lightbox2 pada layout utama.