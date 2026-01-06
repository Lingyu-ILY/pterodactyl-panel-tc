@extends('layouts.admin')

@section('title')
    巢 &rarr; Egg：{{ $egg->name }} &rarr; 安裝腳本
@endsection

@section('content-header')
    <h1>{{ $egg->name }}<small>管理此 Egg 的安裝腳本。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li><a href="{{ route('admin.nests') }}">巢</a></li>
        <li><a href="{{ route('admin.nests.view', $egg->nest->id) }}">{{ $egg->nest->name }}</a></li>
        <li><a href="{{ route('admin.nests.egg.view', $egg->id) }}">{{ $egg->name }}</a></li>
        <li class="active">{{ $egg->name }}</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="nav-tabs-custom nav-tabs-floating">
            <ul class="nav nav-tabs">
                <li><a href="{{ route('admin.nests.egg.view', $egg->id) }}">設定</a></li>
                <li><a href="{{ route('admin.nests.egg.variables', $egg->id) }}">變數</a></li>
                <li class="active"><a href="{{ route('admin.nests.egg.scripts', $egg->id) }}">安裝腳本</a></li>
            </ul>
        </div>
    </div>
</div>
<form action="{{ route('admin.nests.egg.scripts', $egg->id) }}" method="POST">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">安裝腳本</h3>
                </div>
                @if(! is_null($egg->copyFrom))
                    <div class="box-body">
                        <div class="callout callout-warning no-margin">
                            此服務選項正從 <a href="{{ route('admin.nests.egg.view', $egg->copyFrom->id) }}">{{ $egg->copyFrom->name }}</a> 複製安裝腳本和容器選項。除非您從下方下拉選單中選擇「無」，否則您對此腳本所做的任何變更都不會套用。
                        </div>
                    </div>
                @endif
                <div class="box-body no-padding">
                    <div id="editor_install"style="height:300px">{{ $egg->script_install }}</div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label class="control-label">從以下選項複製腳本</label>
                            <select id="pCopyScriptFrom" name="copy_script_from">
                                <option value="">無</option>
                                @foreach($copyFromOptions as $opt)
                                    <option value="{{ $opt->id }}" {{ $egg->copy_script_from !== $opt->id ?: 'selected' }}>{{ $opt->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-muted small">如果選擇，則上方的腳本將被忽略，並使用所選選項的腳本來取代。</p>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">腳本容器</label>
                            <input type="text" name="script_container" class="form-control" value="{{ $egg->script_container }}" />
                            <p class="text-muted small">執行此伺服器腳本時使用的 Docker 容器。</p>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">腳本入口點命令</label>
                            <input type="text" name="script_entry" class="form-control" value="{{ $egg->script_entry }}" />
                            <p class="text-muted small">此腳本使用的入口點命令。</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-muted">
                            以下服務選項依賴此腳本：
                            @if(count($relyOnScript) > 0)
                                @foreach($relyOnScript as $rely)
                                    <a href="{{ route('admin.nests.egg.view', $rely->id) }}">
                                        <code>{{ $rely->name }}</code>@if(!$loop->last),&nbsp;@endif
                                    </a>
                                @endforeach
                            @else
                                <em>無</em>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    {!! csrf_field() !!}
                    <textarea name="script_install" class="hidden"></textarea>
                    <button type="submit" name="_method" value="PATCH" class="btn btn-primary btn-sm pull-right">儲存</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('footer-scripts')
    @parent
    {!! Theme::js('vendor/ace/ace.js') !!}
    {!! Theme::js('vendor/ace/ext-modelist.js') !!}
    <script>
    $(document).ready(function () {
        $('#pCopyScriptFrom').select2();

        const InstallEditor = ace.edit('editor_install');
        const Modelist = ace.require('ace/ext/modelist')

        InstallEditor.setTheme('ace/theme/chrome');
        InstallEditor.getSession().setMode('ace/mode/sh');
        InstallEditor.getSession().setUseWrapMode(true);
        InstallEditor.setShowPrintMargin(false);

        $('form').on('submit', function (e) {
            $('textarea[name="script_install"]').val(InstallEditor.getValue());
        });
    });
    </script>

@endsection
