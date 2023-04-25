<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl">New Invoice has been created for you</h2>
                    <div class="flex justify-between">
                        <div class="flex flex-col gap-2 mt-3">
                            <span class="font-semibold">Serial Number</span>
                            <span>#{{ $invoice->serial_number}}</span>
                        </div>
                        <div class="flex flex-col gap-2 mt-3">
                            <span class="font-semibold">Product</span>
                            <span>{{ $invoice->product->product_name}}</span>
                        </div>

                        <div class="flex flex-col gap-2 mt-3">
                            <span class="font-semibold">Price</span>
                            <span>{{ $invoice->total}}</span>
                        </div>
                    </div>
                </div>
                <form action="{{ route('invoice.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-primary w-full py-3 text-lg">
                        Proceed to Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

