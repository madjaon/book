<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="/ads" method="GET">
						{!! csrf_field() !!}
						<div class="input-group" style="width: 150px; display:inline-block;">
							<label>Keyword</label>
							<input name="keyword" type="text" value="{{ $request->keyword }}" class="form-control" placeholder="Keyword">
						</div>
						<div class="input-group" style="width: 90px; display:inline-block;">
							<label>Trạng thái</label>
						  	{{ Form::select('status', array_add(CommonOption::statusArray(), '', '-- All'), $request->status, array('class' =>'form-control')) }}
						</div>
						<div class="input-group" style="display:inline-block; vertical-align:bottom;">
							<button class="btn btn-primary btn-block" type="submit" title="Search">
                                <i class="fa fa-search fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Search</span>
                            </button>
						</div>
						<div class="input-group" style="display:inline-block; vertical-align:bottom;">
                            <a href="/ads" class="btn btn-default btn-block" title="Clear Filter">Clear Filter</a>
						</div>
						{!! Form::hidden('issearch', 1) !!}
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@include('scripts.datetimepicker')
