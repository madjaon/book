<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="/postchaps" method="GET">
						{!! csrf_field() !!}
						<div class="input-group" style="width: 150px; display:inline-block;">
							<label>Keyword</label>
							<input name="keyword" type="text" value="{{ $request->keyword }}" class="form-control" placeholder="Keyword">
						</div>
						<div class="input-group" style="width: 90px; display:inline-block;">
							<label>Trạng thái</label>
						  	{{ Form::select('status', array_add(CommonOption::statusArray(), '', '-- All'), $request->status, array('class' =>'form-control')) }}
						</div>
						<div class="input-group date" style="width: 90px; display:inline-block;">
							<label>Từ ngày</label>
							<input name="start_date" type="text" value="{{ $request->start_date }}" class="form-control" id="start_date" placeholder="Từ ngày">
						</div>
						<div class="input-group date" style="width: 90px; display:inline-block;">
							<label>Đến ngày</label>
							<input name="end_date" type="text" value="{{ $request->end_date }}" class="form-control" id="end_date" placeholder="Đến ngày">
						</div>
						<div class="input-group" style="display:inline-block; vertical-align:bottom;">
							<button class="btn btn-primary btn-block" type="submit" title="Search">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Search</span>
                            </button>
						</div>
						<div class="input-group" style="display:inline-block; vertical-align:bottom;">
                            <a href="{{ URL::to('postchaps/?post_id=' . $request->post_id) }}" class="btn btn-default btn-block" title="Clear Filter">Clear Filter</a>
						</div>
						{!! Form::hidden('post_id', $request->post_id) !!}
						{!! Form::hidden('issearch', 1) !!}
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@include('scripts.datetimepicker')
