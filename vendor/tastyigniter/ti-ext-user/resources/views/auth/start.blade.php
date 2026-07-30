<div class="container mt-5">
    <div class="col-6 mx-auto">
        <div class="card">
            <div class="card-body">
                {!! form_open([
                    'id' => 'edit-form',
                    'role' => 'form',
                    'method' => 'POST',
                    'data-request' => 'onCompleteSetup',
                ]) !!}
                <h3>@lang('igniter.user::default.login.text_initial_setup_title')</h3>
                <p>@lang('igniter.user::default.login.help_create_super_admin')</p>

                <h5 class="mt-4 mb-3">
                    <i class="fas fa-user-tie"></i>&nbsp;&nbsp;@lang('igniter.user::default.text_super_admin')
                </h5>
                <div class="form-group">
                    <label
                        for="input-name"
                        class="form-label"
                    >@lang('igniter.user::default.staff.label_full_name')</label>
                    <input name="name" type="text" id="input-name" class="form-control" value="{{old('name')}}"/>
                    {!! form_error('name', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-email"
                        class="form-label"
                    >@lang('igniter.user::default.login.label_email')</label>
                    <input name="email" type="email" id="input-email" class="form-control" value="{{old('email')}}"/>
                    {!! form_error('email', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-password"
                        class="form-label"
                    >@lang('igniter.user::default.login.label_password')</label>
                    <input name="password" type="password" id="input-password" class="form-control" value="{{old('password')}}"/>
                    {!! form_error('password', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-password-confirm"
                        class="form-label"
                    >@lang('igniter.user::default.staff.label_confirm_password')</label>
                    <input name="password_confirm" type="password" id="input-password-confirm" class="form-control" value="{{old('password_confirm')}}"/>
                    {!! form_error('password_confirm', '<span class="text-danger">', '</span>') !!}
                </div>

                <h5 class="mt-4 mb-3">
                    <i class="fas fa-store"></i>&nbsp;&nbsp;@lang('igniter.user::default.text_restaurant_details')
                </h5>
                <div class="form-group">
                    <label
                        for="input-restaurant-name"
                        class="form-label"
                    >@lang('igniter.user::default.staff.label_restaurant_name')</label>
                    <input name="restaurant_name" type="text" id="input-restaurant-name" class="form-control" value="{{old('restaurant_name', setting('site_name'))}}"/>
                    {!! form_error('restaurant_name', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-restaurant-email"
                        class="form-label"
                    >@lang('igniter.user::default.staff.label_restaurant_email')</label>
                    <input name="restaurant_email" type="text" id="input-restaurant-email" class="form-control" value="{{old('restaurant_email', setting('site_email'))}}"/>
                    {!! form_error('restaurant_email', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-telephone"
                        class="form-label"
                    >@lang('igniter.local::default.label_telephone')</label>
                    <input name="telephone" type="text" id="input-telephone" class="form-control" value="{{old('telephone')}}"/>
                    {!! form_error('telephone', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-address"
                        class="form-label"
                    >@lang('igniter.local::default.label_address_1')</label>
                    <input name="address_1" type="text" id="input-address" class="form-control" value="{{old('address_1')}}"/>
                    {!! form_error('address_1', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-city"
                        class="form-label"
                    >@lang('igniter.local::default.label_city')</label>
                    <input name="city" type="text" id="input-city" class="form-control" value="{{old('city')}}"/>
                    {!! form_error('city', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-state"
                        class="form-label"
                    >@lang('igniter.local::default.label_state')</label>
                    <input name="state" type="text" id="input-state" class="form-control" value="{{old('state')}}"/>
                    {!! form_error('state', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-postcode"
                        class="form-label"
                    >@lang('igniter.local::default.label_postcode')</label>
                    <input name="postcode" type="text" id="input-postcode" class="form-control" value="{{old('postcode')}}"/>
                    {!! form_error('postcode', '<span class="text-danger">', '</span>') !!}
                </div>
                <div class="form-group">
                    <label
                        for="input-country"
                        class="form-label"
                    >@lang('igniter.user::default.account.label_country')</label>
                    <select name="country_id" id="input-country" data-control="selectlist" class="form-select">
                        <option value="">Select Country</option>
                        @foreach (countries() as $key => $value)
                            <option value="{{ $key }}" {{ old('country_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    {!! form_error('country_id', '<span class="text-danger">', '</span>') !!}
                </div>

                <div class="form-group">
                    <button
                        type="submit"
                        class="btn btn-primary btn-block"
                        data-attach-loading=""
                    >@lang('igniter.user::default.login.button_complete_setup')
                    </button>
                </div>

                {!! form_close() !!}
            </div>
        </div>
    </div>
</div>
