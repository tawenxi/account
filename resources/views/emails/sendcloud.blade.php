@component('mail::message')
# 枚江镇财政收支信息

{{ date('y-m-d') }}收支收支表

@component('mail::table')
| 清算日期      | 摘要         | 金额      |
| ------------- |:-------------:| --------:|
@foreach ($zbs as $zb)
| {{ $zb->LR_RQ }}      | {{ $zb->ZY }} | ${{ $zb->JE }}      |
@endforeach
| Col 3 is      | Right-Aligned | $20      |
@endcomponent


----------------------------------------------------

@component('mail::table')
|     日期      | 摘要         | 金额      |
| ------------- |:-------------:| --------:|
@foreach ($zfpzs as $zfpz)
| {{ $zfpz->QS_RQ }}      | {{ $zfpz->ZY }} | ${{ $zfpz->JE }}      |
@endforeach
| Col 3 is      | Right-Aligned | $20      |
@endcomponent


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
