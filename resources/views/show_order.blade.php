@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Order Detail') }}</div>

                    @php
                        $total_price = 0;
                    @endphp
                    
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ session::get('success') }}
                            </div>
                         @endif
                         
                        <h5 class="card-title">Order ID {{ $order->id }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">By {{ $order->user->name }}</h6>
                        <hr>
                        <p>Your address: {{ $order->address ?? 'Not filled yet' }}</p>
                        <p>Your phone number: {{ $order->phone ?? 'Not filled yet' }}</p>
                        <hr>
                        @if ($order->is_paid == true)
                            <p class="card-text">PAID. Take a wait for your watch</p>
                            <p class="card-text">Check your delivery receipt number on our Instagram @ohwatchstore</p>
                        @else
                            <p class="card-text">UNPAID. Please finish your Payment</p>
                            <p class="card-text">Check your delivery receipt number later on our Instagram @ohwatchstore</p>
                        @endif
                        <hr>
                        @foreach ($order->transactions as $transaction)
                            <p>{{ $transaction->product->name }} - {{ $transaction->amount }} pcs</p>
                            @php
                                $total_price += $transaction->product->price * $transaction->amount;
                            @endphp
                        @endforeach
                        <hr>
                        <p>Total: IDR {{ number_format($total_price, 0, ',', '.') }}</p>
                        <p> PAYMENT VIA BCA 2832310604 MOHAMAD DEDRICK FINNEGAN</p>
                        <p> PAYMENT VIA BNI 1532931017 MOHAMAD DEDRICK FINNEGAN</p>
                        <hr>

                        @if ($order->is_paid == false && $order->payment_receipt == null && !Auth::user()->is_admin)
                            <form action="{{ route('submit_payment_receipt', $order) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label>Your address</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', $order->address) }}">
                                </div>
                                <div class="form-group">
                                    <label>Your phone number</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $order->phone) }}">
                                </div>
                                <div class="form-group">
                                    <label>Upload your payment receipt</label>
                                    <input type="file" name="payment_receipt" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Submit payment</button>
                            </form>

                            <form action="{{ route('delete_order', $order) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete this order?')">Cancel Order</button>
                            </form>
                        @elseif(Auth::user()->is_admin)
                            <!-- Formulir Hapus Order untuk Admin -->
                            <form action="{{ route('delete_order', $order) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
