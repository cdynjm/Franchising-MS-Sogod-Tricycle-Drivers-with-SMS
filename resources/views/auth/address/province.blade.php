@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

<select name="province" id="select-province" class="form-select" required>
    @if(!empty($province))
        <option value="">Select...</option>
        @foreach ($province as $prov)
            <option value="{{ $aes->encrypt($prov->provCode) }}">{{ ucwords(strtolower($prov->provDesc)) }}</option>
        @endforeach
    @else
        <option value="">Please select region first</option>
    @endif
</select>