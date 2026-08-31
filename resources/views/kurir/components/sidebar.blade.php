<aside class="wrapper">
    <input type="checkbox" id="btn-sidebar">
    <label for="btn-sidebar" class="menu-btn">
        <i class="bi bi-list"></i>
    </label>

    <nav id="sidebar">
        <div class="title">Side Menu</div>
        <ul class="list-items">
            <li>
                <a href="{{ route('kurir.index') }}"><i class="bi bi-door-closed-fill"></i>Home</a>
            </li>
            <li>
                <a href="{{ route('customer.index') }}"><i class="bi bi-door-closed-fill"></i>Login Customer</a>
            </li>
             <li>
                <a href="{{ route('wirausaha.index') }}"><i class="bi bi-door-closed-fill"></i>Login Wirausaha</a>
            </li>
        </ul>
    </nav>
</aside>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .wrapper {
        height: 100%;
        width: 330px;
        position: relative;
        z-index: 1;
    }

    input[type="checkbox"] {
        display: none;
    }

    .wrapper .menu-btn {
        position: absolute;
        top: 10px;
        left: 20px;
        height: 45px;
        width: 45px;
        z-index: 2;
        color: #f1f1f1;
        background: #50577A;
        border: 1px solid #333;
        text-align: center;
        line-height: 45px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 40px;
        transition: all 0.3s ease;
    }

    #btn-sidebar:checked~.menu-btn {
        left: 247px;
    }

    #btn-sidebar:checked~.menu-btn i:before {
        position: absolute;
        top: 7px;
        left: 7px;
        font-size: 30px;
        content: "\F159";
    }

    .wrapper #sidebar {
        position: fixed;
        height: 100%;
        width: 270px;
        background: #474E68;
        overflow: hidden;
        left: -270px;
        transition: all 0.3s ease;
    }

    #btn-sidebar:checked~#sidebar {
        left: 0;
    }

    #sidebar .title {
        color: #f2f2f2;
        font-size: 25px;
        font-weight: 600;
        line-height: 65px;
        background: #404258;
        text-align: center;
    }

    #sidebar .list-items {
        position: relative;
        background: #474E68;
        height: 100%;
        list-style: none;
    }

    #sidebar .list-items li {
        line-height: 50px;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        border-bottom: 1px solid #333;
        background: #474E68;
    }

    #sidebar .list-items li:hover,
    #sidebar .list-items a:hover {
        background: #FF004D;
        border-top: 1px solid transparent;
        border-bottom: 1px solid transparent;
    }

    #sidebar .list-items li a {
        padding-left: 50px;
        color: #f1f1f1;
        background: #474E68;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        height: 100%;
        width: 100%;
        display: block;
    }

    #sidebar .list-items li a i {
        margin-right: 20px;
    }
</style>
