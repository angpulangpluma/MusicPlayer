<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="author" content="Script Tutorials" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>HTML5 Audio player with playlist | Script Tutorials</title>
    <!-- add styles and scripts -->
    <link href="styles.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/musicplayer.js"></script>
    <script type="text/javascript">
     jQuery(document).ready(function(){
        // inner variables
    var song;
    var tracker = $('.tracker');
    var volume = $('.volume');
    var paused = true;

    function initAudio(elem) {
        var url = elem.attr('audiourl');
        var title = elem.text();
        var cover = elem.attr('cover');
        var artist = elem.attr('artist');

        if(title.length > 10){
            $('.player .title').html("<marquee width='25%'>" + title + "</marquee>");
        } else $('.player .title').text(title);

        if(artist.length > 9){
            $('.player .artist').html("<marquee width='25%'>" + artist + "</marquee>");
        } else $('.player .artist').text(artist);

        $('.player .cover').css('background-image','url(data/cover/' + cover+')');

        song = new Audio('data/music/' + url);

        // timeupdate event listener
        song.addEventListener('timeupdate',function (){
            var curtime = parseInt(song.currentTime, 10);
            tracker.slider('value', curtime);
        });

        if($('ul').has('li').length == 1){
            // set volume
    song.volume = 1;

    // initialize the volume slider
    volume.slider({
        range: 'min',
        min: 0,
        max: 100,
        value: 80,
        start: function(event,ui) {},
        slide: function(event, ui) {
            song.volume = ui.value / 100;
        },
        stop: function(event,ui) {},
    });

    // empty tracker slider
    tracker.slider({
        range: 'min',
        min: 0, max: 10,
        start: function(event,ui) {},
        slide: function(event, ui) {
            song.currentTime = ui.value;
        },   
        stop: function(event,ui) {}
    });

        elem.addClass('active');
        }

        $('.playlist li').removeClass('active');
        elem.addClass('active');
    }

        $('.add').click(function (e) {
        e.preventDefault();
        // var url=$(this).data('url');
        // var req = document.getElementById('request');
        var list = document.getElementById('file');
        // var files = new Array();
            for (var i = 0; i < list.files.length; i++){
                var name = list.files.item(i).name;
                // console.log(name);
                $('.playlist').append('<li audiourl="' + name +'" cover="cover1.jpg" artist="Artist 1">' + name + '</li>');
                // var input = document.createElement("input");
                // input.setAttribute("type", "hidden");
                // input.setAttribute("name", "song[]");
                // input.setAttribute("value", name);
                // $(".source").append(input);
                initAudio($('.playlist li:last-child'));
                // files.push(name);
            }
            // location.href="includes/uploads.php?file=" + files;
    });
     });
    </script>
</head>

<div class="player">
    <div class="pl"></div>
    <div class="title"></div>
    <div class="artist"></div>
    <div class="cover"></div>
    <div class="controls">
        <div class="play"></div>
        <div class="pause"></div>
        <div class="rew"></div>
        <div class="fwd"></div>
    </div>
    <div class="volume"></div>
    <div class="tracker"></div>
</div>

<div class="functions">
    <div class="error">
        <p id="title"></p>
        <p id="message"></p>
    </div>

    <!-- <form action="MusicPlayer.php" method="post" class="source">
    <form action="includes/process.php" name="createplaylist" method="post" class="source">
        <input type="text" name="out" id="out"/>
        <input type="submit" class="save" value="Save as .m3u" name="save"/>
        <input type="hidden" value="save" name="request"/><br/>
    </form>

     <form action="MusicPlayer.php" method="post">
    <form action="includes/process.php" method="post">
    <input type="text" id="in"/>
    <button class="load">Load .m3u</button>
    <input type="hidden" value="load" name="request"/><br/>
    </form> -->

    <!-- <form name="addplaylist" method="post" enctype="multipart/form-data"> -->
    <form name="addplaylist" action="includes/process.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" id="file" multiple/>
    <input type="hidden" value="add" id="request" name="request">
    <!-- <input type="submit" data-url="includes/uploads.php?form-action=add" value="Add to playlist" name="add" class="add"/> -->
    <input type="submit" value="Add to playlist" class="add"/>
    </form>
</div>

<ul class="playlist hidden">
</ul>

<?php
    // for($i=0;$i<count($_FILES['file']['name']); $i++){
    //     echo $_FILES['file']['name'][$i];
    // }
?>