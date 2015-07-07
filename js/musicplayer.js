/**
 *
 * HTML5 Audio player with playlist
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Script Tutorials
 * http://www.script-tutorials.com/
 */
 
jQuery(document).ready(function() {

    // inner variables
    //note: onended for counting how many times it will play
    var song;
    var tracker = $('.tracker');
    var volume = $('.volume');
    var paused = true;
    var start = true;

    function initAudio(elem) {
        var url = elem.attr('audiourl');
        var title = elem.text();
        var cover = elem.attr('cover');
        var artist = elem.attr('artist');

        if(title.length > 10){
            $('.player .title').html("<marquee>" + title + "</marquee>");
        } else $('.player .title').text(title);

        if(artist.length > 9){
            $('.player .artist').html("<marquee>" + artist + "</marquee>");
        } else $('.player .artist').text(artist);

        $('.player .cover').css('background-image','url(data/cover/' + cover+')');

        song = new Audio('data/music/' + url);

        // timeupdate event listener
        song.addEventListener('timeupdate',function (){
            var curtime = parseInt(song.currentTime, 10);
            tracker.slider('value', curtime);
        });

        // end listener – play next
        song.addEventListener('ended',function(){
            var next = $('.playlist li.active').next();
            if (next.length == 0) {
                next = $('.playlist li:first-child');
            }
            tracker.slider('value', 0);
            $('.playlist li.active').removeClass('active');
            next.addClass('active');
            initAudio(next);
            if(!paused){
                playAudio();
            } else stopAudio();
            tracker.slider("option", "max", song.duration);
        });

            // set volume
            song.volume = 1;

            // // empty tracker slider
            // tracker.slider({
            //     range: 'min',
            //     min: 0, max: 10,
            //     start: function(event,ui) {},
            //     slide: function(event, ui) {
            //         song.currentTime = ui.value;
            //     },
            //     stop: function(event,ui) {}
            // });

    }
    function playAudio() {
        // cursong = song;
        song.play();

        tracker.slider("option", "max", song.duration);

        $('.play').addClass('hidden');
        $('.pause').addClass('visible');
    }
    function stopAudio() {
        song.pause();

        $('.play').removeClass('hidden');
        $('.pause').removeClass('visible');
    }

    // play click
    $('.play').click(function (e) {
        e.preventDefault();
        paused = false;
        playAudio();
    });

    // pause click
    $('.pause').click(function (e) {
        e.preventDefault();
        paused = true;
        stopAudio();
    });

    // forward click
    $('.fwd').click(function (e) {
        e.preventDefault();

        stopAudio();

        var next = $('.playlist li.active').next();

        if (next.length == 0) {
            next = $('.playlist li:first-child');
        }

        initAudio(next);
        tracker.slider('value', 0);

        if(!paused){
            // tracker.slider('value', 0);
            tracker.slider("option", "max", song.duration);
            playAudio();
        }
        // tracker.slider("option", "max", song.duration);

        $('.playlist li.active').removeClass('active');
        next.addClass('active');
    });

    // rewind click
    $('.rew').click(function (e) {
        e.preventDefault();

        stopAudio();

        var prev = $('.playlist li.active').prev();
        if (prev.length == 0) {
            prev = $('.playlist li:last-child');
        }
        initAudio(prev);
        // if(!paused){
        //     tracker.slider('value', 0);
        //     playAudio();
        // }
        // tracker.slider("option", "max", song.duration);
        tracker.slider('value', 0);
        if(!paused){
            // tracker.slider('value', 0);
            playAudio();
        }
        tracker.slider("option", "max", song.duration);

        $('.playlist li.active').removeClass('active');
        prev.addClass('active');

    });

    $('.add').click(function(e){
        e.preventDefault();
        var fileSelect = document.getElementById('file');
        var files = fileSelect.files;
        var formData = new FormData();

        for(var i=0; i<files.length; i++){
            var file = files.item(i);

            //error checking here

            formData.append('files[]', file, file.name);
        }

        // formData.append('files[]', files);
        console.log("To send through ajax: ");
        for (var i=0; i<files.length; i++){
            console.log(files.item(i).name + "\n");
        }
        // alert(JSON.stringify(formData));

        $.ajax({
            url: 'includes/process.php',
            type: "POST",
            xhr: function(){
                var myXhr = $.ajaxSettings.xhr();
                return myXhr;
            },
            data: formData,
             success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                console.log(textStatus);
                for (var i = 0; i < files.length; i++){
                    var name = files.item(i).name;
                    // console.log(name);
                    $('.playlist').append('<li audiourl="' + name +'" cover="cover1.jpg" artist="Artist 1">' + name + '</li>');
                    if($('ul').has('li').length > 0 && start){
                        $('.playlist li:first-child').addClass('active');
                        start = false;
                    }
                    // $('.playlist li:last-child').addEventListener("onclick", function(e){
                    //     stopAudio();
                    //     initAudio($(this));
                    //     tracker.slider('value', 0);
                    //     // tracker.slider("option", "max", song.duration);
                    //     $('.playlist li.active').removeClass('active');
                    //     $(this).addClass('active');
                    //     playAudio();               
                    // });
                    initAudio($('.playlist li:last-child'));
                }
                initAudio($('.playlist li:first-child'));
            }
            else
            {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        },
            cache: false,
            contentType: false,
            processData: false
        });

    });

    // show playlist
    $('.pl').click(function (e) {
        e.preventDefault();

        if ( $('.playlist').is(':visible') ){
            $('.playlist').fadeOut(300);
        } else $('.playlist').fadeIn(300);
    });

    $(".playlist").on("click", "li", function(e){
        stopAudio();
        initAudio($(this));
        tracker.slider('value', 0);
        // tracker.slider("option", "max", song.duration);
        $('.playlist li.active').removeClass('active');
        $(this).addClass('active');
        playAudio();
    });

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
        start: function(event,ui) {

        },
        slide: function(event, ui) {
            song.currentTime = ui.value;
        },
        stop: function(event,ui) {
            
        }
    });
    // } else{
    $('.player .cover').css('background','grey');
    // }
});
 