<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <title>Rapport journalier</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 12mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #333;
            margin-bottom: 15px;
        }

        .header-table td {
            vertical-align: middle;
            padding-bottom: 10px;
        }

        .header-text {
            text-align: center;
        }

        .header-text h2 {
            margin: 0 0 5px;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header-text p {
            margin: 4px 0;
        }

        .header-logo {
            height: 70px;
        }

        .summary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .summary td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }

        .section-title {
            background: #e9ecef;
            border: 1px solid #bbb;
            padding: 8px;
            margin-top: 18px;
            font-size: 13px;
            font-weight: bold;
        }

        .session-title {
            background: #f5f5f5;
            border: 1px solid #ccc;
            padding: 6px;
            margin-top: 10px;
            font-size: 11px;
            font-weight: bold;
        }

        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        table.details th,
        table.details td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        table.details th {
            background: #f0f0f0;
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #f5f5f5;
        }

        .general-total {
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .muted {
            color: #666;
        }

        .footer {
            margin-top: 25px;
            font-size: 9px;
            text-align: right;
            color: #666;
        }
    </style>
</head>

<body>

@php
    // Logo en base64 pour que DomPDF l'affiche à coup sûr.
    $logoPath   = public_path('images/logo.png');
    $logoBase64 = file_exists($logoPath)
        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
        : null;

    // Utilisateur qui génère le rapport.
    $auteur = auth()->user();
    $auteurNom = $auteur->name ?? $auteur->nom ?? $auteur->email ?? 'Utilisateur inconnu';
@endphp

<table class="header-table">
    <tr>
        <td style="width: 90px;">
            @if ($logoBase64)
                <img src="{{ $logoBase64 }}" class="header-logo" alt="Logo">
            @endif
        </td>

        <td class="header-text">
            <h2>Collège Saint François Xavier</h2>
            <p><strong>RAPPORT JOURNALIER DES PAIEMENTS</strong></p>
            <p>
                Période :
                {{ \Carbon\Carbon::parse($date_from)->format('d/m/Y') }}
                au
                {{ \Carbon\Carbon::parse($date_to)->format('d/m/Y') }}
            </p>
            <p>
                Document généré le {{ now()->format('d/m/Y à H:i') }}
                par <strong>{{ $auteurNom }}</strong>
            </p>
        </td>

        {{-- Colonne vide pour garder le texte bien centré --}}
        <td style="width: 90px;"></td>
    </tr>
</table>

{{-- RÉSUMÉ GÉNÉRAL --}}
<table class="summary">
    <tr>
        <td>
            <strong>Élèves ayant payé</strong><br>
            {{ number_format($totalEleves, 0, ',', ' ') }}
        </td>

        @forelse($totalGeneral as $devise => $total)
            <td>
                <strong>Total encaissé en {{ $devise }}</strong><br>
                {{ number_format($total, 2, ',', ' ') }} {{ $devise }}
            </td>
        @empty
            <td>
                <strong>Total encaissé</strong><br>
                0,00
            </td>
        @endforelse
    </tr>
</table>

@forelse($sections as $section)

    {{-- SECTION --}}
    <div class="section-title">
        SECTION : {{ $section->nom }}
    </div>

    <p>
        <strong>Totaux de la section :</strong>

        @forelse($section->totaux as $devise => $total)
            &nbsp; {{ number_format($total, 2, ',', ' ') }}
            {{ $devise }}
        @empty
            0,00
        @endforelse
    </p>

    @forelse($section->sessions as $session)

        {{-- SESSION --}}
        <div class="session-title">
            Session : {{ $session->nom }}
            — {{ $session->nb_eleves }} élève(s) ayant payé
        </div>

        <table class="details">
            <thead>
            <tr>
                <th style="width: 5%">N°</th>
                <th>Frais</th>
                <th style="width: 15%">Devise</th>
                <th style="width: 20%" class="center">
                    Élèves ayant payé
                </th>
                <th style="width: 25%" class="right">
                    Montant encaissé
                </th>
            </tr>
            </thead>

            <tbody>
            @foreach($session->lignes as $ligne)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ligne->frais }}</td>
                    <td>{{ $ligne->devise }}</td>
                    <td class="center">
                        {{ $ligne->nb_eleves }}
                    </td>
                    <td class="right">
                        {{ number_format($ligne->total, 2, ',', ' ') }}
                        {{ $ligne->devise }}
                    </td>
                </tr>
            @endforeach
            </tbody>

            <tfoot>
            @foreach($session->totaux as $devise => $total)
                <tr class="total-row">
                    <td colspan="4" class="right">
                        TOTAL SESSION EN {{ $devise }}
                    </td>
                    <td class="right">
                        {{ number_format($total, 2, ',', ' ') }}
                        {{ $devise }}
                    </td>
                </tr>
            @endforeach
            </tfoot>
        </table>

    @empty
        <p class="muted">Aucune session pour cette section.</p>
    @endforelse

@empty
    <p class="center">
        Aucun paiement trouvé pour la période sélectionnée.
    </p>
@endforelse

{{-- TOTAL GÉNÉRAL --}}
<div class="general-total">
    <div class="section-title">
        RÉCAPITULATIF GÉNÉRAL
    </div>

    <table class="details">
        <thead>
        <tr>
            <th>Devise</th>
            <th class="right">Montant total encaissé</th>
        </tr>
        </thead>

        <tbody>
        @forelse($totalGeneral as $devise => $total)
            <tr class="total-row">
                <td>{{ $devise }}</td>
                <td class="right">
                    {{ number_format($total, 2, ',', ' ') }}
                    {{ $devise }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="center">
                    Aucun encaissement
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="footer">
    Collège Saint François Xavier — Rapport financier
    — Généré par {{ $auteurNom }}
</div>

</body>
</html>