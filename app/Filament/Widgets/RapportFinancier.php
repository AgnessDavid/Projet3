<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Models\Commande;
use Illuminate\Database\Eloquent\Builder;

class RapportFinancier extends BaseWidget
{
    protected static ?string $heading = 'Rapport financier';

    protected function getTableQuery(): Builder
    {
        return Commande::query()->with(['client', 'photo', 'paiements']);
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
                ->searchable(),

            TextColumn::make('client.prenom')
                ->label('Prénom')
                ->searchable(),

            TextColumn::make('client.telephone')
                ->label('Téléphone')
                ->searchable(),

            TextColumn::make('client.adresse')
                ->label('Adresse')
                ->limit(30),

            ImageColumn::make('photo.image_path')
                ->label('Photo')
                ->height(50)
                ->width(50),

            TextColumn::make('photo.prix')
                ->label('Prix unitaire')
                ->formatStateUsing(fn($state) => number_format($state, 0, ',', ' ') . ' FCFA')
                ->alignEnd(),

            TextColumn::make('quantite')
                ->label('Quantité')
                ->alignCenter(),

            TextColumn::make('prix_total')
                ->label('Montant total')
                ->formatStateUsing(fn($state) => number_format($state, 0, ',', ' ') . ' FCFA')
                ->alignEnd()
                ->weight('bold'),

            TextColumn::make('paiements.statut')
                ->label('Statut paiement')
                ->badge()
                ->color(fn(?string $state): string => match ($state) {
                    'paye' => 'success',
                    'en_attente' => 'warning',
                    'refuse' => 'danger',
                    default => 'gray',
                })
                ->formatStateUsing(fn($state) => match ($state) {
                    'paye' => 'Payé',
                    'en_attente' => 'En attente',
                    'refuse' => 'Refusé',
                    default => $state ?? 'N/A'
                }),

            TextColumn::make('paiements.moyen_paiement')
                ->label('Moyen de paiement')
                ->formatStateUsing(fn($state) => match ($state) {
                    'carte_bancaire' => 'Carte bancaire',
                    'virement' => 'Virement',
                    'especes' => 'Espèces',
                    'mobile_money' => 'Mobile Money',
                    default => $state ?? 'N/A'
                }),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('jour')
                ->label('Jour spécifique')
                ->form([
                    DatePicker::make('jour')
                        ->label('Sélectionner un jour'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query->when(
                        $data['jour'] ?? null,
                        fn(Builder $query, $date): Builder => $query->whereDate('created_at', $date)
                    );
                }),

            Tables\Filters\Filter::make('mois')
                ->label('Mois/Année')
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
                        ]),
                    Select::make('annee')
                        ->label('Année')
                        ->options(fn() => Commande::selectRaw('YEAR(created_at) as year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray() ?: [now()->year => now()->year]),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['mois'] ?? null,
                            fn(Builder $query, $month): Builder => $query->whereMonth('created_at', $month)
                        )
                        ->when(
                            $data['annee'] ?? null,
                            fn(Builder $query, $year): Builder => $query->whereYear('created_at', $year)
                        );
                }),

            Tables\Filters\Filter::make('periode')
                ->label('Période personnalisée')
                ->form([
                    DatePicker::make('date_debut')
                        ->label('Date de début'),
                    DatePicker::make('date_fin')
                        ->label('Date de fin'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['date_debut'] ?? null,
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date)
                        )
                        ->when(
                            $data['date_fin'] ?? null,
                            fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date)
                        );
                }),

            Tables\Filters\SelectFilter::make('statut_paiement')
                ->label('Statut de paiement')
                ->relationship('paiements', 'statut')
                ->options([
                    'paye' => 'Payé',
                    'en_attente' => 'En attente',
                    'refuse' => 'Refusé',
                ]),

            Tables\Filters\SelectFilter::make('moyen_paiement')
                ->label('Moyen de paiement')
                ->relationship('paiements', 'moyen_paiement')
                ->options([
                    'carte_bancaire' => 'Carte bancaire',
                    'virement' => 'Virement',
                    'especes' => 'Espèces',
                    'mobile_money' => 'Mobile Money',
                ]),
        ];
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns($this->getTableColumns())
            ->filters($this->getTableFilters())
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}