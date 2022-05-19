@extends("template")

@section("content")

<div>
  <p>学生（生徒・児童）に特化した個人情報ジェネレータです。ある程度リアルな疑似個人情報を作成できます。データはcsv形式(Shift-JIS)でダウンロードできます。</p>
</div>
<div>
  <p>出力されるデータ：姓，名，姓フリガナ，名フリガナ，学年，生年月日，学校名，住所（郵便番号，都道府県，市区町村，その他，番地等），電話番号，携帯電話番号，ユーザー名，パスワード，メールアドレス
</p>
</div>

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
    <p class="text-blue-600 text-85">*未選択の場合は全国</p>
  </div>
  <h3>学年</h3>
  <div class="flex flex-wrap mb-4 mx-8">
    @foreach($gradeNames as $gradeName)
      <div class="flex items-center">
        <input type="checkbox" name="gradeNames[]" id="{{$gradeName}}" value="{{$gradeName}}">
        <label for="{{$gradeName}}" class="mr-4">{{$gradeName}}</label>
      </div>
    @endforeach
    <p class="text-blue-600 text-85">*未選択の場合は全学年</p>
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
  //ページ読み込み時
  window.addEventListener('DOMContentLoaded', function() {
    button.style.visibility = "visible";
    target.style.visibility = "hidden";
  });
  //ページ遷移時
  window.addEventListener('unload', function() {
    button.style.visibility = "visible";
    target.style.visibility = "hidden";
  });
  //クリック時
  let button = document.querySelector("#submit");
  let target = document.querySelector("#loading")
  button.addEventListener('click', function() {
    button.style.visibility = "hidden";
    target.style.visibility = "visible";
  });

</script>

@endsection
