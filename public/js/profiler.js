'use strict';
/*
Array.range = function(n) {
    // Array.range(5) --> [0,1,2,3,4]
    return Array.apply(null,Array(n)).map((x,i) => i);
};

Object.defineProperty(Array.prototype, 'chunk', {
    value: function(n) {
        return Array.range(Math.ceil(this.length/n)).map((x,i) => this.slice(i*n,i*n+n));
    }
});
*/
function chunk(arr, len) {

  var chunks = [],
      i = 0,
      n = arr.length;

  while (i < n) {
    chunks.push(arr.slice(i, i += len));
  }

  return chunks;
}
Array.prototype.chunk = function ( n ) {
    if ( !this.length ) {
        return [];
    }
    return [ this.slice( 0, n ) ].concat( this.slice(n).chunk(n) );
};

var Profiler = 
{
    _id: '',
    per_page: 25,
    sites: [],
    filters: [],
    filtered: [],
    
    init: function()
    {
        $('[data-toggle="tooltip"]').tooltip();
        
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
        
        $('.filter-input[type=checkbox], select.filter-input').on('change', function() {
            Profiler.search();
        });
        
        $('#filter-by-title, #filter-by-url').on('keyup', function (e) {
            Profiler.search();
        });
        
        var chunks = this.sites.chunk(this.per_page);
        this.renderPagination(chunks);
        this.renderPerPageInfo(chunks, 0);
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
        
        var advertisePage = $('#filter-by-advertise-type').val();
        if (advertisePage) {
        console.log(advertisePage);
            this.filters.push({
                title: 'Advertise opportunities: '+ advertisePage,
                type: 'advertise-type'
            });
            for (var i = 0; i < this.sites.length; i++) { 
                var info = this.sites[i];
                if (~$.inArray(advertisePage, info.pages)) {
                    console.log(info);
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
        this.renderFilteredChunk(0, true, false);
        return;
        
        /*
        if (this.filters.length) {
            this.renderFilteredChunk(0, true);
        } else {
            $('.hashed').show();
            var chunks = this.sites.chunk(this.per_page);
            this.renderPagination(chunks);
        }
        */
    }, // end search
    
    renderFilteredChunk: function(chunkIndex, isRenderNewPagination, useAllIfEmptyResult)
    {
        if (!this.filters.length) {
            this.filtered = this.filtered.length ? this.filtered : this.sites;
        }
        
        $('.hashed').hide();
        var chunks = this.filtered.chunk(this.per_page);
        console.log(chunks);
        chunks = chunks.length ? chunks : [[]];
        $.each(chunks[chunkIndex], function(key, info) {
            $('.'+info['hash']).show();
        });
        
        //if (this.filters.length) {
            wo.each(this.filters).render('single-close');
        //}
        
        if (isRenderNewPagination) {
            this.renderPagination(chunks);
        }
        this.renderPerPageInfo(chunks, chunkIndex);
    }, // end renderFilteredChunk
    
    renderPagination: function(chunks)
    {
        var woData = [];
        $.each(chunks, function(key, info) {
            info.index = key + 1;
            info.class = !key ? 'active' : '';
            woData.push(info);
        });
        wo.each(woData).render('pagination');
    }, // end renderPagination
    
    renderPerPageInfo: function(chunks, chunkIndex)
    {
        var from = 1;
        var to = 0;
        $.each(chunks, function(index, chunk) {
            if (index <= chunkIndex) {
                to += chunk.length;
            }
            if (index == chunkIndex) {
                from += to - chunk.length;
            }
        });
        
        var data = {
            from: from,
            to: to,
            total: this.filtered.length ? this.filtered.length : this.sites.length,
        };
        if (!data.to || !data.total) {
            data = {
                from: ' 0 ',
                to: ' 0 ',
                total: ' 0 ',
            };
        }
        
        wo.render('displayed-items-template', data);
    }, // end renderPerPageInfo
    
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
        
        $('.hashed:visible').not('.advanced-info').find('.hashed-row-checkbox').attr('checked', isChecked).prop('checked', isChecked);
        $('.check-all').attr('checked', isChecked).prop('checked', isChecked);
    }, // end checkAll
    
    changePage: function(ctx, page)
    {
        $(ctx).closest('ul').find('li').removeClass('active');
        $(ctx).closest('li').addClass('active');
        
        var index = page - 1;
        Profiler.renderFilteredChunk(index, false, true);
        
        $('html, body').animate({
            scrollTop: $('.content-table').offset().top
        }, 400);
        
        $('.hashed-row-checkbox, .check-all').attr('checked', false);
    }, // end changePage
    
    changePerPage: function(ctx)
    {
        this.per_page = $(ctx).val();
        this.search();
    }, // end changePerPage
    
    remove: function()
    {
        var checked = $('.hashed-row-checkbox:visible:checked');
        if (!checked.length) {
            $('#modal-no-checkboxes').modal('show');
            return;
        }
        
        var hashes = [];
        $('.hashed-row-checkbox:visible:checked').each(function(item) {
            hashes.push($(this).val());
        });
        
        this.deleteByHashes(hashes);
        
        var newSites = [];
        $.each(this.sites, function(key, site) {
            if (!~$.inArray(site.hash, hashes)) {
                newSites.push(site);
            }
        });
        this.sites = newSites;
        this.search();
    }, // end remove
    
    removeAll: function()
    {
        var hashes = [];
        $('.hashed-row-checkbox:visible').each(function(item) {
            hashes.push($(this).val());
        });
        
        this.deleteByHashes(hashes);
        
        var newSites = [];
        $.each(this.sites, function(key, site) {
            if (!~$.inArray(site.hash, hashes)) {
                newSites.push(site);
            }
        });
        this.sites = newSites;
        this.search();
    }, // end removeAll
    
    deleteByHashes: function(hashes)
    {
        jQuery.ajax({
            data: { 
                hashes: hashes 
            },
            type: "POST",
            url: '/me/bulk/'+ this._id +'/profiler/remove-sites',
            cache: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                if (response.status) {
                    toastr.success('Successfully deleted');
                } else {
                    toastr.error(response.error);
                }
            }
        });
    }, // end deleteByHashes
    
};
$(document).ready(function() {
    Profiler.init();
}); 
