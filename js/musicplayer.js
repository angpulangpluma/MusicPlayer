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

    
    function playAudio() {
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
        if(!paused)
            playAudio();
        $('.playlist li.active').removeClass('active');
        $(next).addClass('active');
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
        if(!paused)
            playAudio();
        $('.playlist li.active').removeClass('active');
        $(prev).addClass('active');

    });

    // show playlist
    $('.pl').click(function (e) {
        e.preventDefault();

        if ( $('.playlist').is(':visible') ){
            $('.playlist').fadeOut(300);
        } else $('.playlist').fadeIn(300);
    });

    // playlist elements - click
    $('.playlist li').click(function () {
        stopAudio();
        initAudio($(this));
    });

    /*$('.save').click(function(){
        var optionTexts = [];
            $(".playlist ul").each(function() { 
            optionTexts.push("data/" + $(this).text()); 
            console.log("data/" + $(this).text());
            });
        
    });*/

    if($('ul').has('li').length >= 1){
        // initialization - first element in playlist
    initAudio($('.playlist li:first-child'));

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
    } else{
    $('.player .cover').css('background','grey');
    }
});
