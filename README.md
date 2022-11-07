## Pueba con postman
El endpoint de la API es: http://localhost/web2/tpe2-insumosAgricolasCSR/api/

## Tabla Tipos de insumos
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

## Tabla Tipo de Insumos
El endpoint de la API es: http://localhost/web2/tpe2-insumosAgricolasCSR/api/tiposInsumos

## Endpoint Tipos de Insumos
Metodo: GET, endpoint api/tipoInsumos/ -> lista todos los tipos de insumos.

Metodo: GET, endpoint api/tipoInsumos?inicio=0&registros=5 -> lista los tipos de insumos desde la posicion cero (desde el inicio) y la cantidad de registros a mostrar son 5 (segun el ejemplo).

Metodo: DELETE, endpoint api/tipoInsumos/:ID -> elimina el registro con el ID ingresado.

Metodo: POST, endpoint api/tipoInsumos -> agrega un registro nuevo, pasando por el body los datos requeridos.
{
    "tipo_insumo" : "" //String
}.

Metodo: PUT, endpoint api/tipoInsumos/:ID -> actualiza un registro existente, pasando por el body los datos requeridos.
{
    "id_tipo_insumo" : , //int
    "tipo_insumo" : "" //String
}.
