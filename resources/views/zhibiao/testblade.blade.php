<!DOCTYPE html>
<html>
<head>
	<title>导出模板</title>
</head>
<body>
	<div>
		<ul >
				@foreach ($results as $result)
					<li>
						{{ $result['hanghao'] }}|{{$result['ZY']}}|{{$result['account_number']}}|借|{{div($result['JE']/100)}}|{{ $request['rq'] }}|{{ $result['list_id'] }}|{{ $request['qj'] }}
					</li>	
				@endforeach
		</ul>
	</div>
</body>
</html>

