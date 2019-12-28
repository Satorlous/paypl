@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="card" class="col-12">
            <div class="card-body">
                    <li><a href="{{url('/profile')}}" class="stretched-link">Профиль</a>
                        <ul>
                            <li><a href="{{url('/profile/contact-services')}}">Управление сервисами связи</a></li>
                            <li><a href="{{url('/profile/pay-services')}}" class="stretched-link">Управление платежными сервисами</a></li>
                            <li><a href="{{url('/profile/goods')}}" class="stretched-link">Товары</a></li>
                            <li><a href="{{url('/profile/orders')}}" class="stretched-link">Заказы</a></li>
                            <li><a href="{{url('/profile/statistics')}}" class="stretched-link">Статистика</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('/category/1')}}" class="stretched-link">Категория</a>
                        <ul>
                            <li><a href="{{url('/category/1/subcategory/1')}}" class="stretched-link">Подкатегория</a>
                                <ul>
                                    <li><a href="{{url('/category/1/subcategory/1/goods/2')}}" class="stretched-link">Товар</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="alert-danger">
                    <li><a href="{{url('/statuses')}}" class="stretched-link">Статусы</a></li>
                    <li><a href="{{url('/roles')}}" class="stretched-link">Роли</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
