<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Masked fields
    |--------------------------------------------------------------------------
    |
    | These properties will be replaced with "[masked]",
    |   when logged via toLog or the model tracker.
    |
    */

    'masked_fields' => [
        'password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Model (Property) Tracker
    |--------------------------------------------------------------------------
    |
    | These properties will be logged when changed.
    |
    | It hooks the Observer automatically in, when listed here.
    |
    */

    'model_tracker' => [
        // Disabled by default: Either enable it using the .env key or set it to true here.
        'enabled' => env('APP_MODEL_TRACKER', false),

        // Models to track
        'models' => [
            // \App\Models\Users::class => [
            //     'name',
            //     'email',         // Email isn't changed often. Let's keep an eye on this event.
            //     'password',      // Fields like this are automatically masked
            // ],
        ],
    ],
];
