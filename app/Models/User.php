<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'address',
        'role',
        'token',
        'applied_position',
        'notify',
        'status',
        'added_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token',
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
            'password' => 'hashed',
        ];
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function essay()
    {
        return $this->hasMany(Essay::class);
    }

    public function temp()
    {
        return $this->hasMany(TempAnswer::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class, 'user_id');
    }

    public function color()
    {
        return $this->hasOne(Color::class);
    }

    public function exam()
    {
        return $this->hasOne(Exam::class);
    }


    public function topic()
    {
        return $this->belongsToMany(Topic::class, 'topic_user')
            ->withPivot('amount', 'transaction_id', 'status')
            ->withTimestamps();
    }

    public function is_admin()
    {
        return $this->role === "S" || $this->role === "A";
    }
}
