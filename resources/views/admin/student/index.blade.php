@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
              <label for="">Select School</label>
               
               
             <select class="form-control all_filter" name="select_school" id="select_school" multiple>
                <option value="">Choose School</option>
              
                @foreach ($all_school as $key => $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label for="">Select Class</label>
              <select class="form-control all_filter" name="select_class" id="select_class" multiple>
                    <option value="">Choose Class</option>
                     @foreach ($distinctClasses as $key => $class)
                        <option value="{{ $class->class }}">{{ $class->class }}</option>
                    @endforeach
              </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
              <label for="">Select Status</label>
              <select class="form-control all_filter" name="select_status" id="select_status" multiple>
                    <option value="">Choose Status</option>
                    <option value="0">Pending</option>
                    <option value="1">Complated</option>
              
              </select>
            </div>
        </div>
        <div class="col-md-3"> 
            <button type="button" class="btn btn-primary filder_submit mt-30">Search</button>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-3">
                   {{-- Desktop Table --}}
                    <div class="table-responsive d-none d-md-block" style="height: 500px;overflow: auto;">
                        <table class="table table-bordered" id="studenDatatable">
                            <thead>
                                <tr>
                               <th><input type="checkbox" id="selectAll"></th> {{-- âœ… Select All --}}
                                   
                                    @foreach ($allowedFields as $field)
                                        <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                                        @if($field === 'profile')
                                            <th>Profile Path</th>
                                        @endif
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    {{-- Mobile Cards --}}
                  {{-- Mobile Cards --}}
              <div class="d-md-none">
                    <div id="studentCards"></div>

                    <div class="text-center my-3">
                        <button id="loadMoreBtn" class="btn btn-outline-primary">Load More...</button>
                    </div>
                </div>
             


    {{-- Optional Load More Button --}}
    {{-- <div class="text-center mt-3">
        <button id="loadMoreBtn" class="btn btn-outline-primary">Load More</button>
    </div> --}}
</div>


                </div>
            </div><!-- card end -->
        </div>
    </div>

  <!--<input type="file" id="imageUploadInput" class="d-none" accept="image/*">-->
  <!--<input type="file" id="hiddenFileInput" accept="image/*" capture="environment" style="display: none;"> -->


    <!-- Modal -->
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                <div class="modal-body text-center " id="show_img">
                   
                </div>
               
            </div>
        </div>
    </div>
   <input type="hidden" name="">
  
  
  
  
  <input type="file" id="hiddenFileInput" accept="image/*" capture="environment" style="display: none;">

<!-- Crop Modal -->
<div class="modal fade cropper-modal-container" id="cropperModal" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Crop Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div id="cropperWrapper" style="width:100%; height:300px;">
          <img id="cropperImage" class="cropper-img">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="cropImageBtn" class="btn btn-primary">Crop & Upload</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="SelectSchool" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select School</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                
                 @php
                                use Illuminate\Support\Facades\Auth;

                                   $adminId       = auth()->guard('admin')->id();
                        @endphp
              <select class="form-control" name="select_school_1" id="select_school_1" >
                <option value="">Choose School</option>
                @foreach ($all_school as $key => $school)
                    @if($adminId != $school->id)
                    <option value="{{ $school->id }}" >{{ $school->name }}</option>
                    @endif
                @endforeach
            </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary addNew">Add Student</button>
            </div>
        </div>
    </div>
</div>
@endsection

  @php

                                   $adminId       = auth()->guard('admin')->id();
             @endphp


@push('breadcrumb-plugins')
    @permit('admin.student.store')
        <button class="btn btn-outline--primary " data-modal_title="@lang('Add New Student')" type="button">
            {{-- {{ Route('admin.student.create') }} --}}
           
                        
          @if($adminId == 1)
                <a href="#" rel="noopener noreferrer" class="add_student">
                    <i class="la la-plus"></i>@lang('Add New')
                </a>
            @else
                <a href="{{ route('admin.student.create') }}?school_id={{ $adminId }}" rel="noopener noreferrer">
                    <i class="la la-plus"></i>@lang('Add New')
                </a>
            @endif

        </button>
    @endpermit
     @permit('admin.student.download')
        <button type="button" class="btn btn-primary dowanload">Download Photos</button>
 @endpermit
        @permit('admin.student.import')
          <button class=""  type="button">
             <a class="btn btn--12" href="{{ route('admin.student.importAll') }}">
                            @lang('Import CSV')</a>
        </button>
                       
         @endpermit
   
        @permit('admin.student.bulkDelete')
        <button type="button" id="deleteSelected" class=""><a class="btn btn--red" href="#">
                            @lang('Delete Selected')</a></button>

       
                       
         @endpermit
   
    @php
        $params = request()->all();
    @endphp
          
    @permit('admin.student.csv')
        <div class="btn-group">
            <button class="btn btn-outline--success dropdown-toggle" data-bs-toggle="dropdown" type="button" aria-expanded="false">
                @lang('Action')
            </button>
            <ul class="dropdown-menu">
                @permit('admin.student.csv')
                    <li>
                        <a class="dropdown-item dowanloadCSV" href="#"><i class="la la-download"></i>@lang('Download CSV')</a>
                    </li>
                    <li>
                        <a class="dropdown-item dowanloadExcel" href="#"><i class="las la-file-excel"></i>@lang('Download Excel')</a>
                    </li>
                @endpermit
             
            </ul>
        </div>
    @endpermit
@endpush
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
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
@push('script')
<script>
let cropper, selectedBlob = null;
let uploadInfo = { id: null, type: null, targetImg: null };

const input = document.getElementById('hiddenFileInput');
const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
const image = document.getElementById('cropperImage');
const wrapper = document.getElementById('cropperWrapper');

// Enhanced device detection
function isMobileDevice() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

// Click image => open file input
$(document).on('click', '.updateImg', function() {
    uploadInfo.id = $(this).data('id');
    uploadInfo.type = $(this).attr('data-type');
    uploadInfo.targetImg = this;
    input.click();
});

// File selected
input.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file || !file.type.match('image.*')) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        image.src = e.target.result;
        modal.show();

        image.onload = function() {
            if (cropper) cropper.destroy();
            
            // Set dynamic height based on device
            const isMobile = isMobileDevice();
            const containerHeight = isMobile ? '70vh' : '500px'; // Taller for 3:5 ratio
            wrapper.style.height = containerHeight;
            
            // Cropper options with 3:5 aspect ratio
            cropper = new Cropper(image, {
                aspectRatio: 3/4, // 3x5 aspect ratio
                viewMode: isMobile ? 1 : 3,
                autoCropArea: 0.8,
                responsive: true,
                restore: false,
                checkCrossOrigin: false,
                checkOrientation: true,
                guides: true,
                center: true,
                highlight: true,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
                minContainerWidth: 300,
                minContainerHeight: 500, // Minimum height for 3:5 ratio
                minCanvasWidth: 180,    // 3x
                minCanvasHeight: 300,   // 5x
                minCropBoxWidth: 180,   // 3x
                minCropBoxHeight: 300,  // 5x
                ready: function() {
                    this.cropper.setDragMode('move');
                    // Additional mobile fix
                    if (isMobile) {
                        setTimeout(() => {
                            this.cropper.render();
                            this.cropper.crop();
                        }, 200);
                    }
                }
            });
        };
    };
    reader.readAsDataURL(file);
});

// Enhanced compressBlob function for 500KB target
function compressBlob(blob, targetSizeKB = 500, callback, quality = 0.9, attempts = 7) {
    if (attempts === 0) {
        callback(blob);
        return;
    }

    const reader = new FileReader();
    reader.onload = function(event) {
        const img = new Image();
        img.onload = function() {
            // Calculate dimensions to maintain 3:5 aspect ratio
            const targetWidth = 600;  // 3x
            const targetHeight = 1000; // 5x
            let width = img.width;
            let height = img.height;
            
            // Scale down if original is larger than target
            if (width > targetWidth || height > targetHeight) {
                const ratio = Math.min(targetWidth/width, targetHeight/height);
                width = width * ratio;
                height = height * ratio;
            }

            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            
            const ctx = canvas.getContext('2d');
            ctx.imageSmoothingQuality = 'high';
            ctx.drawImage(img, 0, 0, width, height);
            
            canvas.toBlob(function(newBlob) {
                if (!newBlob || newBlob.size <= targetSizeKB * 1024 || quality <= 0.6) {
                    callback(newBlob || blob);
                } else {
                    const sizeRatio = newBlob.size / (targetSizeKB * 1024);
                    const qualityStep = sizeRatio > 2 ? 0.1 : 0.05;
                    compressBlob(blob, targetSizeKB, callback, Math.max(0.6, quality - qualityStep), attempts - 1);
                }
            }, 'image/jpeg', quality);
        };
        
        img.onerror = function() {
            callback(blob);
        };
        
        img.src = event.target.result;
    };
    
    reader.onerror = function() {
        callback(blob);
    };
    
    reader.readAsDataURL(blob);
}

// Crop & Upload with 3:5 aspect ratio
$(document).on('click', '#cropImageBtn', function () {
    if (!cropper) return;

    const submitBtn = document.getElementById('cropImageBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

    // Get canvas with 3:5 aspect ratio (600x1000 pixels)
    const canvas = cropper.getCroppedCanvas({
        width: 600,    // 3x
        height: 1000,   // 5x
        minWidth: 600,
        minHeight: 1000,
        maxWidth: 600,
        maxHeight: 1000,
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high'
    });

    canvas.toBlob(function (blob) {
        if (!uploadInfo.id || !uploadInfo.type) return;

        // Compress the blob to max 500KB
        compressBlob(blob, 500, function(compressedBlob) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('id', uploadInfo.id);
            formData.append('type', uploadInfo.type);
            formData.append('image', compressedBlob, 'student_image_3x5.jpg');

            $.ajax({
                url: "{{ route('admin.student.ImgUpdate') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res.success && res.image_path) {
                        const newSrc = res.image_path + '?t=' + new Date().getTime();
                        $(uploadInfo.targetImg).attr('src', newSrc).css({
                            'width': '180px',   // 3x
                            'height': '300px',  // 5x
                            'object-fit': 'cover',
                            'display': 'block'
                        });
                        loadStudentCards(currentPage, all_filter);
                        $('#cropperModal').modal('hide');
                    } else {
                        toastr.error("Upload failed.");
                    }
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Crop & Upload';
                },
                error: function () {
                    toastr.error("Server error occurred.");
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Crop & Upload';
                }
            });
        });
    }, 'image/jpeg', 0.9);
});
</script>

    <script>
    
//     let cropper, selectedBlob = null;
// let uploadInfo = { id: null, type: null, targetImg: null };

// const input = document.getElementById('hiddenFileInput');
// const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
// const image = document.getElementById('cropperImage');

// // Click image => open file input
// $(document).on('click', '.updateImg', function () {
//     uploadInfo.id = $(this).data('id');
//     uploadInfo.type = $(this).attr('data-type');
//     uploadInfo.targetImg = this;
//     input.click();
// });

// // File selected
// input.addEventListener('change', function (e) {
//     const file = e.target.files[0];
//     if (file && /^image\/\w+/.test(file.type)) {
//         const reader = new FileReader();
//         reader.onload = function () {
//             image.src = reader.result;
//             modal.show();

//             image.onload = () => {
//                 if (cropper) cropper.destroy();
//                 cropper = new Cropper(image, {
//                     aspectRatio: 1,
//                     viewMode: 3, // viewMode 3 restricts to crop box
//                     autoCropArea: 1,
//                     responsive: true,
//                     zoomable: true,
//                     minCropBoxWidth: 200,
//                     minCropBoxHeight: 200,
//                     cropBoxResizable: false // Disable resizing of crop box
//                 });
//             };
//         };
//         reader.readAsDataURL(file);
//     }
// });

// // Function to compress blob to target size (75KB)
// function compressBlob(blob, targetSizeKB, callback, quality = 0.9, attempts = 5) {
//     if (attempts === 0) {
//         callback(blob);
//         return;
//     }

//     const reader = new FileReader();
//     reader.onload = function(event) {
//         const img = new Image();
//         img.onload = function() {
//             const canvas = document.createElement('canvas');
//             canvas.width = img.width;
//             canvas.height = img.height;
//             const ctx = canvas.getContext('2d');
//             ctx.drawImage(img, 0, 0);
            
//             canvas.toBlob(function(newBlob) {
//                 if (newBlob.size <= targetSizeKB * 1024 || quality <= 0.1) {
//                     callback(newBlob);
//                 } else {
//                     compressBlob(blob, targetSizeKB, callback, quality - 0.1, attempts - 1);
//                 }
//             }, 'image/jpeg', quality);
//         };
//         img.src = event.target.result;
//     };
//     reader.readAsDataURL(blob);
// }

// // Crop & Upload
// $(document).on('click', '#cropImageBtn', function () {
//     if (!cropper) return;

//     const submitBtn = document.getElementById('cropImageBtn');
//     submitBtn.disabled = true;
//     submitBtn.textContent = 'Submitting...';

//     // Get canvas with fixed 200x200 size
//     const canvas = cropper.getCroppedCanvas({
//         width: 200,
//         height: 200,
//         minWidth: 200,
//         minHeight: 200,
//         maxWidth: 200,
//         maxHeight: 200,
//         fillColor: '#fff' // background for transparent images
//     });

//     canvas.toBlob(function (blob) {
//         if (!uploadInfo.id || !uploadInfo.type) return;

//         // Compress the blob to max 75KB
//         compressBlob(blob, 75, function(compressedBlob) {
//             const formData = new FormData();
//             formData.append('_token', '{{ csrf_token() }}');
//             formData.append('id', uploadInfo.id);
//             formData.append('type', uploadInfo.type);
//             formData.append('image', compressedBlob);

//             $.ajax({
//                 url: "{{ route('admin.student.ImgUpdate') }}",
//                 type: 'POST',
//                 data: formData,
//                 processData: false,
//                 contentType: false,
//                 success: function (res) {
//                     if (res.success && res.image_path) {
//                         $(uploadInfo.targetImg).attr('src', res.image_path + '?t=' + new Date().getTime());
//                         loadStudentCards(currentPage, all_filter);
//                         $('#cropperModal').modal('hide');
//                     } else {
//                         toastr.error("Upload failed.");
//                     }
//                     submitBtn.disabled = false;
//                     submitBtn.textContent = 'Crop & Upload';
//                 },
//                 error: function () {
//                     toastr.error("Server error occurred.");
//                     submitBtn.disabled = false;
//                     submitBtn.textContent = 'Crop & Upload';
//                 }
//             });
//         });
//     }, 'image/jpeg', 0.9); // Start with 90% quality
// });
///////////


// Step 1: When image is clicked
// Bind only once - outside click
$('#SelectSchool').on('shown.bs.modal', function () {
    $('#select_school_1').select2({
        dropdownParent: $('#SelectSchool'),
        placeholder: "Select School"
    });
});

// Then trigger the modal on click
$(document).on('click', '.add_student', function () {
    $('#SelectSchool').modal('show');
});
$(document).on('click', '.addNew', function () {
    var school = $('#select_school_1').val();
  
    if(school == ''){
        alert('Please select school');
        return false;
    }else{
                window.location.href = "{{ route('admin.student.create') }}?school_id=" + encodeURIComponent(school);

    }
  

});
        (function($) {
            "use strict"
            $(".importBtn").on('click', function(e) {
                let importModal = $("#importModal");
                importModal.modal('show');
            });
        })(jQuery);
    const allFields = [
        'student_name', 'profile', 'email_id', 'mobile', 'address', 'father_name', 'father_image',
        'mother_name', 'mother_image', 'guardian_image', 'dob', 'class', 'section', 'session', 'adm_no',
        'studen_signature', 'employe_signature', 'medium', 'bus', 'blood_group', 'roll_no',
        'designation', 'husband_name', 'emp_id', 'emp_name', 'blank_1', 'blank_2', 'created_at'
    ];
        const allowedFields = @json($allowedFields);
        const all_filter = {};
            $(document).on('click', '.filder_submit', function () {
                var select_school = $("[name=select_school]").val(); 
                var select_class = $("[name=select_class]").val(); 
                var select_status = $("[name=select_status]").val(); 
             
                sessionStorage.setItem('student_filter_school', JSON.stringify(select_school || []));
                sessionStorage.setItem('student_filter_class', JSON.stringify(select_class || []));
                sessionStorage.setItem('student_filter_status', JSON.stringify(select_status || []));

                all_filter['select_school'] = select_school;
                all_filter['select_class'] = select_class;
                all_filter['select_status'] = select_status;

                initOrderTable(all_filter)
                 loadStudentCards(1, all_filter) 
            });

         $(document).on('click', '.dowanload', function () {
    const schoolId = $('#select_school').val();
    const className = $('#select_class').val();

    $.ajax({
        url: '{{ route('admin.student.download') }}',
        method: 'GET',
        data: {
            'filter[school_id]': schoolId,
            'filter[class]': className
        },
        beforeSend: function () {
            $('#downloadZipBtn').prop('disabled', true).text('Creating ZIP...');
        },
        success: function (response) {
            if (response.success && response.url) {
                // Open download in new tab
                window.open(response.url, '_blank');

                // Or trigger direct download:
                // window.location.href = response.url;
            } else {
                alert('ZIP creation failed.');
                console.error(response);
            }
        },
        error: function (xhr, status, error) {
            console.error('ZIP Error:', error);
            alert('Something went wrong while creating the ZIP.');
        },
        complete: function () {
            $('#downloadZipBtn').prop('disabled', false).text('Download ZIP');
        }
    });
});

            
            
          $(document).on('click', '.dowanloadCSV', function(){
                const schoolId = $('#select_school').val();  // or get from your filter logic
                const className = $('#select_class').val();

                let url = '{{ route('admin.student.csv') }}' + '?';
                url += $.param({
                    'filter[school_id]': schoolId,
                    'filter[class]': className
                });
                window.location.href = url; // Triggers download
            });

          $(document).on('click', '.dowanloadExcel', function(){
                const schoolId = $('#select_school').val();
                const className = $('#select_class').val();

                let url = '{{ route('admin.student.excel') }}' + '?';
                url += $.param({
                    'filter[school_id]': schoolId,
                    'filter[class]': className
                });
                window.location.href = url; // Triggers download
            });

     
let currentPage = 1;
let loading = false;

function loadStudentCards(page = 1, filters = null) {
    if (loading) return;
    loading = true;

    $.ajax({
        url: '{{ route('admin.student.index') }}',
        data: {
            page: page,
            filter: filters,
            mobile: true
        },
        success: function (res) {
            const container = $('#studentCards');
              // âœ… Clear previous data only when applying a new filter or first page
            if (page === 1) {
                container.html('');
                currentPage = 1; // Reset page
            }

            if (res.data.length === 0) {
                $('#loadMoreBtn').hide();
                return;
            }

            res.data.forEach(student => {
                const profileUrl = student.profile ? `{{ asset('students') }}/${student.profile}` : `{{ asset('storage/red-x-png-4.png') }}`;
                const fatherImageUrl = student.father_image ? `{{ asset('storage/students') }}/${student.father_image}` : `{{ asset('storage/red-x-png-4.png') }}`;
                const motherImageUrl = student.mother_image ? `{{ asset('storage/students') }}/${student.mother_image}` : `{{ asset('storage/red-x-png-4.png') }}`;
                const guardianImageUrl = student.guardian_image ? `{{ asset('storage/students') }}/${student.guardian_image}` : `{{ asset('storage/red-x-png-4.png') }}`;

            console.log(profileUrl)
            let profile = '';
            if (allowedFields.includes('profile') && profileUrl) {
                // const profileUrl = '{{ asset('students') }}' +`/${student.profile}`;
                profile = `
                    <div class="text-center">
                        <img src="${profileUrl}" class="rounded-circle updateImg" data-id="${student.id}" data-type="profile" width="60px" height="60px" alt="Student">
                        <div class="small">Student</div>
                    </div>
                `;
            }
            
            let fatherImage = '';
            if (allowedFields.includes('father_image') && fatherImageUrl) {
                // const fatherImageUrl = '{{ asset('students') }}'+`/${student.father_image}`;
                fatherImage = `
                    <div class="text-center">
                        <img src="${fatherImageUrl}" class="rounded-circle updateImg" data-id="${student.id}" data-type="father_image" width="60px" height="60px" alt="Father">
                        <div class="small">Father</div>
                    </div>
                `;
            }
            
            let motherImage = '';
            if (allowedFields.includes('mother_image') && motherImageUrl) {
                
                motherImage = `
                    <div class="text-center">
                        <img src="${motherImageUrl}" class="rounded-circle updateImg" data-id="${student.id}" data-type="mother_image" width="60px" height="60px" alt="Mother">
                        <div class="small">Mother</div>
                    </div>
                `;
            }
            
            let guardianImage = '';
            if (allowedFields.includes('guardian_image') && guardianImageUrl) {
              
                guardianImage = `
                    <div class="text-center">
                        <img src="${guardianImageUrl}" class="rounded-circle updateImg" data-id="${student.id}" data-type="guardian_image" width="60px" height="60px" alt="Guardian">
                        <div class="small">Guardian</div>
                    </div>
                `;
            }
            
            

                let dynamicFieldsHtml = '';

                allowedFields.forEach(field => {
                    if (['profile', 'father_image', 'mother_image', 'guardian_image'].includes(field)) return;

                    const label = field.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const value = student[field];

                    if ((field === 'studen_signature' || field === 'employe_signature') && value) {
                        dynamicFieldsHtml += `
                            <p class="mb-1"><strong>${label}:</strong><br>
                            <img width="30%" src="{{ asset('students') }}/${value}" height="40" /></p>`;
                    } else if (field === 'created_at' && value) {
                        dynamicFieldsHtml += `<p class="mb-1"><strong>${label}:</strong> ${new Date(value).toLocaleDateString()}</p>`;
                    } else {
                        dynamicFieldsHtml += `<p class="mb-1"><strong>${label}:</strong> ${value || '-'}</p>`;
                    }
                });

                container.append(`
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm rounded border">
                            <div class="card-header bg-danger text-white text-center py-2">
                                <div class="d-flex justify-content-around align-items-center">
                                         ${profile}
                                    ${fatherImage}
                                    ${motherImage}
                                    ${guardianImage}
                                </div>
                            </div>

                            <div class="card-body p-3">
                                ${dynamicFieldsHtml}
                                <div class="mt-2 d-flex justify-content-start gap-2 flex-wrap">
                                    ${student.action || ''}
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            });

            currentPage++;
            loading = false;

            if (res.data.length < 15) {
                $('#loadMoreBtn').hide(); // hide when no more records
            } else {
                $('#loadMoreBtn').show();
            }
        }
    });
}




// Initial load
if (window.innerWidth < 768) {
    loadStudentCards(currentPage, all_filter);
}

$('#loadMoreBtn').on('click', function () {
    loadStudentCards(currentPage,all_filter);
});

// let uploadTarget = {};

// $(document).on('click', '.updateImg', function () {
//     // Save info to global variable
//     uploadTarget = {
//         id: $(this).data('id'),
//         type: $(this).attr('type'),
//         imageElement: this // to update image src later
//     };

//     // Trigger file input
//     $('#imageUploadInput').click();
// });

// $('#imageUploadInput').on('change', function () {
//     const file = this.files[0];
//     if (!file || !uploadTarget.id || !uploadTarget.type) return;

//     const formData = new FormData();
//     formData.append('image', file);
//     formData.append('id', uploadTarget.id);
//     formData.append('type', uploadTarget.type);
//     formData.append('_token', '{{ csrf_token() }}');

//     $.ajax({
//         type: 'POST',
//         url: "{{ route('admin.student.ImgUpdate') }}",
//         data: formData,
//         contentType: false,
//         processData: false,
//         success: function (res) {
//             if (res.success && res.image_path) {
//                 // Update the image src
//                 $(uploadTarget.imageElement).attr('src', res.image_path);
//                 toastr.success('Image updated successfully!');
//             } else {
//                 toastr.error('Image update failed.');
//             }
//         },
//         error: function () {
//             toastr.error('Server error.');
//         }
//     });
// });

    $(document).on('change', '#selectAll', function () {
        $('.student-checkbox').prop('checked', $(this).is(':checked'));
    });
    $(document).on('click', '#deleteSelected', function () {
        const selected = $('.student-checkbox:checked').map(function () {
            return $(this).val();
        }).get();

        if (selected.length === 0) {
            alert('Please select at least one student to delete.');
            return;
        }

        if (!confirm('Are you sure you want to delete selected students?')) {
            return;
        }

        $.ajax({
            url: '{{ route('admin.student.bulkDelete') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                ids: selected
            },
            success: function (res) {
                $('#studenDatatable').DataTable().ajax.reload();
                alert(res.message || 'Deleted successfully');
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });



        function initOrderTable(all_filter = null) {
            if ($.fn.dataTable.isDataTable('#studenDatatable')) {
                $('#studenDatatable').DataTable().clear().destroy();
            }

            const imageFields = ['profile', 'father_image', 'mother_image', 'guardian_image', 'studen_signature', 'employe_signature'];

            let columns = [{
                data: 'id',
                name: 'checkbox',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `<input type="checkbox" class="student-checkbox" value="${row.id}">`;
                }
            }];

            // Add all dynamic fields
            allowedFields.forEach(field => {
                let column = {
                    data: field,
                    name: field,
                    title: field.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())
                };

                if (imageFields.includes(field)) {
                    column.render = function (data, type, row) {
                        if (!data) {
                            return `<img class="updateImg" src="{{ asset('red-x-png-4.png') }}" data-type="${field}" data-id="${row.id}" alt="red-x-png-4.png" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #e0e0e0; cursor: pointer;">`;
                        }
                        return `<img class="updateImg" src="{{ asset('students') }}/${data}" data-type="${field}" data-id="${row.id}" alt="images" style="width: 60px; height: 60px; min-width: 60px; min-height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #e0e0e0; cursor: pointer;">`;
                    };
                }

                columns.push(column);

                if (field === 'profile') {
                    columns.push({
                        data: 'profile',
                        name: 'profile_path',
                        title: 'Profile Path',
                        searchable: false,
                        orderable: false,
                        render: function (data, type, row) {
                            if (!data) return '';
                            return `<span style="font-size: 14px; color: #555;">${data}</span>`;
                        }
                    });
                }
            });

            // Add action column
            columns.push({
                data: 'action',
                name: 'action',
                title: 'Action',
                orderable: false,
                searchable: false
            });

            $('#studenDatatable').DataTable({
                processing: true,
                serverSide: true,
                 pageLength: 50, // ðŸ‘ˆ Default 50 rows per page
                lengthMenu: [[50, 100, 200, 300, 500], [50, 100, 200, 300, 500]], // ðŸ‘ˆ options in dropdown
                ajax: {
                    url: '{{ route('admin.student.index') }}',
                    data: function (d) {
                        if (all_filter) {
                            d.filter = all_filter;
                        }
                    }
                },
                columns: columns
            });
        }


    
    $(document).ready(function () {
        $('#select_school').select2();
        $('#select_class').select2();
        $('#select_status').select2();

        let storedSchool = sessionStorage.getItem('student_filter_school');
        let storedClass = sessionStorage.getItem('student_filter_class');
        let storedStatus = sessionStorage.getItem('student_filter_status');
        
        if (storedSchool) {
            let val = JSON.parse(storedSchool);
            $("[name=select_school]").val(val).trigger('change');
            all_filter['select_school'] = val;
        }
        if (storedClass) {
            let val = JSON.parse(storedClass);
            $("[name=select_class]").val(val).trigger('change');
            all_filter['select_class'] = val;
        }
        if (storedStatus) {
            let val = JSON.parse(storedStatus);
            $("[name=select_status]").val(val).trigger('change');
            all_filter['select_status'] = val;
        }

        initOrderTable(all_filter);
        $(document).on('click', '.show_img', function(){
            var src = $(this).attr('src');

            $('#show_img').html('<img  src="'+src+'" alt="">');
            $('#modelId').modal('show');
        })
    });
    </script>
@endpush
<style>
    .bg-custom{
        background: #c2c0bf;
    }
       .card img.rounded-circle {
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    .card-header.bg-danger {
        background-color: #fd5c63 !important;
    }

    /* Sticky Header CSS */
    #studenDatatable thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #4634ff !important;
        color: #ffffff !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }
    
    /* Alternating Column Colors */
    #studenDatatable tbody td:nth-child(even) {
        background-color: #f8f9fa !important;
    }
    #studenDatatable tbody td:nth-child(odd) {
        background-color: #ffffff !important;
    }
</style>