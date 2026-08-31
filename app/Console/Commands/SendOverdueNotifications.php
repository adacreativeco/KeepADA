<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaintenanceTask;
use App\Models\User;

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
                
                // E-posta gönderimi
                try {
                    if (class_exists(\App\Mail\TaskAssignedMail::class)) {
                        \Illuminate\Support\Facades\Mail::to($user->email)
                            ->send(new \App\Mail\TaskAssignedMail($task));
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Gecikme maili gönderilemedi: ' . $e->getMessage());
                }
            }
        }

        $this->info(count($overdueTasks) . ' adet gecikmiş görev için bildirim kontrolü yapıldı.');
    }
}
