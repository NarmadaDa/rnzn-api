<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}" />
  <style>

  @media only screen and (max-width: 600px) {
    .inner-body {
      width: 100% !important;
    }

    .footer {
      width: 100% !important;
    }
  }

  @media only screen and (max-width: 500px) {
    .button {
      width: 100% !important;
    }
  }

  body,
  body *:not(html):not(style):not(br):not(tr):not(code) {
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
          'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
      position: relative;
  }

  body {
      -webkit-text-size-adjust: none;
      background-color: #ffffff;
      color: #002b64;
      line-height: 1.4;
      margin: 0;
      padding: 0;
      width: 100% !important;
  }

  input:focus, input[type=password]:focus, input[type=text]:focus {
    border: 0.1rem solid #002b64;
  }

  .button, button, input[type=button], input[type=reset], input[type=submit] {
    background-color: #002b64;
    border: 0.1rem solid #002b64;
  }

  .wrapper {
    max-width: 570px;
    margin: 100px auto;
  }

  .error {
    background-color: #f7eded;
    border-radius: 5px;
    color: #800000;
    padding: 15px;
    margin-bottom: 15px;
    width: 100%;
  }

  .message {
    background-color: #edf2f7;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
    width: 100%;
  }
  </style>
</head>
<body>
<div class="container">
  <div class="wrapper">
    <h1><strong>HomePort</strong></h1>
    @yield('content')
  </div>
</div>
</body>
</html>
