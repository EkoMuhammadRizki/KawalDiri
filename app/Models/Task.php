<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model Task (Tugas)
 * 
 * Merepresentasikan tugas yang dibuat oleh pengguna.
 * Setiap tugas memiliki judul, deskripsi, prioritas, tenggat waktu, dan status.
 * 
 * @property int $id
 * @property int $user_id - ID pemilik tugas
 * @property string $title - Judul tugas
 * @property string|null $description - Deskripsi tugas (opsional)
 * @property string $priority - Prioritas: 'low', 'medium', 'high'
 * @property \Carbon\Carbon $due_date - Tanggal tenggat waktu
 * @property string $status - Status: 'pending' atau 'completed'
 * @property \Carbon\Carbon|null $completed_at - Waktu penyelesaian tugas
 */
class Task extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     * Ini melindungi dari serangan mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',       // ID pemilik tugas
        'title',         // Judul tugas
        'description',   // Deskripsi tugas
        'priority',      // Prioritas: low, medium, high
        'due_date',      // Tanggal tenggat waktu
        'status',        // Status: pending atau completed
        'completed_at',  // Waktu penyelesaian
    ];

    /**
     * Casting tipe data untuk kolom tertentu.
     * Laravel akan otomatis mengkonversi ke tipe yang ditentukan.
     *
     * @var array
     */
    protected $casts = [
        'due_date' => 'date',        // Otomatis menjadi Carbon date
        'completed_at' => 'datetime', // Otomatis menjadi Carbon datetime
    ];

    /**
     * Relasi: Tugas dimiliki oleh satu User.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Hanya tugas yang masih tertunda (pending).
     * Penggunaan: Task::pending()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Hanya tugas yang sudah selesai (completed).
     * Penggunaan: Task::completed()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Hanya tugas yang sudah melewati tenggat waktu (overdue).
     * Tugas harus berstatus pending DAN due_date sudah lewat.
     * Penggunaan: Task::overdue()->get()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
            ->where('due_date', '<', now());
    }

    /**
     * Tandai tugas sebagai selesai.
     * Set status ke 'completed' dan catat waktu penyelesaian.
     * 
     * @return void
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Kembalikan tugas ke status tertunda.
     * Set status ke 'pending' dan hapus waktu penyelesaian.
     * 
     * @return void
     */
    public function markAsPending()
    {
        $this->update([
            'status' => 'pending',
            'completed_at' => null,
        ]);
    }
}
