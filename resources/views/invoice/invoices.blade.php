<x-app-layout>
    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">My Invoices</h1>

        <div class="bg-white p-3 rounded-md shadow-md">
          <table class="table table-auto w-full">
            <thead class="border-b-2">
              <tr class="text-left">
                <th>Invoice</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th class="w-64">Actions</th>
              </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
              <tr class="border-b">
                <td>
                  <a
                    href="{{route('invoices.view', $invoice)}}"
                    class="text-purple-600 hover:text-purple-500"
                  >
                    {{$invoice->serial_number}}
                  </a>
                </td>
                <td>{{$invoice->created_at}}</td>
                <td>
                  <small class="text-white px-2 py-2 rounded 
                  {{$invoice->isPaid() ? 'bg-emerald-500' : 'bg-gray-500'}}">{{$invoice->status}}</small>
                </td>
                <td>{{ $invoice->total}}</td>
                <td class="flex gap-3">
                  <div>
                    @if(!$invoice->isPaid())
                    <form action="{{ route('invoice.archive', $invoice)}}" method="POST">
                      @method('DELETE')
                      @csrf
                      <button
                      @click="open = false"
                      class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 py-1 px-2 flex items-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>
                      Archive
                    </button>
                    </form>
                    @elseif($invoice->isPaid())
                    <a
                    href="{{route('invoices.view', $invoice)}}"
                      class="btn-primary bg-blue-500 hover:bg-blue-600 active:bg-emerald-700 py-1 px-2 flex items-center"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 mr-1"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                        />
                      </svg>
                      View Invoice
                    </a>
                    @endif
                    
                  </div>
                  @if(!$invoice->isPaid() && !$invoice->isCancelled())
                  <form action="{{ route('cart.checkout-invoice', $invoice)}}" method="POST">
                    @csrf
                    <button class="btn-primary py-1 px-2 flex items-center">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          class="h-6 w-6 mr-1"
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
                        Pay
                      </button>
                  </form>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-3">
            {{ $invoices->links() }}
        </div>
      </div>
</x-app-layout>