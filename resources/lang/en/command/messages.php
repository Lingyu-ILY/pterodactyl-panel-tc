<?php

return [
    'location' => [
        'no_location_found' => '無法找到與提供的簡短代碼相符的記錄。',
        'ask_short' => '位置簡短代碼',
        'ask_long' => '位置描述',
        'created' => '已成功建立新位置 (:name)，ID 為 :id。',
        'deleted' => '已成功刪除所請求的位置。',
    ],
    'user' => [
        'search_users' => '輸入使用者名稱、使用者 ID 或電子郵件地址',
        'select_search_user' => '要刪除的使用者 ID（輸入 "0" 重新搜尋）',
        'deleted' => '使用者已成功從面板中刪除。',
        'confirm_delete' => '你確定要從面板中刪除此使用者嗎？',
        'no_users_found' => '根據提供的搜尋條件未找到任何使用者。',
        'multiple_found' => '為指定的使用者找到多個帳號，由於 --no-interaction 旗標的關係無法刪除使用者。',
        'ask_admin' => '此使用者是管理員嗎？',
        'ask_email' => '電子郵件地址',
        'ask_username' => '使用者名稱',
        'ask_name_first' => '名字',
        'ask_name_last' => '姓氏',
        'ask_password' => '密碼',
        'ask_password_tip' => '如果你想建立一個使用隨機密碼並寄送給使用者的帳號，請重新執行此指令（CTRL+C）並使用 `--no-password` 旗標。',
        'ask_password_help' => '密碼長度至少必須 8 個字元，並且至少包含一個大寫字母與數字。',
        '2fa_help_text' => [
            '此指令將停用使用者帳號的兩步驟驗證（如果已啟用）。這僅應作為帳號復原指令使用，當使用者被鎖定無法進入其帳號時。',
            '如果這不是你想做的，請按 CTRL+C 退出此程序。',
        ],
        '2fa_disabled' => '已為 :email 停用兩步驟驗證。',
    ],
    'schedule' => [
        'output_line' => '正在為 `:schedule` (:hash) 的第一個任務派發作業。',
    ],
    'maintenance' => [
        'deleting_service_backup' => '正在刪除服務備份檔案：:file。',
    ],
    'server' => [
        'rebuild_failed' => '在節點 ":node" 上對 ":name" (#:id) 的重建請求失敗，錯誤訊息：:message',
        'reinstall' => [
            'failed' => '在節點 ":node" 上對 ":name" (#:id) 的重新安裝請求失敗，錯誤訊息：:message',
            'confirm' => '你即將對一組伺服器進行重新安裝。是否要繼續？',
        ],
        'power' => [
            'confirm' => '你即將對 :count 台伺服器執行 :action 動作。是否要繼續？',
            'action_failed' => '在節點 ":node" 上對 ":name" (#:id) 的電源動作請求失敗，錯誤訊息：:message',
        ],
    ],
    'environment' => [
        'mail' => [
            'ask_smtp_host' => 'SMTP 主機（例如 smtp.gmail.com）',
            'ask_smtp_port' => 'SMTP 連接埠',
            'ask_smtp_username' => 'SMTP 使用者名稱',
            'ask_smtp_password' => 'SMTP 密碼',
            'ask_mailgun_domain' => 'Mailgun 網域',
            'ask_mailgun_endpoint' => 'Mailgun 端點',
            'ask_mailgun_secret' => 'Mailgun 密鑰',
            'ask_mandrill_secret' => 'Mandrill 密鑰',
            'ask_postmark_username' => 'Postmark API 金鑰',
            'ask_driver' => '應使用哪個驅動程式來發送電子郵件？',
            'ask_mail_from' => '電子郵件的寄件者地址',
            'ask_mail_name' => '電子郵件顯示的寄件者名稱',
            'ask_encryption' => '要使用的加密方法',
        ],
    ],
];
