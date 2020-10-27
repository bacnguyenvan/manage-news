<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable {

    use Notifiable;

    protected $table = 'admin_user';

    protected $primaryKey = 'admin_user_seq';

    protected $guard = 'admin';

    protected $guarded = [];

    protected $hidden = [];

    public function getAuthPassword() {
        return $this->password;
    }
}
