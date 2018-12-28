@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h3>分类
                    <small>» 新增分类</small>
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">新增分类表单</h3>
                    </div>
                    <div class="card-body">

                        @include('admin.partials.errors')

                        <form class="form-horizontal" role="form" method="POST" action="{{url('admin/cate')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group row">
                                <label for="cate_pid" class="col-md-3 control-label"><i class="require">*</i>父级分类</label>
                                <div class="col-md-3">
                                    <select class="form-control" name="cate_pid" autofocus>
                                        <option value="0">==顶级分类==</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if ($category->id == $cate_pid) selected @endif >{{$category->cate_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cate_name" class="col-md-3 control-label"><i class="require">*</i>分类名称</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="cate_name" id="cate_name" value="{{ $cate_name }}" autofocus>
                                </div>
                            </div>

                            @include('admin.category._form')

                            <div class="form-group row">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>添加
                                    </button>
                                    <button type="button" class="btn btn-default btn-md" onclick="history.go(-1)">
                                        <i class="fa fa-plus-circle"></i>返回
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop