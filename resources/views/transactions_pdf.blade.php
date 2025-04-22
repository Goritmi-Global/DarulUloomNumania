<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <style>
        body {
            font-family: "Jameel Noori Nastaleeq", serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #0A8ACC !important;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }

        .footer .date-time {
            font-size: 12px;
            font-style: italic;
        }

        .footer .totals {
            margin-top: 10px;
            text-align: left;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 150px;
        }

    </style>
</head>

<body>

   
    <div class="logo">
    <img src="{{ asset('images/logo.jpg') }}" alt="Madrasa Logo">


    </div>
 
    <h1>{{ translate("Jamia Darol Uloom Noumania Utmanzai") }}</h1>

  
    <h2>
        @if($selectedFilter == 'Yearly')
            {{ translate("Transaction Report for Year") }}: {{ $selectedYear }}
        @elseif($selectedFilter == 'Monthly')
            {{ translate("Transaction Report for") }}
            {{ date('F', mktime(0, 0, 0, $selectedMonth, 1)) }}
            {{ $selectedYear }}
        @elseif($selectedFilter == 'Custom')
            {{ translate("Transaction Report from") }}
            {{ \Carbon\Carbon::parse($startDate)->format('d-M-Y') }} to
            {{ \Carbon\Carbon::parse($endDate)->format('d-M-Y') }}

        @else
            {{ translate("All Transactions Report") }}
        @endif
    </h2>

    {{-- Transactions Table --}}
    @if($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="font-size:12px">#</th>
                    <th style="font-size:12px">{{ translate("Date") }} </th>
                    <th style="font-size:12px">{{ translate("Ref No") }} </th>
                    <th style="font-size:12px">{{ translate("Description") }} </th>
                    <th style="font-size:12px">{{ translate("Method") }} </th>
                    <th style="font-size:12px">{{ translate("Recieved from") }} </th>
                    <th style="font-size:12px">{{ translate("Recieved By") }} </th>
                    <th style="font-size:12px">{{ translate("Cash In") }} </th>
                    <th style="font-size:12px">{{ translate("Cash Out") }}</th>
                    <th style="font-size:12px">{{ translate("Balance") }} </th>

                </tr>
            </thead>
            <tbody>
                @php
                    $balance = 0;
                    $totalCashIn = 0;
                    $totalCashOut = 0;
                @endphp
                @foreach($transactions as $index => $transaction)
                    @php
                        $cashIn = $transaction->cash_in ?? 0;
                        $cashOut = $transaction->cash_out ?? 0;
                        $balance += $cashIn - $cashOut;
                        $totalCashIn += $cashIn;
                        $totalCashOut += $cashOut;
                    @endphp
                    <tr>
                        <td style="font-size:10px">{{ $index + 1 }}</td>
                        <td style="font-size:10px">
                            {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d-M-Y') }}
                        </td>
                        <td style="font-size:10px">{{ $transaction->ref_no }}</td>
                        <td style="font-size:10px">{{ $transaction->remarks ?? 'N/A' }}
                        </td>
                        <td style="font-size:10px">{{ $transaction->method }}</td>
                        <td style="font-size:10px">{{ $transaction->received_from }}</td>
                        <td style="font-size:10px">{{ $transaction->received_by }}</td>
                        <td style="font-size:10px">
                            {{ $cashIn ?  number_format($cashIn) : '-' }}</td>
                        <td style="font-size:10px">
                            {{ $cashOut ?  number_format($cashOut) : '-' }}</td>
                        <td style="font-size:10px">{{ number_format($balance) }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-center">
            {{ translate("No transactions found for the selected period.") }} </p>
    @endif

    {{-- Footer with Totals --}}
    <div class="footer">

        <div class="totals">
            <p><strong>{{ translate("Total Cash In:") }}
                </strong>{{ number_format($totalCashIn) }}</p>
            <p><strong>{{ translate("Total Cash Out:") }}
                </strong>{{ number_format($totalCashOut) }}</p>
            <p><strong>{{ translate("Total Balance:") }} </strong>{{ number_format($balance) }}
            </p>
        </div>
        <div class="date-time">
            <p>{{ translate("Generated on:") }}
                {{ \Carbon\Carbon::now()->format('d-M-Y H:i:s') }}</p>
        </div>
    </div>

</body>

</html>
