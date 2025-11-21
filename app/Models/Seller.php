<?php

namespace App\Models;

use App\Enums\SellerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'store_name',
        'store_description',
        'pic_name',
        'pic_phone',
        'pic_email',
        'pic_street',
        'pic_rt',
        'pic_rw',
        'pic_village',
        'pic_city',
        'pic_province',
        'pic_ktp_number',
        'pic_photo_path',
        'pic_ktp_file_path',
        'status',
    ];

    protected $casts = [
        'status' => SellerStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'PENDING',
    ];

    // Validation rules
    public static function validationRules(): array
    {
        return [
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string',
            'pic_name' => 'required|string|max:255',
            'pic_phone' => 'required|string|max:20',
            // Ensure email is unique in users table to avoid creation errors
            'pic_email' => 'required|email|max:255|unique:users,email',
            'pic_street' => 'required|string|max:255',
            'pic_rt' => 'required|string|max:10',
            'pic_rw' => 'required|string|max:10',
            'pic_village' => 'required|string|max:100',
            'pic_city' => 'required|string|max:100',
            'pic_province' => 'required|string|max:100',
            'pic_ktp_number' => 'required|string|max:20|unique:sellers,pic_ktp_number',
            'pic_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pic_ktp_file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
        ];
    }

    // Register new seller with a corresponding User account
    public static function register(array $data): bool
    {
        DB::beginTransaction();
        try {
            // 1. Create new User for login
            $user = User::create([
                'name' => $data['pic_name'],
                'email' => $data['pic_email'],
                'password' => Hash::make($data['password']),
                // 'role' => 'seller', // Uncomment if you use a role column
            ]);

            // 2. Add user_id to seller data for relationship
            $data['user_id'] = $user->id;

            // 3. Create Seller record
            $seller = self::create($data);

            DB::commit();
            return $seller !== null;
        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: Log error for debugging
            // \Illuminate\Support\Facades\Log::error('Seller Register Error: ' . $e->getMessage());
            return false;
        }
    }

    // Cancel/Reject seller
    public function batal(): bool
    {
        try {
            $this->status = SellerStatus::REJECTED;
            return $this->save();
        } catch (\Exception $e) {
            return false;
        }
    }

    // Approve seller
    public function approve(): bool
    {
        try {
            $this->status = SellerStatus::ACTIVE;
            return $this->save();
        } catch (\Exception $e) {
            return false;
        }
    }

    // Check if seller is pending
    public function isPending(): bool
    {
        return $this->status === SellerStatus::PENDING;
    }

    // Check if seller is active
    public function isActive(): bool
    {
        return $this->status === SellerStatus::ACTIVE;
    }

    // Check if seller is rejected
    public function isRejected(): bool
    {
        return $this->status === SellerStatus::REJECTED;
    }

    // Custom validation method
    public function validate(): bool
    {
        return !empty($this->store_name)
            && !empty($this->pic_name)
            && !empty($this->pic_email)
            && filter_var($this->pic_email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Convert to array
    public function toArray(): array
    {
        return parent::toArray();
    }

    // Relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
