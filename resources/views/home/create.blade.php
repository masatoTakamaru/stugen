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
      <p class="mr-2">{{$pii['familyName']}}</p>
      <p class="mr-2">{{$pii['firstName']}}</p>
      <p class="mr-2">{{$pii['gradeName']}}</p>
    </div>
  @endforeach
</div>

@endsection
