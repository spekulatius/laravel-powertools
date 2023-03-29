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
        '/password/i',
        '/passwd/i',
        '/hash/i',
        '/checksum/i',
        '/salt/i',
        '/token/i',
        '/key/i',
        '/secret/i',
        '/acl/i',
    ],

];
