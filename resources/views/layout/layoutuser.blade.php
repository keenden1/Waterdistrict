<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','layout')</title>
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body id="bodyPadding">
  <!--Header-->
  <header class="header" id="header">
    <div class="header__toggle">
      <i class='bx bx-menu-alt-left' id="header-toggle"></i>
      <h2 id="header">@yield('header_title', 'header')</h2>
    </div>
    <div class="header__image">
    <i class='bx bxs-bell nav__icon' id="notification-bell" style="font-size: 2.1rem; margin-right: 20px; position: relative; cursor: pointer;">
    <span id="notification-count" style="position: absolute; top: 0; right: -5px; background: red; color: white; font-size: 12px; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">3</span>
    </i>

    <div id="notification-dropdown" style="display: none; position: absolute; top:65px; right:0; min-width: 250px; background: white; box-shadow: 0 4px 8px rgba(0,0,0,0.2); border-radius: 5px; padding: 10px;">
    <h4 style="margin: 0; padding: 10px; border-bottom: 1px solid #ddd;">Notifications</h4>
    <ul style="list-style: none; padding: 0; margin: 0;">
        <li class="notification_style" style="padding: 10px; border-bottom: 1px solid #ddd; cursor: pointer;">New leave request submitted</li>
        <li class="notification_style"  style="padding: 10px; border-bottom: 1px solid #ddd; cursor: pointer;">Employee account updated</li>
        <li class="notification_style"  style="padding: 10px; cursor: pointer;">System maintenance scheduled</li>
    </ul>
  </div>

      <img src="{{ asset($employee->profile_picture ?? 'logo/logo.png') }}" alt="prof_image">
        <p>
        @if(Session::has('fullname'))
        {{ Session::get('fullname') }}
        @endif
          
        
        
        <br> <span id="email">
        @if(Session::has('user_email'))
        {{ Session::get('user_email') }}
        @endif
        </span></p>
    </div>
  </header>
  <!--Header-->
  <!--left anvBar-->
  <div class="l-navbar" id="nav-bar">
    <nav class="nav">

      <div class="nav__list"> 
        <a href="#" class="nav__logo">
          <img src="{{ asset('logo/logo.png') }}" style="width: 22px; height:auto;" alt="">
          <span class="nav__logo-name" style="color:black;">Water District</span>
        </a>
        <a href="{{ url('/Application-For-Leave') }}" class="nav__link active" id="active">
          <i class='bx bxs-home nav__icon'></i>
          <span class="nav__name">Application for Leave</span>
        </a>
        <!-- {{ url('/Admin-Application-Leave') }} -->
        <a href="{{ url('/Application-History') }}" class="nav__link " id="active">
          <i class='bx bx-grid-alt nav__icon'></i>
          <span class="nav__name">Application History</span>
        </a>
        <a href="{{ url('/Profile') }}" class="nav__link" id="active">
          <i class='bx bx-terminal nav__icon'></i>
          <span class="nav__name">Edit Profile</span>
        </a>
       

        <div class="nav__bottom">
       
        <a href="{{ route('logout') }}" 
            onclick="event.preventDefault(); confirmLogout();" 
            class="nav__link" id="active">
              <i class='bx bx-log-out nav__icon'></i>
              <span class="nav__name">Log Out</span>
          </a>
        </div>
       
      </div>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    </nav>
  </div>
  <!--left anvBar-->
  <!--content section-->
  <section>
  @yield('content')
  </section>
  <!--content section-->
</body>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600;700&display=swap");
    
::selection {
  color: white;
  background: SlateBlue;
}

/* /BASE/ */
*,
::after,
::before {
  box-sizing: border-box;
}

body {
  position: relative;
  margin: 3rem 0 0 0;
  font-family: "Poppins", sans-serif;
  background-color: #ffffff;
  font-size: 1.2rem;
  transition: 0.5s;
  padding: 0 1rem;
}

a {
  text-decoration: none;
}

/* /HEADER/ */
.header {
  width: 100%;
  height: 3rem;
  position: fixed;
  top: 0;
  left: 0;
  background-color: #ffffff;
  box-shadow: 1px 0 10px 0px rgba(0, 0, 0, 0.2);
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 1rem;
  z-index: 100;
  transition: 0.5s;
}
/* toogle hamburger */
#header-toggle {
  color: #101010;
  font-size: 1.75rem;
  cursor: pointer;
}
.header__toggle,.header__image {
    display: flex;
    align-items: center;
    justify-content: center;
}
.header__image p{
    text-align: center;
    margin-left: 10px;
}
.header__image p span{
    color: #999;
}
.header__image i, .header__image img{
    margin-bottom: -10px;
}
.header__toggle h2{
    margin-left: 25px;
}

.header img {
  width: 35px;
  height: 35px;
  display: flex;
  justify-content: center;
  border-radius: 50%;
  overflow: hidden;
}

.l-navbar {
  position: fixed;
  left: -30%;
  top: 0;
  width: 68px;
  background: linear-gradient(5deg, #0000FF, #1E3A8A, #E6E6FA);
  height: 100vh;
  padding: 0.5rem 1rem 0 0;
  z-index: 100;
  transition: 0.5s;
  display: flex;
  flex-direction: column;
}

.nav {
  height: 100%;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.nav__list {
  position: relative;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.nav__bottom {
    position: absolute;
    bottom: 10px; /* Adjust as needed */
    left: 0;
    width: 100%;
    display: flex;
    flex-direction: column;
}


.nav__logo,
.nav__link {
  display: grid;
  grid-template-columns: max-content max-content;
  align-items: center;
  column-gap: 1rem;
  padding: 0.5rem 0 0.5rem 1.5rem;
}

.nav__logo {
  margin-bottom: 2rem;
}

.nav__logo-icon {
  font-size: 1.25rem;
  color: #cf222f;
}

.nav__logo-name {
  
  color: #ffffff;
  font-weight: 700;
}
span.nav__name{
    font-size: .825rem;
}

.nav__link {
  position: relative;
  color:rgb(255, 255, 255);
  margin-bottom: 1.5rem;
  transition: 0.5s;
}

.nav__link:is(:hover, :focus) {
  color: rgb(0, 0, 0);
}
.notification_style:hover {
    background-color: #f0f0f0; /* Light gray background */
    color: #333; /* Darker text color */
    cursor: pointer; /* Change cursor to pointer */
    transition: background-color 0.3s ease-in-out, color 0.3s ease-in-out; /* Smooth transition */
    padding: 10px; /* Add some padding */
    border-radius: 5px; /* Rounded corners */
}

.nav__icon {
  font-size: 1.25rem;
}

/* /SHOW NAV BAR/ */
.show {
  left: 0;
}

/*Add padding body movil*/
.body-pd {
  padding-left: calc(68px + 1rem);
}

section {
  position: relative;
  top: 25px;
}

section h1 {
  margin-bottom: 5px;
  font-size: 1.3rem;
  line-height: 1.1;
}

  @media screen and (max-width: 768px) {
    .header__image p{
    display: none;
  }
  #notification-dropdown{
    top: 50px !important;
    right: 0 !important;
    width: 250px;
  }
  .header__image i, .header__image img{
    margin-bottom: 0;
    
}.nav__bottom {
  bottom: 50px;
}

  }
/* ===== MEDIA QUERIES===== */
@media screen and (min-width: 768px) {
  
  body {
    margin: calc(3rem + 1rem) 0 0 0;
    padding-left: calc(68px + 2rem);
  }

  .header {
    height: calc(3rem + 1rem);
    padding: 0 2rem 0 calc(68px + 2rem);
  }

  .header__img {
    width: 40px;
    height: 40px;
  }

  .header__img img {
    width: 45px;
  }

  .l-navbar {
    left: 0;
    padding: 1rem 1rem 0 0;
  }

  /*Show navbar desktop*/
  .show {
    width: calc(68px + 156px);
  }

  /*Add padding body desktop*/
  .body-pd {
    padding-left: calc(68px + 188px);
  }

  section {
    position: relative;
    top: 25px;
  }

  section h1 {
    margin-bottom: 5px;
    font-size: 2rem;
    line-height: 1.2;
  }

  section p {
    font-size: 0.89rem;
    line-height: 1.8;
  }
 
}


</style>
<script>
    //nav bar toggle
const showNavbar = (toggleId, navId, bodyId, headerId) => {
  const toggle = document.getElementById(toggleId),
    nav = document.getElementById(navId),
    bodyPadding = document.getElementById(bodyId),
    headerPadding = document.getElementById(headerId);

  if (toggle && nav && bodyPadding && headerPadding) {
    toggle.addEventListener("click", () => {
      //show nav bar
      nav.classList.toggle("show");
      //change icon
      toggle.classList.toggle("bx-x");
      //add padding
      bodyPadding.classList.toggle("body-pd");
      //add padding to header
      headerPadding.classList.toggle("body-pd");
    });
  }
};
showNavbar("header-toggle", "nav-bar", "bodyPadding", "header");

document.getElementById("notification-bell").addEventListener("click", function() {
        let dropdown = document.getElementById("notification-dropdown");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    });

    // Close the dropdown when clicking outside of it
    document.addEventListener("click", function(event) {
        let dropdown = document.getElementById("notification-dropdown");
        let bell = document.getElementById("notification-bell");
        if (!bell.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = "none";
        }
    });
    function confirmLogout() {
        if (confirm('Are you sure you want to log out?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
</html>