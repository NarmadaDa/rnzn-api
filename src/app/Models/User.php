<?php

namespace App\Models;

use App\Events\UUIDModelCreating;
use App\Models\ArticleFeedback;
use App\Models\Device;
use App\Models\Notification;
use App\Models\Preferences;
use App\Models\Profile;
use App\Models\QuickLink;
use App\Models\Role;
use App\Models\UserFeedback;
use App\Models\UserRole;
use App\Notifications\PasswordResetNotification;
use App\Notifications\PasswordUpdatedNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, Notifiable, SoftDeletes;

  /**
   * The attributes that should be cast to timestamps.
   *
   * @var array
   */
  protected $dates = ["created_at", "updated_at", "deleted_at", "approved_at"];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    "approved_at",
    "approved_by",
    "email",
    "password",
    "google_2fa_secret",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    "approved_by",
    "id",
    "password",
    "deleted_at",
    "google_2fa_secret",
  ];

  /**
   * Relationships
   */

  public function articleFeedback()
  {
    return $this->hasMany(ArticleFeedback::class, "user_id");
  }

  public function devices()
  {
    return $this->hasMany(Device::class);
  }

  public function feedback()
  {
    return $this->hasMany(UserFeedback::class, "user_id");
  }

  public function notifications()
  {
    return $this->belongsToMany(
      Notification::class,
      "user_notifications",
      "user_id",
      "notification_id"
    );
  }

  public function preferences()
  {
    return $this->hasOne(Preferences::class);
  }

  public function profile()
  {
    return $this->hasOne(Profile::class);
  }

  public function quickLinks()
  {
    return $this->hasMany(QuickLink::class);
  }

  public function userRole()
  {
    return $this->hasOne(UserRole::class);
  }

  public function userNotifications()
  {
    return $this->hasMany(UserNotification::class, "user_id", "id");
  }

  public function roles()
  {
    return $this->belongsToMany(
      Role::class,
      "user_roles",
      "user_id",
      "role_id"
    );
  }

  /**
   * Custom functions
   */

  public static function nonGuests()
  {
    return static::where("email", "LIKE", "%@%");
  }

  public function is2faReady()
  {
    return !empty($this->preferences->google_2fa_secret);
  }

  public function isAdmin()
  {
    return $this->roles()
      ->where(function ($q) {
        $q->where("slug", "admin")->orWhere("slug", "super");
      })
      ->exists();
  }

  public function isPersonnel()
  {
    return $this->roles()
      ->where("slug", "personnel")
      ->exists();
  }

  public function isFamily()
  {
    return $this->roles()
      ->where("slug", "family")
      ->exists();
  }

  public function isGuest()
  {
    return $this->roles()
      ->where("slug", "guest")
      ->exists();
  }

  public function isApproved()
  {
    return $this->approved_at != null;
  }

  public function google2FASecret()
  {
    if ($this->preferences) {
      return $this->preferences->google_2fa_secret;
    }

    return "";
  }

  public function setGoogle2FASecret($value)
  {
    if ($this->preferences) {
      $this->preferences->google_2fa_secret = $value;
    }
  }

  /**
   * Send the email verification notification.
   *
   * @return void
   */
  public function sendEmailVerificationNotification()
  {
    $this->notify(new VerifyEmail());
  }

  /**
   * Send the password reset notification.
   *
   * @return void
   */
  public function sendResetPasswordNotification($password)
  {
    $this->notify(new PasswordResetNotification($password));
  }

  /**
   * Send the password updated notification.
   *
   * @return void
   */
  public function sendPasswordUpdatedNotification()
  {
    $this->notify(new PasswordUpdatedNotification());
  }

  /**
   * The event map for the model.
   *
   * @var array
   */
  protected $dispatchesEvents = [
    "creating" => UUIDModelCreating::class,
  ];
}
