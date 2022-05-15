@extends("template")

@section("content")

<div>
<form action="{{route('home.create')}}" method="post">
  <h3>都道府県</h3>
  <div class="flex flex-wrap mb-4 mx-8">
    @foreach($prefNames as $prefName)
      <div class="flex items-center">
        <input type="checkbox" name="prefs[]" id="{{$prefName}}" value="{{$prefName}}">
        <label for="{{$prefName}}" class="mr-4">{{$prefName}}</label>
      </div>
    @endforeach
  </div>
  <h3>人数</h3>
  <div class="flex items-center mb-8 mx-8">
    <input type="number" min="1" max="1000" name="numbers"><p class="ml-4">1～1000</p>
    {{csrf_field()}}
  </div>
  <div class="flex justify-center">
    <button id="submit" type="submit" class="btn py-3 px-12">作成</button>
  </div>
  <div id="loading" class="flex justify-center">
    <div>
      <img class="mb-4" src="{{asset('images/loading.gif')}}">
      <p>処理中...</p>
    </div>
  </div>
</form>
</div>

<script>
  let button = document.querySelector("#submit");
  let target = document.querySelector("#loading")
  target.style.visibility = "hidden";
  button.addEventListener('click', function(){
    button.style.visibility = "hidden";
    target.style.visibility = "visible";
  });
</script>

@endsection
