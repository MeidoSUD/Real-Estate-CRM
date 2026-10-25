<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'email',
        'password',
        'job_title',
        'phone',
        'profile_photo',
        'gender',
        'address',
        'role_id',
        'is_active',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Find a user by either email or employee number (e.g. 1001 or EMP-1001).
     */
    public static function findByLoginIdentifier(?string $identifier): ?self
    {
        if (empty($identifier)) {
            return null;
        }

        $identifier = trim($identifier);

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return static::where('email', strtolower($identifier))->first();
        }

        // Try exact employee_number match
        $user = static::where('employee_number', $identifier)->first();
        if ($user) {
            return $user;
        }

        // If numeric like '1001', check for 'EMP-1001'
        if (is_numeric($identifier)) {
            $user = static::where('employee_number', 'EMP-' . $identifier)->first();
            if ($user) {
                return $user;
            }
        }

        // Fallback: check email without strict filter
        return static::where('email', strtolower($identifier))->first();
    }

    /**
     * Generate a 6-digit OTP code valid for 15 minutes.
     */
    public function generateOtp(): string
    {
        $otp = (string) random_int(100000, 999999);
        $this->update([
            'otp_code' => $otp,
            'otp_expires_at' => now()->addMinutes(15),
        ]);

        return $otp;
    }

    /**
     * Verify if provided OTP matches and has not expired.
     */
    public function verifyOtp(string $otp): bool
    {
        if (empty($this->otp_code) || empty($this->otp_expires_at)) {
            return false;
        }

        if (now()->isAfter($this->otp_expires_at)) {
            return false;
        }

        return hash_equals((string) $this->otp_code, trim($otp));
    }

    /**
     * Clear OTP after successful use.
     */
    public function clearOtp(): void
    {
        $this->update([
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(PropertyOffer::class, 'created_by');
    }

    public function assignedLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}") ?: $this->email;
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo && file_exists(public_path('storage/' . $this->profile_photo))) {
            return asset('storage/' . $this->profile_photo);
        }

        $initials = strtoupper(substr($this->first_name ?: 'U', 0, 1) . substr($this->last_name ?: '', 0, 1));
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name) . "&background=8C532B&color=ffffff&bold=true";
    }

    public function hasRole(string|array $roles): bool
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->slug, $roles);
        }

        return $this->role->slug === $roles;
    }

    public function hasPermission(string $permissionSlug): bool
    {
        if (!$this->role) {
            return false;
        }

        return $this->role->hasPermissionTo($permissionSlug);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isCustomerService(): bool
    {
        return $this->hasRole('customer-service');
    }

    public function isMarketing(): bool
    {
        return $this->hasRole('marketing');
    }

    /**
     * Determine if this user is authorized to view confidential property owner contact details.
     * Admin and Customer Service (or users with specific owner contact permissions) are authorized.
     * Marketing users and general staff are NOT authorized to view owner contact details.
     */
    public function canViewOwnerContact(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->isCustomerService()) {
            return true;
        }

        return $this->hasPermission('offers.view_owner_contact') || $this->hasPermission('leads.contact_owner');
    }
}
