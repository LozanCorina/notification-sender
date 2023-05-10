<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone',
        'phone_unreachable',
        'push_notifications_token',
    ];

    /**
     * Specifies the user's FCM token
     *
     * @return string|array
     */
    public function routeNotificationForFcm()
    {
        return $this->push_notifications_token;
    }

    /**
     * Route notifications for the Vonage channel.
     */
    public function routeNotificationForVonage(Notification $notification): string
    {
        return $this->phone;
    }


    /**
     * @return bool
     */
    public function isPhoneUnreachable(): bool
    {
        return $this->phone_unreachable;
    }

    /**
     * @return bool
     */
    public function hasPushNotificationToken(): bool
    {
        return (bool) $this->push_notifications_token;
    }

    /**
     * @return void
     */
    public function setUnreachablePhoneNumber(): void
    {
        $this->phone_unreachable = true;
        $this->save();
    }

    /**
     * @return void
     */
    public function setPushNotificationTokenNull()
    {
        $this->push_notifications_token = null;
        $this->save();
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeHasPushNotificationToken($q)
    {
        return $q->whereNotNull('push_notifications_token');
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeHasValidPhone($q)
    {
        return $q->where('phone_unreachable', false);
    }
}
