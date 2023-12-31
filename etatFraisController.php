<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PdoGsb;
use MyDate;
class etatFraisController extends Controller
{
    function selectionnerMois(){
        if(session('visiteur') != null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
		    // Afin de sélectionner par défaut le dernier mois dans la zone de liste
		    // on demande toutes les clés, et on prend la première,
		    // les mois étant triés décroissants
		    $lesCles = array_keys( $lesMois );
		    $moisASelectionner = $lesCles[0];
            return view('listemois')
                        ->with('lesMois', $lesMois)
                        ->with('leMois', $moisASelectionner)
                        ->with('visiteur',$visiteur);
        }
        else{
            return view('connexion')->with('erreurs',null);
        }

    }

    function voirFrais(Request $request){
        if( session('visiteur')!= null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            $leMois = $request['lstMois'];
		    $lesMois = PdoGsb::getLesMoisDisponibles($idVisiteur);
            $lesFraisForfait = PdoGsb::getLesFraisForfait($idVisiteur,$leMois);
		    $lesInfosFicheFrais = PdoGsb::getLesInfosFicheFrais($idVisiteur,$leMois);
		    $numAnnee = MyDate::extraireAnnee( $leMois);
		    $numMois = MyDate::extraireMois( $leMois);
		    $libEtat = $lesInfosFicheFrais['libEtat'];
		    $montantValide = $lesInfosFicheFrais['montantValide'];
            $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
            $dateModif =  $lesInfosFicheFrais['dateModif'];
            $dateModifFr = MyDate::getFormatFrançais($dateModif);
            $vue = view('listefrais')->with('lesMois', $lesMois)
                    ->with('leMois', $leMois)->with('numAnnee',$numAnnee)
                    ->with('numMois',$numMois)->with('libEtat',$libEtat)
                    ->with('montantValide',$montantValide)
                    ->with('nbJustificatifs',$nbJustificatifs)
                    ->with('dateModif',$dateModifFr)
                    ->with('lesFraisForfait',$lesFraisForfait)
                    ->with('visiteur',$visiteur);
            return $vue;
        }
        else{
            return view('connexion')->with('erreurs',null);
        }
    }

    function test(){
        if (session('visiteur')!= null){
            $visiteur = session('visiteur');
            $idVisiteur = $visiteur['id'];
            return view('test') ->with('visiteur', $visiteur);
        } else{
            return view('connexion') ->with('erreurs', null);
        }
    }

    function listePersonne(){
        if(session('visiteur')!=null){
            $liste=Pdogsb::Listepersonne();
            return view('listepersonne') ->with('liste', $liste);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
    }
     function suppruser(){
        if(session('visiteur')!=null){
            $req=Pdogsb::supprimerUser($id);

        }
     }
     function selectionneruser(Request $request){
        if(session('visiteur')!=null){

            $visiteur = session('visiteur');

            $id=$request['id'];
            //dd($id);
            $liste=Pdogsb::selectionneruser($id);
            return view('formmodif')->with('liste',$liste)
                    ->with('visiteur', $visiteur);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }

     function ajouterUtilisateur(Request $request){

     }

     function modifierUser(Request $request){
        if(session('visiteur')!=null){

            $visiteur = session('visiteur');
            $id=$request['id'];
            $login=$request['login'];
            $mdp=$request['mdp'];
            $nom=$request['nom'];
            $prenom=$request['prenom'];
            $adresse=$request['adresse'];
            $ville=$request['ville'];
            $cp=$request['cp'];
            $date=$request['date'];
            $req=Pdogsb::modifierUser($id,$nom,$prenom,$login,$adresse,$cp,$ville,$date,$mdp);
            $liste=Pdogsb::Listepersonne();
            return view('listepersonne') ->with('liste', $liste);
        }else{
            return view('connexion') ->with('erreurs', null);
        }
     }
}
