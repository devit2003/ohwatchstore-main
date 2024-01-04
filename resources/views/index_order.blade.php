@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Orders') }}</div>

                <div class="card-body m-auto">
                    @foreach ($orders as $order)
                    <div class="card mb-2" style="width: 30rem;">
                        <div class="card-body">
                            <a href="{{ route('show_order', $order) }}">
                                <h5 class="card-title">Order ID {{ $order->id }}</h5>
                            </a>
                            <h6 class="card-subtitle mb-2 text-muted">By {{ $order->user->name }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $order->phone }}</h6>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $order->address }}</h6>

                            @if ($order->is_paid == true)
                            <p class="card-text">PAID. Take a wait for your watch</p>
                            <p class="card-text">Check your delivery receipt number on our Instagram @ohwatchstore</p>
                            @else
                            <p class="card-text">UNPAID. Please finish your payment</p>
                            <p class="card-text">Check your delivery receipt number later on our Instagram @ohwatchstore</p>

                            @if ($order->payment_receipt)
                            <div class="d-flex flew-row justify-content-around">
                                <a href="{{ url('storage/' . $order->payment_receipt) }}" class="btn btn-primary">Show payment receipt</a>
                            </div>
                            <br>

                            @if (Auth::user()->is_admin)
                            <div>
                                <form action="{{ route('confirm_payment', $order) }}" method="post">
                                    @csrf
                                    <button class="btn btn-success" type="submit">Confirm</button>
                                </form>
                            </div>
                            @endif
                            @endif
                            @endif

                            <br>

                            @if (Auth::user()->is_admin)
                            <form action="{{ route('delete_order', $order) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</button>
                            </form>
                            @elseif ($order->is_paid == false && $order->payment_receipt == null)
                            <!-- Formulir Hapus Order untuk User yang belum membayar -->
                            <form action="{{ route('delete_order', $order) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this order?')">Cancel Order</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
