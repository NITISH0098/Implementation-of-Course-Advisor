function f1()
    {
        var abc=document.getElementById('navLinks');
        abc.classList.toggle('navlinkActivate');
        
    
        var xy=document.getElementById("button1");
        if(xy.value=="=")
            {
                xy.value="-";
            }
        else
            {
                xy.value="=";
            }
     }