@extends('public.web')

@section('content')

<div class="content">
  <h3>Reset your password</h3>
  <form action="{{ route('web.password.forgot.post') }}" method="POST">
    <fieldset>
      @isset($error)
      <div class="error"><strong>{{ $error }}</strong></div>
      @endisset
      @isset($message)
      <div class="message"><strong>{{ $message }}</strong></div>
      @endisset
      <label for="email">Email</label>
      <input type="text" id="email" name="email" />
      <input class="button-primary" type="submit" value="Submit" />
    </fieldset>
  </form>
</div>

@endsection
