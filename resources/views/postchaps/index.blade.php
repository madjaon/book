@extends('layouts.app')

@section('template_title')
  Showing Post Chaps
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')

    @include('postchaps.search')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <!-- <div style="display: flex; justify-content: space-between; align-items: center;"> -->
                            @php
                                $post = CommonQuery::getAllFields('posts', $request->post_id, ['name', 'slug']);
                                $postName = isset($post)?$post->name:null;
                                $postSlug = isset($post)?$post->slug:null;
                            @endphp

                            Showing post chaps: {{ count($data) }}/{{ $data->total() }}
                            @if(isset($postName))
                            <a href="{{ url($postSlug) }}" target="_blank">{{ str_limit($postName, 15) }}</a>
                            @endif

                            <a href="/posts" class="btn btn-info btn-xs pull-right">
                              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
                              <span class="hidden-xs">Back to </span>Posts
                            </a>

                            <a class="btnSelected btn btn-default btn-xs pull-right margin-right-1" id="loadMsg3" data-toggle="modal" data-target="#modalPostChapsDeleteSelected" data-title="Delete Selected Items" data-message="Are you sure you want to delete selected items ?" style="display: none;">
                                <i class="fa fa-fw fa-recycle" aria-hidden="true"></i>
                                Delete Selected Items
                            </a>

                            <a class="btn btn-default btn-xs pull-right margin-right-1 visible" id="loadMsg4" data-toggle="modal" data-target="#modalPostChapsChangePositionSelected" data-title="Change Position Items" data-message="Are you sure you want to change position items ?">
                                <i class="fa fa-fw fa-list" aria-hidden="true"></i>
                                Change Position Items
                            </a>

                            <a class="btnSelected btn btn-default btn-xs pull-right margin-right-1" id="loadMsg1" data-toggle="modal" data-target="#modalPostChapsChangeStatusSelected" data-title="Change Status Selected Items" data-message="Are you sure you want to change status selected items ?" style="display: none;">
                                <i class="fa fa-fw fa-check" aria-hidden="true"></i>
                                Change Status Selected Items
                            </a>

                            <a href="{{ URL::to('postchaps/create/?post_id=' . $request->post_id) }}" class="btn btn-default btn-xs pull-right margin-right-1">
                                <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                Create New Post Chap
                            </a>

                        <!-- </div> -->
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkall" onClick="toggle(this)"></th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Volume</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Chapter</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Position</th>
                                        <th class="hidden-sm hidden-xs hidden-md">StartDate</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Created</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Updated</th>
                                        <th>Actions</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $value)
                                        <tr>
                                            <td><input type="checkbox" class="id" name="id[]" value="{{ $value->id }}"></td>
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td><a id="status_{{ $value->id }}" onclick="updateStatus('postchaps', {{ $value->id }}, 'status')" style="cursor: pointer; text-decoration: none;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->volume}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->chapter}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">
                                                <input type="text" name="position" value="{{ $value->position }}" size="5" class="onlyNumber" style="text-align: center;">
                                            </td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->start_date}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->created_at}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->updated_at}}</td>
                                            <td>
                                                {!! Form::open(array('url' => 'postchaps/' . $value->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Delete</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Item', 'data-message' => 'Are you sure you want to delete this item ?')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ url($value->slug) }}" data-toggle="tooltip" title="Show" target="_blank">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Show</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('postchaps/' . $value->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Edit</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')
    @include('modals.modal-postchaps-delete-selected')
    @include('modals.modal-postchaps-change-status-selected')
    @include('modals.modal-postchaps-change-position-selected')
    @include('modals.modal-posttypes')

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.delete-postchaps-selected-modal-script')
    @include('scripts.change-postchaps-status-selected-modal-script')
    @include('scripts.change-postchaps-position-selected-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
    @include('scripts.common')
    @include('scripts.updateStatus')
    @include('scripts.actionSelected')
@endsection
