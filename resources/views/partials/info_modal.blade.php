<!-- modal -->
  <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header text-center">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Notice</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-xs-12">
              {!! Settings::get('popup_content') !!}
              <div class="text-center form-row">
                <input id="submit" type="submit" name="submit" value="OK" class="btn" data-dismiss="modal" onclick="window.location = '/me/bulk';">
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- /modal -->