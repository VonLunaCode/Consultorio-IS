<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProcedureResource\Pages;
use App\Models\Procedure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProcedureResource extends Resource
{
    protected static ?string $model = Procedure::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Catálogo Procedimientos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre del Procedimiento')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duración')
                            ->numeric()
                            ->suffix('minutos')
                            ->required(),

                        Forms\Components\TextInput::make('price')
                            ->label('Precio')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                            
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Imagen de Referencia')
                            ->image()
                            ->directory('procedures'),
                    ]),

                Forms\Components\TagsInput::make('acupuncture_points')
                    ->label('Puntos de Acupuntura')
                    ->placeholder('Ej: V40, V23')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('materials')
                    ->label('Materiales e Insumos')
                    ->required()
                    ->columnSpanFull(),

                // IMPLEMENTACIÓN DEL RICH EDITOR (SP2-HU2)
                Forms\Components\RichEditor::make('description')
                    ->label('Descripción y Pasos')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('contraindications')
                    ->label('Contraindicaciones (Alerta)')
                    ->placeholder('Ej: Embarazo, Marcapasos')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Ref')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Procedimiento')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Tiempo')
                    ->suffix(' min')
                    ->sortable(),

                // FORMATO DE MONEDA (Checklist)
                Tables\Columns\TextColumn::make('price')
                    ->label('Precio')
                    ->money('MXN')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProcedures::route('/'),
            'create' => Pages\CreateProcedure::route('/create'),
            'edit' => Pages\EditProcedure::route('/{record}/edit'),
        ];
    }
}