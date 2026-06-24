import React, { useCallback, useEffect, useState } from 'react';
import getFileContents from '@/api/server/files/getFileContents';
import { httpErrorToHuman } from '@/api/http';
import SpinnerOverlay from '@/components/elements/SpinnerOverlay';
import saveFileContents from '@/api/server/files/saveFileContents';
import FileManagerBreadcrumbs from '@/components/server/files/FileManagerBreadcrumbs';
import { useHistory, useLocation, useParams } from 'react-router';
import FileNameModal from '@/components/server/files/FileNameModal';
import Can from '@/components/elements/Can';
import FlashMessageRender from '@/components/FlashMessageRender';
import PageContentBlock from '@/components/elements/PageContentBlock';
import { ServerError } from '@/components/elements/ScreenBlock';
import tw from 'twin.macro';
import Button from '@/components/elements/Button';
import Select from '@/components/elements/Select';
import modes from '@/modes';
import useFlash from '@/plugins/useFlash';
import { ServerContext } from '@/state/server';
import ErrorBoundary from '@/components/elements/ErrorBoundary';
import { encodePathSegments, hashToPath } from '@/helpers';
import { dirname } from 'pathe';
import CodemirrorEditor from '@/components/elements/CodemirrorEditor';

const getNewFileDraftKey = (uuid: string, directory: string) => `pterodactyl:new-file:${uuid}:${directory}`;

export default () => {
    const [error, setError] = useState('');
    const { action } = useParams<{ action: 'new' | string }>();
    const [loading, setLoading] = useState(action === 'edit');
    const [content, setContent] = useState('');
    const [modalVisible, setModalVisible] = useState(false);
    const [mode, setMode] = useState('text/plain');

    const history = useHistory();
    const { hash } = useLocation();

    const id = ServerContext.useStoreState((state) => state.server.data!.id);
    const uuid = ServerContext.useStoreState((state) => state.server.data!.uuid);
    const setDirectory = ServerContext.useStoreActions((actions) => actions.files.setDirectory);
    const { addError, clearFlashes } = useFlash();

    const filePath = hashToPath(hash);
    const directory = action === 'new' ? filePath : dirname(filePath);
    const draftKey = action === 'new' ? getNewFileDraftKey(uuid, directory) : undefined;
    const saveDraft = useCallback(
        (value: string) => {
            if (!draftKey) return;

            if (value.length > 0) {
                sessionStorage.setItem(draftKey, value);
            } else {
                sessionStorage.removeItem(draftKey);
            }
        },
        [draftKey]
    );

    let fetchFileContent: null | (() => Promise<string>) = null;

    useEffect(() => {
        setDirectory(directory);
    }, [directory, setDirectory]);

    useEffect(() => {
        if (!draftKey) return;

        setContent(sessionStorage.getItem(draftKey) || '');
    }, [draftKey]);

    useEffect(() => {
        if (action === 'new') return;

        setError('');
        setLoading(true);
        getFileContents(uuid, filePath)
            .then(setContent)
            .catch((error) => {
                console.error(error);
                setError(httpErrorToHuman(error));
            })
            .then(() => setLoading(false));
    }, [action, uuid, filePath]);

    const save = async (name?: string) => {
        if (!fetchFileContent) {
            return;
        }

        setLoading(true);
        clearFlashes('files:view');

        let redirecting = false;

        try {
            const content = await fetchFileContent();

            await saveFileContents(uuid, name || filePath, content);

            if (name) {
                if (draftKey) {
                    sessionStorage.removeItem(draftKey);
                }

                history.push(`/server/${id}/files/edit#/${encodePathSegments(name)}`);
                redirecting = true;
                return;
            }
        } catch (error) {
            console.error(error);
            addError({ message: httpErrorToHuman(error), key: 'files:view' });
        } finally {
            if (!redirecting) {
                setLoading(false);
            }
        }
    };

    if (error) {
        return <ServerError message={error} onBack={() => history.goBack()} />;
    }

    return (
        <PageContentBlock>
            <FlashMessageRender byKey={'files:view'} css={tw`mb-4`} />
            <ErrorBoundary>
                <div css={tw`mb-4`}>
                    <FileManagerBreadcrumbs withinFileEditor isNewFile={action !== 'edit'} />
                </div>
            </ErrorBoundary>
            {hash.replace(/^#/, '').endsWith('.pteroignore') && (
                <div css={tw`mb-4 p-4 border-l-4 bg-neutral-900 rounded border-cyan-400`}>
                    <p css={tw`text-neutral-300 text-sm`}>
                        您正在編輯 <code css={tw`font-mono bg-black rounded py-px px-1`}>.pteroignore</code>{' '}
                        檔案。此處列出的任何檔案或目錄將排除在備份之外。支援使用星號（<code css={tw`font-mono bg-black rounded py-px px-1`}>*</code>）作為萬用字元。您可以在開頭加上驚嘆號（
                        <code css={tw`font-mono bg-black rounded py-px px-1`}>!</code>）來否定之前的規則。
                    </p>
                </div>
            )}
            <FileNameModal
                visible={modalVisible}
                onDismissed={() => setModalVisible(false)}
                onFileNamed={(name) => {
                    setModalVisible(false);
                    save(name);
                }}
            />
            <div css={tw`relative`}>
                <SpinnerOverlay visible={loading} />
                <CodemirrorEditor
                    mode={mode}
                    filename={hash.replace(/^#/, '')}
                    onModeChanged={setMode}
                    initialContent={content}
                    fetchContent={(value) => {
                        fetchFileContent = value;
                    }}
                    onContentSaved={() => {
                        if (action !== 'edit') {
                            setModalVisible(true);
                        } else {
                            save();
                        }
                    }}
                    onContentChanged={action === 'new' ? saveDraft : undefined}
                />
            </div>
            <div css={tw`flex justify-end mt-4`}>
                <div css={tw`flex-1 sm:flex-none rounded bg-neutral-900 mr-4`}>
                    <Select value={mode} onChange={(e) => setMode(e.currentTarget.value)}>
                        {modes.map((mode) => (
                            <option key={`${mode.name}_${mode.mime}`} value={mode.mime}>
                                {mode.name}
                            </option>
                        ))}
                    </Select>
                </div>
                {action === 'edit' ? (
                    <Can action={'file.update'}>
                        <Button css={tw`flex-1 sm:flex-none`} onClick={() => save()}>
                            儲存內容
                        </Button>
                    </Can>
                ) : (
                    <Can action={'file.create'}>
                        <Button css={tw`flex-1 sm:flex-none`} onClick={() => setModalVisible(true)}>
                            建立檔案
                        </Button>
                    </Can>
                )}
            </div>
        </PageContentBlock>
    );
};
