<?php

return [
    'notices' => [
        'created' => '新的 Nest :name 已成功建立。',
        'deleted' => '已成功從面板中刪除所請求的 Nest。',
        'updated' => '已成功更新 Nest 設定選項。',
    ],
    'eggs' => [
        'notices' => [
            'imported' => '已成功匯入此 Egg 及其相關變數。',
            'updated_via_import' => '已使用提供的檔案更新此 Egg。',
            'deleted' => '已成功從面板中刪除所請求的 Egg。',
            'updated' => 'Egg 設定已成功更新。',
            'script_updated' => 'Egg 安裝腳本已更新，將在安裝伺服器時執行。',
            'egg_created' => '新的 Egg 已成功建立。你需要重新啟動任何正在運作的 Daemon 以套用此新 Egg。',
        ],
    ],
    'variables' => [
        'notices' => [
            'variable_deleted' => '變數「:variable」已刪除，一旦重建後將不再可用於伺服器。',
            'variable_updated' => '變數「:variable」已更新。你需要重建任何使用此變數的伺服器以套用變更。',
            'variable_created' => '新變數已成功建立並指派給此 Egg。',
        ],
    ],
];
