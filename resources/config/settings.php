<?php

return [
    'backup_this_server_sites' => [
        'bind' => 'backup::backup_this_server_sites',
        'type' => 'anomaly.field_type.boolean',
        'config' => [
            'default_value' => false,
        ],
    ],
    'remote_host_user' => 'anomaly.field_type.text',
    'remote_host_password' => 'anomaly.field_type.text',
    'remote_host_port' => 'anomaly.field_type.text',
    'remote_host_address' => 'anomaly.field_type.text',
];