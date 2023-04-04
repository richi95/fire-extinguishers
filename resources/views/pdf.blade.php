<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
         *{font-family: DejaVu Sans !important;}
        body{
            margin: auto
        }
        table, th, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            font-size:x-small;
            padding: 0 1rem;
        }
        td{
            padding: 1.5rem 3rem;
            text-align:center;
            font-size: small
        }
    </style>
</head>
<body>
    <table class="">
        <thead>
            <tr>
                <th colspan="4">A tűzoltó készülék</th>
                <th>Gyártás</th>
                <th colspan="4">Az üzemeltetési ellenőrzések időpontja</th>
                <th>Karbantartás időpontja</th>
                <th>Eszköz megj.</th>
            </tr>
            <tr>
                <th>$sz</th>
                <th>Gyári szám</th>
                <th>Készenléti helye</th>
                <th>Típusa</th>
                <th></th>
                <th>I.n.év</th>
                <th>II.n.év</th>
                <th>III.n.év</th>
                <th>IV.n.év</th>
                <th></th>
                <th></th>
    
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $p)
            <tr>
                <td>{{ $p->id }}</td>
                <td>{{ $p->serial_number }}</td>
                <td>{{ $p->internal_identifier }}</td>
                <td>{{ $p->device_type }}</td>
                <td>{{ $p->date_of_manufacture }}</td>     
                <td><span >{{ $p->maintenance ? $p->maintenance->first_qt : ""}}</span></td>
                <td><span>{{ $p->maintenance ? $p->maintenance->second_qt : ""}}</span></td>
                <td><span>{{ $p->maintenance ? $p->maintenance->third_qt : ""}}</span></td>
                <td><span>{{ $p->maintenance ? $p->maintenance->fourth_qt : ""}}</span></td>
                <td><span>{{ $p->maintenance ? $p->maintenance->service_date : ""}}</span></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>