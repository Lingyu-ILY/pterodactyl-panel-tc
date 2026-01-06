@extends('layouts.admin')

@section('title')
    Nests &rarr; Egg：{{ $egg->name }}
@endsection

@section('content-header')
    <h1>{{ $egg->name }}<small>{{ str_limit($egg->description, 50) }}</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li><a href="{{ route('admin.nests') }}">Nests</a></li>
        <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}">{{ $egg->nest->name }}</a></li>
        <li class="active">{{ $egg->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li class="active"><a href="{{ route('admin.nests.egg.view', $egg->id) }}">設定</a></li>
                <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}">變數</a></li>
                <li><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}">安裝腳本</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" enctype="multipart/form-data" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-danger">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group no-margin-bottom">
                                <label for="pName" class="control-label">Egg 檔案</label>
                                <div>
                                    <input type="file" name="import_file" class="form-control" style="border: 0;margin-left:-10px;" />
                                    <p class="text-muted small no-margin-bottom">如果您想透過上傳新的 JSON 檔案來取代此 Egg 的設定，只需在此選擇它並按下「更新 Egg」。這不會變更現有伺服器的任何現有啟動字串或 Docker 鏡像。</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            {!! csrf_field() !!}
                            <button type="submit" name="_method" value="PUT" class="btn btn-sm btn-danger pull-right">更新 Egg</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('admin.nests.egg.view', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">設定</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pName" class="control-label">名稱 <span class="field-required"></span></label>
                                <input type="text" id="pName" name="name" value="{{ $egg->name }}" class="form-control" />
                                <p class="text-muted small">用作此 Egg 識別碼的簡單易讀名稱。</p>
                            </div>
                            <div class="form-group">
                                <label for="pUuid" class="control-label">UUID</label>
                                <input type="text" id="pUuid" readonly value="{{ $egg->uuid }}" class="form-control" />
                                <p class="text-muted small">這是此 Egg 的全域唯一識別碼，守護程式使用它作為識別碼。</p>
                            </div>
                            <div class="form-group">
                                <label for="pAuthor" class="control-label">作者</label>
                                <input type="text" id="pAuthor" readonly value="{{ $egg->author }}" class="form-control" />
                                <p class="text-muted small">此版本 Egg 的作者。從不同作者上傳新的 Egg 設定將變更此項。</p>
                            </div>
                            <div class="form-group">
                                <label for="pDockerImage" class="control-label">Docker 鏡像 <span class="field-required"></span></label>
                                <textarea id="pDockerImages" name="docker_images" class="form-control" rows="4">{{ implode(PHP_EOL, $images) }}</textarea>
                                <p class="text-muted small">
                                    使用此 Egg 的伺服器可用的 Docker 鏡像。每行輸入一個。如果提供多於一個值，
                                    使用者將能夠從此鏡像清單中選擇。可選擇性地，可以透過在鏡像前加上名稱，
                                    然後是管道字元，然後是鏡像 URL 來提供顯示名稱。範例：<code>顯示名稱|ghcr.io/my/egg</code>
                                </p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" @if($egg->force_outgoing_ip) checked @endif />
                                    <label for="pForceOutgoingIp" class="strong">強制對外 IP</label>
                                    <p class="text-muted small">
                                        強制所有對外網路流量將其來源 IP NAT 為伺服器主要分配 IP 的 IP。
                                        當節點擁有多個公網 IP 位址時，某些遊戲需要此設定才能正常運作。
                                        <br>
                                        <strong>
                                            啟用此選項將禁用使用此 Egg 的所有伺服器的內部網路，
                                            導致它們無法在內部存取同一節點上的其他伺服器。
                                        </strong>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pDescription" class="control-label">描述</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ $egg->description }}</textarea>
                                <p class="text-muted small">此 Egg 的描述，將在需要時在整個面板中顯示。</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">啟動命令 <span class="field-required"></span></label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="8">{{ $egg->startup }}</textarea>
                                <p class="text-muted small">使用此 Egg 的新伺服器應使用的預設啟動命令。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">程序管理</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-warning">
                                <p>除非您了解此系統的運作方式，否則不應編輯以下設定選項。如果錯誤修改，守護程式可能會損壞。</p>
                                <p>除非您從「從以下選項複製設定」下拉選單中選擇其他選項，否則所有欄位都是必填的，在這種情況下，欄位可以留空以使用該 Egg 的值。</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">從以下選項複製設定</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">無</option>
                                    @foreach($egg->nest->eggs as $o)
                                        <option value="{{ $o->id }}" {{ ($egg->config_from !== $o->id) ?: 'selected' }}>{{ $o->name }} &lt;{{ $o->author }}&gt;</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">如果您想要預設使用其他 Egg 的設定，請從上面的選單中選擇。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">停止命令</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ $egg->config_stop }}" />
                                <p class="text-muted small">應發送給伺服器程序以正常停止它們的命令。如果您需要發送 <code>SIGINT</code>，您應輸入 <code>^C</code>。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">日誌設定</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ ! is_null($egg->config_logs) ? json_encode(json_decode($egg->config_logs), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">這應該是日誌檔案儲存位置的 JSON 表示，以及守護程式是否應建立自訂日誌。</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">設定檔案</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ ! is_null($egg->config_files) ? json_encode(json_decode($egg->config_files), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">這應該是要修改的設定檔案和應變更部分的 JSON 表示。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">啟動設定</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ ! is_null($egg->config_startup) ? json_encode(json_decode($egg->config_startup), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '' }}</textarea>
                                <p class="text-muted small">這應該是守護程式在啟動伺服器時應尋找的值的 JSON 表示，以確定完成。</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary btn-sm pull-right">儲存</button>
                    <a href="{{ route('admin.nests.egg.export', $egg->id) }}" class="btn btn-sm btn-info pull-right" style="margin-right:10px;">匯出</a>
                    <button id="deleteButton" type="submit" name="_method" value="DELETE" class="btn btn-danger btn-sm muted muted-hover">
                        <i class="fa fa-trash-o"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pConfigFrom').select2();
    $('#deleteButton').on('mouseenter', function (event) {
        $(this).find('i').html(' 刪除 Egg');
    }).on('mouseleave', function (event) {
        $(this).find('i').html('');
    });
    $('textarea[data-action="handle-tabs"]').on('keydown', function(event) {
        if (event.keyCode === 9) {
            event.preventDefault();

            var curPos = $(this)[0].selectionStart;
            var prepend = $(this).val().substr(0, curPos);
            var append = $(this).val().substr(curPos);

            $(this).val(prepend + '    ' + append);
        }
    });
    </script>
@endsection
