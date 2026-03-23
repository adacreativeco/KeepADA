<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\MaintenanceTask;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class SendOverdueNotifications extends Command
{
    protected $signature = 'app:send-overdue-notifications';
    protected $description = 'Gecikmiş bakım görevleri için teknisyenlere ve yöneticilere bildirim gönderir.';

    public function handle()
    {
        $overdueTasks = MaintenanceTask::where('status', '!=', 'done')
            ->where('scheduled_date', '<', now())
            ->get();

        foreach ($overdueTasks as $task) {
            if ($task->assigned_to) {
                $user = User::find($task->assigned_to);
                
                Notification::make()
                    ->title('Gecikmiş Bakım Görevi!')
                    ->body("{$task->equipment->name} için planlanan bakımın tarihi geçti.")
                    ->danger()
                    ->actions([
                        Action::make('view')
                            ->label('Görüntüle')
                            ->url(route('filament.admin.resources.maintenance-tasks.view', [
                                'tenant' => $task->company,
                                'record' => $task,
                            ])),
                    ])
                    ->sendToDatabase($user);
            }
        }

        $this->info(count($overdueTasks) . ' adet gecikmiş görev için bildirim gönderildi.');
    }
}
