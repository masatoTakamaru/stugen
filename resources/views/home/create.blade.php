@extends("template")

@section("content")

<p>作成結果</p>
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
    </div>
  @endforeach
</div>

@endsection
