<div class=" text-white g-card">
    <div class="card-header text-center">
        <h2>{{ __('Update your account') }}</h2>
        <h6><b>Joined</b></h6>
        {{ $user->created_at->format('d.m.Y') }}
    </div>

    <div class="card-body">
        <form id="form-change-username" role="form" method="POST" action="{{  route('change_username') }}" novalidate class="form-horizontal">

            @csrf
            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control text-muted" name="email" value="{{ old('email', $user->email ?? '') }}" disabled autocomplete="email">

                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                <div class="col-md-6">
                    <input type="text" class="form-control   @error('username') border-danger  @enderror" name="username" value="{{ old('username', $user->name ?? '')}}" required autocomplete="username">

                    <div class="text-danger pb-3">{{ $errors->first('username') }}</div>
                </div>
            </div>
            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-blue">
                        Change Username
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <form id="form-change-password" role="form" method="POST" action="{{ route('change_password') }}" novalidate class="form-horizontal">

            @csrf
            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }} row">

                <label for="new-password" class="col-md-4 col-form-label text-md-right">Current Password</label>

                <div class="col-md-6">
                    <input id="current-password" type="password" class="form-control  @error('current-password') border-danger  @enderror" name="current-password" required>
                    <div class="text-danger pb-3">{{ $errors->first('current-password') }}</div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} row">

                <label for="new-password" class="col-md-4 col-form-label text-md-right">New Password</label>

                <div class="col-md-6">
                    <input id="new-password" type="password" class="form-control  @error('new-password') border-danger  @enderror " name="new-password" required>
                    <div class="text-danger pb-3">{{ $errors->first('new-password') }}</div>
                </div>
            </div>
            <div class="form-group{{ $errors->has('new-password_confirmation') ? ' has-error' : '' }} row">

                <label for="new-password-confirm" class="col-md-4 col-form-label text-md-right"> Confirm New Password</label>

                <div class="col-md-6">
                    <input id="new-password-confirm" type="password" class="form-control  @error('new-password_confirmation') border-danger  @enderror" name="new-password_confirmation" required>
                    <div class="text-danger pb-3">{{ $errors->first('new-password_confirmation') }}</div>
                </div>
            </div>

            <div class="form-group">
                <div class="text-center">
                    <button type="submit" class="btn btn-blue">
                        Change Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
