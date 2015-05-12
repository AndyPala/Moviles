<?php
#Todos reciben una variable "action" y arreglo llave-valor llamado extrasJSON, por medio de post.
#

##----Create Account
##Envia
"action" => "createAccount"
extrasJSON{
	"username" => var,
	"password" => var,
	'email' => var
}
##Regresa
{
	"Valid" => [0,1],#1 si fue exitoso
	["Id" => var]#Solo si fue exitoso
}
#Falla si se utiliza un nombre de usuario o un correo registrado previamente
#Enviado:
#"action":"createAccount"
#"extrasJSON":{"username":"Yolo","email":"yolo@swag.com","password":"hashtag"}
#Recibido:
#[{"Valid":"1","Id":"3"}]

##----Login
##Envia
"action" => "login"
extrasJSON{
	"username" => var,
	"password" => var
}
##Regresa
{
	"Valid" => [0,1],#1 si fue exitoso
	"IdUser" => var,
	"Username" => var,
	"PasswordUser" => var,
	"EmailUser" => var
}
#Falla si la combinacion no coincide con ningun registro
#Enviado:
#"action":"login"
#"extrasJSON":{"username":"Yolo","password":"hashtag"}
#Recibido:
#[{"Valid":"1","IdUser":"3","Username":"Yolo","PasswordUser":"hashtag","EmailUser":"yolo@swag.com"}]

##------Buscar Usuario por ID
##Envia
"action" => "searchUser_Id"
extrasJSON{
	"idUser" => var
}
##Regresa
{
	"Valid" => [0,1],#1 si fue exitoso
	"IdUser" => var,
	"Username" => var,
	"EmailUser" => var
}
#Falla si no se encuentra el id
#Enviado:
#"action":"searchUser_Id"
#"extrasJSON":"{"idUser":"3"}"
#Recibido:
#{"Valid":"1","IdUser":"3","Username":"Yolo","EmailUser":"yolo@swag.com"}

##------Agregar lugar
##Envia
"action" => "addPlace"
extrasJSON{
	"idCategory" => var,
	"placeName" => var,
	"latitude" => var,#actual
	"longitude" => var,#actual
	"treshold" => var##La distancia en metros de lo alejado que debe de estar de un lugar existente para que el nuevo se cree
}
##Regresa
{
	"Valid" => [0,1],#1 si fue exitoso
	["Id" => var]#Solo si fue exitoso
}
#Falla si ya existe un lugar dentro del radio especificado
#Enviado:
#"action":"addPlace"
#"extrasJSON":"{"idCategory":"1","placeName":"Hola","latitude":"145","longitude":"135","treshold":"30"}"
#Recibido:
#{"Valid":"1","Id":"4"}

##------Buscar lugares cercanos
##Envia
"action" => "searchPlaces"
extrasJSON{
	"latitude" => var,#actual
	"longitude" => var,#actual
	"maxDst" => var#distancia maxima a la cual buscar
}
##Regresa
{
	"idPlace" => var,
	"idCategory" => var,
	"NamePlace" => var,
	"LatitudePlace" => var,
	"LongitudePlace" => var,
	"Distance" => var
}
#Regresa un arreglo vacio si no se encuantra ningun lugar dentro de la distacia especificada
#Puede regresar un arreglo de datos: {idPlace:1,etc},{idPlace:2,etc},{},{}
#Enviado:
#"action":"searchPlaces"
#"extrasJSON":"{"latitude":"145","longitude":"135","maxDst":"3000"}"
#Recibido:
#{"idPlace":"4","idCategory":"1","NamePlace":"Hola","LatitudePlace":"145.000000","LongitudePlace":"135.000000","Distance":"0"}

##------Buscar lugares cercanos filtrados por categoria
##Envia
"action" => "searchPlacesCat"
extrasJSON{
	"latitude" => var,#actual
	"longitude" => var,#actual
	"maxDst" => var,#distancia maxima a la cual buscar
	"idCategory" => var#categoria por la cual filtrar
}
##Regresa
{
	"idPlace" => var,
	"descCategory" => var,
	"NamePlace" => var,
	"LatitudePlace" => var,
	"LongitudePlace" => var,
	"Distance" => var
}
#Regresa un arreglo vacio si no se encuantra ningun lugar dentro de la distacia especificada
#Puede regresar un arreglo de datos: {idPlace:1,etc},{idPlace:2,etc},{},{}
#Enviado:
#"action":"searchPlaces"
#"extrasJSON":"{"latitude":"145","longitude":"135","maxDst":"3000","idCategory":"1"}"
#Recibido:
#{"idPlace":"4","descCategory":"Hotel","NamePlace":"Hola","LatitudePlace":"145.000000","LongitudePlace":"135.000000","Distance":"0"}

##------Agregar una reseña
##Envia
"action" => "addReview"
extrasJSON{
	"idUser" => var,
	"idPlace" => var,
	"desc" => var,
	"star" => var
}
##Regresa
{
	"Valid" => [0,1],#1 si fue exitoso
	"Deleted" => var,#deberia regresar 1 siempre, pero por si acaso
	"id" => var
}
#BORRA todos los comentarios hechos por el mismo usuario en el mismo lugar
#Enviado:
#"action":"addReview"
#"extrasJSON":"{"idUser":"1","idPlace":"2","desc":"Gotta test dis","star":"5"}"
#Recibido:
#{"Valid":"1","Deleted":"1","id":"9"}

##------Buscar reseñas por lugar
##Envia
"action" => "searchReviews_Place"
extrasJSON{
	"idPlace" => var
}
##Recibe
{
	"IdReview" => var,
	"IdUser" => var,
	"Username" => var,
	"ReviewDesc" => var,
	"ReviewStars" => var
}
#Enviado:
#"action":"searchReviews_Place"
#"extrasJSON":"{"idPlace":"2"}"
#Recibido:
#{"IdReview":"9","IdUser":"1","ReviewDesc":"Gotta test dis","ReviewStars":"5"}

##------Obtener promedio del lugar
##Envia
"action" => "getReviewAverage"
extrasJSON{
	"idPlace" => var
}
##Recibe
{
	"idPlace" => var,
	"Promedio" => var
}
#Enviado:
#"action":"getReviewAverage"
#"extrasJSON":"{"idPlace":"1"}"
#Recibido:
#{"idPlace":"1","Promedio":"3.3333"}
?>