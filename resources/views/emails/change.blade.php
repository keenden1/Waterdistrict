<html>

<head>
  <meta charset="utf-8" />
  <title>Forgot your password?</title>
  <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/x-icon">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>

<body>
 
  <div class="card forgot-password">


  <form action="{{ url('/forgotpasswordform') }}" method="POST" class="auth-form forgot-password">
    @csrf
    <div class="logo"> </div>
    <div class="row labels">
        
        <h2>Forgot your password?</h2>
        <h3>Don't worry. Just enter your email address below and we'll send you some instructions.</h3>
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        <span class="icon"><i class="fa fa-check-circle"></i></span>
        <span class="message">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <span class="icon"><i class="fa fa-times-circle"></i></span>
            <span class="message">{{ session('error') }}</span>
        </div>
    @endif

    <div class="row email">
        <span class="icon email">
            <i class="fa fa-envelope-o fa-lg"></i>
        </span>
        <input type="email" name="email" required autofocus autocomplete pattern="^[^\s@＠=]+[@|＠][^\.\s@＠]+(\.[^\.\s@＠]+)+$" title="Please enter a valid email address." placeholder="Email" />
    </div>

    <div class="row submit">
        <input type="submit" class="button big blue" value="Reset Password" />
    </div>
    
    <span class="link login">
    Remembered your password?
    <a href="{{ url('/Login') }}" class="sign">Sign In</a>
  </span>

</form>

  </div>


</body>
<style>
    /* common.css*/
@import url("https://fonts.googleapis.com/css?family=Lato:300,400,700&subset=latin,latin-ext");
@import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=cyrillic,greek");
html,body,div,input {
    padding: 0;
    margin: 0
}

html,body,div,input,textarea,button,select {
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    -moz-box-sizing: border-box
}

body {
    color: #423e3e;
    background-color: #fafafa;
    font-size: 16px;
    font-weight: 400
}

body,input,button {
    font-family: "Lato","Open Sans","Microsoft Yahei","微软雅黑",STXihei,"华文细黑","Hiragino Kaku Gothic Pro",Osaka,'ＭＳ Ｐゴシック','MS PGothic','メイリオ',Meiryo,"Geneva CY","Lucida Grande","Arial Unicode MS","Helvetica Neue","Arial",Sans-Serif
}

input,textarea,button,select {
    outline: none
}

a[target="_blank"],a[target="_blank"]:visited {
    color: #2b88d9;
    text-decoration: none
}

.ellipsis {
    overflow: hidden;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis;
    white-space: nowrap
}

.sign:hover{
    text-decoration: underline !important;
}
.small,.small a {
    font-size: 12px;
    line-height: 15px
}

.center {
    margin-left: auto;
    margin-right: auto;
    text-align: center
}


/* forgot-password.css*/

.card {
    max-width: 420px;
    min-width: 300px;
    margin: 40px auto 20px auto;
    padding: 0 10px
}

.errors {
    background-color: rgba(214,40,34,0.07);
    border: 1px solid rgba(214,40,34,0.36);
    color: #d62822;
    font-size: 14px;
    text-align: left;
    padding: 10px;
    margin-bottom: 20px;
    -webkit-border-radius: 4px;
    border-radius: 4px
}

.auth-form {
    background-color: #fff;
    border: 1px solid #ddd;
    -webkit-box-shadow: 0 1px 3px rgba(50,50,50,0.08);
    box-shadow: 0 1px 3px rgba(50,50,50,0.08);
    -webkit-border-radius: 4px;
    border-radius: 4px;
    font-size: 16px;
    margin-top: 120px;
    padding: 0 10px;
}

.auth-form .row {
    height: 60px;
    margin: 0;
    border-bottom: 1px solid #eee;
}

.auth-form .row:last-child {
    border-bottom: none
}

.auth-form .row.name,.auth-form .row.email,.auth-form .row.password {
    display: -webkit-box;
    display: -moz-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: box;
    display: flex;
}

.auth-form .row.name input,.auth-form .row.email input,.auth-form .row.password input {
    -webkit-box-flex: 1;
    -moz-box-flex: 1;
    -o-box-flex: 1;
    box-flex: 1;
    -webkit-flex: 1;
    -ms-flex: 1;
    flex: 1;
    border: 0 none;
    font-size: 16px;
    line-height: 15px;
    padding: 20px 8px;
    margin-right: 2px;
    color: #666
}

.auth-form .row.submit {
    border-bottom: none;
    padding: 5px 15px;
}

.auth-form .row.submit input.button {
    display: block;
    width: 100%;
    font-size: 16px;
    padding: 11px 10px;
    -webkit-border-radius: 3px;
    border-radius: 3px;
    margin: 18px auto;
    font-weight: bold
}

.auth-form .row .icon {
    display: inline-block;
    margin: 0 11px 0 16px;
}

.auth-form .row .icon.person {
    width: 20px;
    height: 22px;
    margin-top: 19px
}

.auth-form .row .icon.email {
    width: 21px;
    height: 18px;
    margin-top: 20px
}

.auth-form .row .icon.padlock {
    width: 21px;
    height: 25px;
    margin-top: 16px
}

.link.forgot-password,.link.signup,.link.login {
    display: block;
    text-align: center;
}
.link.login {
    margin-bottom: 22px;
}
.link.forgot-password a,.link.signup a,.link.login a {
    color: #1b7edf;
    text-decoration: none
}

.link.forgot-password {
    font-size: 14px
}

.link.signup,.link.login {
    margin-top: 10px;
    padding: 10px;
    font-size: 15px;
    color: #666
}
.alert {
    padding: 15px;
    margin: 10px 0;
    border-radius: 4px;
    font-size: 16px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-success i, .alert-danger i {
    margin-right: 8px;
    font-size: 20px;
}

.alert-success .fa, .alert-danger .fa {
    vertical-align: middle;
}

.alert-success .message, .alert-danger .message {
    display: inline-block;
    vertical-align: middle;
    padding-left: 8px;
}

.alert-success .icon, .alert-danger .icon {
    display: inline-block;
    vertical-align: middle;
}

.alert-success:hover, .alert-danger:hover {
    opacity: 0.8;
}

.alert-danger {
    font-weight: bold;
}
@media screen and (max-height: 480px) {
    .card {
        margin-top:20px
    }

    .auth-form .row {
        height: 50px;
    }

    .auth-form .row.name input,.auth-form .row.email input,.auth-form .row.password input {
        padding: 15px 5px
    }

    .auth-form .row .icon.person {
        margin-top: 14px
    }

    .auth-form .row .icon.email {
        margin-top: 15px
    }

    .auth-form .row .icon.padlock {
        margin-top: 11px
    }
}

html[dir=rtl] .icon {
    -webkit-transform: rotateY(180deg);
    -moz-transform: rotateY(180deg);
    -o-transform: rotateY(180deg);
    -ms-transform: rotateY(180deg);
    transform: rotateY(180deg)
}

html[dir=rtl] .external-auth .icon,html[dir=rtl] .icon.tick {
    -webkit-transform: none;
    -moz-transform: none;
    -o-transform: none;
    -ms-transform: none;
    transform: none
}

.logo {
    margin: 20px auto;
}

.logo:before {
    content: '';
    display: block;
    margin: auto;
    width: 120px;  /* Increase the width */
    height: 120px; /* Increase the height */
    -webkit-background-size: 120px;  /* Adjust background size */
    -moz-background-size: 120px;     /* Adjust background size */
    background-size: 120px;  
    background-image: url("{{ asset('logo/logo.png') }}");
    background-repeat: no-repeat;
    background-position: top right;
}

@media screen and (max-width: 500px) {
    .logo {
        margin-top:20px
    }
}

@media screen and (max-height: 480px) {
    .logo {
        margin-top:10px
    }
}

.button {
    cursor: pointer;
    -webkit-transition: 0.1s -webkit-transform ease-in-out;
    -moz-transition: 0.1s -moz-transform ease-in-out;
    -o-transition: 0.1s -o-transform ease-in-out;
    -ms-transition: 0.1s -ms-transform ease-in-out;
    transition: 0.1s transform ease-in-out;
}

.button:active {
    -webkit-transform: scale(.99);
    -moz-transform: scale(.99);
    -o-transform: scale(.99);
    -ms-transform: scale(.99);
    transform: scale(.99)
}

.button.blue {
  
    border: 0 none;
    background-color: #2b88d9;
    color: #fff;
}

.button.blue:hover {
    background-color: #4094dd
}

.button.gray {
    border: 0 none;
    background-color: #e6e6e6;
    color: #777;
}

.button.gray:hover {
    background-color: #e9e9e9
}

.buttons-external {
    display: -webkit-box;
    display: -moz-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: box;
    display: flex;
    margin-top: 20px
}

.external-auth {
    -webkit-box-flex: 1;
    -moz-box-flex: 1;
    -o-box-flex: 1;
    box-flex: 1;
    -webkit-flex: 1 0 0;
    -ms-flex: 1 0 0;
    flex: 1 0 0;
    margin-right: 10px;
    width: 50%;
}

.external-auth:last-child {
    margin-right: 0
}

.external-auth .button {
    display: block;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    -webkit-box-shadow: 0 1px 2px rgba(120,120,120,0.05);
    box-shadow: 0 1px 2px rgba(120,120,120,0.05);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    text-decoration: none;
    color: #444;
    text-align: center;
    font-weight: bold
}

.external-auth.facebook .button {
    color: #47629c
}

.external-auth.google .button {
    color: #db4c3f
}

.external-auth.microsoft .button {
    color: #0072c6
}

.external-auth.twitter .button {
    color: #2085d2
}

.external-auth.weibo .button {
    color: #e6162d
}

.external-auth.qq .button {
    color: #221f25
}

/* .external-auth .button .icon {
    width: 28px;
    height: 28px;
    display: inline-block;
    float: left;
    margin-top: -6px;
    margin-left: -4px
} */

html[dir="rtl"] .external-auth {
    margin-right: 0;
    margin-left: 10px;
}

html[dir="rtl"] .external-auth:last-child {
    margin-left: 0
}

.auth-form.forgot-password {
    height: initial;
    min-height: 240px
}

.auth-form.forgot-password-success {
    height: initial;
    min-height: 100px
}

.auth-form.forgot-password .row.labels,.auth-form.forgot-password-success .row.labels {
    height: initial;
    min-height: 75px;
    padding: 0 20px;
}

.auth-form.forgot-password .row.labels h2,.auth-form.forgot-password-success .row.labels h2 {
    text-align: center;
    font-size: 18px;
    margin: 20px auto 10px auto;
    color: #666
}

.auth-form.forgot-password .row.labels h3,.auth-form.forgot-password-success .row.labels h3 {
    color: #a3a3a2;
    font-size: 13px;
    text-align: center;
    margin: 0 auto;
    font-weight: normal;
    margin-bottom: 20px
}

@media screen and (max-height: 480px) {
    .auth-form.login {
        height:200px
    }
}


</style>
</html>