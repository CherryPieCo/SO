'use strict';

var Profiler = 
{
    sites: [],
    filters: [],
    filtered: [],
    
    init: function()
    {
        $("#slider-da").slider({
            tooltip : 'always'
        }).on('slideStop', function(e) {
            Profiler.search();
        });
        $("#slider-ar").slider({
            tooltip : 'always'
        }).on('slideStop', function(e) {
            Profiler.search();
        });

        $('.btn-advanced').on('click', function() {
            $('.advanced-inner').toggle();
            return false;
        });
        
        $('.filter-input').on('change', function() {
            Profiler.search();
        });
    }, // end init
    /*
    filterWithIntersect: function()
    {
        var title = $('#filter-by-title').val().toLowerCase();
        if (title) {
            this.filters.push({
                title: 'title: '+ title,
                type: 'title'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.title.indexOf(title) !== -1) {
                    this.filtered.push(info);
                }
            }
        }
        
        var url = $('#filter-by-url').val().toLowerCase();
        if (url) {
            this.filters.push({
                title: 'url: '+ url,
                type: 'url'
            });
            for (var i = 0; i < this.filtered.length; i++) { 
                var info = this.filtered[i];
                if (info.url.indexOf(url) === -1) {
                    this.filtered.splice(i, 1);
                }
            }
        }
        
        var tld = $('#filter-by-tld').val().toLowerCase();
        if (tld) {
            this.filters.push({
                title: 'tld: '+ tld,
                type: 'tld'
            });
            for (var i = 0; i < this.filtered.length; i++) { 
                var info = this.filtered[i];
                if (info.tld.indexOf(tld) === -1) {
                    this.filtered.splice(i, 1);
                }
            }
        }
        
        var hasEmail = $('#filter-by-has-email').is(':checked');
        if (hasEmail) {
            this.filters.push({
                title: 'Get Email',
                type: 'has-email'
            });
            for (var i = 0; i < this.filtered.length; i++) { 
                var info = this.filtered[i];
                if (!info.has_email) {
                    this.filtered.splice(i, 1);
                }
            }
        }
        
        var hasContacts = $('#filter-by-has-contact-form').is(':checked');
        if (hasContacts) {
            this.filters.push({
                title: 'Contact Form',
                type: 'has-contact-form'
            });
            for (var i = 0; i < this.filtered.length; i++) { 
                var info = this.filtered[i];
                if (!info.has_contacts) {
                    this.filtered.splice(i, 1);
                }
            }
        }
        
        var hasSocialProfiles = $('#filter-by-has-social-profile').is(':checked');
        if (hasSocialProfiles) {
            this.filters.push({
                title: 'Social Profile',
                type: 'has-social-profile'
            });
            for (var i = 0; i < this.filtered.length; i++) { 
                var info = this.filtered[i];
                if (!info.has_social_profiles) {
                    this.filtered.splice(i, 1);
                }
            }
        }
    }, // end filterWithIntersect
    */
    filterWithAdd: function()
    {
        var daSlider = $("#slider-da").slider();
        var daSliderValues = daSlider.slider('getValue');
        var minDaSlider = daSlider.slider('getAttribute', 'min');
        var maxDaSlider = daSlider.slider('getAttribute', 'max');
        if (daSliderValues[0] != minDaSlider || daSliderValues[1] != maxDaSlider) {
            this.filters.push({
                title: 'da: '+ daSliderValues[0] +' - '+ daSliderValues[1],
                type: 'slider-da'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.domain_authority >= daSliderValues[0] && info.domain_authority <= daSliderValues[1]) {
                    this.filtered.push(info);
                }
            }
        } else {
            $('#applied-filter-slider-da').remove();
        }
        
        var arSlider = $("#slider-ar").slider();
        var arSliderValues = arSlider.slider('getValue');
        var minArSlider = arSlider.slider('getAttribute', 'min');
        var maxArSlider = arSlider.slider('getAttribute', 'max');
        if (arSliderValues[0] != minArSlider || arSliderValues[1] != maxArSlider) {
            this.filters.push({
                title: 'ar: '+ arSliderValues[0] +' - '+ arSliderValues[1],
                type: 'slider-ar'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.alexa_rank >= arSliderValues[0] && info.alexa_rank <= arSliderValues[1]) {
                    this.filtered.push(info);
                }
            }
        } else {
            $('#applied-filter-slider-ar').remove();
        }
        
        
        var title = $('#filter-by-title').val().toLowerCase();
        if (title) {
            this.filters.push({
                title: 'title: '+ title,
                type: 'title'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.title.indexOf(title) !== -1) {
                    this.filtered.push(info);
                }
            }
        }
        
        var url = $('#filter-by-url').val().toLowerCase();
        if (url) {
            this.filters.push({
                title: 'url: '+ url,
                type: 'url'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.url.indexOf(url) !== -1) {
                    this.filtered.push(info);
                }
            }
        }
        
        var tld = $('#filter-by-tld').val().toLowerCase();
        if (tld) {
            this.filters.push({
                title: 'tld: '+ tld,
                type: 'tld'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.tld.indexOf(tld) !== -1) {
                    this.filtered.push(info);
                }
            }
        }
        
        var hasEmail = $('#filter-by-has-email').is(':checked');
        if (hasEmail) {
            this.filters.push({
                title: 'Get Email',
                type: 'has-email'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.has_email) {
                    this.filtered.push(info);
                }
            }
        }
        
        var hasContacts = $('#filter-by-has-contact-form').is(':checked');
        if (hasContacts) {
            this.filters.push({
                title: 'Contact Form',
                type: 'has-contact-form'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.has_contacts) {
                    this.filtered.push(info);
                }
            }
        }
        
        var hasSocialProfiles = $('#filter-by-has-social-profile').is(':checked');
        if (hasSocialProfiles) {
            this.filters.push({
                title: 'Social Profile',
                type: 'has-social-profile'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (info.has_social_profiles) {
                    this.filtered.push(info);
                }
            }
        }
    }, // end filterWithAdd
    
    search: function()
    {
        this.filters = [];
        this.filtered = [];
        
        this.filterWithAdd();
        //this.filterWithIntersect();
        
        if (this.filters.length) {
            $('.hashed').hide();
            $.each(this.filtered, function(key, info) {
                $('.'+info['hash']).show();
            });
        } else {
            $('.hashed').show();
        }
        
        console.table(this.filters);
        if (this.filters.length) {
            wo.each(this.filters).render('single-close');
        }
    }, // end search
    
    removeFilter: function(type)
    {
        if (type.match(/^slider/)) {
            $('#'+ type).slider().slider('refresh');
        } else {
            $('#filter-by-'+ type).val('').attr('checked', false);
        }
        
        this.search();
    }, // end removeFilter
    
    removeAllFilters: function()
    {
        $('.filter-input').val('').attr('checked', false);
        $('#applied-filters').html('');
        
        $("#slider-da").slider().slider('refresh');
        $("#slider-ar").slider().slider('refresh');

        this.search();
    }, // end removeAllFilters
    
    checkAll: function(ctx)
    {
        var isChecked = ctx.checked;
        console.log(isChecked);
        
        $('.hashed:visible').not('.advanced-info').find('.hashed-row-checkbox').attr('checked', isChecked).prop('checked', isChecked);
        $('.check-all').attr('checked', isChecked).prop('checked', isChecked);
    }, // end checkAll
    
};
$(document).ready(function() {
    Profiler.init();
}); 
