# Dokumentasi Database - KawalDiri

Dokumentasi lengkap mengenai struktur database aplikasi KawalDiri, termasuk tabel-tabel, relasi, cara migration, dan cara berinteraksi dengan data.

---

##  Ringkasan Database

Aplikasi KawalDiri memiliki **4 tabel utama**:

1. **users** - Data pengguna dan pengaturan akun
2. **tasks** - Tugas yang dibuat oleh pengguna
3. **transactions** - Transaksi keuangan pengguna
4. **notifications** - Notifikasi sistem
5. **password_reset_tokens** - Token untuk reset password

---

## 🗃️ Struktur Tabel

### 1. Tabel `users`

**Fungsi**: Menyimpan data pengguna, profil, preferensi, dan pengaturan akun.

**Kolom**:

| Kolom | Tipe Data | Nullable | Default | Deskripsi |
|-------|-----------|----------|---------|-----------|
| `id` | BIGINT (PK) | ❌ | Auto | ID unik pengguna |
| `name` | VARCHAR | ❌ | - | Nama lengkap pengguna |
| `username` | VARCHAR | ✅ | NULL | Username (opsional) |
| `email` | VARCHAR (UNIQUE) | ❌ | - | Email pengguna (unik) |
| `email_verified_at` | TIMESTAMP | ✅ | NULL | Waktu verifikasi email |
| `password` | VARCHAR | ❌ | - | Password ter-hash |
| `phone` | VARCHAR | ✅ | NULL | Nomor telepon |
| `avatar` | INTEGER | ❌ | 1 | Nomor avatar (1-8) |
| `role` | ENUM | ❌ | 'user' | Role: 'user' atau 'admin' |
| `is_active` | BOOLEAN | ❌ | true | Status aktif pengguna |
| `theme_preference` | ENUM | ❌ | 'system' | Tema: 'light', 'dark', 'system' |
| `accent_color` | VARCHAR | ❌ | '#6366f1' | Warna aksen dashboard |
| `email_notifications` | BOOLEAN | ❌ | true | Aktifkan notifikasi email |
| `weekly_reports` | BOOLEAN | ❌ | true | Aktifkan laporan mingguan |
| `budget` | DECIMAL(15,2) | ✅ | NULL | Budget bulanan pengguna |
| `remember_token` | VARCHAR | ✅ | NULL | Token "remember me" |
| `created_at` | TIMESTAMP | ✅ | NULL | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✅ | NULL | Waktu update terakhir |

**Relasi**:
- ✅ **One to Many** dengan `tasks` (User memiliki banyak tugas)
- ✅ **One to Many** dengan `transactions` (User memiliki banyak transaksi)
- ✅ **Polymorphic** dengan `notifications` (User dapat menerima banyak notifikasi)

---

### 2. Tabel `tasks`

**Fungsi**: Menyimpan tugas/todo yang dibuat oleh pengguna untuk manajemen produktivitas.

**Kolom**:

| Kolom | Tipe Data | Nullable | Default | Deskripsi |
|-------|-----------|----------|---------|-----------|
| `id` | BIGINT (PK) | ❌ | Auto | ID unik tugas |
| `user_id` | BIGINT (FK) | ❌ | - | ID pemilik tugas |
| `title` | VARCHAR | ❌ | - | Judul tugas |
| `description` | TEXT | ✅ | NULL | Deskripsi detail tugas |
| `priority` | ENUM | ❌ | 'medium' | Prioritas: 'low', 'medium', 'high' |
| `due_date` | DATE | ❌ | - | Tanggal tenggat waktu |
| `status` | ENUM | ❌ | 'pending' | Status: 'pending', 'completed' |
| `completed_at` | TIMESTAMP | ✅ | NULL | Waktu penyelesaian tugas |
| `created_at` | TIMESTAMP | ✅ | NULL | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✅ | NULL | Waktu update terakhir |

**Foreign Key**:
- `user_id` → `users.id` (ON DELETE CASCADE)

**Index**:
- Index pada `user_id, status` (untuk query cepat filter by user & status)
- Index pada `due_date` (untuk query tugas berdasarkan deadline)

**Relasi**:
- ✅ **Belongs To** dengan `users` (Tugas dimiliki oleh satu user)

---

### 3. Tabel `transactions`

**Fungsi**: Menyimpan transaksi keuangan pengguna (pemasukan dan pengeluaran).

**Kolom**:

| Kolom | Tipe Data | Nullable | Default | Deskripsi |
|-------|-----------|----------|---------|-----------|
| `id` | BIGINT (PK) | ❌ | Auto | ID unik transaksi |
| `user_id` | BIGINT (FK) | ❌ | - | ID pemilik transaksi |
| `title` | VARCHAR | ❌ | - | Judul/deskripsi transaksi |
| `category` | VARCHAR | ❌ | - | Kategori (Makanan, Transport, Gaji, dll) |
| `type` | ENUM | ❌ | 'expense' | Tipe: 'income' atau 'expense' |
| `amount` | DECIMAL(15,2) | ❌ | - | Nominal (max 999,999,999,999.99) |
| `date` | DATE | ❌ | - | Tanggal transaksi |
| `status` | ENUM | ❌ | 'paid' | Status: 'paid' atau 'pending' |
| `created_at` | TIMESTAMP | ✅ | NULL | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✅ | NULL | Waktu update terakhir |

**Foreign Key**:
- `user_id` → `users.id` (ON DELETE CASCADE)

**Index**:
- Index pada `user_id, type` (untuk query cepat berdasarkan user & tipe)
- Index pada `date` (untuk query transaksi berdasarkan tanggal)

**Relasi**:
- ✅ **Belongs To** dengan `users` (Transaksi dimiliki oleh satu user)

---

### 4. Tabel `notifications`

**Fungsi**: Menyimpan notifikasi sistem menggunakan Laravel Notification system.

**Kolom**:

| Kolom | Tipe Data | Nullable | Default | Deskripsi |
|-------|-----------|----------|---------|-----------|
| `id` | UUID (PK) | ❌ | Auto | ID unik notifikasi |
| `type` | VARCHAR | ❌ | - | Tipe notifikasi class |
| `notifiable_type` | VARCHAR | ❌ | - | Model yang menerima notifikasi |
| `notifiable_id` | BIGINT | ❌ | - | ID model yang menerima |
| `data` | TEXT | ❌ | - | Data notifikasi (JSON) |
| `read_at` | TIMESTAMP | ✅ | NULL | Waktu notifikasi dibaca |
| `created_at` | TIMESTAMP | ✅ | NULL | Waktu pembuatan |
| `updated_at` | TIMESTAMP | ✅ | NULL | Waktu update terakhir |

**Relasi**:
- ✅ **Polymorphic Belongs To** dengan model apapun (biasanya `users`)
  - Menggunakan `notifiable_type` dan `notifiable_id`

---

### 5. Tabel `password_reset_tokens`

**Fungsi**: Menyimpan token untuk reset password pengguna.

**Kolom**:

| Kolom | Tipe Data | Nullable | Default | Deskripsi |
|-------|-----------|----------|---------|-----------|
| `email` | VARCHAR (PK) | ❌ | - | Email pengguna |
| `token` | VARCHAR | ❌ | - | Token reset password |
| `created_at` | TIMESTAMP | ✅ | NULL | Waktu pembuatan token |

---


##  Jenis Relasi

### 1. **One to Many** (1:N)

#### User → Tasks
- **Deskripsi**: Satu user dapat memiliki banyak tugas
- **Foreign Key**: `tasks.user_id` → `users.id`
- **On Delete**: CASCADE (jika user dihapus, semua tugasnya ikut terhapus)

**Contoh Query**:
```php
// Mendapatkan semua tugas dari user
$user = User::find(1);
$tasks = $user->tasks; // Collection of tasks

// Atau dengan kondisi
$pendingTasks = $user->tasks()->where('status', 'pending')->get();
```

#### User → Transactions
- **Deskripsi**: Satu user dapat memiliki banyak transaksi
- **Foreign Key**: `transactions.user_id` → `users.id`
- **On Delete**: CASCADE (jika user dihapus, semua transaksinya ikut terhapus)

**Contoh Query**:
```php
// Mendapatkan semua transaksi dari user
$user = User::find(1);
$transactions = $user->transactions; // Collection of transactions

// Atau filter berdasarkan tipe
$expenses = $user->transactions()->where('type', 'expense')->get();
```

---

### 2. **Belongs To** (N:1)

#### Task → User
- **Deskripsi**: Setiap tugas dimiliki oleh satu user
- **Foreign Key**: `tasks.user_id` → `users.id`

**Contoh Query**:
```php
// Mendapatkan pemilik tugas
$task = Task::find(1);
$owner = $task->user; // User object
```

#### Transaction → User
- **Deskripsi**: Setiap transaksi dimiliki oleh satu user
- **Foreign Key**: `transactions.user_id` → `users.id`

**Contoh Query**:
```php
// Mendapatkan pemilik transaksi
$transaction = Transaction::find(1);
$owner = $transaction->user; // User object
```

---

### 3. **Polymorphic Relation** (Many to Many - Polymorphic)

#### Notifications (Polymorphic)
- **Deskripsi**: Model notification dapat terhubung dengan model apapun
- **Kolom**: `notifiable_type` (nama model) dan `notifiable_id` (ID model)
- **Implementasi**: Menggunakan trait `Notifiable` di model User

**Contoh Query**:
```php
// Mendapatkan semua notifikasi user
$user = User::find(1);
$notifications = $user->notifications; // Collection of notifications

// Mendapatkan notifikasi yang belum dibaca
$unread = $user->unreadNotifications;

// Menandai sebagai sudah dibaca
$user->unreadNotifications->markAsRead();
```


## 💻 Cara Berinteraksi dengan Database

### 1. **Menggunakan Eloquent ORM**

Eloquent adalah ORM (Object-Relational Mapping) bawaan Laravel yang memudahkan interaksi dengan database.

#### **CREATE - Menambah Data**

```php
// Cara 1: Menggunakan create()
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password123'),
    'role' => 'user',
]);

// Cara 2: Menggunakan new + save()
$task = new Task();
$task->user_id = 1;
$task->title = 'Belajar Laravel';
$task->priority = 'high';
$task->due_date = '2026-01-10';
$task->save();

// Cara 3: Menggunakan relasi
$user = User::find(1);
$user->tasks()->create([
    'title' => 'Tugas Baru',
    'priority' => 'medium',
    'due_date' => '2026-01-15',
]);
```

---

## 🎯 Contoh Penggunaan Praktis

### 1. **Dashboard User - Menampilkan Ringkasan**

```php
// Di Controller
$user = auth()->user();

// Total transaksi bulan ini
$monthlyIncome = $user->transactions()
    ->income()
    ->thisMonth()
    ->sum('amount');

$monthlyExpense = $user->transactions()
    ->expense()
    ->thisMonth()
    ->sum('amount');

// Tugas yang harus diselesaikan
$pendingTasks = $user->tasks()
    ->pending()
    ->orderBy('due_date', 'asc')
    ->take(5)
    ->get();

// Tugas yang terlambat
$overdueTasks = $user->tasks()->overdue()->count();

return view('dashboard', compact(
    'monthlyIncome',
    'monthlyExpense',
    'pendingTasks',
    'overdueTasks'
));
```

---

### 2. **Menambah Transaksi Baru**

```php
// Di Controller
public function store(Request $request)
{
    $transaction = auth()->user()->transactions()->create([
        'title' => $request->title,
        'category' => $request->category,
        'type' => $request->type,
        'amount' => $request->amount,
        'date' => $request->date,
        'status' => 'paid',
    ]);

    return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan!');
}
```

---

### 3. **Menyelesaikan Tugas**

```php
// Di Controller
public function complete($id)
{
    $task = Task::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $task->markAsCompleted();

    return redirect()->back()->with('success', 'Tugas selesai!');
}
```

---

### 4. **Menampilkan Notifikasi**

```php
// Di Controller
$user = auth()->user();

// Notifikasi yang belum dibaca
$unread = $user->unreadNotifications;

// Semua notifikasi
$all = $user->notifications;

// Tandai notifikasi sebagai sudah dibaca
$user->unreadNotifications->markAsRead();
```

---

## 🔧 Tips & Best Practices

### 1. **Gunakan Eloquent Scope**
Scope memudahkan query yang sering digunakan. Lihat contoh di model `Task` dan `Transaction`.

### 2. **Eager Loading untuk Performa**
Selalu gunakan `with()` untuk menghindari N+1 query problem:
```php
// ❌ N+1 Problem
$tasks = Task::all();
foreach ($tasks as $task) {
    echo $task->user->name; // Query untuk setiap task!
}

// ✅ Eager Loading
$tasks = Task::with('user')->all();
foreach ($tasks as $task) {
    echo $task->user->name; // Hanya 2 query total
}
```

### 3. **Gunakan Transaction untuk Operasi Kompleks**
```php
use Illuminate\Support\Facades\DB;

DB::transaction(function () {
    $user = User::create([...]);
    $user->tasks()->create([...]);
    $user->transactions()->create([...]);
});
```

### 4. **Mass Assignment Protection**
Selalu definisikan `$fillable` di model untuk keamanan.

### 5. **Gunakan Foreign Key Constraints**
Sudah diimplementasikan dengan `->constrained()->onDelete('cascade')`.

---

## 📚 Kesimpulan

Database KawalDiri menggunakan struktur relasional dengan 4 tabel utama:
- **One to Many**: User dengan Tasks & Transactions
- **Polymorphic**: Notifications dengan User (atau model lain)
- **Cascade Delete**: Data terkait otomatis terhapus saat user dihapus

Migration memudahkan version control database, dan Eloquent ORM menyediakan interface yang intuitif untuk berinteraksi dengan data.
