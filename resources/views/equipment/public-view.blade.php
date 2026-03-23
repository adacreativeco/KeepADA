<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $equipment->name }} - Ekipman Detayı</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="p-8">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ $equipment->category }}</div>
            <h1 class="block mt-1 text-lg leading-tight font-medium text-black">{{ $equipment->name }}</h1>
            <p class="mt-2 text-gray-500">Kod: {{ $equipment->code }}</p>
            
            <div class="mt-4 border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span class="font-bold">Durum:</span>
                    <span class="px-2 py-1 rounded text-xs font-bold {{ $equipment->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $equipment->status === 'active' ? 'Aktif' : 'Pasif' }}
                    </span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-bold">Lokasyon:</span>
                    <span>{{ $equipment->location->name }}</span>
                </div>
                @if($equipment->supplier)
                <div class="flex justify-between mb-2">
                    <span class="font-bold">Tedarikçi:</span>
                    <span>{{ $equipment->supplier->name }}</span>
                </div>
                @endif
                <div class="flex justify-between mb-2 text-indigo-600 font-bold">
                    <span>Tahmini Bakım:</span>
                    <span>{{ $equipment->predictive_next_due_date?->format('d.m.Y') ?? 'Hesaplanıyor...' }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-bold">Garanti Bitiş:</span>
                    <span>{{ $equipment->warranty_end_date?->format('d.m.Y') ?? 'Belirtilmedi' }}</span>
                </div>
            </div>

            <div class="mt-6">
                <h2 class="text-md font-bold mb-2">Son Bakımlar</h2>
                <ul class="space-y-2">
                    @foreach($equipment->maintenanceTasks()->latest('completed_at')->take(3)->get() as $task)
                        <li class="text-sm p-2 bg-gray-50 rounded">
                            <div class="flex justify-between">
                                <span>{{ $task->title }}</span>
                                <span class="text-gray-400">{{ $task->completed_at?->format('d.m.Y') }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-8 text-center">
                <a href="/admin/login" class="text-indigo-600 hover:underline text-sm">Sisteme Giriş Yap</a>
            </div>
        </div>
    </div>
</body>
</html>