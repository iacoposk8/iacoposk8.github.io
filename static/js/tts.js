$(document).ready(function(){
	$("head").append('<link crossorigin="anonymous" media="all" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />');
	$("head").append(`
		<style>
		.tts{
			max-width: 200px;
		}
		.tts .buttons i{
			font-size: 20px;
			margin: 0 10px;
			cursor: pointer;
		}

		.tts .progress,
		.tts .progressbar > div{
			border-radius: 4px;
			height: 10px;
		}
		.tts .progressbar{
			background: #f1f1f1;
		}
		.tts .progressbar > div{
			background: #2196F3;
		}

		.tts .progress{
			text-align: center;
		}

		.tts .progress{
			font-size: 12px;
		}
		</style>
	`);
})

var TTS = function(elem, title, lang, txt, read_from, delete_path){
	var self = this;
	self.audiotts = -1;
	//var blocks = txt.split(".");
	var blocks = [txt];
	var durations = [];

	if(typeof read_from === "undefined")
		var current_play = 0;
	else
		var current_play = read_from;

	var current_conv = 0;
	var started_conv = 0;
	var playclick = 0;
	//var url_part = location.host.split(":");
	//var host = url_part[0];
	var host = location.host

	$.ajax({
		method: "POST",
		url: "https://"+host+"/tts_resume",
		data: { 
			name: title,
			delete: delete_path
		},
		success: function(e){
			if(typeof e["current_conv"] !== "undefined")
			{
				durations = e["durations"];
				if(typeof read_from === "undefined")
					current_play = e["current_play"];
				current_conv = e["current_conv"];
			}
		}
	});

	var blocks = blocks.filter(function (el) {
		//return title.trim() != "";
		return el.trim() != "";
	});

	if(started_conv == 0){
		started_conv = 1;
		get_next();

		setInterval(function(){
			set_progress();
		}, 1000);
	}

	if(elem !== false){
		var tts = $('<div class="tts"></div>').appendTo(elem);

		var progressbar_cont = $(`<div class="progressbar"></div>`).appendTo(tts);
		var progressbar = $(`<div></div>`).appendTo(progressbar_cont);

		var progress = $(`<div class="progress"></div>`).appendTo(tts);

		var buttons = $('<div class="buttons"></div>').appendTo(tts);

		var backward = $('<i class="fa-solid fa-backward"></i>').appendTo(buttons);
		var playbtn = $('<i class="fa-solid fa-play"></i>').appendTo(buttons);
		var pausebtn = $('<i class="fa-solid fa-pause" style="display:none;"></i>').appendTo(buttons);
		var stopbtn = $('<i class="fa-solid fa-stop"></i>').appendTo(buttons);
		var forward = $('<i class="fa-solid fa-forward"></i>').appendTo(buttons);

		var speed = $('<input id="speed" type="range" min="1" max="30" value="20">').appendTo(tts);

		playbtn.click(function(){
			self.play()
		});

		stopbtn.click(function(){
			pause(0);
		});

		pausebtn.click(function(){
			pause();
		});

		backward.click(function(){
			self.backward();
		});

		forward.click(function(){
			self.forward();
		});
	}

	function digit2(n){
		n = parseInt(n);
		if(n < 10)
			return "0" + n;
		return n;
	}

	function secondsToString(seconds) {
		var numhours = Math.floor(((seconds % 31536000) % 86400) / 3600);
		var numminutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60);
		var numseconds = (((seconds % 31536000) % 86400) % 3600) % 60;
		return digit2(numhours) + ":" + digit2(numminutes) + ":" + digit2(numseconds);
	}

	function totaltime(limit){
		var sum = 0;
		for(var i in durations){
			if(typeof limit !== "undefined" && i > limit)
				break;

			sum += durations[i];
		}
		
		return parseInt(sum);
	}

	function set_progress(){
		var tot = blocks.length - 1;
		if(typeof self.audiotts == -1 && typeof self.audiotts.currentTime === "undefined")
			var ct = 0;
		else if(typeof self.audiotts !== "undefined")
			var ct = self.audiotts.currentTime;

		if(elem !== false){
			progress.html(current_play+"/"+tot + " " + secondsToString(totaltime(current_play - 1) + ct) + " / " + secondsToString(totaltime()));

			var perc = (current_play / tot) * 100;
			progressbar.css("width", perc + "%");
		}

		if(current_play != 0 && current_conv != 0){
			$.ajax({
				method: "POST",
				url: "https://"+host+"/tts_save",
				data: { 
					name: title,
					durations: durations,
					current_play: current_play,
					current_conv: current_conv
				}
			});
		}
	}
	set_progress();

	function get_filename(n){
		return title + "/" + n + ".mp3";
	}

	function get_next(){
		//console.log(current_conv+" >= "+blocks.length);
		if(current_conv >= blocks.length){
			current_conv++;
			return false;
		}

		$.ajax({
			method: "POST",
			url: "https://"+host+"/tts",
			data: { txt : blocks[current_conv], name: get_filename(current_conv), lang: lang },
			success: function(e){
				durations.push(parseFloat(e["mp3len"]));
				current_conv++;
				get_next();
			}
		});
	}

	function playpause(type){
		if(type=="play"){
			if(elem !== false){
				playbtn.css("display", "inline");
				pausebtn.css("display", "none");
			}
			playclick = 0;
		} else {
			if(elem !== false){
				playbtn.css("display", "none");
				pausebtn.css("display", "inline");
			}
			playclick = 1;
		}
	}

	self.backward = function(){
		self.pause(0);
		if(current_play >= 1)
			current_play--;
		self.play();
	}

	self.forward = function(){
		self.pause(0);
		if(current_play < blocks.length)
			current_play++;
		self.play();
	}

	self.pause = function(ct){
		playpause("play");

		if(self.audiotts != -1){
			self.audiotts.pause();
			if(typeof ct !== "undefined")
				self.audiotts.currentTime = ct;
		}
	}

	self.play_callback = function(){

	}

	self.playbackRate = 1;

	self.play = function(){
		playpause("pause");

		//console.log(current_play+" >= "+blocks.length+" ("+current_conv+")");
		if(current_play >= current_conv){
			setTimeout(function(){
				self.play()
			}, 1000);
		}
		else if(current_play >= blocks.length){
			current_play = 0;
			playpause("play");

			if(typeof self.play_callback !== "undefined")
				self.play_callback();

			/*$.ajax({
				method: "GET",
				url: "https://"+host+"/tts_clear"
			});*/

			return false;
		}
		else{
			self.audiotts = new Audio('https://'+host+'/static/tts/' + get_filename(current_play));

			if(elem !== false)
				self.audiotts.playbackRate = parseInt(speed.val()) / 10;
			else
				self.audiotts.playbackRate = parseFloat(self.playbackRate);

			self.audiotts.play();

			self.audiotts.onended = () => {
				current_play++;
				if(playclick == 1)
					self.play();
			};
		}
	}
}