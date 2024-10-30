<?php
/**
 * Управление настройками Croice
 * User: P.Nixx
 * Date: 02.07.13
 * Time: 17:00
 */
?>
<script>CROICE_HOST = "<?= CROICE_HOST ?>";</script>
<style>
h2 {
    color: #4a4a4a;
    font-size: 30px;
    font-weight: normal;
}

form {
    min-height: 250px;
}

#wpbody-content {
    padding: 30px 30px 65px 15px;
    width: 764px;
}

.img-polaroid {
    background-color: #BEC5CB;
    border: medium none;
    display: block;
    height: 160px;
    padding: 6px;
    width: 160px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
td {
    vertical-align: top;
}
.yellow-but {
    background: #bff324 !important;
    font-size: 18px !important;
    color: #4f6a00 !important;
    text-shadow: none !important;
    border: none !important;
    box-shadow: 2px 2px 2px #9fad77;
    padding: 15px 0 13px !important;
    width: 235px;
    height: auto !important;
    border-radius: 7px !important;
    line-height: 18px !important;
}
footer {
    text-align: center;
}
.middle-block {
    width: 550px;
    display: table;
    margin: 0 auto;
}
#wpwrap {
    background: #eee;
}
#adminmenuback, #adminmenuwrap {
    z-index: 1;
}

.middle-block .fright, .middle-block .fleft {
    width: 50%;
}

.fleft {
    float: left;
}

.fright {
    float: right;
}

.head-info {
    display: table;
    width: 100%;
    margin-bottom: 20px;
}

.head-info span {
    font-size: 18px;
    font-weight: bold;
    color: #4a4a4a;
    line-height: 30px;
    display: inline; 
}

.head-info .button, .head-info .button:hover {
    background: none repeat scroll 0 0 #4A4A4A !important;
    border-color: #4A4A4A !important;
    border-radius: 7px;
    color: #FFFFFF !important;
    font-size: 14px;
    height: auto;
    padding: 6px 10px;
    text-shadow: none;
}

.element {
    font-size: 18px;
    color: #4a4a4a;
    display: table;
    margin-bottom: 20px;
}

.element label {
    width: 200px;
    float: left;
    display: inline-block;
}waiting-block

.element .station-description {
    display: inline-block;
    width: 340px;
    font-size: 14px;  
}

.middle-block p {
    font-size: 14px;
}

</style>

<h2>Croice configuration panel</h2>
<? if( !get_option('croice_id') ): ?>
	<div class="updated"><p><b>Welcome to CROICE Plugin! Be sure, that you have signed up, created your own radio station and got station ID at <a href="<?= CROICE_URL ?>" target="_blank">croice.com</a></b></p></div>
<? endif ?>

<form method="post" id="form_app">
	<input type="hidden" name="croice_form_counter_sub" value="Y">

	<table class="form-table">
		<tr>
			<td style="width:172px;">
			<div class="main-widget-body-right">
				<img id="cover" src="http://<?= CROICE_HOST ?>/normal_default.jpg" class="img-polaroid">
			</div>
			</td>
			<td scope="row">
				<div class="head-info">
					<span>Current radio station</span>
					<input type="submit" style="display: none;" id="submit_hidden">
					<input id="submit" class="button fright" type="button" value="Save Changes" name="submit">
				</div>
				<div class="element">
					<label for="croice_id">Your ID</label>
					<input type="text" id="croice_id" name="croice_id" value="<?= get_option('croice_id') ?>">
				</div>
<? if( get_option('croice_id') ): ?>
				<div class="element">
					<label for="">Radio station name:</label>
					<span id="channel_name"> </span>
				</div>
				<div class="element">
					<label for="">Station description:</label>
					<span class="station-description" id="channel_description"> </span>
				</div>
<? endif?>
			</td>
		</tr>
	</table>
		
</form>
<? if( get_option('croice_id') ): ?>
	<footer>
		<div class="middle-block">
			<div class="fleft">
				<a class="button yellow-but" href="<?= CROICE_URL ?>/" target="_blank">Get ID</a>
				<p>Create your radio station and get ID</p>
			</div>
			<div class="fright">
				<a class="button yellow-but" href="<?= CROICE_URL ?>/broadcasts/new" target="_blank">NEW BROADCAST</a>
				<p>Create new broadcast and start communicate with listeners</p>
			</div>
		</div>
	</footer>
<? endif ?>
<script type="text/javascript">
<? if( get_option('croice_id') ): ?>
	window.onload = function() {
  var channel_id = jQuery("#croice_id").val();
  var request_url = 'http://' + CROICE_HOST + '/api/get_channel_info/' + channel_id + '.json';
		jQuery.ajax({
			url: request_url,
			success: function(data) {
				if( data.error ) {
					alert("Invalid channel id");
					return;
				}
				jQuery('#channel_description').html(data.channel_description);
				jQuery('#channel_name').html(data.channel_name);
				jQuery('#cover').attr('src', 'http://' + CROICE_HOST + data.cover_url);
			},
			error: function() {
				alert("Something went wrong. Try again!");
			}
		});
		return false;
}
<? endif ?>
	jQuery('#submit').click(function(e){
  var channel_id = jQuery("#croice_id").val();
		var request_url = 'http://' + CROICE_HOST + '/api/get_channel_info/' + channel_id + '.json';
		jQuery.ajax({
			url: request_url,
			success: function(data) {
				jQuery('#channel_description').html(data.channel_description);
				jQuery('#channel_name').html(data.channel_name);
				jQuery('#cover').attr('src', 'http://' + CROICE_HOST + data.cover_url);
				jQuery('#submit_hidden').click();
			},
			error: function(data) {
				if( data.error ) {
					alert("Invalid channel id");
					return;
				}
				alert("Something went wrong. Try again!");
			}
		});
		return false;
	});
</script>
