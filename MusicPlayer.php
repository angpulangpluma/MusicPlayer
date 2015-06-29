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

<div class="functions">
    <!-- <form action="MusicPlayer.php" method="post" class="source"> -->
    <form action="includes/process.php" method="post" class="source">
        <input type="text" name="out" id="out"/>
        <input type="submit" class="save" value="Save as .m3u"/>
        <input type="hidden" value="save" name="request"/><br/>
    </form>

    <!-- <form action="MusicPlayer.php" method="post"> -->
    <form action="includes/process.php" method="post">
    <input type="text" id="in"/>
    <button class="load">Load .m3u</button>
    <input type="hidden" value="load" name="request"/><br/>
    </form>

    <!-- <form method="post" action="MusicPlayer.php" enctype="multipart/form-data"> -->
    <form method="post" action="includes/process.php" enctype="multipart/form-data">
    <input type="file" name="file[]" id="file" multiple/>
    <input type="hidden" value="add" name="request">
    <input type="submit" value="Add to playlist" name="submit"/>
    </form>
</div>

<ul class="playlist hidden">
</ul>

<?php
    // for($i=0;$i<count($_FILES['file']['name']); $i++){
    //     echo $_FILES['file']['name'][$i];
    // }
?>