@extends('layouts.default')
@section('content')
@include('vendor.ueditor.assets')
<br><br><br>
<h1>枚江镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<h2>
	<form action="/storeaccount" method="post">
	{!! csrf_field() !!}
	<table class="table table-bordered table-striped table-hover table-condensed">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>

		<thead>
			<tr class='success'>
				<th>支出ID</th>
				<th>日期</th>
				<th>摘要</th>
				<th>预算单位</th>
				<th>总金额</th>
				<th>支出类型</th>
			
			</tr>
		</thead>
		<tbody class='alert-info'>
	
		
		@foreach ($results as $result)
			<tr>
				<td class="small">
				
					
						{{$result->account?
						$result->account->account_name:''}} 
					
					

					
				
				</td>

				<td>
				
					{{$result->LR_RQ}} 

					
				
				</td>
				<td>
				
					{{$result->ZY}}
				
				</td>
				<td>
				
					{{$result->YSDWMC}}
				
				</td>
				<td>
				
					{{$result->JE}}
				
				</td>
				
				<td>
				
					{{$result->ZFFSMC}}
				
				</td>
				
			</tr>
			<tr><td colspan="7">

				<input type="hidden" name="">
                 {!! csrf_field() !!}				
					<div class="form-group">
                        <select 
                        name="{{$result->PDH}}" 
                        class="
                        js-example-placeholder-multiple               
                        js-data-example-ajax 
                        " 
                        multiple="multiple"
                        style="width:600px">
                        </select>
                    </div>
                   
              
			</td></tr>

		@endforeach

			     			     	
			     
			     	
			


		</tbody>
			
					<tr class='success'>
				<th>指标ID</th>
				<th>摘要</th>
				<th>预算项目</th>
				<th></th>
				<th>{{($results->sum('JE'))/10000}}</th>
				
				<th>支出类型</th>
			</tr>
	</table>
	<button type="submit" class="btn btn-default btn-block">设置科目</button>	
</form>  


			<hr>
	
	</h2>
</article>
{{-- {!! Form::open() !!}
 {!! Form::text("name") !!}
{!! Form::close() !!} --}}


@stop

@section('js')

<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container',
        {
    toolbars: [
            ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
        ],
    elementPathEnabled: false,
    enableContextMenu: false,
    autoClearEmptyNode:true,
    wordCount:false,
    imagePopup:false,
    autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });




            $(document).ready(function() {
            function formatTopic (topic) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel"   +
                    "</div></div></div>";
            }
            function formatTopicSelection (topic) {
                return topic.name || topic.text;
            }
            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 1,
                ajax: {
                    url: '/api/topics2',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatTopic,
                templateSelection: formatTopicSelection,
                escapeMarkup: function (markup) { return markup; }
            });
        });
    </script>
    @endsection