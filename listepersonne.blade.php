@extends ('modeles/visiteur')
    @section('contenu1')
        $id="";
        <div class="container text-center contenu" id="contenu">
            <div class=" corpsForm row">
                <div class="col">
                    <h1>liste des visiteurs</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nom</th>
                                <th>Prenom</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($liste as $unliste)
                            <tr>
                                <td>{{$unliste['id']}}</td>
                                <td>{{$unliste['nom']}}</td>
                                <td>{{$unliste['prenom']}}</td>
                                <td>
                                    <a href="{{Route('modifieruser', ['id'=>$unliste['id']])}}" class="btn btn-primary">Modifier</a>
                                    <a href="{{Route('supprimeruser',['id'=>$unliste['id']])}}" class="btn btn-info">Supprimer</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table><hr>
                        <a href="{{Route('ajouteruser')}}" class="btn btn-secondary">Ajouter un utilisateur</a>
                        
</div>
@endsection