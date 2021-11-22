<tr class="{{ !$checkedValue ? 'text-muted' : '' }}">
    <td role="button" data-toggle="permission">
        <span>@lang($permission->label)</span>&nbsp;-&nbsp;
        <em class="small">[{{ $permission->code }}]</em>&nbsp;&nbsp;
        <span>{{ $permission->description }}</span>
    </td>
    <td class="text-center">
        <div class="form-check d-inline-block">
            <input
                type="checkbox"
                class="form-check-input"
                id="checkbox-{{ str_replace('.', '-', $permission->code) }}"
                value="1"
                name="{{ $field->getName() }}[{{ $permission->code }}]"
                data-permission-group="{{ str_slug($permission->group) }}"
                @if ($checkedValue == 1) checked="checked" @endif
                @if ($this->previewMode) disabled="disabled" @endif
            />
            <label class="form-check-label" for="checkbox-{{ str_replace('.', '-', $permission->code) }}"></label>
        </div>
    </td>
</tr>
