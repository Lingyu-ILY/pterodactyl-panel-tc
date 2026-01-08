@extends('layouts.admin')

@section('title')
    伺服器 — {{ $server->name }}: 建置詳細資訊
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>控制此伺服器的配置和系統資源。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li><a href="{{ route('admin.servers') }}">伺服器</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">建置配置</li>
    </ol>
@endsection

@section('content')
@include('admin.servers.partials.navigation')
<div class="row">
    <form action="{{ route('admin.servers.view.build', $server->id) }}" method="POST">
        <div class="col-sm-5">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">資源管理</h3>
                </div>
                <div class="box-body">
                <div class="form-group">
                        <label for="cpu" class="control-label">CPU 限制</label>
                        <div class="input-group">
                            <input type="text" name="cpu" class="form-control" value="{{ old('cpu', $server->cpu) }}"/>
                            <span class="input-group-addon">%</span>
                        </div>
                        <p class="text-muted small">系統上的每個<em>虛擬</em>核心（執行緒）被視為 <code>100%</code>。將此值設為 <code>0</code> 將允許伺服器無限制地使用 CPU 時間。</p>
                    </div>
                    <div class="form-group">
                        <label for="threads" class="control-label">CPU 釘選</label>
                        <div>
                            <input type="text" name="threads" class="form-control" value="{{ old('threads', $server->threads) }}"/>
                        </div>
                        <p class="text-muted small"><strong>進階：</strong>輸入此程式可以執行的特定 CPU 核心，或留空以允許所有核心。這可以是單個數字，或以逗號分隔的列表。示例：<code>0</code>、<code>0-1,3</code> 或 <code>0,1,3,4</code>。</p>
                    </div>
                    <div class="form-group">
                        <label for="memory" class="control-label">分配記憶體</label>
                        <div class="input-group">
                            <input type="text" name="memory" data-multiplicator="true" class="form-control" value="{{ old('memory', $server->memory) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">此容器允許的最大記憶體量。將此設為 <code>0</code> 將允許容器中的無限記憶體。</p>
                    </div>
                    <div class="form-group">
                        <label for="swap" class="control-label">分配交換空間</label>
                        <div class="input-group">
                            <input type="text" name="swap" data-multiplicator="true" class="form-control" value="{{ old('swap', $server->swap) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">將此設為 <code>0</code> 將禁用此伺服器上的交換空間。設為 <code>-1</code> 將允許無限交換。</p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">磁碟空間限制</label>
                        <div class="input-group">
                            <input type="text" name="disk" class="form-control" value="{{ old('disk', $server->disk) }}"/>
                            <span class="input-group-addon">MiB</span>
                        </div>
                        <p class="text-muted small">如果伺服器使用超過此空間，將不允許啓動。如果伺服器在執行時超過此限制，它將被安全停止並鎖定，直到有足夠的空間可用。設為 <code>0</code> 允許無限磁碟使用。</p>
                    </div>
                    <div class="form-group">
                        <label for="io" class="control-label">區塊 I/O 比例</label>
                        <div>
                            <input type="text" name="io" class="form-control" value="{{ old('io', $server->io) }}"/>
                        </div>
                        <p class="text-muted small"><strong>進階</strong>：此伺服器相對於系統上其他<em>執行中</em>的容器的 I/O 效能。值應在 <code>10</code> 和 <code>1000</code> 之間。</code></p>
                    </div>
                    <div class="form-group">
                        <label for="cpu" class="control-label">OOM Killer</label>
                        <div>
                            <div class="radio radio-danger radio-inline">
                                <input type="radio" id="pOomKillerEnabled" value="0" name="oom_disabled" @if(!$server->oom_disabled)checked @endif>
                                <label for="pOomKillerEnabled">啟用</label>
                            </div>
                            <div class="radio radio-success radio-inline">
                                <input type="radio" id="pOomKillerDisabled" value="1" name="oom_disabled" @if($server->oom_disabled)checked @endif>
                                <label for="pOomKillerDisabled">禁用</label>
                            </div>
                            <p class="text-muted small">
                                啟用 OOM killer 可能會導致伺服器程式意外退出。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">應用功能限制</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="database_limit" class="control-label">資料庫限制</label>
                                    <div>
                                        <input type="text" name="database_limit" class="form-control" value="{{ old('database_limit', $server->database_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">用戶可為此伺服器建立的資料庫總數。</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="allocation_limit" class="control-label">配置限制</label>
                                    <div>
                                        <input type="text" name="allocation_limit" class="form-control" value="{{ old('allocation_limit', $server->allocation_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">用戶可為此伺服器建立的配置總數。</p>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="backup_limit" class="control-label">備份限制</label>
                                    <div>
                                        <input type="text" name="backup_limit" class="form-control" value="{{ old('backup_limit', $server->backup_limit) }}"/>
                                    </div>
                                    <p class="text-muted small">可為此伺服器建立的備份總數。</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">配置管理</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <label for="pAllocation" class="control-label">遊戲連接埠</label>
                                <select id="pAllocation" name="allocation_id" class="form-control">
                                    @foreach ($assigned as $assignment)
                                        <option value="{{ $assignment->id }}"
                                            @if($assignment->id === $server->allocation_id)
                                                selected="selected"
                                            @endif
                                        >{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted small">將用於此遊戲伺服器的預設連接地址。</p>
                            </div>
                            <div class="form-group">
                                <label for="pAddAllocations" class="control-label">分配額外連接埠</label>
                                <div>
                                    <select name="add_allocations[]" class="form-control" multiple id="pAddAllocations">
                                        @foreach ($unassigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">請注意，由於軟體限制，您無法在不同 IP 上分配相同的連接埠給同一台伺服器。</p>
                            </div>
                            <div class="form-group">
                                <label for="pRemoveAllocations" class="control-label">移除額外連接埠</label>
                                <div>
                                    <select name="remove_allocations[]" class="form-control" multiple id="pRemoveAllocations">
                                        @foreach ($assigned as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->alias }}:{{ $assignment->port }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-muted small">只需從上面的列表中選擇您想要移除的連接埠即可。如果您想要分配已經使用的不同 IP 上的連接埠，您可以從左側選擇它並在此處刪除它。</p>
                            </div>
                        </div>
                        <div class="box-footer">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-primary pull-right">更新建置配置</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pAddAllocations').select2();
    $('#pRemoveAllocations').select2();
    $('#pAllocation').select2();
    </script>
@endsection
