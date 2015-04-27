<!doctype html>
<html>
<head>
<title>#ThinkBeforeYouTweet</title>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="mespeak/mespeak.js"></script>
<script src="jquery.lettering.js"></script>
<script src="jquery.textillate.js"></script>
<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="animate.min.css">
<style>
	*{
		margin: 0;
		padding: 0;
	}
	body{
		font-family: 'Roboto', sans-serif;
		background-color: #222;
	}
	.button{
		color:white;
		border-radius: 4px;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
		background: rgb(227, 0, 0);
		padding: 0.5em 1em;
		border: 0px none transparent;
		text-decoration: none;
		letter-spacing: .05em;.
		cursor: pointer;
		font-weight: bold;
	}
	a{
		color:rgb(227, 0, 0);
		text-decoration: none;
	}
	a:hover{
		color:rgb(200, 0, 0);
	}
	.subhead a{
		position: absolute;
		top: 1%;
		left: 1%;
		font-size: 2em;
		font-weight: bold;
	}
	#home{
		position: absolute;
		width:100%;
		height:90vh;
		background-color: #222;
		display: none;
	}
	#home header{
		position: relative;
		width: 100%;
		color: white;
		text-align: center;
		font-size: 4em;
		top:25%
	}
	#homeButton{
		position: relative;
		margin: 0 auto;
		display: block;
		top: 40%;
        font-size: 1.2em;
	}
	#background{
		position: absolute;
		width:100%;
		height:90vh;
		background-color: #222;
		color: white;
		display: none;
	}
	#background p{
		text-align: justify;
		width: 70%;
		margin: 0 auto;
		margin-top: 10%;
        font-size: 1.2em;
	}
	#backgroundButton{
		position: relative;
		margin: 0 auto;
		display: block;
		top: 15%;
        font-size: 1.2em;
	}
	#play{
		position: absolute;
		width:100%;
		height:90vh;
		background-color: #222;
		color: white;
		display: none;
	}
	#startButton{
		position: relative;
		margin: 0 auto;
		display: block;
		top: 40%;
		font-size: 2em;
		z-index: 10;
	}
	#stopButton{
		position: relative;
		margin: 0 auto;
		display: none;
		top: 90%;
		font-size: 1em;
		z-index: 10;
	}
	#play h1{
		color:white;
		position: absolute;
		top:10%;
		left:0%;
		width: 30%;
		font-size: 1.3em;
		z-index: 5;
        text-align: center;
	}
	footer{
		position: fixed;
		width: 100%;
		top:90%;
		height: 10vh;
		background-color: #000;
		color: white;
		text-align: center;
	}
	footer p{
		position: absolute;
		top: 50%;
		font-size: .8em;
		width: 100%;
	}
</style>
</head>
<body>

<!--Page 1-->
<div id="home">
	<header>#ThinkBeforeYouTweet</header>
	<button class="button" id="homeButton">Welcome</button>
</div>

<!--Page 2-->
<div id="background">
	<header class="subhead"><a href="index.php">#ThinkBeforeYouTweet</a></header>
	<p>Cyberbullying is quickly become the most prominent form of bullying that goes uncaught. 43% of teens have experienced cyberbullying in the past year and 59% of teens believe cyberbullying takes place because the action isn’t interpreted as a “Big Deal.” It’s easy to send a hurtful message to a person online because the consequences aren’t seen. However, the National Crime Prevention Council President, Alfonso Lenhardt, <a href="http://www.ncpc.org/resources/files/pdf/bullying/Cyberbullying%20Trends%20-%20Tudes.pdf">states</a>, “Cyberbullying can have the same debilitating effects on a young person as face-to-face bullying – depression, a drop in grades, loss of self-esteem, suicide, and other violent acts.” The aim of this project is to simulate how a victim of cyberbullying perceives the situation.
<br>
<br>
Using Python and <a href="http://www.tweepy.org/">Tweepy</a> I gathered live data from Twitter, by listening for keywords that may indicate cyberbullying over periods of 30 minutes. The tweets were uploaded to a MySQL database where I manually reviewed the tweets to make sure they meet the specific criteria. Then the tweets are loaded into the project with python and vocalized using <a href="http://www.masswerk.at/mespeak/">meSpeak.js</a> and animated using <a href="http://jschr.github.io/textillate/">Textillate.js</a>.
</p>
	<button class="button" id="backgroundButton">Next</button>
</div>

<!--Page 3-->
<div id="play">
<header class="subhead"><a href="index.php">#ThinkBeforeYouTweet</a></header>
<button class="button" id="startButton">Begin</button>
<button class="button" id="stopButton">Pause</button>

<!--Text Boxes to be filled with tweet-->
<h1 class="tlt" id="item1">
	<ul class="texts">
		<li id="para1"></li>
		<li></li>
	</ul>
</h1>
<h1 class="tlt" id="item2">
	<ul class="texts">
		<li id="para2"></li>
		<li></li>
	</ul>
</h1>
<h1 class="tlt" id="item3">
	<ul class="texts">
		<li id="para3"></li>
		<li></li>
	</ul>
</h1>
<h1 class="tlt" id="item4">
	<ul class="texts">
		<li id="para4"></li>
		<li></li>
	</ul>
</h1>
</div>

<!--Establish Connection With Database-->
<?php
//Connect
$connection = mysqli_connect("localhost", "lomc9041", "Test123!", "lomc9041db");
//Check if succesful
if (!$connection){
	die("Connection Failed: "  .mysqli_connect_error());
}
//Gets Tweet and saves into Aray
$data = mysqli_query($connection, "SELECT tweet FROM cb");
$rows = array();
while($i = mysqli_fetch_row($data)){
	$rows[] = $i;
}
mysqli_close($connection);
?>

<!--Grab Tweet and TTS-->

<script>
$(function(){
	$('#home').fadeIn('slow');
	//Declarations
	var tweet, voices, amp, pit, speed, voice, repeat, count = 1, name, x, y, second = false;
	//Gets Tweets in JSON format
	var table = <?php echo json_encode($rows, JSON_PRETTY_PRINT)?>;
	//meSpeak Setup
	meSpeak.loadConfig("mespeak/mespeak_config.json");
	meSpeak.loadVoice('mespeak/voices/en/en-us.json');
	
	//Button Press
	//Color Change
	$('button').mousedown(function(){
		$('button').css("background-color", "rgb(200, 0, 0)")
	});
	$('button').mouseup(function(){
		$('button').css("background-color", "rgb(227, 0, 0)")
	});
	//Home
	$("#homeButton").click(function(){
		$("#home").fadeOut();
		$("#background").fadeIn('slow');
	});
	//about
	$("#backgroundButton").click(function(){
		$("#background").fadeOut();
		$("#play").fadeIn('slow');
	});
	//Start the voices
	$("#startButton").click(function(){
		$('#startButton').hide();
		$('#stopButton').css('display', 'block').fadeIn('slow');
		play();
	});
	$('#stopButton').click(function(){
		$('#stopButton').hide();
		$('#startButton').html("Resume").fadeIn('slow');
		pause();
	});
	
	//Plays the text
	function play(){
		//Selects the Tweet
		tweet = Math.floor(Math.random()*table.length);
		//Different voice options
		voices = ["f1", "f2", "f3", "f4", "f5", "m1", "m2", "m3", "m4", "m5", "m6", "m7"]
		//Random Number to choose Amplitude
		amp = Math.floor(Math.random()*90)+10;
		//Random Number to choose Pitch
		pit = Math.floor(Math.random()*20) + 40;
		//Random Number to choose Speed
		speed = Math.floor(Math.random()*50)+150;
		//Random Number to choose voice
		voice = voices[Math.floor(Math.random()*voices.length)];

		//Create the Speech
		meSpeak.speak(table[tweet], {amplitude: amp, pitch: pit, speed: speed, variant: voice});		
		//Play another phrase randomly
		time = (Math.floor(Math.random()*5)+1) * 1000;

		//Display Tweet
		//generate random coordinates
		x = Math.floor(Math.random()*70);
		x = x+"%";
		y = Math.floor(Math.random()*70);
		y = y+"%";

		//Add Tweet to display out
		$("#para"+count).html(table[tweet]);
		//Move to random position
		$('#item'+count).css({
			"left": x,
			"top": y
		});
		//If it's the second run through
		if (second)
			$('#item'+count).textillate('start');
		//first run through
		else{
			//Animation effects
			$('#item'+count).textillate({
				in: { effect: 'fadeIn'},
				out: { effect: 'fadeOut', sync: true}
			});
		}

		//Increment through elements
		count++;
		if (count == 5){
			second = true;
			count = 1;
		}
		//Print Data
		console.log("Tweet:"+table[tweet]+" Amplitude:"+amp+" Pitch:"+pit+" Speed:"+ speed+" Voice:" + voice+ " Wait:"+time+" Position:" +x+" "+ y+ "\n\n");

		//Start the next tweet
		repeat = setTimeout(play, time);
	}
	//Stops simulation
	function pause(){
		clearTimeout(repeat);
	}
});
</script>
<footer>
<p>Think Before You Tweet&copy; made by <a href="http://loganmccaul.com">Logan McCaul</a> at the University of Colorado Boulder.</p>
</footer>
</body>
</html>