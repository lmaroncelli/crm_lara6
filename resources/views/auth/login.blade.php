@extends('layouts.app_login')

@section('content')
<div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <h1>Login</h1>
                  <div class="input-group mb-3">
                    <input id="username" type="text" placeholder="Username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                  </div>
                  <div class="input-group mb-3">
                    <toggle-password></toggle-password>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="input-group mb-4">                      
                      <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                          <label class="form-check-label" for="remember">
                              {{ __('Ricordami') }}
                          </label>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <button type="submit" class="btn btn-primary px-4" type="button">Login</button>
                    </div>
                    <div class="col-8 text-right">
                      @if (Route::has('password.request'))
                          <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                              {{ __('Password dimenticata?') }}
                          </a>
                      @endif
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="card text-white py-5 d-md-down-none" style="width:44%; background-color: #333; border: 1px solid #187da0;">
              <div class="card-body text-center">
                <div>
                  <img src="{{ asset('images/info-alberghi-login.png') }}" alt="{{ config('app.name', 'Laravel') }}"> 
                  @if (Route::has('register'))
                    <a  href="{{ route('register') }}" class="btn btn-lg btn-outline-light mt-5">Register Now!</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
