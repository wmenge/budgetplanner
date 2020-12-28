<?php

return [
    'database_config' => [ 'connection_string' => 'sqlite:' . __DIR__ . '/../data/database.sqlite' ],
    'file_upload_config' => [
        'upload_directory' => __DIR__ . '/../data/uploads',
        'mime_types' => [
            'text/csv'                                                                => 'attachment'
        ],
     ]
];
