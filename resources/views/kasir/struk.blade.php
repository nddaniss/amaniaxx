<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->transaction_code }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 76mm;
            margin: 0 auto;
            padding: 10px;
            background: #fff;
            color: #000;
        }
        .header { text-align: center; border-bottom: 1px dashed #000; padding-bottom: 10px; margin-bottom: 10px; }
        .title { font-size: 1.1rem; font-weight: bold; text-transform: uppercase; }
        .info { font-size: 0.8rem; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 0.8rem; }
        th { text-align: left; border-bottom: 1px solid #000; }
        td { padding: 4px 0; vertical-align: top; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row td { border-top: 1px dashed #000; font-weight: bold; padding-top: 8px; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.7rem; border-top: 1px dashed #000; padding-top: 10px; }
        
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <div class="title">AMANIAX CAFE</div>
        <div class="info">Jl. Vanilla Blvd No. 21, Bali</div>
        <div class="info">Telp: 0361-555-0101</div>
    </div>

    <div class="info">
        No: {{ $transaction->transaction_code }}<br>
        Tgl: {{ $transaction->created_at->format('d/m/Y H:i') }}<br>
        Kasir: {{ Auth::user()->name }}<br>
        Pelanggan: {{ $transaction->user->name ?? 'Guest' }}
    </div>
    <br>

    <table>
        <thead>
            <tr>
                <th style="width: 45%;">Item</th>
                <th class="text-center" style="width: 15%;">Qty</th>
                <th class="text-right" style="width: 40%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $detail)
            <tr>
                <td>{{ $detail->menu->name }}</td>
                <td class="text-center">{{ $detail->quantity }}</td>
                <td class="text-right">{{ number_format($detail->price_per_item * $detail->quantity) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            {{-- Bagian Diskon Sinkron --}}
            @if($transaction->discount_amount > 0)
            <tr>
                <td colspan="2" style="padding-top:10px;">Subtotal</td>
                <td class="text-right" style="padding-top:10px;">{{ number_format($transaction->total_price) }}</td>
            </tr>
            <tr>
                <td colspan="2">Diskon Voucher</td>
                <td class="text-right">-{{ number_format($transaction->discount_amount) }}</td>
            </tr>
            @endif

            <tr class="total-row">
                <td colspan="2">TOTAL AKHIR</td>
                <td class="text-right">Rp {{ number_format($transaction->final_price) }}</td>
            </tr>

            {{-- Detail Pembayaran Tunai --}}
            <tr>
                <td colspan="2" style="padding-top:5px;">Tunai</td>
                <td class="text-right" style="padding-top:5px;">{{ number_format($transaction->cash_received ?? 0) }}</td>
            </tr>
            <tr>
                <td colspan="2">Kembalian</td>
                <td class="text-right">{{ number_format($transaction->cash_change ?? 0) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top:5px;">STATUS</td>
                <td class="text-right" style="padding-top:5px; font-weight:bold;">LUNAS</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Terima Kasih atas Kunjungan Anda!</p>
        <p>Amaniax Cafe - Sweet Moments.</p>
        <p style="margin-top:5px;">Follow IG: @amaniax.cafe</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 30px; border-top: 2px solid #eee; padding-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer; background: #333; color: white; border: none; border-radius: 5px;">
            Print Ulang
        </button>
        <br><br>
        <a href="{{ route('kasir.dashboard') }}" style="text-decoration: none; color: #8C6239; font-weight: bold;">
            &larr; Kembali ke Dashboard
        </a>
    </div>

</body>
</html>