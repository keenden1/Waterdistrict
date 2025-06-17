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
                <input type="text" value="{{$employee->emp_id}}" disabled>

                     <h2 style="margin-top: 20px;">Available Leave {{ date('Y') }}</h2>

            <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; margin-top: 10px; ">

                <div style="flex: 1; min-width: 240px;">
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <div style="flex: 1;">
                            <label style="display: block; text-align: center;">Special Leave</label>
                            <input type="text" value="{{ $SPL ?? '' }}" disabled>
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; text-align: center;">Forced Leave</label>
                            <input type="text" value="{{ $FL ?? '' }}" disabled>
                        </div>
                         <div style="flex: 1;">
                            <label style="display: block; text-align: center;">Total</label>
                            <input type="text" value="{{ ($FL ?? 0) + ($SPL ?? 0) }}" disabled>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label style="display: block; text-align: center;">VL</label>
                            <input type="text" value="{{ $balance->sl_balance ?? '0' }}" disabled>
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; text-align: center;">SL</label>
                            <input type="text" value="{{ $balance->vl_balance ?? '0' }}" disabled>
                        </div>
                          <div style="flex: 1;">
                            <label style="display: block; text-align: center;">&nbsp</label>
                            <input type="text" value="{{ $balance->total_leave_earned ?? '0' }}" disabled>
                        </div>
                    </div>
                </div>

              
            </div>

                 <label>E-Signature</label>
                @if ($employee->e_signature)
                    <div style="text-align: center; margin-top: 10px;">
                        <img src="{{ asset($employee->e_signature) }}" alt="E-Signature" style="width: 250px; height: 100px; object-fit: contain; border: 1px solid #ccc;">
                    </div>
                @else
                    <p style="text-align: center; color: gray;">No e-signature uploaded</p>
                @endif
                
                <div style="display: flex; justify-content:space-evenly;">
                       <button class="save-btn" id="editProfileBtn">Update</button>
                       <button class="save-btn" id="eSignBtn">E-Signature</button>
                </div>
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
<!-- Edit Profile Modal -->
<div id="eSignModal" class="modal">
    <div class="modal-content">
        <span class="close-esign">&times;</span>
        <h2>Upload E-Signature</h2>
       <div style="margin-left:20px; text-align:left;">
    <p>We recommend using the following tools to create or clean up your signature:</p>
        <ul style="font-size: 14px; padding-left: 20px;">
            <li>
                <a href="https://www.signwell.com/online-signature/" target="_blank" style="color: #007BFF;">
                    SignWell Online Signature Tool
                </a> - to draw your signature.
            </li>
            <li>
                <a href="https://www.remove.bg/" target="_blank" style="color: #007BFF;">
                    Remove.bg
                </a> - to remove background from your image.
            </li>
        </ul>
        <p style="font-size: 14px; margin-bottom: 10px;">
            Make sure to download it with a <strong>transparent background</strong> (usually PNG format).
        </p>
    </div>

      
        <form action="{{ route('profile.e_signature') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateTransparentCheckbox()">
            @csrf
            @method('PUT')

            <div style="margin-top: 15px; display:flex; align-items:center; justify-content:center;">
                <img id="esignPreview" src="#" alt="E-Sign Preview" style="display:none; width: 320px; height: 120px; object-fit: contain; border: 1px solid #ccc;">
            </div>

            <div style="text-align: left; margin-left:20px;margin-bottom:20px;">
                 <input type="file" name="e_signature" accept="image/*" onchange="previewEsign(event)" required>
            </div>
           
            <input type="hidden" name="email" value="{{ $employee->email }}">

            <div style="margin-top: 10px;">
                <input type="checkbox" id="transparentCheck" required>
                <label for="transparentCheck">I confirm this signature has a transparent background.</label>
            </div>
            <div style="margin: 0 20px 0 20px;">
                <button type="submit" id="esignUploadBtn" class="save-btn" style="margin-top: 15px; display: none; width:100%;">Upload</button>
            </div>
            
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

.close,.close-esign {
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
    const profileModal = document.getElementById('editProfileModal');
    const profileBtn = document.getElementById('editProfileBtn');
    const profileClose = document.querySelector('.close');

    const eSignModal = document.getElementById('eSignModal');
    const eSignBtn = document.getElementById('eSignBtn');
    const eSignClose = document.querySelector('.close-esign');

    // Profile modal logic
    profileBtn.onclick = () => profileModal.style.display = 'block';
    profileClose.onclick = () => {
        profileModal.style.display = 'none';
        clearPreview();
    };

    // E-sign modal logic
    eSignBtn.onclick = () => eSignModal.style.display = 'block';
    eSignClose.onclick = () => {
        eSignModal.style.display = 'none';
        clearEsignPreview();
    };

    // Click outside to close
    window.onclick = function(event) {
        if (event.target == profileModal) {
            profileModal.style.display = 'none';
            clearPreview();
        }
        if (event.target == eSignModal) {
            eSignModal.style.display = 'none';
            clearEsignPreview();
        }
    }

    function previewImage(event) {
        const fileInput = event.target;
        const output = document.getElementById('profilePreview');
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = () => {
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            output.src = '#';
            output.style.display = 'none';
        }
    }

    function clearPreview() {
        const fileInput = document.querySelector('input[name="profile_picture"]');
        const output = document.getElementById('profilePreview');
        fileInput.value = '';
        output.src = '#';
        output.style.display = 'none';
    }

    function previewEsign(event) {
        const fileInput = event.target;
        const output = document.getElementById('esignPreview');
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = () => {
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            output.src = '#';
            output.style.display = 'none';
        }
    }

    function clearEsignPreview() {
        const fileInput = document.querySelector('input[name="e_signature"]');
        const output = document.getElementById('esignPreview');
        fileInput.value = '';
        output.src = '#';
        output.style.display = 'none';
    }

      const transparentCheck = document.getElementById('transparentCheck');
    const uploadBtn = document.getElementById('esignUploadBtn');

    transparentCheck.addEventListener('change', () => {
        uploadBtn.style.display = transparentCheck.checked ? 'inline-block' : 'none';
    });

    function validateTransparentCheckbox() {
        if (!transparentCheck.checked) {
            alert("Please confirm the signature has a transparent background.");
            return false;
        }
        return true;
    }
</script>

@endsection
