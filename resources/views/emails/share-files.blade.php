<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fichiers partagés - TuxitVault</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .header .subtitle {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2d3748;
        }

        .message {
            font-size: 16px;
            margin-bottom: 30px;
            color: #4a5568;
            line-height: 1.5;
        }

        .files-section {
            background-color: #f7fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 25px 0;
            border-left: 4px solid #667eea;
        }

        .files-title {
            font-size: 16px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .files-count {
            background-color: #667eea;
            color: white;
            font-size: 12px;
            padding: 2px 8px;
            border-radius: 12px;
            margin-left: 10px;
        }

        .file-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .file-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s;
        }

        .file-item:last-child {
            border-bottom: none;
        }

        .file-item:hover {
            background-color: #edf2f7;
            margin: 0 -15px;
            padding-left: 15px;
            padding-right: 15px;
            border-radius: 6px;
        }

        .file-icon {
            font-size: 20px;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 500;
            color: #2d3748;
            margin-bottom: 2px;
        }

        .file-meta {
            font-size: 12px;
            color: #718096;
        }

        .cta-section {
            text-align: center;
            margin: 35px 0 25px 0;
        }

        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .footer {
            background-color: #f7fafc;
            padding: 25px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer p {
            margin: 0;
            font-size: 13px;
            color: #718096;
            line-height: 1.4;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 25px 0;
            border: none;
        }

        @media (max-width: 600px) {
            .content {
                padding: 25px 20px;
            }

            .header {
                padding: 25px 20px;
            }

            .files-section {
                padding: 20px 15px;
                margin: 20px 0;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="header">
        <h1>📁 Fichiers partagés</h1>
        <p class="subtitle">TuxitVault - Stockage cloud sécurisé</p>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="greeting">
            Bonjour ! 👋
        </div>

        <div class="message">
            Un utilisateur a partagé {{ count($files) }} {{ count($files) > 1 ? 'fichiers' : 'fichier' }} avec vous sur TuxitVault.
        </div>

        <!-- Files Section -->
        <div class="files-section">
            <div class="files-title">
                📋 Fichiers partagés
                <span class="files-count">{{ count($files) }}</span>
            </div>

            <ul class="file-list">
                @foreach($files as $file)
                    <li class="file-item">
                        <div class="file-icon">
                            @if($file->is_folder)
                                📁
                            @else
                                @php
                                    $extension = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));
                                    $icon = match($extension) {
                                        'pdf' => '📄',
                                        'doc', 'docx' => '📝',
                                        'xls', 'xlsx' => '📊',
                                        'ppt', 'pptx' => '📈',
                                        'jpg', 'jpeg', 'png', 'gif', 'svg' => '🖼️',
                                        'mp4', 'avi', 'mov', 'mkv' => '🎬',
                                        'mp3', 'wav', 'flac' => '🎵',
                                        'zip', 'rar', '7z' => '🗜️',
                                        'txt' => '📃',
                                        default => '📄'
                                    };
                                @endphp
                                {{ $icon }}
                            @endif
                        </div>
                        <div class="file-details">
                            <div class="file-name">{{ $file->name }}</div>
                            <div class="file-meta">
                                {{ $file->is_folder ? 'Dossier' : 'Fichier' }}
                                @if(!$file->is_folder && $file->size)
                                    • {{ $file->size }}
                                @endif
                                @if($file->updated_at)
                                    • Modifié le {{ \Carbon\Carbon::parse($file->updated_at)->format('d/m/Y') }}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <hr class="divider">

        <!-- Call to Action -->
        <div class="cta-section">
            <a href="{{ config('app.url') }}" class="cta-button">
                🚀 Accéder à mes fichiers
            </a>
        </div>

        <div style="text-align: center; color: #718096; font-size: 14px;">
            Connectez-vous à votre compte TuxitVault pour consulter et télécharger ces fichiers.
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>
            <strong>TuxitVault</strong> - Votre solution de stockage cloud sécurisé<br>
            Cet email a été envoyé automatiquement. Si vous n'attendiez pas ce message, vous pouvez l'ignorer en toute sécurité.
        </p>
        <p style="margin-top: 15px;">
            <a href="{{ config('app.url') }}">Visiter TuxitVault</a> •
            <a href="mailto:support@tuxitvault.fr">Support</a>
        </p>
    </div>
</div>
</body>
</html>
