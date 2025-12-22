<!DOCTYPE html>
<html>
<head>
    <title>Panduan Kesehatan NutriGuard</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #10b981; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #10b981; }
        .user-info { margin-bottom: 30px; background: #f3f4f6; padding: 15px; border-radius: 8px; }
        h3 { margin-top: 0; }
        
        .disease-box { margin-bottom: 25px; border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        .disease-title { font-size: 18px; font-weight: bold; color: #1f2937; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #eee; }
        
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; color: white; }
        .bg-danger { background-color: #ef4444; } /* Merah */
        .bg-warning { background-color: #f59e0b; } /* Kuning */
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">NutriGuard</div>
        <p>Panduan Keamanan Makanan Personal</p>
    </div>

    <div class="user-info">
        <strong>Nama Pasien:</strong> {{ $user->name }} <br>
        <strong>Tanggal Cetak:</strong> {{ date('d F Y') }}
    </div>

    @if($diseases->isEmpty())
        <p style="text-align: center;">Anda belum mengatur profil kesehatan atau tidak memiliki pantangan tercatat.</p>
    @else
        @foreach($diseases as $disease)
            <div class="disease-box">
                <div class="disease-title">Kondisi: {{ $disease->name }}</div>
                
                @if($disease->ingredients->isEmpty())
                    <p><em>Tidak ada pantangan khusus untuk kondisi ini di database kami.</em></p>
                @else
                    <table>
                        <thead>
                            <tr>
                                <th>Bahan Makanan</th>
                                <th>Status Keamanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($disease->ingredients as $ingredient)
                                <tr>
                                    <td>{{ $ingredient->name }}</td>
                                    <td>
                                        @if($ingredient->pivot->status == 'danger')
                                            <span class="badge bg-danger">BAHAYA (HINDARI)</span>
                                        @elseif($ingredient->pivot->status == 'warning')
                                            <span class="badge bg-warning">BATASI (HATI-HATI)</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endforeach
    @endif

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #888;">
        <p>Dokumen ini digenerate otomatis oleh sistem NutriGuard.<br>
        Selalu konsultasikan dengan dokter atau ahli gizi Anda.</p>
    </div>

</body>
</html>

