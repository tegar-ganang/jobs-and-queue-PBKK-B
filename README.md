# jobs-and-queue-PBKK-B
PBKK B - Teknik Informatika ITS

Muhammad Valda Rizky Nur Firdaus   (05111940000115)

Tegar Ganang Satrio Prambodo           (5025201002)

## Latar Belakang Topik
Pada aplikasi web, biasanya terdapat task yang membutuhkan waktu lama untuk dijalankan, seperti :

* manipulasi gambar yang di-upload oleh client
* konversi data dari database ke bentuk file tertentu
* pengiriman e-mail ke mail server
* menggunakan service dari third-party
* dan lainnya.

Hal ini membuat user harus menunggu beberapa lama untuk dapat melanjutkan task yang lain. Dengan job queues (antrian tugas), tasks yang memakan banyak waktu tersebut dapat dipindah ke dalam _queue_ untuk dijalankan di latar belakang. Dengan demikian _response time_-nya dapat menjadi lebih cepat.
## Konsep
![image](https://user-images.githubusercontent.com/81211647/169029439-6fc681da-4320-49e3-a122-a04f4c959030.png)

Pada Konsep ini menunjukkan perbedaan pada saat menggunakan Queue dan tidak menggunakannya. Perbedaan ini akan terlihat dari kecepatan pengaksesnya, dimana akan lebih cepat orang yang menggunakan Queue karena proses jobs akan lansung dikrjakan pada background dan pada foreground nya tetap akan berjalan untuk penginputan berikutnya.
## Persiapan dan Settingan Awal

Hal hal yang perlu diperhatikan dan harus dilakukan sebelum membuat jobs yang nantinya dapat diqueue yaitu:
1. Membuat project baru
2. Mengubah settingan pada file `.env` di bagian `QUEUE_CONNECTION=sync` menjadi `QUEUE_CONNECTION=database`.(apabila poin ini tidak dilakukan maka jobs yang telah dibuat tidak akan dikirim kedalam queue dan langsung dijalankan di foreground)
3. Terhubung dengan database aktif

![image](https://user-images.githubusercontent.com/85062827/169004441-7fcf1f69-2db6-4d62-a254-f96bd80997c8.png)

## Tutorial
### Tutorial Singkat
Tutorial ini hanya menunjukkan secara singkat bagaimana cara membuat jobs dan queue bekerja
1. Membuat queue job terlebih dahulu
digunakan sebagai lokasi dari queue yang akan dikerjakan. Diletakkan pada folder `database/migration` pada project
```
php artisan queue:table
```
sebagai contoh apabila dijalankan dan berhasil akan muncul seperti berikut

![image](https://user-images.githubusercontent.com/85062827/169006521-a9ad42bf-9e2e-4760-b6d8-3124fab6d0f0.png)

2. Melakukan pembaruan database
setelah membuat queue job, selanjutnya kita perlu melakukan pembaruan database agar dapat menerima queue job yang akan dijalankan
```
php artisan migrate
```
atau bisa juga 
``` 
php artisan migrate:fresh
```
sebagai contoh apabila dijalankan dan berhasil akan muncul seperti berikut
![image](https://user-images.githubusercontent.com/85062827/169007447-d9784a2b-3331-4374-9823-6939e62cfb27.png)
3. Membuat job
Secara default, semua jobs yang dibuat dapat dimasukkan kedalam queue disimpan dalamphp artisan make:jobdirektori `app/jobs`. Jika direktori tersebut belum ada, maka akan dibuat secara otomatis saat menjalankan perintah artisan `make:job`. Kemudian kelas kelas yang telah digenerate mengimplementasikan sebuah interface `Illuminate\Contracts\Queue\ShouldQueue`. Ini berarti jobs akan dipus kedalam queue untuk dijalankan secara asinkronus:
```
php artisan make:job contohJob
```
sebagai contoh apabila dijalankan dan berhasil akan muncul seperti berikut
![image](https://user-images.githubusercontent.com/85062827/169008549-9ee66a1c-2a92-4469-aae7-3b150d6a9a34.png)

isi dari file contohJob
```
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class contohJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo("Jobs");
    }
}

```
4. Memanggil job
Kita tambahkan route terlebih dahulu di `routes\web.php` kemudian kita coba akses
```
Route::get('contohJobs', function () {
    dispatch(new App\Jobs\contohJob);
});
```
![image](https://user-images.githubusercontent.com/85062827/169020096-74346b7e-92f9-4673-a7e7-595960fd0f06.png)

![image](https://user-images.githubusercontent.com/85062827/169009499-73606d1e-05c0-4685-8539-353e933df317.png)

![image](https://user-images.githubusercontent.com/85062827/169009731-0d44f8dc-0cc4-4555-9862-44ab6733bc25.png)
5. Menjalankan job
untuk menjalankan job kita ketikkan pada terminal
```
php artisan queue:work
```
![image](https://user-images.githubusercontent.com/85062827/169010409-8d6dbc08-ed78-430d-8672-80d26b048ae4.png)

### Tutorial Lebih Kompleks
Tutorial ini akan membahas lebih dalam dan memberikan kemungkinan yang dapat terjadi pada jobs
![image](https://user-images.githubusercontent.com/85062827/169011300-83348eb9-912d-406a-aa23-7e5d7b3f63c7.png)
1. Membuat Queue Job dan Melakukan Migrasi Database
- Membuat queue job terlebih dahulu
digunakan sebagai lokasi dari queue yang akan dikerjakan. Diletakkan pada folder `database/migration` pada project
```
php artisan queue:table
```
sebagai contoh apabila dijalankan dan berhasil akan muncul seperti berikut

![image](https://user-images.githubusercontent.com/85062827/169006521-a9ad42bf-9e2e-4760-b6d8-3124fab6d0f0.png)

- Melakukan pembaruan database
setelah membuat queue job, selanjutnya kita perlu melakukan pembaruan database agar dapat menerima queue job yang akan dijalankan
```
php artisan migrate
```
atau bisa juga 
``` 
php artisan migrate:fresh
```
sebagai contoh apabila dijalankan dan berhasil akan muncul seperti berikut
![image](https://user-images.githubusercontent.com/85062827/169007447-d9784a2b-3331-4374-9823-6939e62cfb27.png)

2. Membuat job
Disini kita akan mencoba membuat 3 macam jobs yaitu untuk pekerjaan biasa, pekerjaan error dan pekerjaan delay
Untuk membuat pekerjaan biasa dapat kita ketikkan pada project
```
php artisan make:job commonJob
```
![image](https://user-images.githubusercontent.com/85062827/169013919-c1ab9819-5125-41f7-bd71-aa776947df35.png)

Kemudian definisikan apa yang dapat dilakukan jobs pada fungsi handle. fungsi ini dipangging ketika job diproses di queue. Misal pada pekerjaan biasa:
```
public function handle()
    {
        echo("jobs");
    }
```

Untuk membuat pekerjaan yang memunculkan pesan error dapat kita ketikkan pada project
```
php artisan make:job errorJob
```
![image](https://user-images.githubusercontent.com/85062827/169014009-5824aaea-9edb-439a-b020-bc12bf426681.png)

Kemudian definisikan apa yang dapat dilakukan jobs pada fungsi handle. fungsi ini dipangging ketika job diproses di queue. Misal pada pekerjaan error:
```
public function handle()
    {
        echo("Error");
        $this->fail();
    }
```

Untuk membuat pekerjaan dengan delay waktu dapat kita ketikkan pada project
```
php artisan make:job delayJob
```
![image](https://user-images.githubusercontent.com/85062827/169014107-3db3644c-d166-4753-9970-6f04c12b626c.png)


Kemudian definisikan apa yang dapat dilakukan jobs pada fungsi handle. fungsi ini dipangging ketika job diproses di queue. Misal pada pekerjaan delay:
```
public function handle()
    {
         echo("delay");
        sleep(5);
    }
```

3. Memanggil Job
Jobs dapat dipanggil dengan melakukan dispatch pada job. misal menambah route di `routes\web.php` dan mengaksesnya
```
Route::get('common', function () {
    dispatch(new App\Jobs\commonJob);
});

Route::get('error', function () {
    dispatch(new App\Jobs\errorJob);
});

Route::get('delay', function () {
    dispatch(new App\Jobs\delayJob);
});

Route::get('langsungcommon', function () {
    dispatch_sync(new App\Jobs\commonJob);
});

Route::get('langsungerror', function () {
    dispatch_sync(new App\Jobs\errorJob);
});

Route::get('langsungdelay', function () {
    dispatch_sync(new App\Jobs\delayJob);
});

Route::get('alljob', function () {
    dispatch(new App\Jobs\commonJob);
    dispatch(new App\Jobs\errorJob)->onQueue('high');
    dispatch(new App\Jobs\delayJob)->onQueue('low');
});
```
atau dengan menambahkan jobs dan memanggilnya
```
use App\Jobs\commonJob;
```
```
commonJob::dispatch();
```

Berikut merupakan isi dari Queue job
![image](https://user-images.githubusercontent.com/85062827/169015012-8cd45106-4e7c-4b83-b0a4-e8d4d1068216.png)

Command tambahan:
- Jobs dapat dispesifikasikan lokasi databasenya dengan onConnection() seperti commonJob::dispatch()->onConnection('redis') more connection on config/queue
- Jobs juga dapat dispesifikasikan lokasi queuenya dengan onQueue()seperti commonJob::dispatch()->onQueue('Penting')
- Jika mengganti dispatch() menjadi dispatchSync() maka jobs tidak akan diqueue melainkan langsung dijalankan
- Jobs dapat ditunda dengan menambahkan delay(now()->addMinutes([number]) contoh: commonJob::dispatch()->delay(now()->addMinutes(10))

4. Menjalankan queued job
queue dijalankan dengan melakukan command berikut
```
php artisan queue:work
```
![image](https://user-images.githubusercontent.com/85062827/169016833-06b72e58-6615-4ad9-a583-0e0cb3fdb364.png)

comman ini akan terus berjalan hingga proses dihentikan secara manual atau ketika terminal dimatikan

Additional command:

- Jika mengganti isi dari job dan job masih berjalan maka harus melakukan php artisan queue:restart agar perubahan dapat dikenali worker
- Jika menjalankan php artisan queue:listen maka tidak perlu melakukan queue:restart tapi lebih lambat daripada queue:work
- Worker dapat dispesifikasikan queue yang akan dijalankanya dengan menambahkan --queue='nama_queue' contoh: php artisan queue:work --queue=high, default, low jika tidak dispesifikasikan akan menjalankan default
seperti contoh pada route kita tambahkan seperti berikut:
```
Route::get('alljob', function () {
    dispatch(new App\Jobs\commonJob);
    dispatch(new App\Jobs\errorJob)->onQueue('high');
    dispatch(new App\Jobs\delayJob)->onQueue('low');
});
```
ketika dijalankan dengan 
``` 
php artisan queue:work --queue=high,default,low
```
maka kita lihat bahwa urutan jobs yang dikerjakan yaitu errorJob, commonJob, delayJob
![image](https://user-images.githubusercontent.com/85062827/169017853-6af26556-8430-4905-9df3-4847671817d4.png)

- Untuk database langsung menambahkan nama databasenya contoh:php artisan queue:work redis

4.1 Clearing Queue Job
untuk membersihkan queue yang akan dijalankan dapat melakukan command berikut
```
php artisan queue:clear
```
![image](https://user-images.githubusercontent.com/85062827/169018265-0881989e-a247-458b-9e8d-b5b89da0874b.png)

5. Retry Failed Job
Ketika job sudah melebihi maksimal attempts yang ditentukan atau terdapat error pada jobs, maka akan dimasukan ke tabel database failed_jobs. Jika pada tabel Failed Job ada queue yang ingin coba ulang dapat melakukan command sebagai berikut
```
php artisan queue:retry [id]
```
![image](https://user-images.githubusercontent.com/85062827/169018579-69e867a8-64d0-4f5c-ac9d-01887ffd7674.png)

Additional command:

- Untuk mencoba ulang semua jobs dapat melakukan `php artisan queue:retry all`

![image](https://user-images.githubusercontent.com/85062827/169018751-50534d6f-c8f9-45f6-9baa-b72b09448a37.png)

5.1 Flushing Failed Job
Jika ingin membersihkan tabel Failed Job dapat melakukan command sebagai berikut
```
php artisan queue:forget [id]
```
![image](https://user-images.githubusercontent.com/85062827/169019011-c318c9e2-b870-46dc-9243-056b348772f2.png)

Additional command:

- Untuk menghilangkan semua job yang gagal dapat menjalankan `php artisan queue:flush`

![image](https://user-images.githubusercontent.com/85062827/169019159-5f93d2fb-0163-4f14-9399-d06e867194d1.png)

## More for Jobs
### Unique Job : Memastikan tidak ada jobs ganda pada queue
*database need to be supported with lock*
Job hanya akan dipush ke queue ketika tidak ada job dengan key yang sama pada queue tersebut jika ada maka tidak akan dipush.

untuk basic dari penggunaan jobs bisa menambahkan:
```php
<?php

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class UpdateSearchIndex implements ShouldQueue, ShouldBeUnique
{
    ...
}
```

untuk contoh penggunaan, buat sebuah file job baru bernama UniqueJob
isi dari job bisa diisikan seperti job di bawah:
```php
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TestUniqueJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $jobId = 'Job'; #digunakan untuk membuat sebuah key agar job menjadi unique

    public function __construct()
    {
        //
    }

    public function uniqueId()
    {
        return $this->jobId;
    }
   
    public function handle()
    {
        Log::info('Running job' ,['id' => $this->jobId] ); #agar mencetak log pada database
    }
}

```
Selanjutnya bisa ditambahkan pada web.php
```
Route::get('unique', function ()
{
    dispatch(new App\Jobs\TestUniqueJob);
});
```
Untuk menjalankannya, bisa dijalankan seperti langkah-langkah tutorial sebelumnya lalu dijalankan untuk UniqueJob 

selanjutnya bisa dijalankan jobs pada aplikasi peramban masing masing
![image](https://user-images.githubusercontent.com/81211647/169036314-c3619ff4-cdda-4b10-a0df-2350b6f1746d.png)
terlihat jika pada gambar, yang tercatat hanya 1 log saja dari semua job yang dijalankan

### Job Middleware : Membuat Custom Logic
Jika ingin menambahkan logic sendiri maka laravel tidak mespesifikasikan path dan dapat bebas membuat pathnya misalnya `App\Middleware` atau `App\Jobs\Middleware`. Setelah membut middleware, jangan lupa menambahkannya secara manual di job class, misal :
```php
use App\Jobs\Middleware\RateLimited;

public function middleware()
{
    return [new RateLimited];
}
```

### Job Chaining : Membuat Job yang berjalan urut
Job Chaining dilakukan ketika job yang dilakukan harus urut dan jika ada bagian yang gagal maka job dalam chain tidak akan dilakukan. Untuk menjalankan job chain, menggunkan method `chain` dan facade `Bus`. Misal :

```php
use App\Jobs\Job1;
use App\Jobs\Job2;
use App\Jobs\Job4;
use Illuminate\Support\Facades\Bus;

Bus::chain([
    new Job1,
    new Job2,
    new Job4,
])->dispatch();
```

### Jobs Batching : membuat Jobs yang dapat dilacak
Fitur ini memungkinkan mengjalankan batch dan melakukan aksi ketika batch sudah selesai dilakukan

#### 1 : Membuat Table Batch
Perlu membuat tablenya telebih dahulu
```
php artisan queue:batches-table

php artisan migrate
```

#### 2 : Create Batch
Perlu menambahkan`Illuminate\Bus\Batchable` dan dalam class `use Batchable`

#### 3 : Dispatch Batch
Sebagai contoh:
```php
use App\Jobs\ImportCsv;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

$batch = Bus::batch([
    new ImportCsv(1, 100),
    new ImportCsv(101, 200),
    new ImportCsv(201, 300),
    new ImportCsv(301, 400),
    new ImportCsv(401, 500),
])->then(function (Batch $batch) {
    // All jobs completed successfully...
})->catch(function (Batch $batch, Throwable $e) {
    // First batch job failure detected...
})->finally(function (Batch $batch) {
    // The batch has finished executing...
})->dispatch();

return $batch->id;
```

