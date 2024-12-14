@if($cartItems->isEmpty())
<p>Your cart is empty.</p>
@else
<ul class="woocommerce-mini-cart cart_list product_list_widget" id="side-cart">
    @foreach($cartItems as $item)
    <li class="woocommerce-mini-cart-item mini_cart_item">
        <a href="#" class="remove remove_from_cart_button" data-id="{{ $item->id }}"><i class="far fa-times"></i></a>
        <a href="#"><img src="{{url('uploads/tournament/'.$item->tournament->image)}}" alt="Cart Image">{{ $item->tournament->title }}</a>
        <span class="quantity">{{ $item->quantity }} ×
            <span class="woocommerce-Price-amount amount">
                <span class="woocommerce-Price-currencySymbol">$</span>{{ $item->tournament->price }}</span>
        </span>
    </li>
    @endforeach
</ul>

@endif