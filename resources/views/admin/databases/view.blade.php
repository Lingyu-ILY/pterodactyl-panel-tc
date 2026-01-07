@extends('layouts.admin')

@section('title')
    資料庫主機 &rarr; 查看 &rarr; {{ $host->name }}
@endsection

@section('content-header')
    <h1>{{ $host->name }}<small>查看與此資料庫主機相關的資料庫和詳細資訊。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li><a href="{{ route('admin.databases') }}">資料庫主機</a></li>
        <li class="active">{{ $host->name }}</li>
    </ol>
@endsection

@section('content')
<form action="{{ route('admin.databases.view', $host->id) }}" method="POST">
    <div class="row">
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">主機詳細資訊</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pName" class="form-label">名稱</label>
                        <input type="text" id="pName" name="name" class="form-control" value="{{ old('name', $host->name) }}" />
                    </div>
                    <div class="form-group">
                        <label for="pHost" class="form-label">主機</label>
                        <input type="text" id="pHost" name="host" class="form-control" value="{{ old('host', $host->host) }}" />
                        <p class="text-muted small">當嘗試<em>從面板</em>連接到此 MySQL 主機以新增資料庫時，應使用的 IP 位址或 FQDN。</p>
                    </div>
                    <div class="form-group">
                        <label for="pPort" class="form-label">連接埠</label>
                        <input type="text" id="pPort" name="port" class="form-control" value="{{ old('port', $host->port) }}" />
                        <p class="text-muted small">此主機上 MySQL 執行的連接埠。</p>
                    </div>
                    <div class="form-group">
                        <label for="pNodeId" class="form-label">連結的節點</label>
                        <select name="node_id" id="pNodeId" class="form-control">
                            <option value="">無</option>
                            @foreach($locations as $location)
                                <optgroup label="{{ $location->short }}">
                                    @foreach($location->nodes as $node)
                                        <option value="{{ $node->id }}" {{ $host->node_id !== $node->id ?: 'selected' }}>{{ $node->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <p class="text-muted small">此設定只有在將資料庫新增至所選節點上的伺服器時，預設使用此資料庫主機。</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">使用者詳細資訊</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="pUsername" class="form-label">使用者名稱</label>
                        <input type="text" name="username" id="pUsername" class="form-control" value="{{ old('username', $host->username) }}" />
                        <p class="text-muted small">具有足夠權限在系統上建立新使用者和資料庫的帳戶使用者名稱。</p>
                    </div>
                    <div class="form-group">
                        <label for="pPassword" class="form-label">密碼</label>
                        <input type="password" name="password" id="pPassword" class="form-control" />
                        <p class="text-muted small">所定義帳戶的密碼。留空以繼續使用已指定的密碼。</p>
                    </div>
                    <hr />
                    <p class="text-danger small text-left">為此資料庫主機定義的帳戶<strong>必須</strong>具有 <code>WITH GRANT OPTION</code> 權限。如果定義的帳戶沒有此權限，建立資料庫的請求<em>將會</em>失敗。<strong>不要對 MySQL 使用您為此面板定義的相同帳戶詳細資訊。</strong></p>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <button name="_method" value="PATCH" class="btn btn-sm btn-primary pull-right">儲存</button>
                    <button name="_method" value="DELETE" class="btn btn-sm btn-danger pull-left muted muted-hover"><i class="fa fa-trash-o"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">資料庫</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>伺服器</th>
                        <th>資料庫名稱</th>
                        <th>使用者名稱</th>
                        <th>允許連線來源</th>
                        <th>最大連線數</th>
                        <th></th>
                    </tr>
                    @foreach($databases as $database)
                        <tr>
                            <td class="middle"><a href="{{ route('admin.servers.view', $database->getRelation('server')->id) }}">{{ $database->getRelation('server')->name }}</a></td>
                            <td class="middle">{{ $database->database }}</td>
                            <td class="middle">{{ $database->username }}</td>
                            <td class="middle">{{ $database->remote }}</td>
                            @if($database->max_connections != null)
                                <td class="middle">{{ $database->max_connections }}</td>
                            @else
                                <td class="middle">無限制</td>
                            @endif
                            <td class="text-center">
                                <a href="{{ route('admin.servers.view.database', $database->getRelation('server')->id) }}">
                                    <button class="btn btn-xs btn-primary">管理</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            @if($databases->hasPages())
                <div class="box-footer with-border">
                    <div class="col-md-12 text-center">{!! $databases->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
        $('#pNodeId').select2();
    </script>
@endsection
