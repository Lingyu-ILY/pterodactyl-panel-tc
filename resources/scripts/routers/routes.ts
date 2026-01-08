import React, { lazy } from 'react';
import ServerConsole from '@/components/server/console/ServerConsoleContainer';
import DatabasesContainer from '@/components/server/databases/DatabasesContainer';
import ScheduleContainer from '@/components/server/schedules/ScheduleContainer';
import UsersContainer from '@/components/server/users/UsersContainer';
import BackupContainer from '@/components/server/backups/BackupContainer';
import NetworkContainer from '@/components/server/network/NetworkContainer';
import StartupContainer from '@/components/server/startup/StartupContainer';
import FileManagerContainer from '@/components/server/files/FileManagerContainer';
import SettingsContainer from '@/components/server/settings/SettingsContainer';
import AccountOverviewContainer from '@/components/dashboard/AccountOverviewContainer';
import AccountApiContainer from '@/components/dashboard/AccountApiContainer';
import AccountSSHContainer from '@/components/dashboard/ssh/AccountSSHContainer';
import ActivityLogContainer from '@/components/dashboard/activity/ActivityLogContainer';
import ServerActivityLogContainer from '@/components/server/ServerActivityLogContainer';

// 各個 router 檔案本身都已適當地做了 code split — 因此上面的所有項目
// 只會在該 router 被載入時才會跟著載入。
//
// 這些特定的 lazy loaded routes 是為了避免載入伺服器儀表板中較重的頁面，
// 因為它們只會在特定情況下才需要。
const FileEditContainer = lazy(() => import('@/components/server/files/FileEditContainer'));
const ScheduleEditContainer = lazy(() => import('@/components/server/schedules/ScheduleEditContainer'));

interface RouteDefinition {
    path: string;
    // 如果傳入 undefined，此路由仍會被渲染到 router 中
    // 但不會在子導覽選單中顯示導覽連結。
    name: string | undefined;
    component: React.ComponentType;
    exact?: boolean;
}

interface ServerRouteDefinition extends RouteDefinition {
    permission: string | string[] | null;
}

interface Routes {
    // "/account" 底下可用的所有路由
    account: RouteDefinition[];
    // "/server/:id" 底下可用的所有路由
    server: ServerRouteDefinition[];
}

export default {
    account: [
        {
            path: '/',
            name: '帳號',
            component: AccountOverviewContainer,
            exact: true,
        },
        {
            path: '/api',
            name: 'API 憑證',
            component: AccountApiContainer,
        },
        {
            path: '/ssh',
            name: 'SSH 金鑰',
            component: AccountSSHContainer,
        },
        {
            path: '/activity',
            name: '活動記錄',
            component: ActivityLogContainer,
        },
    ],
    server: [
        {
            path: '/',
            permission: null,
            name: '主控台',
            component: ServerConsole,
            exact: true,
        },
        {
            path: '/files',
            permission: 'file.*',
            name: '檔案',
            component: FileManagerContainer,
        },
        {
            path: '/files/:action(edit|new)',
            permission: 'file.*',
            name: undefined,
            component: FileEditContainer,
        },
        {
            path: '/databases',
            permission: 'database.*',
            name: '資料庫',
            component: DatabasesContainer,
        },
        {
            path: '/schedules',
            permission: 'schedule.*',
            name: '排程',
            component: ScheduleContainer,
        },
        {
            path: '/schedules/:id',
            permission: 'schedule.*',
            name: undefined,
            component: ScheduleEditContainer,
        },
        {
            path: '/users',
            permission: 'user.*',
            name: '使用者',
            component: UsersContainer,
        },
        {
            path: '/backups',
            permission: 'backup.*',
            name: '備份',
            component: BackupContainer,
        },
        {
            path: '/network',
            permission: 'allocation.*',
            name: '網路',
            component: NetworkContainer,
        },
        {
            path: '/startup',
            permission: 'startup.*',
            name: '啟動',
            component: StartupContainer,
        },
        {
            path: '/settings',
            permission: ['settings.*', 'file.sftp'],
            name: '設定',
            component: SettingsContainer,
        },
        {
            path: '/activity',
            permission: 'activity.*',
            name: '活動記錄',
            component: ServerActivityLogContainer,
        },
    ],
} as Routes;
