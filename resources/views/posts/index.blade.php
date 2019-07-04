@extends('layouts.app')

@section('template_title')
  Showing Posts
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
    
    @include('posts.search')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <!-- <div style="display: flex; justify-content: space-between; align-items: center;"> -->

                            Showing posts: {{ count($data) }}/{{ $data->total() }}

                            <a class="btnSelected btn btn-default btn-xs pull-right" id="loadMsg3" data-toggle="modal" data-target="#modalDeleteSelected" data-title="Delete Selected Items" data-message="Are you sure you want to delete selected items ?" style="display: none;">
                                <i class="fa fa-fw fa-recycle" aria-hidden="true"></i>
                                Delete Selected Items
                            </a>

                            <a onclick="actionSelected('posts', 2);" class="btnSelected btn btn-default btn-xs pull-right margin-right-1" id="loadMsg2" style="display: none;">
                                <i class="fa fa-fw fa-list" aria-hidden="true"></i>
                                Change Category Selected Items
                            </a>

                            <a class="btnSelected btn btn-default btn-xs pull-right margin-right-1" id="loadMsg1" data-toggle="modal" data-target="#modalChangeStatusSelected" data-title="Change Status Selected Items" data-message="Are you sure you want to change status selected items ?" style="display: none;">
                                <i class="fa fa-fw fa-check" aria-hidden="true"></i>
                                Change Status Selected Items
                            </a>

                            <a href="/posts/create" class="btn btn-default btn-xs pull-right margin-right-1">
                                <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                Create New Post
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
                                            <td><a id="status_{{ $value->id }}" onclick="updateStatus('posts', {{ $value->id }}, 'status')" style="cursor: pointer; text-decoration: none;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->start_date}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->created_at}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->updated_at}}</td>
                                            <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-sm btn-success btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Action</span> <span class="caret"></span>
                                                  </button>
                                                  <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ url($value->slug) }}" title="Open Link in New Tab" target="_blank">
                                                            <i class="fa fa-external-link fa-fw" aria-hidden="true"></i> Open Link in New Tab
                                                        </a>
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    <li>
                                                        <a href="{{ URL::to('postchaps/?post_id=' . $value->id) }}" title="Show Post Chaps">
                                                            <i class="fa fa-eye fa-fw" aria-hidden="true"></i> Show Post Chaps
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ URL::to('postchaps/create/?post_id=' . $value->id) }}" title="Add New Post Chap">
                                                            <i class="fa fa-plus-square-o fa-fw" aria-hidden="true"></i> Add New Post Chap
                                                        </a>
                                                    </li>

                                                  </ul>
                                                </div>
                                                
                                            </td>
                                            <td>
                                                {!! Form::open(array('url' => 'posts/' . $value->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Delete</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Item', 'data-message' => 'Are you sure you want to delete this item ?')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('posts/' . $value->id . '/edit') }}" data-toggle="tooltip" title="Edit">
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
    @include('modals.modal-delete-selected')
    @include('modals.modal-change-status-selected')
    @include('modals.modal-change-category-selected')
    @include('modals.modal-posttypes')

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.delete-selected-modal-script')
    @include('scripts.change-status-selected-modal-script')
    @include('scripts.change-category-selected-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
    @include('scripts.common')
    @include('scripts.updateStatus')
    @include('scripts.actionSelected')
@endsection
