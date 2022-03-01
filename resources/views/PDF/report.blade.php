<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>
</head>
<style>
    * {
        font-family: Arial, Helvetica, sans-serif
    }

    table {
        width: 100%;
        border: 1px solid #dddddd;
        border-spacing: 0px;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 0em;
        padding-left: 4px;

    }

    tr:nth-child(even) {
        border: 1px solid white;
    }

    .mt-1 {
        margin-top: 4rem;
    }

    .p-0 {
        padding: 0px;
        margin: 0px;
    }

    .text-center {
        width: 50%;
        margin: 0 auto;
    }

    .text-center-title {
        width: 30%;
        margin: 0 auto;
    }

    h5 {
        margin: 0px;
        padding: 0px;
    }

    .text-right {
        position: absolute;
        right: 0px;
        width: 300px;
        /* border: 3px solid #73AD21; */
        text-align: right;
        padding: 10px;
        top: 20px;

    }

    .text-red {
        color: #E78A81 !important;
    }

    .text-black {
        color: black !important;
    }

</style>

<body>
    <h1 class="text-center-title">Recibo de ingreso</h1>
    <h2 class="text-right text-red">
        <b class="text-black">No.</b> <b class="text-red">{{ $data->id }}</b>
    </h2>
    <h4>Fecha de generación: {{ date('d/m/Y H:m:s') }}</h4>
    <h4>Alcaldía municipal de</h4>
    <table>
        <tbody>
            <tr>
                <td rowspan="4" style="padding-bottom: 12px; padding-right: 4px; padding-left: 4px;">
                    <h3>POR US${{ number_format($data->monto, 2) }}</h3>
                    <h4>NOMBRE: {{ $data->nombre }}</h4>
                    <h4>ENTREGO EN ESTA OFICINA LA CANTIDAD DE:</h4>
                    <h4>{{ $data->letras }}</h4>
                    <hr class="mt-1">
                    <h4 class="p-0 text-center" style="height: 10px !important;">FIRMA TESORERO</h4>
                    <hr class="mt-1">
                    <h4 class="p-0 text-center" style="height: 10px !important;">ENC. CONT. MPAL</h4>
                </td>
                <td rowspan="2" style="height: 10px !important;">CONCEPTO O MANTENIMIENTO DE INGRESO</td>
                <td colspan="3" style="height: 10px !important;">CARGO EN CAJA, RUBROS O CUENTAS AFECTADAS</td>
            </tr>
            <tr style="height: 10px !important;">
                <td>
                    <h5>FONDO MUNICIPAL</h5>
                </td>
                <td>
                    <h5>ESPECIF MPLS</h5>
                </td>
                <td>
                    <h5>ESPECIF. FISCALES</h5>
                </td>
            </tr>
            <tr style="height: 800px;">
                <td>
                    @foreach ($conceptos as $concepto)
                        {{ $concepto->codigo }} - {{ $concepto->concepto }} <br>
                    @endforeach
                </td>
                <td></td>
                <td></td>
                <td>
                    @foreach ($conceptos as $concepto)
                        ${{ number_format($concepto->monto, 2) }} <br>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <h5>TOTALES</h5>
                </td>
                <td></td>
                <td>${{ number_format($data->monto, 2) }} </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
