<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzRequest;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public $client;
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://pokeapi.co/api/v2/']);
    }
    
    /**
     * Este endponit retorna unicamente el nombre los 100 primeros pokemones
     * según el API
     */
    public function getPokemons(){
        $arrData = array();
        $response = json_decode($this->client->request('GET', 'pokemon/?limit=100')->getBody()->getContents(), true)['results'];
        foreach ($response as $key => $item) {
            array_push($arrData, [
                'name' => $item['name'],
            ]);
        }
        return $arrData;
    }
    
    /**
     * Este endponit retorna datos más completos sobre cada pokemos
     * el tiempo de respuesta es más demorado por la cantidad de interaciones y consultas que realiza
     * al API (Se que se puede hacer mejor para que sea más rapido)
     */
    public function getPokemonsSlow(){
        $arrDataSlow = array();
        $response = json_decode($this->client->request('GET', 'pokemon/?limit=100')->getBody()->getContents(), true)['results'];
        foreach ($response as $key => $item) {
            $infoPokemon = $this->getInfoPokemon($item['url']);
            array_push($arrDataSlow, [
                'name' => $item['name'],
                'info' => $infoPokemon
            ]);
        }
        return $arrDataSlow;
    }

    /**
     * Endpoint para realizar la busqueda de un pokemon según el NOMBRE o ID
     * @param Request $request
     * NOTA: Los enpoinds que he mirado unicamente acepta los parametros anteriormente mencionados
     */
    public function searchPokemon(Request $request){
        $idOrName = $request->input('name') ?? $request->input('id');
        $response = json_decode($this->client->request('GET', 'pokemon/'.$idOrName)->getBody()->getContents(), true);
        return response()->json($response);
    }

    public function sendAnyData(){
        $body = [
            'id' => 'richardmestra3112@gmail.com',
            'anyDataFromApi' => json_decode($this->client->request('GET', 'pokemon/2')->getBody()->getContents(), true)
        ];
        $response = $this->client->post('https://en4do2rbb9qvdcn.m.pipedream.net', $body);
        return $response;
    }

    /**
     * Submetodo para obtener la información detallada de cada poquemon según el endpoint
     * @param Url $urlInfo
     */
    public function getInfoPokemon($urlInfo){
        $dataInfo = array();
        $responseInfoPokemon = json_decode($this->client->request('GET', $urlInfo)->getBody()->getContents(), true);
        array_push($dataInfo, [
            "url_img"         => $responseInfoPokemon['sprites']['other']['official-artwork']['front_default'],
            "num_abilities"   => count($responseInfoPokemon['abilities']),
            "base_experience" => $responseInfoPokemon['base_experience'],
            "height"          => $responseInfoPokemon['height'],
            "weight"          => $responseInfoPokemon['weight'],
        ]);
        return $dataInfo;
    }
}