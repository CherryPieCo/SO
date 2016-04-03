<!-- modal -->
  <div class="modal fade" id="create-bulk-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Create new campaign</h4>
        </div>
        <div class="modal-body">
            
          <form id="create-bulk-form">
          <input type="hidden" name="type" value="" id="bulk-type">
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label><small>Project name</small></label>
                  <input name="title" id="bulk-title" class="form-control" placeholder="Project name" type="text">
                </div>  
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label><small>Import from file (txt)</small></label>
                  <input name="file" id="bulk-file" class="btn-block text-left" style="text-align: left !important;" placeholder="Add file" type="file" accept="text/plain">
                </div>  
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="form-group">
                  <label><small>Please, input urls: *</small></label>
                  <textarea name="urls" id="bulk-urls" class="form-control" placeholder="Example: http://site1.com" rows="5"></textarea>
                  <span class="help-block"><small>* - not more 1000 sites per one time</small></span>
                </div>  
              </div>
            </div>
          </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button onclick="App.saveBulk();" type="button" class="btn btn-primary">Start</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- /modal -->