<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Commande;
use App\Models\Paiement;
use Illuminate\Support\Number;

class StatistiquesVentes extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCommandes = Commande::count();
        $totalPaiements = Paiement::count();
        $montantTotal = Paiement::where('statut', 'payé')->sum('montant');
        $paiementsEnAttente = Paiement::where('statut', 'paye')->count();

        // Statistiques du mois précédent pour comparaison
        $commandesMoisPrecedent = Commande::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $montantMoisPrecedent = Paiement::where('statut', 'paye')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('montant');

        return [
            Stat::make('Total des commandes', $totalCommandes)
                ->description($this->getEvolutionDescription($totalCommandes, $commandesMoisPrecedent))
                ->descriptionIcon($this->getEvolutionIcon($totalCommandes, $commandesMoisPrecedent))
                ->color($this->getEvolutionColor($totalCommandes, $commandesMoisPrecedent))
                ->chart($this->getCommandesChart()),

            Stat::make('Total des paiements', $totalPaiements)
                ->description('Paiements traités')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('success'),

            Stat::make('Chiffre d\'affaires', $this->formatMontant($montantTotal))
                ->description($this->getEvolutionMontantDescription($montantTotal, $montantMoisPrecedent))
                ->descriptionIcon($this->getEvolutionIcon($montantTotal, $montantMoisPrecedent))
                ->color($this->getEvolutionColor($montantTotal, $montantMoisPrecedent))
                ->chart($this->getVentesChart()),

            Stat::make('Paiements payés', $paiementsEnAttente)
                ->description('Payés')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($paiementsEnAttente > 10 ? 'danger' : ($paiementsEnAttente > 5 ? 'warning' : 'success')),
        ];
    }

    private function formatMontant(float $montant): string
    {
        return number_format($montant, 0, ',', ' ') . ' FCFA';
    }

    private function getEvolutionDescription(int $current, int $previous): string
    {
        if ($previous == 0) {
            return 'Nouveau';
        }

        $evolution = (($current - $previous) / $previous) * 100;
        return abs(round($evolution, 1)) . '% par rapport au mois dernier';
    }

    private function getEvolutionMontantDescription(float $current, float $previous): string
    {
        if ($previous == 0) {
            return 'Premier mois';
        }

        $evolution = (($current - $previous) / $previous) * 100;
        return abs(round($evolution, 1)) . '% par rapport au mois dernier';
    }

    private function getEvolutionIcon(float $current, float $previous): string
    {
        return $current >= $previous ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }

    private function getEvolutionColor(float $current, float $previous): string
    {
        return $current >= $previous ? 'success' : 'danger';
    }

    private function getCommandesChart(): array
    {
        return Commande::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    private function getVentesChart(): array
    {
        return Paiement::selectRaw('DATE(created_at) as date, SUM(montant) as total')
            ->where('statut', 'paye')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total')
            ->toArray();
    }
}
