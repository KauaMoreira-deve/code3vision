@foreach ($fields as $name => $field)
    @php
        $rules = $field[$mode.'_rules'] ?? $field['rules'] ?? [];
        $required = in_array('required', $rules, true);
        $isWide = ($field['wide'] ?? false) || ($field['type'] ?? '') === 'textarea';
        $inputId = $mode.'-'.$name;
    @endphp
    <div class="form-field {{ $isWide ? 'field-wide' : '' }}">
        <label for="{{ $inputId }}">{{ $field['label'] }} @if($required)<span aria-hidden="true">*</span>@endif</label>

        @if (($field['type'] ?? 'text') === 'textarea')
            <textarea id="{{ $inputId }}" name="{{ $name }}" rows="4" {{ $required ? 'required' : '' }}>{{ $mode === 'create' ? old($name) : '' }}</textarea>
        @elseif (($field['type'] ?? 'text') === 'select')
            <select id="{{ $inputId }}" name="{{ $name }}" {{ $required ? 'required' : '' }}>
                <option value="">Selecione</option>
                @foreach (($field['options'] ?? []) as $optionValue => $optionLabel)
                    <option value="{{ $optionValue }}" @selected($mode === 'create' && (string) old($name) === (string) $optionValue)>
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
        @elseif (($field['type'] ?? 'text') === 'file')
            <input id="{{ $inputId }}" name="{{ $name }}" type="file" accept="{{ $field['accept'] ?? 'image/*' }}" {{ $required ? 'required' : '' }}>
            @if ($mode === 'edit')<small data-current-file="{{ $name }}"></small>@endif
        @else
            <input id="{{ $inputId }}" name="{{ $name }}" type="{{ $field['type'] ?? 'text' }}"
                   value="{{ $mode === 'create' ? old($name) : '' }}"
                   @if(isset($field['min'])) min="{{ $field['min'] }}" @endif
                   @if(isset($field['max'])) max="{{ $field['max'] }}" @endif
                   @if(isset($field['step'])) step="{{ $field['step'] }}" @endif
                   {{ $required ? 'required' : '' }}>
        @endif

        @if (! empty($field['help']))<small>{{ $field['help'] }}</small>@endif
    </div>
@endforeach
