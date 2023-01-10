<?php error_reporting(0);  session_start();  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DAMP - Image classification</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
    <link href="lib/twentytwenty/twentytwenty.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
    .img-zoom-container {
      position: relative;
    }

    .img-zoom-lens {
      border: 0px solid #d4d4d4;
      /*set the size of the lens:*/
      width: 120px;
      height: 120px;
    }

    .img-zoom-result {
      border: 1px solid #d4d4d4;
      /*set the size of the result div:*/
      width: 480px;
      height: 360px;
    }
    
    .custom-toggler .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255,255,255, 1)' stroke-width='3' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E");
    }

    .custom-toggler.navbar-toggler {
    border-color: rgb(255,255,255);
    } 
    
    .context-menu {
        position: absolute;
        text-align: center;
        background: white;
        border: 1px solid black;
    }
  
    .context-menu ul {
        padding: 0px;
        margin: 0px;
        min-width: 150px;
        list-style: none;
    }
  
    .context-menu ul li {
        padding-bottom: 7px;
        padding-top: 7px;
        border: 0px solid black;
    }
  
    .context-menu ul li a {
        text-decoration: none;
        color: black;
    }
  
    .context-menu ul li:hover {
        background: darkgray;
    }
    </style>
    <script>
        
    function imageZoom(imgID, resultID) {
      var img, lens, result, cx, cy;
      img = document.getElementById(imgID);
      result = document.getElementById(resultID);
      /*create lens:*/
      lens = document.createElement("DIV");
      lens.setAttribute("class", "img-zoom-lens");
      /*insert lens:*/
      img.parentElement.insertBefore(lens, img);
      /*calculate the ratio between result DIV and lens:*/
      cx = result.offsetWidth / lens.offsetWidth;
      cy = result.offsetHeight / lens.offsetHeight;
      /*set background properties for the result DIV:*/
      result.style.backgroundImage = "url('" + img.src + "')";
      result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
      /*execute a function when someone moves the cursor over the image, or the lens:*/
      lens.addEventListener("mousemove", moveLens);
      img.addEventListener("mousemove", moveLens);
      /*and also for touch screens:*/
      lens.addEventListener("touchmove", moveLens);
      img.addEventListener("touchmove", moveLens);
      function moveLens(e) {
        var pos, x, y;
        /*prevent any other actions that may occur when moving over the image:*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        /*calculate the position of the lens:*/
        x = pos.x - (lens.offsetWidth / 2);
        y = pos.y - (lens.offsetHeight / 2);
        /*prevent the lens from being positioned outside the image:*/
        if (x >= img.width - lens.offsetWidth) {
            result.style.display="none"; 
        }
	else if (x < 0 ) {
	    result.style.display="none"; 
	} 
	else if (y >= img.height - lens.offsetHeight) {
	    result.style.display="none"; 
	}
	else if (y < 0 ) {
	    result.style.display="none"; 
	}
	else {
	    result.style.display="block"; 
	}
        /*set the position of the lens:*/
        /*lens.style.left = (x) + "px";
        lens.style.top = (y) + "px";
        /*display what the lens "sees":*/
        result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
      }
      function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img.getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return {x : x, y : y};
      }
    }
    </script>
</head>

<body>

    <?php
        //session_start();
        include 'support.php';
        if (!isset($_SESSION['user'])) {
          echo "<script>location.href='login.php';</script>";
        }
        else {
          $next_sno=0;
          $nxt=GetFileName($next_sno);
          $sres=RetrieveData($next_sno,$_SESSION['user']);
          $nxt=explode(" ",$nxt);
          echo "<script> window.onload = function() {
          getNext(".$next_sno.",".$nxt[1].",'".$nxt[0]."','".$sres."');
          }; </script>";
         }
    ?>
    
    <?php
        if ($_POST['Task']=='UpDate')
        {
        	 //'UpDate'= $_POST['Task']
            $sno=explode(" ",$_POST['AnnVal']);
            $next_sno=($sno[0]+1)%10;
            $nxt=GetFileName($next_sno);
            $sres=RetrieveData($next_sno,$_SESSION['user']);
            $nxt=explode(" ",$nxt);
            SaveData($sno[0],$_POST['AnnVal'],$_SESSION['user']);
            echo "<script> window.onload = function() {
            getNext(".$next_sno.",".$nxt[1].",'".$nxt[0]."','".$sres."');
      }; </script>";
        }
        if ($_POST['Task']=='GetImg')
        {
            $sno=explode(" ",$_POST['AnnVal']);
            $next_sno=$sno[0];
            $nxt=GetFileName($next_sno);
            $sres=RetrieveData($next_sno,$_SESSION['user']);
            $nxt=explode(" ",$nxt);
            echo "<script> window.onload = function() {
            getNext(".$next_sno.",".$nxt[1].",'".$nxt[0]."','".$sres."');
      }; </script>";
        }
        if ($_POST['Task']=='UpDateNext')
        {
            $sno=explode(" ",$_POST['AnnVal']);
            $next_sno=($sno[0]+1)%10;
            $nxt=GetFileName($next_sno);
            $sres=RetrieveData($next_sno,$_SESSION['user']);
            $nxt=explode(" ",$nxt);
            echo "<script> window.onload = function() {
            getNext(".$next_sno.",".$nxt[1].",'".$nxt[0]."','".$sres."');
      }; </script>";
        }
        if ($_POST['Task']=='UpDateBack')
        {
            $sno=explode(" ",$_POST['AnnVal']);
            $next_sno=($sno[0]-1)%10;
            $nxt=GetFileName($next_sno);
            $sres=RetrieveData($next_sno,$_SESSION['user']);
            $nxt=explode(" ",$nxt);
            echo "<script> window.onload = function() {
            getNext(".$next_sno.",".$nxt[1].",'".$nxt[0]."','".$sres."');
      }; </script>";
        }
        if ($_POST['Task']=='UpdateLogOut')
        {
            $status = $_SESSION['user'];
            echo $status;
            if (isset($_SESSION['user'])) {
              session_destroy();
              echo "<script>location.href='login.php';</script>";
              echo "Logged Out!!";
            }
        }
        if ($_POST['Task']=='UpdateValue')        {
            $xpos=$_POST['Xval'];
            $ypos=$_POST['Yval'];
            $sno=explode(" ",$_POST['AnnVal']);
            $bbox_info=ReadBBox($sno[0]);
            $bbox_info=explode(";",$bbox_info);
            $nxt=GetFileName($sno[0]);
            $nxt=explode(" ",$nxt);
            for ($i = 1; $i <= $nxt[1]; $i++)
            {
                $bbox=explode(" ",$bbox_info[$i]);
                $xtl=$bbox[1]*480;
                $ytl=$bbox[0]*360;
                $xbr=$bbox[3]*480;
                $ybr=$bbox[2]*360;
                if (($xtl<=$xpos) && ($ytl<=$ypos) && ($xbr>=$xpos) && ($ybr>=$ypos))
                {
                    echo "<script> window.onload = function() {
                          updateInfo(".$sno[0].",".$nxt[1].",".$i.",'".$_POST['AnnVal']."','".$nxt[0]."',".$_POST['Ann'].");
                          }; </script>";
                }
   	    }
            
        }
        if (!isset($_POST['Task']))
        {
           // echo '<script>alert("Welcome to Geeks for Geeks_aaa")</script>';
            //return $_POST['Task'] ?? null;

        }
    ?>





    
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-dark m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary m-1" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    
    <form id="formcell" name=frmCell action="" method=POST>
    <input type=hidden name=Task value='hi'> 
    <input type=hidden name=AnnVal value='hi'>   
    <input type=hidden name=Sno value=''>
    
    <input type=hidden name=Xval value='hi'> 
    <input type=hidden name=Yval value='hi'>   
    <input type=hidden name=Ann value=''>


    <!-- Navbar Start -->
    <nav style="background-color:#1a2024;" class="navbar navbar-expand-lg navbar-light shadow-sm px-5 py-3 py-lg-0">
        <a href="index1_Edited.php" class="navbar-brand p-0">
            <h1 class="m-0" style="color: white;"><i style="color: white;" class="fa fa-microscope me-2"></i>DAMP</h1>
        </a>
        <button class="navbar-toggler ml-auto custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <button type="button" class="btn text-white" style="background-color: #1a2024; text-align: left; width:150px;" onClick="SaveAndNext();document.frmCell.Task.value='UpdateLogOut';document.frmCell.submit();">Logout</button>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
    
    <!-- Menu start -->
    <div id="contextMenu" class="context-menu" 
        style="display:none">
        <ul>
            <li><button type="button" class="btn" style="color:black" onClick="SaveAndNext();document.frmCell.Ann.value='0';document.frmCell.Task.value='UpdateValue';document.frmCell.submit();">Graminicola</button></li>
            <li><button type="button" class="btn" style="color:black" onClick="SaveAndNext();document.frmCell.Ann.value='1';document.frmCell.Task.value='UpdateValue';document.frmCell.submit();">Incognita</button></li>
            <li><button type="button" class="btn" style="color:black" onClick="SaveAndNext();document.frmCell.Ann.value='2';document.frmCell.Task.value='UpdateValue';document.frmCell.submit();">Javanica</button></li>
            
        </ul>
    </div>
    <!-- Menu end -->
    
    
    <!-- About Start -->
    <table class="mx-auto" style="position:relative; margin-top=10%;">
        <tr>
                <td colspan=2>
                                        <button type="submit" class="btn text-white" style="background-color: #00a78e; width:150px;" onClick="SaveAndNext();document.frmCell.Task.value='UpDateBack';document.frmCell.submit();"><< Previous</button>
                                        &nbsp &nbsp &nbsp &nbsp<select id="indadi" class="bg-light border-0 " style="border-radius: 0px;" onchange="SaveAndNext();document.frmCell.Task.value='GetImg';document.frmCell.submit();">
<option value='0'>1</option>
<option value='1'>2</option>
<option value='2'>3</option>
<option value='3'>4</option>
<option value='4'>5</option>
<option value='5'>6</option>
<option value='6'>7</option>
<option value='7'>8</option>
<option value='8'>9</option>
<option value='9'>10</option>
<option value='10'>11</option>
</select>&nbsp &nbsp &nbsp &nbsp                                        <!-- <button type="submit" class="btn text-white" style="background-color: #00a78e; width:150px;" onClick=CheckAndSubmit()>GoTo</button> -->
                                        <button type="button" class="btn text-white" style="background-color: #00a78e; width:150px;" onClick="SaveAndNext();document.frmCell.Task.value='UpDateNext';document.frmCell.submit();">Next >></button>
                                    
                </td>
            </tr>
    </table>
    
    <div class="img-zoom-container">
          <table class="mx-auto" style="margin-top=2%;">
            <tr>
                <td><img id="myimage" src="test/IMG_3915.jpg" width="480" height="360"></td>
	        <th>
	            <div class="container-fluid banner mb-5 ">
                        <div class="container">
                            <div class="row gx-5" style="margin-top: 35%; margin-bottom: 25%;">
                                <div class="col float-right wow zoomIn" data-wow-delay="0.3s">
                                    <div id="selectadi" class="d-flex flex-column p-5" style="height: 350px; border-radius: 25px;">
                                        <h3 style="text-align: center; color: #00a78e;"><b> Identify Class </b></h3>
                                        <!-- Select 1 -->
                                        <select id="memadi1" class="form-select text-dark border-0 mb-3" style="background-color: rgba(0, 0, 229, 0.3); height: 40px;">
                                        <option value='0' >N/A</option><option value='1'>Graminicola</option>
<option value='2'>Incognita</option>
<option value='3'>Javanica</option>
                                        </select>
                                        <!-- Select 2 -->
                                        <select id="memadi2" class="form-select text-dark border-0 mb-3" style="background-color: rgba(0, 229, 0, 0.3); height: 40px;">
                                        <option value='0' >N/A</option><option value='1'>Graminicola</option>
<option value='2'>Incognita</option>
<option value='3'>Javanica</option>
                                        </select>
                                                                                <!-- Select 3 -->
                                        <select id="memadi3" class="form-select text-dark border-0 mb-3" style="background-color: rgba(229, 0, 0, 0.3); height: 40px;">
                                        <option value='0' >N/A</option><option value='1'>Graminicola</option>
<option value='2'>Incognita</option>
<option value='3'>Javanica</option>
                                        </select>
                                        <!-- Select 4 -->
                                        <select id="memadi4" class="form-select text-dark border-0 mb-3" style="background-color: rgba(0, 0, 0, 0.3); height: 40px;">
                                        <option value='0' >N/A</option><option value='1'>Graminicola</option>
<option value='2'>Incognita</option>
<option value='3'>Javanica</option>
                                        </select>
                                        <button type="button" class="btn text-white" style="background-color: #00a78e;" onClick="SaveAndNext();document.frmCell.Task.value='UpDate';document.frmCell.submit();">Save & Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
	        </th>
            </tr>
	    <tr>
	        <td><div id="myresult" class="img-zoom-result"></div></td>
            </tr>
          </table>
    </div>
    
    
    <script>
    var myimg = document.getElementById("myimage");
    document.onclick = hideMenu;
    
    function hideMenu() {
        document.getElementById("contextMenu").style.display = "none";
    }
    
    myimg.addEventListener('contextmenu', function(rclick) {
        rclick.preventDefault();
        if (document.getElementById(
            "contextMenu").style.display == "block")
            hideMenu();
        else {
            var menu = document.getElementById("contextMenu");
            var pos;
            menu.style.zIndex = "100";
            menu.style.display = 'block';
            menu.style.left = rclick.pageX + "px";
            menu.style.top = rclick.pageY + "px";
            pos = getCursorPos(rclick);
            document.frmCell.Xval.value=pos.x;
            document.frmCell.Yval.value=pos.y;
        }
        
        function getCursorPos(rclick) {
            var a, x = 0, y = 0;
            rclick = rclick || window.event;
            /*get the x and y positions of the image:*/
            a = document.getElementById("myimage").getBoundingClientRect();
            /*calculate the cursor's x and y coordinates, relative to the image:*/
            x = rclick.pageX - a.left;
            y = rclick.pageY - a.top;
            /*consider any page scrolling:*/
            x = x - window.pageXOffset;
            y = y - window.pageYOffset;
            return {x : x, y : y};
        }
    });
    
    
    function updateInfo(sno,nc,si,vals,fname,id)
    {
        vals=vals.split(" ");
        var indx=document.getElementById('indadi');
        indx.selectedIndex=sno;
        document.getElementById('memadi1').selectedIndex=vals[1];
        if (si == 1) {
            document.getElementById('memadi1').selectedIndex=id+1;
        }
        if (nc>=2) {
            document.getElementById('memadi2').selectedIndex=vals[2];
            if (si == 2) {
                document.getElementById('memadi2').selectedIndex=id+1;
            }
        }
        if (nc>=3) {
            document.getElementById('memadi3').selectedIndex=vals[3];
            if (si == 3) {
                document.getElementById('memadi3').selectedIndex=id+1;
            }
        }
        if (nc>=4) {
            document.getElementById('memadi4').selectedIndex=vals[4];
            if (si == 4) {
                document.getElementById('memadi4').selectedIndex=id+1;
            }
        }
        
        if (nc<2) {
            document.getElementById('memadi2').style.display="none";
        }
        if (nc<3) {
            document.getElementById('memadi3').style.display="none";
        }
        if (nc<4) {
            document.getElementById('memadi4').style.display="none";
        }
        document.getElementById('myimage').src=fname;
        imageZoom("myimage", "myresult");
    }
    
    function getNext(sno,nc,fname,vals)
    {
        vals=vals.split(" ");
        var indx=document.getElementById('indadi');
        indx.selectedIndex=sno;
        document.getElementById('memadi1').selectedIndex=vals[0];
        if (nc>=2) {
            document.getElementById('memadi2').selectedIndex=vals[1];
        }
        if (nc>=3) {
            document.getElementById('memadi3').selectedIndex=vals[2];
        }
        if (nc>=4) {
            document.getElementById('memadi4').selectedIndex=vals[3];
        }
        
        if (nc<2) {
            document.getElementById('memadi2').style.display="none";
        }
        if (nc<3) {
            document.getElementById('memadi3').style.display="none";
        }
        if (nc<4) {
            document.getElementById('memadi4').style.display="none";
        }
        document.getElementById('myimage').src=fname;
        imageZoom("myimage", "myresult");
    }
    
    function SaveAndNext()
    {
        var val="";
        var sel1=document.getElementById('memadi1');
        var sel2=document.getElementById('memadi2');
        var sel3=document.getElementById('memadi3');
        var sel4=document.getElementById('memadi4');
        var indx=document.getElementById('indadi');
        val = val.concat("",(indx.selectedIndex).toString());
        if (sel1.style.display !== "none") {
            val = val.concat(" ",(sel1.selectedIndex).toString());
        }
        if (sel2.style.display !== "none") {
            val = val.concat(" ",(sel2.selectedIndex).toString());
        }
        if (sel3.style.display !== "none") {
            val = val.concat(" ",(sel3.selectedIndex).toString());
        }
        if (sel4.style.display !== "none") {
            val = val.concat(" ",(sel4.selectedIndex).toString());
        }
        document.frmCell.AnnVal.value=val;
    }
    </script>
    
    <!-- About End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded back-to-top"><i class="bi bi-arrow-up"></i></a>
    
    </form>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="lib/twentytwenty/jquery.event.move.js"></script>
    <script src="lib/twentytwenty/jquery.twentytwenty.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
