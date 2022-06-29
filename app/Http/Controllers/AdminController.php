<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Atm;
use App\Models\Bottle;
use App\Http\Controllers\Controller;
use App\Models\Dompet;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Log;
use PDF;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class AdminController extends Controller
{
    //
    public function getData()
    {
        $chart_options = [
            'chart_title' => 'Users by months',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\User',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);

        $chart_options2 = [
            'chart_title' => 'Transactions by dates',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\Atm',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'penghasilan',
            'chart_type' => 'line',
        ];
        $chart2 = new LaravelChart($chart_options2);

        $dataUser = User::count();
        $dataBottle = Atm::sum('jmlhBotol');
        $dataPemasukan = $dataBottle * 2000;
        $dataPenghasilan = Atm::sum('penghasilan');
        $dataKeuntungan = $dataPemasukan - $dataPenghasilan;
        return view('admin.landing-admin', compact('chart1', 'chart2', 'dataUser', 'dataBottle', 'dataPemasukan', 'dataKeuntungan'));
    }

    public function getReport()
    {
        $dataReport = User::join('atms', 'atms.user_id', '=', 'users.id')
            ->join('dompet', 'dompet.user_id', '=', 'users.id')
            ->select('users.first_name as nama', 'atms.jmlhBotol as jumlahbtl', 'atms.penghasilan as penghasilan', 'atms.created_at as tanggal_transaksi', 'dompet.saldo as saldo')
            ->get();
        // $dataReport = DB::table('users')
        //     ->select('users.first_name as nama', 'atms.jmlhBotol as jumlahbtl', 'atms.created_at as tanggal_transaksi', 'dompet.saldo as saldo')
        //     ->join('atms', 'users.id', '=', 'atms.id')
        //     ->join('dompet', 'users.id', '=', 'dompet.id')
        //     ->get();
        return view('admin.report', compact('dataReport'));
    }

    public function generate()
    {
        $dataReport = User::join('atms', 'atms.user_id', '=', 'users.id')
            ->join('dompet', 'dompet.user_id', '=', 'users.id')
            ->select('users.first_name as nama', 'atms.jmlhBotol as jumlahbtl', 'atms.created_at as tanggal_transaksi', 'dompet.saldo as saldo')
            ->get();
        $pdf = PDF::loadview('admin.laporan_pemasukan', [
            'dataReport' => $dataReport,
        ]);
        // return $pdf->download('admin.generate_laporan');
        return $pdf->stream();
    }
}
