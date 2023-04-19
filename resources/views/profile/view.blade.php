<x-app-layout>

    <div x-data="{
        flashMessage: '{{ \Illuminate\Support\Facades\Session::get('flash_message') }}',
        init() {
            if (this.flashMessage) {
                setTimeout(() => this.$dispatch('notify', { message: this.flashMessage }), 200)
            }
        }
    }" class="container mx-auto lg:w-2/3 p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="bg-white p-3 shadow rounded-lg md:col-span-2">
                <form x-data="{
                    countries: {{ json_encode($countries) }},
                    billingAddress: {{ json_encode([
                        'address1' => old('billing.address1', $billingAddress->address1),
                        'address2' => old('billing.address2', $billingAddress->address2),
                        'city' => old('billing.city', $billingAddress->city),
                        'state' => old('billing.state', $billingAddress->state),
                        'country_code' => old('billing.country_code', $billingAddress->country_code),
                        'zipcode' => old('billing.zipcode', $billingAddress->zipcode),
                    ]) }},
                    invoicingAddress: {{ json_encode([
                        'address1' => old('invoicing.address1', $invoicingAddress->address1),
                        'address2' => old('invoicing.address2', $invoicingAddress->address2),
                        'city' => old('invoicing.city', $invoicingAddress->city),
                        'state' => old('invoicing.state', $invoicingAddress->state),
                        'country_code' => old('invoicing.country_code', $invoicingAddress->country_code),
                        'zipcode' => old('invoicing.zipcode', $invoicingAddress->zipcode),
                    ]) }},
                    get billingCountryStates() {
                        const country = this.countries.find(c => c.code === this.billingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    },
                    get invoicingCountryStates() {
                        const country = this.countries.find(c => c.code === this.invoicingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    }
                }" action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <h2 class="text-xl font-semibold mb-2">Profile Details</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <x-text-input type="text" name="first_name"
                            value="{{ old('first_name', $customer->first_name) }}" placeholder="First Name"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        <x-text-input type="text" name="last_name"
                            value="{{ old('last_name', $customer->last_name) }}" placeholder="Last Name"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>
                    <div class="mb-3">
                        <x-text-input type="text" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="Your Email"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>
                    <div class="mb-3">
                        <x-text-input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                            placeholder="Your Phone"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>

                    <h2 class="text-xl mt-6 font-semibold mb-2">Billing Address</h2>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="text" name="billing[address1]" x-model="billingAddress.address1"
                                placeholder="Address 1"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                        <div>
                            <x-text-input type="text" name="billing[address2]" x-model="billingAddress.address2"
                                placeholder="Address 2"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="text" name="billing[city]" x-model="billingAddress.city"
                                placeholder="City"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                        <div>
                            <x-text-input type="text" name="billing[zipcode]" x-model="billingAddress.zipcode"
                                placeholder="ZipCode"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="select" name="billing[country_code]"
                                x-model="billingAddress.country_code"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                                <option value="">Select Country</option>
                                <template x-for="country of countries" :key="country.code">
                                    <option :selected="country.code === billingAddress.country_code"
                                        :value="country.code" x-text="country.name"></option>
                                </template>
                            </x-text-input>
                        </div>
                        <div>
                            <template x-if="billingCountryStates">
                                <x-text-input type="select" name="billing[state]" x-model="billingAddress.state"
                                    class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                                    <option value="">Select State</option>
                                    <template x-for="[code, state] of Object.entries(billingCountryStates)"
                                        :key="code">
                                        <option :selected="code === billingAddress.state" :value="code"
                                            x-text="state"></option>
                                    </template>
                                </x-text-input>
                            </template>
                            <template x-if="!billingCountryStates">
                                <x-text-input type="text" name="billing[state]" x-model="billingAddress.state"
                                    placeholder="State"
                                    class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6 mb-2">
                        <h2 class="text-xl font-semibold">Invoicing Address</h2>
                        <label for="sameAsBillingAddress" class="text-gray-700">
                            <input @change="$event.target.checked ? invoicingAddress = {...billingAddress} : ''"
                                id="sameAsBillingAddress" type="checkbox"
                                class="text-purple-600 focus:ring-purple-600 mr-2"> Same as Billing
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="text" name="invoicing[address1]" x-model="invoicingAddress.address1"
                                placeholder="Address 1"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                        <div>
                            <x-text-input type="text" name="invoicing[address2]" x-model="invoicingAddress.address2"
                                placeholder="Address 2"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="text" name="invoicing[city]" x-model="invoicingAddress.city"
                                placeholder="City"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                        <div>
                            <x-text-input name="invoicing[zipcode]" x-model="invoicingAddress.zipcode" type="text"
                                placeholder="ZipCode"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <x-text-input type="select" name="invoicing[country_code]"
                                x-model="invoicingAddress.country_code"
                                class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                                <option value="">Select Country</option>
                                <template x-for="country of countries" :key="country.code">
                                    <option :selected="country.code === invoicingAddress.country_code"
                                        :value="country.code" x-text="country.name"></option>
                                </template>
                            </x-text-input>
                        </div>
                        <div>
                            <template x-if="invoicingCountryStates">
                                <x-text-input type="select" name="invoicing[state]" x-model="invoicingAddress.state"
                                    class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded">
                                    <option value="">Select State</option>
                                    <template x-for="[code, state] of Object.entries(invoicingCountryStates)"
                                        :key="code">
                                        <option :selected="code === invoicingAddress.state" :value="code"
                                            x-text="state"></option>
                                    </template>
                                </x-text-input>
                            </template>
                            <template x-if="!invoicingCountryStates">
                                <x-text-input type="text" name="invoicing[state]" x-model="invoicingAddress.state"
                                    placeholder="State"
                                    class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                            </template>
                        </div>
                    </div>

                    <x-primary-button class="w-full">Update</x-primary-button>
                </form>
            </div>
            <div class="bg-white p-3 shadow rounded-lg">
                <form action="" method="post">
                    {{-- {{ route('profile_password.update') }} --}}
                    @csrf
                    <h2 class="text-xl font-semibold mb-2">Update Password</h2>
                    <div class="mb-3">
                        <x-text-input type="password" name="old_password" placeholder="Your Current Password"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>
                    <div class="mb-3">
                        <x-text-input type="password" name="new_password" placeholder="New Password"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>
                    <div class="mb-3">
                        <x-text-input type="password" name="new_password_confirmation"
                            placeholder="Repeat New Password"
                            class="w-full focus:border-purple-600 focus:ring-purple-600 border-gray-300 rounded" />
                    </div>
                    <x-primary-button>Update</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
