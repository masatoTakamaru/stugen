<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="{{asset('css/tailwind_sub.css')}}" rel="stylesheet">
  <title>学生ジェネレータ</title>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1151265093391964"
     crossorigin="anonymous"></script>
  <!-- stugenGeneral -->
  <ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-1151265093391964"
     data-ad-slot="1758144469"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
  <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
  </script>
</head>
<body class="p-4">
<header>
  <h1><a href="{{route('home.index')}}">学生ジェネレータ</a></h1>
</header>
<div class="wrapper">
  @yield("content")
</div>
<footer class="flex justify-end mt-8">
  <p>mmsankosho 2022<p>
</footer>
</body>
</html>