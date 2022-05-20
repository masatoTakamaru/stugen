@extends("template")

@section("content")

<div class="mb-2">
  <p>学生（生徒・児童）に特化した個人情報ジェネレータです。ある程度リアルな疑似情報を作成できます。データはcsv形式(Shift-JIS)でダウンロードできます。生成されたデータは商用・非商用を問わず著作権者の許諾無しにデータベースのサンプルデータ等の用途に使用できます。</p>
</div>
<div>
  <p>出力されるデータ：<span class="font-bold">姓，名，姓フリガナ，名フリガナ，学年，生年月日，学校名，住所（郵便番号，都道府県，市区町村，その他，番地等），電話番号，携帯電話番号，ユーザー名，パスワード，メールアドレス</span></p>
</div>
<div>
  <ul>
    <li>学年に応じて，適切な生年月日を生成。</li>
    <li>住所に応じて，実在の幼稚園，小学校，中学校，高校，大学名を生成。</li>
    <li>住所に応じて，適切な郵便番号を生成。</li>
    <li>住所に応じて，適切な市外局番を用いた電話番号を生成。</li>
  </ul>
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
  @error('numbers')
  <div>
    <p>{{$message}}</p>
  </div>
  @enderror
  <div class="flex justify-center mb-2">
    <p>人数が多い場合，処理に数分かかることがあります。</p>
  </div>
  <div class="flex justify-center">
    <button id="submit" type="submit" class="btn py-3 px-12">作成</button>
  </div>
</div>

@endsection
