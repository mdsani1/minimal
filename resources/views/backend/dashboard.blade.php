<x-backend.layouts.master>

    <x-slot name="page_title">
        Dashboard
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between">
            <h1 class="mt-4">Dashboard</h1>
            <a href="/database-backup" class="btn btn-sm btn-success mt-4" style="height: 40px">Database Backup</a>

        </div>
        <x-backend.layouts.elements.message :message="session('message')"/>
        <x-backend.layouts.elements.errors :errors="$errors"/>
        <ol class="breadcrumb mb-4">
            {{ $slot  ?? ''}}
        </ol>
    </x-slot>

    @push('css')
        <link rel="stylesheet" href={{asset("ui/dist/css/adminlte.min.css")}}>
    @endpush
</x-backend.layouts.master>