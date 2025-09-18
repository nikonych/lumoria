<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait Userstamps
{
    /**
     * The "booting" method of the model.
     * This method is called when the model is first booted, and it's the
     * perfect place to register our model event listeners.
     */
    protected static function bootUserstamps(): void
    {
        // Listener for the "creating" event.
        // This will be triggered only once, when a new record is created.
        static::creating(function ($model) {
            // Check if a user is authenticated
            if (Auth::check()) {
                // Set the creator and updater to the current user's ID
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        // Listener for the "updating" event.
        // This will be triggered every time an existing record is saved.
        static::updating(function ($model) {
            // Check if a user is authenticated
            if (Auth::check()) {
                // Set the updater to the current user's ID
                $model->updated_by = Auth::id();
            }
        });
    }
}
