<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS (you can replace this with your own styling) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/css/bootstrap.min.css">
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
            {{ __('Select Data Plan') }}
        </h2>
    </x-slot>
    <div class="container">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Cost</th>
                    <th>Desciption</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dataPlans as $dataPlan)
                    <tr>
                    <form method="POST" action="{{ route('user_data_mapping.store') }}"> 
                        @csrf
                        <input type="hidden" name="data_plan_id" id="data_plan_id" value="{{ $dataPlan->id }}">
                        <td>{{ $dataPlan->id }}</td>
                        <td>{{ $dataPlan->cost }}</td>
                        <td>{{ $dataPlan->description }}</td>
                        <td><x-primary-button class="ms-4">
                                {{ __('Select') }}
                            </x-primary-button></td>
                    </form>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (optional, if you need JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</x-app-layout>