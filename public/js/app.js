'use strict';

var App = 
{
    init: function() 
    {
        
    }, // end init
    
    modalEmails: function()
    {
        $('#bulk-type').val('emails');
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    modalBrokenLinks: function()
    {
        $('#bulk-type').val('not_found');
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    modalBacklink: function()
    {
        $('#bulk-type').val('backlinks');
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    saveBulk: function()
    {
        var data = new FormData();
        data.append('type', $('#bulk-type').val());
        data.append('title', $('#bulk-title').val());
        data.append('urls', $('#bulk-urls').val());
        if ($('#bulk-file')[0].files[0]) {
            data.append("file", $('#bulk-file')[0].files[0]);
        }
        
        
        jQuery.ajax({
            data: data,
            type: "POST",
            url: '/me/create-bulk',
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                
                if (response.status) {
                    $('#create-bulk-form')[0].reset();
                    $('#create-bulk-modal').modal('hide');
                } else {
                    alert('fcuk');
                }
            }
        });
    }, // end saveBulk
    
    setBulksPerPage: function(perPage)
    {
        jQuery.ajax({
            data: { per_page: perPage },
            type: "POST",
            url: '/me/set-bulks-per-page-count',
            cache: false,
            dataType: 'json',
            success: function(response) {
                window.location.reload();
            }
        });
    }, // end setBulksPerPage
    
    removeBulk: function(ctx, id)
    {
        if (!confirm('R U SURE?')) {
            return;
        }
        
        $(ctx).closest('.bulk-tr').remove();
        
        jQuery.ajax({
            data: { id: id },
            type: "POST",
            url: '/me/remove-bulk',
            cache: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
            }
        });
    }, // end removeBulk
    
};

$(document).ready(function() {
    App.init();
});
