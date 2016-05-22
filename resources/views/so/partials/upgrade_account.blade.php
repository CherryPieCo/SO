
@if (!Sentinel::getUser()->isProType())

<div class="row">
<div class="col-md-10 col-md-offset-1">
  <div class="panel panel-default panel-custom plan-selector">
    <div class="panel-body">
      <h4>Upgrade my account</h4>
      <p><strong>Select your new plan</strong></p>
      <div class="row">
        <div class="col-xs-8">
          <label>
            <input type="radio" name="select-plan" value="">
            <span>
              <strong class="text-primary">Trial Account</strong>
              <p><strong>All Opportunities</strong> </p>
            </span>
          </label>
        </div>
        <div class="col-xs-4">
          <div class="col-sm-6 text-right"><h5>14 Day Free</h5></div>
          <div class="col-sm-6 text-right">
            <img src="https://www.paypalobjects.com/en_US/i/btn/x-click-but6.gif" alt="PayPal button">
          </div>
        </div>  
      </div>
      <div class="row">
        <div class="col-xs-8">
          <label>
            <input type="radio" name="select-plan" value="">
            <span>
              <strong class="text-primary">Blogger</strong>
              <p><strong>E-mail Finder</strong> - 3000 requests/ month</p>
            </span>
          </label>
        </div>
        <div class="col-xs-4">
          <div class="col-sm-6 text-right"><h5>$31.00</h5></div>
          <div class="col-sm-6 text-right">
              <form action="https://www.2checkout.com/checkout/purchase" method="post">
                  <input type="hidden" name="sid" value="102893557">
                  <input type="hidden" name="quantity" value="1">
                  <input type="hidden" name="product_id" value="1">
                  <input type="hidden" name="id_user" value="{{ Sentinel::getUser()->id }}" />
                  <input name="submit" type="submit" value="Buy from 2CO" >
              </form>
          </div>
        </div>  
      </div>
      <div class="row">
        <div class="col-xs-8">
          <label>
            <input type="radio" name="select-plan" value="">
            <span>
              <strong class="text-primary">Pro</strong>
              <p><strong>All opportunities:</strong> E-mail Finder, 404 Checker, Backlink Checker - Unlim requests / month</p>
            </span>
          </label>
        </div>
        <div class="col-xs-4">
          <div class="col-sm-6 text-right"><h5>$47.00</h5></div>
          <div class="col-sm-6 text-right">
            <img src="https://www.paypalobjects.com/en_US/i/btn/x-click-but6.gif" alt="PayPal button">
          </div>
        </div>  
      </div>
    </div>
  </div>
</div>
</div>

@endif

