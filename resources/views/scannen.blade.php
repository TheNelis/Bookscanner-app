<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scannen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container bg-white p-6 text-center shadow-sm sm:rounded-lg">
                <h1 class="title">Boek Barcode Scanner</h1>
                <div id="scanner-container" class="viewport">
                    <video class="videoCamera" autoplay="true" preload="auto" src="" muted="true" playsinline="true"></video>
                    <canvas class="drawingBuffer" style="z-index: -10000"></canvas>
                </div>
                <div id="result">Scan uw boek</div>
                <a href='/' id='boekButton' class="button hidden m-auto">Bekijk boek</a>
            </div>
        </div>
    </div>
</x-app-layout>
