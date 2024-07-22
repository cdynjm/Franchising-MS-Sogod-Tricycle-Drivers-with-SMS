<div class="modal fade" id="update-category-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="update-category">
                <div class="modal-body">

                    <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                        <span class="me-2">
                            <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                        </span>
                        <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                    </div>

                    <input type="hidden" class="form-control" name="id" readonly>

                    <label for="" style="font-size: 12px;">Category Name</label>
                    <input type="text" name="category" class="form-control mb-2" required>

                    <label for="" style="font-size: 12px;">Color Code</label>
                    <input type="text" name="color" class="form-control mb-2" required>

                    <label for="" style="font-size: 12px;">Description/Route</label>
                    <input type="text" name="description" class="form-control" required>

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
