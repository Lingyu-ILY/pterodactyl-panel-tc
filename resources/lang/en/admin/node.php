<?php

return [
    'validation' => [
        'fqdn_not_resolvable' => '提供的 FQDN 或 IP 位址無法解析為有效的 IP 位址。',
        'fqdn_required_for_ssl' => '要為此節點使用 SSL，必須提供可解析為公用 IP 位址的完整網域名稱。',
    ],
    'notices' => [
        'allocations_added' => '配置（allocation）已成功新增到此節點。',
        'node_deleted' => '節點已成功從面板中移除。',
        'location_required' => '在新增節點到此面板之前，你必須至少設定一個位置。',
        'node_created' => '已成功建立新節點。你可以透過「設定」分頁自動設定此機器上的 Daemon。新增任何伺服器之前，你必須至少配置一個 IP 位址與連接埠。',
        'node_updated' => '節點資訊已更新。若有任何 Daemon 設定變更，你需要重新啟動以使變更生效。',
        'unallocated_deleted' => '已刪除 <code>:ip</code> 的所有未配置連接埠。',
    ],
];
