'use strict';

var App = 
{
    init: function() 
    {
        
    }, // end init
    
    modalEmails: function()
    {
        $('#bulk-type').val('emails');
        $('#bulk-urls-limit').text(500);
        wo.render('emails-options'); 
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    modalMoz: function()
    {
        $('#bulk-type').val('moz');
        $('#bulk-urls-limit').text(500);
        wo.render('moz-options');
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    modalBrokenLinks: function()
    {
        $('#bulk-type').val('not_found');
        $('#bulk-urls-limit').text(500);
        $('#bulk-options').html('');
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    modalBacklink: function()
    {
        $('#bulk-type').val('backlinks');
        $('#bulk-urls-limit').text(100);
        wo.render('backlinks-options');
        $('#create-bulk-modal').modal('show');
    }, // end 
    
    saveBulk: function()
    {
        var options = [];
        $('#bulk-options').find('input:checked').each(function() {
            options.push($(this).val());
        });
        var data = new FormData();
        data.append('type', $('#bulk-type').val());
        data.append('title', $('#bulk-title').val());
        data.append('urls', $('#bulk-urls').val());
        data.append('options', options);
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
                if (response.status) {
                    // FIXME: make me awesome
                    window.location.reload();
                    
                    $('#bulk-table tbody').prepend(wo.fetch('bulk-tr-template', response));
                    
                    $('#create-bulk-form')[0].reset();
                    $('#create-bulk-modal').modal('hide');
                } else {
                    toastr.error(response.error);
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
        var $modal = $('#modal-delete-project');
        
        $modal.find('.bulk-name').text($(ctx).closest('.bulk-tr').find('td:first').text());
        $modal.find('.ok-delete-button')
            .off('click')
            .on('click', function() {
                $(ctx).closest('.bulk-tr').remove();
                
                jQuery.ajax({
                    data: { id: id },
                    type: "POST",
                    url: '/me/remove-bulk',
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        $modal.modal('hide');
                    }
                });
            });
        $modal.modal('show');
    }, // end removeBulk
    
    downloadBacklinkXls: function(ctx)
    {
        var $modal = $('#modal-backlinks-type-xls');
        
        $modal.find('.all-links-type')
            .off('click')
            .on('click', function() {
                window.location = $(ctx).attr('href') + '?type=all';
                $modal.modal('hide');
            });
            
        $modal.find('.one-link-type')
            .off('click')
            .on('click', function() {
                window.location = $(ctx).attr('href') + '?type=one';
                $modal.modal('hide');
            });
            
        $modal.modal('show');
    }, // end downloadBacklinkXls
    
};

$(document).ready(function() {
    App.init();
});
