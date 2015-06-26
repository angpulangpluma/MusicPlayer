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

<div class="file">
    <form action="process.php" method="post" class="source">
        <input type="text" name="out" id="out"/>
        <input type="submit" class="save" value="Save as .m3u"/>
        <input type="hidden" value="save" name="request"/><br/>
    </form>
    <input type="text" id="in"/>
    <button class="load">Load .m3u</button><br/>
    <input type="text" id="initem"/>
    <button class="add" >Add to playlist</button>
</div>

<ul class="playlist hidden">
    <!--<li audiourl="01.mp3" cover="cover1.jpg" artist="Artist 1">01.mp3</li>
    <li audiourl="02.mp3" cover="cover2.jpg" artist="Artist 2">02.mp3</li>
    <li audiourl="03.mp3" cover="cover3.jpg" artist="Artist 3">03.mp3</li>
    <li audiourl="04.mp3" cover="cover4.jpg" artist="Artist 4">04.mp3</li>
    <li audiourl="05.mp3" cover="cover5.jpg" artist="Artist 5">05.mp3</li>-->
</ul>