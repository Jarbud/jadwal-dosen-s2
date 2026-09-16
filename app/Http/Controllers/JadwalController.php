<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $spreadsheetId = '1xQ5m1wOkIwfiliee1X9IBN6-149fh1Eo2eFaFHrZHIk';
        $sheetName = 'Data';
        $url = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/gviz/tq?tqx=out:csv&sheet=" . urlencode($sheetName) . "&tq=select+*";

        $response = Http::get($url);
        $jadwalList = [];

        if ($response->successful()) {
            $rawBody = str_replace("\r", "", $response->body());
            $stream = fopen('php://temp', 'r+');
            fwrite($stream, $rawBody);
            rewind($stream);

            $header = fgetcsv($stream, 0, ',', '"');

            $months = [
                'Januari' => '01', 'Februari' => '02', 'Maret' => '03', 'April' => '04',
                'Mei' => '05', 'Juni' => '06', 'Juli' => '07', 'Agustus' => '08',
                'September' => '09', 'Oktober' => '10', 'November' => '11', 'Desember' => '12'
            ];

            $id = 1;
            while (($row = fgetcsv($stream, 0, ',', '"')) !== false) {
                if (empty(array_filter($row))) continue;

                $row = array_map(fn($value) => str_replace("\n", " ", $value), $row);

                if (count($header) !== count($row)) {
                    $row = (count($row) < count($header))
                        ? array_pad($row, count($header), '')
                        : array_slice($row, 0, count($header));
                }

                $combined = array_combine($header, $row);
                if (empty($combined['Nama Dosen']) && empty($combined['Mata Kuliah'])) continue;

                // Konversi tanggal "Selasa, 31 Maret 2026" -> "2026-03-31"
                $rawDate = $combined['Tanggal'] ?? '';
                $parsedDate = '';
                if ($rawDate) {
                    $cleanDate = str_replace(',', '', $rawDate);
                    $parts = explode(' ', $cleanDate);
                    $day = $monthText = $year = '';
                    foreach ($parts as $part) {
                        $part = trim($part);
                        if (is_numeric($part)) {
                            if (strlen($part) === 4) $year = $part;
                            else $day = str_pad($part, 2, '0', STR_PAD_LEFT);
                        } elseif (isset($months[$part])) {
                            $monthText = $part;
                        }
                    }
                    if ($day && $monthText && $year) {
                        $parsedDate = "{$year}-{$months[$monthText]}-{$day}";
                    }
                }

                if (!$parsedDate) $parsedDate = date('Y-m-d');

                $jadwalList[] = [
                    'id'          => $id++,
                    'date'        => $parsedDate,
                    'jam'         => '18.30-20.30',
                    'batch'       => $combined['Batch'] ?? '',
                    'matkul'      => $combined['Mata Kuliah'] ?? '',
                    'dosen'       => $combined['Nama Dosen'] ?? '',
                    'materi'      => $combined['Materi'] ?? '',
                    'sub_materi'  => $combined['Sub Materi'] ?? '',
                    'periode'     => $combined['Periode'] ?? '',
                    'tahun_ajaran'=> $combined['Tahun Ajaran'] ?? '',
                ];
            }
            fclose($stream);
        }

        return view('jadwal', compact('jadwalList'));
    }
}