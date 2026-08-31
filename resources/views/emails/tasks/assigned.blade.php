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

<x-mail::button :url="route('panel.tasks.show', ['company' => $task->company->slug, 'task' => $task->id])">
Görevi Görüntüle
</x-mail::button>

İyi çalışmalar,<br>
{{ config('app.name') }}
</x-mail::message>
