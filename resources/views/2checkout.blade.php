


<form action="https://www.2checkout.com/checkout/purchase" method="post">
  <input type="hidden" name="sid" value="102893557">
  <input type="hidden" name="quantity" value="1">
  <input type="hidden" name="product_id" value="1">
  <input type="hidden" name="id_user" value="{{ Sentinel::getUser()->id }}" />
  <input name="submit" type="submit" value="Buy from 2CO" >
</form>

