@extends("template")

@section("content")

<div>
<form action="{{route('home.create')}}" method="post">
  <div class="flex items-center mb-8">
    <p class="mr-2">人数：</p><input type="number" min="1" max="1000" name="numbers"><p>1～1000</p>
    {{csrf_field()}}
  </div>
  <button type="submit" class="btn py-2 px-8">作成</button>
</form>
</div>

@endsection
