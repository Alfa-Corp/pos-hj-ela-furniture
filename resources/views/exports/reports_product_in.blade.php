<div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        Hj Ela Furniture
    </div>
    <div style="text-align: center">
        Alamat: Jl Raya Syeh Quro, Talagamulya, Kec. Talagasari, Karawang, Jawa Barat 41381
    </div>
    <div style="text-align: center">
        Telp: 085779714489
    </div>
</div>
<table style="width: 100%">
    <thead>
        <tr style="background-color: #e6e6e7;">
            <th scope="col">Date</th>
            <th scope="col">Supplier</th>
            <th scope="col">No Telp</th>
            <th scope="col">Alamat</th>
            <th scope="col">Harga / Qty</th>
            <th scope="col">Qty</th>
            <th scope="col">Harga</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products->purchase_transaction_details as $product)
        <tr>
            <td>{{ $product->created_at }}</td>
            <td>{{ $product->purchase_transaction->supplier_id ? $product->purchase_transaction->supplier->name_company : "Umum"  }}</td>
            <td>{{ $product->purchase_transaction->supplier_id ? $product->purchase_transaction->supplier->no_telp : ""  }}</td>
            <td>{{ $product->purchase_transaction->supplier_id ? $product->purchase_transaction->supplier->address : ""  }}</td>
            <td class="text-end">{{ formatPrice($product->price_per_qty) }}</td>
            <td>{{ $product->qty }}</td>
            <td class="text-end">{{ formatPrice($product->price) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
