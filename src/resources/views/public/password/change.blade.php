@extends('public.web')

@section('content')

<div class="content">
  <h3>Change your password</h3>
  <p>To change your password enter your email address, the temporary password that was sent to you, and enter a new password twice.</p>
  <form action="{{ route('web.password.reset.post') }}" method="POST">
    <fieldset>
      @isset($error)
        <div class="error"><strong>{{ $error }}</strong></div>
      @endisset
      @isset($message)
        <div class="message"><strong>{{ $message }}</strong></div>
      @else
        <div class="message">
          <strong>Please check your emails for your temporary password.</strong>
        </div>
      @endisset
      <label for="email">Email</label>
      <input type="text" id="email" name="email" value="{{ $email }}" />
      <label for="code">Temporary Password</label>
      <input type="text" id="code" name="code" />
      <label for="password">New Password</label>
      <input type="password" id="password" name="password" />
      <label for="password_confirmation">Re-enter New Password</label>
      <input type="password" id="password_confirmation" name="password_confirmation" />
      <input class="button-primary" type="submit" value="Submit" />
    </fieldset>
  </form>
</div>

@endsection
