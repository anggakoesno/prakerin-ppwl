# Panduan Praktikum Pemrograman Web 2 - TRPL

## BAB X: Penggunaan SEO

### 10.1. Tujuan Pembelajaran
* **A.** Mahasiswa mampu mengenali penggunaan SEO.
* **B.** Mahasiswa mengetahui cara membuat SEO.
* **C.** Mahasiswa dapat menerapkan penggunaan SEO untuk mengakses data pada project.

---

### 10.2. Dasar Teori
Materi pada bab sebelumnya yaitu menerapkan fitur *upload image* ke *project* dan menggunakan *image* yang sudah di-*upload* untuk ditampilkan. Selain itu kita sudah belajar bagaimana membuat *form* yang berisikan *dropdown menu* yang berisikan data buku dari *database* yang dimiliki. Dan yang terakhir menerapkan kolom `galeri_seo` pada tabel galeri yang dibuat berdasarkan nama galeri yang diinputkan.

Sekarang kita akan coba membuat penggunaan SEO tersebut pada buku, agar kita dapat menampilkan detail galeri untuk setiap data buku yang dipilih. Pada pertemuan ini langsung akan diberikan tugas praktikum tanpa ada latihan, dan pengumpulan tugas sebagai ganti laporan praktikum. Untuk itu coba perhatikan baik-baik rekaman video penjelasan yang terlampir.

---

### 10.3. Tugas Praktikum

1. Silahkan buat kolom baru `buku_seo` dan `foto` pada tabel `buku`!
2. Silahkan buat halaman `list_buku` yang berisikan tampilan foto dan judul buku!
3. Silahkan buat halaman `detail_buku` yang berisikan semua galeri buku yang terkait dengan panduan berikut:

   **a) Membuat route untuk galeri buku**
   ```php
   Route::get('/detail-buku/{title}', 'BukuController@galbuku')->name('galeri.buku');
   ```
   *(Catatan: Untuk Laravel versi 8 ke atas, penulisan controller pada route umumnya menggunakan sintaks `[BukuController::class, 'galbuku']`).*

   **b) Membuat fungsi `photos()` pada model `Buku`**
   ```php
   public function photos()
   {
       return $this->hasMany('App\Galeri', 'id_buku', 'id');
   }
   ```
   *(Catatan: Pada modul tertulis `'App\Buku'`, namun secara relasi *one-to-many* ke tabel galeri merujuk pada model Galeri seperti `'App\Galeri'` atau `Galeri::class`).*

   **c) Membuat fungsi galeri buku pada controller `BukuController`**
   ```php
   public function galbuku($title)
   {
       $bukus = Buku::where('buku_seo', $title)->first();
       $galeris = $bukus->photos()->orderBy('id', 'desc')->paginate(6);
       return view('galeri-buku', compact('bukus', 'galeris'));
   }
   ```

   **d) Membuat view galeri foto (`galeri-buku.blade.php`)**
   ```html
   <section id="album" class="py-1 text-center bg-light">
       <div class="container">
           <h2>Buku: {{ $bukus->judul }}</h2>
           <hr>
           <div class="row">
               @foreach ($galeris as $data)
                   <div class="col-md-4">
                       <a href="{{ asset('images/'.$data->foto) }}" data-lightbox="image-1" data-title="{{ $data->keterangan }}">
                           <img src="{{ asset('images/'.$data->foto) }}" style="width:200px; height:150px">
                       </a>
                       <p><h5>{{ $data->nama_galeri }}</h5></p>
                   </div>
               @endforeach
           </div>
           <div>{{ $galeris->links() }}</div>
       </div>
   </section>
   ```

4. Terapkan **Lightbox** untuk menampilkan detail galeri buku dengan mengikuti langkah berikut:
   * **a)** Download plugin lightbox di <https://github.com/lokesh/lightbox2>
   * **b)** Silahkan download dan ekstrak folder `dist` pada folder `public/`
   * **c)** Menyertakan file lightbox di Laravel dengan cara:
     * Menyertakan kode berikut pada *layout* sebelum penutup tag `</head>`:
       ```html
       <link href="{{ asset('dist/css/lightbox.min.css') }}" rel="stylesheet">
       ```
     * Menyertakan kode berikut pada *layout* sebelum penutup tag `</body>`:
       ```html
       <script src="{{ asset('dist/js/lightbox-plus-jquery.min.js') }}"></script>
       ```