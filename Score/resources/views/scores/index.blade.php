<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>
<body>

<h1>Leaderboard - Tournoi Jeux Vidéo</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<!-- Formulaire Add -->
<h2>Ajouter un score</h2>
<form action="{{ route('scores.store') }}" method="POST">
    @csrf
    <input type="text" name="player_name" placeholder="Nom du joueur" required>
    <input type="number" name="points" placeholder="Points" min="0" required>
    <button type="submit">Ajouter</button>
</form>

<hr>

<!-- Liste des scores -->
<h2>Tableau des scores</h2>

@if($scores->isEmpty())
    <p>Aucun score enregistré.</p>
@else
    <table border="2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Joueur</th>
                <th>Points</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scores as $index => $score)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $score->player_name }}</td>
                    <td>{{ $score->points }}</td>
                    <td>
                        <form action="{{ route('scores.destroy', $score) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer ce score ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</body>
</html>