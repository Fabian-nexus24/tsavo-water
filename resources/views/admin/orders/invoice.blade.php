@php
    $logoPath = public_path('images/logo.png');
    $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    $logoSrc  = $logoData ? 'data:image/png;base64,' . $logoData : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice #{{ $order->order_number }}</title>
<style>
    /* A4 portrait at 96dpi = 794px wide.
       We use 40px padding each side → 714px usable content width.
       All widths below are in explicit px to prevent DomPDF overflow. */

    * { margin:0; padding:0; box-sizing:border-box; }

    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 11px;
        color: #333;
        line-height: 1.5;
        background: #fff;
    }

    .wrap { width: 714px; margin: 0 auto; padding: 24px 0; }

    /* Logo */
    .logo-center { text-align: center; margin-bottom: 4px; }
    .logo-center img { width: 200px; height: auto; }
    .logo-fallback { font-size: 22px; font-weight: bold; color: #0d6efd; letter-spacing: 2px; }
    .contact { text-align: center; font-size: 10px; color: #888; margin-bottom: 12px; }

    /* Rules */
    .rule-blue  { width: 714px; border: none; border-top: 2px solid #0d6efd; margin: 10px 0; }
    .rule-light { width: 714px; border: none; border-top: 1px solid #dde3ea; margin: 10px 0; }

    /* Meta row */
    .meta { width: 714px; border-collapse: collapse; margin-bottom: 12px; }
    .meta td { vertical-align: top; }
    .meta-title { font-size: 20px; font-weight: bold; color: #0d6efd; letter-spacing: 3px; }
    .meta-right { text-align: right; font-size: 11px; line-height: 1.8; width: 320px; }
    .badge { display:inline-block; padding:1px 8px; border-radius:10px; font-size:9px; font-weight:bold; text-transform:uppercase; }
    .badge-paid    { background:#d1fae5; color:#065f46; }
    .badge-pending { background:#fef9c3; color:#92400e; }

    /* Address boxes */
    .addr { width: 714px; border-collapse: collapse; margin-bottom: 12px; }
    .addr td { width: 347px; vertical-align: top; }
    .addr td:first-child { padding-right: 10px; }
    .addr td:last-child  { padding-left: 10px; }
    .addr-box { border: 1px solid #dde3ea; border-radius: 4px; padding: 8px 12px; background: #f8fafc; }
    .addr-lbl { font-size: 9px; font-weight: bold; text-transform: uppercase; color: #0d6efd; letter-spacing:1px; margin-bottom: 4px; }

    /* Items table — fixed layout with exact px column widths totalling 714px */
    .items { width: 714px; border-collapse: collapse; table-layout: fixed; margin-bottom: 8px; }
    .items col.c1 { width: 28px; }
    .items col.c2 { width: 280px; }
    .items col.c3 { width: 56px; }
    .items col.c4 { width: 175px; }
    .items col.c5 { width: 175px; }
    .items th {
        background: #0d6efd; color: #fff;
        padding: 7px 8px; font-size: 9px;
        text-transform: uppercase; letter-spacing: 0.5px;
        text-align: left; overflow: hidden;
    }
    .items th.r, .items td.r { text-align: right; }
    .items td {
        padding: 7px 8px;
        border-bottom: 1px solid #eef0f3;
        font-size: 11px;
        overflow: hidden;
        word-wrap: break-word;
    }
    .items tr:nth-child(even) td { background: #f8fafc; }

    /* Totals */
    .totals { width: 714px; border-collapse: collapse; margin-top: 4px; }
    .totals td.spacer { width: 390px; }
    .totals td.right-col { width: 324px; vertical-align: top; }
    .totals-inner { width: 324px; border-collapse: collapse; }
    .totals-inner td { padding: 3px 8px; font-size: 11px; color: #555; }
    .totals-inner td.r { text-align: right; }
    .totals-inner tr.grand td {
        font-size: 13px; font-weight: bold; color: #0d6efd;
        border-top: 2px solid #0d6efd; padding-top: 6px;
    }

    .footer {
        width: 714px; text-align: center;
        color: #bbb; font-size: 9px;
        border-top: 1px solid #e5e7eb;
        padding-top: 8px; margin-top: 16px;
    }
</style>
</head>
<body>
<div class="wrap">

    {{-- LOGO --}}
    <div class="logo-center">
        @if($logoSrc)
            <img src="{{ $logoSrc }}" alt="Tsavo Water">
        @else
            <div class="logo-fallback">TSAVO WATER</div>
        @endif
    </div>
    <div class="contact">
        Nairobi, Kenya &nbsp;&bull;&nbsp; support@tsavowater.com &nbsp;&bull;&nbsp; +254 700 000 000
    </div>

    <hr class="rule-blue">

    {{-- META --}}
    <table class="meta">
        <tr>
            <td><span class="meta-title">INVOICE</span></td>
            <td class="meta-right">
                <strong>Invoice No:</strong>&nbsp; #{{ $order->order_number }}<br>
                <strong>Date:</strong>&nbsp; {{ $order->created_at->format('d M Y') }}<br>
                <strong>Payment:</strong>&nbsp; {{ ucfirst($order->payment_method) }}&nbsp;
                <span class="badge {{ $order->payment_status=='paid' ? 'badge-paid' : 'badge-pending' }}">
                    {{ ucfirst($order->payment_status) }}
                </span>
            </td>
        </tr>
    </table>

    <hr class="rule-light">

    {{-- ADDRESSES --}}
    <table class="addr">
        <tr>
            <td>
                <div class="addr-box">
                    <div class="addr-lbl">Bill To</div>
                    <strong>{{ $order->user->name }}</strong><br>
                    {{ $order->user->email }}<br>
                    {{ $order->user->phone ?? '—' }}
                </div>
            </td>
            <td>
                <div class="addr-box">
                    <div class="addr-lbl">Deliver To</div>
                    <strong>{{ $order->delivery_city }}</strong><br>
                    {{ $order->delivery_address }}<br>
                    Zone: {{ $order->zone->name ?? 'Standard' }}
                </div>
            </td>
        </tr>
    </table>

    <hr class="rule-light">

    {{-- ITEMS --}}
    <table class="items">
        <col class="c1"><col class="c2"><col class="c3"><col class="c4"><col class="c5">
        <thead>
            <tr>
                <th>#</th>
                <th>Description</th>
                <th class="r">Qty</th>
                <th class="r">Unit Price</th>
                <th class="r">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->product_name }}</td>
                <td class="r">{{ $item->quantity }}</td>
                <td class="r">KES {{ number_format($item->unit_price, 2) }}</td>
                <td class="r">KES {{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTALS --}}
    <table class="totals">
        <tr>
            <td class="spacer"></td>
            <td class="right-col">
                <table class="totals-inner">
                    @if(isset($order->delivery_fee) && $order->delivery_fee > 0)
                    <tr>
                        <td>Subtotal</td>
                        <td class="r">KES {{ number_format($order->total_amount - $order->delivery_fee, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Delivery Fee</td>
                        <td class="r">KES {{ number_format($order->delivery_fee, 2) }}</td>
                    </tr>
                    @endif
                    <tr class="grand">
                        <td>Total Amount</td>
                        <td class="r">KES {{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @if($order->notes)
    <p style="font-size:10px;color:#666;margin-top:10px;"><strong>Notes:</strong> {{ $order->notes }}</p>
    @endif

    <div class="footer">
        Thank you for choosing Tsavo Water &mdash; <em>Delivering Purity, Every Drop.</em>
    </div>

</div>
</body>
</html>
