@extends("template")

@section("content")

<p>作成結果</p>
<div>
  {{$numbers}}人
</div>
<div>
  @foreach($lastNames as $lastName)
    <p>{{$lastName}}</p>
  @endforeach
</div>

@endsection
