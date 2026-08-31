<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MaintenancePlan;
use App\Models\MaintenanceTask;
use Carbon\Carbon;

class GenerateMaintenanceTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keepada:generate-maintenance-tasks {--company= : Specific company ID or slug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vadesi gelen veya sayaç limiti dolan periyodik bakım planlarından otomatik iş emri oluşturur.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Periyodik bakım planları taranıyor...');

        $query = MaintenancePlan::where('is_active', true)->with(['equipment', 'company']);

        if ($companyId = $this->option('company')) {
            $query->whereHas('company', function ($q) use ($companyId) {
                $q->where('id', $companyId)->orWhere('slug', $companyId);
            });
        }

        $plans = $query->get();
        $generatedCount = 0;
        $now = Carbon::now();

        foreach ($plans as $plan) {
            $shouldGenerate = false;

            // 1. Tarih bazlı kontrol
            if ($plan->next_due_date && $plan->next_due_date->lte($now->endOfDay())) {
                $shouldGenerate = true;
            }

            // 2. Sayaç bazlı kontrol (eğer sayaç aralığı tanımlıysa)
            if ($plan->meter_interval && $plan->equipment && $plan->equipment->current_meter_reading) {
                // Ekipmanın son sayaç okuması ile plan aralığı karşılaştırması
                $lastTask = MaintenanceTask::where('maintenance_plan_id', $plan->id)
                    ->where('status', 'done')
                    ->latest('completed_at')
                    ->first();

                // Eğer daha önce bakım yapılmadıysa veya aralık dolduysa
                if (!$lastTask) {
                    $shouldGenerate = true;
                }
            }

            if (!$shouldGenerate) {
                continue;
            }

            // Halihazırda açık (bekleyen veya devam eden) mükerrer görev var mı?
            $existingOpenTask = MaintenanceTask::where('maintenance_plan_id', $plan->id)
                ->whereIn('status', ['pending', 'in_progress'])
                ->exists();

            if ($existingOpenTask) {
                $this->line("  [Atlandı] Plan #{$plan->id} ({$plan->title}) için açık bir iş emri zaten mevcut.");
                continue;
            }

            // Yeni iş emri oluştur
            $task = MaintenanceTask::create([
                'company_id' => $plan->company_id,
                'equipment_id' => $plan->equipment_id,
                'maintenance_plan_id' => $plan->id,
                'assigned_to' => $plan->assigned_to,
                'title' => $plan->title,
                'type' => 'preventive',
                'priority' => 'medium',
                'status' => 'pending',
                'scheduled_date' => $plan->next_due_date ?? $now->toDateString(),
                'notes' => $plan->description ?: 'Periyodik bakım planından otomatik oluşturuldu.',
            ]);

            // Bir sonraki bakım tarihini hesapla ve güncelle
            $nextDate = $plan->next_due_date ? Carbon::parse($plan->next_due_date) : $now->copy();
            $freqVal = $plan->frequency_value ?: 1;

            switch ($plan->frequency_type) {
                case 'daily':
                    $nextDate->addDays($freqVal);
                    break;
                case 'weekly':
                    $nextDate->addWeeks($freqVal);
                    break;
                case 'monthly':
                    $nextDate->addMonths($freqVal);
                    break;
                case 'quarterly':
                    $nextDate->addMonths($freqVal * 3);
                    break;
                case 'yearly':
                    $nextDate->addYears($freqVal);
                    break;
                default:
                    $nextDate->addMonths($freqVal);
            }

            $plan->update([
                'next_due_date' => $nextDate->toDateString(),
            ]);

            $this->info("  [Oluşturuldu] İş Emri #{$task->id} -> {$plan->title} ({$plan->equipment->name}) | Sonraki Bakım: {$nextDate->format('d.m.Y')}");
            $generatedCount++;
        }

        $this->info("Tarama tamamlandı. Toplam {$generatedCount} yeni iş emri başarıyla oluşturuldu.");

        return Command::SUCCESS;
    }
}
