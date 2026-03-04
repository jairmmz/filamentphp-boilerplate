<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #1e3a8a;
            color: #ffffff;
        }

        th {
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }

        td {
            padding: 7px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 15px;
            font-size: 11px;
            color: #374151;
        }
    </style>
</head>

<body>

<main>
    <table>
        <thead>
            <tr>
                <th width="10%">#</th>
                <th width="25%">Nombre</th>
                <th width="50%">Correo Electrónico</th>
                <th width="15%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>
                        {{ $index + 1 }}
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->status ? 'Activo' : 'Inactivo' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        Total de registros: {{ count($users) }}
    </div>
</main>

</body>
</html>
