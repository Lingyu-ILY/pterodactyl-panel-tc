<?php

return [
    'daemon_connection_failed' => '嘗試與 Daemon 通訊時發生例外狀況，導致回傳 HTTP/:code 狀態碼。此例外已被記錄。',
    'node' => [
        'servers_attached' => '節點必須沒有任何已連結的伺服器才能刪除。',
        'daemon_off_config_updated' => 'Daemon 設定<strong>已更新</strong>，但在嘗試自動更新 Daemon 上的設定檔時發生錯誤。你需要手動更新 Daemon 的設定檔（config.yml）以套用這些變更。',
    ],
    'allocations' => [
        'server_using' => '目前有伺服器指派使用此配置（allocation）。只有在沒有任何伺服器指派使用時，才可以刪除此配置。',
        'too_many_ports' => '不支援在單一範圍內一次新增超過 1000 個連接埠。',
        'invalid_mapping' => '提供給 :port 的對應（mapping）無效，無法處理。',
        'cidr_out_of_range' => 'CIDR 表示法僅允許 /25 到 /32 之間的遮罩。',
        'port_out_of_range' => '配置（allocation）中的連接埠必須大於 1024 且小於或等於 65535。',
    ],
    'nest' => [
        'delete_has_servers' => '有啟用中伺服器連結的 Nest 無法從面板中刪除。',
        'egg' => [
            'delete_has_servers' => '有啟用中伺服器連結的 Egg 無法從面板中刪除。',
            'invalid_copy_id' => '用於複製腳本的 Egg 不存在，或該 Egg 本身也正在複製腳本。',
            'must_be_child' => '此 Egg 的「複製設定來源」指示必須是所選 Nest 的子選項。',
            'has_children' => '此 Egg 是一個或多個其他 Egg 的父層。請先刪除那些 Egg，再刪除此 Egg。',
        ],
        'variables' => [
            'env_not_unique' => '環境變數 :name 必須在此 Egg 中保持唯一。',
            'reserved_name' => '環境變數 :name 受到保護，不能指派給變數。',
            'bad_validation_rule' => '驗證規則「:rule」不是此應用程式可用的有效規則。',
        ],
        'importer' => [
            'json_error' => '嘗試解析 JSON 檔案時發生錯誤：:error。',
            'file_error' => '提供的 JSON 檔案無效。',
            'invalid_json_provided' => '提供的 JSON 檔案格式無法辨識。',
        ],
    ],
    'subusers' => [
        'editing_self' => '不允許編輯你自己的子使用者（subuser）帳號。',
        'user_is_owner' => '你不能將伺服器擁有者新增為此伺服器的子使用者（subuser）。',
        'subuser_exists' => '使用該電子郵件地址的使用者已被指派為此伺服器的子使用者（subuser）。',
    ],
    'databases' => [
        'delete_has_databases' => '無法刪除仍有啟用中資料庫連結的資料庫主機。',
    ],
    'tasks' => [
        'chain_interval_too_long' => '串連任務（chained task）的最大間隔時間為 15 分鐘。',
    ],
    'locations' => [
        'has_nodes' => '無法刪除仍有啟用中節點連結的位置。',
    ],
    'users' => [
        'node_revocation_failed' => '無法撤銷 <a href=":link">節點 #:node</a> 的金鑰。:error',
    ],
    'deployment' => [
        'no_viable_nodes' => '找不到符合自動部署需求的節點。',
        'no_viable_allocations' => '找不到符合自動部署需求的配置（allocation）。',
    ],
    'api' => [
        'resource_not_found' => '請求的資源在此伺服器上不存在。',
    ],
];
