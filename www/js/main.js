/*
    Designed by: David McClain
    Copyright (c) <2016> <David McClain> www.dirtyredz.com
*/

var main = {
    OnLoad: function () {
        main.init();
    },
    init: function () {
        //Register Event Functions
        main.InteruptLink();
        //Clear JS dependent display none
        $('.FadeInOnLoad').removeClass('FadeInOnLoad');

    },
    OnScroll: function () {
        /// <signature>
        /// <summary>On Scroll Event</summary>
        /// </signature>
        $(window).scroll(function () {

        });
    },
    InteruptLink: function(){
        $('a').click(function (event) {
            // Remember the link href
            var href = this.href;
            // Don't follow the link
            event.preventDefault();
            // Do the async thing
            LoadTransition(function () {
                // This is the completion callback for the asynchronous thing;
                // go to the link
                window.location = href;
            });

        });
        function LoadTransition(callback) {
            if (callback && typeof (callback) == 'function') {
                callback();
            }
        };
    },
    ToggleAttr: function ($Elem,Attr, Case1, Case2) {
        if ($Elem.attr(Attr) == Case1) {
            $Elem.attr(Attr, Case2);
        } else if ($Elem.attr(Attr) == Case2) {
            $Elem.attr(Attr, Case1);
        }
    },
    log: function (Message) {
        /// <signature>
        /// <summary>Custom Console.log</summary>
        /// <param name="Message">Message to be passed to the console</param>
        /// </signature>
        if (Message) {
            console.log(Message);
        }
    }
}
$(window).on('load', function () { main.OnLoad() });
