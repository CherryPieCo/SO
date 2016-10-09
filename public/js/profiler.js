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
        
        if (filtered.length) {
            $('.hashed').hide();
            $.each(filtered, function(key, info) {
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
        $('#filter-by-'+ type).val('');
        this.search();
    }, // end removeFilter
    
    removeAllFilters: function()
    {
        $('.filter-input').val('');
        $('#applied-filters').html('');
        this.search();
    }, // end removeAllFilters
    
};
$(document).ready(function() {
    Profiler.init();
}); 
