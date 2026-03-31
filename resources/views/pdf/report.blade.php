<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">
    <main class="px-8 py-20">
        <section class="mb-6">
            <div class="rounded-2xl bg-linear-to-r from-blue-700 to-indigo-600 p-8 text-white shadow">
                <h1 class="text-3xl font-bold">{{ $title }}</h1>
                <p class="mt-2 text-sm text-blue-100">{{ $subtitle }}</p>
                <p class="mt-4 text-xs text-blue-100">Gerado em {{ $generatedAt }}</p>
            </div>
        </section>

        <section class="grid grid-cols-3 gap-4 mb-6">
            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                <div class="text-xs uppercase tracking-wide text-slate-500">Registros</div>
                <div class="mt-2 text-2xl font-bold">{{ $items->count() }}</div>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                <div class="text-xs uppercase tracking-wide text-slate-500">Total vendido</div>
                <div class="mt-2 text-2xl font-bold">
                    R$ {{ number_format($total, 2, ',', '.') }}
                </div>
            </div>

            <div class="rounded-2xl bg-white p-5 shadow-sm border border-slate-200">
                <div class="text-xs uppercase tracking-wide text-slate-500">Média</div>
                <div class="mt-2 text-2xl font-bold">
                    R$ {{ number_format($items->avg('valor'), 2, ',', '.') }}
                </div>
            </div>
        </section>

        <section class="rounded-2xl bg-white shadow-sm border border-slate-200 overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="text-sm font-semibold text-slate-700">Detalhamento</h2>
            </div>

            <table class="min-w-full text-sm">
                <thead class="bg-slate-100 text-slate-600">
                    <tr>
                        <th class="px-6 py-4 text-left font-semibold">Cliente</th>
                        <th class="px-6 py-4 text-left font-semibold">E-mail</th>
                        <th class="px-6 py-4 text-left font-semibold">Data</th>
                        <th class="px-6 py-4 text-right font-semibold">Valor</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($items as $item)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $item['cliente'] }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $item['email'] }}</td>
                            <td class="px-6 py-4 text-slate-600">
                                {{ \Carbon\Carbon::parse($item['data'])->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-right font-semibold">
                                R$ {{ number_format($item['valor'], 2, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <section class="mt-6 flex justify-end">
            <div class="w-72 rounded-2xl bg-slate-900 text-white p-5 shadow">
                <div class="flex items-center justify-between text-sm">
                    <span>Total geral</span>
                    <span class="text-lg font-bold">
                        R$ {{ number_format($total, 2, ',', '.') }}
                    </span>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
