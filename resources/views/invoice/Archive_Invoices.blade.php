<x-app-layout>
    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class="text-3xl font-bold mb-6">My Archived Invoices</h1>

        <div class="bg-white p-3 rounded-md shadow-md">
          <table class="table table-auto w-full">
            <thead class="border-b-2">
              <tr class="text-left">
                <th>Invoice</th>
                <th>Archive Date</th>
                <th>Status</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
              <tr class="border-b">
                <td>
                  <span
                    class="text-purple-600 hover:text-purple-500"
                  >
                    {{$invoice->serial_number}}
                  </span>
                </td>
                <td>{{$invoice->deleted_at}}</td>
                <td>
                  <small class="text-white px-2 py-2 rounded 
                  {{$invoice->isPaid() ? 'bg-emerald-500' : 'bg-gray-500'}}">{{$invoice->status}}</small>
                </td>
                <td>{{ $invoice->total}}</td>
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