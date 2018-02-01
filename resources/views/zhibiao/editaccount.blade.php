@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')

@include('vendor.ueditor.assets')

      <h1>更新ACCOUNT数据</h1>
      <hr>
      <div class="row col-md-6 col-lg-offset-3">
        <div class="panel-body">
          @include('shared.errors')
        {!! Form::model($result,['method' => 'PATCH', 'url' => ['zbdetail/update'], 'class' => 'form-horizontal']) !!}
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
               {!! Form::label('id', 'ID') !!}
               {!! Form::text('id',$result->id, ['class' => 'form-control', 'required' => 'required']) !!}
               <small class="text-danger">{{ $errors->first('id') }}</small>
           </div>

           <div class="form-group{{ $errors->has('QS_RQ') ? ' has-error' : '' }}">
               {!! Form::label('QS_RQ', '清算日期') !!}
               {!! Form::text('QS_RQ',$result->QS_RQ, ['class' => 'form-control']) !!}
               <small class="text-danger">{{ $errors->first('QS_RQ') }}</small>
           </div>

           <div class="form-group{{ $errors->has('zy') ? ' has-error' : '' }}">
               {!! Form::label('zy', '摘要') !!}
               {!! Form::text('zy', $result->ZY, ['class' => 'form-control', 'required' => 'required']) !!}
               <small class="text-danger">{{ $errors->first('zy') }}</small>
           </div>

           <div class="form-group{{ $errors->has('JE') ? ' has-error' : '' }}">
               {!! Form::label('JE', '金额') !!}
               {!! Form::text('JE',$result->JE, ['class' => 'form-control', 'required' => 'required']) !!}
               <small class="text-danger">{{ $errors->first('JE') }}</small>
           </div>

                 <tr>
        <td colspan="7">
          {!! Form::label('请输入科目', \DB::table('accounts')->where('account_number',$result->account_number)->value('account_name')) !!}
        <input type="hidden" name="">
                 {!! csrf_field() !!}       
          <div class="form-group">
                        <select 
                        name="account_id" 
                        class="
                        js-example-placeholder-multiple               
                        js-data-example-ajax 
                        " 
                        multiple="multiple"
                        style="width:100%">
                        </select>
                    </div>
      </td></tr>

               <button type="submit" class="btn btn-block btn-success">更新</button>
       {!! Form::close() !!}
    </div>
      </div>




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