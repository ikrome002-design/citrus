<?php

return [
    'name' => 'Bank Transfer',
    'description' => 'Online / Offline Bank fund transfer',
    'bank_name' => env('BANK_TRANSFER_NAME', ''),
    'account_type' => env('BANK_TRANSFER_ACCOUNT_TYPE', ''),
    'account_name' => env('BANK_TRANSFER_ACCOUNT_NAME', ''),
    'account_number' => env('BANK_TRANSFER_ACCOUNT_NUMBER', ''),
    'bank_swift_code' => env('BANK_TRANSFER_SWIFT_CODE', ''),
    'note' => env('BANK_TRANSFER_SWIFT_NOTE', 'Choosing this option may delay the shipment of the item.'),
];
