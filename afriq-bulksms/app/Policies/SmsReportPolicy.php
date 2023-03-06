<?php

namespace App\Policies;

use App\Models\SmsReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SmsReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view sms reports');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsReport  $smsReport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, SmsReport $smsReport)
    {
        return $user->can('view sms report details');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsReport  $smsReport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, SmsReport $smsReport)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsReport  $smsReport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, SmsReport $smsReport)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsReport  $smsReport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, SmsReport $smsReport)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\SmsReport  $smsReport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, SmsReport $smsReport)
    {
        //
    }
}
