@extends('layouts.admin')
@include('partials/admin.settings.nav', ['activeTab' => 'mail'])

@section('title')
    郵件設定
@endsection

@section('content-header')
    <h1>郵件設定<small>設定 Pterodactyl 要如何處理寄送電子郵件。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">設定</li>
    </ol>
@endsection

@section('content')
    @yield('settings::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">電子郵件設定</h3>
                </div>
                @if($disabled)
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="alert alert-info no-margin-bottom">
                                    此介面僅支援使用 SMTP 作為郵件驅動的環境。請使用 <code>php artisan p:environment:mail</code> 指令更新郵件設定，或在你的環境檔案中設定 <code>MAIL_DRIVER=smtp</code>。
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <form>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">SMTP 主機</label>
                                    <div>
                                        <input required type="text" class="form-control" name="mail:mailers:smtp:host" value="{{ old('mail:mailers:smtp:host', config('mail.mailers.smtp.host')) }}" />
                                        <p class="text-muted small">輸入用於寄送郵件的 SMTP 伺服器位址。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">SMTP 連接埠</label>
                                    <div>
                                        <input required type="number" class="form-control" name="mail:mailers:smtp:port" value="{{ old('mail:mailers:smtp:port', config('mail.mailers.smtp.port')) }}" />
                                        <p class="text-muted small">輸入用於寄送郵件的 SMTP 伺服器連接埠。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">加密</label>
                                    <div>
                                        @php
                                            $encryption = old('mail:mailers:smtp:encryption', config('mail.mailers.smtp.encryption'));
                                        @endphp
                                        <select name="mail:mailers:smtp:encryption" class="form-control">
                                            <option value="" @if($encryption === '') selected @endif>無</option>
                                            <option value="tls" @if($encryption === 'tls') selected @endif>傳輸層安全性（TLS）</option>
                                            <option value="ssl" @if($encryption === 'ssl') selected @endif>安全通訊端層（SSL）</option>
                                        </select>
                                        <p class="text-muted small">選擇寄送郵件時要使用的加密類型。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">使用者名稱 <span class="field-optional"></span></label>
                                    <div>
                                        <input type="text" class="form-control" name="mail:mailers:smtp:username" value="{{ old('mail:mailers:smtp:username', config('mail.mailers.smtp.username')) }}" />
                                        <p class="text-muted small">連線到 SMTP 伺服器時使用的使用者名稱。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">密碼 <span class="field-optional"></span></label>
                                    <div>
                                        <input type="password" class="form-control" name="mail:mailers:smtp:password"/>
                                        <p class="text-muted small">搭配 SMTP 使用者名稱使用的密碼。留空將繼續使用現有密碼。若要將密碼設為空值，請在欄位中輸入 <code>!e</code>。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <hr />
                                <div class="form-group col-md-6">
                                    <label class="control-label">寄件者信箱</label>
                                    <div>
                                        <input required type="email" class="form-control" name="mail:from:address" value="{{ old('mail:from:address', config('mail.from.address')) }}" />
                                        <p class="text-muted small">輸入所有寄出郵件所使用的寄件者電子郵件地址。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">寄件者名稱 <span class="field-optional"></span></label>
                                    <div>
                                        <input type="text" class="form-control" name="mail:from:name" value="{{ old('mail:from:name', config('mail.from.name')) }}" />
                                        <p class="text-muted small">郵件中顯示的寄件者名稱。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            {{ csrf_field() }}
                            <div class="pull-right">
                                <button type="button" id="testButton" class="btn btn-sm btn-success">測試</button>
                                <button type="button" id="saveButton" class="btn btn-sm btn-primary">儲存</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent

    <script>
        function saveSettings() {
            return $.ajax({
                method: 'PATCH',
                url: '/admin/settings/mail',
                contentType: 'application/json',
                data: JSON.stringify({
                    'mail:mailers:smtp:host': $('input[name="mail:mailers:smtp:host"]').val(),
                    'mail:mailers:smtp:port': $('input[name="mail:mailers:smtp:port"]').val(),
                    'mail:mailers:smtp:encryption': $('select[name="mail:mailers:smtp:encryption"]').val(),
                    'mail:mailers:smtp:username': $('input[name="mail:mailers:smtp:username"]').val(),
                    'mail:mailers:smtp:password': $('input[name="mail:mailers:smtp:password"]').val(),
                    'mail:from:address': $('input[name="mail:from:address"]').val(),
                    'mail:from:name': $('input[name="mail:from:name"]').val()
                }),
                headers: { 'X-CSRF-Token': $('input[name="_token"]').val() }
            }).fail(function (jqXHR) {
                showErrorDialog(jqXHR, 'save');
            });
        }

        function testSettings() {
            swal({
                type: 'info',
                title: '測試郵件設定',
                text: '點擊「測試」以開始測試。',
                showCancelButton: true,
                confirmButtonText: '測試',
                closeOnConfirm: false,
                showLoaderOnConfirm: true
            }, function () {
                $.ajax({
                    method: 'POST',
                    url: '/admin/settings/mail/test',
                    headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
                }).fail(function (jqXHR) {
                    showErrorDialog(jqXHR, 'test');
                }).done(function () {
                    swal({
                        title: '成功',
                        text: '測試郵件已成功寄出。',
                        type: 'success'
                    });
                });
            });
        }

        function saveAndTestSettings() {
            saveSettings().done(testSettings);
        }

        function showErrorDialog(jqXHR, verb) {
            console.error(jqXHR);
            var errorText = '';
            if (!jqXHR.responseJSON) {
                errorText = jqXHR.responseText;
            } else if (jqXHR.responseJSON.error) {
                errorText = jqXHR.responseJSON.error;
            } else if (jqXHR.responseJSON.errors) {
                $.each(jqXHR.responseJSON.errors, function (i, v) {
                    if (v.detail) {
                        errorText += v.detail + ' ';
                    }
                });
            }

            swal({
                title: '糟糕！',
                text: '嘗試' + verb + '郵件設定時發生錯誤：' + errorText,
                type: 'error'
            });
        }

        $(document).ready(function () {
            $('#testButton').on('click', saveAndTestSettings);
            $('#saveButton').on('click', function () {
                saveSettings().done(function () {
                    swal({
                        title: '成功',
                        text: '郵件設定已成功更新，並已重新啟動佇列工作程序以套用這些變更。',
                        type: 'success'
                    });
                });
            });
        });
    </script>
@endsection
