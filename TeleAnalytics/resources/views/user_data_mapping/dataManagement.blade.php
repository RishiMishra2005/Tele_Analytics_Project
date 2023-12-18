<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS (you can replace this with your own styling) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        h1 {
            color: #007bff;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    </head>
    <body>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Data Plan') }}
            <x-primary-button class="ms-4" onclick="addPlan()">
                {{ __('Add Data Plan') }}
            </x-primary-button>
        </h2>

    </x-slot>
    <div class="container">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cost</th>
                    <th>Validity</th>
                    <th>Data Per Day</th>
                    <th>Desciption</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr id="add_plan" style="display: none;">
                <form method="POST" action="{{ route('user_data_mapping.saveDataPlan') }}">
                    @csrf
                    <input type=hidden id="plan_id" name="plan_id">
                    <td ></td>
                    <td><x-text-input id="price" name="price"  class="block mt-1 w-1/3" type="text"  required/>
                    <x-input-error :messages="$errors->get('price')" class="mt-2" /></td>
                    <td><x-text-input id="valid" name="valid" class="block mt-1 w-1/3" type="number"  required/>
                    <x-input-error :messages="$errors->get('valid')" class="mt-2" /></td>
                    <td><x-text-input id="data" name="data"  class="block mt-1 w-1/3" type="number"  required/>
                    <x-input-error :messages="$errors->get('data')" class="mt-2" /></td>
                    <td><textarea id="desc" name="desc" class="block mt-1 " type="text"  required></textarea>
                    <x-input-error :messages="$errors->get('desc')" class="mt-2" /></td>
                    <td><input  id="active" name="active" type="checkbox" checked>
                    <x-input-error :messages="$errors->get('active')" class="mt-2" /></td>   
                    <td>
                        
                        <x-primary-button class="ms-4" >
                            {{ __('Save') }}
                        </x-primary-button>
                        <x-primary-button class="ms-4" onclick="removePlan()">
                            {{ __('Cancel') }}
                        </x-primary-button>
                    </td>
                </form>
                </tr>
                @foreach($dataPlans as $dataPlan)
                    <tr>
                    <form method="POST" action="{{ route('user_data_mapping.update') }}">
                    @csrf
                    <input type=hidden id="id" name="id" value="{{ $dataPlan->id }}">
                        <td >{{ $dataPlan->id }}</td>
                        <td><x-text-input id="cost" name="cost" value="{{ $dataPlan->cost }}" class="block mt-1 w-1/3" type="text"  required/>
                        <x-input-error :messages="$errors->get('cost')" class="mt-2" /></td>
                        <td><x-text-input id="validity" name="validity" value="{{ $dataPlan->validity }}" class="block mt-1 w-1/3" type="number"  required/>
                        <x-input-error :messages="$errors->get('validity')" class="mt-2" /></td>
                        <td><x-text-input id="data_per_day" name="data_per_day" value="{{ $dataPlan->data_per_day }}" class="block mt-1 w-1/3" type="number"  required/>
                        <x-input-error :messages="$errors->get('data_per_day')" class="mt-2" /></td>
                        <td><textarea id="description" name="description" value="{{ $dataPlan->description }}" class="block mt-1 " type="text"  required>{{ $dataPlan->description }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" /></td>
                        <td><input  id="is_active" name="is_active" type="checkbox" {{ $dataPlan->is_active == 'Yes' ? 'checked' : '' }}>
                        <x-input-error :messages="$errors->get('is_active')" class="mt-2" /></td>   
                        <td>
                            
                            <x-primary-button class="ms-4" >
                                {{ __('Update') }}
                            </x-primary-button>
                        </td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional, if you need JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</x-app-layout>
<script>
    function addPlan(){
        document.getElementById("add_plan").style.display='table-row';
    }
    function removePlan(){
        document.getElementById("add_plan").style.display='none';
    }
</script>