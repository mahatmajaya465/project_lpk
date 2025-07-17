<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
            background-color: #f8f9fa;
        }

        .certificate-container {
            /* width: 297mm; */
            height: 176mm;
            position: relative;
            background: white;
            border: 15px solid #2c5aa0;
            box-sizing: border-box;
            padding: 10mm;
            background-image: url('https://lkpsaraswati.com/wp-content/uploads/2023/05/bg-pattern.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 60%;
            background-opacity: 0.05;
        }

        .header {
            text-align: center;
            margin-bottom: 10mm;
        }

        .logo {
            height: 50px;
            margin-bottom: 5mm;
        }

        .institution-name {
            font-size: 20pt;
            font-weight: bold;
            color: #2c5aa0;
            margin-bottom: 2mm;
        }

        .address {
            font-size: 10pt;
            color: #555;
            margin-bottom: 5mm;
        }

        .certificate-title {
            font-size: 22pt;
            font-weight: bold;
            color: #d4af37;
            text-decoration: underline;
            margin: 8mm 0;
        }

        .content {
            margin: 0 15mm;
        }

        .recipient-info {
            margin-bottom: 10mm;
            line-height: 1.6;
        }

        .course-details {
            width: 100%;
            border-collapse: collapse;
            margin: 5mm 0;
            padding: 0px
        }

        .course-details td {
            padding: 2mm 0mm;
            vertical-align: top;
            border-bottom: 1px solid #eee;
        }

        .signature-area {
            position: absolute;
            right: 20mm;
            bottom: 0mm;
            text-align: center;
            width: 60mm;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 50mm;
            margin: 15mm auto 3mm;
        }

        .certificate-number {
            position: absolute;
            bottom: 10mm;
            left: 20mm;
            font-size: 10pt;
            color: #666;
        }

        .highlight {
            color: #2c5aa0;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <!-- Header -->
        <div class="header">
            {{-- <img src="{{ $logo }}" class="logo" alt="Logo LKP Saraswati"> --}}
            <div class="institution-name">{{ $institution }}</div>
            <div class="address">{{ $address }}</div>
            <div class="certificate-title">{{ $certificate_title }}</div>
        </div>

        <!-- Nomor Sertifikat -->
        {{-- <div class="certificate-number">
            No: {{ $certificate_number }}
        </div> --}}

        <!-- Konten Utama -->
        <div class="content">
            <div class="recipient-info">
                <div>Diberikan kepada:</div>
                <div style="font-weight: bold; font-size: 14pt; color: #2c5aa0;">
                    {{ $recipient['name'] }}
                </div>
                <div>No. Registrasi: <span class="highlight">{{ $recipient['registration'] }}</span></div>
            </div>

            <div style="text-align: justify; margin-bottom: 5mm;">
                Telah menyelesaikan program pelatihan <span class="highlight">{{ $course['program'] }}</span>
                yang diselenggarakan oleh <span class="highlight">{{ $institution }}</span> pada periode <span class="highlight">{{ $course['period'] }}</span> dan dinyatakan:
            </div>

            <table class="course-details">
                <tr>
                    <td width="30%">Program Pelatihan</td>
                    <td>: {{ $course['program'] }}</td>
                </tr>
                {{-- <tr>
                    <td>Durasi Pelatihan</td>
                    <td>: {{ $course['duration'] }}</td>
                </tr> --}}
                <tr>
                    <td>Periode Pelatihan</td>
                    <td>: {{ $course['period'] }}</td>
                </tr>
                <tr>
                    <td>Nilai</td>
                    <td>: {{ $course['nilai'] }}</td>
                </tr>
            </table>

            <div style="text-align: justify; margin-top: 5mm;">
                Sertifikat ini merupakan bukti bahwa yang bersangkutan telah mengikuti dan menyelesaikan program
                pelatihan
                sesuai dengan standar kompetensi yang ditetapkan oleh LKP Saraswati Komputer.
            </div>
        </div>

        <!-- Tanda Tangan -->
        <div class="signature-area">
            <div>Denpasar, {{ $date }}</div>
            <div class="signature-line"></div>
            <div style="font-weight: bold;">{{ $signature['title'] }}</div>
            {{-- <div style="margin-top: 10mm;">({{ $signature['name'] }})</div> --}}
        </div>
    </div>
</body>

</html>
