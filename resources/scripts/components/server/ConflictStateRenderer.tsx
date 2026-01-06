import React from 'react';
import { ServerContext } from '@/state/server';
import ScreenBlock from '@/components/elements/ScreenBlock';
import ServerInstallSvg from '@/assets/images/server_installing.svg';
import ServerErrorSvg from '@/assets/images/server_error.svg';
import ServerRestoreSvg from '@/assets/images/server_restore.svg';

export default () => {
    const status = ServerContext.useStoreState((state) => state.server.data?.status || null);
    const isTransferring = ServerContext.useStoreState((state) => state.server.data?.isTransferring || false);
    const isNodeUnderMaintenance = ServerContext.useStoreState(
        (state) => state.server.data?.isNodeUnderMaintenance || false
    );

    return status === 'installing' || status === 'install_failed' || status === 'reinstall_failed' ? (
        <ScreenBlock
            title={'正在執行安裝程式'}
            image={ServerInstallSvg}
            message={'您的伺服器即將準備就緒，請稍後幾分鐘再試。'}
        />
    ) : status === 'suspended' ? (
        <ScreenBlock
            title={'伺服器已暫停'}
            image={ServerErrorSvg}
            message={'此伺服器已被暫停，無法存取。'}
        />
    ) : isNodeUnderMaintenance ? (
        <ScreenBlock
            title={'節點維護中'}
            image={ServerErrorSvg}
            message={'此伺服器的節點目前正在維護中。'}
        />
    ) : (
        <ScreenBlock
            title={isTransferring ? '轉移中' : '從備份還原中'}
            image={ServerRestoreSvg}
            message={
                isTransferring
                    ? '您的伺服器正在轉移至新節點，請稍後再查看。'
                    : '您的伺服器目前正在從備份還原，請稍後幾分鐘再查看。'
            }
        />
    );
};
