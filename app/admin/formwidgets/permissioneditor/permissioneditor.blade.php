<div class="permission-editor" {!! $field->getAttributes() !!}>
    <div class="table-responsive">
        <table class="table table-border mb-0">
            @foreach ($groupedPermissions as $group => $permissions)
                <thead>
                <tr>
                    <th class="{{ $loop->first ? '' : 'pt-4' }}">
                        <h5 class="panel-title">@lang($group)</h5>
                    </th>
                    <th class="{{ $loop->first ? '' : 'pt-4 ' }}text-center">
                        <a
                            role="button"
                            data-toggle="permission-group"
                            data-permission-group="{{ str_slug($group) }}"
                        >{{ lang('admin::lang.text_allow') }}</a>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($permissions as $permission)
                    {!! $this->makePartial('permissioneditor/permission', [
                        'permission' => $permission,
                        'checkedValue' => (int)(array_key_exists($permission->code, $checkedPermissions) ? $checkedPermissions[$permission->code] : 0),
                    ]) !!}
                @endforeach
                </tbody>
            @endforeach
        </table>
    </div>
</div>
