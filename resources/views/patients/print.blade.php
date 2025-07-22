<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Arsip Pasien - {{ $patient->name }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .header p { margin: 5px 0; }
        .content table { width: 100%; border-collapse: collapse; }
        .content th, .content td { border: 1px solid #ddd; padding: 8px; }
        .content th { background-color: #f2f2f2; text-align: left; width: 30%;}
    </style>
</head>
<body>
    <div class="header">
        <h1>Klinik Fisioterapi Karya Suci</h1>
        <p>Cabang {{ $patient->branch->name ?? 'Pusat' }}</p>
        <hr>
        <h2>ARSIP DATA PASIEN</h2>
    </div>

    <div class="content">
        <table>
            <tr>
                <th>Nama Pasien</th>
                <td>{{ $patient->name }}</td>
            </tr>
            <tr>
                <th>Tanggal Registrasi</th>
                <td>{{ $patient->created_at->format('d M Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }}</td>
            </tr>
             <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $patient->gender }}</td>
            </tr>
            <tr>
                <th>Nomor Kontak</th>
                <td>{{ $patient->contact_number ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $patient->address ?? '-' }}</td>
            </tr>
            <tr>
                <th>Program yang Diambil</th>
                <td><strong>{{ $patient->program_status }}</strong></td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 30px; font-size: 10px;">Dokumen ini dicetak pada tanggal: {{ $date }}</p>
</body>
</html>