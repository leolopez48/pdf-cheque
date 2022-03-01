<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Cheque;
use Luecano\NumeroALetras\NumeroALetras;

class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generatePDF($id)
    {
        $data = Cheque::where('id', $id)->first();
        $conceptos = Cheque::join('conceptos as con', 'cheques.id', '=', 'con.cheque_id')
        ->whereNull('con.deleted_at')
        ->get();
        $formatter = new NumeroALetras();
        $data->letras = $formatter->toMoney($data->monto, 2, 'DÓLARES', 'CENTAVOS');

        define("dompdf_enable_html5parser", true);
        define("dompdf_enable_fontsubsetting", true);
        define("dompdf_unicode_enabled", true);
        define("dompdf_dpi", 120);
        define("dompdf_enable_remote", true);

        $html = \View::make("PDF.report", compact("data", "conceptos"));

        $pdf = PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);
        // $pdf = PDF::loadView('PDF.report', compact('data', 'conceptos'));
        // $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('cheque-'.now().'.pdf');
        // return view('PDF.report', compact('data', 'conceptos'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPDF()
    {
        $data = Cheque::all();

        $pdf = PDF::loadView('PDF.report', compact('data'));

        return $pdf->download('report-'.now().'.pdf');
    }
}
