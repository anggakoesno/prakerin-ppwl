# Praktikum Pemrograman Web 2: Gallery

## Gambaran Umum
Modul ini membahas pembuatan fitur **Gallery** pada aplikasi Laravel untuk menampilkan postingan yang memiliki gambar, mengunggah gambar baru, serta mengintegrasikan plugin **Lightbox2** untuk pratinjau gambar yang interaktif.

---

## Langkah Praktikum

### 1. Membuat Model Post dan Migration-nya
Jalankan perintah Artisan berikut untuk membuat model `Post` beserta file migration-nya secara otomatis:

```bash
php artisan make:model Post --migration
```

Perintah di atas akan men-generate file pada lokasi berikut:
* `app/Models/Post.php`
* `database/migrations/2023_11_07_173731_create_posts_table.php` *(nama timestamp menyesuaikan waktu pembuatan)*

Buka file migration `create_posts_table.php` dan sesuaikan skema tabelnya menjadi seperti berikut:

```php
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title', 200);
    $table->mediumText('description')->nullable();
    $table->string('picture')->nullable();
    $table->timestamps();
});
```

Kemudian jalankan perintah berikut untuk mengeksekusi migration ke dalam database:

```bash
php artisan migrate
```

---

### 2. Membuat Controller Gallery
Jalankan perintah berikut untuk membuat resource controller `GalleryController`:

```bash
php artisan make:controller GalleryController -r
```

Buka file `app/Http/Controllers/GalleryController.php`, lalu import model `Post`:

```php
use App\Models\Post;
```

Buat query pada method `index()` untuk menampilkan data dari tabel `posts` yang memiliki gambar dan kolom gambarnya tidak kosong:

```php
public function index()
{
    $data = array(
        'id' => "posts",
        'menu' => 'Gallery',
        'galleries' => Post::where('picture', '!=', '')
            ->whereNotNull('picture')
            ->orderBy('created_at', 'desc')
            ->paginate(30)
    );

    return view('gallery.index')->with($data);
}
```

---

### 3. Membuat View Gallery
Buat folder baru bernama `gallery` di dalam direktori `resources/views/gallery`, kemudian buat file `index.blade.php` di dalamnya:

```html
@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                        @foreach ($galleries as $gallery)
                            <div class="col-sm-2">
                                <div>
                                    <a class="example-image-link" href="{{ asset('storage/posts_image/' . $gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/' . $gallery->picture) }}" alt="image-1" />
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3>Tidak ada data.</h3>
                    @endif

                    <div class="d-flex">
                        {{ $galleries->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

---

### 4. Membuat Menu & Route Gallery

#### A. Menambahkan Menu Navigasi
Buka file `resources/views/auth/layouts.blade.php` dan tambahkan item menu baru untuk halaman Gallery:

```html
<li class="nav-item">
    <a class="nav-link {{ (request()->is('gallery')) ? 'active' : '' }}" href="{{ route('gallery.index') }}">Gallery</a>
</li>
```

#### B. Membuat Route Gallery
Buka file `routes/web.php`, lalu daftarkan resource route untuk `GalleryController`:

```php
use App\Http\Controllers\GalleryController;

Route::resource('gallery', GalleryController::class);
```

---

### 5. Membuat Form Upload Gambar

#### A. Mengubah Method `create()` pada Controller
Buka `app/Http/Controllers/GalleryController.php` dan ubah method `create()` menjadi:

```php
public function create()
{
    return view('gallery.create');
}
```

#### B. Membuat View Form Upload (`create.blade.php`)
Buat file baru di `resources/views/gallery/create.blade.php`:

```html
@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Upload Gambar</div>
            <div class="card-body">
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 row">
                        <label for="title" class="col-md-4 col-form-label text-md-end text-start">Title</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" id="title" name="title">
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="description" rows="5" name="description"></textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="input-file" class="col-md-4 col-form-label text-md-end text-start">File input</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="input-file" name="picture">
                                    <label class="custom-file-label" for="input-file">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
```

#### C. Mengubah Method `store()` pada Controller
Buka `app/Http/Controllers/GalleryController.php` dan lengkapi method `store()` untuk memvalidasi serta menyimpan gambar ke storage:

```php
public function store(Request $request)
{
    $this->validate($request, [
        'title' => 'required|max:255',
        'description' => 'required',
        'picture' => 'image|nullable|max:1999'
    ]);

    if ($request->hasFile('picture')) {
        $filenameWithExt = $request->file('picture')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('picture')->getClientOriginalExtension();

        $basename = uniqid() . time();
        $smallFilename = "small_{$basename}.{$extension}";
        $mediumFilename = "medium_{$basename}.{$extension}";
        $largeFilename = "large_{$basename}.{$extension}";

        $filenameSimpan = "{$basename}.{$extension}";
        $path = $request->file('picture')->storeAs('posts_image', $filenameSimpan);
    } else {
        $filenameSimpan = 'noimage.png';
    }

    // dd($request->input());
    $post = new Post;
    $post->picture = $filenameSimpan;
    $post->title = $request->input('title');
    $post->description = $request->input('description');
    $post->save();

    return redirect('gallery')->with('success', 'Berhasil menambahkan data baru');
}
```

*(Catatan: Pastikan sudah menjalankan `php artisan storage:link` agar file pada `storage/app/public/posts_image` dapat diakses dari folder `public/storage`).*

---

### 6. Integrasi Plugin Lightbox2 untuk Tampilan Foto
1. Unduh plugin **Lightbox2** dari repositori resmi: [https://github.com/lokesh/lightbox2](https://github.com/lokesh/lightbox2)
2. Ekstrak hasil unduhan ke dalam folder `public/` proyek Laravel Anda (sehingga menjadi `public/lightbox2/`).
3. Import file CSS dan JavaScript Lightbox2 pada layout utama (`resources/views/auth/layouts.blade.php` atau `layouts/app.blade.php`):
   * Tambahkan baris berikut di dalam tag `<head>`:
     ```html
     <link rel="stylesheet" href="{{ asset('lightbox2/dist/css/lightbox.min.css') }}">
     ```
   * Tambahkan baris berikut sebelum penutup tag `</body>` (bagian import JavaScript):
     ```html
     <script src="{{ asset('lightbox2/dist/js/lightbox-plus-jquery.min.js') }}"></script>
     ```

---

## Tugas Praktikum
1. Ikuti seluruh langkah praktikum pada materi ini, kemudian buatlah fungsi **Edit** dan **Delete** untuk mengganti dan menghapus gambar pada gallery.
2. Implementasikan tema tampilan ke dalam website portofolio agar terlihat menarik.
3. Kumpulkan *source code* dengan cara *push* ke repositori Git dengan nama branch **`pertemuan_11`**.