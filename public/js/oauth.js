'use strict';

var oauth = 
{

    google: {
        CLIENTID  : '',
        REDIRECT  : window.location.origin +'/_oauth/google/redirect',
        OAUTHURL  : 'https://accounts.google.com/o/oauth2/auth?',
        SCOPE     : '',
        TYPE      : 'token',
        _url      : null, 
        acToken   : null,
        tokenType : null,
        expiresIn : null,
        callback  : null,
    
        login: function(callback)
        {
            oauth.google._url = oauth.google.OAUTHURL 
                              + 'scope=' + oauth.google.SCOPE 
                              + '&client_id=' + oauth.google.CLIENTID 
                              + '&redirect_uri=' + oauth.google.REDIRECT 
                              + '&response_type=' + oauth.google.TYPE;
            oauth.google.callback = callback;
            var win = window.open(oauth.google._url, "gplusoauth", 'width=600, height=500, left='+ (screen.width - 600) / 2);
    
            var pollTimer = window.setInterval(function() {
                try {
                    if (win.document.URL.indexOf(oauth.google.REDIRECT) != -1) {
                        window.clearInterval(pollTimer);
                        var url =   win.document.URL;
                        oauth.google.acToken   = oauth.google.gup(url, 'access_token');
                        oauth.google.tokenType = oauth.google.gup(url, 'token_type');
                        oauth.google.expiresIn = oauth.google.gup(url, 'expires_in');
                        win.close();
                        
                        oauth.google.callback(oauth.google.acToken);
                    }
                } catch(e) {
                }
            }, 200);
        }, // end login
    
        // credits: http://www.netlobo.com/url_query_string_javascript.html
        gup: function(url, name)
        {
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS  = "[\\#&]"+name+"=([^&#]*)";
            var regex   = new RegExp(regexS);
            var results = regex.exec(url);
            if (results == null) {
                return "";
            } else {
                return results[1];
            }
        } // end gup
    },
    
    facebook: {
        CLIENTID  : '',
        REDIRECT  : window.location.origin +'/_oauth/facebook/redirect',
        OAUTHURL  : 'https://graph.facebook.com/oauth/authorize?', 
        SCOPE     : '',
        TYPE      : 'token',
        _url      : null,
        acToken   : null,
        tokenType : null,
        expiresIn : null,
        callback  : null,
    
    
        login: function(callback)
        {
            oauth.facebook._url = oauth.facebook.OAUTHURL 
                                + 'scope=' + oauth.facebook.SCOPE 
                                + '&client_id=' + oauth.facebook.CLIENTID 
                                + '&redirect_uri=' + oauth.facebook.REDIRECT 
                                + '&response_type=' + oauth.facebook.TYPE;
            oauth.facebook.callback = callback;
            var win = window.open(oauth.facebook._url, "facebookoauth", 'width=600, height=500, left='+ (screen.width - 600) / 2);
    
            var pollTimer = window.setInterval(function() {
                try {
                    if (win.document.URL.indexOf(oauth.facebook.REDIRECT) != -1) {
                        window.clearInterval(pollTimer);
                        var url =   win.document.URL;
                        oauth.facebook.acToken   = oauth.facebook.gup(url, 'access_token');
                        oauth.facebook.tokenType = oauth.facebook.gup(url, 'token_type');
                        oauth.facebook.expiresIn = oauth.facebook.gup(url, 'expires_in');
                        win.close();
                        
                        oauth.facebook.callback(oauth.facebook.acToken);
                    }
                } catch(e) {
                }
            }, 200);
        }, // end login
    
        // credits: http://www.netlobo.com/url_query_string_javascript.html
        gup: function(url, name)
        {
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS  = "[\\#&]"+name+"=([^&#]*)";
            var regex   = new RegExp(regexS);
            var results = regex.exec(url);
            if (results == null) {
                return "";
            } else {
                return results[1];
            }
        } // end gup
    },

    twitter: {
        CLIENTID  : '',
        REDIRECT  : window.location.origin +'/_oauth/twitter/redirect',
        OAUTHURL  : 'https://api.twitter.com/oauth/request_token.json?', 
        SCOPE     : '',
        TYPE      : 'oauth_token',
        _url      : null,
        acToken   : null,
        tokenType : null,
        expiresIn : null,
        callback  : null,
    
    
        login: function(callback)
        {
            oauth.twitter._url = oauth.twitter.OAUTHURL 
                                + 'oauth_callback=' + oauth.twitter.REDIRECT 
                                + '&client_id=' + oauth.twitter.CLIENTID;
            oauth.twitter.callback = callback;
            var win = window.open(oauth.twitter._url, "facebookoauth", 'width=600, height=500, left='+ (screen.width - 600) / 2);
    
            var pollTimer = window.setInterval(function() {
                try {
                    if (win.document.URL.indexOf(oauth.twitter.REDIRECT) != -1) {
                        window.clearInterval(pollTimer);
                        var url =   win.document.URL;
                        oauth.twitter.acToken   = oauth.twitter.gup(url, 'access_token');
                        oauth.twitter.tokenType = oauth.twitter.gup(url, 'token_type');
                        oauth.twitter.expiresIn = oauth.twitter.gup(url, 'expires_in');
                        win.close();
                        
                        oauth.twitter.callback(oauth.twitter.acToken);
                    }
                } catch(e) {
                }
            }, 200);
        }, // end login
    
        // credits: http://www.netlobo.com/url_query_string_javascript.html
        gup: function(url, name)
        {
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS  = "[\\#&]"+name+"=([^&#]*)";
            var regex   = new RegExp(regexS);
            var results = regex.exec(url);
            if (results == null) {
                return "";
            } else {
                return results[1];
            }
        } // end gup
    },
    
    yahoo: {
        CLIENTID  : '',
        REDIRECT  : window.location.origin +'/_oauth/yahoo/redirect',
        OAUTHURL  : 'https://api.login.yahoo.com/oauth2/request_auth?', 
        SCOPE     : '',
        TYPE      : 'token',
        _url      : null,
        acToken   : null,
        tokenType : null,
        expiresIn : null,
        callback  : null,
    
    
        login: function(callback)
        {
            oauth.yahoo._url = oauth.yahoo.OAUTHURL 
                                + '&client_id=' + oauth.yahoo.CLIENTID 
                                + '&redirect_uri=' + oauth.yahoo.REDIRECT 
                                + '&response_type=' + oauth.yahoo.TYPE;
            oauth.yahoo.callback = callback;
            var win = window.open(oauth.yahoo._url, "facebookoauth", 'width=600, height=500, left='+ (screen.width - 600) / 2);
    
            var pollTimer = window.setInterval(function() {
                try {
                    if (win.document.URL.indexOf(oauth.yahoo.REDIRECT) != -1) {
                        window.clearInterval(pollTimer);
                        var url =   win.document.URL;
                        oauth.yahoo.acToken   = oauth.yahoo.gup(url, 'access_token');
                        oauth.yahoo.tokenType = oauth.yahoo.gup(url, 'token_type');
                        oauth.yahoo.expiresIn = oauth.yahoo.gup(url, 'expires_in');
                        win.close();
                        
                        oauth.yahoo.callback(oauth.yahoo.acToken);
                    }
                } catch(e) {
                }
            }, 200);
        }, // end login
    
        // credits: http://www.netlobo.com/url_query_string_javascript.html
        gup: function(url, name)
        {
            name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
            var regexS  = "[\\#&]"+name+"=([^&#]*)";
            var regex   = new RegExp(regexS);
            var results = regex.exec(url);
            if (results == null) {
                return "";
            } else {
                return results[1];
            }
        } // end gup
    },
    
    
};

 