<?php

return [
    'sign_in' => '登入',
    'go_to_login' => '前往登入',
    'failed' => '找不到符合這些登入資訊的帳號。',

    'forgot_password' => [
        'label' => '忘記密碼？',
        'label_help' => '請輸入你的帳號電子郵件地址，以接收重設密碼的指示說明。',
        'button' => '恢復帳號',
    ],

    'reset_password' => [
        'button' => '重設並登入',
    ],

    'two_factor' => [
        'label' => '兩步驟驗證權杖',
        'label_help' => '此帳號需要第二層驗證才能繼續。請輸入你的裝置所產生的代碼以完成登入。',
        'checkpoint_failed' => '兩步驟驗證權杖無效。',
    ],

    'throttle' => '嘗試登入次數過多，請於 :seconds 秒後再試。',
    'password_requirements' => '密碼長度至少需 8 個字元，並建議不要與其他網站共用。',
    '2fa_must_be_enabled' => '管理員要求你的帳號必須啟用兩步驟驗證才能使用面板。',
];
