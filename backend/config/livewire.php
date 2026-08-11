<?php

return [
    'temporary_file_upload' => [
        'disk' => null,        // Example: 'local', 's3'              | Default: 'default'
        'rules' => 'file|mimes:png,jpg,jpeg,mp4,webm,avi,mov|max:102400', // max 100MB
        'directory' => null,   // Example: 'tmp'                      | Default: 'livewire-tmp'
        'middleware' => null,  // Example: 'throttle:5,1'             | Default: 'throttle:60,1'
        'preview_mimes' => [   // Supported file types for temporary pre-signed file URLs.
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5, // Max duration (in minutes) before an upload gets invalidated.
    ],
];
