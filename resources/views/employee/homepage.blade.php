<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.6.0/p5.js"></script>
    <title>Villasis Water District</title>
</head>
<body>
    <div class="Main">
        <div class="Main-box">
            <h2>APPLICATION FOR LEAVE</h2>
            <a href="{{ url('/Application-For-Leave') }}" class="right-button">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
        <div class="Main-box">
            <h2>INSTRUCTION AND REQUIREMENTS</h2>
            <a href="{{ url('/Read') }}" class="right-button">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>
@if (session('success'))
    <div id="popup-message" class="popup-message">
        <span class="popup-close" onclick="closePopup()">&times;</span>
        {{ session('success') }}
    </div>
@endif


    <!-- <footer>
        <div class="footer">
            <span class="footer-links">
            <a href="https://www.facebook.com/VillasisWaterDistrict" target="_blank" rel="noopener noreferrer"><img src="{{ asset('logo/facebook.png') }}" alt="Facebook"></a>
            <a href="https://www.facebook.com/VillasisWaterDistrict" target="_blank" rel="noopener noreferrer">Villasis Water District</a>
            </span>
            <span class="footer-links">
                
                <a href="https://www.villasiswaterdistrict.gov.ph" target="_blank" rel="noopener noreferrer"><img src="{{ asset('logo/link.png') }}" alt="Website"></a>
                <a href="https://www.villasiswaterdistrict.gov.ph" target="_blank" rel="noopener noreferrer">villasiswaterdistrict.gov.ph</a>
            </span>
            <span class="footer-links">
                
                <a href="tel:09178492328" target="_blank" rel="noopener noreferrer"><img src="{{ asset('logo/cellphone.png') }}" alt="Phone"></a>
                <a href="tel:09178492328" target="_blank" rel="noopener noreferrer">0917 849 2328</a>
            </span>
            <span class="footer-links">
                
                <a href="mailto:villasis_wd@yahoo.com" target="_blank" rel="noopener noreferrer"><img src="{{ asset('logo/email.png') }}" alt="Email"></a>
                <a href="mailto:villasis_wd@yahoo.com" target="_blank" rel="noopener noreferrer">villasis_wd@yahoo.com</a>
            </span>
            <span class="footer-links">
                
                <a href="tel:0756321093" target="_blank" rel="noopener noreferrer"><img src="{{ asset('logo/phone.png') }}" alt="Landline"></a>
                <a href="tel:0756321093" target="_blank" rel="noopener noreferrer">(075) 632-1093</a>
            </span>
        </div>
    </footer> -->
</body>
<style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            position: relative;
            min-height: 100vh;
            padding: 2rem;
            background: linear-gradient(5deg, #0000FF, #1E3A8A, #E6E6FA);
            /* background-color: #f0f2f5; */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 90vw;
            max-height: 90vh;
            /* border-top: 20px solid #6956D3; */
        }
    
        .Main{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.8);
           
            padding: 7rem 2rem;
            border-radius: 10px;
            max-width: 90vw;
            max-height: 90vh;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 1);
            
            text-align: center;
        }
      
        .Main-box{
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* background-color: #D9D9D9; */
            background-color: rgba(255, 255, 255, 1);
            width: 350px;
            height: 70px;
            margin: 10px auto;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            
        }
        .Main-box a{
            text-decoration: none;
        }
        .right-button{
            background-color: #394384;
            height: 50px;
            min-width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            
        }
        .right-button a {
            text-decoration: none;
        }
        .right-button i {
            font-size: 30px;
            color: white;
            text-decoration: none;
        }

        .footer{
            position: absolute;
            bottom: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: space-around;
            width: 100%;
            background-color: #E26C6C;
            height: 50px;
        }
        .footer a{
            text-decoration: none;
            color: #fff;
        }
        .footer-links{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-links img{
            height: 30px;
            width: auto;
            margin: 0 5px;
        }
        @media (max-width: 780px) {
            .footer a{
                display: none;
            }
            .Main-box{
              width: 250px;
            }
            .Main-box h2{
              font-size: small;
            }
        }
       .popup-message {
    position: fixed;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #4CAF50;
    color: white;
    padding: 20px 40px;
    border-radius: 12px;
    font-weight: bold;
    font-size: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
    z-index: 9999;
    text-align: center;
    position: fixed;
}

.popup-close {
    position: absolute;
    top: 8px;
    right: 12px;
    font-size: 24px;
    cursor: pointer;
}
.popup-message.hide {
    opacity: 0;
    pointer-events: none;
}

    </style>
    <script>
    function closePopup() {
        const popup = document.getElementById('popup-message');
        if (popup) {
            popup.classList.add('hide');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(() => {
            closePopup();
        }, 4000);
    });
</script>


    <!-- <script>
                /*
TO-DOs
[  ] Melhorar posicionamento
[  ] Melhorar espaçamento
[ok] Variar angulação
[  ] Variar compimento da gota (timeline?)
[  ] fator z (opacidade e tamanho vertical)
[  ] ease in nas ellipses, ease out nas gotas
*/

var pingos = [];

class Pingo {
  constructor(tempX,tempY,tempStart,tempDuration){
    this.x = tempX;
    this.y = tempY;
    this.z = map(this.y,height/2,height,0.0,1.0);
    this.start = tempStart;
    this.duration = tempDuration;
    
    this.isActive = true;
    this.initSize = 0.0;
    this.endSize = 100.0;
    
    this.ang = random(150,300);
    
    //tl -> timeline
    //onde em 'progress' (0.0~1.0) acontecem? 
    //[(pingo nasce),(pingo hit/ellipse),(pingo some),(ellipse some))]
    this.tl = [];
  }
  
  update(){
    if(this.isActive){
      this.draw();
      if(millis()>this.start+(this.duration*1000)){
        this.isActive = false;
      }
    }
  }
  
  draw(){
    //eliminar os 'ifs' com min() e max() no stroke!
  
    var progress =  map(millis(),this.start,this.start+(this.duration*1000),0.0,1.0);
    //desenha pingo
    if(progress < 0.4){
      var p1 = p5.Vector.lerp(createVector(this.x+this.ang,this.y-height),
                              createVector(this.x,this.y),
                              map(progress,0.0,0.4,0.0,1.0,true));
      var p2 = p5.Vector.lerp(createVector(this.x+this.ang,this.y-height),
                              createVector(this.x,this.y),
                              map(progress+0.03,0.0,0.4,0.0,1.0,true));
      stroke(168,192,255);
      line(p1.x,p1.y,p2.x,p2.y);
    }

    //desenha respingos
    if(progress > 0.325 && progress < 0.6){
      var q1 = p5.Vector.lerp(createVector(this.x,this.y),
                              createVector(this.x-15,this.y-10),
                              map(progress,0.325,0.6,0.0,1.0,true));
      var q2 = p5.Vector.lerp(createVector(this.x,this.y),
                              createVector(this.x+15,this.y-10),
                              map(progress,0.325,0.6,0.0,1.0,true));

      stroke(168,192,255,map(progress,0.325,0.6,255,0,true));
      point(q1.x,q1.y);
      point(q2.x,q2.y);
    }

    //desenha ellipse
    if(progress > 0.325){
      var actualSize = this.initSize + (this.endSize-this.initSize)*map(progress,0.325,1.0,0.0,1.0,true);
      stroke(168,192,255,map(progress,0.0,1.0,255,0));
      ellipse(this.x,this.y,actualSize*3,actualSize);
    }
  }
}

function setup(){
  createCanvas(windowWidth,windowHeight);
  stroke(168,192,255);
  noFill();
  strokeWeight(2);
}

function draw(){
  background(63,43,150);
  for(var i=0;i<pingos.length;i=i+1){
    pingos[i].update();
    if(!pingos[i].isActive){
      pingos.splice(i,1);
    }
  }
  
  if(frameCount % 3 == 0){
    pingos.push(new Pingo((noise(frameCount)*(width+400))-200,
                          random(height/2,height),
                          millis(),random(2.0,3.0)));
  }
  
  if(frameCount % 4 == 0){
    pingos.push(new Pingo((noise(frameCount)*(width+400))-200,
                          random(height/2,height),
                          millis(),random(1.0,2.0)));
  }
  
  if(frameCount % 5 == 0){
    pingos.push(new Pingo((noise(frameCount)*(width+400))-200,
                          random(height/2,height),
                          millis(),random(0.5,3.0)));
  }
}
    </script> -->
</html>
