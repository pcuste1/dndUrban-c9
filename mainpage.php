<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
session_start();

function loginForm(){
    echo'
    <div id="loginform">
    <form action="mainpage.php" method="post" style="justify-content:center;">
        <p>Please enter your name to continue:</p>
        <label for="name"></label>
        <input type="text" name="name" id="name" />
        <input type="submit" style="background: transparent;border: none !important;font-size:0;" name="enter" id="enter" value="send" alt="Enter" />
    </form>
    </div>
    ';
    }
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        $filename = "log.html";
        $fileContent = file_get_contents($filename);
        $string = "<div class='msgln'><i>User ". $_SESSION['name'] ." has joined the chat session.</i><br></div>";
        file_put_contents($filename, $string . $fileContent);       
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}

if(isset($_GET['logout'])){ 
     
    //Simple exit message
    $filename = "log.html";
    $fileContent = file_get_contents($filename);
    $string = "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>";
    file_put_contents($filename, $string . $fileContent);
    
    #$fp = fopen("log.html", 'a');
    #fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
    #fclose($fp);
     
    session_destroy();
    header("Location: mainpage.php"); //Redirect the user
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Chat</title>
<link type="text/css" rel="stylesheet" href="style.css" />
</head>
<body>
<?php
if(!isset($_SESSION['name'])){
    loginForm();
}
else{
?>
<div id="top">
<form name="message" action="">
        <br />
        <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="#">Exit Chat</a></p>
        </div>
        <textarea name="usermsg" id="usermsg" cols="70" rows="2" size="140"></textarea>
        <br />
        <br />
        <!--<input type="image" src="enter_button.png" onMouseOver="this.src='enter_button_hover.png'" onMouseOut="this.src='enter_button.png'" alt="Enter">-->
        <input name="submitmsg" type="image"  style="background: transparent;border: none !important;font-size:0;" id="submitmsg" value="Send" alt="Enter"/>
        <br />
</form>
</div>
<br/>
<div id="bottom">
<div id="wrapper">
    <div id="chatbox"><?php
        if(file_exists("log.html") && filesize("log.html") > 0){
        $handle = fopen("log.html", "r");
        $contents = fread($handle, filesize("log.html"));
        fclose($handle);
        echo $contents;
        }
    ?>
    </div>
    <!--<span id="C">C:\&gt;</span> <span id="FakeTextbox"></span><span id="Score">_</span>

    <p>
        <input type="text" id="RealTextbox" />
    </p>--> 
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document
    $(document).ready(function(){

    $(function() {
    $("#usermsg").keypress(function (e) {
        if(e.which == 13) {
            //submit form via ajax, this is not JS but server side scripting so not showing here
            var clientmsg = $("#usermsg").val();
		    $.post("post.php", {text: clientmsg});
		    $("#usermsg").attr("value", "");
		    return false;
        }
    });
    });


    /*$('#FakeTextbox, #Score').click(function()
    {
        $('#RealTextbox').focus();
    });

    $('#RealTextbox').keyup(function(e)
    {
        var code = (e.keyCode ? e.keyCode : e.which);
        // Enter key?
        if(code == 13)
        {
            // Don't put a newline if this is the first command
            //if ($('#PastCommands').html() != '')
            //    $('#PastCommands').append('<br />');
            $('#PastCommands').append($(this).val());
            $.post("post.php", {text: $(this).val()});
            $(this).val('');
        }
        else
            $('#FakeTextbox').html($(this).val());
    });

    $('#RealTextbox').focus();
    */
    setInterval (loadLog, 2500);
    
    //If user wants to end session
	$("#exit").click(function(){
		var exit = confirm("Are you sure you want to end the session?");
		if(exit==true){window.location = 'mainpage.php?logout=true';}		
	});
	//If user submits the form
	$("#submitmsg").click(function(){	
		var clientmsg = $("#usermsg").val();
		$.post("post.php", {text: clientmsg});
		$("#usermsg").attr("value", "");
		return false;
	});
	//Load the file containing the chat log
	function loadLog(){		
		var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
		$.ajax({
			url: "log.html",
			cache: false,
			success: function(html){		
				$("#chatbox").html(html); //Insert chat log into the #chatbox div	
				
				//Auto-scroll			
				var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}				
		  	},
		});
	}
});
</script>
<?php
}
?>
</body>
</html>