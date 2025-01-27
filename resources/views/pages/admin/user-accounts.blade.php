<!-- this page will retrieve data from the usersd table based on the selected category -->
<script>
    $(document).ready(function() {
        $('#category-user').select2({
            placeholder: "Select...",
            allowClear: true
        });
    });
</script>

<div id="selected-category-result" class="mb-3">
    <label for="" class="ms-1" style="font-size: 13px">User/Body Number <small class="text-danger">(Select category first)</small></label>
    <select name="id" id="category-user" class="form-control mb-3" required>
        @if(!empty($user))
            <option value="">Select User</option>
            <option value="1">No Account Yet? (Create)</option>
            @foreach ($user->sortBy('name') as $us)
                <option value="{{ $aes->encrypt($us->id) }}">{{ $us->name }}</option>
            @endforeach
        @else
            <option value="">Select...</option>
        @endif
    </select>
</div>

<style>

.select2-container .select2-selection--single {
    padding: 5px;
    height: auto; /* Ensure height is adjusted based on padding */
    border-radius:10px; /* Optional: to customize border-radius */
    border: 1px solid rgb(238, 238, 238);
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 50%; /* Center vertically */
    transform: translateY(-50%); /* Adjust positioning */
    right: 8px; /* Adjust distance from the right edge */
    position: absolute; /* Ensure the arrow remains in place */
}

</style>

<script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
