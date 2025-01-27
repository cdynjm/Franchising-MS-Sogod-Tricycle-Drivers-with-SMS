@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

<select name="barangay" id="select-barangay" class="form-select" required>
    @if(!empty($barangay))
        <option value="">Select...</option>
        @foreach ($barangay as $brgy)
            <option value="{{ $aes->encrypt($brgy->brgyCode) }}">{{ $brgy->brgyDesc }}</option>
        @endforeach
    @else
        <option value="">Please select region, province & municipal first</option>
    @endif
</select>