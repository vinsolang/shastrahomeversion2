<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class ContactSubmission extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email_address',
        'project_type',
        'message',
        'ip_address',
        'user_agent',
    ];
}
