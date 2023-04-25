<x-app-layout>

        <div class="container mx-auto lg:w-2/3 p-5">
            <h1 class="text-3xl font-bold mb-2">Serial_number {{$invoice->serial_number}}</h1>
            <div class="bg-white rounded-lg p-3 flex justify-between">
                <table>
                    <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Invoice #</td>
                        <td>{{$invoice->id}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Invoice Date</td>
                        <td>{{$invoice->created_at}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Invoice Status</td>
                        <td>
                            <span
                                class="text-white py-1 px-2 rounded {{$invoice->isPaid() ? 'bg-emerald-500' : 'bg-gray-400'}}">
                                {{$invoice->status}}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Total</td>
                        <td>${{ $invoice->total }}</td>
                    </tr>
                    </tbody>
                </table>

                <table>
                    <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Gross price</td>
                        <td>{{$invoice->gross_price}}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Discount</td>
                        <td>{{$invoice->discount}}%</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">TVA</td>
                        <td>
                            {{$invoice->TVA}}%
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Product</td>
                        <td>{{ $invoice->product->product_name }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Customer</td>
                        <td>{{ $user->name}}</td>
                    </tr>
                    </tbody>
                </table>
    
                <hr class="my-5"/>
    
    
            </div>
            @if (!$invoice->isPaid())
            <form action="{{ route('cart.checkout-invoice', $invoice) }}"
                  method="POST">
                @csrf
                <button class="btn-primary flex items-center justify-center w-full mt-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                        />
                    </svg>
                    Make a Payment
                </button>
            </form>
        @endif
        </div>
</x-app-layout>