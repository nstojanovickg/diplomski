@extends('app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        <b class="panel-title">{{ Lang::get('general.DASHBOARD') }}</b>
    </div>
	<div class="panel-body">
		{{ Lang::get('general.SCHOOL_YEAR') }}:
		<select id="chart_year" onchange="changeFirstChart()">
			@foreach ($years as $year)
				<option value='{{ $year }}'>{{ $year }}</option>
			@endforeach
		</select>
		<div id="applications" style="height: 250px;"></div>
		@if(!empty($new_stats_arr))
			<h1>{{ $period_year }}</h1>
			{{ Lang::get('general.COURSE') }}:
			<select id="chart_course" onchange="changeSecondChart()">
				@foreach ($courses as $course)
					<option value='{{ $course }}'>{{ $course }}</option>
				@endforeach
			</select>
				
			<div id="new_applications" style="height: 250px;"></div>
		@endif
	</div>
</div>
	<script>
		var result_arr = <?php echo json_encode($stats_arr); ?>;
		var labels = ['Polozili ispit', 'Pali ispit', 'Nisu izasli'];
		
		@if (\Auth::user()->getStatus() == 'student')
            labels = ['Polozio ispit', 'Pao ispit', 'Nisam izasao'];
        @endif
		
		var chartApplications = Morris.Bar({
			element: 'applications',
			data:  result_arr[document.getElementById("chart_year").value],
			xkey: 'rok',
			ykeys: ['polozili', 'pali', 'odustali'],
			yLabelFormat: function(y){return y != Math.round(y)?'':y;},
			labels: labels
		});
		
		<?php
		if (!empty($new_stats_arr)) {
		?>
			var new_result_arr = <?php echo json_encode($new_stats_arr); ?>;
			
			var newChartApplications = Morris.Bar({
				element: 'new_applications',
				data:  new_result_arr[document.getElementById("chart_course").value],
				xkey: 'xkey',
				ykeys: ['prijavljeno'],
				yLabelFormat: function(y){return y != Math.round(y)?'':y;},
				labels: ['Prijavili ispit']
			});
		<?php
		}
		?>
		function changeFirstChart() {
			var x = document.getElementById("chart_year").value;
			chartApplications.setData(result_arr[x]);
		};
		function changeSecondChart() {
			var x = document.getElementById("chart_course").value;
			newChartApplications.setData(new_result_arr[x]);
		};
	</script>
@section('styles')
    {!! Html::style('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css') !!}
@stop
@section('scripts')
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js') !!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js') !!}
@stop
@endsection
