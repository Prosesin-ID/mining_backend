<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas Driver</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 3px 0;
        }
        .info td:first-child {
            width: 150px;
            font-weight: bold;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table.data th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        table.data td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 11px;
        }
        table.data tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-valid {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-onlocation {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN AKTIVITAS DRIVER</h1>
        <p>Checkpoint Tracker - Unit Monitoring System</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ date('d F Y H:i:s') }}</td>
            </tr>
            <tr>
                <td>Total Data</td>
                <td>: {{ $logs->count() }} record</td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>Unit</th>
                <th>Driver</th>
                <th>Checkpoint</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Durasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $log->driver->unitTruck->unit_number ?? 'N/A' }}</td>
                <td>{{ $log->driver->name }}</td>
                <td>{{ $log->checkPoint->name }}</td>
                <td>{{ \Carbon\Carbon::parse($log->check_In)->format('d/m/Y H:i') }}</td>
                <td>{{ $log->check_Out ? \Carbon\Carbon::parse($log->check_Out)->format('d/m/Y H:i') : '-' }}</td>
                <td>
                    @if($log->check_Out)
                        @php
                            $checkIn = \Carbon\Carbon::parse($log->check_In);
                            $checkOut = \Carbon\Carbon::parse($log->check_Out);
                            $diff = $checkIn->diff($checkOut);
                        @endphp
                        {{ $diff->h }}j {{ $diff->i }}m
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($log->status === 'selesai')
                        <span class="badge badge-valid">Valid</span>
                    @else
                        <span class="badge badge-onlocation">On Location</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh sistem pada {{ date('d F Y H:i:s') }}</p>
        <p>Checkpoint Tracker © {{ date('Y') }}</p>
    </div>
</body>
</html>