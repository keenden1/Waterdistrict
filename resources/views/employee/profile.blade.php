@extends('layout.layoutuser')

@section('title', 'PROFILE')
@section('header_title', "PROFILE")
@section('content')

<div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
               <img src="{{ asset($employee->profile_picture ?? 'logo/logo.png') }}" alt="Profile Picture" class="profile-img">
                <h2>Edit Profile</h2>
            </div>
            <div class="profile-body">
                <label>Name</label>

                <input type="text" value="{{ ucfirst(strtolower($employee->fname)) }}" disabled>
                
                <label>Email</label>
                <input type="email" value="{{$employee->email}}" disabled>
                
                <label>Position</label>
                <input type="text" value="{{$employee->position}}" disabled>
                
                <label>Employee ID</label>
                <input type="text" value="{{$employee->employee_id}}" disabled>
                
                <label>Vacation Leave</label>
                <input type="text" value="{{$balance->vl_balance ?? '0'}}" disabled>

                <label>Sick Leave</label>
                <input type="text" value="{{$balance->sl_balance ?? '0'}}" disabled>

                <label>Leave of Credit</label>
                <input type="text" value="{{$balance->total_leave_earned ?? '0'}}" disabled>
                
                <button class="save-btn">Update</button>
            </div>
<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Update Profile Picture</h2>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-top: 15px; display:flex; align-items:center; justify-content:center;">
                <img id="profilePreview" src="#" alt="Preview" style="display:none; width: 320px; height: 320px; border-radius: 50%; object-fit: cover;">
            </div>
            <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)" required>
            <input type="hidden" name="email"  value="{{$employee->email}}">

            <button type="submit" class="save-btn" style="margin-top: 15px;">Upload</button>
        </form>
    </div>
</div>



        </div>
    </div>

<style>
    .nav__list a:nth-child(4) {
  color: #ffffff;
  background-color:rgb(102, 44, 217);
}

.nav__list a:nth-child(4)::before {
  content: "";
  position: absolute;
  left: 0;
  width: 5px;
  height: 42px;
  background-color: #cf222f;
}
    .profile-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
   
   
}
.profile-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 500px;
    width: 100%;
    margin-bottom: 40px;
}
.profile-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
}
.profile-body label {
    display: block;
    text-align: left;
    margin-top: 10px;
    font-weight: bold;
}

.profile-body input {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background: #f0f0f0;
    text-align: center;
}
.save-btn {
    background: #6956D3;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
    font-size: 16px;
}
.save-btn:hover {
    background: #5745c6;
}
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fff;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 500px;
    position: relative;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 20px;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

</style>
<script>
    const modal = document.getElementById('editProfileModal');
    const btn = document.querySelector('.save-btn');
    const span = document.querySelector('.close');

    btn.onclick = function() {
        modal.style.display = 'block';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

function previewImage(event) {
    const fileInput = event.target;
    const output = document.getElementById('profilePreview');

    // If a file is selected
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        reader.onload = function () {
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(fileInput.files[0]);
    } else {
        // No file selected (e.g., user cancels)
        output.src = '#';
        output.style.display = 'none';
    }
}
function clearPreview() {
    const fileInput = document.querySelector('input[name="profile_picture"]');
    const output = document.getElementById('profilePreview');

    fileInput.value = ''; // Clear the file input
    output.src = '#';
    output.style.display = 'none';
}
span.onclick = function() {
    modal.style.display = 'none';
    clearPreview(); // Reset the image
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
        clearPreview(); // Reset the image
    }
}

</script>

@endsection
