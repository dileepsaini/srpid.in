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
                <form action="{{ route('admin.student.store') }}" method="POST" enctype="multipart/form-data" id="myform">
                    @csrf

                    <input type="hidden" name="cropped_profile" id="cropped_profile">
                    <input type="hidden" name="school_id" id="school_id" value="{{ $school_id }}">

                    <div class="row">
                        @foreach ($allFields as $field)
                            @continue(!in_array($field, $allowedFields)) {{-- 👈 Add this line to skip non-required fields --}}

                            @php
                                $label = ucwords(str_replace('_', ' ', $field));
                                $isRequired = '';
                                $fieldType = in_array($field, ['profile', 'father_image', 'mother_image', 'guardian_image']) ? 'file' : ($field === 'dob' ? 'text' : ($field === 'email_id' ? 'email' : 'text'));

                                $file_ex = '';
                                if($fieldType == 'file'){
                                    $file_ex = ' accept=".jpg,.jpeg,.png"'; 
                                }
                            @endphp

                            @if ($field === 'studen_signature')
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Student Signature </label>
                                    <canvas id="student-signature-pad" style="border: 1px solid #000; height: 150px; width: 100%;"></canvas>
                                    <input type="hidden" name="studen_signature" id="studen_signature" >
                                    <button type="button" class="btn btn-sm btn-warning mt-1" id="clear-student-signature">Clear</button>
                                </div>
                            @elseif ($field === 'employe_signature')
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Employee Signature </label>
                                    <canvas id="employe-signature-pad" style="border: 1px solid #000; height: 150px; width: 100%;"></canvas>
                                    <input type="hidden" name="employe_signature" id="employe_signature" >
                                    <button type="button" class="btn btn-sm btn-warning mt-1" id="clear-employe-signature">Clear</button>
                                </div>
                            @else
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ $label }} </label>
                                    <input type="{{ $fieldType }}" name="{{ $field }}" {!! $file_ex !!} class="form-control" >
                                </div>
                            @endif
                        @endforeach


                        <div class="col-12 mt-3">
                            <button type="submit" id="" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>



                </div>
            </div><!-- card end -->
        </div>
    </div>



<!-- Modal for cropping -->
<div class="modal" tabindex="-1" id="cropperModal">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crop Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div>
          <img id="cropperImage" style="max-width: 30%;">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop & Upload</button>
      </div>
    </div>
  </div>
</div>

<!-- Hidden field to hold base64 -->

@endsection


<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.6/dist/signature_pad.umd.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

@push('script')
<script>
let cropper;
const input = document.getElementById('profile');
const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
const image = document.getElementById('cropperImage');

input.addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file && /^image\/\w+/.test(file.type)) {
        const reader = new FileReader();
        reader.onload = function () {
            image.src = reader.result;
            modal.show();

            // wait until image is loaded
            image.onload = () => {
                if (cropper) cropper.destroy(); // destroy previous instance
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 1,
                });
            };
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('cropImageBtn').addEventListener('click', function () {
    const canvas = cropper.getCroppedCanvas({
        width: 200,
        height: 200
    });

    canvas.toBlob(function (blob) {
        const reader = new FileReader();
        reader.onloadend = function () {
            document.getElementById('cropped_profile').value = reader.result;
            modal.hide();
        };
        reader.readAsDataURL(blob);
    });
});
</script>

    <script>


    $(document).on('click', '#save_btn', function(){
                    const submitBtn = document.getElementById('save_btn');
                        $('#myform').submit();
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Submitting...'; // optional
        })

        const studentCanvas = document.getElementById('student-signature-pad');
    const employeCanvas = document.getElementById('employe-signature-pad');

    const studentPad = new SignaturePad(studentCanvas);
    const employePad = new SignaturePad(employeCanvas);

    // Resize canvas while preserving signature
    function resizeCanvas(canvas, pad) {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        const data = pad.toData(); // Save existing drawing

        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);

        pad.clear();
        pad.fromData(data); // Restore drawing
    }

    resizeCanvas(studentCanvas, studentPad);
    resizeCanvas(employeCanvas, employePad);

    window.addEventListener("resize", () => {
        resizeCanvas(studentCanvas, studentPad);
        resizeCanvas(employeCanvas, employePad);
    });

    // Clear buttons
    document.getElementById('clear-student-signature').addEventListener('click', () => studentPad.clear());
    document.getElementById('clear-employe-signature').addEventListener('click', () => employePad.clear());

    // On form submit, save signature as Base64
    document.getElementById('myform').addEventListener('submit', function () {
        if (!studentPad.isEmpty()) {
            document.getElementById('studen_signature').value = studentPad.toDataURL();
        }
        if (!employePad.isEmpty()) {
            document.getElementById('employe_signature').value = employePad.toDataURL();
        }
    });
    </script>
@endpush
<style>
    canvas {
    width: 100% !important;
    height: 150px !important;
    border: 1px solid #000;
}
</style>