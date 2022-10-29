'use strict';

const URL = 'http://localhost/web2/tpe2-insumosAgricolasCSR/api/';
const URL_INSUMOS = 'insumos';
const URL_TIPO_INSUMOS = 'tiposInsumos';

/**
 * Obtiene todos los insumos de la API.
 */
async function getAll(url_padre, url_hijo) {
    
    let response = await fetch(url_padre + url_hijo);
    let result = await response.json();

    console.log(result);
}

getAll(URL, URL_INSUMOS);


