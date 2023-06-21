<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        #pokemons,
        #search {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 80%;
            margin-left: 10%;
            margin-right: 10%;
        }


        #pokemons tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        #pokemons td,
        #pokemons th {
            padding: 8px;
            height: 20;
        }

        #pokemons th {
            border-bottom: 2px solid #ddd;
            text-align: left;
            background-color: #FFFFFF;
        }

        #logo-pokemon img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        #action {
            margin-right: auto;
            width: 100%;
        }

        #search_name {
            border: 1px solid #CECECE;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div id="logo-pokemon">
        <img height="200px" src="https://user-images.githubusercontent.com/69367907/105195232-72462e00-5b08-11eb-9bd0-dfa95f8e7e9a.png" alt="">
    </div>
    <div id="search"><label>Search:<input id="search_name" class="" placeholder="" aria-controls="example"></label></div>
    &nbsp;
    <table id="pokemons">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Experience</th>
                <th>Weight</th>
                <th>Abilities</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pokemons as $pokemon)
            <tr>
                <td>{{ $pokemon->pokemon_id }}</td>
                <td>{{ $pokemon->name }}</td>
                @if($pokemon->base_experience <= 100) <td>{{ $pokemon->base_experience }} (junior)</td>
                    @else
                    <td>{{ $pokemon->base_experience }} (proffesional)</td>
                    @endif
                    @if($pokemon->weight <= 200) <td>{{ $pokemon->weight }} (light)</td>
                        @elseif($pokemon->weight > 200 && $pokemon->weight <= 300) <td>{{ $pokemon->weight }} (medium)</td>
                            @else
                            <td>{{ $pokemon->weight }} (heavy)</td>
                            @endif
                            <td>
                                @php
                                $push = [];
                                foreach($pokemon->abilities as $abb) {
                                $push[] = $abb->name;
                                }
                                @endphp

                                @forelse ($push as $ability)
                                {{ $ability }}
                                @if (!$loop->last)
                                ,
                                @endif
                                @empty
                                Tidak ada ability
                                @endforelse
                            </td>
                            <td><img src="{{ $pokemon->image_url }}" alt="Italian Trulli"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById('pokemons');
        const searchInput = document.getElementById('search_name');
        const rowsz = table.querySelectorAll('tbody tr');

        searchInput.addEventListener("input", function(e) {
            const searchValue = e.target.value.toLowerCase();
            rowsz.forEach(function(row) {
                tdName = row.getElementsByTagName("td")[1].textContent;
                console.log(tdName.toLowerCase(), tdName.toLowerCase().indexOf(searchValue));
                if (tdName.toLowerCase().indexOf(searchValue) <= -1) {
                    row.style.display = "none";
                } else {
                    row.style.display = "";
                }
            });
        });
    })
</script>

</html>