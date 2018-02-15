<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $summary = [
            'current_month' => Payment::totalPaidForMonth(date('m')),
            'last_month' => Payment::totalPaidForMonth(date('m') - 1),
            'last_2_month' => Payment::totalPaidForMonth(date('m') - 2),
        ];

        return view('report.index', compact('summary'));
    }

    public function downloadPdf()
    {
        $summary = [
            'current_month' => Payment::totalPaidForMonth(date('m')),
            'last_month' => Payment::totalPaidForMonth(date('m') - 1),
            'last_2_month' => Payment::totalPaidForMonth(date('m') - 2),
        ];
        $pdf = PDF::loadView('pdf.report', compact('summary'));
        return $pdf->download('report.pdf');
    }
}
