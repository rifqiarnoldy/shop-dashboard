<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    <div class="blog_right_sidebar">
        <aside class="single_sidebar_widget post_category_widget">
            <h4 class="widget_title">Sidebar</h4>
            <ul class="list cat-list">
                <li class="@if($active == 'dashboard') active @endif">
                    <a href="/dashboard" class="d-flex justify-content-between">
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="@if($active == 'category-product') active @endif">
                    <a href="/dashboard/category-product" class="d-flex justify-content-between">
                        <p>Category Product</p>
                    </a>
                </li>
                <li class="@if($active == 'product') active @endif">
                    <a href="/dashboard/product" class="d-flex justify-content-between">
                        <p>Product</p>
                    </a>
                </li>
            </ul>
            <div class="br"></div>
            <button type="button" class="genric-btn danger rounded"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</button>
            <form action="/logout" method="post" id="logout-form">
                @csrf
            </form>
        </aside>
    </div>
</div>