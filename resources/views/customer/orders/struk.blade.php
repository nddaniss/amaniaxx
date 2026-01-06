<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    {{-- Pastikan variable di sini $transaction (sesuai Controller) --}}
    <title>Struk Pembayaran - {{ $transaction->transaction_code }}</title>
    <style>
        body { font-family: 'Courier New', Courier, monospace; width: 350px; margin: auto; padding: 20px; color: #333; }
        .text-center { text-align: center; }
        .divider { border-top: 1px dashed #888; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .footer { margin-top: 30px; font-size: 11px; color: #666; }
        .btn-back { display: block; margin-top: 20px; padding: 10px; border: 1px solid #8C6239; color: #8C6239; text-decoration: none; font-weight: bold; border-radius: 8px; text-align: center;}
        .discount-text { color: #16a34a; font-style: italic; }
        .bold { font-weight: bold; }
        .status-unpaid { border: 2px dashed red; color: red; padding: 5px; text-align: center; font-weight: bold; margin: 10px 0; }
        .status-paid { border: 2px solid #8C6239; color: #8C6239; padding: 5px; text-align: center; font-weight: bold; margin: 10px 0; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2 style="margin: 0; color: #8C6239;">AMANIAX CAFE</h2>
        <p style="font-size: 12px; margin: 5px 0;">Jl. Vanilla Blvd No. 21, Bali</p>
        <p style="font-size: 11px; margin: 0;">Telp: 0361-555-0101</p>
    </div>

    <div class="divider"></div>

    <table style="margin-bottom: 10px;">
        <tr>
            <td>No: {{ $transaction->transaction_code }}</td>
            <td align="right">{{ $transaction->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Pelanggan: {{ $transaction->user->name ?? Auth::user()->name }}</td>
            <td align="right">{{ $transaction->created_at->format('H:i') }}</td>
        </tr>
    </table>

    {{-- STATUS PEMBAYARAN --}}
    @if($transaction->status == 'paid')
        <div class="status-paid">LUNAS</div>
    @else
        <div class="status-unpaid">BELUM BAYAR</div>
    @endif

    <div class="divider"></div>

    {{-- Detail Pesanan --}}
    <table>
        @foreach($transaction->details as $detail)
        <tr>
            <td style="padding-bottom: 5px;">
                {{ $detail->menu->name }}<br>
                {{-- PERBAIKAN: Gunakan $detail->menu->price agar harga muncul --}}
                <small>{{ $detail->quantity }} x {{ number_format($detail->menu->price, 0, ',', '.') }}</small>
            </td>
            {{-- PERBAIKAN: Kalikan quantity dengan menu->price --}}
            <td align="right" valign="top">Rp {{ number_format($detail->quantity * $detail->menu->price, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    {{-- Perhitungan Pembayaran --}}
    <table>
        <tr>
            <td>Subtotal</td>
            <td align="right">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
        </tr>
        
        {{-- Jika ada diskon voucher --}}
        @if($transaction->discount_amount > 0)
        <tr>
            <td class="discount-text">Potongan Voucher</td>
            <td align="right" class="discount-text">- Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
        </tr>
        @endif
        
        <tr style="font-weight: bold; font-size: 15px;">
            <td style="padding-top: 5px;">TOTAL TAGIHAN</td>
            <td align="right" style="color: #e75480; padding-top: 5px;">Rp {{ number_format($transaction->final_price, 0, ',', '.') }}</td>
        </tr>

        {{-- Tampilkan detail pembayaran CUMA kalau sudah dibayar --}}
        @if($transaction->status == 'paid')
            <tr>
                <td style="padding-top: 10px;">Tunai</td>
                <td align="right" style="padding-top: 10px;">Rp {{ number_format($transaction->cash_received, 0, ',', '.') }}</td>
            </tr>
            <tr class="bold">
                <td>Kembalian</td>
                <td align="right">Rp {{ number_format($transaction->cash_change, 0, ',', '.') }}</td>
            </tr>
        @else
            <tr>
                <td colspan="2" style="padding-top:10px; text-align:center; font-size:11px; font-style:italic;">
                    Silakan lakukan pembayaran di kasir.
                </td>
            </tr>
        @endif
    </table>

    <div class="divider"></div>

    <div class="text-center footer">
        <p>Voucher hanya berlaku 1x pemakaian per akun.<br>Terima Kasih atas Kunjungan Anda!</p>
        <p class="bold" style="color: #8C6239;">Sweet Moments at Amaniax Cafe</p>
        
        <a href="{{ route('customer.dashboard') }}" class="btn-back">
             Kembali ke Dashboard
        </a>
    </div>
</body>
</html>