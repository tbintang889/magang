<?php


namespace App\Policies;

use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\Access\Response;
class UserPolicy
{
public function update(User $authUser, User $targetUser)
{
    return $authUser->hasRole('admin');
}}