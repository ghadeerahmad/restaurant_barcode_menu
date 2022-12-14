<div class="container col-md-10">
    <form id="order_settings" method="POST">
        <div class="form-check form-switch">
            <input class="form-check-input" name="delivery" id="delivery" type="checkbox" {{$settings->is_delivery_enabled==1?'checked':''}}>
            <label class="form-check-label" for="flexSwitchCheckDefault">{{__('orders.is_delivery_enabled')}}</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="cash" id="cash" type="checkbox" {{$settings->is_cash_enabled==1?'checked':''}}>
            <label class="form-check-label" for="flexSwitchCheckDefault">{{__('orders.is_cash_enabled')}}</label>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" name="other_payment" id="other_payment" type="checkbox" {{$settings->other_payment_enabled==1?'checked':''}}>
            <label class="form-check-label" for="flexSwitchCheckDefault">{{__('orders.other_payment')}}</label>
        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button type="submit" class="btn btn-primary">{{__('chef.save')}}</button>
        </div>
    </form>
</div>