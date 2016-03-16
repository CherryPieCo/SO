'use strict';

var App = 
{
    
    login: function()
    {
        $('#bg_fade').css('visibility', 'visible');
        var $popup = $('#magestore-popup');
        $popup.css('left', ($(window).width() / 2) - ($popup.width() / 2));
        $popup.show();
    }, // end login
    
    oauth: function(provider)
    {
        var url = window.location.origin +'/_oauth/'+ provider;
        var redirect = window.location.origin +'/_oauth/'+ provider+ '/redirect';
        
        var win = window.open(url, "oauth", 'width=600, height=500, left='+ (screen.width - 600) / 2);
        var pollTimer = window.setInterval(function() {
            try {
                if (win.document.URL.indexOf(redirect) != -1) {
                    window.clearInterval(pollTimer);
                    //win.close();
                }
            } catch(e) {
            }
        }, 200);
    }, // end oauth
      
};
