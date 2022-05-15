@extends("template")

@section("content")

<div class="flex justify-center">
  <a href="{{route('home.index')}}" class="btn btn-flat py-3 px-10">戻る</a>
</div>
<h3>結果</h3>
<div>
  {{$numbers}}人
</div>
<div>
  @foreach($piis as $pii)
    <div class="flex">
      <p>{{$pii['familyName']}}</p>
      <p>{{$pii['firstName']}}</p>
      <p>{{$pii['familyNameKana']}}</p>
      <p>{{$pii['firstNameKana']}}</p>
      <p>{{$pii['zip']}}</p>
      <p>{{$pii['pref']}}</p>
      <p>{{$pii['city']}}</p>
      <p>{{$pii['st']}}</p>
      <p>{{$pii['block']}}</p>
      <p>電話番号</p>
      <p>{{$pii['phone1']}}</p>
      <p>携帯番号</p>
      <p>{{$pii['phone2']}}</p>
    </div>
  @endforeach
</div>

@endsection
