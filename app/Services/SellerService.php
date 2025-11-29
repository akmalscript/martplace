<?php

namespace App\Services;

use App\Models\Seller;
use App\Models\User;
use App\Enums\SellerStatus;
use App\Mail\SellerApproved;
use App\Mail\SellerRejected;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class SellerService
{
    /**
     * Validation rules for seller registration (SRS-MartPlace-01)
     */
    public static function validationRules(): array
    {
        return [
            'store_name' => 'required|string|max:255',
            'store_description' => 'nullable|string|max:1000',
            'pic_name' => 'required|string|max:255',
            'pic_phone' => ['required', 'string', 'regex:/^[0-9]{11,13}$/'],
            'pic_email' => 'required|email|max:255|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/|unique:users,email',
            'password' => 'required|string|min:8|regex:/[0-9]/',
            'pic_street' => 'required|string|max:255',
            'pic_rt' => ['required', 'string', 'regex:/^[0-9]{3}$/'],
            'pic_rw' => ['required', 'string', 'regex:/^[0-9]{3}$/'],
            'pic_village' => 'required|string|max:100',
            'pic_district' => 'required|string|max:100',
            'pic_city' => 'required|string|max:100',
            'pic_province' => 'required|string|max:100',
            'pic_ktp_number' => ['required', 'string', 'regex:/^[0-9]{16}$/', 'unique:sellers,pic_ktp_number'],
            'pic_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pic_ktp_file' => 'nullable|mimes:jpeg,png,jpg,pdf|max:5120',
        ];
    }

    /**
     * Custom validation messages
     */
    public static function validationMessages(): array
    {
        return [
            'pic_phone.regex' => 'Nomor HP harus 11-13 digit angka.',
            'pic_email.regex' => 'Email harus menggunakan domain @gmail.com.',
            'pic_rt.regex' => 'RT harus 3 digit angka.',
            'pic_rw.regex' => 'RW harus 3 digit angka.',
            'pic_ktp_number.regex' => 'Nomor KTP harus tepat 16 digit angka.',
            'password.regex' => 'Password harus mengandung minimal 1 angka.',
        ];
    }

    /**
     * Register a new seller with user account (SRS-MartPlace-01)
     */
    public function register(array $data, ?UploadedFile $photoFile = null, ?UploadedFile $ktpFile = null): ?Seller
    {
        DB::beginTransaction();
        
        try {
            // Create user account for login
            $user = User::create([
                'name' => $data['pic_name'],
                'email' => $data['pic_email'],
                'password' => Hash::make($data['password']),
                'role' => 'seller',
            ]);

            // Handle file uploads
            $photoPath = null;
            $ktpPath = null;

            if ($photoFile) {
                $photoPath = $photoFile->store('sellers/photos', 'public');
            }

            if ($ktpFile) {
                $ktpPath = $ktpFile->store('sellers/ktp', 'public');
            }

            // Create seller record
            $seller = Seller::create([
                'user_id' => $user->id,
                'store_name' => $data['store_name'],
                'store_description' => $data['store_description'] ?? null,
                'pic_name' => $data['pic_name'],
                'pic_phone' => $data['pic_phone'],
                'pic_email' => $data['pic_email'],
                'password' => Hash::make($data['password']),
                'pic_street' => $data['pic_street'],
                'pic_rt' => $data['pic_rt'],
                'pic_rw' => $data['pic_rw'],
                'pic_village' => $data['pic_village'],
                'pic_district' => $data['pic_district'],
                'pic_city' => $data['pic_city'],
                'pic_province' => $data['pic_province'],
                'pic_ktp_number' => $data['pic_ktp_number'],
                'pic_photo_path' => $photoPath,
                'pic_ktp_file_path' => $ktpPath,
                'status' => SellerStatus::PENDING,
                'registered_at' => now(),
            ]);

            DB::commit();
            
            return $seller;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Seller registration failed: ' . $e->getMessage());
            
            // Clean up uploaded files if registration failed
            if (isset($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            if (isset($ktpPath)) {
                Storage::disk('public')->delete($ktpPath);
            }
            
            return null;
        }
    }

    /**
     * Approve seller registration (SRS-MartPlace-02)
     */
    public function approve(Seller $seller): bool
    {
        try {
            $seller->status = SellerStatus::ACTIVE;
            $seller->verified_at = now();
            $seller->save();

            // Send approval email notification
            $this->sendApprovalEmail($seller);

            return true;
        } catch (\Exception $e) {
            Log::error('Seller approval failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Reject seller registration (SRS-MartPlace-02)
     */
    public function reject(Seller $seller, string $reason = ''): bool
    {
        try {
            $seller->status = SellerStatus::REJECTED;
            $seller->rejected_at = now();
            $seller->rejection_reason = $reason;
            $seller->save();

            // Send rejection email notification
            $this->sendRejectionEmail($seller, $reason);

            return true;
        } catch (\Exception $e) {
            Log::error('Seller rejection failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send approval email to seller
     */
    protected function sendApprovalEmail(Seller $seller): void
    {
        try {
            Mail::to($seller->pic_email)->send(new SellerApproved($seller));
        } catch (\Exception $e) {
            Log::error('Failed to send approval email: ' . $e->getMessage());
        }
    }

    /**
     * Send rejection email to seller
     */
    protected function sendRejectionEmail(Seller $seller, string $reason): void
    {
        try {
            Mail::to($seller->pic_email)->send(new SellerRejected($seller, $reason));
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email: ' . $e->getMessage());
        }
    }

    /**
     * Get sellers with filters for admin
     */
    public function getFilteredSellers(array $filters = [], int $perPage = 20)
    {
        $query = Seller::with('user')->latest();

        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            $query->where('status', strtoupper($filters['status']));
        }

        if (!empty($filters['province'])) {
            $query->where('pic_province', $filters['province']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('store_name', 'like', "%{$search}%")
                  ->orWhere('pic_name', 'like', "%{$search}%")
                  ->orWhere('pic_email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Get active sellers for public directory
     */
    public function getActiveSellers(array $filters = [], int $perPage = 12)
    {
        $query = Seller::active()->with('products');

        if (!empty($filters['search'])) {
            $query->where('store_name', 'like', "%{$filters['search']}%");
        }

        if (!empty($filters['city'])) {
            $query->where('pic_city', $filters['city']);
        }

        if (!empty($filters['province'])) {
            $query->where('pic_province', $filters['province']);
        }

        $sortBy = $filters['sort'] ?? 'latest';
        
        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'products':
                $query->orderBy('total_products', 'desc');
                break;
            default:
                $query->latest();
        }

        return $query->paginate($perPage);
    }

    /**
     * Get unique cities from active sellers
     */
    public function getActiveCities()
    {
        return Seller::active()
            ->whereNotNull('pic_city')
            ->distinct()
            ->pluck('pic_city')
            ->sort()
            ->values();
    }

    /**
     * Get unique provinces from active sellers
     */
    public function getActiveProvinces()
    {
        return Seller::active()
            ->whereNotNull('pic_province')
            ->distinct()
            ->pluck('pic_province')
            ->sort()
            ->values();
    }
}
