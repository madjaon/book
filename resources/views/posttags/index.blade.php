@extends('layouts.app')

@section('template_title')
  Showing Post Tags
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

    @include('posttags.search')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <!-- <div style="display: flex; justify-content: space-between; align-items: center;"> -->
                            
                            Showing post tags: {{ count($data) }}/{{ $data->total() }}

                            <a href="{{ URL::to('posttags/create') }}" class="btn btn-default btn-xs pull-right margin-right-1">
                                <i class="fa fa-fw fa-plus" aria-hidden="true"></i>
                                Create New Post Tag
                            </a>

                        <!-- </div> -->
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <thead>
                                    <tr>
                                        <!-- <th><input type="checkbox" id="checkall" onClick="toggle(this)"></th> -->
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Status</th>
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
                                            <!-- <td><input type="checkbox" class="id" name="id[]" value="{{-- $value->id --}}"></td> -->
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td><a id="status_{{ $value->id }}" onclick="updateStatus('posttags', {{ $value->id }}, 'status')" style="cursor: pointer; text-decoration: none;" title="Click to change">{!! CommonOption::getStatus($value->status) !!}</a></td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->created_at}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$value->updated_at}}</td>
                                            <td>
                                                {!! Form::open(array('url' => 'posttags/' . $value->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Delete</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete Item', 'data-message' => 'Are you sure you want to delete this item ?')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-success btn-block" href="{{ url('tag/' . $value->slug) }}" data-toggle="tooltip" title="Show" target="_blank">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Show</span>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('posttags/' . $value->id . '/edit') }}" data-toggle="tooltip" title="Edit">
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

@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
    @include('scripts.updateStatus')
@endsection
