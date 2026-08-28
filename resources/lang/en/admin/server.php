<?php

return [
    'exceptions' => [
        'no_new_default_allocation' => '你正在嘗試刪除此伺服器的預設配置（allocation），但沒有可用的替代配置。',
        'marked_as_failed' => '此伺服器被標記為先前安裝失敗。在此狀態下無法切換目前狀態。',
        'skipping_install_script' => '這台伺服器已設定為略過其 Egg 的安裝腳本。在停用此設定之前，無法使用重新安裝功能。',
        'bad_variable' => ':name 變數驗證時發生錯誤。',
        'daemon_exception' => '嘗試與 Daemon 通訊時發生例外狀況，導致回傳 HTTP/:code 狀態碼。此例外已被記錄。（request id: :request_id）',
        'default_allocation_not_found' => '在此伺服器的配置（allocation）中找不到所請求的預設配置。',
    ],
    'alerts' => [
        'startup_changed' => '此伺服器的啟動設定已更新。若此伺服器的 Nest 或 Egg 已變更，現在將開始重新安裝。',
        'server_deleted' => '伺服器已成功從系統中刪除。',
        'server_created' => '伺服器已成功在面板中建立。請給 Daemon 幾分鐘時間以完成伺服器安裝。',
        'build_updated' => '此伺服器的建置細節已更新。部分變更可能需要重新啟動才能生效。',
        'suspension_toggled' => '伺服器停權狀態已變更為 :status。',
        'rebuild_on_boot' => '此伺服器已被標記為需要重建 Docker 容器。這會在下次啟動伺服器時進行。',
        'install_toggled' => '此伺服器的安裝狀態已切換。',
        'server_reinstalled' => '此伺服器已排入重新安裝佇列，將立即開始。',
        'details_updated' => '伺服器詳細資訊已成功更新。',
        'docker_image_updated' => '已成功變更此伺服器所使用的預設 Docker 映像檔。需要重新啟動才能套用此變更。',
        'node_required' => '在新增伺服器到此面板之前，你必須至少設定一個節點。',
        'transfer_nodes_required' => '在轉移伺服器之前，你必須至少設定兩個節點。',
        'transfer_started' => '伺服器轉移已開始。',
        'transfer_not_viable' => '你所選的節點沒有足夠的磁碟空間或記憶體來容納此伺服器。',
    ],
];
