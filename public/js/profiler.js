'use strict';

var Profiler = 
{
    sites: [],
    filters: [],
    
    init: function()
    {
        $("#slider-da, #slider-ar").slider({
            tooltip : 'always'
        });

        $('.btn-advanced').on('click', function() {
            $('.advanced-inner').toggle();
            return false;
        });
    }, // end init
    
    search: function()
    {
        this.filters = [];
        var filtered = [];
        
        var title = $('#filter-by-title').val().toLowerCase();
        if (title) {
            this.filters.push({
                title: 'title: '+ title,
                type: 'title'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.title.indexOf(title) !== -1) {
                    filtered.push(info);
                }
            }
        }
        
        var url = $('#filter-by-url').val().toLowerCase();
        if (url) {
            this.filters.push({
                title: 'url: '+ url,
                type: 'url'
            });
            for (var i = 0; i < filtered.length; i++) { 
                var info = filtered[i];
                if (info.url.indexOf(url) === -1) {
                    filtered.splice(i, 1);
                }
            }
        }
        
        var tld = $('#filter-by-tld').val().toLowerCase();
        if (tld) {
            this.filters.push({
                title: 'tld: '+ tld,
                type: 'tld'
            });
            for (var i = 0; i < filtered.length; i++) { 
                var info = filtered[i];
                if (info.tld.indexOf(tld) === -1) {
                    filtered.splice(i, 1);
                }
            }
        }
        
        var hasEmail = $('#filter-by-has-email').is(':checked');
        if (hasEmail) {
            this.filters.push({
                title: 'Get Email',
                type: 'has-email'
            });
            for (var i = 0; i < filtered.length; i++) { 
                var info = filtered[i];
                if (!info.has_email) {
                    filtered.splice(i, 1);
                }
            }
        }
        
        var hasContacts = $('#filter-by-has-contact-form').is(':checked');
        if (hasContacts) {
            this.filters.push({
                title: 'Contact Form',
                type: 'has-contact-form'
            });
            for (var i = 0; i < filtered.length; i++) { 
                var info = filtered[i];
                if (!info.has_contacts) {
                    filtered.splice(i, 1);
                }
            }
        }
        
        var hasSocialProfiles = $('#filter-by-has-social-profile').is(':checked');
        if (hasSocialProfiles) {
            this.filters.push({
                title: 'Social Profile',
                type: 'has-social-profile'
            });
            for (var i = 0; i < filtered.length; i++) { 
                var info = filtered[i];
                if (!info.has_social_profiles) {
                    filtered.splice(i, 1);
                }
            }
        }
        
        
        if (filtered.length) {
            $('.hashed').hide();
            $.each(filtered, function(key, info) {
                $('.'+info['hash']).show();
            });
        } else {
            $('.hashed').show();
        }
        
        //console.table(this.filters);
        if (this.filters.length) {
            wo.each(this.filters).render('single-close');
        }
    }, // end search
    
    removeFilter: function(type)
    {
        $('#filter-by-'+ type).val('').attr('checked', false);
        
        this.search();
    }, // end removeFilter
    
    removeAllFilters: function()
    {
        $('.filter-input').val('').attr('checked', false);
        $('#applied-filters').html('');

        this.search();
    }, // end removeAllFilters
    
};
$(document).ready(function() {
    Profiler.init();
}); 
