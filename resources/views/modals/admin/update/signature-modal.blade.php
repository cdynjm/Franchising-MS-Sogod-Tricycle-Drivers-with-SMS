<div class="modal fade" id="signature-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">

        <!-- this modal will update the signatures of the mayor and pnp chief for the certification -->

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Persons</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="update-signature">
                <div class="modal-body">

                    <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                        <span class="me-2">
                            <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                        </span>
                        <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                    </div>

                    <label for="" style="font-size: 12px;">Current Municipal Mayor</label>
                    <input type="text" name="mayor" id="mayor" class="form-control text-uppercase mb-2" required>

                    <label for="" style="font-size: 12px;">Current Chief of Police</label>
                    <input type="text" name="police" id="police" class="form-control text-uppeercase mb-2" required>

        

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
