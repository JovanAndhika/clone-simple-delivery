<aside class="wrapper">
    <input type="checkbox" id="btn-sidebar">
    <label for="btn-sidebar" class="menu-btn">
        <i class="bi bi-list"></i>
    </label>

    <nav id="sidebar">
        <div class="title">Side Menu</div>
        <ul class="list-items">
            <li>
                <a href="{{ route('wirausaha.index') }}"><i class="bi bi-house-door-fill"></i>Home</a>
            </li>
            <li>
                <a href="{{ route('wirausaha.barang') }}"><i class="bi bi-bag"></i>Product</a>
            </li>
            <li>
                <a href="{{ route('wirausaha.offer') }}"><i class="bi bi-box"></i>Offer Barang</a>
            </li>
            <li>
                <a href="{{ route('kurir.index') }}"><i class="bi bi-door-closed-fill"></i>Login Kurir</a>
            </li>
            <li>
                <a href="{{ route('customer.index') }}"><i class="bi bi-door-closed-fill"></i>Login Customer</a>
            </li>
        </ul>
    </nav>
</aside>
