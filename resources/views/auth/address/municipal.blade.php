@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

<select name="municipal" id="select-municipal" class="form-select" required>
    @if(!empty($municipal))
        <option value="">Select...</option>
        @foreach ($municipal as $mun)
            <option value="{{ $aes->encrypt($mun->citymunCode) }}">{{ ucwords(strtolower($mun->citymunDesc)) }}</option>
        @endforeach
    @else
        <option value="">Please select region and province first</option>
    @endif
</select>