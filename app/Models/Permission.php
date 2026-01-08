<?php

namespace Pterodactyl\Models;

use Illuminate\Support\Collection;

class Permission extends Model
{
    /**
     * The resource name for this model when it is transformed into an
     * API representation using fractal.
     */
    public const RESOURCE_NAME = 'subuser_permission';

    /**
     * Constants defining different permissions available.
     */
    public const ACTION_WEBSOCKET_CONNECT = 'websocket.connect';
    public const ACTION_CONTROL_CONSOLE = 'control.console';
    public const ACTION_CONTROL_START = 'control.start';
    public const ACTION_CONTROL_STOP = 'control.stop';
    public const ACTION_CONTROL_RESTART = 'control.restart';

    public const ACTION_DATABASE_READ = 'database.read';
    public const ACTION_DATABASE_CREATE = 'database.create';
    public const ACTION_DATABASE_UPDATE = 'database.update';
    public const ACTION_DATABASE_DELETE = 'database.delete';
    public const ACTION_DATABASE_VIEW_PASSWORD = 'database.view_password';

    public const ACTION_SCHEDULE_READ = 'schedule.read';
    public const ACTION_SCHEDULE_CREATE = 'schedule.create';
    public const ACTION_SCHEDULE_UPDATE = 'schedule.update';
    public const ACTION_SCHEDULE_DELETE = 'schedule.delete';

    public const ACTION_USER_READ = 'user.read';
    public const ACTION_USER_CREATE = 'user.create';
    public const ACTION_USER_UPDATE = 'user.update';
    public const ACTION_USER_DELETE = 'user.delete';

    public const ACTION_BACKUP_READ = 'backup.read';
    public const ACTION_BACKUP_CREATE = 'backup.create';
    public const ACTION_BACKUP_DELETE = 'backup.delete';
    public const ACTION_BACKUP_DOWNLOAD = 'backup.download';
    public const ACTION_BACKUP_RESTORE = 'backup.restore';

    public const ACTION_ALLOCATION_READ = 'allocation.read';
    public const ACTION_ALLOCATION_CREATE = 'allocation.create';
    public const ACTION_ALLOCATION_UPDATE = 'allocation.update';
    public const ACTION_ALLOCATION_DELETE = 'allocation.delete';

    public const ACTION_FILE_READ = 'file.read';
    public const ACTION_FILE_READ_CONTENT = 'file.read-content';
    public const ACTION_FILE_CREATE = 'file.create';
    public const ACTION_FILE_UPDATE = 'file.update';
    public const ACTION_FILE_DELETE = 'file.delete';
    public const ACTION_FILE_ARCHIVE = 'file.archive';
    public const ACTION_FILE_SFTP = 'file.sftp';

    public const ACTION_STARTUP_READ = 'startup.read';
    public const ACTION_STARTUP_UPDATE = 'startup.update';
    public const ACTION_STARTUP_DOCKER_IMAGE = 'startup.docker-image';

    public const ACTION_SETTINGS_RENAME = 'settings.rename';
    public const ACTION_SETTINGS_REINSTALL = 'settings.reinstall';

    public const ACTION_ACTIVITY_READ = 'activity.read';

    /**
     * Should timestamps be used on this model.
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     */
    protected $table = 'permissions';

    /**
     * Fields that are not mass assignable.
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * Cast values to correct type.
     */
    protected $casts = [
        'subuser_id' => 'integer',
    ];

    public static array $validationRules = [
        'subuser_id' => 'required|numeric|min:1',
        'permission' => 'required|string',
    ];

    /**
     * All the permissions available on the system. You should use self::permissions()
     * to retrieve them, and not directly access this array as it is subject to change.
     *
     * @see \Pterodactyl\Models\Permission::permissions()
     */
    protected static array $permissions = [
        'websocket' => [
            'description' => '允許使用者連線到伺服器的 websocket，讓使用者可以查看主控台輸出與即時的伺服器狀態資訊。',
            'keys' => [
                'connect' => '允許使用者連線到伺服器的 websocket 實例，以串流主控台內容。',
            ],
        ],

        'control' => [
            'description' => '控制使用者是否能操控伺服器電源狀態或發送指令的權限。',
            'keys' => [
                'console' => '允許使用者透過主控台向伺服器實例發送指令。',
                'start' => '允許使用者在伺服器停止時啟動伺服器。',
                'stop' => '允許使用者在伺服器運作中停止伺服器。',
                'restart' => '允許使用者重新啟動伺服器。這也允許使用者在伺服器離線時啟動伺服器，但不允許將伺服器切換為完全停止狀態。',
            ],
        ],

        'user' => [
            'description' => '允許使用者管理伺服器上的其他子使用者（subuser）的權限。使用者永遠無法編輯自己的帳號，也無法指派超出自己所擁有的權限。',
            'keys' => [
                'create' => '允許使用者為此伺服器建立新的子使用者（subuser）。',
                'read' => '允許使用者查看此伺服器的子使用者（subuser）及其權限。',
                'update' => '允許使用者修改其他子使用者（subuser）。',
                'delete' => '允許使用者從此伺服器刪除子使用者（subuser）。',
            ],
        ],

        'file' => [
            'description' => '控制使用者是否能修改此伺服器檔案系統的權限。',
            'keys' => [
                'create' => '允許使用者透過面板或直接上傳建立額外的檔案與資料夾。',
                'read' => '允許使用者檢視目錄內容，但不能檢視檔案內容或下載檔案。',
                'read-content' => '允許使用者檢視指定檔案的內容，這也會允許使用者下載檔案。',
                'update' => '允許使用者更新既有檔案或目錄的內容。',
                'delete' => '允許使用者刪除檔案或目錄。',
                'archive' => '允許使用者將目錄內容封存為壓縮檔，並解壓系統中既有的封存檔。',
                'sftp' => '允許使用者透過 SFTP 連線，並使用其他已指派的檔案權限來管理伺服器檔案。',
            ],
        ],

        'backup' => [
            'description' => '控制使用者是否能建立與管理伺服器備份的權限。',
            'keys' => [
                'create' => '允許使用者為此伺服器建立新的備份。',
                'read' => '允許使用者查看此伺服器現有的所有備份。',
                'delete' => '允許使用者從系統中移除備份。',
                'download' => '允許使用者下載此伺服器的備份。注意：這會讓使用者透過備份存取此伺服器的所有檔案。',
                'restore' => '允許使用者還原此伺服器的備份。注意：此過程可能會刪除伺服器上的所有檔案。',
            ],
        ],

        // Controls permissions for editing or viewing a server's allocations.
        'allocation' => [
            'description' => '控制使用者是否能修改此伺服器連接埠配置（allocation）的權限。',
            'keys' => [
                'read' => '允許使用者查看目前指派給此伺服器的所有配置。任何對此伺服器有任何層級存取權限的使用者都可以查看主要配置。',
                'create' => '允許使用者為伺服器指派額外的配置。',
                'update' => '允許使用者變更伺服器的主要配置，並為每個配置附加備註。',
                'delete' => '允許使用者從伺服器移除配置。',
            ],
        ],

        // Controls permissions for editing or viewing a server's startup parameters.
        'startup' => [
            'description' => '控制使用者是否能查看此伺服器啟動參數的權限。',
            'keys' => [
                'read' => '允許使用者查看伺服器的啟動變數。',
                'update' => '允許使用者修改伺服器的啟動變數。',
                'docker-image' => '允許使用者修改執行伺服器時所使用的 Docker 映像檔。',
            ],
        ],

        'database' => [
            'description' => '控制使用者是否能存取此伺服器資料庫管理功能的權限。',
            'keys' => [
                'create' => '允許使用者為此伺服器建立新的資料庫。',
                'read' => '允許使用者查看與此伺服器關聯的資料庫。',
                'update' => '允許使用者重設資料庫實例的密碼。若使用者沒有 view_password 權限，將不會看到更新後的密碼。',
                'delete' => '允許使用者從此伺服器移除資料庫實例。',
                'view_password' => '允許使用者查看此伺服器資料庫實例的密碼。',
            ],
        ],

        'schedule' => [
            'description' => '控制使用者是否能存取此伺服器排程管理功能的權限。',
            'keys' => [
                'create' => '允許使用者為此伺服器建立新的排程。', // task.create-schedule
                'read' => '允許使用者查看排程，以及與排程相關的任務。', // task.view-schedule, task.list-schedules
                'update' => '允許使用者更新排程並排程任務。', // task.edit-schedule, task.queue-schedule, task.toggle-schedule
                'delete' => '允許使用者刪除此伺服器的排程。', // task.delete-schedule
            ],
        ],

        'settings' => [
            'description' => '控制使用者是否能存取此伺服器設定的權限。',
            'keys' => [
                'rename' => '允許使用者重新命名此伺服器並變更其描述。',
                'reinstall' => '允許使用者觸發此伺服器的重新安裝。',
            ],
        ],

        'activity' => [
            'description' => '控制使用者是否能存取伺服器活動記錄的權限。',
            'keys' => [
                'read' => '允許使用者查看伺服器的活動記錄。',
            ],
        ],
    ];

    /**
     * Returns all the permissions available on the system for a user to
     * have when controlling a server.
     */
    public static function permissions(): Collection
    {
        return Collection::make(self::$permissions);
    }
}
