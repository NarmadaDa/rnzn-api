<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>HomePort Article - {{ $title }}</title>
<style>
body {
  font-family: sans-serif;
  line-height: 1.5em;
}
img {
  height: auto;
  width: 100%;
}
</style>
</head>
<body>
  <h1>RNZN HomePort Article</h1>
  <h2>{{ $title }}</h2>
  <div class="container">
    {!! $content !!}
  </div>
</body>
</html>