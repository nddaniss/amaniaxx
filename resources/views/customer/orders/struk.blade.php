<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - {{ $trx->transaction_code }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 350px; margin: auto; padding: 20px; color: #333; }
        .text-center { text-align: center; }
        .divider { border-top: 1px dashed #888; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .footer { margin-top: 30px; font-size: 11px; color: #666; }
        .btn-back { display: block; margin-top: 20px; padding: 10px; border: 1px solid #8C6239; color: #8C6239; text-decoration: none; font-weight: bold; border-radius: 8px; }
        .discount-text { color: #16a34a; font-style: italic; }
    </style>
</head>
<body>
    <div class="text-center">
        <h2 style="margin: 0; color: #8C6239;">AMANIAX CAFE</h2>
        <p style="font-size: 12px; margin: 5px 0;">Jl. Vanilla Blvd No. 21, Bali</p>
        <p style="font-size: 11px; margin: 0;">Telp: 0361-555-0101</p>
    </div>

    <div class="divider"></div>

    <table style="margin-bottom: 10px;">
        <tr>
            <td>No: {{ $trx->transaction_code }}</td>
            <td align="right">{{ $trx->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Pelanggan: {{ Auth::user()->name }}</td>
            <td align="right">{{ $trx->created_at->format('H:i') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- Detail Pesanan --}}
    <table>
        @foreach($trx->details as $detail)
        <tr>
            <td style="padding-bottom: 5px;">{{ $detail->menu->name }}<br><small>{{ $detail->quantity }} x {{ number_format($detail->price) }}</small></td>
            <td align="right" valign="top">Rp {{ number_format($detail->quantity * $detail->price) }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    {{-- Perhitungan Diskon --}}
    <table>
        {{-- Jika ada diskon, tampilkan Subtotal dan nominal potongannya --}}
        @if($trx->discount_amount > 0)
        <tr>
            <td>Subtotal</td>
            <td align="right">Rp {{ number_format($trx->total_price) }}</td>
        </tr>
        <tr>
            <td class="discount-text">Potongan Voucher</td>
            <td align="right" class="discount-text">- Rp {{ number_format($trx->discount_amount) }}</td>
        </tr>
        @endif
        
        <tr style="font-weight: bold; font-size: 15px;">
            <td style="padding-top: 5px;">TOTAL BAYAR</td>
            <td align="right" style="color: #e75480; padding-top: 5px;">Rp {{ number_format($trx->final_price) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center footer">
        <p>*** LUNAS ***</p>
        <p>Terima Kasih atas Kunjungan Anda!<br>Sweet Moments at Amaniax Cafe</p>
        
        <a href="{{ route('customer.dashboard') }}" class="btn-back">
             Kembali ke Dashboard
        </a>
    </div>
</body>
</html>