<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use App\Models\Commande;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;

class RapportFinancier extends BaseWidget
{
    protected static ?string $heading = 'Rapport financier';

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Commande::query()
            ->with([
                'client:id,nom,prenom,telephone,adresse',
                'photo:id,image_path,prix',
                'paiements:id,commande_id,statut,moyen_paiement'
            ])
            ->select(['id', 'client_id', 'photo_id', 'quantite', 'prix_total', 'created_at']);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')
                ->label('Date de commande')
                ->dateTime('d/m/Y H:i')
                ->sortable(),

            TextColumn::make('client.nom')
                ->label('Nom')
                ->searchable()
                ->sortable(),

            TextColumn::make('client.prenom')
                ->label('Prénom')
                ->searchable()
                ->sortable(),

            TextColumn::make('client.telephone')
                ->label('Téléphone')
                ->searchable()
                ->copyable()
                ->copyMessage('Téléphone copié!')
                ->copyMessageDuration(1500),

            TextColumn::make('client.adresse')
                ->label('Adresse')
                ->limit(30)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
                    if (strlen($state) <= 30) {
                        return null;
                    }
                    return $state;
                }),

            ImageColumn::make('photo.image_path')
                ->label('Photo')
                ->height(50)
                ->width(50)
                ->circular(),

            TextColumn::make('photo.prix')
                ->label('Prix unitaire')
                ->money('EUR')
                ->sortable(),

            TextColumn::make('quantite')
                ->label('Quantité')
                ->numeric()
                ->sortable(),

            TextColumn::make('prix_total')
                ->label('Montant total')
                ->money('EUR')
                ->weight('bold')
                ->color('success')
                ->sortable(),

            BadgeColumn::make('paiements.statut')
                ->label('Statut paiement')
                ->colors([
                    'success' => 'payé',
                    'warning' => 'en_attente',
                    'danger' => 'échoué',
                    'secondary' => 'annulé',
                ])
                ->icons([
                    'heroicon-o-check-circle' => 'payé',
                    'heroicon-o-clock' => 'en_attente',
                    'heroicon-o-x-circle' => 'échoué',
                    'heroicon-o-no-symbol' => 'annulé',
                ]),

            TextColumn::make('paiements.moyen_paiement')
                ->label('Moyen de paiement')
                ->badge()
                ->color('primary'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('search')
                ->form([
                    TextInput::make('search')
                        ->label('Rechercher')
                        ->placeholder('Nom, prénom, téléphone...')
                        ->maxLength(255),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['search'],
                        fn(Builder $query, $search): Builder => $query->whereHas('client', function (Builder $q) use ($search) {
                            $q->where('nom', 'like', "%{$search}%")
                                ->orWhere('prenom', 'like', "%{$search}%")
                                ->orWhere('telephone', 'like', "%{$search}%");
                        })
                    );
                }),

            Tables\Filters\SelectFilter::make('paiements.statut')
                ->label('Statut paiement')
                ->options([
                    'payé' => 'Payé',
                    'en_attente' => 'En attente',
                    'échoué' => 'Échoué',
                    'annulé' => 'Annulé',
                ])
                ->placeholder('Tous les statuts'),

            Tables\Filters\SelectFilter::make('paiements.moyen_paiement')
                ->label('Moyen de paiement')
                ->options([
                    'especes' => 'Espèces',
                    'carte' => 'Carte bancaire',
                    'virement' => 'Virement',
                    'cheque' => 'Chèque',
                    'mobile' => 'Paiement mobile',
                ])
                ->placeholder('Tous les moyens'),

            Tables\Filters\Filter::make('jour')
                ->form([
                    DatePicker::make('jour')
                        ->label('Date spécifique')
                        ->displayFormat('d/m/Y'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['jour'],
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', $date),
                    );
                }),

            Tables\Filters\Filter::make('periode')
                ->form([
                    DatePicker::make('date_debut')
                        ->label('Date début')
                        ->displayFormat('d/m/Y'),
                    DatePicker::make('date_fin')
                        ->label('Date fin')
                        ->displayFormat('d/m/Y'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['date_debut'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['date_fin'],
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),

            Tables\Filters\Filter::make('mois')
                ->form([
                    Select::make('mois')
                        ->label('Mois')
                        ->options([
                            1 => 'Janvier',
                            2 => 'Février',
                            3 => 'Mars',
                            4 => 'Avril',
                            5 => 'Mai',
                            6 => 'Juin',
                            7 => 'Juillet',
                            8 => 'Août',
                            9 => 'Septembre',
                            10 => 'Octobre',
                            11 => 'Novembre',
                            12 => 'Décembre',
                        ])
                        ->placeholder('Sélectionner un mois'),
                    Select::make('annee')
                        ->label('Année')
                        ->options(function () {
                            $years = Commande::selectRaw('YEAR(created_at) as year')
                                ->distinct()
                                ->orderBy('year', 'desc')
                                ->pluck('year', 'year')
                                ->toArray();
                            return $years;
                        })
                        ->placeholder('Sélectionner une année'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['mois'] && $data['annee'],
                            fn(Builder $query): Builder => $query
                                ->whereMonth('created_at', $data['mois'])
                                ->whereYear('created_at', $data['annee']),
                        );
                }),

            Tables\Filters\Filter::make('montant')
                ->form([
                    TextInput::make('montant_min')
                        ->label('Montant minimum')
                        ->numeric()
                        ->prefix('€'),
                    TextInput::make('montant_max')
                        ->label('Montant maximum')
                        ->numeric()
                        ->prefix('€'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['montant_min'],
                            fn(Builder $query, $amount): Builder => $query->where('prix_total', '>=', $amount),
                        )
                        ->when(
                            $data['montant_max'],
                            fn(Builder $query, $amount): Builder => $query->where('prix_total', '<=', $amount),
                        );
                }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->label('Voir')
                ->icon('heroicon-o-eye'),

            Action::make('print')
                ->label('Imprimer')
                ->icon('heroicon-o-printer')
                ->color('secondary')
                ->action(function (Commande $record) {
                    // Logique d'impression
                    $this->dispatchBrowserEvent('print-invoice', ['commandeId' => $record->id]);
                }),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('export')
                ->label('Exporter Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function () {
                    // Logique d'export
                    $this->dispatchBrowserEvent('export-data');
                }),

            Action::make('refresh')
                ->label('Actualiser')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $this->dispatchBrowserEvent('refresh-widget');
                }),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Aucune commande trouvée';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Il n\'y a aucune commande correspondant à vos critères de recherche.';
    }

    protected function getTableFooter(): ?View
    {
        $query = $this->getTableQuery();

        // Appliquer les filtres actifs
        $filteredQuery = $this->applyFiltersToTableQuery($query);

        $stats = [
            'total_commandes' => $filteredQuery->count(),
            'total_revenus' => $filteredQuery->sum('prix_total'),
            'moyenne_commande' => $filteredQuery->avg('prix_total'),
            'commandes_payees' => $filteredQuery->whereHas('paiements', function ($q) {
                $q->where('statut', 'payé');
            })->count(),
        ];

        return view('filament.widgets.rapport-financier-footer', compact('stats'));
    }

    protected function applyFiltersToTableQuery(Builder $query): Builder
    {
        // Cette méthode applique les filtres actifs à la requête
        // Filament gère cela automatiquement, mais vous pouvez l'override si nécessaire
        return $query;
    }

    public function getTableRecordKey($record): string
    {
        return (string) $record->getKey();
    }
}
