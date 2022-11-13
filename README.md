## Pueba con postman
El endpoint de la API es: http://localhost/web2/tpe2-insumosAgricolasCSR/api/

## Tabla Insumos
El endpoint de la API es: http://localhost/web2/tpe2-insumosAgricolasCSR/api/insumos
## Endpoint Insumos
Metodo: GET, endpoint api/insumos/ -> lista todos los insumos.

Metodo: GET, endpoint api/insumos?start=1&records=5 -> lista los insumos desde la posicion cero (desde el inicio) y la cantidad de registros a mostrar son 5 (segun el ejemplo).

Metodo: GET, endpoint api/insumos?supplie=Ferti -> lista los insumos los cuales el atributo insumo, contenga en cualquier parte, la palabra "Ferti" (segun el ejemplo).

Metodo: DELETE, endpoint api/insumos/:ID -> elimina el registro con el ID ingresado.

Metodo: POST, endpoint api/insumos -> agrega un registro nuevo, pasando por el body los datos requeridos.
{
    "insumo" : "", //String
    "unidad_medida" : "", //String
    "id_tipo_insumo" : //int
}.

Metodo: PUT, endpoint api/insumos/:ID -> actualiza un registro existente, pasando por el body los datos requeridos.
{
    "id_insumo" : , //int
    "insumo" : "", //String
    "unidad_medida" : "", //String
    "id_tipo_insumo" : //int
}.

## Gestion de Token
El endpoint de la API es: http://localhost/web2/tpe2-insumosAgricolasCSR/api/auth/token
## Endpoint Auth/Token

Metodo: GET, endpoint api/auth/token -> enviando por parametros de Authorization, del tipo Basic Auth, Username y Password, se puede obtener el token de seguridad, para realizar altas, modificaciones y eliminaciones de registros.

