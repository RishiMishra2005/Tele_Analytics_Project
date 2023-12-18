<x-app-layout>
<form method="get" action="{{ route('user_data_mapping.stateAnalysis') }}">
    @csrf
    <div class="mt-4">
        <select id="state" class="block z-50 mt-1  rounded-md w-1/4" style="border-color: gray;" name="state" :value="old('state')" required>
            <option value="--Select State--">--Select State--</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Gujrat">Gujrat</option>
            <option value="West Bengal">West Bengal</option>
        </select><x-primary-button class="ms-4" >
            {{ __('Search') }}
        </x-primary-button><br><br>
        @if(isset($result))
            <x-input-label :value="__('Total Customers')" />
            <x-text-input value="{{$result['totalCustomer']}}" class="block mt-1 w-1/3" type="text" disabled /><br>
            <x-input-label :value="__('Total Revenue')" />
            <x-text-input value="{{$result['revenue']}}" class="block mt-1 w-1/3" type="text" disabled /><br>
            <x-input-label :value="__('Most Used Plan')" />
            <x-text-input value="{{$result['mostUsedPlan']}}" class="block mt-1 w-1/3" type="text" disabled />
        @else
            <x-input-label :value="__('Total Customers')" />
            <x-text-input value=0 class="block mt-1 w-1/3" type="text" disabled /><br>
            <x-input-label :value="__('Total Revenue')" />
            <x-text-input value=0 class="block mt-1 w-1/3" type="text" disabled /><br>
            <x-input-label :value="__('Most Used Plan')" />
            <x-text-input value=0 class="block mt-1 w-1/3" type="text" disabled />
        @endif       
    </div>
</form>
</x-app-layout>
<script>
    // Save the selected value to session storage when the dropdown changes
    document.getElementById('state').addEventListener('change', function() {
        sessionStorage.setItem('selectedOption', this.value);
    });

    // Retrieve the selected value from session storage on page load
    window.addEventListener('load', function() {
        var selectedOption = sessionStorage.getItem('selectedOption');
        if (selectedOption) {
            document.getElementById('state').value = selectedOption;
        }
    });
</script>
