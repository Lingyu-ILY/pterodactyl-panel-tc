@extends('layouts.admin')

@section('title')
    Nests &rarr; 新 Egg
@endsection

@section('content-header')
    <h1>新 Egg<small>建立新的 Egg 以指定給伺服器。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li><a href="{{ route('admin.nests') }}">Nests</a></li>
        <li class="active">新 Egg</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.nests.egg.new') }}" method="POST">
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
                                <label for="pNestId" class="form-label">關聯的 Nest</label>
                                <div>
                                    <select name="nest_id" id="pNestId">
                                        @foreach($nests as $nest)
                                            <option value="{{ $nest->id }}" {{ old('nest_id') != $nest->id ?: 'selected' }}>{{ $nest->name }} &lt;{{ $nest->author }}&gt;</option>
                                        @endforeach
                                    </select>
                                    <p class="text-muted small">將 Nest 視為一個分類。您可以在一個 Nest 中放置多個 Egg，但請考慮在每個 Nest 中僅放置相關的 Egg。</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="pName" class="form-label">名稱</label>
                                <input type="text" id="pName" name="name" value="{{ old('name') }}" class="form-control" />
                                <p class="text-muted small">用作此 Egg 識別碼的簡單易讀名稱。這是使用者將看到的遊戲伺服器類型。</p>
                            </div>
                            <div class="form-group">
                                <label for="pDescription" class="form-label">描述</label>
                                <textarea id="pDescription" name="description" class="form-control" rows="8">{{ old('description') }}</textarea>
                                <p class="text-muted small">此 Egg 的描述。</p>
                            </div>
                            <div class="form-group">
                                <div class="checkbox checkbox-primary no-margin-bottom">
                                    <input id="pForceOutgoingIp" name="force_outgoing_ip" type="checkbox" value="1" {{ \Pterodactyl\Helpers\Utilities::checked('force_outgoing_ip', 0) }} />
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
                                <label for="pDockerImage" class="control-label">Docker 鏡像</label>
                                <textarea id="pDockerImages" name="docker_images" rows="4" placeholder="quay.io/pterodactyl/service" class="form-control">{{ old('docker_images') }}</textarea>
                                <p class="text-muted small">使用此 Egg 的伺服器可用的 Docker 鏡像。每行輸入一個。如果提供多於一個值，使用者將能夠從此鏡像清單中選擇。</p>
                            </div>
                            <div class="form-group">
                                <label for="pStartup" class="control-label">啟動命令</label>
                                <textarea id="pStartup" name="startup" class="form-control" rows="10">{{ old('startup') }}</textarea>
                                <p class="text-muted small">使用此 Egg 建立的新伺服器應使用的預設啟動命令。您可以根據需要為每個伺服器變更此設定。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigFeatures" class="control-label">Features</label>
                                <div>
                                    <select class="form-control" name="features[]" id="pConfigFeatures" multiple>
                                    </select>
                                    <p class="text-muted small">Additional features belonging to the egg. Useful for configuring additional panel modifications.</p>
                                </div>
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
                                <p>除非您從「從以下選項複製設定」下拉選單中選擇其他選項，否則所有欄位都是必填的，在這種情況下，欄位可以留空以使用該選項的值。</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFrom" class="form-label">從以下選項複製設定</label>
                                <select name="config_from" id="pConfigFrom" class="form-control">
                                    <option value="">無</option>
                                </select>
                                <p class="text-muted small">如果您想要預設使用其他 Egg 的設定，請從上面的下拉選單中選擇。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStop" class="form-label">停止命令</label>
                                <input type="text" id="pConfigStop" name="config_stop" class="form-control" value="{{ old('config_stop') }}" />
                                <p class="text-muted small">應發送給伺服器程序以正常停止它們的命令。如果您需要發送 <code>SIGINT</code>，您應輸入 <code>^C</code>。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigLogs" class="form-label">日誌設定</label>
                                <textarea data-action="handle-tabs" id="pConfigLogs" name="config_logs" class="form-control" rows="6">{{ old('config_logs') }}</textarea>
                                <p class="text-muted small">這應該是日誌檔案儲存位置的 JSON 表示，以及守護程式是否應建立自訂日誌。</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pConfigFiles" class="form-label">設定檔案</label>
                                <textarea data-action="handle-tabs" id="pConfigFiles" name="config_files" class="form-control" rows="6">{{ old('config_files') }}</textarea>
                                <p class="text-muted small">這應該是要修改的設定檔案和應變更部分的 JSON 表示。</p>
                            </div>
                            <div class="form-group">
                                <label for="pConfigStartup" class="form-label">啟動設定</label>
                                <textarea data-action="handle-tabs" id="pConfigStartup" name="config_startup" class="form-control" rows="6">{{ old('config_startup') }}</textarea>
                                <p class="text-muted small">這應該是守護程式在啟動伺服器時應尋找的值的 JSON 表示，以確定完成。</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-success btn-sm pull-right">建立</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/lodash/lodash.js') !!}
    <script>
    $(document).ready(function() {
        $('#pNestId').select2().change();
        $('#pConfigFrom').select2();
    });
    $('#pNestId').on('change', function (event) {
        $('#pConfigFrom').html('<option value="">無</option>').select2({
            data: $.map(_.get(Pterodactyl.nests, $(this).val() + '.eggs', []), function (item) {
                return {
                    id: item.id,
                    text: item.name + ' <' + item.author + '>',
                };
            }),
        });
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
    $('#pConfigFeatures').select2({
        tags: true,
        selectOnClose: false,
        tokenSeparators: [',', ' '],
    });
    </script>
@endsection
