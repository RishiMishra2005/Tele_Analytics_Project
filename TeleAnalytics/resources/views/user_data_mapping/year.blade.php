<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<x-app-layout>
<form method="get" action="{{ route('user_data_mapping.yearAnalysis') }}">
    @csrf
    <div class="mt-4">
        <x-input-label style="font-size: large;" for="start_year" :value="__('Start Year')" />
        <x-text-input id="start_year" class="block mt-1 w-1/3" type="number" min="2000" max="2099" value="2019" step="1" name="start_year"/>
        <x-input-label style="font-size: large;" for="end_year" :value="__('End Year')" />
        <x-text-input id="end_year" class="block mt-1 w-1/3" type="number" min="2000" max="2099" value="2023" step="1" name="end_year"/>
        <br /></select><x-primary-button class="ms-4" >
            {{ __('Search') }}
        </x-primary-button><br><br>
    </div>

    <canvas id="revenueChart" ></canvas>
</form>
</x-app-layout>

<script>

    var revenueData = <?php echo json_encode($result);?>;
    console.log(revenueData);
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(revenueData),
            datasets: [{
                label: 'Yearly Revenue',
                data: Object.values(revenueData),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('start_year').addEventListener('change', function() {
        
        if(this.value>document.getElementById('end_year').value){
            alert('Start Year should be less than End Year');
            document.getElementById('start_year').value = sessionStorage.getItem('selectedStart');;
        }
        else{
            sessionStorage.setItem('selectedStart', this.value);
        }
    });

    // Retrieve the selected value from session storage on page load
    window.addEventListener('load', function() {
        var selectedOption = sessionStorage.getItem('selectedStart');
        if (selectedOption) {
            document.getElementById('start_year').value = selectedOption;
        }
    });
    document.getElementById('end_year').addEventListener('change', function() {
        
        if(document.getElementById('start_year').value>this.value){
            document.getElementById('end_year').value = sessionStorage.getItem('selectedEnd');
            alert('Start Year should be less than End Year');
        }
        else{
            sessionStorage.setItem('selectedEnd', this.value);
        }
    });

    // Retrieve the selected value from session storage on page load
    window.addEventListener('load', function() {
        var selectedOption = sessionStorage.getItem('selectedEnd');
        if (selectedOption) {
            document.getElementById('end_year').value = selectedOption;
        }
    });
    
</script>
