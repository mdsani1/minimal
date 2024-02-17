<x-guest-layout>
    <!-- Validation Errors -->
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh">
        <div class="container-fluid">
            <div class="card" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 d-flex align-content-center flex-wrap justify-content-center" style="border-right: 1px solid #dee2e6">
                            <div class="d-flex align-content-center flex-wrap justify-content-center">

                                <img src="{{ asset('image/logo.png') }}" class="" alt="logo" style="width: 100%">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12" style="padding:100px">
                            <div style="border-top:5px solid #00695c; width: 50px;"></div>
                            <h3 class="mt-2">Login  as a User</h3>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name -->
                                <div>
                                    <x-backend.form.input name="name" icon="fas fa-user" :value="old('name')" required/>
                                </div>

                                <!-- Email -->
                                <div class="mt-4">
                                    <x-backend.form.input name="email" icon="fas fa-envelope" :value="old('email')" required/>
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-backend.form.input name="password" icon="fas fa-unlock" type="password" :value="old('password')" required autocomplete="new-password"/>
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-backend.form.input name="password_confirmation" icon="fas fa-unlock" type="password" :value="old('password_confirmation')" required/>
                                </div>

                                <!-- Remember Me -->
                                <div class="block mt-4">
                                    {{-- <x-backend.form.checkbox name="checkbox" label="Remember All"/> --}}
                                </div>

                                <div class="d-flex flex-column justify-content-center">
                                    <button type="submit" class="btn btn-login btn-primary btn-lg btn-block"><strong>R G I S T E R</strong></button>
                                    {{-- @if (Route::has('password.request'))
                                        <a herf="#" class="text-center text-muted mt-4">{{ __('Forgot your password?') }}</a>
                                    @endif --}}
                                    <a href="login" id="sign-in" class="text-center text-muted mt-4" style="color: #1A4314;">You Have Account? Login Now</a>
                                    {{-- <a herf="#" class="text-center text-muted terms mt-2">Terms of use.Privacy policy</a> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
