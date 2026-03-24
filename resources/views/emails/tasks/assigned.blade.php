<x-mail::message>
# Yeni Bakım Görevi Atandı

Merhaba {{ $task->assignedUser->name }},

Size yeni bir bakım görevi atandı. Detaylar aşağıdadır:

**Görev:** {{ $task->title }}
**Ekipman:** {{ $task->equipment->name }}
**Planlanan Tarih:** {{ $task->scheduled_date->format('d.m.Y') }}
**Öncelik:** {{ match($task->priority) {
    'low' => 'Düşük',
    'medium' => 'Orta',
    'high' => 'Yüksek',
    'critical' => 'Kritik',
    default => $task->priority
} }}

<x-mail::button :url="route('filament.admin.resources.maintenance-tasks.view', ['tenant' => $task->company, 'record' => $task])">
Görevi Görüntüle
</x-mail::button>

İyi çalışmalar,<br>
{{ config('app.name') }}
</x-mail::message>
