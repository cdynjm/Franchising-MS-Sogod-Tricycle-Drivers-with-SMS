@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('app')

@section('content')
    <div id="layout-wrapper">
        @include('layouts.navbar', ['page' => '<div class="d-flex align-items-center"><iconify-icon icon="mingcute:upload-3-fill" width="24" height="24" class="me-2"></iconify-icon> Upload Forms</div>'])
        @include('layouts.sidebar')
        @include('layouts.horizontal-topbar')

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- in this section, it will display all the franchise history records of that number/unit. refer to the data folder -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mt-4 rounded-1">
                                <div class="card-header">
                                    <div class="d-flex flex-row justify-content-between">
                                        <div>
                                            <h6 class="text-sm">
                                                @if(empty($franchise->applicationForm) && empty($franchise->permitForm) && empty($franchise->confirmationForm) && empty($franchise->provisionalForm))
                                                Upload your current fanchise forms with signatures here:
                                                @else
                                                Uploaded Forms with Signatures
                                                @endif
                                            </h6>
                                        </div>
                                        <div>
                                            <button class="btn btn-sm btn-primary shadow-lg d-flex" id="collapse-display-for-forms">
                                                <iconify-icon icon="majesticons:arrows-collapse-full-line" width="20" class="me-1"></iconify-icon> Collapse
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body" id="forms-content">
                                   
                                    @if(empty($franchise->applicationForm) && empty($franchise->permitForm) && empty($franchise->confirmationForm) && empty($franchise->provisionalForm))

                                    <form action="" id="upload-form-with-signature" data-id="{{ $aes->encrypt($franchise->id) }}">
                                            <div class="processing alert p-1 alert-sm alert-success align-items-center" style="display: none">
                                                <span class="me-2">
                                                    <i class="mdi mdi-spin mdi-loading fs-3 ms-2"></i>
                                                </span>
                                                <div class="text-secondary" style="font-size: 13px;">Loading...</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-4">
                                                    <label for="" style="font-size: 12px">Application Form</label>
                                                    <input type="file" class="form-control" id="application-form" name="applicationForm" accept=".jpg" required>

                                                    <label for="" style="font-size: 12px">Permit Form</label>
                                                    <input type="file" class="form-control" id="permit-form" name="permitForm" accept=".jpg" required>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <label for="" style="font-size: 12px">Confirmation Form</label>
                                                    <input type="file" class="form-control" id="confirmation-form" name="confirmationForm" accept=".jpg" required>

                                                    <label for="" style="font-size: 12px">Provisional Form</label>
                                                    <input type="file" class="form-control" id="provisional-form" name="provisionalForm" accept=".jpg" required>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <button class="btn btn-sm btn-primary">
                                                        Upload
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    
                                        <hr>
                                    @endif

                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <label for="">APPLICATION FORM</label>
                                                <img src="{{ asset('storage/files/'.$franchise->applciationForm) }}" class="img-fluid rounded-2 shadow-lg" alt="">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label for="">PERMIT FORM</label>
                                                <img src="{{ asset('storage/files/'.$franchise->permitForm) }}" class="img-fluid rounded-2 shadow-lg" alt="">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label for="">CONFIRMATION FORM</label>
                                                <img src="{{ asset('storage/files/'.$franchise->confirmationForm) }}" class="img-fluid rounded-2 shadow-lg" alt="">
                                            </div>
                                            <div class="col-md-12 mb-4">
                                                <label for="">PROVISIONAL FORM</label>
                                                <img src="{{ asset('storage/files/'.$franchise->provisionalForm) }}" class="img-fluid rounded-2 shadow-lg" alt="">
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

                                            const compressedFile = await compressImage(file, {
                                                quality: 0.3,
                                                type: 'image/jpeg'
                                            });

                                            dataTransfer.items.add(compressedFile);
                                        }

                                        e.target.files = dataTransfer.files;
                                    };

                                    const fileInputs = [
                                        document.querySelector('#application-form'),
                                        document.querySelector('#permit-form'),
                                        document.querySelector('#confirmation-form'),
                                        document.querySelector('#provisional-form')
                                    ];

                                    fileInputs.forEach(input => {
                                        input.addEventListener('change', handleFileInputChange);
                                    });
                                });
                                </script>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            @include('layouts.footer-auth')
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->
@endsection
