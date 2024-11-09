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
            <th scope="col">Nama</th>
            <th scope="col">No Telp</th>
            <th scope="col">Alamat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->no_telp }}</td>
            <td>{{ $customer->address }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
