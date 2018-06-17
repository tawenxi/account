@extends('layouts.default')
@section('content')
<h1>文件</h1>
            



<article>
	
	<div class='h4'>
		<table class="table table-bordered table-striped table-hover table-dark table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class="table-hover">
				<th>ID</th>
				<th>文号</th>
				<th>标题</th>
				<th>文件类型</th>
				<th>ZBID</th>
				<th>下载</th>
				<th>删除</th>

				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr>
						<td>{{ $loop->index+1 }}</td>
						<td class="small">{{ $result->name }}</td>
						<td class="small">{{ $result->title }}</td>
						<td class="small">{{ $result->type }}</td>
						<td class="small">{{ $result->ZBID }}</td>
						<td>
						<a href="{{ $result->url }}" class="btn btn-info btn-sm">download</a>
					   </td>
					   <td>
						<a href="/deletefile/{{ $result->id }}" class="btn btn-danger btn-sm">删除</a>
					   </td>
						

					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
				<th>ID</th>
				<th>文号</th>
				<th>标题</th>
				<th>文件类型</th>
				<th>ZBID</th>
				<th>下载</th><th>删除</th>
				</tr>
		</table>


		<hr>
	</div>
</article>


@stop

@section('content2')
<article class="offset-md-2 col-md-8">
            <form
                action="{{ route('store_file_path') }}"
                method="post"
                class="dropzone"
                id="addPhotosForm"
                >
                                <input type="text" name="name" class="form-control" placeholder="文号">
                                <input type="text" name="title" class="form-control" placeholder="主题">
                                <input type="hidden" name="zb" class="form-control" value="{{ $zb->id }}">
                {{ csrf_field() }}
                
            </form>
</article>
@stop
@section('js')

    <script type="text/javascript" src="/js/dropzone.js"></script>
    <script type="text/javascript">
        Dropzone.options.addPhotosForm = {
            paramName: 'file',
            maxFileSize: 3,
            acceptedFiles: '.xlsx,.doc,.xls',
        };
    </script>

@endsection

