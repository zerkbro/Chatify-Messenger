@extends('auth.admin.design.main')

@section('subtitle', 'User Management Section')
@section('contentsection')
    <div class="d-flex align-items-center justify-content-around">
        <h2 class="mb-0">Add New User
            <i class="fas fa-edit"></i>
        </h2>
    </div>
    <a href="{{ route('show_users') }}" class="btn btn-secondary float-right">View Users</a>
    <hr />
    {{-- add new course body --}}
    <div class="d-flex align-items-center justify-content-around mt-5 mb-5">
        <div class="row col-8 card shadow py-5 px-5">
            {{-- Adding new course form field --}}
            {{-- <form action="{{ route('addnew_admin') }}" method="post" enctype="multipart/form-data"> --}}
            <form action="{{ route('add_newuser') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" placeholder="eg: Mark Angles"
                        value="{{ old('name') }}" aria-describedby="helpId">
                    @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="text" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror" placeholder="eg: youremail@domain.com"
                        value="{{ old('email') }}" aria-describedby="helpId">
                    @error('email')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">password</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        aria-describedby="helpId">
                    @error('password')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_phone" class="form-label">Mobile Number</label>
                    <input type="text" name="phone" id="user_phone"
                        class="form-control @error('phone') is-invalid @enderror" placeholder="eg: +977"
                        aria-describedby="helpId">
                    @error('phone')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="profile_image" class="form-label">Profile Picture</label>
                    <div class="wrapper">
                        <label class="custom-file-upload">
                            <input class="file-input @error('profile_image') is-invalid @enderror" type="file" name="profile_image">
                            <i class="fas fa-cloud-upload-alt
                                @error ('profile_image')
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
                                <div class="progress-bar bg-success" role="progressbar"></div>
                            </div>
                        </section>
                        <section class="uploaded-area float-right"></section>
                    </div>

                </div>


                <div class="form-group mt-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender_type" id="inlineRadio1" value="male" checked>
                        <label class="form-check-label" for="inlineRadio1" >Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="gender_type" id="inlineRadio2"
                            value="hidden" >
                        <label class="form-check-label" for="inlineRadio2">Female</label>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-2">
                    <button class="btn btn-success" type="submit">Save Changes</button>
                </div>
            </form>
        </div>

        {{-- <div class="row col-4">
            <div class="text-center">
                Image Goes here
            </div>
        </div> --}}
    </div>
    <style>
        .file-input {
            display: none;
        }

        .custom-file-upload {
            border: 2px dashed #6990F2;
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
            background-color: #069129fd;
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
                                    <div class="content mx-5 pt-2">${file.name}</div>
                                    <div class="remove-btn text-danger pt-2">Remove</div>
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
