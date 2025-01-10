<?php

namespace App\Filament\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class ChangePasswordAction extends Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'changePassword';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Şifre Değiştir');

        $this->form([
            TextInput::make('password')
                ->label('Şifre')
                ->password()
                ->required()
        ]);

        $this->modalIcon('heroicon-o-lock-closed');

        $this->requiresConfirmation();

        $this->color('info');

        $this->action(function (array $data): void {
            $result = $this->process(static fn (Model $record) => $record->update([
                'password' => bcrypt($data['password'])
            ]));

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
