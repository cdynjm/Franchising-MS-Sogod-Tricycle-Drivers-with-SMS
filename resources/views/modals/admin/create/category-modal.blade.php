<div class="modal fade" id="create-category-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">

        <!-- this modal will create a category for the type of tricycle -->

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Create Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="create-category">
                <div class="modal-body">

                    <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                        <span class="me-2">
                            <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                        </span>
                        <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                    </div>

                    <label for="" style="font-size: 12px;">Category Name</label>
                    <input type="text" name="category" pattern="[a-zA-Z]" maxlength="1" class="form-control mb-2" required>

                    <label for="" style="font-size: 12px;">Color Code</label>
                    <input type="text" name="color" class="form-control mb-2" required>

                    <label for="" style="font-size: 12px;">Description/Route</label>
                    <input type="text" name="description" class="form-control" required>

                    <label for="" style="font-size: 12px;">Sample Picture</label>
                    <input type="file" name="picture" id="create-sample-picture" accept=".jpg" class="form-control" required>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="" class="btn btn-sm btn-primary waves-effect waves-light">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', () => { 
    const compressImage = async (file, {
        quality = 1,
        type = file.type
    }) => {

        const imageBitmap = await createImageBitmap(file);

        const canvas = document.createElement('canvas');
        canvas.width = imageBitmap.width;
        canvas.height = imageBitmap.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(imageBitmap, 0, 0);

        const blob = await new Promise((resolve) =>
            canvas.toBlob(resolve, type, quality)
        );

        return new File([blob], file.name, {
            type: blob.type,
        });
    };

    const handleFileInputChange = async (e) => {
        const {
            files
        } = e.target;

        if (!files.length) return;

        const dataTransfer = new DataTransfer();

        for (const file of files) {

            if (!file.type.startsWith('image')) {

                dataTransfer.items.add(file);
                continue;
            }

            // Determine the type based on the uploaded file
            const compressType = file.type === 'image/png' ? 'image/png' : 'image/jpeg';

            const compressedFile = await compressImage(file, {
                quality: 0.3,
                type: compressType
            });

            dataTransfer.items.add(compressedFile);
        }

        e.target.files = dataTransfer.files;
    };

    const fileInputs = [
        document.querySelector('#create-sample-picture'),
    ];

    fileInputs.forEach(input => {
        input.addEventListener('change', handleFileInputChange);
    });
});
</script>