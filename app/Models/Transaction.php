<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Transaction (Transaksi Keuangan)
 * 
 * Merepresentasikan transaksi keuangan yang dicatat oleh pengguna.
 * Setiap transaksi memiliki judul, kategori, tipe (income/expense), nominal, dan tanggal.
 * 
 * @property int $id
 * @property int $user_id - ID pemilik transaksi
 * @property string $title - Judul/deskripsi transaksi
 * @property string $category - Kategori transaksi (Makanan, Transport, dll)
 * @property string $type - Tipe: 'income' (pemasukan) atau 'expense' (pengeluaran)
 * @property float $amount - Nominal transaksi
 * @property \Carbon\Carbon $date - Tanggal transaksi
 * @property string $status - Status: 'paid' atau 'pending'
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Ini melindungi dari serangan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',   // ID pemilik transaksi
        'title',     // Judul transaksi
        'category',  // Kategori (Makanan, Transport, Gaji, dll)
        'type',      // Tipe: income atau expense
        'amount',    // Nominal dalam Rupiah
        'date',      // Tanggal transaksi
        'status',    // Status: paid atau pending
    ];

    /**
     * Casting tipe data untuk kolom tertentu.
     * Laravel akan otomatis mengkonversi ke tipe yang ditentukan.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',           // Otomatis menjadi Carbon date
        'amount' => 'decimal:2',    // Format desimal 2 digit
    ];

    /**
     * Relasi: Transaksi dimiliki oleh satu User.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Hanya transaksi pemasukan (income).
     * Penggunaan: Transaction::income()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope: Hanya transaksi pengeluaran (expense).
     * Penggunaan: Transaction::expense()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope: Hanya transaksi bulan ini.
     * Penggunaan: Transaction::thisMonth()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisMonth($query)
    {
        return $query->whereYear('date', now()->year)
            ->whereMonth('date', now()->month);
    }

    /**
     * Scope: Hanya transaksi yang sudah dibayar (paid).
     * Penggunaan: Transaction::paid()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
