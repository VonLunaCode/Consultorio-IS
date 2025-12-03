<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatientResource\Pages;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Pacientes';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Información Personal')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nombre Completo')
                        ->required()
                        ->maxLength(255),

                    // --- AQUÍ ESTÁ EL EMAIL FALTANTE ---
                    Forms\Components\TextInput::make('email')
                        ->label('Correo Electrónico')
                        ->email() // Valida formato de correo
                        ->unique(ignoreRecord: true) // Valida que no se repita en la BD
                        ->maxLength(255),
                    // -----------------------------------
                    
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Fecha de Nacimiento')
                        ->required(),
                    
                    Forms\Components\Select::make('gender')
                        ->label('Sexo / Género')
                        ->options([
                            'M' => 'Masculino',
                            'F' => 'Femenino',
                            'O' => 'Otro',
                        ])
                        ->required(),
                    
                    Forms\Components\TextInput::make('phone')
                        ->label('Teléfono')
                        ->tel()
                        ->numeric() // Validación numérica requerida por el checklist
                        ->required(),
                    
                    Forms\Components\TextInput::make('curp')
                        ->label('CURP')
                        ->maxLength(18),
                    
                    Forms\Components\TextInput::make('emergency_contact')
                        ->label('Contacto de Emergencia')
                        ->required(),
                ])->columns(2), // Dos columnas para que se vea ordenado

            Forms\Components\Section::make('Información Médica')
                ->schema([
                    Forms\Components\Textarea::make('address')
                        ->label('Domicilio Completo')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TagsInput::make('allergies')
                        ->label('Alergias')
                        ->placeholder('Escribe y presiona enter')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\Textarea::make('chronic_diseases')
                        ->label('Enfermedades Crónicas')
                        ->columnSpanFull(),
                ]),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                // --- CORRECCIÓN AQUÍ ---
            // Cambiamos TextInput (Formulario) por TextColumn (Tabla)
            Tables\Columns\TextColumn::make('email')
                ->label('Correo')
                ->icon('heroicon-m-envelope') // Icono opcional decorativo
                ->searchable(),
            // -----------------------
                
                // --- CORRECCIÓN: Cálculo manual de edad ---
            Tables\Columns\TextColumn::make('birth_date')
                ->label('Edad')
                ->sortable()
                // Usamos Carbon para calcular la edad exacta
                ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->age . ' años'),
            // ------------------------------------------

                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->icon('heroicon-m-phone'),

                // Mostramos las alergias como badges rojos (alerta)
                Tables\Columns\TextColumn::make('allergies')
                    ->label('Alergias')
                    ->badge()
                    ->color('danger')
                    ->separator(','),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(), // Agregamos "Ver" para ver los detalles ocultos
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
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}