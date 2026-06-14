@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-3">
                  @php
                    $allFields = [
                        'student_name', 'profile', 'email_id', 'mobile', 'address', 'father_name', 'father_image',
                        'mother_name', 'mother_image', 'guardian_image', 'dob', 'class', 'section', 'session', 'adm_no',
                        'studen_signature', 'employe_signature', 'medium', 'bus', 'blood_group', 'roll_no',
                        'designation', 'husband_name', 'emp_id', 'emp_name', 'blank_1', 'blank_2'
                    ];
                @endphp

              <form action="{{ route('admin.student.store', $student->id) }}" method="POST" enctype="multipart/form-data" id="myform">
                @csrf

                                    <input type="hidden" name="cropped_profile" id="cropped_profile">

                <div class="row">
                   @foreach ($allFields as $field)
                        @continue(!in_array($field, $allowedFields)) {{-- Show only required fields --}}

                        @php
                            $label = ucwords(str_replace('_', ' ', $field));
                            $value = old($field, $student->$field ?? '');

                            $isImageField = in_array($field, ['profile', 'father_image', 'mother_image', 'guardian_image']);
                            $hasExisting = !empty($value);
                            $isSignature = in_array($field, ['studen_signature', 'employe_signature']);

                            // Required if: field is in allowed list, and (not image or no existing value)
                            $isRequired = (!$isImageField || !$hasExisting) ? '' : '';

                            // Input type
                            $fieldType = $isImageField ? 'file' : ($field === 'dob' ? 'text' : ($field === 'email_id' ? 'email' : 'text'));
                            $fileAccept = $isImageField ? 'accept=".jpg,.jpeg,.png"' : '';
                        @endphp

                        {{-- Signature Pad --}}
                        @if ($isSignature)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }} 
                                    @if ($isRequired)<span class="text-danger">*</span>@endif
                                </label>
                                <canvas id="{{ $field }}-pad" class="signature-pad" style="border: 1px solid #000; height: 150px; width: 100%;"></canvas>
                                <input type="hidden" name="{{ $field }}" id="{{ $field }}" {{ $isRequired }}>
                                <button type="button" class="btn btn-sm btn-warning mt-1" id="clear-{{ $field }}">Clear</button>

                                @if ($hasExisting)
                                    <div class="mt-2">
                                        <strong>Existing Signature:</strong><br>
                                        <img class="show_img" src="{{ asset('students/' . $value) }}" alt="Signature" height="80">
                                    </div>
                                @endif
                            </div>

                        {{-- Image/File Input --}}
                        @elseif ($isImageField)
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}
                                    @if ($isRequired)<span class="text-danger">*</span>@endif
                                </label>
                                <input type="file" name="{{ $field }}" class="form-control" {!! $fileAccept !!} {{ $isRequired }}>

                                @if ($hasExisting)
                                    <div class="mt-2">
                                        <strong>Existing Image:</strong><br>
                                        <img class="show_img" src="{{ asset('students/' . $value) }}" alt="{{ $label }}" height="80">
                                    </div>
                                @endif
                            </div>

                        {{-- Text/Date/Email Fields --}}
                        @else
                            <div class="col-md-6 mb-3">
                                <label class="form-label">{{ $label }}
                                    @if ($isRequired)<span class="text-danger">*</span>@endif
                                </label>
                                <input type="{{ $fieldType }}" name="{{ $field }}" class="form-control" value="{{ $value }}" {{ $isRequired }}>
                            </div>
                        @endif
                    @endforeach


                    <div class="col-12 mt-3">
                        <button type="submit" id="" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>




                </div>
            </div><!-- card end -->
        </div>
    </div>
@endsection
    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                <div class="modal-body text-center " id="show_img">
                   
                </div>
               
            </div>
        </div>
    </div>

<!-- Modal for cropping (same as your existing modal) -->
<!-- Modal for cropping -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crop Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="cropperWrapper" style="width: 100%; height: 60vh;">
          <img id="cropperImage" style="max-width: 100%; display: block;">
        </div>
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop & Save</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>


@push('script')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

<script>
    const studentCanvas = document.getElementById('studen_signature-pad');
    const employeCanvas = document.getElementById('employe_signature-pad');

    let studentPad = null;
    let employePad = null;

    if (studentCanvas) {
        studentPad = new SignaturePad(studentCanvas);
        document.getElementById('clear-studen_signature').addEventListener('click', () => studentPad.clear());
    }
    
    if (employeCanvas) {
        employePad = new SignaturePad(employeCanvas);
        document.getElementById('clear-employe_signature').addEventListener('click', () => employePad.clear());
    }

    // Resize canvas while preserving signature
    function resizeCanvas(canvas, pad) {
        if (!canvas || !pad) return;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const data = pad.toData(); // Save existing drawing

        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        pad.clear();
        pad.fromData(data); // Restore drawing
    }

    if (studentCanvas) resizeCanvas(studentCanvas, studentPad);
    if (employeCanvas) resizeCanvas(employeCanvas, employePad);

    window.addEventListener("resize", () => {
        if (studentCanvas) resizeCanvas(studentCanvas, studentPad);
        if (employeCanvas) resizeCanvas(employeCanvas, employePad);
    });

    // On form submit, save signature as Base64
    document.getElementById('myform').addEventListener('submit', function () {
        if (studentPad && !studentPad.isEmpty()) {
            document.getElementById('studen_signature').value = studentPad.toDataURL();
        }
        if (employePad && !employePad.isEmpty()) {
            document.getElementById('employe_signature').value = employePad.toDataURL();
        }
    });

      $(document).on('click', '#save_btn', function(){
                    const submitBtn = document.getElementById('save_btn');
                        $('#myform').submit();
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Submitting...'; // optional
        })



</script>
<script>
let cropper;
const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
const image = document.getElementById('cropperImage');
const profileInput = document.getElementById('profile');

// File input change handler
profileInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file || !file.type.match('image.*')) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        image.src = e.target.result;
        modal.show();

        image.onload = function() {
            if (cropper) cropper.destroy();
            
            // Initialize cropper with 3:4 aspect ratio
            cropper = new Cropper(image, {
                aspectRatio: 3/4,
                viewMode: 1,
                autoCropArea: 0.8,
                responsive: true,
                movable: true,
                zoomable: true,
                rotatable: true,
                minCropBoxWidth: 200,
                minCropBoxHeight: 266, // 3:4 ratio
                ready: function() {
                    this.cropper.setDragMode('move');
                }
            });
        };
    };
    reader.readAsDataURL(file);
});

// Crop button handler
document.getElementById('cropImageBtn').addEventListener('click', function() {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 600,     // 3x
        height: 800,    // 4x (3:4 ratio)
        minWidth: 300,
        minHeight: 400,
        maxWidth: 900,
        maxHeight: 1200,
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });

    canvas.toBlob(function(blob) {
        // Create a new file with the cropped image
        const croppedFile = new File([blob], 'profile.jpg', { type: 'image/jpeg' });
        
        // Create a DataTransfer object to set the new file
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(croppedFile);
        
        // Update the file input with the cropped image
        profileInput.files = dataTransfer.files;
        
        // Hide the modal
        modal.hide();
        
        // // Optional: Preview the cropped image
        // const previewUrl = URL.createObjectURL(blob);
        // const previewImg = document.createElement('img');
        // previewImg.src = previewUrl;
        // previewImg.style.width = '180px';
        // previewImg.style.height = '240px';
        // previewImg.style.objectFit = 'cover';
        
        // // Replace or add the preview image in your form
        // const previewContainer = document.getElementById('profile-preview') || document.body;
        // previewContainer.innerHTML = '';
        // previewContainer.appendChild(previewImg);
        
    }, 'image/jpeg', 0.9); // 90% quality
});
</script>

@endpush
<style>
    /* Android-specific cropper fixes */
    .cropper-container.cropper-bg {
        width: 100% !important;
        height: 300px !important;
        max-height: 70vh !important;
    }
    
    /* Ensure proper image display on Android */
    .cropper-img {
        max-width: 100% !important;
        height: auto !important;
    }
    
    /* Modal adjustments for Android */
    @media (max-width: 768px) {
        .cropper-modal-container {
            padding: 0 !important;
        }
        .cropper-container.cropper-bg {
            height: 60vh !important;
        }
    }
</style>