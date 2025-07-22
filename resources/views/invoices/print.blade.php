<!DOCTYPE html>
<html>
<head>
    <title>Laporan Invoice</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Laporan Invoice</h1>
    <p>Tanggal Cetak: {{ $date }}</p>
    <hr>
    <table>
        <thead>
            <tr>
                <th>ID Invoice</th>
                <th>Tanggal</th>
                <th>Pasien</th>
                <th>Kasir</th>
                <th>Cabang</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Total Tagihan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr>
                    <td>#{{ $invoice->id }}</td>
                    <td>{{ $invoice->created_at->format('d M Y') }}</td>
                    <td>{{ $invoice->patient->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->cashier->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->branch->name ?? 'N/A' }}</td>
                    
                    {{-- PERBAIKAN DI SINI: Membuat Keterangan Lebih Detail --}}
                    <td>
                        @if ($invoice->treatment_session_id)
                            Sesi Perawatan
                        @elseif ($invoice->sale && $invoice->sale->items->isNotEmpty())
                            @foreach($invoice->sale->items as $item)
                                {{ $item->product_name }} (x{{$item->quantity}})<br>
                            @endforeach
                        @else
                            {{ $invoice->payment_type }}
                        @endif
                    </td>

                    <td>{{ $invoice->payment_status }}</td>
                    <td>Rp {{ number_format($invoice->total_due, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html> 