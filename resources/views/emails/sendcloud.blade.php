@component('mail::message')
# 枚江镇财政收支信息

{{ date('y-m-d') }}收支日表

@component('mail::table')
| 清算日期      | 摘要         | 金额      |
| ------------- |:-------------:| --------:|
@foreach ($zbs as $zb)
| {{ $zb->LR_RQ }}      | {{ $zb->ZY }} | ${{ $zb->JE }}      |
@endforeach
| 汇总      | 汇总 | ${{ bcdiv($zbs->sum('JE'), '1',2) }}      |
@endcomponent


----------------------------------------------------

@component('mail::table')
|     日期      | 摘要         | 金额      |
| ------------- |:-------------:| --------:|
@foreach ($zfpzs as $zfpz)
| {{ $zfpz->QS_RQ }}      | {{ $zfpz->ZY }} | ${{ $zfpz->JE }}      |
@endforeach
| 汇总      | 汇总 | ${{ bcdiv($zfpzs->sum('JE'), '1',2) }}       |
@endcomponent


@component('mail::button', ['url' => 'imiguo.top/geren'])
进入网站查看
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
