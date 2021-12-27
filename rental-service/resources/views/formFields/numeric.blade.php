<input type="number"
       class="form-control"
       name="{{ $row->field }}"
       type="number"
       @if($row->required == 1) required @endif
       @if(isset($options->min)) min="{{ $options->min }}" @endif
       @if(isset($options->max)) max="{{ $options->max }}" @endif
       @if(isset($options->disabled)) readonly="true" @endif
       @if(isset($options->readonly)) readonly="true" @endif
       step="{{ $options->step ?? 'any' }}"
       placeholder="{{ old($row->field, $options->placeholder ?? $row->getTranslatedAttribute('display_name')) }}"
       value="{{ old($row->field, $dataTypeContent->{$row->field} ?? $options->default ?? '0') }}">
@if ((isset($options->disabled) || isset($options->readonly)))
    @if ((($dataTypeContent->{$row->field}) ?? $options->default ?? 0) <= 0)
        <input type="hidden"
               name="{{ $row->field }}"
               value="0">
    @endif
@endif
