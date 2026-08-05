<?php

return [
    // Your Lockally API key. lk_test_ keys run the full pipeline without sending
    // real mail (sandbox); lk_live_ keys send for real. There is no separate
    // sandbox URL — the mode is implied by the key prefix.
    'api_key' => env('LOCKALLY_API_KEY'),

    // Optional API base URL override (defaults to https://api.lockally.com).
    'base_url' => env('LOCKALLY_BASE_URL'),
];
