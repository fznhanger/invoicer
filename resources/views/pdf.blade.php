@extends('template')

@section('css')
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    h1 {
        font-size: 36px;
        text-align: center;
    }
    hr {
        border: 1px solid black;
        margin: 20px 0;
    }
    h4 {
        font-size: 18px;
        margin: 10px 0;
    }
    tr:nth-child(even) {
        background-color: whitesmoke;
    }
    .navbar {
        display: none;
    }
    .container-fluid {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .col {
        flex: 1;
        min-width: 300px;
    }
    .col:nth-child(2) {
        text-align: right;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .table td, .table th {
        border: 1px solid black;
        padding: 10px;
        font-size: 18px;
    }
    .table th {
        text-align: center;
    }
</style>
@endsection

@section('content')
    <div class="col">
        <h1>Invoice</h1>
        <hr>
        <div class="row">
            <div class="col">
                <h4><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</h4>
                <h4><strong>Address:</strong>  {{ $invoice->address }}</h4>
                <h4><strong>Date:</strong>  {{ $invoice->date }}</h4>
            </div>
        </div>
        <table class="table">
            <thead style="background-color: red; color:white">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
