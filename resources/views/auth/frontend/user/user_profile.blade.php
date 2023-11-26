{{-- @extends('auth.frontend.user.bestlayout.user_body') --}}
@extends('layouts.app')

@section('main_title', 'Chatify | Profile')

@section('main_content')

    <!-- Container-fluid starts-->

    <div class="edit-profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header pb-0">
                        <h4 class="card-title mb-0"><i class="fa-solid fa-id-badge fa-lg pe-2"></i>My Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="profile-title">
                                <div class="media"> <img class="img-100 rounded-circle" type="button" alt=""
                                        src="/storage/{{ auth()->user()->profile_image_path }}">
                                    <div class="media-body">
                                        <h3 class="mb-1 f-20 txt-info" type="button">
                                            {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }} </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (Session::has('updateSuccess'))
                            <div class="alert alert-success outline-2x alert-dismissible fade show" role="alert">
                                <p class="text-success">{{ Session::get('updateSuccess') }}</p>
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                    data-bs-original-title="" title=""></button>
                            </div>
                        @endif
                        <form action="{{ route('updateProfilePicture') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-5">
                                <div class="form-group">
                                    {{-- <label for="profile_image" class="form-label">Profile Picture</label> --}}
                                    <div class="wrapper">
                                        <label class="custom-file-upload">
                                            <input class="file-input @error('profile_image') is-invalid @enderror"
                                                type="file" name="profile_image">
                                            <i
                                                class="fas fa-cloud-upload-alt
                                                        @error('profile_image')
                                                            text-danger
                                                        @endif
                                                    "></i>
                                                    <p class="browse-text">Upload Profile Picture</p>
                                                    @error('profile_image')
                                                    <span class="invalid-feedback">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                                </label>
                                                <section class="progress-area">
                                                <div class="progress">
                                                    <div class="progress-bar    " role="progressbar"></div>
                                                </div>
                                                </section>
                                                <section class="uploaded-area float-end"></section>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><span class="text-muted f-14 f-w-600"><i
                                            class="fa-regular fa-envelope fa-lg pe-2"></i>Email Address</span></label>
                                <input class="form-control" value="{{ auth()->user()->email }}" disabled
                                    data-container="body" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                    data-bs-original-title="Email update is disabled">
                            </div>

                            <div class="form-footer text-center">
                                <button class="btn btn-dark rounded-pill btn-block mt-3"><span class="text-light f-w-600"><i
                                            class="fa-regular fa-floppy-disk fa-lg pe-2"></i>Save</span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card shadow">
                    <div class="card-header pb-0">
                        <h4 class="card-title mb-0"><i class="fa-regular fa-address-card pe-2 fa-lg"></i>Edit Profile</h4>
                    </div>

                    <form method="post" action="{{ route('updateProfileInfo') }}">
                        @csrf
                        <div class="card-body">
                            @if (Session::has('profileSuccess'))
                                <div class="alert alert-success outline-2x alert-dismissible fade show" role="alert">
                                    <p class="text-danger">{{ Session::get('profileSuccess') }}</p>
                                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                        data-bs-original-title="" title=""></button>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-600"><i class="fa-solid fa-user fa-lg pe-2"></i>First
                                            Name<span class="text-danger">*</span></label>
                                        <input
                                            class="form-control rounded-pill @error('first_name') is-invalid @else border-success @enderror"
                                            type="text" name="first_name" placeholder="eg: Ram"
                                            value="{{ auth()->user()->first_name }}">
                                        @error('first_name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-600"><i class="fa-regular fa-user fa-lg pe-2"></i>Last
                                            Name<span class="text-danger">*</span></label>
                                        <input
                                            class="form-control rounded-pill @error('last_name') is-invalid @else border-success @enderror"
                                            name="last_name" type="text" placeholder="eg: Kumar Thakuri"
                                            value="{{ auth()->user()->last_name }}">
                                        @error('last_name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-600"><i
                                                class="fa-solid fa-house pe-2"></i>Address</label>
                                        <input
                                            class="form-control rounded-pill @error('address') is-invalid @else border-success @enderror"
                                            name="address" type="text" placeholder="eg: Kalanki"
                                            value="{{ auth()->user()->address }}">
                                        @error('address')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><span class="text-muted f-w-600"><i
                                                    class="fa-solid fa-mobile-screen-button fa-lg pe-2"></i>Mobile</span><span
                                                class="text-danger f-w-600"> *</span></label>
                                        <input
                                            class="form-control rounded-pill @error('phone') is-invalid @else border-success @enderror"
                                            name="phone" type="phone" placeholder="eg: +9779812345678"
                                            value="{{ auth()->user()->phone }}">
                                        @error('phone')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label f-w-600"><i
                                                class="fa-solid fa-tree-city fa-lg pe-2"></i>City</label>
                                        <input
                                            class="form-control rounded-pill @error('city') is-invalid @else border-success @enderror"
                                            name="city" type="text" placeholder="eg: Kathmandu"
                                            value="{{ auth()->user()->city }}">
                                        @error('city')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><span class="text-muted f-w-600"><i
                                                    class="fa-solid fa-venus-mars fa-lg pe-2"></i>Gender</span></label>
                                        <select class="form-control btn-square rounded-pill text-center" name="gender">
                                            <option class="bg-info" value="0" disabled>--Select Your Gender--
                                            </option>
                                            <option value="male"
                                                {{ auth()->user()->gender == 'male' ? 'selected' : '' }}>
                                                Male</option>
                                            <option value="female"
                                                {{ auth()->user()->gender == 'female' ? 'selected' : '' }}>
                                                Female</option>
                                            <option value="other"
                                                {{ auth()->user()->gender == 'other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-2 mb-1">
                                        <label class="form-label f-w-600"><i class="fa-solid fa-fire fa-lg pe-2"></i>About
                                            Me</label>
                                        <textarea class="form-control @error('user_bio') is-invalid @else border-success @enderror" name="user_bio"
                                            rows="5" placeholder="eg: I'm a professional software developer">{{ auth()->user()->user_bio }}</textarea>
                                        @error('user_bio')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-dark rounded-pill" type="submit"><span class="text-light f-w-600"><i
                                        class="fa-solid fa-arrows-rotate fa-lg pe-2"></i>Update Profile</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Account Deletion Section --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow">
                <div class="card-header pb-0">
                    <h5 class="text-danger"><i class="fa-solid fa-trash fa-lg pe-2"></i>Account Deletion</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted f-12">If you want to delete your account click on the delete my account button
                        <span class="text-danger"> ( Once your account is deleted, your all the information will be erased
                            from our database. And it cannot be recovered! )</span>
                        <button class="btn-danger float-end " data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop"><span class="text-light"><i
                                    class="fa-solid fa-user-slash pe-2"></i>Delete My Account</span></button>

                        <!-- Vertically centered modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete My Account</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <span class="text-danger fw-600">Are you sure to delete this account?</span>
                                    <p class="text-dark fw-400">Note: If proceed this action cannot be undone!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('deactive_me', ['id'=> auth()->user()->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Yes! Just Do It</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    {{-- <!-- Vertically centered scrollable modal -->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        ...
    </div> --}}
    {{-- Custom File Upload Script section --}}
    <style>
        .file-input {
            display: none;
        }

        .custom-file-upload {
            border: 2px dashed #02420c;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 30px;
        }

        .custom-file-upload i {
            font-size: 50px;
        }

        .custom-file-upload p {
            margin-top: 15px;
            font-size: 16px;
        }

        .progress-bar {
            background-color: #0af645fd;
            border-radius: 5px;
        }

        .remove-btn:hover {
            cursor: pointer;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var fileInput = document.querySelector(".file-input");
            var progressBar = document.querySelector(".progress-bar");
            var uploadedArea = document.querySelector(".uploaded-area");
            var browseText = document.querySelector(".browse-text");

            fileInput.addEventListener("change", function(event) {
                var file = event.target.files[0];
                var fileSize = getFileSize(file.size);

                var row = document.createElement("div");
                row.className = "row";
                var mBtn = '<i class="fas fa-times"></i>';
                row.innerHTML = `
                                    <div class= "row">
                                    <div class="text text-start mx-5 pt-2">${file.name} <span class="remove-btn badge rounded-pill bg-danger">Remove</span></div>
                                    </div>
                                `;

                uploadedArea.appendChild(row);
                browseText.textContent = "File Uploaded Successfully!";

                var formData = new FormData();
                formData.append("file", file);

                var xhr = new XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(event) {
                    var percent = (event.loaded / event.total) * 100;
                    progressBar.style.width = percent + "%";
                });

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            row.innerHTML += '<i class="fas fa-check"></i>';
                        } else {
                            // row.innerHTML += '<i class="fas fa-times"></i>';

                        }
                    }
                };

                xhr.open("POST", "{{ route('add_newadmin') }}");
                xhr.send(formData);
            });

            uploadedArea.addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-btn")) {
                    var row = event.target.parentNode;
                    row.parentNode.removeChild(row);
                    browseText.textContent = "Browse File to Upload";
                    progressBar.style.width = "0%";
                }
            });

            function getFileSize(bytes) {
                var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
                if (bytes === 0) return "0 Byte";
                var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
            }
        });
    </script>

@endsection
