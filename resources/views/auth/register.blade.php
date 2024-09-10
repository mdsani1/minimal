<x-backend.layouts.master>
    <!-- Validation Errors -->

    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-sm-12" style="padding:100px">
            <div class="card card-body">
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

                    @php
                        $roles = \App\Models\Role::get();
                    @endphp
                    <!-- Password -->
                    <div class="mt-4">
                        <select name="role" class="form-select">
                            <option value="" style="border: 1px solid #DCDCDC;">Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
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
                        {{-- <a href="login" id="sign-in" class="text-center text-muted mt-4" style="color: #1A4314;">You Have Account? Login Now</a> --}}
                        {{-- <a herf="#" class="text-center text-muted terms mt-2">Terms of use.Privacy policy</a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            .input-group-text {
                padding: 0.9rem 0.75rem
            }
        </style>
    @endpush

</x-backend.layouts.master>
