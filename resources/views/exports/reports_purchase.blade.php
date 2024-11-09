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
            <th scope="col">Invoice</th>
            <th scope="col">Admin</th>
            <th scope="col">Supplier</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($purchases as $purchase)
        <tr>
            <td>{{ $purchase->created_at }}</td>
            <td>{{ $purchase->invoice }}</td>
            <td>{{ $purchase->admin->name ?? '' }}</td>
            <td>{{ $purchase->supplier->name_company ?? 'Umum' }}</td>
            <td class="text-end">{{ formatPrice($purchase->grand_total) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-end fw-bold" style="background-color: #e6e6e7;">TOTAL</td>
            <td class="text-end fw-bold" style="background-color: #e6e6e7;">{{ formatPrice($total) }}</td>
        </tr>
    </tbody>
</table>
