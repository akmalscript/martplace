<?php

namespace App\Models;

use App\Enums\SellerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'store_name',
        'store_description',
        'pic_name',
        'pic_phone',
        'pic_email',
        'pic_street',
        'pic_rt',
        'pic_rw',
        'pic_village',
        'pic_district',
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
            'pic_email' => 'required|email|max:255',
            'pic_street' => 'required|string|max:255',
            'pic_rt' => 'required|string|max:10',
            'pic_rw' => 'required|string|max:10',
            'pic_village' => 'required|string|max:100',
            'pic_district' => 'required|string|max:100',
            'pic_city' => 'required|string|max:100',
            'pic_province' => 'required|string|max:100',
            'pic_ktp_number' => 'required|string|max:20|unique:sellers,pic_ktp_number',
            'pic_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pic_ktp_file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
        ];
    }

    // Register new seller
    public static function register(array $data): bool
    {
        try {
            $seller = self::create($data);
            return $seller !== null;
        } catch (\Exception $e) {
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
}
