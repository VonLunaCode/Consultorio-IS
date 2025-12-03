<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Agenda de Citas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // BUSCADOR DE PACIENTES (SP2-HU3)
                Forms\Components\Select::make('patient_id')
                    ->label('Paciente')
                    ->relationship('patient', 'name')
                    ->searchable() // Hace que se pueda escribir para buscar
                    ->preload() // Carga los primeros resultados para que sea rápido
                    ->required()
                    ->createOptionForm([ // Opcional: Permite crear un paciente rápido desde la cita
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('phone')->required(),
                        // ... campos minimos para registro rápido
                    ]),

                // VALIDACIÓN DE FECHA (Checklist)
                Forms\Components\DateTimePicker::make('scheduled_at')
                    ->label('Fecha y Hora')
                    ->required()
                    // CORRECCIÓN CLAVE:
                    // 1. native(false) usa el calendario de Filament (evita error del navegador)
                    // 2. startOfMinute() evita conflictos con los segundos actuales
                    ->native(false)
                    ->minDate(now()->startOfMinute()) 
                    ->seconds(false),

                Forms\Components\Select::make('status')
                    ->label('Estatus')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmada' => 'Confirmada',
                        'cancelada' => 'Cancelada',
                        'finalizada' => 'Finalizada',
                    ])
                    ->default('pendiente')
                    ->required(),

                Forms\Components\Textarea::make('reason')
                    ->label('Motivo de Consulta')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y h:i A') // Formato amigable (12h con AM/PM)
                    ->sortable(),

                Tables\Columns\TextColumn::make('patient.name')
                    ->label('Paciente')
                    ->searchable()
                    ->sortable(),

                // CÓDIGO DE COLORES PARA ESTATUS
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pendiente' => 'warning',
                        'confirmada' => 'info',
                        'finalizada' => 'success',
                        'cancelada' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('reason')
                    ->label('Motivo')
                    ->limit(30), // Muestra un resumen corto
            ])
            ->defaultSort('scheduled_at', 'desc') // Ordenar por fecha más reciente
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'confirmada' => 'Confirmada',
                        'finalizada' => 'Finalizada',
                    ]),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}