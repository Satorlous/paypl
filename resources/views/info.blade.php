@extends('layouts.payplMain')
@section('content')
    <ul>
        <li><a href="/profile">Профиль</a>
            <ul>
                <li><a href="/profile/contact-services">Управление сервисами связи</a></li>
                <li><a href="/profile/pay-services">Управление платежными сервисами</a></li>
                <li><a href="/profile/goods">Товары</a></li>
                <li><a href="/profile/orders">Заказы</a></li>
                <li><a href="/profile/statistics">Статистика</a></li>
            </ul>
        </li>
        <li>
            <a href="/category/1">Категория</a>
            <ul>
                <li><a href="/category/1/subcategory/1">Подкатегория</a>
                    <ul>
                        <li><a href="/category/1/subcategory/1/goods/2">Товар</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>

    <ul class="alert-danger">
        <li><a href="/statuses">Статусы</a></li>
        <li><a href="/roles">Роли</a></li>
    </ul>
@endsection
